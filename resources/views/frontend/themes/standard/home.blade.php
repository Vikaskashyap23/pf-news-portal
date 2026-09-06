<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }}</title>

    <meta name="description"
           content="{{ $setting->meta_description ?? 'Latest news and breaking news.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .headline-font {
            font-family: Georgia, 'Times New Roman', serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>

</head>


<body class="bg-gray-100 text-gray-900">


{{-- ========================================================= --}}
{{-- TOP BAR --}}
{{-- ========================================================= --}}

<div class="bg-gray-900 text-gray-300">

    <div class="max-w-7xl mx-auto px-4">

        <div class="h-9 flex items-center justify-between text-xs">

            <div>
                {{ now()->format('l, d F Y') }}
            </div>

            <div class="hidden sm:block">

                {{ __('messages.independent_news') ?? 'Independent News' }}

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- MAIN HEADER --}}
{{-- ========================================================= --}}

<header class="bg-white border-b border-gray-300">

    <div class="max-w-7xl mx-auto px-4">

        <div class="py-5 flex items-center justify-between">


            {{-- LOGO + SITE NAME --}}

            <a href="{{ frontend_home_url() }}"
               class="flex items-center gap-4">

                <div class="w-12 h-12 bg-red-600 text-white
                            flex items-center justify-center
                            font-black text-2xl rounded">

                      {{ strtoupper(substr($website->name, 0, 1 )) }}
                    

                </div>

                <div>

                    <h1 class="text-2xl sm:text-3xl
                               font-black
                               tracking-tight">

                        {{ $website->name }}

                    </h1>

                    <p class="text-xs text-gray-500 uppercase tracking-widest">

                        News • Ideas • Perspective

                    </p>

                </div>

            </a>


            {{-- SEARCH --}}

            <button
                id="standardSearchButton"
                class="hidden sm:flex
                       items-center gap-2
                       border border-gray-300
                       px-4 py-2
                       rounded
                       text-sm
                       hover:border-red-600
                       hover:text-red-600">

                🔍

                {{ __('messages.search') }}

            </button>

        </div>


        {{-- ================================================= --}}
        {{-- CATEGORY NAVIGATION --}}
        {{-- ================================================= --}}

        <nav class="border-t border-gray-200">

            <div class="flex gap-7
                        overflow-x-auto
                        whitespace-nowrap
                        hide-scrollbar">


                <a href="{{ frontend_home_url() }}"
                   class="py-4
                          text-sm
                          font-bold
                          text-red-600
                          border-b-2
                          border-red-600">

                    {{ __('messages.home') }}

                </a>


                @foreach($categories as $category)
                      <a href="{{ frontend_category_url($category->slug) }}"
                       class="py-4
                              text-sm
                              font-semibold
                              text-gray-600
                              hover:text-red-600
                              border-b-2
                              border-transparent
                              hover:border-red-600">

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

<section class="bg-red-600 text-white">

    <div class="max-w-7xl mx-auto px-4">

        <div class="flex items-center">

            <div class="font-black text-xs
                        uppercase
                        tracking-wider
                        py-3
                        pr-6
                        border-r border-red-400">

                🔴 Breaking

            </div>


            <div class="flex gap-8
                        overflow-x-auto
                        whitespace-nowrap
                        hide-scrollbar
                        px-5">

                @foreach($breakingNews as $breaking)

                    <a href="{{ frontend_news_url($breaking->slug) }}"
                       class="text-sm
                              font-semibold
                              py-3
                              hover:underline">

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

<main class="max-w-7xl mx-auto px-4 py-8">


