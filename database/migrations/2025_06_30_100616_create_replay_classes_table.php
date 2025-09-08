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
        Schema::create('replay_classes', function (Blueprint $table) {
            $table->id();
            $table->string('grade_id');
            $table->string('subject_id');
            $table->string('topic_id');
            $table->string('name')->nullable();
            $table->longtext('description')->nullable();
            $table->string('user_id');
            $table->string('replay_url')->nullable();
            $table->string('replay_public_id')->nullable();
            $table->string('duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_Date')->nullable();
            $table->enum('status', ['draft','publish'])->default('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replay_classes');
    }
};
