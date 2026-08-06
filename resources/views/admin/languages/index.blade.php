@extends('adminlte::page')

@section('title', 'Languages')

@section('content_header')
    <h1>Language List</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">

        <a href="{{ route('languages.create') }}" class="btn btn-primary">
            Add Language
        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($languages as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->name }}</td>

                    <td>{{ $item->code }}</td>

                    <td>

                     <form action="{{ route('languages.status', $item->id) }}" method="POST">

                        @csrf

                        @method('PUT')


                        @if($item->status)

                        <button class="btn btn-success btn-sm">

                            Active

                        </button>
                        
                        @else
                        
                        <button class="btn btn-danger btn-sm">

                            Inactive

                        </button>
                        
                        @endif
                        
                    </form>

                    </td>

                    <td>

                        <a href="{{ route('languages.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="#" class="btn btn-danger btn-sm">
                            Delete
                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">
                        No Language Found
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-3">
            {{ $languages->links() }}
        </div>

    </div>

</div>

@stop