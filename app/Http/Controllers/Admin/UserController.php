<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display users.
     *
     * Super Admin:
     * - Can see all users.
     *
     * Admin:
     * - Can only see users assigned to their own website.
     */
    public function index()
    {
        $currentUser = auth()->user();

        if ($currentUser->role === 'super_admin') {
            $users = User::with('website')
                ->latest()
                ->paginate(10);
        } elseif ($currentUser->role === 'admin') {
            if (!$currentUser->website_id) {
                $users = User::whereRaw('1 = 0')
                    ->paginate(10);
            } else {
                $users = User::with('website')
                    ->where('website_id', $currentUser->website_id)
                    ->latest()
                    ->paginate(10);
            }
        } else {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form.
     *
     * Only Super Admin can create users because only Super Admin
     * is allowed to decide who becomes Admin or Super Admin.
     */
    public function create()
    {
        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(403, 'Only Super Admin can create users.');
        }

        $websites = Website::orderBy('name')->get();

        return view(
            'admin.users.create',
            compact('websites')
        );
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Only Super Admin can create users
        |--------------------------------------------------------------------------
        */

        if ($currentUser->role !== 'super_admin') {
            abort(403, 'Only Super Admin can create users.');
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'super_admin',
                    'admin',
                ]),
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'website_id' => [
                'nullable',
                'integer',
                'exists:websites,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Website assignment rules
        |--------------------------------------------------------------------------
        |
        | Super Admin:
        | - Super Admin does not belong to a particular website.
        | - Admin MUST belong to one website.
        |--------------------------------------------------------------------------
        */

        if ($validated['role'] === 'admin') {

            if (empty($validated['website_id'])) {
                return back()
                    ->withErrors([
                        'website_id' =>
                            'Please select a website for the Admin.',
                    ])
                    ->withInput();
            }

        } else {

            // Super Admin is platform-wide.
            $validated['website_id'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Create user
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => (bool) $validated['status'],
            'website_id' => $validated['website_id'],
        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User created successfully.'
            );
    }

    /**
     * Display specified user.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        $this->authorizeUserAccess($user);

        return view(
            'admin.users.show',
            compact('user')
        );
    }

    /**
     * Show edit user form.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $this->authorizeUserAccess($user);

        /*
        |--------------------------------------------------------------------------
        | Only Super Admin can edit user role / website assignment.
        |--------------------------------------------------------------------------
        */

        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(
                403,
                'Only Super Admin can edit user accounts.'
            );
        }

        $websites = Website::orderBy('name')->get();

        return view(
            'admin.users.edit',
            compact(
                'user',
                'websites'
            )
        );
    }

    /**
     * User-specific permissions page.
     *
     * Only Super Admin can manage user permissions.
     */
    public function permissions(string $id)
    {
        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(
                403,
                'Only Super Admin can manage user permissions.'
            );
        }

        $user = User::findOrFail($id);

        $permissions = Permission::orderBy('module')
            ->orderBy('name')
            ->get();

        $userPermissions = DB::table('user_permissions')
            ->where('user_id', $user->id)
            ->pluck(
                'effect',
                'permission_id'
            );

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
    public function updatePermissions(
        Request $request,
        string $id
    ) {
        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(
                403,
                'Only Super Admin can modify user permissions.'
            );
        }

        $user = User::findOrFail($id);

        $permissions = $request->input(
            'permissions',
            []
        );

        /*
        |--------------------------------------------------------------------------
        | Remove existing user-specific overrides
        |--------------------------------------------------------------------------
        */

        DB::table('user_permissions')
            ->where('user_id', $user->id)
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | Save new overrides
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permissionId => $effect) {

            if (!in_array(
                $effect,
                ['allow', 'deny'],
                true
            )) {
                continue;
            }

            $permissionExists = Permission::where(
                'id',
                $permissionId
            )->exists();

            if (!$permissionExists) {
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
            ->route(
                'users.permissions',
                $user->id
            )
            ->with(
                'success',
                'User permissions updated successfully.'
            );
    }

    /**
     * Update user.
     *
     * Only Super Admin can update users.
     */
    public function update(
        Request $request,
        string $id
    ) {
        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(
                403,
                'Only Super Admin can update user accounts.'
            );
        }

        $user = User::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'super_admin',
                    'admin',
                ]),
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'website_id' => [
                'nullable',
                'integer',
                'exists:websites,id',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Self protection
        |--------------------------------------------------------------------------
        |
        | Super Admin cannot:
        | - deactivate their own account
        | - change their own role
        |--------------------------------------------------------------------------
        */

        if ($user->id === $currentUser->id) {

            if ((int) $validated['status'] === 0) {
                abort(
                    403,
                    'You cannot deactivate your own account.'
                );
            }

            if (
                $validated['role'] !==
                'super_admin'
            ) {
                abort(
                    403,
                    'You cannot change your own role.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Protect the last active Super Admin
        |--------------------------------------------------------------------------
        */

        if (
            $user->role === 'super_admin' &&
            $validated['role'] !== 'super_admin'
        ) {

            $activeSuperAdmins = User::where(
                'role',
                'super_admin'
            )
                ->where('status', true)
                ->count();

            if ($activeSuperAdmins <= 1) {
                abort(
                    403,
                    'The last active Super Admin cannot be removed.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Website rules
        |--------------------------------------------------------------------------
        */

        if ($validated['role'] === 'admin') {

            if (empty($validated['website_id'])) {
                return back()
                    ->withErrors([
                        'website_id' =>
                            'Please select a website for the Admin.',
                    ])
                    ->withInput();
            }

        } else {

            // Super Admin is not assigned to a website.
            $validated['website_id'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Update data
        |--------------------------------------------------------------------------
        */

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => (bool) $validated['status'],
            'website_id' => $validated['website_id'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make(
                $validated['password']
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
     *
     * Only Super Admin can delete users.
     */
    public function destroy(string $id)
    {
        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(
                403,
                'Only Super Admin can delete users.'
            );
        }

        $user = User::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Cannot delete own account
        |--------------------------------------------------------------------------
        */

        if ($user->id === $currentUser->id) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'You cannot delete your own account.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cannot delete Super Admin
        |--------------------------------------------------------------------------
        |
        | For safety, Super Admin accounts cannot be deleted from here.
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'super_admin') {
            abort(
                403,
                'Super Admin accounts cannot be deleted.'
            );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User deleted successfully.'
            );
    }

    /**
     * Check whether current user can access target user.
     */
    private function authorizeUserAccess(
        User $user
    ): void {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        if ($currentUser->role === 'super_admin') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        |
        | Admin can only access users belonging to the same website.
        |--------------------------------------------------------------------------
        */

        if ($currentUser->role === 'admin') {

            if (
                !$currentUser->website_id ||
                $user->website_id !==
                $currentUser->website_id
            ) {
                abort(
                    403,
                    'You do not have access to this user.'
                );
            }

            return;
        }

        abort(
            403,
            'Unauthorized access.'
        );
    }
}