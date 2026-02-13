<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    public function up()
    {
        // Schema::create('chats', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('sender_id');
        //     $table->integer('receiver_id');
        //     $table->text('message');
        //     $table->string('file_path')->nullable(); // For file uploads
        //     $table->string('file_type')->nullable(); // For file type (image, video, etc.)
        //     $table->timestamps();
        // });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
}