<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }}</title>

    <meta name="description"
          content="{{ $setting->meta_description ?? 'Latest news and breaking news.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    fontFamily: {

                        classic: [
                            'Arial',
                            'Helvetica',
                            'sans-serif'
                        ]

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

            background: #080808;

            color: #222;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

        }


        /* =====================================================
           MAIN SITE WRAPPER
        ===================================================== */

        .classic-wrapper {

            width: 100%;

            max-width: 1180px;

            margin: 0 auto;

            background: #fff;

            min-height: 100vh;

        }


        /* =====================================================
           HEADER
        ===================================================== */

        .classic-header {

            background: #050505;

            color: white;

        }


        .logo-text {

            letter-spacing: -1px;

        }


        .top-nav {

            border-top: 1px solid #292929;

        }


        .top-nav a {

            transition: .2s ease;

        }


        .top-nav a:hover {

            background: #222;

            color: #fff;

        }


        /* =====================================================
           BREAKING
        ===================================================== */

        .breaking-scroll {

            overflow-x: auto;

            white-space: nowrap;

        }


        .breaking-scroll::-webkit-scrollbar {

            display: none;

        }


        /* =====================================================
           HERO
        ===================================================== */

        .hero-image {

            transition: transform .4s ease;

        }


        .hero-box:hover .hero-image {

            transform: scale(1.025);

        }


        .hero-overlay {

            background:
                linear-gradient(
                    to top,
                    rgba(0,0,0,.85),
                    rgba(0,0,0,.05)
                );

        }


        /* =====================================================
           NEWS CARDS
        ===================================================== */

        .news-card {

            transition: .25s ease;

        }


        .news-card:hover {

            background: #f5f5f5;

        }


        .news-card img {

            transition: transform .35s ease;

        }


        .news-card:hover img {

            transform: scale(1.04);

        }


        /* =====================================================
           SECTION
        ===================================================== */

        .section-title {

            position: relative;

            padding-left: 12px;

        }


        .section-title::before {

            content: "";

            position: absolute;

            left: 0;

            top: 3px;

            bottom: 3px;

            width: 4px;

            background: #111;

        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar-title {

            border-bottom: 3px solid #111;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 767px) {

            .classic-wrapper {

                width: 100%;

            }

            .logo-text {

                font-size: 28px;

            }

        }

    </style>

</head>


<body>


<div class="classic-wrapper">


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<header class="classic-header">


    {{-- TOP BLACK AREA --}}

    <div class="px-5 sm:px-8">


        <div class="h-[72px]
                    flex items-center
                    justify-between">


            {{-- LEFT --}}

            <div class="hidden sm:block">

                <span class="text-[9px]
                             uppercase
                             tracking-[.25em]
                             text-gray-500">

                    Independent News

                </span>

            </div>


            {{-- LOGO --}}

            <a href="{{ frontend_home_url() }}"
               class="text-center">


                <div class="logo-text
                            text-3xl
                            sm:text-4xl
                            font-black
                            uppercase
                            text-white">

                    {{ $website->name }}

                </div>


                <div class="text-[8px]
                            uppercase
                            tracking-[.35em]
                            text-gray-500
                            mt-1">

                    News • Information • Stories

                </div>


            </a>


            {{-- RIGHT --}}

            <div class="hidden sm:block
                        text-right">


                <div class="text-[9px]
                            uppercase
                            tracking-widest
                            text-gray-500">

                    {{ now()->format('d M Y') }}

                </div>


                <div class="text-[9px]
                            text-gray-600
                            mt-1">

                    {{ now()->format('l') }}

                </div>

            </div>


        </div>


    </div>


    {{-- NAVIGATION --}}

    <nav class="top-nav">


        <div class="flex
                    items-center
                    justify-center
                    overflow-x-auto
                    whitespace-nowrap">


            <a href="{{ frontend_home_url() }}"
               class="px-5
                      py-3
                      text-[10px]
                      uppercase
                      tracking-wider
                      font-bold
                      bg-white
                      text-black">

                Home

            </a>


            @foreach($categories->take(8) as $category)


                <a href="{{ frontend_category_url($category->slug) }}"
                   class="px-5
                          py-3
                          text-[10px]
                          uppercase
                          tracking-wider
                          text-gray-400">

                    {{ $category->name }}

                </a>


            @endforeach


            <a href="{{ route('frontend.themes', [
                'websiteSlug' => $website->slug
            ]) }}"
               class="px-5
                      py-3
                      text-[10px]
                      uppercase
                      tracking-wider
                      text-gray-400">

                Themes

            </a>


        </div>


    </nav>


</header>



{{-- ========================================================= --}}
{{-- BREAKING NEWS --}}
{{-- ========================================================= --}}

@if($breakingNews->count())


