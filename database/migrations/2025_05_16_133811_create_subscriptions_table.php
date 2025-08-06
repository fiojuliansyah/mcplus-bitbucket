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
            $table->string('transaction_code')->nullable();
            $table->string('user_id')->nullable();
            $table->string('profile_id')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('duration')->nullable();
            $table->string('payment_method')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('price')->nullable();
            $table->string('coupon_id')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->string('tax')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('status')->nullable();
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
