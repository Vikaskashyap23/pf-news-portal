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
                0 10px 35px rgba(0,0,0,.035);

        }


        .image-hover img {

            transition:
                transform .5s ease;

        }


        .image-hover:hover img {

            transform: scale(1.045);

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


        .hero-shape {

            border-radius:
                48% 52% 58% 42%
                / 43% 40% 60% 57%;

        }


        .story-image {

            transition:
                transform .45s ease;

        }


        .story-card:hover .story-image {

            transform: scale(1.04);

        }


        .sidebar-scroll::-webkit-scrollbar {

            width: 0;

        }


        .category-pill {

            transition:
                all .25s ease;

        }


        .category-pill:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(0,0,0,.08);

        }


        @media(max-width: 768px) {

            .hero-shape {

                border-radius: 30px;

            }

        }

    </style>

</head>


<body>


{{-- ========================================================= --}}
{{-- TOP HEADER --}}
{{-- ========================================================= --}}

<header class="bg-white border-b border-gray-100">


    <div class="container-main px-5 lg:px-10">


        <div class="h-[76px]
                    flex items-center
                    justify-between
                    gap-8">


            {{-- LOGO --}}

            <a href="{{ frontend_home_url() }}"
               class="shrink-0">


                <div class="text-[27px]
                            sm:text-[31px]
                            font-black
                            tracking-[-1.5px]
                            text-black">

                    {{ $website->name }}

                </div>


                <div class="text-[8px]
                            uppercase
                            tracking-[.28em]
                            text-gray-400
                            mt-[-2px]">

                    News & Lifestyle

                </div>

            </a>


            {{-- DESKTOP NAV --}}

            <nav class="hidden lg:flex
                        items-center
                        gap-7">


                <a href="{{ frontend_home_url() }}"
                   class="nav-link text-[12px]
                          font-semibold">

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



            </nav>


            {{-- RIGHT --}}

            <div class="flex items-center gap-3">


                <button class="w-9 h-9
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

                </button>


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


        {{-- MOBILE NAV --}}

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



{{-- ========================================================= --}}
{{-- BREAKING NEWS --}}
{{-- ========================================================= --}}

@if($breakingNews->count())

<div class="bg-[#111] text-white">


    <div class="container-main
                px-5 lg:px-10">


        <div class="min-h-[42px]
                    flex items-center
                    gap-4
                    overflow-hidden">


            <span class="shrink-0
                         text-[9px]
                         uppercase
                         tracking-[.2em]
                         font-bold
                         text-white">

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



{{-- ========================================================= --}}
{{-- MAIN --}}
{{-- ========================================================= --}}

<main class="container-main
             px-5 lg:px-10
             py-8 lg:py-12">



