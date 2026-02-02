<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devicelogs extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $casts = [
    //     'event_time' => 'datetime', // Ensure it is cast as a datetime
    // ];

    // public function getEventTimeAttribute($value)
    // {   
    //     $timestampSec = intval($value / 1000);
    //     $dateTime = Carbon::createFromTimestamp($timestampSec, 'UTC')->setTimezone('Asia/Kolkata');

    //     return $dateTime->format('Y-m-d H:i:s');
    // }
}
