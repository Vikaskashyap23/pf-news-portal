@extends('adminlte::page')

@section('title', 'Add Language')

@section('content_header')
    <h1>Add Language</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('languages.store') }}" method="POST">

            @csrf

            <div class="form-group mb-3">
                <label>Language Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Enter Language Name">
            </div>

            <div class="form-group mb-3">
                <label>Language Code</label>

                <input type="text"
                       name="code"
                       class="form-control"
                       placeholder="Example: en, hi, mr">
            </div>

            <button type="submit" class="btn btn-success">
                Save Language
            </button>

        </form>

    </div>
</div>

@stop