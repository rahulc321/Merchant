<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'currency',
        'pesapal_consumer_key',
        'pesapal_consumer_secret',
        'pesapal_base_url',
        'pesapal_ipn_url',
        'selcom_api_key',
        'selcom_api_secret',
        'selcom_base_url',
        'selcom_vendor',
    ];

    public static function current()
    {
        return static::firstOrCreate([], [
            'gateway' => 'pesapal',
            'currency' => 'TZS',
            'pesapal_base_url' => 'https://cybqa.pesapal.com/pesapalv3/api/',
            'pesapal_ipn_url' => url('/subscription-payment/ipn'),
            'selcom_base_url' => 'https://apigw.selcommobile.com',
        ]);
    }
}
