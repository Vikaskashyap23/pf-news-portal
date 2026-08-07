@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">Category List</h3>

        <div class="card-tools">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                Add Category
            </a>
        </div>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Website</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $category->website->name ?? '-' }}</td>

                        <td>{{ $category->name }}</td>

                        <td>{{ $category->slug }}</td>

                        <td>
                            @if($category->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('categories.edit' , $category->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                         
                            <form action="{{ route('categories.destroy', $category->id) }}"
                                 method="POST"
                                 style="display:inline;">

                                 @csrf
                                 @method('DELETE')
                                 
                                 <button type="submit"
                                         class="btn btn-danger btn-sm"
                                         onclick="return confirm('Delete this category?')">

                                         Delete
                                         
                                 </button>
                                        
                              </form>
        

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">
                            No Categories Found
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop