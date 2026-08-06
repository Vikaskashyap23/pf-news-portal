@extends('adminlte::page')

@section('title', 'Add News')

@section('content_header')
    <h1>Add News</h1>
@stop

@section('content')

<form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">

    @csrf

    @method('PUT')

    <div class="card">
        <div class="card-body">

            <div class="form-group mb-3">
                <label>Website</label>

                <select name="website_id" class="form-control">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}">
                            {{ $news->website_id == $website->id ? 'selected': '' }}
                            {{ $website->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Category</label>

                <select name="category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $news->category_id == $category->id ? 'selected' : ''}}
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">

               <label> Language </label>

            <select name="language_id" class="form-control">
                 
                 @foreach($languages as $language)

                     <option value="{{ $language->id }}">
                     {{ $news->language_id == $language->id ? 'selected' : ''}}
                    {{ $language->name }}
                </option>
                @endforeach
            </select>

            </div>

             <div class="form-group mb-3">

                <label> Theme </label>

                <select name="theme_id" class="form-control">
                    @foreach($themes as $theme)
                    <option value="{{ $theme->id }}">
                        {{ $news->theme_id == $theme->id ? 'selected' : ''}}
                        {{ $theme->name }}

                    </option>

                    @endforeach

                </select>
                
            </div>



             @if($news->featured_image)
               <div class="mb-3">
                <label> Current Image </label><br>

                <img src="{{ asset('storage/' . $news->featured_image) }} "
                    width="120"
                    style="border-redius:8px; border:1px solid #add;">
               </div>

               @endif

               <div class="mb-3">

               <label> Change Image </label>

               <input type="file"
                      name="featured_image"
                      class="form-control">
               </div>

            <div class="form-group mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $news->title }}">
            </div>

            <div class="form-group mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $news->slug }}">
            </div>

            <div class="form-group mb-3">
                <label>Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ $news->meta_title }}">
            </div>

            <div class="form-group mb-3">
                <label>Meta Description</label>
                <textarea name="meta_description" class="form-control"> {{ $news->meta_description }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label>Description</label>
                <textarea name="description" rows="6" class="form-control"> {{ $news->description }} </textarea>
            </div>

            <div class="form-group mb-3">
                <label> Meta Keywords </label>
                <input type="text" name="meta_keywords" class="form-control" value="{{ $news->meta_keywords }}">
            </div>
            
            <div class="form-group mb-3">
                <label>
                    <input type="checkbox"
                    name="is_breaking"
                    value="1"
                    {{ $news->is_breaking ? 'checked' : ''}}>

                    Breaking News

                </label>

            </div>

            <div class="form-group mb-3">
                <label>
                    <input type="checkbox"
                            name="is_featured"
                            value="1"
                            {{ $news->is_featured ? 'checked' : ''}}>

                        Featured News    
                </label>
            </div>
            
            <button class="btn btn-primary">
                Update News
            </button>

        </div>
    </div>

</form>

@stop