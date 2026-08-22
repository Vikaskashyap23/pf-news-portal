 <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }}</title>

    <meta name="description"
          content="{{ $setting->meta_description ?? 'Latest news and updates.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    fontFamily: {

                        sans: ['Inter', 'Arial', 'sans-serif'],

                        display: ['Poppins', 'Arial', 'sans-serif'],

                    },

                    colors: {

                        modern: {

                            primary: '#6366f1',

                            dark: '#111827',

                            soft: '#eef2ff',

                        }

                    }

                }

            }

        }

    </script>


    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <style>

        body {
            font-family: 'Inter', sans-serif;
        }

        .display-font {
            font-family: 'Poppins', sans-serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

    </style>

</head>


<body class="bg-slate-50 text-slate-900">


{{-- ========================================================= --}}
{{-- MODERN TOP BAR --}}
{{-- ========================================================= --}}

<div class="bg-slate-950 text-slate-300">

    <div class="max-w-7xl mx-auto px-4">

        <div class="h-9 flex items-center justify-between text-xs">

            <div class="flex items-center gap-2">

                <span class="w-2 h-2
                             bg-indigo-500
                             rounded-full
                             animate-pulse">
                </span>

                <span>
                    {{ now()->format('l, d F Y') }}
                </span>

            </div>


            <div class="hidden sm:block text-slate-500">

                {{ __('messages.independent_news') ?? 'Independent News' }}

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODERN HEADER --}}
{{-- ========================================================= --}}

<header class="bg-white/95
               backdrop-blur-xl
               sticky top-0
               z-40
               border-b border-slate-200">


    <div class="max-w-7xl mx-auto px-4">


        <div class="h-20
                    flex
                    items-center
                    justify-between">


            {{-- BRAND --}}

            <a href="{{ route('frontend.website', [
                'slug' => $website->slug
            ]) }}"
               class="flex items-center gap-3">


                <div class="w-11 h-11
                            rounded-2xl
                            bg-gradient-to-br
                            from-indigo-500
                            to-violet-600
                            text-white
                            flex items-center
                            justify-center
                            font-black
                            text-xl
                            shadow-lg
                            shadow-indigo-200">

                      {{ strtoupper(substr($website->name, 0, 1 )) }}
                    

                </div>


                <div>

                    <h1 class="display-font
                               text-xl
                               sm:text-2xl
                               font-extrabold
                               tracking-tight">
                            {{ $website->name }}

                    </h1>


                    <p class="hidden sm:block
                              text-[9px]
                              uppercase
                              tracking-[0.3em]
                              text-slate-400
                              font-bold">

                        Modern News Network

                    </p>

                </div>

            </a>



            {{-- SEARCH --}}

            <button
                id="modernSearchButton"
                class="flex items-center gap-2
                       px-4 py-2.5
                       rounded-xl
                       bg-slate-100
                       text-slate-700
                       text-sm
                       font-semibold
                       hover:bg-indigo-50
                       hover:text-indigo-600
                       transition">

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35
                           m2.35-5.65
                           a8 8 0 1 1-16 0
                           8 8 0 0 1 16 0Z"/>

                </svg>

                <span class="hidden sm:inline">

                    {{ __('messages.search') }}

                </span>

            </button>

        </div>



        {{-- ================================================= --}}
        {{-- MODERN CATEGORY NAV --}}
        {{-- ================================================= --}}

        <nav>

            <div class="flex items-center
                        gap-2
                        overflow-x-auto
                        whitespace-nowrap
                        hide-scrollbar
                        pb-3">


                <a href="{{ route('frontend.website', [
                    'slug' => $website->slug
                ]) }}"
                   class="px-4 py-2
                          rounded-full
                          bg-indigo-600
                          text-white
                          text-xs
                          font-bold
                          shadow-sm
                          shadow-indigo-200">

                    {{ __('messages.home') }}

                </a>


                @foreach($categories as $category)

                    <a href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                        'categorySlug' => $category->slug
                    ]) }}"
                       class="px-4 py-2
                              rounded-full
                              bg-slate-100
                              text-slate-600
                              text-xs
                              font-semibold
                              hover:bg-indigo-50
                              hover:text-indigo-600
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

