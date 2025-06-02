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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('profile_id');
            $table->string('plan_id');
            $table->string('subject_id');
            $table->string('duration');
            $table->string('payment_method');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('price');
            $table->string('coupon_discount');
            $table->string('tax');
            $table->string('total_amount');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
