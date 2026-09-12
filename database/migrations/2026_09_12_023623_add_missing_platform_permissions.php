<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            [
                'name' => 'domains.view',
                'display_name' => 'View Domains',
                'module' => 'domains',
            ],
            [
                'name' => 'domains.create',
                'display_name' => 'Create Domains',
                'module' => 'domains',
            ],
            [
                'name' => 'domains.edit',
                'display_name' => 'Edit Domains',
                'module' => 'domains',
            ],
            [
                'name' => 'domains.delete',
                'display_name' => 'Delete Domains',
                'module' => 'domains',
            ],
            [
                'name' => 'payments.view',
                'display_name' => 'View Payments',
                'module' => 'payments',
            ],
            [
                'name' => 'payments.create',
                'display_name' => 'Create Payments',
                'module' => 'payments',
            ],
            [
                'name' => 'payments.edit',
                'display_name' => 'Edit Payments',
                'module' => 'payments',
            ],
            [
                'name' => 'payments.delete',
                'display_name' => 'Delete Payments',
                'module' => 'payments',
            ],
            [
                'name' => 'theme_store.view',
                'display_name' => 'View Theme Store',
                'module' => 'theme_store',
            ],
            [
                'name' => 'theme_store.manage',
                'display_name' => 'Manage Theme Store',
                'module' => 'theme_store',
            ],
        ];

        foreach ($permissions as $permission) {
            $exists = DB::table('permissions')
                ->where('name', $permission['name'])
                ->exists();

            if (!$exists) {
                DB::table('permissions')->insert([
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'module' => $permission['module'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('permissions')
            ->whereIn('name', [
                'domains.view',
                'domains.create',
                'domains.edit',
                'domains.delete',
                'payments.view',
                'payments.create',
                'payments.edit',
                'payments.delete',
                'theme_store.view',
                'theme_store.manage',
            ])
            ->delete();
    }
};