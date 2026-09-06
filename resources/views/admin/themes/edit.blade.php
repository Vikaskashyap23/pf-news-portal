 @extends('adminlte::page')

@section('title', 'Edit Theme')

@section('content_header')
    <h1>Edit Theme</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('themes.update', $theme->id) }}" method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- Theme Name --}}
            <div class="form-group mb-3">
                <label>Theme Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $theme->name) }}"
                       placeholder="Enter Theme Name"
                       required>

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Description --}}
            <div class="form-group mb-3">
                <label>Description</label>

                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="Enter Theme Description">{{ old('description', $theme->description) }}</textarea>

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Theme Type --}}
            <div class="form-group mb-3">
                <label>Theme Type</label>

                <select name="type" class="form-control" required>
                    <option value="free"
                        {{ old('type', $theme->type) === 'free' ? 'selected' : '' }}>
                        Free
                    </option>

                    <option value="premium"
                        {{ old('type', $theme->type) === 'premium' ? 'selected' : '' }}>
                        Premium
                    </option>
                </select>

                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Price --}}
            <div class="form-group mb-3">
                <label>Price</label>

                <input type="number"
                       name="price"
                       class="form-control"
                       value="{{ old('price', $theme->price) }}"
                       min="0"
                       step="0.01"
                       placeholder="Enter Theme Price">

                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Trial Days --}}
            <div class="form-group mb-3">
                <label>Trial Days</label>

                <input type="number"
                       name="trial_days"
                       class="form-control"
                       value="{{ old('trial_days', $theme->trial_days) }}"
                       min="0"
                       placeholder="Enter Trial Days">

                @error('trial_days')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Preview Image --}}
            <div class="form-group mb-3">
                <label>Preview Image</label>

                @if($theme->preview_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $theme->preview_image) }}"
                             alt="{{ $theme->name }}"
                             style="max-width: 250px; max-height: 150px;"
                             class="img-thumbnail">
                    </div>
                @endif

                <input type="file"
                       name="preview_image"
                       class="form-control"
                       accept="image/*">
                    @error('preview_image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Theme Path --}}
            <div class="form-group mb-3">
                <label>Theme Path</label>

                <input type="text"
                       name="theme_path"
                       class="form-control"
                       value="{{ old('theme_path', $theme->theme_path) }}"
                       placeholder="Enter Theme Path">

                @error('theme_path')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Status --}}
            <div class="form-group mb-3">
                <label>Status</label>

                <select name="status" class="form-control" required>
                    <option value="1"
                        {{ old('status', $theme->status) == 1 ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ old('status', $theme->status) == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>

                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Buttons --}}
            <button type="submit" class="btn btn-success">
                Update Theme
            </button>

            <a href="{{ route('themes.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@stop