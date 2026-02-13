<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('bind_space_id')->nullable();
            $table->string('category')->nullable();
            $table->string('custom_name')->nullable();
            $table->string('icon')->nullable();
            $table->string('device_id')->unique();
            $table->string('ip')->nullable();
            $table->boolean('is_online')->default(false);
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lon', 10, 6)->nullable();
            $table->string('local_key')->nullable();
            $table->string('model')->nullable();
            $table->string('name')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->boolean('sub')->default(false);
            $table->string('time_zone')->nullable();
            $table->timestamp('active_time')->nullable();
            $table->timestamp('create_time')->nullable();
            $table->timestamp('update_time')->nullable();
            $table->string('uuid')->unique();
            $table->json('device_logs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
