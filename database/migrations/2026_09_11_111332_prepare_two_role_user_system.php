<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        | Existing users are NOT deleted.
        |
        | Existing editor/customer roles are temporarily converted to admin
        | so that the application can safely move to the new two-role system.
        |
        | Admin users without a website remain unassigned for now.
        | We will assign websites safely in the User Management step.
        |--------------------------------------------------------------------------
        */

        DB::table('users')
            ->whereIn('role', ['editor', 'customer'])
            ->update([
                'role' => 'admin',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Change default role for future users
        |--------------------------------------------------------------------------
        */

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')
                ->default('admin')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Restore database column default.
        |
        | We intentionally DO NOT try to restore editor/customer users here,
        | because their original roles cannot be reliably known after migration.
        |--------------------------------------------------------------------------
        */

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')
                ->default('editor')
                ->change();
        });
    }
};