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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('subject_id');
<<<<<<< HEAD
<<<<<<< HEAD
            $table->string('grade_id');
<<<<<<< HEAD
=======
>>>>>>> 33644b8 (add Topics)
=======
            $table->string('grade_id');
>>>>>>> 27cb97e (Add Subject Detail Page to show the topics)
=======
>>>>>>> parent of ad55921 (update some bug)
            $table->string('status'); // assuming status is a boolean
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