<div class="bg-[#eeeeee]
            border-b
            border-gray-300">


    <div class="flex
                items-center">


        <div class="shrink-0
                    bg-[#111]
                    text-white
                    px-4
                    py-3
                    text-[9px]
                    uppercase
                    tracking-widest
                    font-bold">

            Breaking

        </div>


        <div class="breaking-scroll
                    px-5
                    py-3
                    flex-1">


            <div class="inline-flex
                        items-center
                        gap-10">


                @foreach($breakingNews as $breaking)


                    <a href="{{ frontend_news_url($breaking->slug) }}"
                       class="text-[11px]
                              font-semibold
                              hover:underline">

                        {{ $breaking->title }}

                    </a>


                @endforeach


            </div>


        </div>


    </div>


</div>

@endif



{{-- ========================================================= --}}
{{-- MAIN CONTENT --}}
{{-- ========================================================= --}}

<main class="px-5
             sm:px-7
             lg:px-9
             py-8">



{{-- ========================================================= --}}
{{-- HERO AREA --}}
{{-- ========================================================= --}}

@if($featuredNews->count())


@php

    $hero = $featuredNews->first();

    $sideStories = $featuredNews
        ->skip(1)
        ->take(3);

@endphp


<section class="grid
                lg:grid-cols-12
                gap-5
                pb-7
                border-b
                border-gray-300">


    {{-- =====================================================
       MAIN HERO
    ===================================================== --}}

    <article class="hero-box
                    lg:col-span-8
                    relative
                    overflow-hidden
                    bg-black">


        @if($hero->featured_image)


            <div class="relative
                        aspect-[16/9]
                        overflow-hidden">


                <img src="{{ asset(
                    'storage/' .
                    $hero->featured_image
                ) }}"
                     alt="{{ $hero->title }}"
                     class="hero-image
                            absolute
                            inset-0
                            w-full
                            h-full
                            object-cover">


                <div class="absolute
                            inset-0
                            hero-overlay">
                </div>


                <div class="absolute
                            left-0
                            right-0
                            bottom-0
                            p-5
                            sm:p-7">


                    <div class="text-[9px]
                                uppercase
                                tracking-widest
                                text-white/70
                                mb-2">

                        {{ $hero->category->name ?? 'News' }}

                    </div>


                    <a href="{{ frontend_news_url($hero->slug) }}">


                        <h1 class="text-2xl
                                   sm:text-3xl
                                   lg:text-4xl
                                   leading-tight
                                   font-black
                                   text-white
                                   hover:underline">

                            {{ $hero->title }}

                        </h1>


                    </a>


                    <div class="flex
                                items-center
                                gap-3
                                mt-3">


                        <span class="text-[9px]
                                     uppercase
                                     tracking-widest
                                     text-gray-300">

                            {{ optional(
                                $hero->published_at
                            )->diffForHumans() }}

                        </span>


                        <span class="text-gray-500">
                            |
                        </span>


                        <span class="text-[9px]
                                     text-gray-300">

                            Featured

                        </span>


                    </div>


                </div>


            </div>


        @else


            <div class="aspect-[16/9]
                        bg-gray-200
                        flex
                        items-center
                        justify-center">


                <span class="text-gray-500
                             text-sm">

                    No featured image

                </span>


            </div>


        @endif


    </article>



    {{-- =====================================================
       RIGHT STORIES
    ===================================================== --}}

    <div class="lg:col-span-4
                grid
                sm:grid-cols-3
                lg:grid-cols-1
                gap-4">


        @foreach($sideStories as $item)


            <article class="grid
                            grid-cols-2
                            lg:grid-cols-2
                            gap-3
                            pb-4
                            border-b
                            border-gray-200
                            last:border-0">


                @if($item->featured_image)


                    <div class="aspect-[4/3]
                                overflow-hidden
                                bg-gray-100">


                        <img src="{{ asset(
                            'storage/' .
                            $item->featured_image
                        ) }}"
                             alt="{{ $item->title }}"
                             class="w-full
                                    h-full
                                    object-cover">


                    </div>


                @else


                    <div class="aspect-[4/3]
                                bg-gray-100">
                    </div>


                @endif


                <div>


                    <div class="text-[8px]
                                uppercase
                                tracking-widest
                                text-gray-500
                                mb-1">

                        {{ $item->category->name ?? 'News' }}

                    </div>


                    <a href="{{ frontend_news_url($item->slug) }}">


                        <h2 class="text-sm
                                   font-black
                                   leading-snug
                                   hover:underline">

                            {{ $item->title }}

                        </h2>


                    </a>


                    <div class="text-[8px]
                                text-gray-400
                                mt-2">

                        {{ optional(
                            $item->published_at
                        )->diffForHumans() }}

                    </div>


                </div>


            </article>


        @endforeach


    </div>


</section>


@endif



{{-- ========================================================= --}}
{{-- FEATURED SMALL CARDS --}}
{{-- ========================================================= --}}

