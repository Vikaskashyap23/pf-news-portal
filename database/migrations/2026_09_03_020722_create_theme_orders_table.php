<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_orders', function (Blueprint $table) {
            $table->id();

            // Customer
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Website for which theme is purchased
            $table->foreignId('website_id')
                ->constrained('websites')
                ->cascadeOnDelete();

            // Purchased theme
            $table->foreignId('theme_id')
                ->constrained('themes')
                ->cascadeOnDelete();

            // Amount charged at purchase time
            $table->decimal('amount', 10, 2);

            // Payment gateway
            $table->string('gateway')->default('razorpay');

            // Razorpay identifiers
            $table->string('razorpay_order_id')
                ->nullable()
                ->unique();

            $table->string('razorpay_payment_id')
                ->nullable()
                ->unique();

            $table->string('razorpay_signature')
                ->nullable();

            // pending / paid / failed
            $table->string('status')->default('pending');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_orders');
    }
};