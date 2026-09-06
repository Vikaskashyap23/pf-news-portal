<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display users.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:super_admin,admin,editor',
            'status' => 'required|boolean',
        ]);

        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ROLE CREATION CONTROL
        |--------------------------------------------------------------------------
        */

        if ($currentUser->role === 'super_admin') {

            // Super Admin can create any role.
            $allowedRoles = [
                'super_admin',
                'admin',
                'editor',
            ];

            if (!in_array($request->role, $allowedRoles)) {
                abort(403, 'Unauthorized role assignment.');
            }

        } elseif ($currentUser->role === 'admin') {

            // Admin can create Editor only.
            if ($request->role !== 'editor') {
                abort(403, 'Admin can only create Editor users.');
            }

        } else {

            abort(403, 'Unauthorized access.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display specified user.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show edit user form.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | EDIT ACCESS CONTROL
        |--------------------------------------------------------------------------
        */

        // Admin cannot edit Super Admin.
        if (
            $currentUser->role === 'admin' &&
            $user->role === 'super_admin'
        ) {
            abort(403, 'Admin cannot edit Super Admin.');
        }

        // Only Super Admin and Admin can reach this area.
        if (!in_array($currentUser->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * User-specific permissions page.
     */
    public function permissions(string $id)
    {
        $user = User::findOrFail($id);

        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | PERMISSION MANAGEMENT CONTROL
        |--------------------------------------------------------------------------
        */

        // Admin cannot manage Super Admin permissions.
        if (
            $currentUser->role === 'admin' &&
            $user->role === 'super_admin'
        ) {
            abort(403, 'Admin cannot manage Super Admin permissions.');
        }
           if (!in_array($currentUser->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized access.');
        }

        $permissions = Permission::orderBy('module')
            ->orderBy('name')
            ->get();

        $userPermissions = DB::table('user_permissions')
            ->where('user_id', $user->id)
            ->pluck('effect', 'permission_id');

        return view(
            'admin.users.permissions',
            compact(
                'user',
                'permissions',
                'userPermissions'
            )
        );
    }

    /**
     * Update user-specific permissions.
     */
    public function updatePermissions(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | PROTECT SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        if (
            $currentUser->role === 'admin' &&
            $user->role === 'super_admin'
        ) {
            abort(403, 'Admin cannot modify Super Admin permissions.');
        }

        if (!in_array($currentUser->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized access.');
        }

        $permissions = $request->input('permissions', []);

        DB::table('user_permissions')
            ->where('user_id', $user->id)
            ->delete();

        foreach ($permissions as $permissionId => $effect) {

            if (!in_array($effect, ['allow', 'deny'])) {
                continue;
            }

            DB::table('user_permissions')->insert([
                'user_id' => $user->id,
                'permission_id' => $permissionId,
                'effect' => $effect,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()
            ->route('users.permissions', $user->id)
            ->with(
                'success',
                'User permissions updated successfully.'
            );
    }

    /**
     * Update user.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $currentUser = auth()->user();

        $request->validate([
            'name' => 'required|max:255',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'role' => 'required|in:super_admin,admin,editor',

            'status' => 'required|boolean',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADMIN PROTECTION
        |--------------------------------------------------------------------------
        */

        // Admin cannot edit Super Admin.
        if (
            $currentUser->role === 'admin' &&
            $user->role === 'super_admin'
        ) {
            abort(403, 'Admin cannot edit Super Admin.');
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE CONTROL
        |--------------------------------------------------------------------------
        */

        if ($currentUser->role === 'super_admin') {

            // Super Admin can assign any valid role.

        } elseif ($currentUser->role === 'admin') {

            // Admin can only assign Editor role.

            if ($request->role !== 'editor') {
                abort(
                    403,
                    'Admin can only assign Editor role.'
                );
            }

        } else {

            abort(403, 'Unauthorized access.');
        }

        /*
        |--------------------------------------------------------------------------
        | SELF PROTECTION
        |--------------------------------------------------------------------------
        */
           if ($user->id === $currentUser->id) {

            // User cannot deactivate own account.
            if ((int) $request->status === 0) {
                abort(
                    403,
                    'You cannot deactivate your own account.'
                );
            }

            // Super Admin cannot change own role.
            if (
                $currentUser->role === 'super_admin' &&
                $request->role !== 'super_admin'
            ) {
                abort(
                    403,
                    'Super Admin cannot change their own role.'
                );
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        /*
        |--------------------------------------------------------------------------
        | PASSWORD
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $request->validate([
                'password' => 'min:6',
            ]);

            $data['password'] = Hash::make(
                $request->password
            );
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User updated successfully.'
            );
    }

    /**
     * Delete user.
     */
   public function destroy(string $id)
{
    $user = User::findOrFail($id);
    $currentUser = auth()->user();

    // User cannot delete their own account
    if ($user->id === $currentUser->id) {
        return redirect()
            ->route('users.index')
            ->with('error', 'You cannot delete your own account.');
    }

    // Only Super Admin can delete users
    if ($currentUser->role !== 'super_admin') {
        abort(403, 'Only Super Admin can delete users.');
    }

    // Super Admin cannot delete another Super Admin
    if ($user->role === 'super_admin') {
        abort(403, 'Super Admin cannot delete another Super Admin.');
    }

    $user->delete();

    return redirect()
        ->route('users.index')
        ->with('success', 'User deleted successfully.');
}

}