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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('topic_id');
            $table->string('name')->nullable();
            $table->longtext('description')->nullable();
            $table->string('file_url')->nullable();
            $table->string('file_public_id')->nullable();
            $table->string('key_url')->nullable();
            $table->string('key_public_id')->nullable();
            $table->enum('status', ['draft','publish'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
