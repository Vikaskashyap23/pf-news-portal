<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Existing role permissions ko reset karo
        DB::table('role_permissions')->truncate();

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        | Admin ko saari permissions
        */

        $allPermissions = Permission::pluck('id');

        foreach ($allPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role' => 'admin',
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | EDITOR
        |--------------------------------------------------------------------------
        | Editor ko content management permissions
        */

        $editorPermissions = Permission::whereIn('name', [

            // Websites
            'websites.view',
            'websites.create',
            'websites.edit',

            // Categories
            'categories.view',
            'categories.create',
            'categories.edit',

            // News
            'news.view',
            'news.create',
            'news.edit',

            // Languages
            'languages.view',
            'languages.create',
            'languages.edit',

            // Themes
            'themes.view',
            'themes.create',
            'themes.edit',

        ])->pluck('id');

        foreach ($editorPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role' => 'editor',
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}