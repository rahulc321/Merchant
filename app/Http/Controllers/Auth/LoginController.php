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
        
        //$ip = "2404:7c80:64:76dd:2e9d:ba70:6893:63a9";
        $ip = $request->ip();
        
        
        $ip = $request->ip();
        if ($ip === "127.0.0.1" || $ip === "::1") {
            $ip = "8.8.8.8";
        }
        
        $url = "https://ipinfo.io/{$ip}/json";
        $response = @file_get_contents($url);
        
        $timezone = 'Australia/Sydney';
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if (!empty($data['timezone'])) {
                $timezone = $data['timezone'] ;
            }
        }
        
        // dd($timezone);

        // $url = "http://www.geoplugin.net/php.gp?ip={$ip}";
        // $response = file_get_contents($url);
        // $geoData = unserialize($response);

        //$geoplugin_timezone = $geoData['geoplugin_timezone'] ?? 'Australia/Sydney';

        \Session::put('timeZone',$timezone);

        //dd($geoData['geoplugin_timezone']);
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {

            if (Auth::user()->roles->contains('title', 'end_user')) {
                session()->flash('error', 'Access denied: Your account does not have permission to login this portal.');
                Auth::logout();
                return back();
            }

            return redirect('admin');
        }else{
             
            session()->flash('error', 'Please Enter Valid Login Details!');
            return back();
        }

    }
}
