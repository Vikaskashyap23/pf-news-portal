@extends('adminlte::page')

@section('title', 'Add Theme')

@section('content_header')
    <h1>Add Theme</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('themes.store') }}" method="POST">

            @csrf

            <div class="form-group mb-3">
                <label>Theme Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Enter Theme Name"
                       required>
            </div>

            <button type="submit" class="btn btn-success">
                Save Theme
            </button>

            <a href="{{ route('themes.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </form>

    </div>
</div>

@stop