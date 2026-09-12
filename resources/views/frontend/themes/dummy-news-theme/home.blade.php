<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">


<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>{{ $website->name }}</title>

<meta name="description"
      content="{{ $setting->meta_description ?? 'Latest news and stories.' }}">

<script src="https://cdn.tailwindcss.com"></script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    serifDisplay: [
                        'Georgia',
                        'Times New Roman',
                        'serif'
                    ],
                    sansClean: [
                        'Inter',
                        'Arial',
                        'Helvetica',
                        'sans-serif'
                    ]
                },
                colors: {
                    royal: '#b08a45',
                    royalDark: '#80622f',
                    ink: '#111111',
                    ivory: '#f6f2e9',
                    paper: '#fbfaf7',
                    charcoal: '#181818',
                    line: '#ded8cc'
                }
            }
        }
    }
</script>

<style>
    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        margin: 0;
        background: #f6f2e9;
        color: #111;
        font-family: Inter, Arial, Helvetica, sans-serif;
    }

    .page-width {
        width: min(1480px, 100%);
        margin: auto;
    }

    .serif {
        font-family: Georgia, "Times New Roman", serif;
    }

    .gold-line {
        height: 1px;
        background: #b08a45;
    }

    .thin-line {
        border-color: #ded8cc;
    }

    .headline {
        letter-spacing: -2px;
    }

    .news-image {
        transition: transform .55s ease;
    }

    .news-card:hover .news-image {
        transform: scale(1.045);
    }

    .gold-hover {
        transition: color .25s ease;
    }

    .gold-hover:hover {
        color: #b08a45;
    }

    .nav-item {
        position: relative;
    }

    .nav-item::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -7px;
        width: 0;
        height: 1px;
        background: #b08a45;
        transition: width .3s ease;
    }

    .nav-item:hover::after {
        width: 100%;
    }

    .hero-image {
        min-height: 520px;
    }

    .number-story {
        font-family: Georgia, "Times New Roman", serif;
    }

    @media(max-width: 768px) {
        .hero-image {
            min-height: 300px;
        }

        .headline {
            letter-spacing: -1px;
        }
    }
</style>


</head>

<body>

{{-- ========================================================= --}}
{{-- TOP BAR --}}
{{-- ========================================================= --}}

<div class="bg-[#111111] text-white">

<div class="page-width px-5 lg:px-10">

    <div class="h-9 flex items-center justify-between text-[9px] uppercase tracking-[.2em]">

        <div>
            {{ now()->format('l, d F Y') }}
        </div>

        <div class="hidden sm:block text-[#b08a45]">
            Independent News & Journalism
        </div>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- MAIN HEADER --}}
{{-- ========================================================= --}}

<header class="bg-[#fbfaf7] border-b border-[#ded8cc]">

```
<div class="page-width px-5 lg:px-10">

    {{-- BRAND ROW --}}

    <div class="py-7 lg:py-9 flex items-center justify-between gap-6">

        <div class="hidden lg:block w-1/4">

            <div class="text-[9px] uppercase tracking-[.25em] text-gray-500">
                The Daily Edition
            </div>

        </div>


        <a href="{{ frontend_home_url() }}"
           class="text-center flex-1">

            <div class="serif text-4xl sm:text-5xl lg:text-6xl font-bold tracking-[-2px]">
                {{ $website->name }}
            </div>

            <div class="mt-2 flex items-center justify-center gap-3">

                <span class="w-10 h-px bg-[#b08a45]"></span>

                <span class="text-[8px] uppercase tracking-[.35em] text-gray-500">
                    News • Politics • Business • Culture
                </span>

                <span class="w-10 h-px bg-[#b08a45]"></span>

            </div>

        </a>


        <div class="hidden lg:flex w-1/4 justify-end">

            <a href="{{ frontend_home_url() }}"
               class="border border-[#b08a45] px-5 py-2 text-[9px] uppercase tracking-[.2em] font-bold hover:bg-[#111] hover:text-white transition">

                Latest News

            </a>

        </div>

    </div>


    {{-- NAVIGATION --}}

    <div class="border-t border-[#ded8cc]">

        <nav class="hidden lg:flex items-center justify-center gap-8 py-4">

            <a href="{{ frontend_home_url() }}"
               class="nav-item text-[10px] uppercase tracking-[.18em] font-bold">

                Home

            </a>

            @foreach($categories->take(9) as $category)

                <a href="{{ frontend_category_url($category->slug) }}"
                   class="nav-item text-[10px] uppercase tracking-[.18em] text-gray-600 hover:text-black">

                    {{ $category->name }}

                </a>

            @endforeach

        </nav>


        {{-- MOBILE NAV --}}

        <div class="lg:hidden flex gap-6 overflow-x-auto py-4">

            <a href="{{ frontend_home_url() }}"
               class="shrink-0 text-[10px] uppercase tracking-widest font-bold">

                Home

            </a>

            @foreach($categories->take(8) as $category)

                <a href="{{ frontend_category_url($category->slug) }}"
                   class="shrink-0 text-[10px] uppercase tracking-widest text-gray-500">

                    {{ $category->name }}

                </a>

            @endforeach

        </div>

    </div>

</div>
```

