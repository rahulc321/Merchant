<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{MerchantAddress, Merchant, User, Coupon, Order, Role, PlanPurchase};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Hash;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userRegister()
    {   
        //$this->data['restaurants'] = Merchant::with('addresses')->get();
        $this->data['restaurants'] = User::with('addresses')->whereHas('roles', function ($query) {
            $query->where('title', 'merchant');
        })->get();
        return view('user_register',$this->data);
    }

    public function userLogin()
    {   
        return view('user_login');
    }

    public function userDashboard()
    {
        $user = Auth::user();

        $activeSubscription = PlanPurchase::with('plan')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->latest('expires_at')
            ->first();

        $latestSubscription = PlanPurchase::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return view('user_dashboard', compact('user', 'activeSubscription', 'latestSubscription'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'subject' => 'required|max:200',
            'message' => 'required|min:10',
        ]);

        Mail::send([], [], function ($message) use ($request) {

            $message->to('rahulk@yopmail.com') // 👈 change admin email
                ->replyTo($request->email, $request->name)
                ->subject('Contact Message: '.$request->subject)
                ->html("
                    <h2>New Contact Message</h2>
                    <p><strong>Name:</strong> {$request->name}</p>
                    <p><strong>Email:</strong> {$request->email}</p>
                    <p><strong>Subject:</strong> {$request->subject}</p>
                    <p><strong>Message:</strong><br>{$request->message}</p>
                ");
        });

        return back()->with('success','✅ Your message has been sent successfully!');
    }

    public function index(){
        return view('website');
    }

    public function about(){
        return view('about');
    }

    public function spiner(){
        return view('spinner');
    }

    public function studentRegister(Request $request)
    {

    $rules = [
    'role' => 'required|in:normal,student,teacher,youth',
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'phone' => 'required',
    'password' => 'required',
    'dob' => 'required|date|before:today',
    'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ];

    if($request->role == 'student'){

    $rules['institution_name'] = 'required|string|max:255';
    $rules['institution_logo'] = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
    $age = $request->filled('dob') ? Carbon::parse($request->dob)->age : null;

    if($age !== null && $age < 14){
    $rules['parent_email'] = 'required|email';
    }

    }

    if($request->role == 'teacher'){
    $rules['institution_name'] = 'required|string|max:255';
    $rules['institution_logo'] = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
    $rules['department'] = 'required';
    $rules['subject'] = 'required';
    }

    if($request->role == 'youth'){
    $rules['organization'] = 'required';
    }

    $validated = $request->validate($rules);
    $age = Carbon::parse($request->dob)->age;


    /* image upload */

    File::ensureDirectoryExists(public_path('uploads'), 0755, true);

    $image = $request->file('image');
    $imageName = time().'_'.preg_replace('/[^A-Za-z0-9._-]/', '_', $image->getClientOriginalName());
    $image->move(public_path('uploads'), $imageName);

    $institutionLogoPath = null;

    if ($request->hasFile('institution_logo')) {
    File::ensureDirectoryExists(public_path('institution_logos'), 0755, true);

    $institutionLogo = $request->file('institution_logo');
    $institutionLogoName = time().'_institution_'.preg_replace('/[^A-Za-z0-9._-]/', '_', $institutionLogo->getClientOriginalName());
    $institutionLogo->move(public_path('institution_logos'), $institutionLogoName);
    $institutionLogoPath = 'institution_logos/'.$institutionLogoName;
    }


    /* create user */

    $user = User::create([

    'full_name'=>$request->name,
    'email'=>$request->email,
    'phone_number'=>$request->phone,
    'password'=>Hash::make($request->password),
    'school'=>$request->institution_name ?? $request->school ?? null,
    'institution_name'=>$request->institution_name ?? null,
    'institution_logo'=>$institutionLogoPath,
    'age'=>$age,
    'dob'=>$request->dob,
    'department'=>$request->department ?? null,
    'subject'=>$request->subject ?? null,
    'organization'=>$request->organization ?? null,
    'parent_email'=>$request->parent_email ?? null,
    'type'=>$request->role,
    'image'=>'uploads/'.$imageName

    ]);


    /* role assign */

    $roleMap = [
    'normal' => [
    'titles' => ['Normal', 'normal', 'end_user'],
    'fallback' => 2,
    ],
    'student' => [
    'titles' => ['Student', 'student'],
    'fallback' => 2,
    ],
    'teacher' => [
    'titles' => ['Teacher', 'teacher'],
    'fallback' => 5,
    ],
    'youth' => [
    'titles' => ['Youth', 'youth'],
    'fallback' => 6,
    ],
    ];

    $roleConfig = $roleMap[$request->role];
    $roleId = Role::whereIn('title', $roleConfig['titles'])->value('id') ?: $roleConfig['fallback'];

    $user->roles()->sync([$roleId]);


    Auth::login($user);

    return redirect()->route('user.dashboard')->with('success','Registration Successful. Please choose a subscription plan.');

    }

    public function details($id){

        $this->data['details'] = User::find($id);
        return view('details',$this->data);

    }

    public function unlockCoupon($merchantId, Request $request)
    {
        if (!auth()->check()) {

            # store intended url
            session(['url.intended' => url()->previous()]);
            return redirect()->route('login');
        }

        # validation
        $request->validate([
            'restaurant_id' => 'required|exists:users,id',
            'cashier_code' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {

                    $exists = User::where('id', $request->restaurant_id)
                        ->where('code', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('Invalid cashier verification code for selected vendor.');
                    }
                }
            ],
            'amount' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {

                    $merchant = User::find($request->restaurant_id);

                    if (!$merchant) {
                        $fail('Please select a valid restaurant.');
                        return;
                    }

                    # minimum amount validation
                    if ((float) $value < (float) $merchant->amount) {
                        $fail('Minimum amount is ' . number_format($merchant->amount) . '.');
                    }
                }
            ],
        ]);

        $user = auth()->user();

        $merchant = User::find($merchantId);

        # first 3 characters of merchant name
        $prefix = strtoupper(substr($merchant->full_name, 0, 3));

        # generate 4 digit number
        $number = rand(1000, 9999);

        # final coupon code
        $couponCode = $prefix . $number;

        Coupon::create([
            'user_id' => $user->id,
            'merchant_id' => $merchantId,
            'coupon_code' => $couponCode,
            'discount' => $merchant->discount,
        ]);

        Order::create([
            'user_id' => $user->id,
            'restaurant_id' => $merchantId,
            'amount' => $request->amount,
            'address' => 'test',
            'address_id' => $merchantId,
            'cashier_code' => $request->code ?? '000000',
            'status' => 1,
        ]);

        return redirect()->back()->with([
            'success' => 'Congratulations! Your coupon has been unlocked.',
            'coupon_code' => $couponCode
        ]);
    }
}
