@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')
<h1>Add User</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('users.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>

    <div class="mb-3">
    <label>Password</label>

    <div class="input-group">

        <input
            type="password"
            name="password"
            id="password"
            class="form-control"
            required
        >

        <button
            type="button"
            class="btn btn-outline-secondary"
            onclick="togglePassword()"
        >
            👁
        </button>

    </div>
</div>

            <div class="mb-3">
                <label>Role</label>

                <select name="role" class="form-control">

                    <option value="admin">
                        Admin
                    </option>

                    <option value="editor" selected>
                        Editor
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>

                </select>

            </div>

            <button class="btn btn-primary">
                Save User
            </button>

        </form>

    </div>

</div>

<script>
      function togglePassword() {

        let password = document.getElementById('password');

        if (password.type === "password") {
            password.type = "text";

        }else{
            password.type = "password";
        }
      }
</script>

@stop