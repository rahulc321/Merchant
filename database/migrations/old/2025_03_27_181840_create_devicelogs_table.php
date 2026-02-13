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
        Schema::create('devicelogs', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->nullable();
            $table->string('code')->nullable();
            $table->string('value')->nullable();
            $table->string('status')->nullable();
            $table->string('event_id')->nullable();
            $table->string('event_from')->nullable();
            $table->string('event_time')->nullable();
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
        Schema::dropIfExists('devicelogs');
    }
};
