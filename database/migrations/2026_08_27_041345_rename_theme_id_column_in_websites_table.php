<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropForeign(['theme-id']);
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->renameColumn('theme-id', 'theme_id');
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->foreign('theme_id')
                ->references('id')
                ->on('themes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropForeign(['theme_id']);
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->renameColumn('theme_id', 'theme-id');
        });

        Schema::table('websites', function (Blueprint $table) {
            $table->foreign('theme-id')
                ->references('id')
                ->on('themes')
                ->nullOnDelete();
        });
    }
};