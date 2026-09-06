<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->string('verification_token')->nullable()->unique()->after('status');
            $table->string('verification_method')->default('dns_txt')->after('verification_token');
        });
    }

    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropUnique(['verification_token']);
            $table->dropColumn([
                'verification_token',
                'verification_method',
            ]);
        });
    }
};