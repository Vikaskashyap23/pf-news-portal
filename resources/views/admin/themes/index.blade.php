@extends('adminlte::page')

@section('title', 'Themes')

@section('content_header')
    <h1>Themes</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <a href="{{ route('themes.create') }}" class="btn btn-primary">
            Add Theme
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Theme Name</th>
                    <th>Status</th>
                    <th width="220">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($themes as $theme)

                <tr>

                    <td>{{ $theme->id }}</td>

                    <td>{{ $theme->name }}</td>

                    <td>
                        @if($theme->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif

                        
                        <!-- <form action="{{ route('themes.status',$theme->id) }}"
                              method="POST"
                              style="display:inline">
                            @csrf
                            @method('PUT')

                            <button class="btn btn-info btn-sm">
                                {{ $theme->status ? 'Inactive' : 'Active' }}
                            </button>
                        </form>
                         -->
                    </td>

                    <td>

                        <a href="{{ route('themes.edit',$theme->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('themes.destroy', $theme->id) }}"
                                method="POST"
                                style="display:inline-block;"
                                onsubmit="return confirm('Are yOU Sure you want to delete this theme?')">

                                @csrf

                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Delete
                                </button>

                            </form>


                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center">
                        No Theme Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="mt-3">
            {{ $themes->links() }}
        </div>

    </div>
</div>

@stop