<section class="bg-gradient-to-r
                from-indigo-600
                via-violet-600
                to-purple-600
                text-white">


    <div class="max-w-7xl mx-auto px-4">


        <div class="flex items-center">


            <div class="flex-shrink-0
                        py-3
                        pr-5
                        font-black
                        text-xs
                        uppercase
                        tracking-wider">
                        <span class="inline-flex
                             items-center
                             gap-2">

                    <span class="w-2 h-2
                                 bg-white
                                 rounded-full
                                 animate-pulse">
                    </span>

                    Breaking

                </span>

            </div>


            <div class="flex gap-8
                        overflow-x-auto
                        whitespace-nowrap
                        hide-scrollbar">


                @foreach($breakingNews as $breaking)

                    <a href="{{ route('frontend.news', [
                        'websiteSlug' => $website->slug,
                        'newsSlug' => $breaking->slug
                    ]) }}"
                       class="text-sm
                              font-medium
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
{{-- MAIN CONTENT --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto
             px-4
             py-8
             sm:py-10">



{{-- ========================================================= --}}
{{-- MODERN HERO --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

    @php

        $hero = $featuredNews->first();

        $secondaryNews = $featuredNews
            ->skip(1)
            ->take(4);

    @endphp


    <section class="mb-12">


        <div class="flex items-end
                    justify-between
                    mb-5">


            <div>

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-[0.2em]
                          text-indigo-600">

                    {{ __('messages.featured') }}

                </p>


                <h2 class="display-font
                           text-2xl
                           sm:text-3xl
                           font-extrabold
                           mt-1">

                    {{ __('messages.top_stories') }}

                </h2>

            </div>


            <div class="hidden sm:block
                        text-xs
                        text-slate-400">

                Latest updates

            </div>

        </div>



        <div class="grid
                    lg:grid-cols-12
                    gap-5">


            {{-- MAIN HERO --}}

            <article class="lg:col-span-7
                            relative
                            overflow-hidden
                            rounded-3xl
                            bg-slate-900
                            min-h-[430px]
                            group">


                @if($hero->featured_image)

                    <img
                        src="{{ asset('storage/' . $hero->featured_image) }}"
                        alt="{{ $hero->title }}"
                        class="absolute
                               inset-0
                               w-full
                               h-full
                               object-cover
                               opacity-90
                               group-hover:scale-105
                               transition
                               duration-700">


                    <div class="absolute
                                inset-0
                                bg-gradient-to-t
                                from-black/90
                                via-black/30
                                to-transparent">
                    </div>

                @else
                               <div class="absolute inset-0
                                bg-gradient-to-br
                                from-indigo-600
                                to-violet-700">
                    </div>

                @endif


                <div class="absolute
                            left-0
                            right-0
                            bottom-0
                            p-6
                            sm:p-8
                            text-white">


                    <div class="flex items-center gap-2
                                text-xs
                                uppercase
                                tracking-wider
                                font-bold
                                mb-3">


                        <span class="px-3 py-1
                                     rounded-full
                                     bg-indigo-500">

                            {{ $hero->category->name ?? 'News' }}

                        </span>


                        <span class="text-white/60">

                            {{ optional($hero->published_at)->diffForHumans() }}

                        </span>

                    </div>


                    <a href="{{ route('frontend.news', [
                        'websiteSlug' => $website->slug,
                        'newsSlug' => $hero->slug
                    ]) }}">


                        <h1 class="display-font
                                   text-3xl
                                   sm:text-4xl
                                   lg:text-5xl
                                   font-extrabold
                                   leading-tight
                                   hover:text-indigo-200
                                   transition">

                            {{ $hero->title }}

                        </h1>


                    </a>


                    <p class="hidden sm:block
                              text-sm
                              text-white/70
                              mt-4
                              max-w-2xl">

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags($hero->description),
                            180
                        ) }}

                    </p>


                </div>

            </article>



            {{-- SIDE FEATURE CARDS --}}

            <div class="lg:col-span-5
                        grid
                        sm:grid-cols-2
                        lg:grid-cols-1
                        gap-5">


                @foreach($secondaryNews as $item)


                    <article class="bg-white
                                    rounded-2xl
                                    border border-slate-200
                                    p-3
                                    shadow-sm
                                    hover:shadow-xl
                                    hover:-translate-y-0.5
                                    transition">


                        <div class="flex gap-4">


                            @if($item->featured_image)

                                <div class="w-28
                                            h-24
                                            flex-shrink-0
                                            overflow-hidden
                                            rounded-xl">

                                    <img
                                        src="{{ asset('storage/' . $item->featured_image) }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-full
                                               object-cover
                                               hover:scale-110
                                               transition">

                                </div>

                            @endif


                            <div class="min-w-0">
                             <div class="text-[10px]
                                            uppercase
                                            font-bold
                                            text-indigo-600">

                                    {{ $item->category->name ?? 'News' }}

                                </div>


                                <a href="{{ route('frontend.news', [
                                    'websiteSlug' => $website->slug,
                                    'newsSlug' => $item->slug
                                ]) }}">


                                    <h3 class="display-font
                                               text-base
                                               font-bold
                                               leading-snug
                                               mt-1
                                               hover:text-indigo-600">

                                        {{ $item->title }}

                                    </h3>


                                </a>


                                <div class="text-[10px]
                                            text-slate-400
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
{{-- NEWS + SIDEBAR --}}
{{-- ========================================================= --}}

