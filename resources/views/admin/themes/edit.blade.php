@extends('adminlte::page')

@section('title', 'Edit Theme')

@section('content_header')
    <h1>Edit Theme</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('themes.update', $theme->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Theme Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $theme->name) }}"
                       placeholder="Enter Theme Name">

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">
                Update Theme
            </button>

            <a href="{{ route('themes.index') }}" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@stop