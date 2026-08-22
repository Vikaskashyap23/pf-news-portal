@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
<h1>Users</h1>
@stop

@section('content')

@can('users.create')
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        Add User
    </a>
@endcan
<div class="card">
    <div class="card-body">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            @foreach($users as $user)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ ucfirst($user->role) }}</td>

                    <td>
                        @if($user->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>

                   <td>

                        @can('users.edit')
                         <a href="{{ route('users.edit', $user->id) }}"
                         class="btn btn-warning btn-sm">
                            Edit
                      </a>
                         @endcan

                     @can('users.edit')
                    <a href="{{ route('users.permissions', $user->id) }}"
                    class="btn btn-info btn-sm">
                    Permissions
                     </a>
                   @endcan

               @can('users.delete')

             <form action="{{ route('users.destroy', $user->id) }}"
              method="POST"
              style="display:inline;"
              onsubmit="return confirm('Are you sure you want to delete this user?')">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger btn-sm">
                Delete
            </button>
        </form>
    @endcan

</td>
                </tr>

            @endforeach

            </tbody>

        </table>

        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>

@stop