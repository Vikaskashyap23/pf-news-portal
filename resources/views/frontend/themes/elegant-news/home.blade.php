<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }}</title>

    <meta name="description"
          content="{{ $setting->meta_description ?? 'Latest news and breaking news.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        elegant: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            500: '#db2777',
                            600: '#be185d',
                            700: '#9d174d',
                            900: '#500724',
                        }
                    },
                    fontFamily: {
                        display: ['Georgia', 'Times New Roman', 'serif'],
                        sans: ['Arial', 'Helvetica', 'sans-serif'],
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
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            color: #171717;
        }

        .display {
            font-family: Georgia, "Times New Roman", serif;
        }

        .news-title {
            letter-spacing: -0.025em;
        }

        .hero-slide {
            display: none;
        }

        .hero-slide.active {
            display: block;
        }

        .hero-image {
            transition: transform .7s ease;
        }

        .hero-card:hover .hero-image {
            transform: scale(1.035);
        }

        .story-image {
            transition: transform .45s ease;
        }

        .story-card:hover .story-image {
            transform: scale(1.04);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>


<body>


{{-- ========================================================= --}}
{{-- TOP BAR --}}
{{-- ========================================================= --}}

<div class="bg-[#171717] text-white">

    <div class="max-w-7xl mx-auto px-4">

        <div class="h-9 flex items-center justify-between gap-4">

            <div class="text-[10px] uppercase tracking-[0.18em] text-gray-400">
                {{ now()->format('l, d F Y') }}
            </div>

            <div class="hidden sm:block text-[10px] uppercase tracking-[0.18em] text-gray-400">
                Trusted News • Independent Journalism
            </div>

            <div class="text-[10px] uppercase tracking-[0.18em] text-gray-400">
                {{ $setting->email ?? '' }}
            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- MAIN HEADER --}}
{{-- ========================================================= --}}

<header class="bg-white border-b border-gray-200">

    <div class="max-w-7xl mx-auto px-4">

        <div class="py-6 sm:py-7 flex flex-col lg:flex-row
                    lg:items-center lg:justify-between gap-5">

            {{-- LOGO --}}

            <div class="text-center lg:text-left">

                <a href="{{ frontend_home_url() }}"
                   class="inline-block">

                    <div class="text-[9px] uppercase
                                tracking-[0.4em]
                                text-elegant-600
                                font-bold mb-1">

                        ELEGANT EDITION

                    </div>

                    <h1 class="display text-4xl sm:text-5xl
                               font-black tracking-tight">

                        {{ $website->name }}

                    </h1>

                </a>

                <div class="mt-2 text-[9px]
                            uppercase tracking-[0.25em]
                            text-gray-400">

                    Sophisticated • Professional • Independent

                </div>

            </div>


            {{-- HEADER RIGHT --}}

            <div class="hidden md:flex items-center gap-3">

                <div class="border border-gray-200
                            px-4 py-3 text-center">

                    <div class="text-[8px] uppercase
                                tracking-widest
                                text-gray-400">

                        Today's Edition

                    </div>

                    <div class="display font-bold text-lg mt-1">

                        {{ now()->format('d M Y') }}

                    </div>

                </div>

                <div class="border border-gray-200
                            px-4 py-3 text-center">

                    <div class="text-[8px] uppercase
                                tracking-widest
                                text-gray-400">

                        Stories

                    </div>

                    <div class="display font-bold text-lg mt-1">

                        {{ $latestNews->count() }}

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- NAVIGATION --}}
        {{-- ================================================= --}}

        <nav class="border-t border-gray-100">

            <div class="flex items-center
                        overflow-x-auto
                        whitespace-nowrap
                        hide-scrollbar">

                <a href="{{ frontend_home_url() }}"
                   class="px-4 py-3
                          text-[10px]
                          uppercase
                          tracking-[0.15em]
                          font-bold
                          text-white
                          bg-elegant-600">

                    {{ __('messages.home') }}

                </a>


                @foreach($categories as $category)

                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="px-4 py-3
                              text-[10px]
                              uppercase
                              tracking-[0.12em]
                              font-bold
                              text-gray-600
                              hover:text-elegant-600
                              hover:bg-elegant-50
                              transition">

                        {{ $category->name }}

                    </a>

                @endforeach



            </div>

        </nav>

    </div>

