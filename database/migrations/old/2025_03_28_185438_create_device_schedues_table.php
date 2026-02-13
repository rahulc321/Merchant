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
        Schema::create('device_schedues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->date('schedule_date'); // Specific date for the schedule
            $table->string('timezone');
            $table->time('on_time');
            $table->time('off_time');
            $table->float('temperature')->nullable(); // Temperature setting
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
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
        Schema::dropIfExists('device_schedues');
    }
};
