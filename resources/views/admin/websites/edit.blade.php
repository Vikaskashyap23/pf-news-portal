@extends('adminlte::page')

@section('title', 'Edit Website')

@section('content_header')
    <h1>Edit Website</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Update Website</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('websites.update', $website->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control"
                    value="{{ $website->name }}">
            </div>

            <div class="mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control"
                    value="{{ $website->slug }}">
            </div>

            <div class="mb-3">
                <label>Language</label>
                <input type="text" name="language" class="form-control"
                    value="{{ $website->language }}">
            </div>

            <div class="mb-3">
                <label>Theme</label>
                <input type="text" name="theme" class="form-control"
                    value="{{ $website->theme }}">
            </div>

            <div class="mb-3">
                <label>Domain</label>
                <input type="text" name="domain" class="form-control"
                    value="{{ $website->domain }}">
            </div>

            <button type="submit" class="btn btn-success">
                Update Website
            </button>

            <a href="{{ route('websites.index') }}" class="btn btn-secondary">
                Back
            </a>

        </form>

    </div>
</div>

@stop