<div class="grid lg:grid-cols-12 gap-7">



{{-- ========================================================= --}}
{{-- LATEST NEWS --}}
{{-- ========================================================= --}}

<section class="lg:col-span-8">


    <div class="flex items-center
                justify-between
                mb-5">


        <div>

            <p class="text-xs
                      uppercase
                      tracking-widest
                      font-bold
                      text-indigo-600">

                News Feed

            </p>


            <h2 class="display-font
                       text-2xl
                       font-extrabold">

                {{ __('messages.latest_news') }}

            </h2>

        </div>


        <span class="hidden sm:block
                     px-3 py-1
                     rounded-full
                     bg-indigo-50
                     text-indigo-600
                     text-xs
                     font-bold">

            LIVE

        </span>

    </div>



    <div class="space-y-4">


        @forelse($latestNews as $item)


            <article class="bg-white
                            rounded-2xl
                            border border-slate-200
                            p-4
                            hover:shadow-xl
                            transition">


                <div class="flex
                            flex-col
                            sm:flex-row
                            gap-5">


                    @if($item->featured_image)

                        <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $item->slug
                        ]) }}"
                           class="sm:w-48
                                  h-40
                                  flex-shrink-0
                                  overflow-hidden
                                  rounded-xl">


                            <img
                                src="{{ asset('storage/' . $item->featured_image) }}"
                                alt="{{ $item->title }}"
                                class="w-full
                                       h-full
                                       object-cover
                                       hover:scale-105
                                       transition
                                       duration-500">

                        </a>

                    @endif



                    <div class="flex-1">


                        <div class="flex items-center
                                    gap-2
                                    text-[10px]
                                    uppercase
                                    font-bold">


                            <span class="text-indigo-600">

                                {{ $item->category->name ?? 'News' }}

                            </span>


                            <span class="text-slate-300">
                                •
                            </span>


                            <span class="text-slate-400">

                                {{ optional($item->published_at)->diffForHumans() }}

                            </span>

                        </div>



                        <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $item->slug
                        ]) }}">


                            <h3 class="display-font
                                       text-xl
                                       sm:text-2xl
                                       font-bold
                                       leading-tight
                                       mt-2
                                       hover:text-indigo-600">

                                {{ $item->title }}

                            </h3>


                        </a>



                        <p class="text-sm
                                  text-slate-500
                                  leading-6
                                  mt-2">


                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($item->description),
                                150
                            ) }}


                        </p>



                        <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $item->slug
                        ]) }}"
                           class="inline-flex
                                  items-center
                                  gap-2
                                  mt-3
                                  text-xs
                                  font-bold
                                  text-indigo-600
                                  hover:text-indigo-800">


                            {{ __('messages.read_full_story') }}

                            <span>→</span>


                        </a>


                    </div>

                </div>

            </article>


        @empty


            <div class="bg-white
                        rounded-2xl
                        border
                        p-10
                        text-center
                        text-slate-500">

                No published news available yet.

            </div>


        @endforelse


    </div>



    @if($latestNews->hasPages())

        <div class="mt-6">

            {{ $latestNews->links() }}

        </div>

    @endif


