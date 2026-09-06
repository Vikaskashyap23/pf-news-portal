<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('theme_orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_mobile', 20)->nullable()->after('customer_email');
            $table->string('customer_password')->nullable()->after('customer_mobile');
        });
    }

    public function down(): void
    {
        Schema::table('theme_orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_email',
                'customer_mobile',
                'customer_password',
            ]);
        });
    }
};