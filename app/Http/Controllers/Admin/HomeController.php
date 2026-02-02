<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Leads;
use App\Card;
use App\User;
use App\Device;
use DB;

class HomeController
{
    public function index()
    {   
        //dd(Auth::Id());
        if (Auth::user()->roles->contains('title', 'Installer')) {
            $this->data['device'] = Device::where('installer_id',Auth::Id())->get();
            $this->data['topDevices'] = Device::where('installer_id',Auth::Id())->latest()->take(10)->get();
            $this->data['I_N'] = User::where('id',Auth::Id())->latest()->take(10)->get();


            $devicesByMonth = Device::select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw("COUNT(*) as count")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))
            ->orderByRaw("MIN(created_at)")
            ->where('installer_id',Auth::Id())
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        }else{
            $this->data['device'] = Device::get();
            $this->data['topDevices'] = Device::latest()->take(10)->get();
            $this->data['I_N'] = User::whereHas('roles', function ($query) {
                $query->where('title', 'Installer');
            })->latest()->take(10)->get();

            $devicesByMonth = Device::select(
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw("COUNT(*) as count")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))
            ->orderByRaw("MIN(created_at)")
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        }

        // define all 12 months
        $allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        // fill missing months with 0
        $monthlyDevices = [];
        foreach ($allMonths as $month) {
            $monthlyDevices[$month] = $devicesByMonth[$month] ?? 0;
        }
        
        $this->data['monthlyDevices'] = $monthlyDevices;
     
       // echo '<pre>';print_r($this->data['monthlyDevices']);die;
         
        return view('home',$this->data);
    }
}
