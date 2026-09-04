<?php

use App\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingsTableSeeder extends Seeder
{
    public function run()
    {
        $setting = PaymentSetting::current();

        $data = [
            'gateway' => 'pesapal',
            'currency' => $this->envValue('PAYMENT_CURRENCY', 'TZS'),
            'pesapal_base_url' => $this->envValue('PESAPAL_BASE_URL', 'https://pay.pesapal.com/v3/api/'),
            'pesapal_ipn_url' => $this->envValue('PESAPAL_IPN_URL', url('/subscription-payment/ipn')),
            'selcom_base_url' => $this->envValue('SELCOM_BASE_URL', 'https://apigw.selcommobile.com'),
            'selcom_vendor' => $this->envValue('SELCOM_VENDOR', $setting->selcom_vendor ?: 'TILL60938297'),
        ];

        $secretFields = [
            'pesapal_consumer_key' => $this->envValue('PESAPAL_CONSUMER_KEY'),
            'pesapal_consumer_secret' => $this->envValue('PESAPAL_CONSUMER_SECRET'),
            'selcom_api_key' => $this->envValue('SELCOM_API_KEY'),
            'selcom_api_secret' => $this->envValue('SELCOM_API_SECRET'),
        ];

        foreach ($secretFields as $field => $value) {
            if (!empty($value)) {
                $data[$field] = $value;
            }
        }

        $setting->update($data);
    }

    protected function envValue($key, $default = null)
    {
        $value = env($key);

        return $value === null || $value === '' ? $default : $value;
    }
}