</header>

{{-- ========================================================= --}}
{{-- BREAKING NEWS --}}
{{-- ========================================================= --}}

@if($breakingNews->count())

<div class="bg-[#181818] text-white">

```
<div class="page-width px-5 lg:px-10">

    <div class="min-h-[46px] flex items-center gap-4 overflow-hidden">

        <div class="shrink-0 flex items-center gap-2">

            <span class="w-2 h-2 rounded-full bg-[#b08a45]"></span>

            <span class="text-[9px] uppercase tracking-[.25em] font-bold">
                Breaking
            </span>

        </div>

        <div class="h-4 w-px bg-gray-600"></div>

        <div class="flex gap-10 overflow-x-auto whitespace-nowrap">

            @foreach($breakingNews as $breaking)

                <a href="{{ frontend_news_url($breaking->slug) }}"
                   class="text-[11px] text-gray-300 hover:text-[#b08a45] transition">

                    {{ $breaking->title }}

                </a>

            @endforeach

        </div>

    </div>

</div>
```

</div>

@endif

{{-- ========================================================= --}}
{{-- MAIN CONTENT --}}
{{-- ========================================================= --}}

<main class="page-width px-5 lg:px-10 py-8 lg:py-12">

{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

@php
$hero = $featuredNews->first();


$secondaryNews = $featuredNews
    ->skip(1)
    ->take(2);


@endphp

<section class="mb-14">


<div class="grid lg:grid-cols-12 gap-8">

    {{-- HERO IMAGE --}}

    <div class="lg:col-span-8 order-1">

        @if($hero->featured_image)

            <a href="{{ frontend_news_url($hero->slug) }}"
               class="block relative overflow-hidden bg-black hero-image">

                <img
                    src="{{ asset('storage/' . $hero->featured_image) }}"
                    alt="{{ $hero->title }}"
                    class="news-image w-full h-full object-cover absolute inset-0"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>


                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 lg:p-10">

                    <div class="flex items-center gap-3 mb-4">

                        <span class="bg-[#b08a45] text-white px-3 py-1 text-[8px] uppercase tracking-[.2em] font-bold">

                            Featured

                        </span>

                        <span class="text-white/70 text-[9px] uppercase tracking-widest">

                            {{ optional($hero->published_at)->diffForHumans() }}

                        </span>

                    </div>


                    <h1 class="serif headline text-3xl sm:text-5xl lg:text-6xl xl:text-7xl text-white font-bold leading-[1.02] max-w-5xl">

                        {{ $hero->title }}

                    </h1>


                    <p class="hidden sm:block mt-5 text-sm text-gray-200 leading-6 max-w-2xl">

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($hero->description),
                            220
                        ) }}

                    </p>

                </div>

            </a>

        @else

            <div class="hero-image bg-[#222] flex items-end p-8">

                <h1 class="serif text-4xl text-white font-bold">
                    {{ $hero->title }}
                </h1>

            </div>

        @endif

    </div>


    {{-- SECONDARY STORIES --}}

    <div class="lg:col-span-4 order-2 border-t lg:border-t-0 lg:border-l border-[#ded8cc] lg:pl-7">

        <div class="mb-5">

            <div class="text-[9px] uppercase tracking-[.25em] text-[#b08a45] font-bold">
                Editor's Choice
            </div>

            <h2 class="serif text-2xl font-bold mt-1">
                Top Stories
            </h2>

        </div>


        @foreach($secondaryNews as $index => $item)

            <article class="news-card py-5 border-t border-[#ded8cc]">

                @if($item->featured_image)

                    <a href="{{ frontend_news_url($item->slug) }}"
                       class="block aspect-[16/9] overflow-hidden mb-4">

                        <img
                            src="{{ asset('storage/' . $item->featured_image) }}"
                            alt="{{ $item->title }}"
                            class="news-image w-full h-full object-cover"
                        >

                    </a>

                @endif


                <div class="flex gap-3">

                    <div class="serif text-2xl text-[#b08a45]">
                        0{{ $index + 1 }}
                    </div>

                    <div>

                        <div class="text-[8px] uppercase tracking-widest text-gray-500 mb-2">
                            {{ $item->category->name ?? 'News' }}
                        </div>

                        <a href="{{ frontend_news_url($item->slug) }}">

                            <h3 class="serif text-xl font-bold leading-tight gold-hover">
                                {{ $item->title }}
                            </h3>

                        </a>

                        <div class="text-[8px] uppercase tracking-widest text-gray-400 mt-3">
                            {{ optional($item->published_at)->diffForHumans() }}
                        </div>

                    </div>

                </div>

            </article>

        @endforeach

    </div>

