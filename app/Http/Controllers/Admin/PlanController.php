<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PaymentSetting;
use App\Plan;
use App\PlanPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlanController extends Controller
{
    public function index()
    {
        $this->abortIfNotAdmin();

        $this->data['plans'] = Plan::withCount('purchases')->orderBy('id', 'DESC')->get();

        return view('admin.plans.index', $this->data);
    }

    public function create()
    {
        $this->abortIfNotAdmin();

        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $this->abortIfNotAdmin();

        Plan::create($this->validatedData($request));

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function show(Plan $plan)
    {
        $this->abortIfNotAdmin();

        return view('admin.plans.edit', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return $this->show($plan);
    }

    public function update(Request $request, Plan $plan)
    {
        $this->abortIfNotAdmin();

        $plan->update($this->validatedData($request));

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $this->abortIfNotAdmin();

        $plan->delete();

        return redirect()->route('admin.plans.index')->with('warning', 'Plan deleted successfully.');
    }

    public function browse()
    {
        $this->data['plans'] = Plan::where('status', 1)->orderBy('price')->get();
        $this->data['activePurchase'] = PlanPurchase::with('plan')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('expires_at', '>=', now())
            ->latest('expires_at')
            ->first();
        $this->data['purchases'] = PlanPurchase::with('plan')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('admin.plans.browse', $this->data);
    }

    public function subscriptions(Request $request)
    {
        $this->abortIfNotAdmin();

        $query = PlanPurchase::with(['user.roles', 'plan'])->latest();

        $query->when($request->user, function ($q) use ($request) {
            $q->whereHas('user', function ($user) use ($request) {
                $user->where('full_name', 'like', '%' . $request->user . '%')
                    ->orWhere('email', 'like', '%' . $request->user . '%')
                    ->orWhere('phone_number', 'like', '%' . $request->user . '%');
            });
        });

        $query->when($request->plan_id, function ($q) use ($request) {
            $q->where('plan_id', $request->plan_id);
        });

        $query->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $this->data['subscriptions'] = $query->paginate(20)->withQueryString();
        $this->data['plans'] = Plan::orderBy('title')->get();

        return view('admin.plans.subscriptions', $this->data);
    }

    public function purchase(Plan $plan)
    {
        if (!$plan->status) {
            return back()->with('error', 'This plan is currently inactive.');
        }

        $purchase = PlanPurchase::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'price' => $plan->price,
            'days' => $plan->days,
            'usage_limit' => $plan->usage_limit,
            'used_count' => 0,
            'status' => 'pending',
            'payment_reference' => 'SUB-' . time() . '-' . auth()->id(),
        ]);

        return redirect()->route('admin.plans.payment', $purchase->id);
    }

    public function payment(PlanPurchase $purchase)
    {
        abort_if($purchase->user_id !== auth()->id() && !auth()->user()->roles->contains('title', 'Admin'), 403);

        $purchase->load('plan', 'user');
        $setting = PaymentSetting::current();

        return view('admin.plans.payment', compact('purchase', 'setting'));
    }

    public function payNow(Request $request, PlanPurchase $purchase)
    {
        abort_if($purchase->user_id !== auth()->id(), 403);
        $purchase->load('user', 'plan');

        $data = $request->validate([
            'gateway' => 'required|in:pesapal,selcom',
        ]);

        if ($purchase->status === 'active') {
            return redirect()->route('admin.plans.browse')->with('success', 'Subscription already active.');
        }

        $purchase->update([
            'payment_gateway' => $data['gateway'],
            'status' => 'pending',
            'payment_tracking_id' => null,
            'payment_redirect_url' => null,
            'gateway_response' => null,
        ]);

        if (app()->environment('local')) {
            return redirect()->route('admin.plans.payment', $purchase->id)
                ->with('success', 'Local mode: ' . ucfirst($data['gateway']) . ' selected without external payment redirect.');
        }

        $setting = PaymentSetting::current();

        $response = $data['gateway'] === 'selcom'
            ? $this->selcomPaymentFlow($purchase, $setting)
            : $this->pesapalPaymentFlow($purchase, $setting);

        if (!empty($response['redirect_url'])) {
            $purchase->update([
                'payment_tracking_id' => $response['order_tracking_id'] ?? null,
                'payment_redirect_url' => $response['redirect_url'],
                'gateway_response' => json_encode($response['response'] ?? $response),
            ]);

            return redirect()->away($response['redirect_url']);
        }

        $purchase->update([
            'status' => 'failed',
            'gateway_response' => json_encode($response),
        ]);

        return back()->with('error', $response['error'] ?? 'Payment initiation failed.');
    }

    public function localConfirm(PlanPurchase $purchase)
    {
        abort_if(!app()->environment('local'), 403);
        abort_if($purchase->user_id !== auth()->id(), 403);

        $this->expireOldSubscriptions($purchase);
        $purchase->activate();

        return redirect()->route('admin.plans.browse')->with('success', 'Local payment confirmed. Subscription activated.');
    }

    public function paymentCallback(PlanPurchase $purchase, Request $request)
    {
        $this->expireOldSubscriptions($purchase);
        $purchase->update([
            'payment_tracking_id' => $request->OrderTrackingId ?? $request->order_tracking_id ?? $purchase->payment_tracking_id,
            'gateway_response' => json_encode($request->all()),
        ]);
        $purchase->activate();

        return redirect()->route('admin.plans.browse')->with('success', 'Payment completed. Subscription activated.');
    }

    public function paymentIpn(Request $request)
    {
        return response()->json(['status' => 'received']);
    }

    protected function validatedData(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'benefits' => 'required|string',
            'price' => 'required|numeric|min:0',
            'days' => 'required|integer|min:1',
            'usage_limit' => 'required|integer|min:1',
            'status' => 'required|in:0,1',
        ]);

        $data['benefits'] = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $data['benefits']))));

        return $data;
    }

    protected function abortIfNotAdmin()
    {
        abort_if(!auth()->user()->roles->contains('title', 'Admin'), 403);
    }

    protected function expireOldSubscriptions(PlanPurchase $purchase)
    {
        PlanPurchase::where('user_id', $purchase->user_id)
            ->where('id', '!=', $purchase->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);
    }

    protected function pesapalPaymentFlow(PlanPurchase $purchase, PaymentSetting $setting)
    {
        if (!$setting->pesapal_consumer_key || !$setting->pesapal_consumer_secret || !$setting->pesapal_base_url) {
            return ['error' => 'Pesapal payment settings are missing.'];
        }

        $baseUrl = rtrim($setting->pesapal_base_url, '/') . '/';

        $authResponse = Http::asJson()->post($baseUrl . 'Auth/RequestToken', [
            'consumer_key' => $setting->pesapal_consumer_key,
            'consumer_secret' => $setting->pesapal_consumer_secret,
        ]);

        $authData = $authResponse->json();

        if (empty($authData['token'])) {
            return ['error' => 'Pesapal authentication failed.', 'response' => $authData ?: $authResponse->body()];
        }

        $ipnUrl = $setting->pesapal_ipn_url ?: url('/subscription-payment/ipn');
        $ipnResponse = Http::withToken($authData['token'])->asJson()->post($baseUrl . 'URLSetup/RegisterIPN', [
            'url' => $ipnUrl,
            'ipn_notification_type' => 'POST',
        ]);

        $ipnData = $ipnResponse->json();

        if (empty($ipnData['ipn_id'])) {
            return ['error' => 'Pesapal IPN registration failed.', 'response' => $ipnData ?: $ipnResponse->body()];
        }

        $nameParts = preg_split('/\s+/', trim($purchase->user->full_name ?? 'Customer'), 2);
        $firstName = $nameParts[0] ?? 'Customer';
        $lastName = $nameParts[1] ?? '';

        $orderResponse = Http::withToken($authData['token'])->asJson()->post($baseUrl . 'Transactions/SubmitOrderRequest', [
            'id' => $purchase->payment_reference,
            'currency' => $setting->currency ?: 'TZS',
            'amount' => number_format($purchase->price, 2, '.', ''),
            'description' => 'Subscription Payment #' . $purchase->id,
            'callback_url' => route('subscription.payment.callback', $purchase->id),
            'notification_id' => $ipnData['ipn_id'],
            'billing_address' => [
                'email_address' => $purchase->user->email,
                'phone_number' => $purchase->user->phone_number,
                'country_code' => 'TZ',
                'first_name' => $firstName,
                'middle_name' => '',
                'last_name' => $lastName,
                'line_1' => '',
                'line_2' => '',
                'city' => '',
                'state' => '',
                'postal_code' => '',
                'zip_code' => '',
            ],
        ]);

        $orderData = $orderResponse->json();

        if (!empty($orderData['redirect_url'])) {
            return [
                'status' => 'success',
                'redirect_url' => $orderData['redirect_url'],
                'order_tracking_id' => $orderData['order_tracking_id'] ?? null,
                'response' => $orderData,
            ];
        }

        return [
            'error' => data_get($orderData, 'error.message', 'Pesapal order submission failed.'),
            'response' => $orderData ?: $orderResponse->body(),
        ];
    }

    protected function selcomPaymentFlow(PlanPurchase $purchase, PaymentSetting $setting)
    {
        if (!$setting->selcom_api_key || !$setting->selcom_api_secret || !$setting->selcom_base_url || !$setting->selcom_vendor) {
            return ['error' => 'Selcom payment settings are missing.'];
        }

        $baseUrl = rtrim($setting->selcom_base_url, '/');
        $path = '/v1/checkout/create-order-minimal';
        $callbackUrl = route('subscription.payment.callback', $purchase->id);
        $phone = preg_replace('/\D+/', '', (string) $purchase->user->phone_number);

        $payload = [
            'vendor' => $setting->selcom_vendor,
            'order_id' => $purchase->payment_reference,
            'buyer_email' => $purchase->user->email ?: 'customer@example.com',
            'buyer_name' => $purchase->user->full_name ?: 'Customer',
            'buyer_phone' => $phone ?: '255000000000',
            'amount' => number_format($purchase->price, 2, '.', ''),
            'currency' => $setting->currency ?: 'TZS',
            'buyer_remarks' => 'Subscription Payment #' . $purchase->id,
            'merchant_remarks' => 'Subscription Payment #' . $purchase->id,
            'no_of_items' => 1,
            'redirect_url' => base64_encode($callbackUrl),
        ];

        $response = Http::withHeaders($this->selcomHeaders($payload, $setting))
            ->asJson()
            ->post($baseUrl . $path, $payload);

        $data = $response->json();
        $encodedUrl = $data['data'][0]['payment_gateway_url'] ?? null;
        $redirectUrl = $encodedUrl ? base64_decode($encodedUrl) : null;

        if ($redirectUrl) {
            return [
                'status' => 'success',
                'redirect_url' => $redirectUrl,
                'order_tracking_id' => $purchase->payment_reference,
                'response' => $data,
            ];
        }

        return [
            'error' => $data['message'] ?? 'Selcom order submission failed.',
            'response' => $data ?: $response->body(),
        ];
    }

    protected function selcomHeaders(array $payload, PaymentSetting $setting)
    {
        $timestamp = now()->toIso8601String();
        $signedFields = implode(',', array_keys($payload));
        $signedData = 'timestamp=' . $timestamp;

        foreach ($payload as $key => $value) {
            $signedData .= '&' . $key . '=' . $value;
        }

        $digest = base64_encode(hash_hmac('sha256', $signedData, $setting->selcom_api_secret, true));
        $authorization = 'SELCOM ' . base64_encode($setting->selcom_api_key);

        return [
            'Accept' => 'application/json',
            'Authorization' => $authorization,
            'Digest-Method' => 'HS256',
            'Digest' => $digest,
            'Timestamp' => $timestamp,
            'Signed-Fields' => $signedFields,
        ];
    }
}
