<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'amount',
        'status',
        'code'
    ];

    public function addresses()
    {
        return $this->hasMany(MerchantAddress::class);
    }
}