</header>


{{-- ========================================================= --}}
{{-- BREAKING NEWS --}}
{{-- ========================================================= --}}

@if($breakingNews->count())

<div class="border-b border-gray-200 bg-gray-50">

    <div class="max-w-7xl mx-auto px-4">

        <div class="flex items-center">

            <div class="flex-shrink-0
                        bg-elegant-600
                        text-white
                        px-4 py-3
                        text-[9px]
                        uppercase
                        tracking-widest
                        font-black">

                BREAKING NEWS

            </div>

            <div class="overflow-x-auto
                        whitespace-nowrap
                        hide-scrollbar">

                <div class="flex items-center gap-8 px-5">

                    @foreach($breakingNews as $breaking)

                        <a href="{{ frontend_news_url($breaking->slug) }}"
                           class="text-xs
                                  font-semibold
                                  text-gray-700
                                  hover:text-elegant-600
                                  transition
                                  py-3">

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
{{-- MAIN CONTENT --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto px-4 py-7 sm:py-9">


{{-- ========================================================= --}}
{{-- HERO HEADING --}}
{{-- ========================================================= --}}

<div class="flex items-center justify-between mb-5">

    <div class="flex items-center gap-3">

        <span class="w-1.5 h-7 bg-elegant-600"></span>

        <div>

            <div class="text-[9px]
                        uppercase
                        tracking-[0.2em]
                        text-elegant-600
                        font-black">

                Featured

            </div>

            <h2 class="display text-2xl sm:text-3xl
                       font-black">

                Top Stories

            </h2>

        </div>

    </div>

    <div class="hidden sm:flex items-center gap-2">

        <span class="text-[9px]
                     uppercase
                     tracking-widest
                     text-gray-400">

            {{ now()->format('d F Y') }}

        </span>

    </div>

</div>


{{-- ========================================================= --}}
{{-- HERO SLIDER --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

<div id="elegantHero"
     class="relative">

    @foreach($featuredNews->take(5) as $index => $hero)

        <article class="hero-slide {{ $index === 0 ? 'active' : '' }}">

            <div class="hero-card
                        relative
                        overflow-hidden
                        bg-[#111827]
                        rounded-sm">

                @if($hero->featured_image)

                    <img src="{{ asset('storage/' . $hero->featured_image) }}"
                         alt="{{ $hero->title }}"
                         class="hero-image
                                absolute inset-0
                                w-full h-full
                                object-cover
                                opacity-75">

                @else

                    <div class="absolute inset-0
                                bg-gradient-to-br
                                from-gray-900
                                via-gray-700
                                to-elegant-900">
                    </div>

                @endif


                {{-- OVERLAY --}}

                <div class="absolute inset-0
                            bg-gradient-to-t
                            from-black
                            via-black/50
                            to-black/5">
                </div>


                {{-- CONTENT --}}

                <div class="relative z-10
                            min-h-[390px]
                            sm:min-h-[470px]
                            flex items-end">

                    <div class="w-full
                                p-6 sm:p-9 lg:p-12">

                        <div class="inline-flex
                                    items-center
                                    bg-elegant-600
                                    text-white
                                    px-3 py-1.5
                                    text-[8px]
                                    uppercase
                                    tracking-[0.18em]
                                    font-black
                                    mb-4">

                            {{ $hero->category->name ?? 'News' }}

                        </div>


                        <a href="{{ frontend_news_url($hero->slug) }}">

                            <h1 class="display
                                       news-title
                                       text-white
                                       text-3xl
                                       sm:text-4xl
                                       lg:text-5xl
                                       xl:text-6xl
                                       font-black
                                       leading-[1.02]
                                       max-w-4xl
                                       hover:text-pink-200
                                       transition">

                                {{ $hero->title }}

                            </h1>

                        </a>


                        <p class="mt-4
                                  text-sm sm:text-base
                                  text-gray-200
                                  max-w-2xl
                                  leading-6
                                  line-clamp-2">

                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($hero->description),
                                180
                            ) }}

                        </p>


                        <div class="mt-5 flex
                                    flex-wrap
                                    items-center
                                    gap-4">

                            <a href="{{ frontend_news_url($hero->slug) }}"
                               class="inline-flex
                                      items-center gap-2
                                      bg-elegant-600
                                      hover:bg-elegant-700
                                      text-white
                                      px-5 py-3
                                      text-[9px]
                                      uppercase
                                      tracking-widest
                                      font-black
                                      transition">

                                Read More

                                <span>→</span>

                            </a>


                            <span class="text-[9px]
                                         uppercase
                                         tracking-widest
                                         text-gray-300">

                                {{ optional($hero->published_at)->format('d M Y') }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </article>

    @endforeach


    {{-- SLIDER BUTTONS --}}

    @if($featuredNews->take(5)->count() > 1)

        <button type="button"
                id="heroPrev"
                class="absolute
                       left-4
                       top-1/2
                       -translate-y-1/2
                       w-9 h-9
                       rounded-full
                       bg-black/50
                       hover:bg-elegant-600
                       text-white
                       flex items-center
                       justify-center
                       transition">

            ←

        </button>


        <button type="button"
                id="heroNext"
                class="absolute
                       right-4
                       top-1/2
                       -translate-y-1/2
                       w-9 h-9
                       rounded-full
                       bg-black/50
                       hover:bg-elegant-600
                       text-white
                       flex items-center
                       justify-center
                       transition">

            →

        </button>


        <div id="heroDots"
             class="absolute
                    bottom-5
                    right-6
                    flex gap-1.5">

            @foreach($featuredNews->take(5) as $index => $item)

                <button type="button"
                        data-slide="{{ $index }}"
                        class="hero-dot
                               w-2 h-2
                               rounded-full
                               {{ $index === 0
                                    ? 'bg-white w-5'
                                    : 'bg-white/50' }}
                               transition-all">

                </button>

            @endforeach

        </div>

    @endif

</div>

@endif


{{-- ========================================================= --}}
{{-- QUICK STORY ROW --}}
{{-- ========================================================= --}}

@if($featuredNews->count() > 1)

<div class="grid
            sm:grid-cols-2
            lg:grid-cols-4
            gap-4
            mt-5">

    @foreach($featuredNews->skip(1)->take(4) as $item)

        <article class="story-card
                        group
                        border
                        border-gray-200
                        bg-white
                        overflow-hidden">

            @if($item->featured_image)

                <a href="{{ frontend_news_url($item->slug) }}"
                   class="block overflow-hidden">

                    <img src="{{ asset('storage/' . $item->featured_image) }}"
                         alt="{{ $item->title }}"
                         class="story-image
                                w-full
                                aspect-[16/10]
                                object-cover">

                </a>

            @endif


            <div class="p-4">

                <div class="text-[8px]
                            uppercase
                            tracking-widest
                            font-black
                            text-elegant-600
                            mb-2">

                    {{ $item->category->name ?? 'News' }}

                </div>


                <a href="{{ frontend_news_url($item->slug) }}">

                    <h3 class="display
                               text-lg
                               font-bold
                               leading-snug
                               line-clamp-3
                               group-hover:text-elegant-600
                               transition">

                        {{ $item->title }}

                    </h3>

                </a>

            </div>

        </article>

    @endforeach

</div>

@endif


{{-- ========================================================= --}}
{{-- TRENDING + LATEST --}}
{{-- ========================================================= --}}

<div class="grid lg:grid-cols-12 gap-8 mt-12">


    {{-- ===================================================== --}}
    {{-- LATEST STORIES --}}
    {{-- ===================================================== --}}

    <section class="lg:col-span-8">

        <div class="flex items-end justify-between
                    border-b-2 border-gray-900
                    pb-3 mb-1">

            <div>

                <div class="text-[8px]
                            uppercase
                            tracking-[0.22em]
                            font-black
                            text-elegant-600">

                    News Desk

                </div>

                <h2 class="display
                           text-3xl
                           font-black
                           mt-1">

                    Latest Stories

                </h2>

            </div>


            <span class="hidden sm:block
                         text-[9px]
                         uppercase
                         tracking-widest
                         text-gray-400">

                View All

            </span>

        </div>


        @forelse($latestNews as $item)

            <article class="story-card
                            py-5
                            border-b
                            border-gray-200">

                <div class="grid sm:grid-cols-12 gap-5">


                    @if($item->featured_image)

                        <div class="sm:col-span-4
                                    overflow-hidden">

                            <a href="{{ frontend_news_url($item->slug) }}">

                                <img src="{{ asset('storage/' . $item->featured_image) }}"
                                     alt="{{ $item->title }}"
                                     class="story-image
                                            w-full
                                            aspect-[16/10]
                                            object-cover">

                            </a>

                        </div>

                    @endif


                    <div class="{{ $item->featured_image
                        ? 'sm:col-span-8'
                        : 'sm:col-span-12' }}">

                        <div class="flex items-center gap-2
                                    text-[8px]
                                    uppercase
                                    tracking-widest
                                    font-black
                                    text-elegant-600">

                            {{ $item->category->name ?? 'News' }}

                            <span class="text-gray-300">•</span>

                            <span class="text-gray-400">

                                {{ optional($item->published_at)->diffForHumans() }}

                            </span>

                        </div>


                        <a href="{{ frontend_news_url($item->slug) }}">

                            <h3 class="display
                                       text-2xl
                                       sm:text-3xl
                                       font-black
                                       leading-tight
                                       mt-2
                                       hover:text-elegant-600
                                       transition">

                                {{ $item->title }}

                            </h3>

                        </a>


                        <p class="text-sm
                                  text-gray-500
                                  leading-6
                                  mt-3
                                  line-clamp-2">

                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($item->description),
                                180
                            ) }}

                        </p>


                        <a href="{{ frontend_news_url($item->slug) }}"
                           class="inline-flex
                                  items-center gap-2
                                  mt-3
                                  text-[8px]
                                  uppercase
                                  tracking-widest
                                  font-black
                                  text-elegant-600">

                            Read Story →

                        </a>

                    </div>

                </div>

            </article>

        @empty

            <div class="py-16
                        text-center
                        border
                        border-dashed
                        border-gray-300">

                <div class="text-4xl mb-3">
                    📰
                </div>

                <h3 class="display text-xl font-bold">
                    No published news available.
                </h3>

            </div>

        @endforelse


        @if($latestNews->hasPages())

            <div class="pt-6">

                {{ $latestNews->links() }}

            </div>

        @endif

    </section>


    {{-- ===================================================== --}}
    {{-- SIDEBAR --}}
    {{-- ===================================================== --}}

    <aside class="lg:col-span-4">


        {{-- MOST READ --}}

        <section class="border
                        border-gray-200
                        bg-white">

            <div class="px-5 py-4
                        border-b-2
                        border-gray-900">

                <div class="text-[8px]
                            uppercase
                            tracking-[0.2em]
                            text-elegant-600
                            font-black">

                    Popular

                </div>

                <h2 class="display
                           text-2xl
                           font-black
                           mt-1">

                    Most Read

                </h2>

            </div>


            <div class="px-5">

                @foreach($latestNews->take(5) as $index => $item)

                    <article class="py-5
                                    border-b
                                    border-gray-200
                                    last:border-0">

                        <div class="flex gap-4">

                            <div class="display
                                        text-3xl
                                        font-black
                                        text-gray-200">

                                {{ str_pad(
                                    $index + 1,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}

                            </div>


                            <div class="flex-1">

                                <div class="text-[8px]
                                            uppercase
                                            tracking-widest
                                            text-elegant-600
                                            font-black">

                                    {{ $item->category->name ?? 'News' }}

                                </div>


                                <a href="{{ frontend_news_url($item->slug) }}">

                                    <h3 class="display
                                               text-base
                                               font-bold
                                               leading-snug
                                               mt-1
                                               hover:text-elegant-600
                                               transition">

                                        {{ $item->title }}

                                    </h3>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        </section>


        {{-- ================================================= --}}
        {{-- FEATURED MINI GRID --}}
        {{-- ================================================= --}}

        @if($featuredNews->count() > 1)

        <section class="mt-8">

            <div class="flex items-center
                        justify-between
                        border-b-2
                        border-gray-900
                        pb-3 mb-4">

                <h2 class="display
                           text-xl
                           font-black">

                    Featured

                </h2>

                <span class="text-[8px]
                             uppercase
                             tracking-widest
                             text-elegant-600
                             font-bold">

                    Editor's Pick

                </span>

            </div>


            @foreach($featuredNews->skip(1)->take(2) as $item)

                <article class="group
                                flex gap-4
                                py-4
                                border-b
                                border-gray-200">

                    @if($item->featured_image)

                        <a href="{{ frontend_news_url($item->slug) }}"
                           class="flex-shrink-0
                                  overflow-hidden
                                  w-28">

                            <img src="{{ asset('storage/' . $item->featured_image) }}"
                                 alt="{{ $item->title }}"
                                 class="story-image
                                        w-full
                                        h-20
                                        object-cover">

                        </a>

                    @endif


                    <div>

                        <div class="text-[8px]
                                    uppercase
                                    tracking-widest
                                    text-elegant-600
                                    font-black">

                            {{ $item->category->name ?? 'News' }}

                        </div>


                        <a href="{{ frontend_news_url($item->slug) }}">

                            <h3 class="display
                                       text-base
                                       font-bold
                                       leading-snug
                                       mt-1
                                       line-clamp-3
                                       group-hover:text-elegant-600
                                       transition">

                                {{ $item->title }}

                            </h3>

                        </a>

                    </div>

                </article>

            @endforeach

        </section>

        @endif


        {{-- ================================================= --}}
        {{-- CATEGORIES --}}
        {{-- ================================================= --}}

        <section class="mt-8">

            <div class="flex items-center gap-3
                        border-b-2
                        border-gray-900
                        pb-3 mb-4">

                <h2 class="display
                           text-xl
                           font-black">

                    Explore Topics

                </h2>

            </div>


            <div class="grid grid-cols-2 gap-2">

                @foreach($categories->take(12) as $category)

                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="border
                              border-gray-200
                              px-3 py-3
                              text-[9px]
                              uppercase
                              tracking-wider
                              font-bold
                              text-gray-600
                              hover:bg-elegant-600
                              hover:text-white
                              hover:border-elegant-600
                              transition">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>

        </section>


        {{-- ================================================= --}}
        {{-- NEWSLETTER --}}
        {{-- ================================================= --}}

        <section class="mt-8
                        bg-[#171717]
                        text-white
                        p-6">

            <div class="text-[8px]
                        uppercase
                        tracking-[0.25em]
                        text-pink-400
                        font-black">

                Daily Brief

            </div>


            <h2 class="display
                       text-2xl
                       font-black
                       mt-3
                       leading-tight">

                The news
                that matters.

            </h2>


            <p class="text-sm
                      text-gray-400
                      leading-6
                      mt-3">

                Important stories and
                thoughtful reporting,
                delivered directly to you.

            </p>


            <form class="mt-5">

                <input type="email"
                       placeholder="Your email address"
                       class="w-full
                              px-4 py-3
                              text-sm
                              text-gray-900
                              outline-none">


                <button type="button"
                        class="w-full
                               mt-2
                               py-3
                               bg-elegant-600
                               hover:bg-elegant-700
                               text-white
                               text-[9px]
                               uppercase
                               tracking-widest
                               font-black
                               transition">

                    Subscribe →

                </button>

            </form>

        </section>

    </aside>

</div>


{{-- ========================================================= --}}
{{-- CATEGORY SHOWCASE --}}
{{-- ========================================================= --}}

@if($categories->count())

<section class="mt-14">

    <div class="flex items-center
                justify-between
                border-b-2
                border-gray-900
                pb-3 mb-6">

        <div>

            <div class="text-[8px]
                        uppercase
                        tracking-[0.2em]
                        text-elegant-600
                        font-black">

                Discover

            </div>

            <h2 class="display
                       text-3xl
                       font-black">

                Browse Categories

            </h2>

        </div>

    </div>


    <div class="grid
                grid-cols-2
                sm:grid-cols-3
                lg:grid-cols-6
                gap-3">

        @foreach($categories->take(6) as $category)

            <a href="{{ frontend_category_url($category->slug) }}"
               class="group
                      relative
                      overflow-hidden
                      bg-gray-900
                      p-5
                      min-h-[110px]
                      flex items-end">

                <div class="absolute
                            inset-0
                            bg-gradient-to-t
                            from-black/80
                            to-transparent">
                </div>

                <div class="relative z-10">

                    <div class="w-6 h-0.5
                                bg-elegant-500
                                mb-2
                                group-hover:w-10
                                transition-all">

                    </div>

                    <span class="text-white
                                 text-[10px]
                                 uppercase
                                 tracking-wider
                                 font-black">

                        {{ $category->name }}

                    </span>

                </div>

            </a>

        @endforeach

    </div>

</section>

@endif


</main>


{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#111111] text-gray-400 mt-14">

    <div class="max-w-7xl mx-auto px-4 py-12">

        <div class="grid
                    md:grid-cols-3
                    gap-10">


            {{-- BRAND --}}

            <div>

                <div class="text-[8px]
                            uppercase
                            tracking-[0.3em]
                            text-pink-400
                            font-black">

                    Elegant Edition

                </div>

                <div class="display
                            text-3xl
                            text-white
                            font-black
                            mt-2">

                    {{ $website->name }}

                </div>

                <p class="text-sm
                          leading-6
                          text-gray-500
                          mt-4
                          max-w-sm">

                    Independent journalism,
                    trusted reporting and
                    stories that shape the world.

                </p>

            </div>


            {{-- CATEGORIES --}}

            <div>

                <h3 class="text-[9px]
                           uppercase
                           tracking-[0.25em]
                           font-black
                           text-white
                           mb-5">

                    Explore

                </h3>


                <div class="grid grid-cols-2 gap-3">

                    @foreach($categories->take(8) as $category)

                        <a href="{{ frontend_category_url($category->slug) }}"
                           class="text-xs
                                  hover:text-white
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
                           tracking-[0.25em]
                           font-black
                           text-white
                           mb-5">

                    Contact

                </h3>


                @if($setting?->email)

                    <div class="text-sm mb-3 break-all">
                        {{ $setting->email }}
                    </div>

                @endif


                @if($setting?->phone)

                    <div class="text-sm">
                        {{ $setting->phone }}
                    </div>

                @endif

            </div>

        </div>


        <div class="border-t
                    border-gray-800
                    mt-10 pt-5
                    flex flex-col
                    sm:flex-row
                    justify-between
                    gap-3">

            <div class="text-[9px]
                        uppercase
                        tracking-widest
                        text-gray-600">

                © {{ date('Y') }}
                {{ $website->name }}
                — All Rights Reserved

            </div>

            <div class="text-[9px]
                        uppercase
                        tracking-widest
                        text-gray-600">

                Powered by NewsHub CMS

            </div>

        </div>

    </div>

</footer>


{{-- ========================================================= --}}
{{-- HERO SLIDER JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');

    const nextButton = document.getElementById('heroNext');
    const prevButton = document.getElementById('heroPrev');

    if (!slides.length || slides.length <= 1) {
        return;
    }

    let current = 0;
    let timer;


    function showSlide(index) {

        if (index >= slides.length) {
            index = 0;
        }

        if (index < 0) {
            index = slides.length - 1;
        }

        slides.forEach(function (slide, i) {

            slide.classList.toggle(
                'active',
                i === index
            );

        });


        dots.forEach(function (dot, i) {

            dot.classList.toggle(
                'bg-white',
                i === index
            );

            dot.classList.toggle(
                'w-5',
                i === index
            );

            dot.classList.toggle(
                'bg-white/50',
                i !== index
            );

            dot.classList.toggle(
                'w-2',
                i !== index
            );

        });


        current = index;

    }


    function nextSlide() {
        showSlide(current + 1);
    }


    function prevSlide() {
        showSlide(current - 1);
    }


    function startAutoPlay() {

        timer = setInterval(
            nextSlide,
            5000
        );

    }


    function resetAutoPlay() {

        clearInterval(timer);

        startAutoPlay();

    }


    if (nextButton) {

        nextButton.addEventListener(
            'click',
            function () {

                nextSlide();
                resetAutoPlay();

            }
        );

    }


    if (prevButton) {

        prevButton.addEventListener(
            'click',
            function () {

                prevSlide();
                resetAutoPlay();

            }
        );

    }


    dots.forEach(function (dot) {

        dot.addEventListener(
            'click',
            function () {

                showSlide(
                    parseInt(
                        dot.dataset.slide
                    )
                );

                resetAutoPlay();

            }
        );

    });


    startAutoPlay();

});

</script>

</body>
</html>