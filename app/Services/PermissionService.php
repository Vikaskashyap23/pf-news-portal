<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    /**
     * Check whether a user has a specific permission.
     *
     * Priority:
     * 1. Admin role = Full Access
     * 2. Per-user override
     * 3. Role permission
     */
    public function hasPermission(User $user, string $permission): bool
    {
        // Inactive user = no permission
        if (!$user->status) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | 1. ADMIN = FULL ACCESS
        |--------------------------------------------------------------------------
        |
        | Admin does not need individual permissions.
        | Admin can access everything in the CMS.
        |
        */
        if ($user->role === 'admin') {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. CHECK PER-USER OVERRIDE
        |--------------------------------------------------------------------------
        |
        | Per-user permission has higher priority than role permission.
        |
        | allow = permission granted
        | deny  = permission denied
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
        | 3. CHECK ROLE PERMISSION
        |--------------------------------------------------------------------------
        |
        | If there is no per-user override, fall back to the
        | permissions assigned to the user's role.
        |
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