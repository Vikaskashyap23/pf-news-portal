@extends('adminlte::page')

@section('title', 'Theme Store')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">Theme Store</h1>
            <p class="text-muted mb-0">
                Browse and activate professional news themes.
            </p>
        </div>

        <a href="{{ route('themes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-palette mr-1"></i>
            Manage Themes
        </a>
    </div>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-1"></i>
        {{ session('success') }}

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle mr-1"></i>
        {{ session('error') }}

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif


{{-- HERO --}}
<div class="card border-0 shadow-sm overflow-hidden mb-4"
     style="border-radius:16px;">

    <div class="card-body p-4 p-md-5"
         style="background:linear-gradient(135deg,#111827,#1f2937,#374151);">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <span class="badge badge-light px-3 py-2 mb-3">
                    <i class="fas fa-store mr-1"></i>
                    NewsHub Theme Store
                </span>

                <h2 class="text-white font-weight-bold mb-3">
                    Professional News Themes
                </h2>

                <p class="text-light mb-0"
                   style="font-size:17px;max-width:700px;">

                    Choose a professional theme for your news website.
                    Preview themes and activate the design that fits your publication.

                </p>

            </div>

            <div class="col-lg-4 text-lg-right mt-4 mt-lg-0">

                <div class="text-white">

                    <div style="font-size:42px;">
                        <i class="fas fa-newspaper"></i>
                    </div>

                    <div class="mt-2">
                        <strong>{{ $themes->total() }}</strong>
                        themes available
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- WEBSITE SELECTOR --}}
@if($websites->count())

<div class="card border-0 shadow-sm mb-4"
     style="border-radius:12px;">

    <div class="card-body">

        <div class="row align-items-end">

            <div class="col-md-8">

                <label class="font-weight-bold">
                    <i class="fas fa-globe mr-1"></i>
                    Select Website
                </label>

                <form method="GET"
                      action="{{ route('admin.theme-store.index') }}">

                    <select name="website"
                            class="form-control"
                            onchange="this.form.submit()">

                        @foreach($websites as $website)

                            <option value="{{ $website->id }}"
                                {{ $selectedWebsite && $selectedWebsite->id == $website->id ? 'selected' : '' }}>

                                {{ $website->name }}

                            </option>

                        @endforeach

                    </select>

                </form>

            </div>

            <div class="col-md-4 mt-3 mt-md-0">

                @if($selectedWebsite)

                    <div class="alert alert-light border mb-0">

                        <small class="text-muted d-block">
                            Current Website
                        </small>

                        <strong>
                            {{ $selectedWebsite->name }}
                        </strong>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endif


