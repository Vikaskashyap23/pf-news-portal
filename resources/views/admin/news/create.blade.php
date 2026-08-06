@extends('adminlte::page')

@section('title', 'Add News')

@section('content_header')
    <h1>Add News</h1>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <div class="card">
        <div class="card-body">

            <div class="form-group mb-3">
                <label>Website</label>

                <select name="website_id" class="form-control">
                    @foreach($websites as $website)
                        <option value="{{ $website->id }}">
                            {{ old('website_id') == $website->id ? 'selected' : ''}}
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

                            {{ old('category_id') == $category->id ? 'selected' : ''}}

                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label> Language </label>

                <select name="language_id" class="form-control " >

                    @foreach($languages as $language)

                    <option value="{{ $language->id }}">

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
                        {{ old('theme_id') == $theme->id ? 'selected' : ''}}
                        {{ $theme->name }}

                    </option>

                    @endforeach

                </select>
                
            </div>


            <div class="form-group mb-3">
                <label>Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="form-group mb-3">
                <label>Slug</label>
                <input type="text" name="slug" id="slug" class="form-control" readonly value="{{ old('slug') }}">
            </div>

            <div class="form-group mb-3">
                <label>Meta Title</label>
                <input type="text" name="meta_title" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>Meta Description</label>
                <textarea name="meta_description" class="form-control"></textarea>
            </div>

            <div class="form-group mb-3">
                <label>Description</label>
                <textarea name="description" rows="6" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label> featured_image </label>

                <input type="file"
                       name="featured_image"
                       class="form-control">
            </div>

            <div class="form-group mb-3">
                <label> Meta Keywords </label>
                <input type="text" name="meta_keywords" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>
                    <input type="checkbox" name="is_breaking" value="1">
                    Breaking News
                </label>
            </div>

            <div class="form-group mb-3">
                <label>
                <input type="checkbox"
                         name="is_featured"
                         value="1">

                  Featured News    
                  
               </label> 

            </div>

            <div class="form-group mb-3">
                <label> Publish Date & Time </label>

                <input type="datetime-local"
                       name="published_at"
                       class="form-control"
                       value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
            </div>

            <button class="btn btn-success">
                Save News
            </button>

        </div>
    </div>

</form>

@section('js')

<script>
  
  document.getElementById('title').addEventListener('keyup', function(){

     let slug = this.value
     .toLowerCase()
     .replace(/[^a-z0-9]+/g,'-')
     .replace(/^-|-$/g,'');
     
     document.getElementById('slug').value = slug;
  });


</script>

@endsection

@stop
