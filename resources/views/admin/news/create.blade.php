@extends('adminlte::page')

@section('title', 'Add News')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Add News</h1>

        <a href="{{ route('news.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>
@stop


@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('news.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                News Information
            </h3>
        </div>


        <div class="card-body">

            {{-- Website --}}
            <div class="form-group mb-3">

                <label for="website_id">
                    Website
                </label>

                <select name="website_id"
                        id="website_id"
                        class="form-control">

                    @foreach($websites as $website)

                        <option value="{{ $website->id }}"
                            {{ old('website_id') == $website->id ? 'selected' : '' }}>

                            {{ $website->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Category --}}
            <div class="form-group mb-3">

                <label for="category_id">
                    Category
                </label>

                <select name="category_id"
                        id="category_id"
                        class="form-control">

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Language --}}
            <div class="form-group mb-3">

                <label for="language_id">
                    Language
                </label>

                <select name="language_id"
                        id="language_id"
                        class="form-control">

                    @foreach($languages as $language)

                        <option value="{{ $language->id }}"
                            {{ old('language_id') == $language->id ? 'selected' : '' }}>

                            {{ $language->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Theme --}}
            <div class="form-group mb-3">

                <label for="theme_id">
                    Theme
                </label>

                <select name="theme_id"
                        id="theme_id"
                        class="form-control">

                    @foreach($themes as $theme)

                        <option value="{{ $theme->id }}"
                            {{ old('theme_id') == $theme->id ? 'selected' : '' }}>

                            {{ $theme->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Title --}}
            <div class="form-group mb-3">

                <label for="title">
                    Title
                </label>

                <input type="text"
                       name="title"
                       id="title"
                       class="form-control"
                       value="{{ old('title') }}"
                       placeholder="Enter news title">

            </div>


            {{-- Slug --}}
            <div class="form-group mb-3">

                <label for="slug">
                    Slug
                </label>

                <input type="text"
                       name="slug"
                       id="slug"
                       class="form-control"
                       value="{{ old('slug') }}"
                       readonly>

            </div>


            {{-- Meta Title --}}
            <div class="form-group mb-3">

                <label for="meta_title">
                    Meta Title
                </label>

                <input type="text"
                       name="meta_title"
                       id="meta_title"
                       class="form-control"
                       value="{{ old('meta_title') }}"
                       placeholder="Enter meta title">

            </div>


            {{-- Meta Description --}}
            <div class="form-group mb-3">

                <label for="meta_description">
                    Meta Description
                </label>

                <textarea name="meta_description"
                          id="meta_description"
                          rows="4"
                          class="form-control"
                          placeholder="Enter meta description">{{ old('meta_description') }}</textarea>

            </div>


            {{-- Description --}}
            <div class="form-group mb-3">

                <label for="description">
                    Description
                </label>

                <textarea name="description"
                          id="description"
                          rows="10"
                          class="form-control">{{ old('description') }}</textarea>

            </div>


            {{-- Featured Image --}}
            <div class="form-group mb-3">

                <label for="featured_image">
                    Featured Image
                </label>

                <input type="file"
                       name="featured_image"
                       id="featured_image"
                       class="form-control"
                       accept="image/*">

            </div>


            {{-- Meta Keywords --}}
            <div class="form-group mb-3">

                <label for="meta_keywords">
                    Meta Keywords
                </label>

                <input type="text"
                       name="meta_keywords"
                       id="meta_keywords"
                       class="form-control"
                       value="{{ old('meta_keywords') }}"
                       placeholder="news, india, politics">

            </div>


            {{-- Breaking News --}}
            <div class="form-group mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           name="is_breaking"
                           id="is_breaking"
                           value="1"
                           class="form-check-input"
                           {{ old('is_breaking') ? 'checked' : '' }}>

                    <label for="is_breaking"
                           class="form-check-label">

                        Breaking News

                    </label>

                </div>

            </div>


            {{-- Featured News --}}
            <div class="form-group mb-3">

                <div class="form-check">

                    <input type="checkbox"
                           name="is_featured"
                           id="is_featured"
                           value="1"
                           class="form-check-input"
                           {{ old('is_featured') ? 'checked' : '' }}>

                    <label for="is_featured"
                           class="form-check-label">

                        Featured News

                    </label>

                </div>

            </div>


            {{-- Publish Date --}}
            <div class="form-group mb-3">

                <label for="published_at">
                    Publish Date & Time
                </label>

                <input type="datetime-local"
                       name="published_at"
                       id="published_at"
                       class="form-control"
                       value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">

            </div>


            {{-- Status --}}
            <div class="form-group mb-3">

                <label for="status">
                    Status
                </label>

                <select name="status"
                        id="status"
                        class="form-control">

                    <option value="draft"
                        {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>

                        Draft

                    </option>

                    <option value="published"
                        {{ old('status') == 'published' ? 'selected' : '' }}>

                        Published

                    </option>

                </select>

            </div>

        </div>


        {{-- Footer --}}
        <div class="card-footer">

            <button type="submit"
                    class="btn btn-success">

                <i class="fas fa-save"></i>
                Save News

            </button>


            <a href="{{ route('news.index') }}"
               class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </div>

</form>

@stop


{{-- =========================================================
     CKEDITOR + JAVASCRIPT
========================================================= --}}

@section('js')

@vite('resources/js/app.js')



<style>

    /*
    |--------------------------------------------------------------------------
    | CKEditor
    |--------------------------------------------------------------------------
    */

    .ck-editor {
        width: 100%;
    }

    .ck-editor__editable {
        min-height: 300px !important;
        cursor: text !important;
        pointer-events: auto !important;
        user-select: text !important;
    }

    .ck-editor__editable_inline {
        min-height: 300px !important;
    }

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Slug Generator
    |--------------------------------------------------------------------------
    */

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    if (titleInput && slugInput) {

        titleInput.addEventListener('keyup', function () {

            let slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');

            slugInput.value = slug;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | CKEditor
    |--------------------------------------------------------------------------
    */

    const descriptionElement =
        document.getElementById('description');

    if (!descriptionElement) {
        console.error('Description textarea not found.');
        return;
    }

    if (typeof window.ClassicEditor === 'undefined') {
        console.error('ClassicEditor not loaded.');
        return;
    }

    const {
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Heading,
        Link,
        List,
        BlockQuote,
        Table
    } = window.CKEditorPlugins;


    window.ClassicEditor
        .create(descriptionElement, {

            licenseKey: 'GPL',

            plugins: [
                Essentials,
                Paragraph,
                Bold,
                Italic,
                Heading,
                Link,
                List,
                BlockQuote,
                Table
            ],

            toolbar: [
                'undo',
                'redo',
                '|',
                'heading',
                '|',
                'bold',
                'italic',
                '|',
                'link',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'blockQuote',
                'insertTable'
            ],

            placeholder:
                'Write your news description here...'

        })

        .then(editor => {

            window.newsEditor = editor;

            console.log(
                'CKEditor loaded successfully.'
            );

        })

        .catch(error => {

            console.error(
                'CKEditor Error:',
                error
            );

        });

});
</script>


@stop