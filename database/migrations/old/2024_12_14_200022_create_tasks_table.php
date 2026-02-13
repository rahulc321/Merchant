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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Task title
            $table->text('description')->nullable(); // Task description
            $table->string('assigned_to')->nullable(); // User ID the task is assigned to
            $table->unsignedInteger('created_by'); // User ID who created the task
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending'); // Task status
            $table->dateTime('due_date')->nullable(); // Due date for the task
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraints
            //$table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
