@extends('adminlte::page')

@section('title', 'Add Website')

@section('content_header')
    <h1>Add Website</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Website Information</h3>
    </div>

    <form method="POST" action="/websites">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label for="name">Website Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    placeholder="Enter website name"
                >
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input
                    type="text"
                    name="slug"
                    id="slug"
                    class="form-control"
                    placeholder="Enter slug"
                >
            </div>

            <div class="form-group">
                <label for="language">Language</label>
                <input
                    type="text"
                    name="language"
                    id="language"
                    class="form-control"
                    placeholder="Enter language"
                >
            </div>

            <div class="form-group">
                <label for="theme">Theme</label>
                <input
                    type="text"
                    name="theme"
                    id="theme"
                    class="form-control"
                    placeholder="Enter theme"
                >
            </div>

            <div class="form-group">
                <label for="domain">Domain</label>
                <input
                    type="text"
                    name="domain"
                    id="domain"
                    class="form-control"
                    placeholder="Enter domain"
                >
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Save Website
            </button>
        </div>

    </form>
</div>

@stop