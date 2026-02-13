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
        Schema::create('learning_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('learning_collections')->onDelete('cascade');
            $table->enum('type', ['text', 'image', 'video', 'question']);
            $table->text('content')->nullable(); // for text, image/video path, or video URL
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('learning_items');
    }
};
