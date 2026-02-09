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
}
