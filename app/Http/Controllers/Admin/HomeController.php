<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Leads;
use App\Card;
use App\{User, Order, Merchant};
use App\Device;
use DB;

class HomeController
{
    public function index()
    {
        $user = Auth::user();
    
        // check admin
        if ($user->roles->contains('title', 'Admin')) {
    
            $this->data['totalUsers'] = User::count();
            $this->data['totalOrders'] = Order::count();
            $this->data['totalMerchants'] = Merchant::count();
    
        } else {
    
            // only logged-in user's orders
            $this->data['totalOrders'] = Order::where('user_id', $user->id)->count();
        }
    
        return view('home', $this->data);
    }
}