{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

@php

    $hero = $featuredNews->first();

    $secondaryNews = $featuredNews
        ->skip(1)
        ->take(3);

@endphp


<section class="grid
                lg:grid-cols-12
                gap-8
                items-center
                mb-14">


    {{-- HERO TEXT --}}

    <div class="lg:col-span-6
                order-2
                lg:order-1
                px-2
                lg:px-8">


        <div class="text-[10px]
                    uppercase
                    tracking-[.25em]
                    text-gray-400
                    font-bold
                    mb-5">

            Featured Story

        </div>


        <a href="{{ frontend_news_url($hero->slug) }}">


            <h1 class="text-4xl
                       sm:text-5xl
                       lg:text-[60px]
                       xl:text-[70px]
                       leading-[.98]
                       tracking-[-3px]
                       font-black
                       text-black
                       hover:text-gray-600
                       transition">

                {{ $hero->title }}

            </h1>


        </a>


        <p class="mt-6
                  max-w-lg
                  text-[14px]
                  sm:text-[15px]
                  leading-7
                  text-gray-500">

            {{ \Illuminate\Support\Str::limit(
                strip_tags($hero->description),
                190
            ) }}

        </p>


        <div class="flex items-center
                    gap-4
                    mt-6">


            <a href="{{ frontend_news_url($hero->slug) }}"
               class="inline-flex
                      items-center
                      gap-3
                      bg-black
                      text-white
                      rounded-full
                      px-6 py-3
                      text-[10px]
                      uppercase
                      tracking-widest
                      font-bold
                      hover:bg-gray-800
                      transition">

                Read Story

                <span>→</span>

            </a>


            <span class="text-[10px]
                         uppercase
                         tracking-widest
                         text-gray-400">

                {{ optional($hero->published_at)->diffForHumans() }}

            </span>


        </div>


    </div>



    {{-- HERO IMAGE --}}

    <div class="lg:col-span-6
                order-1
                lg:order-2
                flex justify-center">


        @if($hero->featured_image)

            <div class="relative
                        w-full
                        max-w-[560px]
                        aspect-square">


                {{-- soft background shape --}}

                <div class="absolute
                            inset-5
                            bg-[#ecebe6]
                            hero-shape">
                </div>


                <div class="absolute
                            inset-10
                            overflow-hidden
                            hero-shape
                            z-10
                            shadow-xl">


                    <img src="{{ asset(
                        'storage/' . $hero->featured_image
                    ) }}"
                         alt="{{ $hero->title }}"
                         class="w-full
                                h-full
                                object-cover">


                </div>


            </div>

        @else

            <div class="w-full
                        max-w-[560px]
                        aspect-square
                        rounded-[40%]
                        bg-[#ecebe6]">

            </div>

        @endif


    </div>


</section>

@endif



{{-- ========================================================= --}}
{{-- CATEGORY STRIP --}}
{{-- ========================================================= --}}

<section class="mb-14">


    <div class="flex items-center
                justify-between
                mb-5">


        <div>

            <div class="text-[10px]
                        uppercase
                        tracking-[.2em]
                        text-gray-400">

                Explore

            </div>

            <h2 class="text-xl
                       font-black
                       mt-1">

                Discover Stories

            </h2>

        </div>


        <span class="hidden sm:block
                     text-[10px]
                     text-gray-400">

            Browse by category

        </span>


    </div>



    <div class="grid
                grid-cols-2
                sm:grid-cols-4
                lg:grid-cols-6
                gap-3">


        @foreach($categories->take(6) as $category)


            <a href="{{ frontend_category_url($category->slug) }}"
               class="category-pill
                      bg-white
                      border
                      border-gray-100
                      rounded-2xl
                      px-4
                      py-5
                      text-center">


                <div class="w-9 h-9
                            mx-auto
                            rounded-full
                            bg-[#f0f0ed]
                            flex items-center
                            justify-center
                            mb-3">


                    <span class="text-sm
                                 font-bold">

                        {{ strtoupper(
                            substr($category->name, 0, 1)
                        ) }}

                    </span>


                </div>


                <div class="text-[10px]
                            uppercase
                            tracking-wider
                            font-bold">

                    {{ $category->name }}

                </div>


            </a>


        @endforeach


    </div>


</section>



{{-- ========================================================= --}}
{{-- CONTENT AREA --}}
{{-- ========================================================= --}}

<div class="grid
            lg:grid-cols-12
            gap-8">



{{-- ========================================================= --}}
{{-- LEFT --}}
{{-- ========================================================= --}}

<section class="lg:col-span-8">


    <div class="flex items-end
                justify-between
                border-b
                border-gray-200
                pb-4
                mb-6">


        <div>

            <div class="text-[9px]
                        uppercase
                        tracking-[.25em]
                        text-gray-400">

                Latest

            </div>

            <h2 class="text-2xl
                       sm:text-3xl
                       font-black
                       tracking-tight">

                Latest Stories

            </h2>

        </div>


        <span class="text-[9px]
                     uppercase
                     tracking-widest
                     text-gray-400">

            {{ $latestNews->count() }} Stories

        </span>


    </div>



    {{-- FEATURED LARGE STORY --}}

    @if($secondaryNews->count())


        @php

            $largeStory = $secondaryNews->first();

        @endphp


        <article class="soft-card
                        overflow-hidden
                        mb-7
                        story-card">


            <div class="grid
                        md:grid-cols-2">


                @if($largeStory->featured_image)

                    <div class="aspect-[4/3]
                                md:aspect-auto
                                overflow-hidden">

                        <img src="{{ asset(
                            'storage/' .
                            $largeStory->featured_image
                        ) }}"
                             alt="{{ $largeStory->title }}"
                             class="story-image
                                    w-full
                                    h-full
                                    object-cover">

                    </div>

                @endif


                <div class="p-6
                            sm:p-8
                            flex
                            flex-col
                            justify-center">


                    <div class="text-[9px]
                                uppercase
                                tracking-[.2em]
                                text-gray-400
                                font-bold
                                mb-3">

                        {{ $largeStory->category->name ?? 'News' }}

                    </div>


                    <a href="{{ frontend_news_url($largeStory->slug) }}">


                        <h3 class="text-2xl
                                   sm:text-3xl
                                   leading-tight
                                   font-black
                                   hover:text-gray-500
                                   transition">

                            {{ $largeStory->title }}

                        </h3>


                    </a>


                    <p class="text-sm
                              leading-6
                              text-gray-500
                              mt-4">

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($largeStory->description),
                            125
                        ) }}

                    </p>


                    <div class="mt-5
                                text-[9px]
                                uppercase
                                tracking-widest
                                text-gray-400">

                        {{ optional(
                            $largeStory->published_at
                        )->diffForHumans() }}

                    </div>


                </div>


            </div>


        </article>


    @endif



    {{-- STORY GRID --}}

    <div class="grid
                sm:grid-cols-2
                gap-5">


        @forelse(
            $latestNews->take(6) as $item
        )


            <article class="story-card
                            soft-card
                            overflow-hidden">


                @if($item->featured_image)

                    <div class="aspect-[16/10]
                                overflow-hidden">

                        <img src="{{ asset(
                            'storage/' .
                            $item->featured_image
                        ) }}"
                             alt="{{ $item->title }}"
                             class="story-image
                                    w-full
                                    h-full
                                    object-cover">

                    </div>

                @endif


                <div class="p-5">


                    <div class="flex
                                items-center
                                gap-2
                                mb-3">


                        <span class="text-[8px]
                                     uppercase
                                     tracking-widest
                                     font-bold
                                     text-gray-400">

                            {{ $item->category->name ?? 'News' }}

                        </span>


                        <span class="text-gray-300">
                            •
                        </span>


                        <span class="text-[8px]
                                     uppercase
                                     tracking-widest
                                     text-gray-400">

                            {{ optional(
                                $item->published_at
                            )->diffForHumans() }}

                        </span>


                    </div>


                    <a href="{{ frontend_news_url($item->slug) }}">


                        <h3 class="text-lg
                                   font-black
                                   leading-tight
                                   hover:text-gray-500
                                   transition">

                            {{ $item->title }}

                        </h3>


                    </a>


                    <p class="text-xs
                              text-gray-500
                              leading-5
                              mt-3">

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($item->description),
                            90
                        ) }}

                    </p>


                </div>


            </article>


        @empty


            <div class="sm:col-span-2
                        soft-card
                        py-16
                        text-center">


                <div class="text-3xl">
                    📰
                </div>


                <h3 class="font-bold mt-3">

                    No published news available.

                </h3>


            </div>


        @endforelse


    </div>



    {{-- PAGINATION --}}

    @if($latestNews->hasPages())

        <div class="mt-8">

            {{ $latestNews->links() }}

        </div>

    @endif