</section>



{{-- ========================================================= --}}
{{-- MODERN SIDEBAR --}}
{{-- ========================================================= --}}

<aside class="lg:col-span-4 space-y-6">



{{-- TRENDING --}}

<section class="bg-slate-950
                text-white
                rounded-3xl
                overflow-hidden">


    <div class="p-5
                border-b
                border-white/10">


        <div class="flex items-center gap-2">
            <span class="w-2 h-2
                         rounded-full
                         bg-indigo-400
                         animate-pulse">
            </span>


            <h2 class="display-font
                       font-bold">

                {{ __('messages.trending') }}

            </h2>


        </div>

    </div>



    <div>


        @foreach($latestNews->take(5) as $index => $item)


            <a href="{{ route('frontend.news', [
                'websiteSlug' => $website->slug,
                'newsSlug' => $item->slug
            ]) }}"
               class="block
                      p-5
                      border-b
                      border-white/10
                      hover:bg-white/5
                      transition">


                <div class="flex gap-4">


                    <span class="text-2xl
                                 font-black
                                 text-indigo-400">

                        {{ str_pad(
                            $index + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}

                    </span>


                    <div>


                        <div class="text-[10px]
                                    uppercase
                                    text-indigo-300
                                    font-bold">

                            {{ $item->category->name ?? 'News' }}

                        </div>


                        <h3 class="display-font
                                   font-bold
                                   leading-snug
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
                rounded-3xl
                border
                border-slate-200
                p-5">


    <h2 class="display-font
               font-bold
               text-lg
               mb-4">

        Categories

    </h2>


    <div class="flex flex-wrap gap-2">


        @foreach($categories as $category)


            <a href="{{ route('frontend.category', [
                'websiteSlug' => $website->slug,
                'categorySlug' => $category->slug
            ]) }}"
               class="px-3
                      py-2
                      rounded-full
                      bg-slate-100
                      text-xs
                      font-semibold
                      text-slate-600
                      hover:bg-indigo-600
                      hover:text-white
                      transition">


                {{ $category->name }}


            </a>


        @endforeach


    </div>

</section>



{{-- NEWSLETTER --}}

<section class="relative
                overflow-hidden
                rounded-3xl
                bg-gradient-to-br
                from-indigo-600
                to-violet-700
                text-white
                p-6">


    <div class="relative">


        <p class="text-xs
                  uppercase
                  tracking-widest
                  font-bold
                  text-indigo-200">

            Newsletter

        </p>


        <h2 class="display-font
                   text-2xl
                   font-extrabold
                   mt-2">

            Stay ahead of the news.

        </h2>


        <p class="text-sm
                  text-indigo-100
                  mt-3
                  leading-6">

            Get important stories and latest
            updates directly in your inbox.

        </p>


        <form class="mt-5">


            <input
                type="email"
                placeholder="Your email address"
                class="w-full
                       px-4
                       py-3
                       rounded-xl
                       bg-white
                       text-slate-900
                       text-sm
                       outline-none">


            <button
                type="button"
                class="w-full
                       mt-2
                       py-3
                       rounded-xl
                       bg-slate-950
                       text-white
                       font-bold
                       text-sm
                       hover:bg-slate-800
                       transition">

                Subscribe →

            </button>


        </form>

    </div>

