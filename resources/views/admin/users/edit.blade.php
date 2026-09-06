@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('users.update', $user->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-3">
                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $user->name) }}"
                    required
                >
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    required
                >
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                >

                <small class="text-muted">
                    Leave blank if you don't want to change password.
                </small>
            </div>

            {{-- Role --}}
            <div class="mb-3">

                <label>Role</label>

                <select name="role" class="form-control" required>

                    @if(auth()->user()->role === 'super_admin')

                        <option value="super_admin"
                            {{ $user->role === 'super_admin' ? 'selected' : '' }}>
                            Super Admin
                        </option>

                        <option value="admin"
                            {{ $user->role === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="editor"
                            {{ $user->role === 'editor' ? 'selected' : '' }}>
                            Editor
                        </option>

                    @elseif(auth()->user()->role === 'admin')

                        <option value="editor"
                            {{ $user->role === 'editor' ? 'selected' : '' }}>
                            Editor
                        </option>

                    @endif

                </select>

            </div>

            {{-- Status --}}
            <div class="mb-3">

                <label>Status</label>

                <select name="status" class="form-control" required>

                    <option value="1"
                        {{ $user->status ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ !$user->status ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

            <button type="submit" class="btn btn-success">
                Update User
            </button>

        </form>

    </div>

</div>

@stop