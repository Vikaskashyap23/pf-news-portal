<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }} | Digital Edge</title>

    <meta name="description"
          content="{{ $setting->meta_description ?? 'Latest technology news, digital trends and breaking news.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Arial', 'Helvetica', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 0 30px rgba(14, 165, 233, .15)',
                        blueglow: '0 0 25px rgba(14, 165, 233, .25)',
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
            font-family: Inter, Arial, Helvetica, sans-serif;
            background: #05080d;
            color: #e5edf7;
        }

        .digital-grid {
            background-image:
                linear-gradient(rgba(30, 144, 255, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(30, 144, 255, 0.035) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .hero-overlay {
            background:
                linear-gradient(
                    90deg,
                    rgba(3, 7, 13, 0.98) 0%,
                    rgba(3, 7, 13, 0.80) 35%,
                    rgba(3, 7, 13, 0.30) 75%,
                    rgba(3, 7, 13, 0.80) 100%
                );
        }

        .hero-bottom {
            background:
                linear-gradient(
                    0deg,
                    rgba(3, 7, 13, 0.98),
                    transparent
                );
        }

        .glass {
            background: rgba(10, 16, 25, 0.72);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .tech-border {
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .blue-border {
            border-color: rgba(14, 165, 233, 0.45);
        }

        .news-card {
            transition: all .3s ease;
        }

        .news-card:hover {
            transform: translateY(-4px);
            border-color: rgba(14, 165, 233, 0.55);
            box-shadow: 0 10px 35px rgba(0, 0, 0, .35);
        }

        .news-card img {
            transition: transform .5s ease;
        }

        .news-card:hover img {
            transform: scale(1.06);
        }

        .hero-image {
            transition: transform .7s ease;
        }

        .hero:hover .hero-image {
            transform: scale(1.03);
        }

        .cyan-line {
            background: linear-gradient(
                90deg,
                #0ea5e9,
                #38bdf8,
                transparent
            );
        }

        .section-title {
            letter-spacing: .08em;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>

</head>


<body class="digital-grid">


{{-- ========================================================= --}}
{{-- TOP TECH BAR --}}
{{-- ========================================================= --}}

<div class="border-b border-slate-800 bg-[#03070d]">

    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-9 flex items-center justify-between gap-4">

            <div class="flex items-center gap-3">

                <span class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_10px_#22d3ee]"></span>

                <span class="text-[10px] uppercase tracking-[.25em] text-slate-400">
                    Digital Intelligence
                </span>

            </div>

            <div class="hidden sm:block text-[10px] uppercase tracking-widest text-slate-500">
                {{ now()->format('l, d F Y') }}
            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<header class="sticky top-0 z-50 border-b border-slate-800 bg-[#05080d]/95 backdrop-blur-xl">

    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-20 flex items-center justify-between gap-8">


            {{-- LOGO --}}

            <a href="{{ frontend_home_url() }}"
               class="flex items-center gap-3 shrink-0">

                <div class="w-10 h-10 rounded-lg
                            bg-gradient-to-br from-cyan-400 to-blue-600
                            flex items-center justify-center
                            text-slate-950 font-black text-xl
                            shadow-[0_0_25px_rgba(14,165,233,.35)]">

                    D

                </div>

                <div>

                    <div class="text-xl sm:text-2xl font-black tracking-tight text-white">
                        {{ $website->name }}
                    </div>

                    <div class="text-[8px] uppercase tracking-[.35em] text-cyan-400">
                        Digital Edge
                    </div>

                </div>

            </a>


            {{-- NAVIGATION --}}

            <nav class="hidden lg:flex items-center gap-1 overflow-hidden">

                <a href="{{ frontend_home_url() }}"
                   class="px-4 py-2 rounded-md
                          text-[11px] uppercase tracking-wider
                          font-bold text-cyan-400
                          bg-cyan-400/10
                          hover:bg-cyan-400/20 transition">

                    Home

                </a>


                @foreach($categories->take(7) as $category)

                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="px-4 py-2 rounded-md
                              text-[11px] uppercase tracking-wider
                              font-semibold text-slate-400
                              hover:text-white
                              hover:bg-white/5
                              transition">

                        {{ $category->name }}

                    </a>

                @endforeach


                {{-- THEME STORE --}}

                <a href="{{ route('frontend.themes', [
                    'websiteSlug' => $website->slug
                ]) }}"
                   class="px-4 py-2 rounded-md
                          text-[11px] uppercase tracking-wider
                          font-bold text-cyan-400
                          hover:bg-cyan-400/10 transition">

                    Themes

                </a>

            </nav>


            {{-- SEARCH / MENU --}}

            <div class="flex items-center gap-2">

                <button class="w-9 h-9 rounded-lg
                               border border-slate-700
                               text-slate-400
                               hover:text-cyan-400
                               hover:border-cyan-400/50
                               transition">

                    <svg class="w-4 h-4 mx-auto"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"/>

                    </svg>

                </button>


                <button class="lg:hidden w-9 h-9 rounded-lg
                               border border-slate-700
                               text-slate-400">

                    <svg class="w-5 h-5 mx-auto"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>

                    </svg>

                </button>

            </div>

        </div>


        {{-- MOBILE NAV --}}

        <div class="lg:hidden flex gap-2 overflow-x-auto scrollbar-hide pb-3">

            <a href="{{ frontend_home_url() }}"
               class="shrink-0 px-4 py-2 rounded-full
                      bg-cyan-500/10 text-cyan-400
                      border border-cyan-500/20
                      text-[10px] uppercase font-bold">

                Home

            </a>

            @foreach($categories->take(8) as $category)

                <a href="{{ frontend_category_url($category->slug) }}"
                   class="shrink-0 px-4 py-2 rounded-full
                          bg-white/[.03]
                          text-slate-400
                          border border-slate-800
                          text-[10px] uppercase font-bold">

                    {{ $category->name }}

                </a>

            @endforeach

        </div>

    </div>

</header>


{{-- ========================================================= --}}
{{-- BREAKING NEWS --}}
{{-- ========================================================= --}}

@if($breakingNews->count())

<div class="border-b border-slate-800 bg-[#080d14]">

    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center min-h-11">

            <div class="shrink-0 flex items-center gap-2
                        bg-cyan-500/10
                        border border-cyan-500/20
                        rounded px-3 py-1.5">

                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400
                             shadow-[0_0_8px_#22d3ee]"></span>

                <span class="text-[9px] font-black
                             uppercase tracking-widest
                             text-cyan-400">

                    Breaking

                </span>

            </div>


            <div class="overflow-x-auto scrollbar-hide">

                <div class="flex items-center gap-10 px-5 whitespace-nowrap">

                    @foreach($breakingNews as $breaking)

                        <a href="{{ frontend_news_url($breaking->slug) }}"
                           class="text-xs text-slate-400
                                  hover:text-cyan-400 transition">

                            {{ $breaking->title }}

                        </a>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>

@endif


{{-- ========================================================= --}}
{{-- MAIN --}}
{{-- ========================================================= --}}

<main class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 py-8">


{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

@php

    $hero = $featuredNews->first();

    $secondaryNews = $featuredNews->skip(1)->take(3);

@endphp


<section class="hero relative overflow-hidden
                rounded-2xl
                border border-slate-800
                bg-[#080d14]
                shadow-2xl
                mb-12">


    {{-- IMAGE --}}

    @if($hero->featured_image)

        <img src="{{ asset('storage/' . $hero->featured_image) }}"
             alt="{{ $hero->title }}"
             class="hero-image absolute inset-0
                    w-full h-full
                    object-cover">

    @else

        <div class="absolute inset-0 bg-gradient-to-br
                    from-slate-900 to-black"></div>

    @endif


    {{-- OVERLAY --}}

    <div class="absolute inset-0 hero-overlay"></div>

    <div class="absolute inset-x-0 bottom-0 h-48 hero-bottom"></div>


    {{-- CONTENT --}}

    <div class="relative min-h-[470px]
                lg:min-h-[520px]
                flex items-end">


        <div class="w-full p-6 sm:p-8 lg:p-12">

            <div class="max-w-3xl">


                {{-- CATEGORY --}}

                <div class="flex items-center gap-3 mb-5">

                    <span class="px-3 py-1
                                 bg-cyan-500
                                 text-slate-950
                                 rounded
                                 text-[9px]
                                 font-black
                                 uppercase
                                 tracking-widest">

                        {{ $hero->category->name ?? 'Technology' }}

                    </span>

                    <span class="text-[10px]
                                 uppercase
                                 tracking-widest
                                 text-slate-400">

                        {{ optional($hero->published_at)->diffForHumans() }}

                    </span>

                </div>


                {{-- TITLE --}}

                <a href="{{ frontend_news_url($hero->slug) }}">

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl
                               font-black
                               leading-[1.05]
                               tracking-tight
                               text-white
                               hover:text-cyan-300
                               transition">

                        {{ $hero->title }}

                    </h1>

                </a>


                {{-- DESCRIPTION --}}

                <p class="mt-5
                          text-sm sm:text-base
                          leading-7
                          text-slate-300
                          max-w-2xl">

                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($hero->description),
                        190
                    ) }}

                </p>


                {{-- BUTTON --}}

                <a href="{{ frontend_news_url($hero->slug) }}"
                   class="inline-flex items-center gap-2
                          mt-6
                          px-5 py-3
                          rounded-lg
                          bg-cyan-500
                          text-slate-950
                          text-[10px]
                          uppercase
                          tracking-widest
                          font-black
                          hover:bg-cyan-300
                          transition">

                    Read More

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 12h14m-5-5 5 5-5 5"/>

                    </svg>

                </a>

            </div>

        </div>

    </div>

</section>

@endif


{{-- ========================================================= --}}
{{-- TRENDING + LATEST --}}
{{-- ========================================================= --}}

<div class="grid lg:grid-cols-12 gap-8">


{{-- ========================================================= --}}
{{-- LEFT CONTENT --}}
{{-- ========================================================= --}}

<section class="lg:col-span-8">


    {{-- SECTION HEADER --}}

    <div class="flex items-center justify-between
                mb-5 pb-3
                border-b border-slate-800">

        <div>

            <div class="flex items-center gap-3">

                <span class="w-1 h-6 bg-cyan-400 rounded-full"></span>

                <h2 class="section-title
                           text-xl sm:text-2xl
                           font-black
                           uppercase
                           text-white">

                    Latest Stories

                </h2>

            </div>

        </div>

        <span class="text-[9px]
                     uppercase
                     tracking-widest
                     text-slate-500">

            Updated Live

        </span>

    </div>


    {{-- LATEST NEWS GRID --}}

    <div class="grid sm:grid-cols-2 gap-5">


        @forelse($latestNews as $item)

            <article class="news-card
                            overflow-hidden
                            rounded-xl
                            bg-[#080d14]
                            tech-border">


                {{-- IMAGE --}}

                @if($item->featured_image)

                    <div class="relative overflow-hidden aspect-[16/9]">

                        <img src="{{ asset('storage/' . $item->featured_image) }}"
                             alt="{{ $item->title }}"
                             class="w-full h-full object-cover">

                        <div class="absolute inset-0
                                    bg-gradient-to-t
                                    from-[#080d14]
                                    via-transparent
                                    to-transparent">
                        </div>

                    </div>

                @endif


                <div class="p-5">


                    <div class="flex items-center gap-2 mb-3">

                        <span class="text-[8px]
                                     uppercase
                                     tracking-widest
                                     font-black
                                     text-cyan-400">

                            {{ $item->category->name ?? 'News' }}

                        </span>

                        <span class="text-slate-700">•</span>

                        <span class="text-[8px]
                                     uppercase
                                     tracking-wider
                                     text-slate-500">

                            {{ optional($item->published_at)->diffForHumans() }}

                        </span>

                    </div>


                    <a href="{{ frontend_news_url($item->slug) }}">

                        <h3 class="text-lg sm:text-xl
                                   font-black
                                   leading-tight
                                   text-white
                                   hover:text-cyan-400
                                   transition">

                            {{ $item->title }}

                        </h3>

                    </a>


                    <p class="mt-3
                              text-xs
                              leading-6
                              text-slate-500">

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($item->description),
                            100
                        ) }}

                    </p>


                    <a href="{{ frontend_news_url($item->slug) }}"
                       class="inline-flex items-center gap-2
                              mt-4
                              text-[9px]
                              uppercase
                              tracking-widest
                              font-black
                              text-cyan-400
                              hover:text-cyan-300">

                        Read Story

                        <span>→</span>

                    </a>

                </div>

            </article>

        @empty

            <div class="sm:col-span-2
                        py-20
                        text-center
                        rounded-xl
                        border border-dashed
                        border-slate-800">

                <div class="text-4xl mb-4">
                    ◈
                </div>

                <h3 class="text-xl font-bold text-white">
                    No published news available
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Published stories will appear here.
                </p>

            </div>

        @endforelse


    </div>


    {{-- PAGINATION --}}

    @if($latestNews->hasPages())

        <div class="mt-8 pt-6 border-t border-slate-800">

            {{ $latestNews->links() }}

        </div>

    @endif


</section>


{{-- ========================================================= --}}
{{-- RIGHT SIDEBAR --}}
{{-- ========================================================= --}}

<aside class="lg:col-span-4">


    {{-- TRENDING NOW --}}

    <section class="rounded-xl
                    bg-[#080d14]
                    tech-border
                    overflow-hidden">


        <div class="px-5 py-4
                    border-b border-slate-800
                    flex items-center justify-between">

            <div class="flex items-center gap-3">

                <span class="w-2 h-2
                             rounded-full
                             bg-cyan-400
                             shadow-[0_0_10px_#22d3ee]">
                </span>

                <h2 class="text-sm
                           font-black
                           uppercase
                           tracking-widest
                           text-white">

                    Trending Now

                </h2>

            </div>

            <span class="text-[8px] text-slate-600">
                LIVE
            </span>

        </div>


        <div class="p-3">

            @foreach($latestNews->take(5) as $index => $item)

                <a href="{{ frontend_news_url($item->slug) }}"
                   class="group flex gap-4
                          p-3 rounded-lg
                          hover:bg-white/[.03]
                          transition">


                    <div class="shrink-0
                                text-2xl
                                font-black
                                text-slate-700
                                group-hover:text-cyan-500
                                transition">

                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                    </div>


                    <div>

                        <div class="text-[8px]
                                    uppercase
                                    tracking-widest
                                    text-cyan-400
                                    font-bold
                                    mb-1">

                            {{ $item->category->name ?? 'News' }}

                        </div>


                        <h3 class="text-sm
                                   font-bold
                                   leading-snug
                                   text-slate-200
                                   group-hover:text-white">

                            {{ $item->title }}

                        </h3>


                        <div class="text-[8px]
                                    text-slate-600
                                    uppercase
                                    tracking-wider
                                    mt-2">

                            {{ optional($item->published_at)->diffForHumans() }}

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

    </section>


    {{-- HOT TOPICS --}}

    <section class="mt-6
                    rounded-xl
                    bg-[#080d14]
                    tech-border
                    p-5">


        <div class="flex items-center justify-between mb-5">

            <h2 class="text-sm
                       font-black
                       uppercase
                       tracking-widest
                       text-white">

                Hot Topics

            </h2>

            <span class="text-cyan-400 text-xs">
                #
            </span>

        </div>


        <div class="flex flex-wrap gap-2">

            @foreach($categories->take(10) as $category)

                <a href="{{ frontend_category_url($category->slug) }}"
                   class="px-3 py-2
                          rounded-md
                          bg-slate-900
                          border border-slate-800
                          text-[9px]
                          uppercase
                          tracking-wider
                          font-bold
                          text-slate-400
                          hover:border-cyan-500/40
                          hover:text-cyan-400
                          transition">

                    #{{ $category->name }}

                </a>

            @endforeach

        </div>

    </section>


    {{-- NEWSLETTER --}}

    <section class="mt-6
                    relative
                    overflow-hidden
                    rounded-xl
                    bg-gradient-to-br
                    from-cyan-500/15
                    to-blue-600/5
                    border border-cyan-500/20
                    p-6">


        <div class="absolute -right-10 -top-10
                    w-32 h-32
                    rounded-full
                    bg-cyan-400/10
                    blur-3xl">
        </div>


        <div class="relative">

            <div class="text-[9px]
                        uppercase
                        tracking-[.25em]
                        text-cyan-400
                        font-black">

                Digital Brief

            </div>


            <h2 class="mt-3
                       text-2xl
                       font-black
                       leading-tight
                       text-white">

                Technology news
                that matters.

            </h2>


            <p class="mt-3
                      text-sm
                      leading-6
                      text-slate-500">

                Get the latest technology,
                business and digital stories
                directly in your inbox.

            </p>


            <form class="mt-5">

                <input type="email"
                       placeholder="Email address"
                       class="w-full
                              rounded-lg
                              bg-[#05080d]
                              border border-slate-800
                              px-4 py-3
                              text-sm
                              text-white
                              placeholder:text-slate-600
                              outline-none
                              focus:border-cyan-500/50">


                <button type="button"
                        class="w-full
                               mt-2
                               rounded-lg
                               bg-cyan-500
                               py-3
                               text-[10px]
                               uppercase
                               tracking-widest
                               font-black
                               text-slate-950
                               hover:bg-cyan-300
                               transition">

                    Subscribe

                </button>

            </form>

        </div>

    </section>

</aside>

</div>


{{-- ========================================================= --}}
{{-- FEATURED STORIES --}}
{{-- ========================================================= --}}

@if($featuredNews->count() > 1)

<section class="mt-14">


    <div class="flex items-center justify-between
                mb-6
                pb-3
                border-b border-slate-800">

        <div class="flex items-center gap-3">

            <span class="w-1 h-6 bg-cyan-400 rounded-full"></span>

            <h2 class="text-xl sm:text-2xl
                       font-black
                       uppercase
                       tracking-wider
                       text-white">

                Featured

            </h2>

        </div>

        <span class="text-[9px]
                     uppercase
                     tracking-widest
                     text-slate-600">

            Editor's Selection

        </span>

    </div>


    <div class="grid md:grid-cols-3 gap-5">

        @foreach($featuredNews->skip(1)->take(3) as $item)

            <article class="news-card
                            relative
                            overflow-hidden
                            rounded-xl
                            bg-[#080d14]
                            tech-border">


                @if($item->featured_image)

                    <div class="aspect-[16/10] overflow-hidden">

                        <img src="{{ asset('storage/' . $item->featured_image) }}"
                             alt="{{ $item->title }}"
                             class="w-full h-full object-cover">

                    </div>

                @endif


                <div class="p-5">

                    <div class="text-[8px]
                                uppercase
                                tracking-widest
                                text-cyan-400
                                font-black
                                mb-2">

                        {{ $item->category->name ?? 'Technology' }}

                    </div>


                    <a href="{{ frontend_news_url($item->slug) }}">

                        <h3 class="text-lg
                                   font-black
                                   leading-tight
                                   text-white
                                   hover:text-cyan-400
                                   transition">

                            {{ $item->title }}

                        </h3>

                    </a>


                    <div class="mt-3 text-[8px]
                                uppercase
                                tracking-wider
                                text-slate-600">

                        {{ optional($item->published_at)->diffForHumans() }}

                    </div>

                </div>

            </article>

        @endforeach

    </div>

</section>

@endif


</main>


{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="mt-16
               border-t border-slate-800
               bg-[#03070d]">


    <div class="max-w-[1500px]
                mx-auto
                px-4 sm:px-6 lg:px-8
                py-12">


        <div class="grid md:grid-cols-4 gap-10">


            {{-- BRAND --}}

            <div class="md:col-span-2">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10
                                rounded-lg
                                bg-gradient-to-br
                                from-cyan-400
                                to-blue-600
                                flex items-center
                                justify-center
                                font-black
                                text-slate-950">

                        D

                    </div>


                    <div>

                        <div class="text-xl
                                    font-black
                                    text-white">

                            {{ $website->name }}

                        </div>

                        <div class="text-[8px]
                                    uppercase
                                    tracking-[.3em]
                                    text-cyan-400">

                            Digital Edge

                        </div>

                    </div>

                </div>


                <p class="mt-5
                          max-w-md
                          text-sm
                          leading-7
                          text-slate-600">

                    Independent digital journalism,
                    technology news and stories
                    shaping the future.

                </p>

            </div>


            {{-- CATEGORIES --}}

            <div>

                <h3 class="text-[9px]
                           uppercase
                           tracking-[.25em]
                           font-black
                           text-white
                           mb-5">

                    Explore

                </h3>


                <div class="space-y-3">

                    @foreach($categories->take(6) as $category)

                        <a href="{{ frontend_category_url($category->slug) }}"
                           class="block
                                  text-xs
                                  text-slate-600
                                  hover:text-cyan-400
                                  transition">

                            {{ $category->name }}

                        </a>

                    @endforeach

                </div>

            </div>


            {{-- CONTACT --}}

            <div>

                <h3 class="text-[9px]
                           uppercase
                           tracking-[.25em]
                           font-black
                           text-white
                           mb-5">

                    Contact

                </h3>


                @if($setting?->email)

                    <a href="mailto:{{ $setting->email }}"
                       class="block
                              text-xs
                              text-slate-600
                              hover:text-cyan-400
                              break-all">

                        {{ $setting->email }}

                    </a>

                @endif


                @if($setting?->phone)

                    <div class="mt-3
                                text-xs
                                text-slate-600">

                        {{ $setting->phone }}

                    </div>

                @endif

            </div>


        </div>


        {{-- COPYRIGHT --}}

        <div class="mt-10
                    pt-5
                    border-t border-slate-900
                    flex flex-col sm:flex-row
                    justify-between
                    gap-3">


            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-slate-700">

                © {{ date('Y') }}
                {{ $website->name }}
                — All Rights Reserved

            </span>


            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-slate-700">

                Powered by NewsHub CMS

            </span>

        </div>

    </div>

</footer>


</body>
</html>