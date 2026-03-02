<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{MerchantAddress, Merchant, User};

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
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'phone'  => 'required',
            'school' => 'required',
            'age'    => 'required|integer|min:1',
            'image'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // add parent email rule if age < 14
        if ($request->input('age') && $request->input('age') < 14) {
            $rules['parent_email'] = 'required|email';
        }

        $validated = $request->validate($rules);

        // store image
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads'), $imageName);

        $user = User::create([
            'full_name'     => $validated['name'],
            'email'         => $validated['email'],
            'phone_number'  => $validated['phone'],
            'school'        => $validated['school'],
            'age'           => $validated['age'],
            'parent_email'  => $validated['age'] < 14 ? $validated['parent_email'] : null,
            'image'         => 'uploads/' . $imageName
        ]);

        $user->roles()->sync([2]);

        return redirect()->back()->with('success', 'Student Registered Successfully');
    }
}
