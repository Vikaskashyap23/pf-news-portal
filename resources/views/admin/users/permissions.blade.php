@extends('adminlte::page')

@section('title', 'Manage Permissions')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manage Permissions</h1>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Back to Users
        </a>
    </div>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Permissions for:
            <strong>{{ $user->name }}</strong>
        </h3>
    </div>

    <div class="card-body">

        <div class="mb-4">
            <strong>Email:</strong> {{ $user->email }}
            <br>
            <strong>Role:</strong> {{ ucfirst($user->role) }}
        </div>

        <form action="{{ route('users.permissions.update', $user->id) }}" method="POST">

            @csrf
            @method('PUT')

            @php
                $groupedPermissions = $permissions->groupBy('module');
            @endphp

            @foreach($groupedPermissions as $module => $modulePermissions)

                <div class="card mb-4">

                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            {{ ucfirst($module) }} Permissions
                        </h5>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th>Permission Name</th>
                                    <th width="200">Per-User Override</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($modulePermissions as $permission)

                                    @php
                                        $effect = $userPermissions[$permission->id] ?? null;
                                    @endphp

                                    <tr>

                                        <td>
                                            {{ $permission->display_name }}
                                        </td>

                                        <td>
                                            <code>{{ $permission->name }}</code>
                                        </td>

                                        <td>

                                            <select
                                                name="permissions[{{ $permission->id }}]"
                                                class="form-control"
                                            >

                                                <option value=""
                                                    {{ $effect === null ? 'selected' : '' }}>
                                                    Use Role Permission
                                                </option>

                                                <option value="allow"
                                                    {{ $effect === 'allow' ? 'selected' : '' }}>
                                                    Allow
                                                </option>

                                                <option value="deny"
                                                    {{ $effect === 'deny' ? 'selected' : '' }}>
                                                    Deny
                                                </option>

                                            </select>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @endforeach

            <div class="text-end">

                <button type="submit" class="btn btn-primary">
                    Save Permissions
                </button>

                <a href="{{ route('users.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@stop