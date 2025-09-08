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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('grade_id');
            $table->string('subject_id');
            $table->string('topic_id');
            $table->string('user_id');
            // $table->string('question');
            // $table->json('multiple_choice');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('max_score');
            $table->string('attempts_time');
            $table->string('estimate_time');
            $table->string('total_question');
            $table->enum('auto_mark', ['yes','no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
