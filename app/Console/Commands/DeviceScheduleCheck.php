<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DeviceSchedue;
use App\Http\Controllers\DeviceController;
use Carbon\Carbon;
use App\Http\Controllers\Api\V1\Admin\TuyaController;

class DeviceScheduleCheck extends Command
{
    protected $signature = 'devices:check';
    protected $description = 'Check device schedules and turn them on/off based on UTC time';



    public function handle()
    {
        $nowUTC = Carbon::now('UTC');
        

        // Fetch all active device schedules
        $schedules = DeviceSchedue::where('status', 1)->get();

        foreach ($schedules as $schedule) {
             

            # convert UTC to device local time
            $currentDay = strtolower($nowUTC->format('l')); // e.g., "monday"
            $currentTime = $nowUTC->format('H:i');  
           
            # match exact day or 'everyday'
            if ($schedule->day != 'everyday' && $schedule->day != $currentDay) {
                continue;
            }

            # parse start and end times (assumed to be stored as 'H:i:s')
            $onTime = Carbon::parse($schedule->on_time)->format('H:i');
            $offTime = Carbon::parse($schedule->off_time)->format('H:i');
            
            $this->info('UTC.'.'>>>>>>>>'.@$currentTime);
            $this->info('onTime.'.'>>>>>>>>'.@$onTime);
            
            
            $action = null;
            if ($currentTime === $onTime) {
                $action = 'on';
            } elseif ($currentTime === $offTime) {
                $action = 'off';
            }

            //echo '>>>>>>>>'.$action;

            if (@$action) {
                $sendCommand = new TuyaController();
                $sendCommand->deviceControlFromCron($schedule, true, $action);
            }
        }

        $this->info('Device schedule check completed.'.'>>>>>>>>'.@$action);
    }

 

    public function handle_old()
    {
        $nowUTC = Carbon::now('UTC');
        $today = $nowUTC->toDateString();

        $devices = DeviceSchedue::where('status', 1)
            ->whereDate('schedule_date', $today)
            ->get();

        foreach ($devices as $device) {

             
            $deviceTimeOnUTC = Carbon::parse($device->on_time, 'UTC');
            $deviceTimeOffUTC = Carbon::parse($device->off_time, 'UTC');

            $onTime = 0;
            if ($nowUTC->format('H:i') === $deviceTimeOnUTC->format('H:i')) {
                $onTime = 1;
                $type = "on";
            }

            if ($nowUTC->format('H:i') === $deviceTimeOffUTC->format('H:i')) {
                $onTime = 1;
                $type = "off";
            }

            

            if($onTime == 1){
                $sendCommand = new TuyaController();
                $data = $sendCommand->deviceControlFromCron($device,true,$type);
            }
        }

        $this->info('Device schedule check completed.');
    }
}
