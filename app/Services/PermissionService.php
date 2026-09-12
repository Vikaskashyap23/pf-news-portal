<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function hasPermission(User $user, string $permission): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Inactive User
        |--------------------------------------------------------------------------
        */

        if (!$user->status) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        |
        | Super Admin has full platform access.
        |
        */

        if ($user->role === 'super_admin') {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        |
        | Admin does NOT automatically get full access.
        | Permissions must be assigned through role_permissions
        | or user_permissions.
        |
        */

        /*
        |--------------------------------------------------------------------------
        | USER-SPECIFIC PERMISSION
        |--------------------------------------------------------------------------
        |
        | User-specific permission has priority.
        |
        */

        $userOverride = DB::table('user_permissions')
            ->join(
                'permissions',
                'permissions.id',
                '=',
                'user_permissions.permission_id'
            )
            ->where('user_permissions.user_id', $user->id)
            ->where('permissions.name', $permission)
            ->select('user_permissions.effect')
            ->first();


        if ($userOverride) {
            return $userOverride->effect === 'allow';
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE PERMISSION
        |--------------------------------------------------------------------------
        */

        return DB::table('role_permissions')
            ->join(
                'permissions',
                'permissions.id',
                '=',
                'role_permissions.permission_id'
            )
            ->where('role_permissions.role', $user->role)
            ->where('permissions.name', $permission)
            ->exists();
    }
}