@if($featuredNews->count())


<section class="py-7
                border-b
                border-gray-300">


    <div class="section-title
                mb-5">


        <h2 class="text-lg
                   uppercase
                   tracking-wide
                   font-black">

            Featured Stories

        </h2>


    </div>


    <div class="grid
                grid-cols-1
                sm:grid-cols-3
                gap-5">


        @foreach($featuredNews->take(3) as $item)


            <article class="news-card">


                @if($item->featured_image)


                    <div class="aspect-[16/9]
                                overflow-hidden
                                bg-gray-100">


                        <img src="{{ asset(
                            'storage/' .
                            $item->featured_image
                        ) }}"
                             alt="{{ $item->title }}"
                             class="w-full
                                    h-full
                                    object-cover">


                    </div>


                @endif


                <div class="pt-3">


                    <div class="text-[8px]
                                uppercase
                                tracking-widest
                                text-gray-500
                                mb-2">

                        {{ $item->category->name ?? 'News' }}

                    </div>


                    <a href="{{ frontend_news_url($item->slug) }}">


                        <h3 class="text-base
                                   font-black
                                   leading-tight
                                   hover:underline">

                            {{ $item->title }}

                        </h3>


                    </a>


                </div>


            </article>


        @endforeach


    </div>


</section>

@endif



{{-- ========================================================= --}}
{{-- NEWS + SIDEBAR --}}
{{-- ========================================================= --}}

<div class="grid
            lg:grid-cols-12
            gap-8
            pt-8">



{{-- ========================================================= --}}
{{-- LATEST NEWS --}}
{{-- ========================================================= --}}

<section class="lg:col-span-8">


    <div class="section-title
                border-b
                border-gray-200
                pb-3
                mb-2">


        <h2 class="text-lg
                   uppercase
                   tracking-wide
                   font-black">

            Latest News

        </h2>


    </div>



    @forelse($latestNews as $item)


        <article class="news-card
                        grid
                        sm:grid-cols-12
                        gap-5
                        py-5
                        border-b
                        border-gray-200">


            {{-- IMAGE --}}

            @if($item->featured_image)


                <div class="sm:col-span-4">


                    <div class="aspect-[4/3]
                                overflow-hidden
                                bg-gray-100">


                        <img src="{{ asset(
                            'storage/' .
                            $item->featured_image
                        ) }}"
                             alt="{{ $item->title }}"
                             class="w-full
                                    h-full
                                    object-cover">


                    </div>


                </div>


            @endif



            {{-- CONTENT --}}

            <div class="{{ $item->featured_image
                ? 'sm:col-span-8'
                : 'sm:col-span-12' }}">


                <div class="flex
                            items-center
                            gap-2
                            text-[8px]
                            uppercase
                            tracking-widest
                            text-gray-500
                            mb-2">


                    <span class="font-bold">

                        {{ $item->category->name ?? 'News' }}

                    </span>


                    <span>
                        •
                    </span>


                    <span>

                        {{ optional(
                            $item->published_at
                        )->diffForHumans() }}

                    </span>


                </div>


                <a href="{{ frontend_news_url($item->slug) }}">


                    <h3 class="text-xl
                               sm:text-2xl
                               font-black
                               leading-tight
                               hover:underline">

                        {{ $item->title }}

                    </h3>


                </a>


                <p class="text-sm
                          text-gray-500
                          leading-6
                          mt-3">


                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($item->description),
                        150
                    ) }}


                </p>


                <a href="{{ frontend_news_url($item->slug) }}"
                   class="inline-block
                          mt-3
                          text-[9px]
                          uppercase
                          tracking-widest
                          font-bold
                          hover:underline">

                    Read Story →

                </a>


            </div>


        </article>


    @empty


        <div class="py-16
                    text-center
                    border-b
                    border-gray-200">


            <div class="text-3xl">
                📰
            </div>


            <h3 class="font-bold
                       mt-3">

                No published news available.

            </h3>


        </div>


    @endforelse



    {{-- PAGINATION --}}

    @if($latestNews->hasPages())


        <div class="pt-6">


            {{ $latestNews->links() }}


        </div>


    @endif


</section>



{{-- ========================================================= --}}
{{-- SIDEBAR --}}
{{-- ========================================================= --}}

