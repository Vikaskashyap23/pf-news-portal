@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <h1>Edit Category</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Edit Category</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('categories.update', $category->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Website</label>

                <select name="website_id" class="form-control">

                    @foreach($websites as $website)
                        <option value="{{ $website->id }}"
                            {{ $category->website_id == $website->id ? 'selected' : '' }}>
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
                        <option value="{{ $parent->id }}"
                            {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label>Category Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ $category->name }}">
            </div>

            <div class="mb-3">
                <label>Slug</label>

                <input type="text"
                       name="slug"
                       class="form-control"
                       value="{{ $category->slug }}">
            </div>

            <div class="mb-3">
                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="1" {{ $category->status ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0" {{ !$category->status ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>
            </div>

            <button type="submit" class="btn btn-success">
                Update Category
            </button>

        </form>

    </div>

</div>

@stop