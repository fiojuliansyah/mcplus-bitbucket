<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
            $table->string('grade_id');
            $table->string('subject_id');
<<<<<<< HEAD
<<<<<<< HEAD
            $table->string('topic_id');
            $table->string('user_id');
=======
            $table->string('topic');
>>>>>>> e9bf435 (Add Live Class management for tutor)
=======
            $table->string('topic_id');
            $table->string('user_id');
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
            $table->text('agenda'); 
            $table->integer('type');
            $table->integer('duration'); 
            $table->string('timezone')->default('Asia/Dhaka'); 
            $table->string('password')->nullable(); 
            $table->datetime('start_time'); 
            $table->json('settings'); 
            $table->string('zoom_meeting_id')->nullable(); 
            $table->string('zoom_join_url')->nullable(); 
            $table->string('status')->default('scheduled'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_classes');
    }
};
