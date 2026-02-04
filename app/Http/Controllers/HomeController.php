<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{MerchantAddress, Merchant};

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
        $this->data['restaurants'] = Merchant::with('addresses')->get();
        return view('user_register',$this->data);
    }
}
