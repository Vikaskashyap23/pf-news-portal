<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();

            $table->foreignId('website_id')
                ->constrained('websites')
                ->cascadeOnDelete();

            $table->string('domain')->unique();

            $table->enum('type', [
                'subdomain',
                'custom',
            ])->default('custom');

            $table->boolean('is_primary')->default(false);

            $table->enum('status', [
                'pending',
                'verified',
                'active',
                'disabled',
            ])->default('pending');

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index(['website_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};