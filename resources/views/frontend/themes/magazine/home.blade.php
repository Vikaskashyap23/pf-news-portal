
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }}</title>

    <meta name="description"
          content="{{ $setting->meta_description ?? 'Latest news and magazine stories.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        magazine: ['Arial', 'Helvetica', 'sans-serif']
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
            background: #ffffff;
            color: #202020;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container-news {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        /* MAIN MAGAZINE GRADIENT */

        .mag-gradient {
            background:
                linear-gradient(
                    90deg,
                    #f83f78 0%,
                    #ff4b68 35%,
                    #ff6348 68%,
                    #ff7a36 100%
                );
        }

        /* HERO */

        .hero-image {
            transition: transform .5s ease;
        }

        .hero-card:hover .hero-image {
            transform: scale(1.05);
        }

        .image-overlay {
            background:
                linear-gradient(
                    to top,
                    rgba(0,0,0,.88) 0%,
                    rgba(0,0,0,.48) 42%,
                    rgba(0,0,0,.04) 100%
                );
        }

        /* CARD HOVER */

        .mag-card {
            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }

        .mag-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0,0,0,.10);
        }

        /* SECTION LINE */

        .section-title {
            position: relative;
            border-bottom: 1px solid #e9e9e9;
        }

        .section-title::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 42px;
            height: 4px;
            border-radius: 4px 4px 0 0;
            background: linear-gradient(
                90deg,
                #f83f78,
                #ff7038
            );
        }

        /* COLORS */

        .pink {
            background: linear-gradient(135deg, #f43f75, #ff5272);
        }

        .orange {
            background: linear-gradient(135deg, #ff542f, #ff7b28);
        }

        .purple {
            background: linear-gradient(135deg, #7028d8, #a43be7);
        }

        .blue {
            background: linear-gradient(135deg, #2563eb, #08a8d8);
        }

        .teal {
            background: linear-gradient(135deg, #0ea5a4, #1677c8);
        }

        .yellow {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
        }

        /* NAV */

        .nav-item {
            transition: .2s ease;
        }

        .nav-item:hover {
            background: rgba(255,255,255,.16);
        }

        /* SCROLL */

        .hide-scroll::-webkit-scrollbar {
            display: none;
        }

        .hide-scroll {
            scrollbar-width: none;
        }

        /* IMAGE */

        .object-cover {
            object-fit: cover;
        }

        /* MOBILE */

        @media(max-width: 640px) {

            .container-news {
                width: calc(100% - 22px);
            }

        }

    </style>

</head>


<body class="bg-white">


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<header class="bg-white">

    <div class="container-news">

        <div class="min-h-[88px]
                    flex
                    items-center
                    justify-between
                    gap-6">

            {{-- LOGO --}}

            <a href="{{ frontend_home_url() }}"
               class="shrink-0">

                <div class="text-3xl
                            sm:text-4xl
                            font-black
                            uppercase
                            tracking-[-2px]">

                    {{ $website->name }}

                </div>

                <div class="text-[8px]
                            uppercase
                            tracking-[.35em]
                            text-gray-400
                            mt-1">

                    Magazine • News • Lifestyle

                </div>

            </a>


            {{-- ADVERTISEMENT --}}

            <div class="hidden md:flex
                        w-[500px]
                        h-[64px]
                        border
                        border-gray-100
                        bg-[#fffaf8]
                        items-center
                        justify-between
                        px-6">

                <div>

                    <div class="text-sm
                                font-bold
                                text-[#f04d69]">

                        Simple Responsive Magazine

                    </div>

                    <div class="text-[10px]
                                text-gray-400
                                mt-1">

                        Modern News & Magazine Theme

                    </div>

                </div>

                <div class="text-center">

                    <div class="text-[10px]
                                font-black
                                text-gray-800">

                        ADS

                    </div>

                    <div class="text-[8px]
                                text-gray-400">

                        630 × 90 px

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- COLORFUL NAVBAR --}}
    {{-- ================================================= --}}

    <nav class="mag-gradient text-white">

        <div class="container-news">

            <div class="flex
                        items-stretch
                        overflow-x-auto
                        hide-scroll
                        whitespace-nowrap">

                {{-- HOME --}}

                <a href="{{ frontend_home_url() }}"
                   class="nav-item
                          px-5
                          py-4
                          text-[10px]
                          uppercase
                          font-black">

                    HOME

                </a>


                {{-- CATEGORIES --}}

                @foreach($categories->take(7) as $category)

                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="nav-item
                              px-5
                              py-4
                              text-[10px]
                              uppercase
                              font-black">

                        {{ $category->name }}

                    </a>

                @endforeach




                <div class="ml-auto
                            hidden lg:flex
                            items-center">

                    <span class="px-4 opacity-80 text-xs">
                        f
                    </span>

                    <span class="px-4 opacity-80 text-xs">
                        t
                    </span>

                    <span class="px-4 opacity-80 text-xs">
                        ◎
                    </span>

                    <span class="px-5
                                 h-full
                                 flex
                                 items-center
                                 bg-black/10">

                        🔍

                    </span>

                </div>

            </div>

        </div>

    </nav>

</header>



{{-- ========================================================= --}}
{{-- BREAKING NEWS --}}
{{-- ========================================================= --}}

@if($breakingNews->count())

<section class="bg-[#fff7f5]
                border-b
                border-[#ffe5dd]">

    <div class="container-news
                flex
                items-center">

        <div class="shrink-0
                    bg-[#ff5b38]
                    text-white
                    px-5
                    py-3
                    text-[9px]
                    uppercase
                    font-black
                    tracking-widest">

            BREAKING

        </div>


        <div class="flex-1
                    overflow-x-auto
                    hide-scroll
                    whitespace-nowrap
                    px-5">

            <div class="inline-flex gap-10">

                @foreach($breakingNews as $breaking)

                    <a href="{{ frontend_news_url($breaking->slug) }}"
                       class="text-[11px]
                              text-gray-600
                              hover:text-[#f43f75]">

                        {{ $breaking->title }}

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endif



{{-- ========================================================= --}}
{{-- MAIN --}}
{{-- ========================================================= --}}

<main class="container-news py-8">



{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

@php

    $hero = $featuredNews->first();
    $sideStories = $featuredNews->skip(1)->take(2);

@endphp


<section class="grid
                lg:grid-cols-12
                gap-2
                mb-12">


    {{-- ================================================= --}}
    {{-- BIG HERO --}}
    {{-- ================================================= --}}

    <article class="hero-card
                    relative
                    overflow-hidden
                    lg:col-span-8
                    h-[380px]
                    sm:h-[450px]
                    lg:h-[510px]
                    bg-gray-100">

        @if($hero->featured_image)

            <img src="{{ asset('storage/' . $hero->featured_image) }}"
                 alt="{{ $hero->title }}"
                 class="hero-image
                        absolute
                        inset-0
                        w-full
                        h-full
                        object-cover">

        @endif


        <div class="image-overlay
                    absolute
                    inset-0">
        </div>


        {{-- COLOR LINE --}}

        <div class="absolute
                    left-5
                    top-1/2
                    -translate-y-1/2
                    flex
                    flex-col
                    gap-2">

            <span class="w-2 h-8 bg-[#ff3f7f]"></span>

            <span class="w-2 h-8 bg-[#7434db]"></span>

            <span class="w-2 h-8 bg-[#2d70e7]"></span>

            <span class="w-2 h-8 bg-[#ff7138]"></span>

        </div>


        <div class="absolute
                    left-0
                    right-0
                    bottom-0
                    p-6
                    sm:p-8
                    lg:p-10">

            <span class="inline-block
                         bg-[#ef3d83]
                         text-white
                         px-3
                         py-1
                         text-[8px]
                         uppercase
                         font-black
                         tracking-wider
                         mb-4">

                {{ $hero->category->name ?? 'News' }}

            </span>


            <a href="{{ frontend_news_url($hero->slug) }}">

                <h1 class="text-white
                           text-3xl
                           sm:text-4xl
                           lg:text-[44px]
                           leading-[1.05]
                           font-black
                           max-w-3xl">

                    {{ $hero->title }}

                </h1>

            </a>


            <div class="flex
                        flex-wrap
                        gap-4
                        mt-4
                        text-[9px]
                        text-white/80">

                <span>
                    ● {{ $website->name }}
                </span>

                <span>
                    ◷ {{ optional($hero->published_at)->format('M d, Y') }}
                </span>

                <span>
                    ♡ {{ $hero->id }}
                </span>

            </div>

        </div>

    </article>



    {{-- ================================================= --}}
    {{-- RIGHT SIDE --}}
    {{-- ================================================= --}}

    <div class="lg:col-span-4
                grid
                sm:grid-cols-2
                lg:grid-cols-1
                gap-2">


        @foreach($sideStories as $index => $item)


            @if($index == 0)

                {{-- IMAGE STORY --}}

                <article class="mag-card
                                relative
                                overflow-hidden
                                min-h-[250px]
                                bg-gray-100">

                    @if($item->featured_image)

                        <img src="{{ asset('storage/' . $item->featured_image) }}"
                             alt="{{ $item->title }}"
                             class="absolute
                                    inset-0
                                    w-full
                                    h-full
                                    object-cover">

                    @endif


                    <div class="image-overlay
                                absolute
                                inset-0">
                    </div>


                    <div class="absolute
                                bottom-0
                                left-0
                                right-0
                                p-5">

                        <span class="inline-block
                                     purple
                                     text-white
                                     px-2
                                     py-1
                                     text-[7px]
                                     uppercase
                                     font-black
                                     mb-3">

                            {{ $item->category->name ?? 'Lifestyle' }}

                        </span>


                        <a href="{{ frontend_news_url($item->slug) }}">

                            <h2 class="text-white
                                       text-xl
                                       font-black
                                       leading-tight">

                                {{ $item->title }}

                            </h2>

                        </a>

                    </div>

                </article>


            @else

                {{-- ORANGE STORY --}}

                <article class="mag-card
                                relative
                                overflow-hidden
                                min-h-[250px]
                                orange
                                p-6
                                flex
                                flex-col
                                justify-end
                                text-white">


                    @if($item->featured_image)

                        <img src="{{ asset('storage/' . $item->featured_image) }}"
                             alt="{{ $item->title }}"
                             class="absolute
                                    inset-0
                                    w-full
                                    h-full
                                    object-cover
                                    opacity-20">

                    @endif


                    <div class="relative">

                        <span class="inline-block
                                     purple
                                     px-2
                                     py-1
                                     text-[7px]
                                     uppercase
                                     font-black
                                     mb-4">

                            {{ $item->category->name ?? 'Health' }}

                        </span>


                        <a href="{{ frontend_news_url($item->slug) }}">

                            <h2 class="text-xl
                                       sm:text-2xl
                                       font-black
                                       leading-tight">

                                {{ $item->title }}

                            </h2>

                        </a>


                        <div class="mt-4
                                    flex
                                    gap-4
                                    text-[8px]
                                    text-white/80">

                            <span>
                                {{ $website->name }}
                            </span>

                            <span>
                                {{ optional($item->published_at)->format('M d, Y') }}
                            </span>

                        </div>

                    </div>

                </article>

            @endif


        @endforeach

    </div>

</section>

@endif



{{-- ========================================================= --}}
{{-- WEEKEND TOP --}}
{{-- ========================================================= --}}

<section class="mb-12">

    <div class="section-title
                flex
                items-center
                justify-between
                pb-4
                mb-6">

        <h2 class="text-[12px]
                   uppercase
                   tracking-widest
                   font-black
                   text-[#ff5a32]">

            WEEKEND TOP

        </h2>


        <span class="text-[9px]
                     uppercase
                     tracking-widest
                     text-gray-400">

            Trending Magazine Stories

        </span>

    </div>


    <div class="grid
                grid-cols-1
                sm:grid-cols-2
                lg:grid-cols-4
                gap-5">


        @foreach($featuredNews->take(4) as $index => $item)

            @php

                $colors = [
                    'pink',
                    'purple',
                    'blue',
                    'orange'
                ];

                $color = $colors[$index % 4];

            @endphp


            <article class="mag-card
                            relative
                            overflow-hidden
                            h-[260px]
                            {{ $color }}">

                @if($item->featured_image)

                    <img src="{{ asset('storage/' . $item->featured_image) }}"
                         alt="{{ $item->title }}"
                         class="absolute
                                inset-0
                                w-full
                                h-full
                                object-cover
                                opacity-55">

                @endif


                <div class="absolute
                            inset-0
                            bg-gradient-to-t
                            from-black/80
                            via-black/20
                            to-transparent">
                </div>


                <div class="absolute
                            bottom-0
                            left-0
                            right-0
                            p-5
                            text-white">

                    <span class="inline-block
                                 bg-white/20
                                 backdrop-blur-sm
                                 px-2
                                 py-1
                                 text-[7px]
                                 uppercase
                                 font-black
                                 mb-3">

                        {{ $item->category->name ?? 'News' }}

                    </span>


                    <a href="{{ frontend_news_url($item->slug) }}">

                        <h3 class="text-lg
                                   font-black
                                   leading-tight">

                            {{ $item->title }}

                        </h3>

                    </a>


                    <div class="text-[8px]
                                text-white/70
                                mt-3">

                        {{ optional($item->published_at)->diffForHumans() }}

                    </div>

                </div>

            </article>

        @endforeach

    </div>

</section>



{{-- ========================================================= --}}
{{-- CATEGORY COLOR BOXES --}}
{{-- ========================================================= --}}

<section class="mb-12">

    <div class="grid
                grid-cols-2
                sm:grid-cols-3
                lg:grid-cols-6
                gap-3">


        @foreach($categories->take(6) as $index => $category)

            @php

                $categoryColors = [
                    'pink',
                    'purple',
                    'blue',
                    'orange',
                    'teal',
                    'yellow'
                ];

            @endphp


            <a href="{{ frontend_category_url($category->slug) }}"
               class="{{ $categoryColors[$index % 6] }}
                      text-white
                      min-h-[105px]
                      p-4
                      flex
                      flex-col
                      justify-between
                      hover:-translate-y-1
                      transition">


                <span class="text-2xl
                             font-black
                             opacity-80">

                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                </span>


                <span class="text-[9px]
                             uppercase
                             tracking-wider
                             font-black">

                    {{ $category->name }}

                </span>

            </a>

        @endforeach

    </div>

</section>



{{-- ========================================================= --}}
{{-- CONTENT + SIDEBAR --}}
{{-- ========================================================= --}}

<div class="grid
            lg:grid-cols-12
            gap-9">


    {{-- ================================================= --}}
    {{-- LATEST STORIES --}}
    {{-- ================================================= --}}

    <section class="lg:col-span-8">


        <div class="section-title
                    pb-4
                    mb-2">

            <h2 class="text-xl
                       uppercase
                       font-black">

                Latest Stories

            </h2>

        </div>


        @forelse($latestNews as $index => $item)


            <article class="grid
                            sm:grid-cols-12
                            gap-5
                            py-6
                            border-b
                            border-gray-100">


                @if($item->featured_image)

                    <div class="sm:col-span-4">

                        <div class="aspect-[4/3]
                                    overflow-hidden
                                    bg-gray-100">

                            <img src="{{ asset('storage/' . $item->featured_image) }}"
                                 alt="{{ $item->title }}"
                                 class="w-full
                                        h-full
                                        object-cover
                                        hover:scale-105
                                        transition
                                        duration-500">

                        </div>

                    </div>

                @endif


                <div class="{{ $item->featured_image
                    ? 'sm:col-span-8'
                    : 'sm:col-span-12' }}">


                    @php

                        $badges = [
                            'pink',
                            'orange',
                            'purple',
                            'blue'
                        ];

                    @endphp


                    <div class="flex
                                items-center
                                gap-3
                                mb-3">


                        <span class="{{ $badges[$index % 4] }}
                                     text-white
                                     px-2
                                     py-1
                                     text-[7px]
                                     uppercase
                                     tracking-wider
                                     font-black">

                            {{ $item->category->name ?? 'News' }}

                        </span>


                        <span class="text-[8px]
                                     text-gray-400">

                            {{ optional($item->published_at)->diffForHumans() }}

                        </span>

                    </div>


                    <a href="{{ frontend_news_url($item->slug) }}">

                        <h3 class="text-xl
                                   sm:text-2xl
                                   font-black
                                   leading-tight
                                   hover:text-[#f43f75]
                                   transition">

                            {{ $item->title }}

                        </h3>

                    </a>


                    <p class="text-sm
                              leading-6
                              text-gray-500
                              mt-3">

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($item->description),
                            170
                        ) }}

                    </p>


                    <a href="{{ frontend_news_url($item->slug) }}"
                       class="inline-block
                              mt-4
                              text-[9px]
                              uppercase
                              tracking-widest
                              font-black
                              text-[#ff5a32]">

                        Read More →

                    </a>

                </div>

            </article>


        @empty


            <div class="py-16
                        text-center
                        text-gray-400">

                No published news available.

            </div>


        @endforelse


        @if($latestNews->hasPages())

            <div class="mt-7">

                {{ $latestNews->links() }}

            </div>

        @endif


    </section>



    {{-- ================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ================================================= --}}

    <aside class="lg:col-span-4">


        {{-- POPULAR STORIES --}}

        <section class="mb-9">


            <div class="section-title
                        pb-4
                        mb-2">

                <h2 class="text-sm
                           uppercase
                           tracking-widest
                           font-black">

                    Popular Stories

                </h2>

            </div>


            @foreach($latestNews->take(5) as $index => $item)


                <a href="{{ frontend_news_url($item->slug) }}"
                   class="group
                          flex
                          gap-4
                          py-4
                          border-b
                          border-gray-100">


                    <div class="w-[72px]
                                h-[58px]
                                shrink-0
                                overflow-hidden
                                bg-gray-100">


                        @if($item->featured_image)

                            <img src="{{ asset('storage/' . $item->featured_image) }}"
                                 alt=""
                                 class="w-full
                                        h-full
                                        object-cover
                                        group-hover:scale-110
                                        transition
                                        duration-500">

                        @else

                            <div class="w-full
                                        h-full
                                        {{ ['pink','purple','blue','orange','teal'][$index % 5] }}">
                            </div>

                        @endif

                    </div>


                    <div>

                        <span class="text-[7px]
                                     uppercase
                                     tracking-widest
                                     font-black
                                     text-[#f43f75]">

                            {{ $item->category->name ?? 'News' }}

                        </span>


                        <h3 class="text-sm
                                   font-black
                                   leading-snug
                                   mt-1
                                   group-hover:text-[#ff5a32]
                                   transition">

                            {{ $item->title }}

                        </h3>


                        <div class="text-[8px]
                                    text-gray-400
                                    mt-2">

                            {{ optional($item->published_at)->diffForHumans() }}

                        </div>

                    </div>

                </a>

            @endforeach

        </section>



        {{-- ================================================= --}}
        {{-- TRENDING CARD --}}
        {{-- ================================================= --}}

        @if($latestNews->count())

            @php

                $trend = $latestNews->first();

            @endphp


            <section class="relative
                            overflow-hidden
                            min-h-[300px]
                            purple
                            p-6
                            mb-9
                            text-white">


                @if($trend->featured_image)

                    <img src="{{ asset('storage/' . $trend->featured_image) }}"
                         alt="{{ $trend->title }}"
                         class="absolute
                                inset-0
                                w-full
                                h-full
                                object-cover
                                opacity-30">

                @endif


                <div class="absolute
                            inset-0
                            bg-gradient-to-t
                            from-black/60
                            to-transparent">
                </div>


                <div class="relative
                            min-h-[250px]
                            flex
                            flex-col
                            justify-end">


                    <span class="self-start
                                 orange
                                 px-2
                                 py-1
                                 text-[7px]
                                 uppercase
                                 font-black
                                 mb-3">

                        Trending

                    </span>


                    <h2 class="text-2xl
                               font-black
                               leading-tight">

                        {{ $trend->title }}

                    </h2>


                    <a href="{{ frontend_news_url($trend->slug) }}"
                       class="mt-4
                              text-[9px]
                              uppercase
                              tracking-widest
                              font-black">

                        Read Story →

                    </a>

                </div>

            </section>

        @endif



        {{-- ================================================= --}}
        {{-- CATEGORIES --}}
        {{-- ================================================= --}}

        <section class="mb-9">


            <div class="section-title
                        pb-4
                        mb-4">

                <h2 class="text-sm
                           uppercase
                           tracking-widest
                           font-black">

                    Categories

                </h2>

            </div>


            <div class="grid grid-cols-2 gap-2">


                @foreach($categories->take(10) as $index => $category)

                    @php

                        $categoryColors = [
                            'pink',
                            'orange',
                            'purple',
                            'blue',
                            'teal'
                        ];

                    @endphp


                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="{{ $categoryColors[$index % 5] }}
                              text-white
                              px-4
                              py-3
                              text-[8px]
                              uppercase
                              tracking-wider
                              font-black
                              hover:opacity-90
                              transition">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>

        </section>



        {{-- ================================================= --}}
        {{-- NEWSLETTER --}}
        {{-- ================================================= --}}

        <section class="mag-gradient
                        p-6
                        text-white">


            <div class="text-[8px]
                        uppercase
                        tracking-[.25em]
                        font-black
                        text-white/70">

                Newsletter

            </div>


            <h2 class="text-2xl
                       font-black
                       mt-3">

                Stay Updated

            </h2>


            <p class="text-sm
                      leading-6
                      mt-3
                      text-white/80">

                Get the latest news and magazine stories directly in your inbox.

            </p>


            <form class="mt-5">


                <input type="email"
                       placeholder="Email address"
                       class="w-full
                              bg-white
                              text-gray-900
                              px-4
                              py-3
                              text-sm
                              outline-none">


                <button type="button"
                        class="w-full
                               mt-2
                               bg-[#181818]
                               text-white
                               py-3
                               text-[9px]
                               uppercase
                               tracking-widest
                               font-black
                               hover:bg-black">

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

<footer class="mt-14
               bg-[#181818]
               text-gray-400">


    <div class="container-news
                py-12">


        <div class="grid
                    md:grid-cols-3
                    gap-10">


            {{-- BRAND --}}

            <div>

                <div class="text-2xl
                            uppercase
                            font-black
                            text-white">

                    {{ $website->name }}

                </div>


                <p class="text-xs
                          leading-6
                          text-gray-500
                          mt-4">

                    News, lifestyle, technology and magazine stories.

                </p>

            </div>



            {{-- CATEGORIES --}}

            <div>

                <h3 class="text-[9px]
                           uppercase
                           tracking-widest
                           font-black
                           text-white
                           mb-4">

                    Explore

                </h3>


                <div class="grid
                            grid-cols-2
                            gap-3">


                    @foreach($categories->take(8) as $category)

                        <a href="{{ frontend_category_url($category->slug) }}"
                           class="text-xs
                                  text-gray-500
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
                           tracking-widest
                           font-black
                           text-white
                           mb-4">

                    Contact

                </h3>


                @if($setting?->email)

                    <a href="mailto:{{ $setting->email }}"
                       class="block
                              text-xs
                              text-gray-500
                              hover:text-white
                              break-all">

                        {{ $setting->email }}

                    </a>

                @endif


                @if($setting?->phone)

                    <div class="text-xs
                                text-gray-500
                                mt-3">

                        {{ $setting->phone }}

                    </div>

                @endif

            </div>

        </div>



        <div class="border-t
                    border-gray-800
                    mt-10
                    pt-5
                    flex
                    flex-col
                    sm:flex-row
                    justify-between
                    gap-2">


            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-gray-600">

                © {{ date('Y') }}
                {{ $website->name }}

            </span>


            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-gray-600">

                Powered by NewsHub CMS

            </span>

        </div>

    </div>

</footer>


</body>

</html>