{{-- ========================================================= --}}
{{-- FEATURED NEWS --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

    @php

        $hero = $featuredNews->first();

        $secondaryNews = $featuredNews
            ->skip(1)
            ->take(4);

    @endphp


    <section class="mb-10">


        {{-- SECTION TITLE --}}

        <div class="flex items-center
                    justify-between
                    border-b-2
                    border-gray-900
                    pb-3
                    mb-6">

            <h2 class="text-2xl
                       font-black
                       headline-font">

                {{ __('messages.top_stories') }}

            </h2>

            <span class="text-xs
                         text-gray-500
                         uppercase
                         tracking-widest">

                {{ __('messages.featured') }}

            </span>

        </div>



        {{-- HERO GRID --}}

        <div class="grid lg:grid-cols-3 gap-6">


            {{-- MAIN STORY --}}

            <article class="lg:col-span-2
                            bg-white
                            border
                            border-gray-200
                            rounded-lg
                            overflow-hidden
                            shadow-sm
                            hover:shadow-lg
                            transition">


                @if($hero->featured_image)

                    <a href="{{ frontend_news_url($hero->slug) }}">

                        <div class="relative h-72 sm:h-96 overflow-hidden">
                             <img
                                src="{{ asset('storage/' . $hero->featured_image) }}"
                                alt="{{ $hero->title }}"
                                class="w-full h-full
                                       object-cover
                                       hover:scale-105
                                       transition
                                       duration-500">


                            <div class="absolute
                                        bottom-0
                                        left-0
                                        right-0
                                        p-6
                                        bg-gradient-to-t
                                        from-black/90
                                        to-transparent">

                                <span class="text-red-400
                                             text-xs
                                             font-bold
                                             uppercase">

                                    {{ $hero->category->name ?? 'News' }}

                                </span>


                                <h1 class="headline-font
                                           text-white
                                           text-2xl
                                           sm:text-4xl
                                           font-bold
                                           mt-2">

                                    {{ $hero->title }}

                                </h1>

                            </div>

                        </div>

                    </a>

                @endif


                <div class="p-5">

                    <p class="text-gray-600
                              text-sm
                              leading-6">

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($hero->description),
                            220
                        ) }}

                    </p>

                </div>

            </article>



            {{-- SECONDARY STORIES --}}

            <div class="space-y-4">

                @foreach($secondaryNews as $item)

                    <article class="bg-white
                                    border
                                    border-gray-200
                                    rounded-lg
                                    p-4
                                    hover:shadow-md
                                    transition">

                        <div class="flex gap-4">


                            @if($item->featured_image)

                                <div class="w-28
                                            h-24
                                            flex-shrink-0
                                            overflow-hidden
                                            rounded">

                                    <img
                                        src="{{ asset('storage/' . $item->featured_image) }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-full
                                               object-cover">

                                </div>

                            @endif


                            <div class="min-w-0">

                                <div class="text-xs
                                            text-red-600
                                            font-bold
                                            uppercase">

                                    {{ $item->category->name ?? 'News' }}

                                </div>


                                <a href="{{ frontend_news_url($item->slug) }}">
                                    <h3 class="headline-font
                                               font-bold
                                               text-lg
                                               leading-tight
                                               mt-1
                                               hover:text-red-600">

                                        {{ $item->title }}

                                    </h3>

                                </a>


                                <div class="text-xs
                                            text-gray-400
                                            mt-2">

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
{{-- LATEST NEWS --}}
{{-- ========================================================= --}}

<div class="grid lg:grid-cols-3 gap-8">


{{-- ========================================================= --}}
{{-- NEWS LIST --}}
{{-- ========================================================= --}}

<section class="lg:col-span-2">


    <div class="flex items-center
                justify-between
                border-b-2
                border-gray-900
                pb-3
                mb-5">

        <h2 class="text-2xl
                   font-black
                   headline-font">

            {{ __('messages.latest_news') }}

        </h2>

    </div>


    <div class="space-y-4">


        @forelse($latestNews as $item)

            <article class="bg-white
                            border
                            border-gray-200
                            rounded-lg
                            p-4
                            hover:shadow-md
                            transition">


                <div class="flex
                            flex-col
                            sm:flex-row
                            gap-5">


                    @if($item->featured_image)

                        <a href="{{ frontend_news_url($item->slug) }}"
                           class="sm:w-48
                                  h-40
                                  flex-shrink-0
                                  overflow-hidden
                                  rounded">

                            <img
                                src="{{ asset('storage/' . $item->featured_image) }}"
                                alt="{{ $item->title }}"
                                class="w-full h-full
                                       object-cover
                                       hover:scale-105
                                       transition">

                        </a>

                    @endif


                    <div class="flex-1">


                        <div class="flex items-center gap-2
                                    text-xs
                                    uppercase
                                    font-bold">

                            <span class="text-red-600">

                                {{ $item->category->name ?? 'News' }}

                            </span>

                            <span class="text-gray-300">
                                •
                            </span>

                            <span class="text-gray-400">

                                {{ optional($item->published_at)->diffForHumans() }}

                            </span>

                        </div>


                        <a href="{{ frontend_news_url($item->slug) }}">
                            <h3 class="headline-font
                                       text-xl
                                       font-bold
                                       mt-2
                                       hover:text-red-600">

                                {{ $item->title }}

                            </h3>

                        </a>


                        <p class="text-sm
                                  text-gray-500
                                  leading-6
                                  mt-2">

                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($item->description),
                                150
                            ) }}

                        </p>


                        <div class="mt-3">

                            <a href="{{ frontend_news_url($item->slug) }}"
                               class="text-xs
                                      font-bold
                                      text-red-600
                                      hover:underline">

                                {{ __('messages.read_full_story') }} →

                            </a>

                        </div>

                    </div>

                </div>

            </article>

        @empty

            <div class="bg-white
                        border
                        rounded-lg
                        p-10
                        text-center
                        text-gray-500">

                No published news available yet.

            </div>

        @endforelse


    </div>


    {{-- PAGINATION --}}

    @if($latestNews->hasPages())

        <div class="mt-6">

            {{ $latestNews->links() }}

        </div>

    @endif


</section>



{{-- ========================================================= --}}
{{-- SIDEBAR --}}
{{-- ========================================================= --}}

<aside class="space-y-6">