{{-- FILTERS --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

    <div>

        <h4 class="font-weight-bold mb-1">
            Available Themes
        </h4>

        <small class="text-muted">
            Choose a theme for your website
        </small>

    </div>

    <div class="btn-group mt-3 mt-md-0">

        <button type="button"
                class="btn btn-dark filter-btn active"
                data-filter="all">
            All
        </button>

        <button type="button"
                class="btn btn-outline-dark filter-btn"
                data-filter="free">
            Free
        </button>

        <button type="button"
                class="btn btn-outline-dark filter-btn"
                data-filter="premium">
            Premium
        </button>

    </div>

</div>


{{-- THEME GRID --}}
<div class="row" id="themeGrid">

    @forelse($themes as $theme)

        <div class="col-xl-4 col-lg-6 mb-4 theme-card-wrapper"
             data-type="{{ $theme->type }}">

            <div class="card h-100 border-0 shadow-sm theme-card"
                 style="border-radius:14px;overflow:hidden;">

                {{-- IMAGE --}}
                <div class="position-relative"
                     style="height:210px;background:#f3f4f6;">

                    @if($theme->preview_image)

                        <img src="{{ asset('storage/' . $theme->preview_image) }}"
                             alt="{{ $theme->name }}"
                             style="width:100%;height:100%;object-fit:cover;">

                    @else

                        <div class="d-flex align-items-center justify-content-center h-100">

                            <div class="text-center text-muted">

                                <i class="fas fa-newspaper"
                                   style="font-size:55px;"></i>

                                <div class="mt-2">
                                    Theme Preview
                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- TYPE --}}
                    <div class="position-absolute"
                         style="top:12px;left:12px;">

                        @if($theme->type === 'premium')

                            <span class="badge badge-warning px-3 py-2">
                                <i class="fas fa-crown mr-1"></i>
                                Premium
                            </span>

                        @else

                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-check mr-1"></i>
                                Free
                            </span>

                        @endif

                    </div>

                </div>


                {{-- BODY --}}
                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between align-items-start">

                        <h4 class="font-weight-bold mb-2">
                            {{ $theme->name }}
                        </h4>

                        @if($theme->type === 'premium')

                            <span class="font-weight-bold text-success">
                                ₹{{ number_format((float) $theme->price, 2) }}
                            </span>

                        @else

                            <span class="font-weight-bold text-success">
                                Free
                            </span>

                        @endif

                    </div>


                    <p class="text-muted"
                       style="min-height:48px;">

                        {{ \Illuminate\Support\Str::limit(
                            $theme->description ?: 'Professional news website theme.',
                            120
                        ) }}

                    </p>


                    @if($theme->type === 'premium' && $theme->trial_days > 0)

                        <div class="small text-muted mb-3">

                            <i class="fas fa-clock mr-1"></i>

                            {{ $theme->trial_days }} days trial

                        </div>

                    @endif


                    {{-- BUTTONS --}}
                    <div class="mt-auto pt-2">

                        <div class="row">

                            {{-- PREVIEW --}}
                            <div class="col-6">

                                @if($selectedWebsite)

                                    <a href="{{ route('frontend.themes.preview', [
                                        'websiteSlug' => $selectedWebsite->slug,
                                        'themeId' => $theme->id
                                    ]) }}"
                                       target="_blank"
                                       class="btn btn-outline-dark btn-block">

                                        <i class="fas fa-eye mr-1"></i>
                                        Preview

                                    </a>

                                @else

                                    <button type="button"
                                            class="btn btn-outline-secondary btn-block"
                                            disabled>

                                        Preview

                                    </button>

                                @endif

                            </div>


                            {{-- THEME ACTION --}}
                            <div class="col-6">

                                @if($selectedWebsite)

                                    {{-- FREE THEME --}}
                                    @if($theme->type === 'free')

                                        {{-- CURRENTLY ACTIVE --}}
                                        @if(
                                            $selectedWebsite->theme_id !== null &&
                                            (int) $selectedWebsite->theme_id === (int) $theme->id
                                        )

                                            <button type="button"
                                                    class="btn btn-success btn-block"
                                                    disabled>

                                                <i class="fas fa-check-circle mr-1"></i>
                                                Activated

                                            </button>

                                        {{-- NOT ACTIVE --}}
                                        @else

                                            <form method="POST"
                                                  action="{{ route('frontend.themes.activate', [
                                                      'websiteSlug' => $selectedWebsite->slug,
                                                      'themeId' => $theme->id
                                                  ]) }}">

                                                @csrf

                                                <button type="submit"
                                                        class="btn btn-dark btn-block">

                                                    <i class="fas fa-check mr-1"></i>
                                                    Use Theme

                                                </button>

                                            </form>

                                        @endif


                                    {{-- PREMIUM THEME --}}
                                    @else

                                        {{-- ALREADY ACTIVE --}}
                                        @if(
                                            $selectedWebsite->theme_id !== null &&
                                            (int) $selectedWebsite->theme_id === (int) $theme->id
                                        )

                                            <button type="button"
                                                    class="btn btn-success btn-block"
                                                    disabled>

                                                <i class="fas fa-check-circle mr-1"></i>
                                                Activated

                                            </button>

                                        {{-- NOT ACTIVE --}}
                                        @else

                                            <a href="{{ route('frontend.themes.checkout', [
                                                'websiteSlug' => $selectedWebsite->slug,
                                                'themeId' => $theme->id
                                            ]) }}"
                                               class="btn btn-warning btn-block">

                                                <i class="fas fa-shopping-cart mr-1"></i>
                                                Get Theme

                                            </a>

                                        @endif

                                    @endif

                                @else

                                    <button type="button"
                                            class="btn btn-secondary btn-block"
                                            disabled>

                                        Select Website

                                    </button>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center py-5">

                    <i class="fas fa-palette text-muted"
                       style="font-size:50px;"></i>

                    <h4 class="mt-3">
                        No themes available
                    </h4>

                    <p class="text-muted">
                        Add themes from the Themes management section.
                    </p>

                    <a href="{{ route('themes.create') }}"
                       class="btn btn-dark">

                        <i class="fas fa-plus mr-1"></i>
                        Add Theme

                    </a>

                </div>

            </div>

        </div>

    @endforelse

</div>


{{-- PAGINATION --}}
@if($themes->hasPages())

    <div class="d-flex justify-content-center mt-3">

        {{ $themes->links() }}

    </div>

@endif

@stop


@section('css')

<style>

.theme-card {
    transition: .2s;
}

.theme-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,.10) !important;
}

.filter-btn {
    min-width: 80px;
}

</style>

@stop


@section('js')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const filterButtons = document.querySelectorAll('.filter-btn');
    const themeCards = document.querySelectorAll('.theme-card-wrapper');

    filterButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const filter = this.dataset.filter;

            filterButtons.forEach(function (btn) {
                btn.classList.remove('active', 'btn-dark');
                btn.classList.add('btn-outline-dark');
            });

            this.classList.add('active', 'btn-dark');
            this.classList.remove('btn-outline-dark');

            themeCards.forEach(function (card) {

                if (
                    filter === 'all' ||
                    card.dataset.type === filter
                ) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }

            });

        });

    });

});

</script>

@stop