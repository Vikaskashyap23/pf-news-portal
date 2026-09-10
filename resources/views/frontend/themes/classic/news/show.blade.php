<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $news->title }} - {{ $website->name }}</title>

    <meta name="description"
          content="{{ \Illuminate\Support\Str::limit(strip_tags($news->description ?? ''), 160) }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: [
                            'Inter',
                            'Arial',
                            'Helvetica',
                            'sans-serif'
                        ]
                    },
                    colors: {
                        cream: '#f7f7f4',
                        ink: '#161616',
                        muted: '#777777',
                        soft: '#eeeeea'
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
            background: #f7f7f4;
            color: #171717;
            font-family:
                Inter,
                Arial,
                Helvetica,
                sans-serif;
        }

        .container-main {
            width: min(1440px, 100%);
            margin: auto;
        }

        .soft-card {
            background: white;
            border: 1px solid #eeeeea;
            border-radius: 22px;
            box-shadow:
                0 10px 35px rgba(0, 0, 0, .035);
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 0;
            height: 1px;
            background: #111;
            transition: .3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .story-image {
            transition:
                transform .45s ease;
        }

        .story-card:hover .story-image {
            transform: scale(1.04);
        }

        .article-content {
            color: #404040;
            font-size: 17px;
            line-height: 1.9;
        }

        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4 {
            color: #111111;
            font-weight: 800;
            line-height: 1.3;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .article-content h1 {
            font-size: 2rem;
        }

        .article-content h2 {
            font-size: 1.7rem;
        }

        .article-content h3 {
            font-size: 1.4rem;
        }

        .article-content h4 {
            font-size: 1.2rem;
        }

        .article-content p {
            margin-bottom: 1.25rem;
        }

        .article-content a {
            color: #111111;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .article-content ul {
            list-style: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .article-content ol {
            list-style: decimal;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .article-content li {
            margin-bottom: .5rem;
        }

        .article-content blockquote {
            margin: 1.5rem 0;
            padding: 1rem 1.25rem;
            border-left: 4px solid #111111;
            background: #f7f7f4;
            border-radius: 12px;
            font-weight: 600;
        }

        .article-content img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 1.75rem auto;
            border-radius: 18px;
        }

        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }

        .article-content th,
        .article-content td {
            border: 1px solid #e5e5e5;
            padding: .75rem;
            text-align: left;
        }

        .article-content th {
            background: #f7f7f4;
            color: #111111;
            font-weight: 700;
        }

        .article-content strong {
            color: #111111;
            font-weight: 700;
        }

        .article-content hr {
            border: 0;
            border-top: 1px solid #e5e5e5;
            margin: 2rem 0;
        }

        @media (max-width: 768px) {

            .article-content {
                font-size: 16px;
                line-height: 1.8;
            }

            .article-content h1 {
                font-size: 1.7rem;
            }

            .article-content h2 {
                font-size: 1.5rem;
            }

        }

    </style>

</head>


<body>


{{-- ============================================================
     PAGE DATA
============================================================ --}}

@php

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    $categories = \App\Models\Category::where('website_id', $website->id)
        ->where('status', true)
        ->orderBy('name')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Latest News
    |--------------------------------------------------------------------------
    */

    $latestNews = \App\Models\News::where('website_id', $website->id)
        ->where('status', 'published')
        ->where('id', '!=', $news->id)
        ->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
        ->latest('published_at')
        ->latest('id')
        ->take(6)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Breaking News
    |--------------------------------------------------------------------------
    */

    $breakingNews = \App\Models\News::where('website_id', $website->id)
        ->where('status', 'published')
        ->where('is_breaking', true)
        ->where('id', '!=', $news->id)
        ->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
        ->latest('published_at')
        ->latest('id')
        ->take(5)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    */

    $siteName = $website->name ?? 'NewsHub';

    $categoryName = optional($news->category)->name ?? 'News';

    $publishedDate = $news->published_at
        ? \Carbon\Carbon::parse($news->published_at)
        : null;

@endphp


{{-- ============================================================
     HEADER
============================================================ --}}

<header class="bg-white border-b border-gray-100">

    <div class="container-main px-5 lg:px-10">

        <div class="h-[76px] flex items-center justify-between gap-8">


            {{-- LOGO --}}

            <a href="{{ frontend_home_url() }}"
               class="shrink-0">

                <div class="text-[27px]
                            sm:text-[31px]
                            font-black
                            tracking-[-1.5px]
                            text-black">

                    {{ $siteName }}

                </div>

                <div class="text-[8px]
                            uppercase
                            tracking-[.28em]
                            text-gray-400
                            mt-[-2px]">

                    News & Lifestyle

                </div>

            </a>


            {{-- DESKTOP NAVIGATION --}}

            <nav class="hidden lg:flex items-center gap-7">

                <a href="{{ frontend_home_url() }}"
                   class="nav-link text-[12px] font-semibold">

                    Home

                </a>


                @foreach($categories->take(7) as $category)

                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="nav-link
                              text-[12px]
                              text-gray-500
                              hover:text-black
                              font-medium">

                        {{ $category->name }}

                    </a>

                @endforeach


                <a href="{{ route('frontend.themes', [
                    'websiteSlug' => $website->slug
                ]) }}"
                   class="nav-link
                          text-[12px]
                          font-semibold">

                    Themes

                </a>

            </nav>


            {{-- RIGHT SIDE --}}

            <div class="flex items-center gap-3">

                <a href="{{ route('frontend.domain.search') }}"
                   class="w-9 h-9
                          rounded-full
                          border border-gray-200
                          flex items-center
                          justify-center
                          hover:bg-black
                          hover:text-white
                          transition">

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="m21 21-4.3-4.3m2.3-5.7a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"/>

                    </svg>

                </a>


                <button class="lg:hidden
                               w-9 h-9
                               rounded-full
                               border border-gray-200">

                    <svg class="w-4 h-4 mx-auto"
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


        {{-- MOBILE NAVIGATION --}}

        <div class="lg:hidden
                    flex gap-5
                    overflow-x-auto
                    pb-4">

            <a href="{{ frontend_home_url() }}"
               class="shrink-0
                      text-xs
                      font-semibold">

                Home

            </a>


            @foreach($categories->take(8) as $category)

                <a href="{{ frontend_category_url($category->slug) }}"
                   class="shrink-0
                          text-xs
                          text-gray-500">

                    {{ $category->name }}

                </a>

            @endforeach

        </div>

    </div>

