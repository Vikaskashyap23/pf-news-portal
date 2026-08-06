@extends('adminlte::page')

@section('title', 'Edit Language')

@section('content_header')
    <h1>Edit Language</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('languages.update', $language->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Language Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $language->name }}">
            </div>

            <div class="form-group mb-3">
                <label>Language Code</label>

                <input type="text"
                       name="code"
                       class="form-control"
                       value="{{ $language->code }}">
            </div>

            <div class="form-group mb-3">
                <label>
                    <input type="checkbox"
                           name="status"
                           value="1"
                           {{ $language->status ? 'checked' : '' }}>

                    Active
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                Update Language
            </button>

        </form>

    </div>
</div>

@stop