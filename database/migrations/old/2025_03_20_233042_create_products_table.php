<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key (id)
            $table->string('product_id')->unique(); // Renamed 'id' to 'product_id' to avoid conflict
            $table->string('uid')->nullable();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('category_code')->nullable();
            $table->string('create_uid')->nullable();
            $table->text('desc')->nullable();
            $table->integer('dev_model')->nullable();
            $table->integer('develop_attribute')->nullable();
            $table->integer('develop_status')->nullable();
            $table->bigInteger('gmt_create')->nullable();
            $table->bigInteger('gmt_modified')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_debug')->default(0);
            $table->string('model')->nullable();
            $table->integer('oem_type')->nullable();
            $table->integer('power_type')->nullable();
            $table->boolean('support_group')->default(false);
            $table->integer('type')->nullable();
            $table->string('ui_id')->nullable();
            $table->integer('attribute')->nullable();
            $table->integer('biz_attribute')->nullable();
            $table->integer('capability')->nullable();
            $table->json('product_json')->nullable(); // New column for storing product JSON
            $table->json('product_details_json')->nullable(); 
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('products');
    }
    
    
};
