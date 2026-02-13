<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'address',
        'city',
        'state',
        'pincode'
    ];

    public function spinners()
    {
        return $this->belongsToMany(Spinner::class,'address_spinner')
                    ->withTimestamps();
    }
}