</div>


</section>

@endif

{{-- ========================================================= --}}
{{-- CATEGORY BAR --}}
{{-- ========================================================= --}}

<section class="mb-14">


<div class="border-y border-[#ded8cc] py-5">

    <div class="flex items-center gap-5 overflow-x-auto">

        <span class="shrink-0 text-[9px] uppercase tracking-[.25em] font-bold text-[#b08a45]">
            Sections
        </span>

        @foreach($categories->take(10) as $category)

            <a href="{{ frontend_category_url($category->slug) }}"
               class="shrink-0 text-[10px] uppercase tracking-widest text-gray-600 hover:text-[#b08a45] transition">

                {{ $category->name }}

            </a>

        @endforeach

    </div>

</div>


</section>

{{-- ========================================================= --}}
{{-- LATEST NEWS + SIDEBAR --}}
{{-- ========================================================= --}}

<div class="grid lg:grid-cols-12 gap-10">

{{-- ========================================================= --}}
{{-- LATEST NEWS --}}
{{-- ========================================================= --}}

<section class="lg:col-span-8">


<div class="flex items-end justify-between border-b-2 border-[#111] pb-4 mb-7">

    <div>

        <div class="text-[9px] uppercase tracking-[.25em] text-[#b08a45] font-bold">
            Newsroom
        </div>

        <h2 class="serif text-3xl sm:text-4xl font-bold">
            Latest News
        </h2>

    </div>

    <div class="hidden sm:block text-[9px] uppercase tracking-widest text-gray-500">
        {{ $latestNews->total() }} Stories
    </div>

</div>


@forelse($latestNews->take(8) as $index => $item)

    <article class="news-card grid sm:grid-cols-12 gap-5 py-6 border-b border-[#ded8cc]">

        {{-- IMAGE --}}

        @if($item->featured_image)

            <a href="{{ frontend_news_url($item->slug) }}"
               class="sm:col-span-4 block aspect-[16/10] overflow-hidden bg-gray-200">

                <img
                    src="{{ asset('storage/' . $item->featured_image) }}"
                    alt="{{ $item->title }}"
                    class="news-image w-full h-full object-cover"
                >

            </a>

        @else

            <div class="sm:col-span-4 aspect-[16/10] bg-[#e9e3d8] flex items-center justify-center">

                <span class="serif text-4xl text-[#b08a45]">
                    {{ $index + 1 }}
                </span>

            </div>

        @endif


        {{-- CONTENT --}}

        <div class="sm:col-span-8">

            <div class="flex items-center gap-3 mb-3">

                <span class="text-[8px] uppercase tracking-[.2em] font-bold text-[#b08a45]">
                    {{ $item->category->name ?? 'News' }}
                </span>

                <span class="text-gray-300">
                    /
                </span>

                <span class="text-[8px] uppercase tracking-widest text-gray-400">
                    {{ optional($item->published_at)->diffForHumans() }}
                </span>

            </div>


            <a href="{{ frontend_news_url($item->slug) }}">

                <h3 class="serif text-2xl sm:text-3xl font-bold leading-tight gold-hover">

                    {{ $item->title }}

                </h3>

            </a>


            <p class="text-sm text-gray-600 leading-6 mt-3 max-w-2xl">

                {{ \Illuminate\Support\Str::limit(
                    strip_tags($item->description),
                    150
                ) }}

            </p>


            <a href="{{ frontend_news_url($item->slug) }}"
               class="inline-block mt-4 text-[9px] uppercase tracking-[.2em] font-bold text-[#80622f] hover:text-black">

                Read Full Story →

            </a>

        </div>

    </article>

@empty

    <div class="py-20 text-center border border-[#ded8cc]">

        <div class="serif text-3xl">
            No News
        </div>

        <p class="text-sm text-gray-500 mt-2">
            No published news available.
        </p>

    </div>

@endforelse


{{-- PAGINATION --}}

@if($latestNews->hasPages())

    <div class="mt-8">

        {{ $latestNews->links() }}

    </div>

