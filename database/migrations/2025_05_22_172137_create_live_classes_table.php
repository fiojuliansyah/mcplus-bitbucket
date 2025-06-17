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
            $table->string('topic');
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