<aside class="lg:col-span-4">



    {{-- POPULAR --}}

    <section>


        <div class="sidebar-title
                    pb-2
                    mb-1">


            <h2 class="text-sm
                       uppercase
                       tracking-wide
                       font-black">

                Popular News

            </h2>


        </div>


        @foreach($latestNews->take(5) as $index => $item)


            <a href="{{ frontend_news_url($item->slug) }}"
               class="flex
                      gap-3
                      py-4
                      border-b
                      border-gray-200
                      group">


                <div class="text-2xl
                            font-black
                            text-gray-300
                            w-7
                            shrink-0">

                    {{ str_pad(
                        $index + 1,
                        2,
                        '0',
                        STR_PAD_LEFT
                    ) }}

                </div>


                <div>


                    <div class="text-[8px]
                                uppercase
                                tracking-widest
                                text-gray-500
                                mb-1">

                        {{ $item->category->name ?? 'News' }}

                    </div>


                    <h3 class="text-sm
                               font-bold
                               leading-snug
                               group-hover:underline">

                        {{ $item->title }}

                    </h3>


                    <div class="text-[8px]
                                text-gray-400
                                mt-2">

                        {{ optional(
                            $item->published_at
                        )->diffForHumans() }}

                    </div>


                </div>


            </a>


        @endforeach


    </section>



    {{-- CATEGORIES --}}

    <section class="mt-8">


        <div class="sidebar-title
                    pb-2
                    mb-4">


            <h2 class="text-sm
                       uppercase
                       tracking-wide
                       font-black">

                Categories

            </h2>


        </div>


        <div class="grid
                    grid-cols-2
                    gap-0
                    border-t
                    border-l
                    border-gray-200">


            @foreach($categories->take(10) as $category)


                <a href="{{ frontend_category_url($category->slug) }}"
                   class="border-r
                          border-b
                          border-gray-200
                          px-3
                          py-3
                          text-[9px]
                          uppercase
                          tracking-wider
                          font-bold
                          hover:bg-black
                          hover:text-white
                          transition">


                    {{ $category->name }}


                </a>


            @endforeach


        </div>


    </section>



    {{-- NEWSLETTER --}}

    <section class="mt-8
                    bg-[#111]
                    text-white
                    p-6">


        <div class="text-[9px]
                    uppercase
                    tracking-[.2em]
                    text-gray-500">

            Newsletter

        </div>


        <h2 class="text-xl
                   font-black
                   mt-3
                   leading-tight">

            Get the latest
            stories.

        </h2>


        <p class="text-xs
                  leading-5
                  text-gray-400
                  mt-3">

            Subscribe for the latest
            news and important stories.

        </p>


        <form class="mt-5">


            <input type="email"
                   placeholder="Email address"
                   class="w-full
                          bg-white
                          text-black
                          px-3
                          py-3
                          text-xs
                          outline-none">


            <button type="button"
                    class="w-full
                           mt-2
                           bg-white
                           text-black
                           py-3
                           text-[9px]
                           uppercase
                           tracking-widest
                           font-black
                           hover:bg-gray-200
                           transition">

                Subscribe

            </button>


        </form>


    </section>


</aside>


</div>


</main>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#050505]
               text-gray-400">


    <div class="max-w-[1180px]
                mx-auto
                px-5
                py-10">


        <div class="grid
                    md:grid-cols-3
                    gap-8">


            {{-- BRAND --}}

            <div>


                <div class="text-xl
                            font-black
                            text-white
                            uppercase">

                    {{ $website->name }}

                </div>


                <p class="text-xs
                          leading-6
                          text-gray-600
                          mt-3
                          max-w-sm">

                    Independent journalism,
                    breaking news and stories
                    that matter.

                </p>


            </div>



            {{-- CATEGORIES --}}

            <div>


                <h3 class="text-[9px]
                           uppercase
                           tracking-[.2em]
                           font-bold
                           text-white
                           mb-4">

                    Categories

                </h3>


                <div class="grid
                            grid-cols-2
                            gap-2">


                    @foreach($categories->take(8) as $category)


                        <a href="{{ frontend_category_url($category->slug) }}"
                           class="text-xs
                                  text-gray-600
                                  hover:text-white">

                            {{ $category->name }}

                        </a>


                    @endforeach


                </div>


            </div>



            {{-- CONTACT --}}

            <div>


                <h3 class="text-[9px]
                           uppercase
                           tracking-[.2em]
                           font-bold
                           text-white
                           mb-4">

                    Contact

                </h3>


                @if($setting?->email)


                    <a href="mailto:{{ $setting->email }}"
                       class="block
                              text-xs
                              text-gray-600
                              hover:text-white
                              break-all">

                        {{ $setting->email }}

                    </a>


                @endif


                @if($setting?->phone)


                    <div class="text-xs
                                text-gray-600
                                mt-3">

                        {{ $setting->phone }}

                    </div>


                @endif


            </div>


        </div>



        <div class="border-t
                    border-gray-900
                    mt-8
                    pt-5
                    flex
                    flex-col
                    sm:flex-row
                    justify-between
                    gap-2">


            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-gray-700">

                © {{ date('Y') }}
                {{ $website->name }}

            </span>


            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-gray-700">

                Powered by NewsHub CMS

            </span>


        </div>


    </div>


</footer>


</div>


</body>

</html>