</section>


</aside>

</div>

</main>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-slate-950
                text-slate-400
                mt-10">


    <div class="max-w-7xl mx-auto
                px-4
                py-12">


        <div class="grid
                    md:grid-cols-3
                    gap-8">


            <div>


                <div class="flex items-center gap-3">


                    <div class="w-10 h-10
                                rounded-xl
                                bg-indigo-600
                                text-white
                                flex items-center
                                justify-center
                                font-black">

                        N

                    </div>


                    <h2 class="display-font
                               text-xl
                               font-bold
                               text-white">

                        {{ $website->name }}

                    </h2>


                </div>


                <p class="text-sm
                          leading-6
                          mt-4">

                    Modern journalism,
                    breaking stories and
                    important updates.

                </p>


            </div>



            <div>


                <h3 class="text-white
                           font-bold
                           mb-4">

                    Categories

                </h3>


                <div class="grid grid-cols-2 gap-2">


                    @foreach($categories->take(8) as $category)


                        <a href="{{ route('frontend.category', [
                            'websiteSlug' => $website->slug,
                            'categorySlug' => $category->slug
                        ]) }}"
                           class="text-sm
                                  hover:text-indigo-400
                                  transition">


                            {{ $category->name }}


                        </a>


                    @endforeach


                </div>

            </div>



            <div>


                <h3 class="text-white
                           font-bold
                           mb-4">

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
                    border-white/10
                    mt-10
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
{{-- SEARCH MODAL --}}
{{-- ========================================================= --}}

<div id="modernSearch"
     class="hidden fixed inset-0
            z-50
            bg-slate-950/70
            backdrop-blur-sm
            items-start
            justify-center
            pt-24
            px-4">


    <div class="w-full
                max-w-xl
                bg-white
                rounded-3xl
                shadow-2xl
                p-6">


        <div class="flex items-center
                    justify-between
                    mb-5">


            <h2 class="display-font
                       text-xl
                       font-bold">

                {{ __('messages.search') }}

            </h2>


            <button
                onclick="closeModernSearch()"
                class="w-9
                       h-9
                       rounded-lg
                       bg-slate-100
                       hover:bg-slate-900
                       hover:text-white">

                ✕

            </button>

        </div>


        <form
            action="{{ route('frontend.search', [
                'slug' => $website->slug
            ]) }}"
            method="GET"
            class="flex gap-2">


            <input
                type="search"
                name="q"
                placeholder="Search news..."
                class="flex-1
                       border
                       border-slate-300
                       rounded-xl
                       px-4
                       py-3
                       outline-none
                       focus:border-indigo-500">


            <button
                type="submit"
                class="px-5
                       rounded-xl
                       bg-indigo-600
                       text-white
                       font-bold
                       hover:bg-indigo-700">

                Search

            </button>


        </form>

    </div>

</div>



<script>

const modernSearchButton =
    document.getElementById('modernSearchButton');

const modernSearch =
    document.getElementById('modernSearch');


if (modernSearchButton && modernSearch) {

    modernSearchButton.addEventListener('click', function () {

        modernSearch.classList.remove('hidden');

        modernSearch.classList.add('flex');

    });

}


function closeModernSearch() {

    modernSearch.classList.add('hidden');

    modernSearch.classList.remove('flex');

}


document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeModernSearch();

    }

});

</script>


</body>

</html>