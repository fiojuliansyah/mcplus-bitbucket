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
        Schema::table('users', function (Blueprint $table) {
            $table->string('zoom_id')->nullable()->after('id');
            $table->text('zoom_token')->nullable()->after('remember_token');
            $table->text('zoom_refresh_token')->nullable()->after('zoom_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['zoom_id', 'zoom_token', 'zoom_refresh_token']);
        });
    }
};
