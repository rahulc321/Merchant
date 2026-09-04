<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function edit()
    {
        $this->abortIfNotAdmin();

        $setting = PaymentSetting::current();

        return view('admin.settings.payment', compact('setting'));
    }

    public function update(Request $request)
    {
        $this->abortIfNotAdmin();

        $data = $request->validate([
            'gateway' => 'required|in:pesapal,selcom',
            'currency' => 'required|string|max:10',
            'pesapal_consumer_key' => 'nullable|string|max:255',
            'pesapal_consumer_secret' => 'nullable|string|max:255',
            'pesapal_base_url' => 'nullable|url|max:255',
            'pesapal_ipn_url' => 'nullable|url|max:255',
            'selcom_api_key' => 'nullable|string|max:255',
            'selcom_api_secret' => 'nullable|string|max:255',
            'selcom_base_url' => 'nullable|url|max:255',
            'selcom_vendor' => 'nullable|string|max:255',
        ]);

        PaymentSetting::current()->update($data);

        return back()->with('success', 'Payment settings updated successfully.');
    }

    protected function abortIfNotAdmin()
    {
        abort_if(!auth()->user()->roles->contains('title', 'Admin'), 403);
    }
}
