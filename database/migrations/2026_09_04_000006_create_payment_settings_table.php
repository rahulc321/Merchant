<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway')->default('pesapal');
            $table->string('currency', 10)->default('TZS');
            $table->string('pesapal_consumer_key')->nullable();
            $table->string('pesapal_consumer_secret')->nullable();
            $table->string('pesapal_base_url')->nullable();
            $table->string('pesapal_ipn_url')->nullable();
            $table->string('selcom_api_key')->nullable();
            $table->string('selcom_api_secret')->nullable();
            $table->string('selcom_base_url')->nullable();
            $table->string('selcom_vendor')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_settings');
    }
};
