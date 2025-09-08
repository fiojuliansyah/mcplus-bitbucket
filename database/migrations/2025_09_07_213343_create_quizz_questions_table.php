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
        Schema::create('quizz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quizz_id')->constrained('quizzes')->onDelete('cascade');
            $table->text('question_text');
            
            $table->enum('answer_type', ['single_choice', 'multiple_choice', 'true_false', 'text'])->default('single_choice');

            $table->json('options')->nullable(); 
            
            $table->json('correct_answer')->nullable();

            $table->integer('score')->default(10);
            $table->string('media_url')->nullable();
            $table->string('media_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizz_questions');
    }
};
