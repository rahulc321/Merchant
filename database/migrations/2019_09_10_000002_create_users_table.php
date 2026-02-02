<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('full_name');
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email');

            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('product_model')->nullable();
            $table->string('installation_date')->nullable();
            $table->string('warranty_status')->nullable();
            $table->string('service_history')->nullable();
            $table->string('last_contact_date')->nullable();
            $table->text('feedback')->nullable();

           // $table->string('last_contact_date')->nullable();
            $table->string('region')->nullable();
            $table->string('specialization')->nullable();
            $table->string('certifications')->nullable();
            $table->string('appointment_availability')->nullable();
            $table->string('history_service_calls')->nullable();
            $table->string('interest_level')->nullable();
            $table->string('preferred_contact_method')->nullable();
            $table->string('source_lead')->nullable();
            $table->string('business_address')->nullable();
            $table->string('type_of_business')->nullable();
            $table->string('volume_of_sales')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('sales_representative_assigned')->nullable();
            $table->string('store_locations')->nullable();
            $table->string('product_type')->nullable();
           // $table->string('sales_volume')->nullable();
            $table->string('order_history')->nullable();
            $table->string('territories_covered')->nullable();
            $table->string('agrement_details_start_date')->nullable();
            $table->string('agrement_details_duration')->nullable();

            $table->datetime('email_verified_at')->nullable();

            $table->string('password');

            $table->string('remember_token')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });

    }
}