{{-- TRENDING --}}

<section class="bg-white
                border
                border-gray-200
                rounded-lg
                overflow-hidden">


    <div class="bg-gray-900
                text-white
                px-5
                py-4">

        <h2 class="font-black
                   uppercase
                   text-sm
                   tracking-wider">

            {{ __('messages.trending') }}

        </h2>

    </div>


    <div>

        @foreach($latestNews->take(5) as $index => $item)

            <a href="{{ frontend_news_url($item->slug) }}"
               class="block
                      p-4
                      border-b
                      border-gray-100
                      hover:bg-gray-50">

                <div class="flex gap-3">

                    <span class="text-2xl
                                 font-black
                                 text-gray-200">

                        {{ str_pad(
                            $index + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}

                    </span>


                    <div>

                        <div class="text-xs
                                    text-red-600
                                    font-bold">

                            {{ $item->category->name ?? 'News' }}

                        </div>


                        <h3 class="headline-font
                                   font-bold
                                   leading-tight
                                   mt-1">

                            {{ $item->title }}

                        </h3>

                    </div>

                </div>

            </a>

        @endforeach

    </div>

</section>



{{-- CATEGORIES --}}
               <section class="bg-white
                border
                border-gray-200
                rounded-lg
                p-5">


    <h2 class="font-black
               text-lg
               headline-font
               border-b
               pb-3
               mb-4">

        Categories

    </h2>


    <div class="grid grid-cols-2 gap-2">

        @foreach($categories as $category)

            <a href="{{ frontend_category_url($category->slug) }}"
               class="text-sm
                      text-gray-600
                      hover:text-red-600
                      hover:underline">

                {{ $category->name }}

            </a>

        @endforeach

    </div>

</section>

</aside>

</div>

</main>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-gray-900 text-gray-400 mt-10">


    <div class="max-w-7xl mx-auto px-4 py-10">


        <div class="grid md:grid-cols-3 gap-8">


            <div>

                <h2 class="text-white
                           text-xl
                           font-black">

                    {{ $website->name }}

                </h2>

                <p class="text-sm
                          leading-6
                          mt-3">

                    Latest news, breaking stories
                    and important updates.

                </p>

            </div>


            <div>

                <h3 class="text-white
                           font-bold
                           mb-3">

                    Categories

                </h3>

                <div class="space-y-2">

                    @foreach($categories->take(6) as $category)

                        <a href="{{ frontend_category_url($category->slug) }}"
                           class="block
                                  text-sm
                                  hover:text-white">

                            {{ $category->name }}

                        </a>

                    @endforeach

                </div>

            </div>


            <div>

                <h3 class="text-white
                           font-bold
                           mb-3">

                    Contact

                </h3>

                @if($setting?->email)

                    <p class="text-sm">
                        {{ $setting->email }}
                    </p>

                @endif

                @if($setting?->phone)

                    <p class="text-sm mt-2">
                        {{ $setting->phone }}
                    </p>

                @endif

            </div>

        </div>


        <div class="border-t
                    border-gray-700
                    mt-8
                    pt-5
                    text-center
                    text-xs">

            © {{ date('Y') }}
            {{ $website->name }}.
            All rights reserved.

        </div>

    </div>

</footer>



{{-- ========================================================= --}}
{{-- SEARCH OVERLAY --}}
{{-- ========================================================= --}}

<div id="standardSearch"
     class="hidden fixed inset-0
            bg-black/60
            z-50
            items-start
            justify-center
            pt-24
            px-4">


    <div class="bg-white
                rounded-xl
                shadow-2xl
                w-full
                max-w-xl
                p-6">


        <div class="flex justify-between
                    items-center
                    mb-5">

            <h2 class="text-xl
                       font-black">

                {{ __('messages.search') }}

            </h2>
             <button
                onclick="closeStandardSearch()"
                class="text-gray-500
                       text-xl">

                ✕

            </button>

        </div>


        <form
            action="{{ frontend_search_url() }}"
            method="GET"
            class="flex gap-2">


            <input
                type="search"
                name="q"
                placeholder="Search news..."
                class="flex-1
                       border
                       border-gray-300
                       rounded-lg
                       px-4
                       py-3
                       outline-none
                       focus:border-red-600">


            <button
                type="submit"
                class="bg-red-600
                       text-white
                       px-5
                       rounded-lg
                       font-bold">

                Search

            </button>

        </form>

    </div>

</div>



<script>

const standardSearchButton =
    document.getElementById('standardSearchButton');

const standardSearch =
    document.getElementById('standardSearch');


if (standardSearchButton && standardSearch) {

    standardSearchButton.addEventListener('click', function () {

        standardSearch.classList.remove('hidden');

        standardSearch.classList.add('flex');

    });

}


function closeStandardSearch() {

    standardSearch.classList.add('hidden');

    standardSearch.classList.remove('flex');

}


document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeStandardSearch();

    }

});

</script>


</body>

</html>