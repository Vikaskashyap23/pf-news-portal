@extends('adminlte::page')

@section('title', 'Websites')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Websites</h1>

        <a href="{{ route('websites.create') }}" class="btn btn-primary">
            + Add Website
        </a>
    </div>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Websites</h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Language</th>
                    <th>Domain</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($websites as $website)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $website->name }}</td>

                        <td>{{ $website->slug }}</td>

                        <td>{{ $website->language }}</td>

                        <td>{{ $website->domain }}</td>

                        <td>

                            @if($website->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif

                        </td>

                        <td>

                            <a href="{{ route('websites.edit', $website->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('websites.destroy' , $website->id) }}" method="POST" style="display:inline;">

                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-sm btn-danger"

                            onclick="return confirm('Are you sure you want to delete this website?')">
                            
                            
                            Delete

                            </button>
                            
                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">
                            No Website Found
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@stop