</section>



{{-- ========================================================= --}}
{{-- RIGHT SIDEBAR --}}
{{-- ========================================================= --}}

<aside class="lg:col-span-4">


    {{-- POPULAR --}}

    <section class="soft-card
                    p-6
                    sticky
                    top-28">


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

                    Popular

                </div>


                <h2 class="text-xl
                           font-black">

                    Most Read

                </h2>

            </div>


            <span class="text-xl">
                ✦
            </span>


        </div>



        <div>


            @foreach($latestNews->take(5) as $index => $item)


                <a href="{{ frontend_news_url($item->slug) }}"
                   class="flex
                          gap-4
                          py-5
                          border-b
                          border-gray-100
                          last:border-0
                          group">


                    <div class="w-14
                                h-14
                                shrink-0
                                rounded-xl
                                overflow-hidden
                                bg-gray-100">


                        @if($item->featured_image)

                            <img src="{{ asset(
                                'storage/' .
                                $item->featured_image
                            ) }}"
                                 alt=""
                                 class="w-full
                                        h-full
                                        object-cover
                                        group-hover:scale-105
                                        transition">

                        @else

                            <div class="w-full
                                        h-full
                                        flex
                                        items-center
                                        justify-center
                                        text-gray-400">

                                {{ $index + 1 }}

                            </div>

                        @endif


                    </div>


                    <div class="flex-1">


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


        </div>


    </section>



    {{-- CATEGORIES --}}

    <section class="mt-7
                    soft-card
                    p-6">


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


            @foreach($categories->take(10) as $category)


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


            @endforeach


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



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

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

                    {{ $website->name }}

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



            {{-- CONTACT --}}

            <div>


                <h3 class="text-[9px]
                           uppercase
                           tracking-[.2em]
                           font-black
                           mb-5">

                    Contact

                </h3>


                @if($setting?->email)

                    <a href="mailto:{{ $setting->email }}"
                       class="text-xs
                              text-gray-500
                              break-all
                              hover:text-black">

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
                {{ $website->name }}

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