</header>


{{-- ============================================================
     BREAKING NEWS
============================================================ --}}

@if($breakingNews->count())

    <div class="bg-[#111] text-white">

        <div class="container-main px-5 lg:px-10">

            <div class="min-h-[42px]
                        flex items-center
                        gap-4
                        overflow-hidden">

                <span class="shrink-0
                             text-[9px]
                             uppercase
                             tracking-[.2em]
                             font-bold">

                    Breaking

                </span>


                <div class="h-3 w-px bg-gray-600"></div>


                <div class="flex gap-10
                            overflow-x-auto
                            whitespace-nowrap">

                    @foreach($breakingNews as $breaking)

                        <a href="{{ frontend_news_url($breaking->slug) }}"
                           class="text-[11px]
                                  text-gray-300
                                  hover:text-white">

                            {{ $breaking->title }}

                        </a>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

@endif


{{-- ============================================================
     MAIN CONTENT
============================================================ --}}

<main class="container-main
             px-5 lg:px-10
             py-8 lg:py-12">


    {{-- ========================================================
         BREADCRUMB
    ========================================================= --}}

    <div class="flex items-center
                flex-wrap
                gap-2
                text-xs
                text-gray-400
                mb-7">

        <a href="{{ frontend_home_url() }}"
           class="hover:text-black transition">

            Home

        </a>


        <span>/</span>


        @if($news->category)

            <a href="{{ frontend_category_url($news->category->slug) }}"
               class="hover:text-black transition">

                {{ $categoryName }}

            </a>

            <span>/</span>

        @endif


        <span class="text-gray-500">

            Article

        </span>

    </div>


    {{-- ========================================================
         ARTICLE + SIDEBAR
    ========================================================= --}}

    <div class="grid
                lg:grid-cols-12
                gap-8
                lg:gap-10">


        {{-- ====================================================
             ARTICLE
        ===================================================== --}}

        <article class="lg:col-span-8">


            {{-- CATEGORY --}}

            <div class="mb-5">

                <a href="{{ $news->category
                    ? frontend_category_url($news->category->slug)
                    : frontend_home_url()
                }}"
                   class="inline-flex
                          items-center
                          px-3
                          py-1.5
                          rounded-full
                          bg-black
                          text-white
                          text-[9px]
                          uppercase
                          tracking-[.18em]
                          font-bold">

                    {{ $categoryName }}

                </a>

            </div>


            {{-- TITLE --}}

            <h1 class="text-4xl
                       sm:text-5xl
                       lg:text-[58px]
                       xl:text-[64px]
                       leading-[1]
                       tracking-[-2.5px]
                       font-black
                       text-black">

                {{ $news->title }}

            </h1>


            {{-- META --}}

            <div class="flex flex-wrap
                        items-center
                        gap-3
                        mt-6
                        pb-6
                        border-b
                        border-gray-200">

                @if($publishedDate)

                    <span class="text-[10px]
                                 uppercase
                                 tracking-widest
                                 text-gray-500">

                        {{ $publishedDate->format('d M Y') }}

                    </span>


                    <span class="text-gray-300">

                        •

                    </span>


                    <span class="text-[10px]
                                 uppercase
                                 tracking-widest
                                 text-gray-400">

                        {{ $publishedDate->diffForHumans() }}

                    </span>

                @endif


                @if($news->category)

                    <span class="text-gray-300">

                        •

                    </span>


                    <span class="text-[10px]
                                 uppercase
                                 tracking-widest
                                 text-gray-400">

                        {{ $categoryName }}

                    </span>

                @endif

            </div>


            {{-- FEATURED IMAGE --}}

            @if(!empty($news->image))

                <div class="mt-8
                            overflow-hidden
                            rounded-[28px]
                            bg-white
                            border
                            border-[#eeeeea]">

                    <img src="{{ asset('storage/' . $news->image) }}"
                         alt="{{ $news->title }}"
                         class="w-full
                                max-h-[650px]
                                object-cover">

                </div>

            @endif


                {{-- ========================================================
     NEWS VIDEO
========================================================= --}}

@if(!empty($news->video))

    <div class="mt-8 overflow-hidden rounded-[28px] bg-black border border-[#eeeeea]">

        <video
            controls
            preload="metadata"
            class="w-full"
            style="max-height: 650px;"
        >

            <source
                src="{{ asset('storage/' . $news->video) }}"
                type="video/mp4"
            >

            Your browser does not support the video tag.

        </video>

    </div>

@endif



            {{-- ARTICLE BODY --}}

            <div class="soft-card
                        mt-8
                        p-6
                        sm:p-8
                        lg:p-10">

                <div class="article-content">

                    {!! $news->description !!}

                </div>

            </div>


            {{-- BACK BUTTON --}}

            <div class="flex
                        flex-wrap
                        items-center
                        justify-between
                        gap-4
                        mt-8">

                <a href="{{ frontend_home_url() }}"
                   class="inline-flex
                          items-center
                          gap-3
                          bg-black
                          text-white
                          rounded-full
                          px-6
                          py-3
                          text-[10px]
                          uppercase
                          tracking-widest
                          font-bold
                          hover:bg-gray-800
                          transition">

                    <span>
                        ←
                    </span>

                    Back to Home

                </a>


                @if($news->category)

                    <a href="{{ frontend_category_url($news->category->slug) }}"
                       class="text-[10px]
                              uppercase
                              tracking-widest
                              font-bold
                              text-gray-400
                              hover:text-black
                              transition">

                        More from {{ $categoryName }}

                    </a>

                @endif

            </div>

        </article>


        {{-- ====================================================
             SIDEBAR
        ===================================================== --}}

        <aside class="lg:col-span-4">


            {{-- LATEST STORIES --}}

            <section class="soft-card
                            p-6
                            lg:sticky
                            lg:top-8">

                <div class="flex
                            items-center
                            justify-between
                            border-b
                            border-gray-100
                            pb-4
                            mb-2">

                    <div>

                        <div class="text-[9px]
                                    uppercase
                                    tracking-[.2em]
                                    text-gray-400">

                            Latest

                        </div>


                        <h2 class="text-xl
                                   font-black">

                            Latest Stories

                        </h2>

                    </div>


                    <span class="text-xl">

                        ✦

                    </span>

                </div>


                <div>

                    @forelse($latestNews as $index => $item)

                        <a href="{{ frontend_news_url($item->slug) }}"
                           class="flex
                                  gap-4
                                  py-5
                                  border-b
                                  border-gray-100
                                  last:border-0
                                  group">


                            {{-- IMAGE --}}

                            <div class="w-20
                                        h-16
                                        shrink-0
                                        rounded-xl
                                        overflow-hidden
                                        bg-gray-100">

                                @if(!empty($item->image))

                                    <img src="{{ asset('storage/' . $item->image) }}"
                                         alt="{{ $item->title }}"
                                         class="story-image
                                                w-full
                                                h-full
                                                object-cover">

                                @else

                                    <div class="w-full
                                                h-full
                                                flex
                                                items-center
                                                justify-center
                                                text-gray-400
                                                text-sm
                                                font-bold">

                                        {{ $index + 1 }}

                                    </div>

                                @endif

                            </div>


                            {{-- TEXT --}}

                            <div class="flex-1 min-w-0">

                                <div class="text-[8px]
                                            uppercase
                                            tracking-widest
                                            text-gray-400
                                            mb-1">

                                    {{ $item->category->name ?? 'News' }}

                                </div>


                                <h3 class="text-sm
                                           font-bold
                                           leading-snug
                                           group-hover:text-gray-500
                                           transition">

                                    {{ \Illuminate\Support\Str::limit(
                                        $item->title,
                                        70
                                    ) }}

                                </h3>


                                @if($item->published_at)

                                    <div class="text-[8px]
                                                text-gray-400
                                                mt-2">

                                        {{ \Carbon\Carbon::parse(
                                            $item->published_at
                                        )->format('d M Y') }}

                                    </div>

                                @endif

                            </div>

                        </a>

                    @empty

                        <p class="text-sm
                                  text-gray-400
                                  py-5">

                            No latest stories available.

                        </p>

                    @endforelse

                </div>

            </section>


            {{-- CATEGORIES --}}

            <section class="soft-card
                            p-6
                            mt-7">

                <div class="text-[9px]
                            uppercase
                            tracking-[.2em]
                            text-gray-400">

                    Explore

                </div>


                <h2 class="text-xl
                           font-black
                           mt-1
                           mb-5">

                    Categories

                </h2>


                <div class="grid
                            grid-cols-2
                            gap-2">

                    @forelse($categories->take(10) as $category)

                        <a href="{{ frontend_category_url($category->slug) }}"
                           class="bg-[#f7f7f4]
                                  rounded-xl
                                  px-3
                                  py-3
                                  text-[9px]
                                  uppercase
                                  tracking-wider
                                  font-bold
                                  text-gray-600
                                  hover:bg-black
                                  hover:text-white
                                  transition">

                            {{ $category->name }}

                        </a>

                    @empty

                        <p class="col-span-2
                                  text-sm
                                  text-gray-400">

                            No categories available.

                        </p>

                    @endforelse

                </div>

            </section>


            {{-- NEWSLETTER --}}

            <section class="mt-7
                            bg-black
                            text-white
                            rounded-[22px]
                            p-7">

                <div class="text-[9px]
                            uppercase
                            tracking-[.25em]
                            text-gray-500">

                    Newsletter

                </div>


                <h2 class="text-2xl
                           font-black
                           leading-tight
                           mt-3">

                    Stories worth
                    reading.

                </h2>


                <p class="text-sm
                          text-gray-400
                          leading-6
                          mt-3">

                    Get the latest stories
                    directly in your inbox.

                </p>


                <form class="mt-5">

                    <input type="email"
                           placeholder="Your email"
                           class="w-full
                                  rounded-xl
                                  bg-white
                                  text-black
                                  px-4
                                  py-3
                                  text-sm
                                  outline-none">


                    <button type="button"
                            class="w-full
                                   mt-2
                                   bg-white
                                   text-black
                                   rounded-xl
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


{{-- ============================================================
     FOOTER
============================================================ --}}

<footer class="bg-white
               border-t
               border-gray-100
               mt-10">

    <div class="container-main
                px-5 lg:px-10
                py-12">

        <div class="grid
                    md:grid-cols-4
                    gap-10">


            {{-- BRAND --}}

            <div class="md:col-span-2">

                <div class="text-2xl
                            font-black">

                    {{ $siteName }}

                </div>


                <p class="text-sm
                          text-gray-500
                          leading-6
                          max-w-md
                          mt-4">

                    Independent journalism,
                    latest news and stories
                    that matter.

                </p>

            </div>


            {{-- CATEGORIES --}}

            <div>

                <h3 class="text-[9px]
                           uppercase
                           tracking-[.2em]
                           font-black
                           mb-5">

                    Explore

                </h3>


                <div class="grid
                            grid-cols-2
                            gap-3">

                    @foreach($categories->take(8) as $category)

                        <a href="{{ frontend_category_url($category->slug) }}"
                           class="text-xs
                                  text-gray-500
                                  hover:text-black">

                            {{ $category->name }}

                        </a>

                    @endforeach

                </div>

            </div>


            {{-- WEBSITE INFO --}}

            <div>

                <h3 class="text-[9px]
                           uppercase
                           tracking-[.2em]
                           font-black
                           mb-5">

                    About

                </h3>


                <p class="text-xs
                          text-gray-500
                          leading-6">

                    {{ $siteName }}

                    brings you the latest
                    news, stories and updates.

                </p>

            </div>

        </div>


        {{-- FOOTER BOTTOM --}}

        <div class="border-t
                    border-gray-100
                    mt-10
                    pt-5
                    flex
                    flex-col
                    sm:flex-row
                    justify-between
                    gap-3">

            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-gray-400">

                © {{ date('Y') }}
                {{ $siteName }}

            </span>


            <span class="text-[9px]
                         uppercase
                         tracking-widest
                         text-gray-400">

                Powered by NewsHub CMS

            </span>

        </div>

    </div>

</footer>


</body>

</html>