<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Leads;
use App\Card;
use App\{User, Order, Merchant};
use App\Device;
use DB;
use Illuminate\Support\Facades\Schema;

class HomeController
{
    public function index()
    {
        $user = Auth::user();
    
        // check admin
        if ($user->roles->contains('title', 'Admin')) {
    
            $this->data['totalUsers'] = User::count();
            $this->data['totalOrders'] = Order::count();
            $this->data['totalMerchants'] = User::whereHas('roles', function ($query) {
                $query->where('title', 'merchant');
            })->count();
    
        } else {
    
            // only logged-in user's orders
            $this->data['totalOrders'] = Order::where('user_id', $user->id)->count();

            if (Schema::hasTable('user_referrals')) {
                User::ensureReferralCode($user);

                $referral = DB::table('user_referrals')->where('user_id', $user->id)->first();
                $this->data['referralCode'] = $referral->referral_code ?? null;
                $this->data['referralPoints'] = $referral->referral_points ?? 0;
                $this->data['referralLink'] = $this->data['referralCode']
                    ? route('register', ['ref' => $this->data['referralCode']])
                    : null;
            }
        }
    
        return view('home', $this->data);
    }
}
