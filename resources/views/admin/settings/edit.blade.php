 @extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1>Settings</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    {{-- General Settings --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>General Settings</strong>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label>Site Name</label>
                <input type="text"
                       name="site_name"
                       class="form-control"
                       value="{{ old('site_name', $setting->site_name ?? '') }}">
            </div>

        </div>
    </div>

    {{-- Contact Settings --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>Contact Settings</strong>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $setting->email ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       value="{{ old('phone', $setting->phone ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address"
                          class="form-control"
                          rows="3">{{ old('address', $setting->address ?? '') }}</textarea>
            </div>

        </div>
    </div>

    {{-- Social Links --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>Social Links</strong>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label>Facebook</label>
                <input type="url"
                       name="facebook"
                       class="form-control"
                       value="{{ old('facebook', $setting->facebook ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Instagram</label>
                <input type="url"
                       name="instagram"
                       class="form-control"
                       value="{{ old('instagram', $setting->instagram ?? '') }}">
            </div>

            <div class="mb-3">
                <label>YouTube</label>
                <input type="url"
                       name="youtube"
                       class="form-control"
                       value="{{ old('youtube', $setting->youtube ?? '') }}">
            </div>

            <div class="mb-3">
                <label>Twitter / X</label>
                <input type="url"
                       name="twitter"
                       class="form-control"
                       value="{{ old('twitter', $setting->twitter ?? '') }}">
            </div>

        </div>
    </div>

    {{-- SEO Settings --}}
    <div class="card mb-3">
        <div class="card-header">
            <strong>SEO Settings</strong>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label>Meta Title</label>
                <input type="text"
                       name="meta_title"
                       class="form-control"
                       value="{{ old('meta_title', $setting->meta_title ?? '') }}">
            </div>
                <div class="mb-3">
                <label>Meta Description</label>
                <textarea name="meta_description"
                          class="form-control"
                          rows="4">{{ old('meta_description', $setting->meta_description ?? '') }}</textarea>
            </div>

        </div>
    </div>

    <button type="submit" class="btn btn-success">
        Save Settings
    </button>

</form>

@stop