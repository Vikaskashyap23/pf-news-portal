@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit User</h1>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Edit User: {{ $user->name }}
        </h3>
    </div>

    <div class="card-body">

        <form
            action="{{ route('users.update', $user->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-3">

                <label for="name">
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ old('name', $user->name) }}"
                    required
                >

            </div>

            {{-- Email --}}
            <div class="mb-3">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    required
                >

            </div>

            {{-- Password --}}
            <div class="mb-3">

                <label for="password">
                    New Password
                </label>

                <div class="input-group">

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                    >

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        onclick="togglePassword('password', this)"
                    >
                        Show
                    </button>

                </div>

                <small class="text-muted">
                    Leave blank if you don't want to change the password.
                </small>

            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">

                <label for="password_confirmation">
                    Confirm New Password
                </label>

                <div class="input-group">

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                    >

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        onclick="togglePassword(
                            'password_confirmation',
                            this
                        )"
                    >
                        Show
                    </button>

                </div>

            </div>

            {{-- Role --}}
            <div class="mb-3">

                <label for="role">
                    Role
                </label>

                <select
                    name="role"
                    id="role"
                    class="form-control"
                    required
                >

                    <option value="admin"
                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="super_admin"
                        {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>

                </select>

                <small class="text-muted">
                    Only Super Admin can change user roles.
                </small>

            </div>

            {{-- Website --}}
            <div class="mb-3">

                <label for="website_id">
                    Website
                </label>

                <select
                    name="website_id"
                    id="website_id"
                    class="form-control"
                >

                    <option value="">
                        Select Website
                    </option>

                    @foreach ($websites as $website)

                        <option
                            value="{{ $website->id }}"
                            {{ old(
                                'website_id',
                                $user->website_id
                            ) == $website->id ? 'selected' : '' }}
                        >
                            {{ $website->name }}
                        </option>

                    @endforeach

                </select>

                <small class="text-muted">
                    Admin users must have a website.
                    Super Admin users are platform-wide.
                </small>

            </div>

            {{-- Status --}}
            <div class="mb-3">

                <label for="status">
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    required
                >

                    <option
                        value="1"
                        {{ old(
                            'status',
                            $user->status ? '1' : '0'
                        ) === '1' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ old(
                            'status',
                            $user->status ? '1' : '0'
                        ) === '0' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>

            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="btn btn-success"
            >
                Update User
            </button>

            <a
                href="{{ route('users.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </form>

    </div>

</div>

<script>
    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            button.innerText = 'Hide';
        } else {
            input.type = 'password';
            button.innerText = 'Show';
        }
    }
</script>

@stop