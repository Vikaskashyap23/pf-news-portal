[26-08-2026 09:24] Vikas Kashyap: @extends('adminlte::page')

@section('title', 'Add Theme')

@section('content_header')
    <h1>Add Theme</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <form action="{{ route('themes.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            {{-- Theme Name --}}
            <div class="form-group mb-3">

                <label>Theme Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    placeholder="Enter Theme Name"
                    required
                >

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            {{-- Description --}}
            <div class="form-group mb-3">

                <label>Description</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                    placeholder="Enter Theme Description"
                >{{ old('description') }}</textarea>

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            {{-- Theme Type --}}
            <div class="form-group mb-3">

                <label>Theme Type</label>

                <select
                    name="type"
                    id="themeType"
                    class="form-control"
                    required
                >

                    <option value="free"
                        {{ old('type', 'free') == 'free' ? 'selected' : '' }}>
                        Free
                    </option>

                    <option value="premium"
                        {{ old('type') == 'premium' ? 'selected' : '' }}>
                        Premium
                    </option>

                </select>

            </div>


            {{-- Price --}}
            <div class="form-group mb-3" id="priceField">

                <label>Price (₹)</label>

                <input
                    type="number"
                    name="price"
                    class="form-control"
                    value="{{ old('price', 0) }}"
                    min="0"
                    step="0.01"
                    placeholder="Enter Theme Price"
                >

                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            {{-- Trial Days --}}
            <div class="form-group mb-3" id="trialField">

                <label>Trial Days</label>

                <input
                    type="number"
                    name="trial_days"
                    class="form-control"
                    value="{{ old('trial_days', 0) }}"
                    min="0"
                    placeholder="Example: 7"
                >

                @error('trial_days')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            {{-- Preview Image --}}
            <div class="form-group mb-3">

                <label>Preview Image</label>

                <input
                    type="file"
                    name="preview_image"
                    class="form-control"
                    accept="image/*"
                >

                @error('preview_image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            {{-- Theme Path --}}
            <div class="form-group mb-3">

                <label>Theme Path</label>
                   <input
                    type="text"
                    name="theme_path"
                    class="form-control"
                    value="{{ old('theme_path') }}"
                    placeholder="Example: themes/magazine"
                >

                @error('theme_path')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>


            {{-- Status --}}
            <div class="form-group mb-3">

                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="1"
                        {{ old('status', 1) == 1 ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ old('status') == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>


            <button type="submit" class="btn btn-success">
                Save Theme
            </button>

            <a href="{{ route('themes.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </form>

    </div>

</div>


<script>

    function togglePremiumFields() {

        let type = document.getElementById('themeType').value;

        let priceField = document.getElementById('priceField');
        let trialField = document.getElementById('trialField');

        if (type === 'premium') {

            priceField.style.display = 'block';
            trialField.style.display = 'block';

        } else {

            priceField.style.display = 'none';
            trialField.style.display = 'none';

        }
    }

    document.getElementById('themeType').addEventListener('change', togglePremiumFields);

    togglePremiumFields();

</script>

@stop