@endif


</section>

{{-- ========================================================= --}}
{{-- SIDEBAR --}}
{{-- ========================================================= --}}

<aside class="lg:col-span-4">

{{-- MOST READ --}}

<section class="bg-[#111] text-white p-6 sm:p-7">

```
<div class="flex items-center justify-between border-b border-gray-700 pb-4">

    <div>

        <div class="text-[8px] uppercase tracking-[.25em] text-[#b08a45]">
            Trending
        </div>

        <h2 class="serif text-2xl font-bold mt-1">
            Most Read
        </h2>

    </div>

    <div class="text-[#b08a45] text-xl">
        ✦
    </div>

</div>


@foreach($latestNews->take(6) as $index => $item)

    <a href="{{ frontend_news_url($item->slug) }}"
       class="flex gap-4 py-5 border-b border-gray-700 last:border-0 group">

        <div class="number-story text-3xl text-[#b08a45] leading-none">
            {{ sprintf('%02d', $index + 1) }}
        </div>

        <div>

            <div class="text-[8px] uppercase tracking-widest text-gray-500 mb-2">
                {{ $item->category->name ?? 'News' }}
            </div>

            <h3 class="serif text-lg font-bold leading-tight group-hover:text-[#b08a45] transition">
                {{ $item->title }}
            </h3>

        </div>

    </a>

@endforeach


</section>

{{-- CATEGORIES --}}

<section class="mt-8 border-t-2 border-[#111] pt-5">

```
<div class="text-[9px] uppercase tracking-[.25em] text-[#b08a45] font-bold">
    Explore
</div>

<h2 class="serif text-2xl font-bold mt-1 mb-5">
    Categories
</h2>


<div>

    @foreach($categories->take(10) as $category)

        <a href="{{ frontend_category_url($category->slug) }}"
           class="flex items-center justify-between py-3 border-b border-[#ded8cc] text-sm hover:text-[#b08a45] transition">

            <span>
                {{ $category->name }}
            </span>

            <span>
                →
            </span>

        </a>

    @endforeach

</div>
```

</section>

{{-- ABOUT --}}

<section class="mt-8 bg-[#e9e3d8] p-6">

```
<div class="text-[9px] uppercase tracking-[.25em] text-[#80622f] font-bold">
    About
</div>

<h2 class="serif text-2xl font-bold mt-2">
    {{ $website->name }}
</h2>

<p class="text-sm leading-6 text-gray-600 mt-3">

    {{ $setting->meta_description
        ?? 'Independent journalism, trusted reporting and stories that matter.' }}

</p>
```

</section>

</aside>

</div>

</main>

{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#111] text-white mt-12">

```
<div class="page-width px-5 lg:px-10 py-12">


    <div class="grid md:grid-cols-4 gap-10">


        {{-- BRAND --}}

        <div class="md:col-span-2">

            <div class="serif text-3xl font-bold">
                {{ $website->name }}
            </div>

            <div class="w-16 h-px bg-[#b08a45] mt-4"></div>

            <p class="text-sm text-gray-400 leading-6 max-w-md mt-5">

                {{ $setting->meta_description
                    ?? 'Independent journalism, latest news and stories that matter.' }}

            </p>

        </div>


        {{-- CATEGORIES --}}

        <div>

            <h3 class="text-[9px] uppercase tracking-[.25em] text-[#b08a45] font-bold mb-5">
                Sections
            </h3>

            <div class="space-y-3">

                @foreach($categories->take(7) as $category)

                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="block text-xs text-gray-400 hover:text-white transition">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>

        </div>


        {{-- CONTACT --}}

        <div>

            <h3 class="text-[9px] uppercase tracking-[.25em] text-[#b08a45] font-bold mb-5">
                Contact
            </h3>

            @if($setting?->email)

                <a href="mailto:{{ $setting->email }}"
                   class="block text-xs text-gray-400 hover:text-white break-all">

                    {{ $setting->email }}

                </a>

            @endif

            @if($setting?->phone)

                <div class="text-xs text-gray-400 mt-3">
                    {{ $setting->phone }}
                </div>

            @endif

        </div>

    </div>


    <div class="border-t border-gray-800 mt-10 pt-5 flex flex-col sm:flex-row justify-between gap-3">

        <span class="text-[8px] uppercase tracking-[.2em] text-gray-500">

            © {{ date('Y') }} {{ $website->name }}

        </span>

        <span class="text-[8px] uppercase tracking-[.2em] text-gray-500">

            Powered by NewsHub CMS

        </span>

    </div>

</div>


</footer>

</body>
</html>
