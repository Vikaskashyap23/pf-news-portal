@extends('adminlte::page')

@section('title', 'Add Category')

@section('content_header')
<h1>Add Category</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Create Category</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('categories.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Website</label>

                <select name="website_id" class="form-control">

                    @foreach($websites as $website)

                        <option value="{{ $website->id }}">
                            {{ $website->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">
                <label>Parent Category</label>

                <select name="parent_id" class="form-control">

                    <option value="">None</option>

                    @foreach($parents as $parent)

                        <option value="{{ $parent->id }}">
                            {{ $parent->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-3">
                <label>Category Name</label>

                <input type="text" name="name" class="form-control">

            </div>

            <div class="mb-3">
                <label>Slug</label>

                <input type="text" name="slug" class="form-control">

            </div>

            <div class="mb-3">

                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="1">Active</option>
                    <option value="0">Inactive</option>

                </select>

            </div>

            <button class="btn btn-primary">
                Save Category
            </button>

        </form>

    </div>

</div>

@stop