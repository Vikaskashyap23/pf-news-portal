@extends('adminlte::page')

@section('title', 'Edit Domain')

@section('content_header')
    <div>
        <h1>Edit Domain</h1>
        <small class="text-muted">
            Update domain for {{ $website->name }}
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

        <form action="{{ route('admin.websites.domains.update', [$website, $domain]) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Domain --}}
                <div class="form-group">
                    <label for="domain">Domain Name</label>

                    <input type="text"
                           name="domain"
                           id="domain"
                           class="form-control @error('domain') is-invalid @enderror"
                           value="{{ old('domain', $domain->domain) }}"
                           placeholder="example.com">

                    @error('domain')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="form-group">
                    <label for="type">Domain Type</label>

                    <select name="type"
                            id="type"
                            class="form-control @error('type') is-invalid @enderror">

                        <option value="custom"
                            {{ old('type', $domain->type) === 'custom' ? 'selected' : '' }}>
                            Custom Domain
                        </option>

                        <option value="subdomain"
                            {{ old('type', $domain->type) === 'subdomain' ? 'selected' : '' }}>
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
                           {{ old('is_primary', $domain->is_primary) ? 'checked' : '' }}>

                    <label class="form-check-label" for="is_primary">
                        Set as Primary Domain
                    </label>

                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label>Status</label>

                    <input type="text"
                           class="form-control"
                           value="{{ ucfirst($domain->status) }}"
                           disabled>

                    <small class="form-text text-muted">
                        Domain status is currently managed by the verification system.
                    </small>
                </div>

            </div>

            <div class="card-footer">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Update Domain
                </button>

                <a href="{{ route('admin.websites.domains.index', $website) }}"
                   class="btn btn-secondary ml-2">
                    Cancel
                </a>

            </div>

        </form>

    </div>

@stop