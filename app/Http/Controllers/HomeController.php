<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{MerchantAddress, Merchant, User, Coupon, Order};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'phone' => 'required',
    'password' => 'required',
    'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ];

    if($request->role == 'student'){

    $rules['school'] = 'required';
    $rules['age'] = 'required|integer|min:1';

    if($request->age < 14){
    $rules['parent_email'] = 'required|email';
    }

    }

    if($request->role == 'teacher'){
    $rules['department'] = 'required';
    $rules['subject'] = 'required';
    }

    if($request->role == 'youth'){
    $rules['organization'] = 'required';
    }

    $validated = $request->validate($rules);


    /* image upload */

    File::ensureDirectoryExists(public_path('uploads'), 0755, true);

    $image = $request->file('image');
    $imageName = time().'_'.preg_replace('/[^A-Za-z0-9._-]/', '_', $image->getClientOriginalName());
    $image->move(public_path('uploads'), $imageName);


    /* create user */

    $user = User::create([

    'full_name'=>$request->name,
    'email'=>$request->email,
    'phone_number'=>$request->phone,
    'password'=>Hash::make($request->password),
    'school'=>$request->school ?? null,
    'age'=>$request->age ?? null,
    'department'=>$request->department ?? null,
    'subject'=>$request->subject ?? null,
    'organization'=>$request->organization ?? null,
    'parent_email'=>$request->parent_email ?? null,
    'image'=>'uploads/'.$imageName

    ]);


    /* role assign */

    if($request->role == 'student'){
    $user->roles()->sync([2]);
    }

    if($request->role == 'teacher'){
    $user->roles()->sync([5]);
    }

    if($request->role == 'youth'){
    $user->roles()->sync([6]);
    }


    Auth::login($user);

    return redirect()->back()->with('success','Registration Successful');

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
