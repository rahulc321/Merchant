<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id','address','city','state','pincode'
    ];

}
