<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Websites
            [
                'name' => 'websites.view',
                'display_name' => 'View Websites',
                'module' => 'websites',
            ],
            [
                'name' => 'websites.create',
                'display_name' => 'Create Websites',
                'module' => 'websites',
            ],
            [
                'name' => 'websites.edit',
                'display_name' => 'Edit Websites',
                'module' => 'websites',
            ],
            [
                'name' => 'websites.delete',
                'display_name' => 'Delete Websites',
                'module' => 'websites',
            ],

            // Categories
            [
                'name' => 'categories.view',
                'display_name' => 'View Categories',
                'module' => 'categories',
            ],
            [
                'name' => 'categories.create',
                'display_name' => 'Create Categories',
                'module' => 'categories',
            ],
            [
                'name' => 'categories.edit',
                'display_name' => 'Edit Categories',
                'module' => 'categories',
            ],
            [
                'name' => 'categories.delete',
                'display_name' => 'Delete Categories',
                'module' => 'categories',
            ],

            // News
            [
                'name' => 'news.view',
                'display_name' => 'View News',
                'module' => 'news',
            ],
            [
                'name' => 'news.create',
                'display_name' => 'Create News',
                'module' => 'news',
            ],
            [
                'name' => 'news.edit',
                'display_name' => 'Edit News',
                'module' => 'news',
            ],
            [
                'name' => 'news.delete',
                'display_name' => 'Delete News',
                'module' => 'news',
            ],

            // Languages
            [
                'name' => 'languages.view',
                'display_name' => 'View Languages',
                'module' => 'languages',
            ],
            [
                'name' => 'languages.create',
                'display_name' => 'Create Languages',
                'module' => 'languages',
            ],
            [
                'name' => 'languages.edit',
                'display_name' => 'Edit Languages',
                'module' => 'languages',
            ],
            [
                'name' => 'languages.delete',
                'display_name' => 'Delete Languages',
                'module' => 'languages',
            ],

            // Themes
            [
                'name' => 'themes.view',
                'display_name' => 'View Themes',
                'module' => 'themes',
            ],
            [
                'name' => 'themes.create',
                'display_name' => 'Create Themes',
                'module' => 'themes',
            ],
            [
                'name' => 'themes.edit',
                'display_name' => 'Edit Themes',
                'module' => 'themes',
            ],
            [
                'name' => 'themes.delete',
                'display_name' => 'Delete Themes',
                'module' => 'themes',
            ],

            // Users
            [
                'name' => 'users.view',
                'display_name' => 'View Users',
                'module' => 'users',
            ],
            [
                'name' => 'users.create',
                'display_name' => 'Create Users',
                'module' => 'users',
            ],
            [
                'name' => 'users.edit',
                'display_name' => 'Edit Users',
                'module' => 'users',
            ],
            [
                'name' => 'users.delete',
                'display_name' => 'Delete Users',
                'module' => 'users',
            ],

            // Settings
            [
                'name' => 'settings.view',
                'display_name' => 'View Settings',
                'module' => 'settings',
            ],
            [
                'name' => 'settings.edit',
                'display_name' => 'Edit Settings',
                'module' => 'settings',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}