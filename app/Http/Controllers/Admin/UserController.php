<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'status' => 'required',
        ]);

        User::Create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'  => $request->role,
            'status'  => $request->status,
        ]);

        return redirect()
          ->route('users.index')
          ->with('success', 'User created successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function permissions(string $id)

    {

    $user = User::findOrFail($id);

    $permissions = \App\Models\Permission::orderBy('module')
        ->orderBy('name')
        ->get();

    $userPermissions = \DB::table('user_permissions')
        ->where('user_id', $user->id)
        ->pluck('effect', 'permission_id');

    return view('admin.users.permissions', compact(
        'user',
        'permissions',
        'userPermissions'
    ));

   }


          
   public function updatePermissions(Request $request, string $id)

   {

    $user = User::findOrFail($id);

    $permissions = $request->input('permissions', []);

    \DB::table('user_permissions')
        ->where('user_id', $user->id)
        ->delete();

    foreach ($permissions as $permissionId => $effect) {

        if (!in_array($effect, ['allow', 'deny'])) {
            continue;
        }

        \DB::table('user_permissions')->insert([
            'user_id' => $user->id,
            'permission_id' => $permissionId,
            'effect' => $effect,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()
        ->route('users.permissions', $user->id)
        ->with('success', 'User permissions updated successfully.');
        
    }

       


    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => 'required',
            'status' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
            'status' => $request->status,
        ];


        if ($request->filled('password')) {

           $request->validate([
            'password' => 'min:6',

           ]);

           $data['password'] = Hash::make($request->password);

        }

        $user->update($data);

        return redirect()
        ->route('users.index')
        ->with('success', 'User updated successfullly.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if($user->id == auth()->id()) {
            return redirect()
            ->route('users.index')
            ->with('error', 'You cannot delete your own accoount.');

        }

        $user->delete();

        return redirect()
        ->route('users.index')
        ->with('success', ' User deleted successfully.');
    }
}
