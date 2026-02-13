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
        Schema::create('cat_objects', function (Blueprint $table) {
            $table->id();
            $table->string('obj_id');
            $table->string('cat_id');
            $table->string('type')->nullable();
            $table->decimal('value',10,2)->default(0);
            $table->integer('chance')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('status')->default(1);
            $table->string('tbl_type')->default(1);
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
        Schema::dropIfExists('cat_objects');
    }
};
