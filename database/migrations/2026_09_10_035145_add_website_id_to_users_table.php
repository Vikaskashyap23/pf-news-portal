<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // website_id column was already created successfully
        // during the previous migration attempt.

        $foreignKeyExists = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'users')
            ->where('COLUMN_NAME', 'website_id')
            ->where('REFERENCED_TABLE_NAME', 'websites')
            ->where('REFERENCED_COLUMN_NAME', 'id')
            ->exists();

        if (!$foreignKeyExists) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('website_id', 'users_website_id_foreign')
                    ->references('id')
                    ->on('websites')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'website_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_website_id_foreign');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('website_id');
            });
        }
    }
};