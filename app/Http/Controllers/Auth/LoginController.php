<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Hash;
use Session;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function customLogin(Request $request)
    {   
         
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // check if user exists but inactive
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status == 0) {
            return back()->with(
                'error',
                'Your account is not activated yet. Please wait for admin approval.'
            );
        }
        
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {

            // if (Auth::user()->roles->contains('title', 'end_user')) {
            //     session()->flash('error', 'Access denied: Your account does not have permission to login this portal.');
            //     Auth::logout();
            //     return back();
            // }

            return redirect()->intended('admin');
        }else{
             
            session()->flash('error', 'Please Enter Valid Login Details!');
            return back();
        }

    }

    public function customLoginUser(Request $request)
    {   
         
        $request->validate([
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        // check if user exists but inactive
        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user && $user->status == 0) {
            return back()->with(
                'error',
                'Your account is not activated yet. Please wait for admin approval.'
            );
        }
        
        $credentials = $request->only('phone_number', 'password');
        
        if (Auth::attempt($credentials)) {

            // if (Auth::user()->roles->contains('title', 'end_user')) {
            //     session()->flash('error', 'Access denied: Your account does not have permission to login this portal.');
            //     Auth::logout();
            //     return back();
            // }

            return redirect('admin');
        }else{
             
            session()->flash('error', 'Please Enter Valid Login Details!');
            return back();
        }

    }
}