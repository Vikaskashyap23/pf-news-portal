@extends('adminlte::page')

@section('title', 'Add Domain')

@section('content_header')
    <div>
        <h1>Add Domain</h1>
        <small class="text-muted">
            Connect a domain to {{ $website->name }}
        </small>
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

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-globe mr-1"></i>
                Domain Details
            </h3>
        </div>

        <form action="{{ route('admin.websites.domains.store', $website) }}"
              method="POST">

            @csrf

            <div class="card-body">

                {{-- Domain --}}
                <div class="form-group">
                    <label for="domain">Domain Name</label>

                    <input type="text"
                           name="domain"
                           id="domain"
                           class="form-control @error('domain') is-invalid @enderror"
                           value="{{ old('domain') }}"
                           placeholder="example.com">

                    @error('domain')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                    <small class="form-text text-muted">
                        Example: bbcnews.com
                    </small>
                </div>

                {{-- Type --}}
                <div class="form-group">
                    <label for="type">Domain Type</label>

                    <select name="type"
                            id="type"
                            class="form-control @error('type') is-invalid @enderror">

                        <option value="custom"
                            {{ old('type', 'custom') === 'custom' ? 'selected' : '' }}>
                            Custom Domain
                        </option>

                        <option value="subdomain"
                            {{ old('type') === 'subdomain' ? 'selected' : '' }}>
                            Subdomain
                        </option>

                    </select>

                    @error('type')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Primary --}}
                <div class="form-check mb-3">

                    <input type="checkbox"
                           name="is_primary"
                           value="1"
                           class="form-check-input"
                           id="is_primary"
                           {{ old('is_primary') ? 'checked' : '' }}>

                    <label class="form-check-label" for="is_primary">
                        Set as Primary Domain
                    </label>

                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-1"></i>

                    After adding the domain, its status will initially be
                    <strong>Pending</strong>.
                </div>

            </div>

            <div class="card-footer">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    Add Domain
                </button>

                <a href="{{ route('admin.websites.domains.index', $website) }}"
                   class="btn btn-secondary ml-2">
                    Cancel
                </a>

            </div>

        </form>

    </div>

@stop