<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }}</title>

    <meta name="description"
          content="{{ $setting->meta_description ?? 'Latest breaking news, India, world, business, technology and more.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Arial', 'sans-serif'],
                        serif: ['Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#f7f7f5] text-[#111827]">



{{-- PREMIUM NEWS HEADER --}}


<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md
               border-b border-gray-200 shadow-sm">

    {{-- TOP UTILITY BAR --}}
    <div class="bg-[#111827] text-gray-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
                    h-9 flex items-center justify-between">

            <div class="flex items-center gap-2 text-[11px] font-semibold
                        tracking-wide">

                <span class="w-1.5 h-1.5 bg-red-500 rounded-full
                             animate-pulse"></span>

                <span>Independent • Fast • Trusted News</span>

            </div>

            <div class="hidden sm:block text-[11px] text-gray-400">
                {{ now()->format('l, d F Y') }}
            </div>

        </div>

    </div>


    {{-- MAIN BRAND HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-20 flex items-center justify-between">

            {{-- BRAND --}}
            <a href="{{ route('frontend.home') }}"
               class="flex items-center gap-3 group">

                {{-- LOGO --}}
                <div class="relative w-11 h-11 sm:w-12 sm:h-12
                            bg-red-600 text-white
                            flex items-center justify-center
                            rounded-md shadow-md
                            group-hover:bg-red-700
                            transition duration-300">

                    <span class="text-xl sm:text-2xl font-black">

                        {{ strtoupper(substr($website->name, 0, 1 ))}}
                        
                    </span>

                </div>


                {{-- SITE NAME --}}
                <div>

                    <div class="text-2xl sm:text-3xl
                                font-black tracking-tight
                                text-gray-900
                                group-hover:text-red-600
                                transition">

                        {{ $website->name }}

                    </div>

                    <div class="hidden sm:block
                                text-[9px] uppercase
                                tracking-[0.3em]
                                text-gray-500 font-semibold">

                        News • Ideas • Perspective

                    </div>

                </div>

            </a>


            {{-- DESKTOP ACTIONS --}}


                  <div class="hidden md:flex items-center gap-3 relative z-[200]">
                  
        <div class="hidden md:flex items-center gap-3">



</div>


               {{-- SEARCH BUTTON --}}

        <button
        type="button"
        id="homeSearchButton"
        class="group relative z-[201]
               flex items-center gap-2
               border border-gray-300
               rounded-md
               px-4 py-2.5
               text-sm font-semibold
               text-gray-700
               bg-white
               cursor-pointer
               hover:border-gray-900
               hover:text-gray-900
               transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4 text-gray-500
                    group-hover:text-red-600"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m21 21-4.35-4.35
                     m2.35-5.65a8 8 0 1 1-16 0
                     8 8 0 0 1 16 0Z"/>

        </svg>

        {{ __('messages.search') }}

    </button>


    {{-- THREE LINE MENU --}}

    <details class="relative z-[201]">

        <summary
            class="list-none
                   cursor-pointer
                   w-11 h-11
                   border border-gray-300
                   rounded-md
                   flex items-center justify-center
                   text-gray-700
                   bg-white
                   hover:bg-gray-900
                   hover:text-white
                   hover:border-gray-900
                   transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>

            </svg>

        </summary>


        {{-- MENU --}}

        <div
            class="absolute right-0 top-14
                   w-60
                   bg-white
                   border border-gray-200
                   rounded-xl
                   shadow-2xl
                   p-3
                   z-[300]">

            <a
                href="{{ frontend_home_url() }}"
                class="block px-4 py-3
                       rounded-lg
                       text-sm font-bold
                       text-red-600
                       hover:bg-gray-100">

                Home

            </a>


            @foreach($categories as $category)

                <a
                    href="{{ frontend_category_url($category->slug) }}"
                    class="block px-4 py-3
                           rounded-lg
                           text-sm font-semibold
                           text-gray-700
                           hover:bg-gray-100
                           hover:text-red-600">

                    {{ $category->name }}

                </a>

            @endforeach

        
          

        </div>

    </details>

</div>

            {{-- DESKTOP MENU DROPDOWN --}}

      <div id="mainMenu"
     class="hidden absolute right-4 sm:right-6 lg:right-8 top-24
            w-64
            bg-white
            border border-gray-200
            rounded-xl
            shadow-2xl
            p-3
            z-[60]">

       <a href="{{ frontend_home_url() }}"
       class="block px-4 py-3
              rounded-lg
              text-sm font-bold
              text-red-600
              hover:bg-gray-100">

        Home

    </a>

    @foreach($categories as $category)

        <a href="{{ frontend_category_url($category->slug) }}"
           class="block px-4 py-3
                  rounded-lg
                  text-sm font-semibold
                  text-gray-700
                  hover:bg-gray-100
                  hover:text-red-600">

            {{ $category->name }}

        </a>

    @endforeach

         </div>

       </details>

     </div>


        {{-- CATEGORY NAVIGATION --}}
        <nav class="border-t border-gray-100">

            <div class="flex items-center gap-8
                        overflow-x-auto
                        whitespace-nowrap
                        scrollbar-hide">

                {{-- HOME --}}

                <a href="{{ frontend_home_url() }}"
                   class="relative py-4
                          text-xs font-black uppercase
                          tracking-wide
                          text-red-600">

                    {{ __('messages.home') }}

                    <span class="absolute left-0 right-0
                                 bottom-0 h-0.5
                                 bg-red-600"></span>

                </a>


                {{-- CATEGORIES --}}

                @foreach($categories as $category)

            <a href="{{ frontend_category_url($category->slug) }}"
               class="relative py-4
              text-xs font-bold uppercase
              tracking-wide
              text-gray-500
              hover:text-red-600
              transition
              group">

           {{ $category->name }}

        <span class="absolute left-0 right-0
                     bottom-0 h-0.5
                     bg-red-600
                     scale-x-0
                     group-hover:scale-x-100
                     transition-transform
                     origin-left"></span>

    </a>

@endforeach

            </div>

        </nav>

    </div>

</header>

   {{-- ========================================================= --}}
{{-- PREMIUM BREAKING NEWS TICKER --}}
{{-- ========================================================= --}}

@if($breakingNews->count())

    <section class="bg-[#111827] text-white border-y border-gray-800">

        <div class="max-w-7xl mx-auto flex items-stretch">

            {{-- Breaking label --}}
            <div class="relative flex-shrink-0
                        bg-red-600
                        px-5 sm:px-7
                        py-3
                        flex items-center
                        gap-2
                        font-black
                        text-[11px]
                        uppercase
                        tracking-[0.15em]">

                <span class="relative flex h-2.5 w-2.5">

                    <span class="absolute inline-flex
                                 h-full w-full
                                 rounded-full
                                 bg-white opacity-50
                                 animate-ping">
                    </span>

                    <span class="relative inline-flex
                                 rounded-full
                                 h-2.5 w-2.5
                                 bg-white">
                    </span>

                </span>

                Breaking

            </div>


            {{-- Headlines --}}
            <div class="flex-1 overflow-hidden">

                <div class="flex items-center
                            gap-8
                            overflow-x-auto
                            whitespace-nowrap
                            px-5
                            py-3
                            scrollbar-hide">

                    @foreach($breakingNews as $breaking)

                        <a href="{{ frontend_news_url($breaking->slug) }}"
                           class="group flex items-center gap-3
                                  text-sm font-semibold
                                  text-gray-200
                                  hover:text-white
                                  transition">

                            <span class="w-1 h-1
                                         rounded-full
                                         bg-red-500
                                         flex-shrink-0">
                            </span>

                            <span class="group-hover:text-red-400
                                         transition">

                                {{ $breaking->title }}

                            </span>

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
             px-4 sm:px-6 lg:px-8
             py-10 sm:py-12">


    {{-- ========================================================= --}}
    {{-- PREMIUM TOP STORIES --}}
    {{-- ========================================================= --}}

    @if($featuredNews->count())

        @php

            $hero = $featuredNews->first();

            $secondaryNews = $featuredNews
                ->skip(1)
                ->take(4);

        @endphp


        <section class="mb-14">


            {{-- Section heading --}}
            <div class="flex items-end
                        justify-between
                        border-b border-gray-300
                        pb-4
                        mb-6">

                <div class="flex items-center gap-3">

                    <span class="w-1.5 h-8
                                 bg-red-600">
                    </span>

                    <div>

                        <p class="text-[10px]
                                  uppercase
                                  tracking-[0.25em]
                                  font-bold
                                  text-red-600
                                  mb-1">

                            {{ __('messages.featured') }}

                        </p>

                        <h2 class="text-2xl sm:text-3xl
                                   font-black
                                   tracking-tight
                                   text-gray-900">

                                  {{ __('messages.top_stories') }}


                        </h2>

                    </div>

                </div>


                <span class="hidden sm:block
                             text-[10px]
                             uppercase
                             tracking-widest
                             font-bold
                             text-gray-400">

                    Editor's Selection

                </span>

            </div>


            {{-- HERO GRID --}}
            <div class="grid
                        lg:grid-cols-12
                        gap-6
                        lg:gap-7">


                {{-- ================================================= --}}
                {{-- MAIN HERO STORY --}}
                {{-- ================================================= --}}

                <article class="lg:col-span-7
                                group
                                relative
                                bg-white
                                overflow-hidden
                                rounded-xl
                                shadow-sm
                                border border-gray-200
                                hover:shadow-xl
                                transition-all
                                duration-500">


                    @if($hero->featured_image)

                        <div class="relative
                                    aspect-[16/10]
                                    overflow-hidden
                                    bg-gray-200">

                            <img
                                src="{{ asset('storage/' . $hero->featured_image) }}"
                                alt="{{ $hero->title }}"
                                class="w-full h-full
                                       object-cover
                                       group-hover:scale-105
                                       transition-transform
                                       duration-700">


                            {{-- Image gradient --}}
                            <div class="absolute inset-0
                                        bg-gradient-to-t
                                        from-black/80
                                        via-black/10
                                        to-transparent">
                            </div>


                            {{-- Featured badge --}}
                            <div class="absolute
                                        top-5 left-5">

                                <span class="inline-flex
                                             items-center
                                             gap-2
                                             bg-red-600
                                             text-white
                                             px-3 py-1.5
                                             rounded-full
                                             text-[10px]
                                             font-black
                                             uppercase
                                             tracking-wider">

                                    <span class="w-1.5 h-1.5
                                                 bg-white
                                                 rounded-full">
                                    </span>

                                    Featured

                                </span>

                            </div>


                            {{-- Hero information on image --}}
                            <div class="absolute
                                        left-0 right-0
                                        bottom-0
                                        p-5 sm:p-7
                                        text-white">

                                <div class="flex items-center
                                            gap-3
                                            text-[10px]
                                            uppercase
                                            tracking-wider
                                            font-bold
                                            mb-3">

                                    <span class="text-red-400">

                                        {{ $hero->category->name ?? 'News' }}

                                    </span>

                                    <span class="text-white/50">
                                        •
                                    </span>

                                    <span class="text-white/70">

                                        {{ optional($hero->published_at)->diffForHumans() }}

                                    </span>

                                </div>

                               <a href="{{ frontend_news_url($hero->slug) }}"
                                        class="block">
                                <h1 class="font-serif
                                           text-3xl
                                           sm:text-4xl
                                           lg:text-[42px]
                                           leading-[1.05]
                                           font-bold
                                           tracking-tight
                                           group-hover:text-red-200
                                           transition">

                                    {{ $hero->title }}

                                </h1>

                                </a>

                            </div>

                        </div>

                    @else

                        <div class="aspect-[16/10]
                                    bg-gray-100
                                    flex items-center
                                    justify-center">

                            <span class="text-gray-400">
                                No image available
                            </span>

                        </div>

                    @endif


                    {{-- Hero description --}}
                    <div class="p-5 sm:p-6">

                        <p class="text-gray-600
                                  text-sm
                                  leading-6">

                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($hero->description),
                                180
                            ) }}

                        </p>


                        <div class="mt-5
                                    flex items-center
                                    justify-between">

                            <span class="text-[10px]
                                         uppercase
                                         tracking-widest
                                         font-black
                                         text-gray-400">

                                
                                  {{ __('messages.Read_Story') }}

                            

                            </span>

                            <span class="w-8 h-8
                                         rounded-full
                                         border border-gray-300
                                         flex items-center
                                         justify-center
                                         text-gray-600
                                         group-hover:bg-red-600
                                         group-hover:border-red-600
                                         group-hover:text-white
                                         transition">

                                →

                            </span>

                        </div>

                    </div>

                </article>


                {{-- ================================================= --}}
                {{-- SECONDARY STORIES --}}
                {{-- ================================================= --}}

                <div class="lg:col-span-5
                            grid
                            sm:grid-cols-2
                            lg:grid-cols-1
                            gap-5">


                    @foreach($secondaryNews as $index => $item)

                        <article class="group
                                        bg-white
                                        rounded-xl
                                        border border-gray-200
                                        overflow-hidden
                                        hover:shadow-lg
                                        transition-all
                                        duration-300">


                            <div class="flex
                                        h-full
                                        gap-4
                                        p-3">


                                {{-- Image --}}
                                @if($item->featured_image)

                                    <div class="relative
                                                w-32
                                                sm:w-36
                                                lg:w-40
                                                h-28
                                                flex-shrink-0
                                                overflow-hidden
                                                rounded-lg
                                                bg-gray-100">

                                        <img
                                            src="{{ asset('storage/' . $item->featured_image) }}"
                                            alt="{{ $item->title }}"
                                            class="w-full h-full
                                                   object-cover
                                                   group-hover:scale-110
                                                   transition-transform
                                                   duration-500">


                                        {{-- Number --}}
                                        <span class="absolute
                                                     top-2 left-2
                                                     w-7 h-7
                                                     rounded-full
                                                     bg-black/70
                                                     text-white
                                                     flex items-center
                                                     justify-center
                                                     text-[10px]
                                                     font-black">

                                            {{ str_pad($index + 2, 2, '0', STR_PAD_LEFT) }}

                                        </span>

                                    </div>

                                @endif


                                {{-- Story content --}}
                                <div class="flex-1
                                            min-w-0
                                            py-1">

                                    <div class="flex items-center
                                                gap-2
                                                text-[10px]
                                                uppercase
                                                tracking-wider
                                                font-black
                                                mb-2">

                                        <span class="text-red-600">

                                            {{ $item->category->name ?? 'News' }}

                                        </span>

                                    </div>

                                     <a href="{{ frontend_news_url($item->slug) }}"
                                              class="block">
                                    <h3 class="font-serif
                                               text-lg
                                               font-bold
                                               leading-tight
                                               text-gray-900
                                               group-hover:text-red-600
                                               transition">

                                        {{ $item->title }}

                                    </h3>

                                    </a>


                                    <div class="mt-3
                                                text-[10px]
                                                uppercase
                                                tracking-wide
                                                text-gray-400
                                                font-semibold">

                                        {{ optional($item->published_at)->diffForHumans() }}

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach


                    {{-- Empty secondary stories fallback --}}
                    @if($secondaryNews->count() === 0)

                        <div class="rounded-xl
                                    border border-dashed
                                    border-gray-300
                                    p-8
                                    text-center
                                    text-sm
                                    text-gray-400">

                            More featured stories
                            will appear here.

                        </div>

                    @endif

                </div>

            </div>

        </section>

    @endif


    {{-- ========================================================= --}}
{{-- PREMIUM LATEST NEWS + SIDEBAR --}}
{{-- ========================================================= --}}

<div class="grid lg:grid-cols-12 gap-8 lg:gap-10">


    {{-- ========================================================= --}}
    {{-- LATEST NEWS --}}
    {{-- ========================================================= --}}

    <section class="lg:col-span-8">


        {{-- Section heading --}}
        <div class="flex items-end justify-between
                    border-b-2 border-gray-900
                    pb-4 mb-6">

            <div class="flex items-center gap-3">

                <span class="w-1.5 h-8 bg-red-600"></span>

                <div>

                    <p class="text-[10px]
                              uppercase
                              tracking-[0.25em]
                              font-black
                              text-red-600
                              mb-1">

                        News Feed

                    </p>

                    <h2 class="text-2xl sm:text-3xl
                               font-black
                               tracking-tight">

                        
                              latest news

                        

                    </h2>

                </div>

            </div>


            <span class="hidden sm:block
                         text-[10px]
                         uppercase
                         tracking-widest
                         font-bold
                         text-gray-400">

                Just In

            </span>

        </div>


        {{-- News list --}}
        <div class="space-y-5">


            @forelse($latestNews as $index => $item)


                <article class="group
                                relative
                                bg-white
                                rounded-xl
                                border border-gray-200
                                overflow-hidden
                                hover:shadow-xl
                                hover:border-gray-300
                                transition-all
                                duration-300">


                    <div class="flex
                                flex-col
                                sm:flex-row
                                gap-4 sm:gap-5
                                p-4">


                        {{-- ================================================= --}}
                        {{-- IMAGE --}}
                        {{-- ================================================= --}}

                        @if($item->featured_image)

                            <div class="relative
                                        w-full
                                        sm:w-48
                                        lg:w-52
                                        h-48
                                        sm:h-32
                                        flex-shrink-0
                                        overflow-hidden
                                        rounded-lg
                                        bg-gray-100">

                                <img
                                    src="{{ asset('storage/' . $item->featured_image) }}"
                                    alt="{{ $item->title }}"
                                    class="w-full h-full
                                           object-cover
                                           group-hover:scale-110
                                           transition-transform
                                           duration-700">


                                {{-- Number badge --}}
                                <span class="absolute
                                             top-3 left-3
                                             w-8 h-8
                                             rounded-full
                                             bg-black/75
                                             text-white
                                             flex items-center
                                             justify-center
                                             text-[10px]
                                             font-black">

                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                                </span>

                            </div>

                        @else

                            <div class="relative
                                        w-full
                                        sm:w-48
                                        lg:w-52
                                        h-40
                                        sm:h-32
                                        flex-shrink-0
                                        rounded-lg
                                        bg-gray-100
                                        flex items-center
                                        justify-center">

                                <span class="text-xs
                                             text-gray-400
                                             uppercase
                                             tracking-wider">

                                    No Image

                                </span>

                            </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- CONTENT --}}
                        {{-- ================================================= --}}

                        <div class="flex-1
                                    min-w-0
                                    flex flex-col
                                    justify-between
                                    py-1">


                            <div>


                                {{-- Category + time --}}
                                <div class="flex items-center
                                            flex-wrap
                                            gap-2
                                            text-[10px]
                                            uppercase
                                            tracking-wider
                                            font-black">

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


                                {{-- Headline --}}

                                <a href="{{ frontend_news_url($item->slug) }}"
                                         class="block">
                                <h3 class="font-serif
                                           text-xl
                                           sm:text-2xl
                                           font-bold
                                           leading-tight
                                           mt-2
                                           text-gray-900
                                           group-hover:text-red-600
                                           transition">

                                    {{ $item->title }}

                                </h3>

                                </a>


                                {{-- Description --}}
                                <p class="hidden sm:block
                                          text-sm
                                          text-gray-500
                                          leading-6
                                          mt-2">

                                    {{ \Illuminate\Support\Str::limit(
                                        strip_tags($item->description),
                                        135
                                    ) }}

                                </p>

                            </div>


                            {{-- Bottom meta --}}
                            <div class="flex items-center
                                        justify-between
                                        mt-4">


                                <span class="text-[10px]
                                             uppercase
                                             tracking-widest
                                             font-bold
                                             text-gray-400">

                                    NewsHub

                                </span>


                                <span class="flex items-center
                                             gap-2
                                             text-xs
                                             font-bold
                                             text-gray-500
                                             group-hover:text-red-600
                                             transition">

                                  {{ __('messages.Read_Story') }}
                                    

                                    <span class="w-7 h-7
                                                 rounded-full
                                                 border
                                                 border-gray-300
                                                 flex items-center
                                                 justify-center
                                                 group-hover:bg-red-600
                                                 group-hover:border-red-600
                                                 group-hover:text-white
                                                 transition">

                                        →

                                    </span>

                                </span>

                            </div>

                        </div>

                    </div>

                </article>


            @empty


                <div class="bg-white
                            border border-gray-200
                            rounded-xl
                            p-12
                            text-center">

                    <div class="text-4xl mb-3">
                        📰
                    </div>

                    <p class="font-bold
                              text-gray-700">

                        No published news available yet.

                    </p>

                    <p class="text-sm
                              text-gray-400
                              mt-1">

                        Published stories will appear here.

                    </p>

                </div>


            @endforelse


        </div>


        {{-- Pagination --}}
        @if($latestNews->hasPages())

            <div class="mt-8
                        bg-white
                        rounded-xl
                        border border-gray-200
                        p-4">

                {{ $latestNews->links() }}

            </div>

        @endif


    </section>



    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}

    <aside class="lg:col-span-4 space-y-7">


        {{-- ========================================================= --}}
        {{-- TRENDING --}}
        {{-- ========================================================= --}}

        <section class="bg-white
                        rounded-xl
                        border border-gray-200
                        overflow-hidden
                        shadow-sm">


            {{-- Heading --}}
            <div class="flex items-center
                        justify-between
                        px-5 py-4
                        bg-[#111827]
                        text-white">

                <div class="flex items-center gap-3">

                    <span class="w-1.5 h-6 bg-red-600"></span>

                    <h2 class="font-black
                               uppercase
                               tracking-wider
                               text-sm">

                        
                                  {{ __('messages.Trending') }}


                    </h2>

                </div>

                <span class="text-[9px]
                             uppercase
                             tracking-widest
                             text-gray-400">

                    Today

                </span>

            </div>


            {{-- Trending stories --}}
            <div class="divide-y divide-gray-100">


                @foreach($latestNews->take(5) as $index => $item)


                    <div class="group
                                p-5
                                flex gap-4
                                hover:bg-gray-50
                                transition">


                        {{-- Number --}}
                        <div class="flex-shrink-0">

                            <span class="text-3xl
                                         font-black
                                         text-gray-200
                                         group-hover:text-red-500
                                         transition">

                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                            </span>

                        </div>


                        {{-- Story --}}
                        <div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-widest
                                        font-black
                                        text-red-600
                                        mb-1">

                                {{ $item->category->name ?? 'News' }}

                            </div>

                            <h3 class="font-serif
                                       text-base
                                       font-bold
                                       leading-snug
                                       text-gray-900
                                       group-hover:text-red-600
                                       transition">

                                {{ $item->title }}

                            </h3>

                            <p class="text-[10px]
                                      text-gray-400
                                      mt-2">

                                {{ optional($item->published_at)->diffForHumans() }}

                            </p>

                        </div>

                    </div>


                @endforeach


            </div>

        </section>



        {{-- ========================================================= --}}
        {{-- NEWSLETTER --}}
        {{-- ========================================================= --}}

        <section class="relative
                        overflow-hidden
                        rounded-xl
                        bg-[#111827]
                        text-white
                        p-6
                        shadow-lg">


            {{-- Decorative circle --}}
            <div class="absolute
                        -right-12
                        -top-12
                        w-32 h-32
                        rounded-full
                        bg-red-600/20">
            </div>


            <div class="relative">


                <div class="flex items-center
                            gap-2
                            text-red-400
                            text-[10px]
                            uppercase
                            tracking-[0.2em]
                            font-black">

                    <span class="w-2 h-2
                                 rounded-full
                                 bg-red-500">
                    </span>

                    NewsHub Daily

                </div>


                <h2 class="text-2xl
                           sm:text-3xl
                           font-black
                           leading-tight
                           mt-3">

                    The news
                    that matters.

                </h2>


                <p class="text-sm
                          text-gray-400
                          leading-6
                          mt-3">

                    Get the most important headlines,
                    stories and updates delivered
                    straight to your inbox.

                </p>


                <form class="mt-5">


                    <div class="flex
                                flex-col
                                gap-2">

                        <input
                            type="email"
                            placeholder="Enter your email"
                            class="w-full
                                   rounded-lg
                                   px-4 py-3
                                   bg-white
                                   text-gray-900
                                   text-sm
                                   outline-none
                                   focus:ring-2
                                   focus:ring-red-500">


                        <button
                            type="button"
                            class="w-full
                                   rounded-lg
                                   bg-red-600
                                   text-white
                                   py-3
                                   text-sm
                                   font-black
                                   uppercase
                                   tracking-wider
                                   hover:bg-red-700
                                   transition">

                            Subscribe →

                        </button>

                    </div>


                </form>


                <p class="text-[9px]
                          text-gray-500
                          mt-3">

                    No spam. Unsubscribe anytime.

                </p>

            </div>

        </section>


    </aside>


  </div>

    </main>

{{-- ========================================================= --}}
{{-- PREMIUM NEWS FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#0b1120] text-gray-300 mt-16">


    {{-- ========================================================= --}}
    {{-- MAIN FOOTER --}}
    {{-- ========================================================= --}}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">


        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">


            {{-- ================================================= --}}
            {{-- BRAND --}}
            {{-- ================================================= --}}

            <div class="lg:col-span-1">

                <a href="{{ route('frontend.home') }}"
                   class="inline-flex items-center gap-3 group">

                    <div class="w-11 h-11
                                bg-red-600
                                rounded-lg
                                flex items-center
                                justify-center
                                text-white
                                text-xl
                                font-black
                                group-hover:bg-red-700
                                transition">

                        N

                    </div>


                    <div>

                        <div class="text-white
                                    text-2xl
                                    font-black
                                    tracking-tight">

                            {{ $website->name ?? $setting->site_name ?? 'NewsHub' }}

                        </div>

                        <div class="text-[9px]
                                    uppercase
                                    tracking-[0.25em]
                                    text-gray-500">

                            News • Ideas • Perspective

                        </div>

                    </div>

                </a>


                <p class="text-sm
                          text-gray-400
                          leading-7
                          mt-5">

                    Independent journalism, breaking news
                    and stories that matter. Stay informed
                    with the latest updates from India and
                    around the world.

                </p>


                {{-- Social icons/text --}}
                <div class="flex flex-wrap gap-2 mt-6">

                    @if($setting?->facebook)

                        <a href="{{ $setting->facebook }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="px-3 py-2
                                  rounded-md
                                  bg-white/5
                                  border border-white/10
                                  text-xs
                                  font-bold
                                  hover:bg-red-600
                                  hover:text-white
                                  hover:border-red-600
                                  transition">

                            Facebook

                        </a>

                    @endif


                    @if($setting?->instagram)

                        <a href="{{ $setting->instagram }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="px-3 py-2
                                  rounded-md
                                  bg-white/5
                                  border border-white/10
                                  text-xs
                                  font-bold
                                  hover:bg-red-600
                                  hover:text-white
                                  hover:border-red-600
                                  transition">

                            Instagram

                        </a>

                    @endif


                    @if($setting?->youtube)

                        <a href="{{ $setting->youtube }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="px-3 py-2
                                  rounded-md
                                  bg-white/5
                                  border border-white/10
                                  text-xs
                                  font-bold
                                  hover:bg-red-600
                                  hover:text-white
                                  hover:border-red-600
                                  transition">

                            YouTube

                        </a>

                    @endif


                    @if($setting?->twitter)

                        <a href="{{ $setting->twitter }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="px-3 py-2
                                  rounded-md
                                  bg-white/5
                                  border border-white/10
                                  text-xs
                                  font-bold
                                  hover:bg-red-600
                                  hover:text-white
                                  hover:border-red-600
                                  transition">

                            Twitter

                        </a>

                    @endif

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- EXPLORE --}}
            {{-- ================================================= --}}

            <div>

                <h3 class="text-white
                           font-black
                           text-sm
                           uppercase
                           tracking-wider
                           mb-5
                           flex items-center gap-2">

                    <span class="w-1.5 h-5 bg-red-600"></span>

                    Explore

                </h3>


                <div class="space-y-3 text-sm">

                    <a href="{{ frontend_home_url() }}"
                       class="block text-gray-400
                              hover:text-white
                              hover:translate-x-1
                              transition">

                        Home

                    </a>


                    <a href="#"
                       class="block text-gray-400
                              hover:text-white
                              hover:translate-x-1
                              transition">

                        Latest News

                    </a>


                    <a href="#"
                       class="block text-gray-400
                              hover:text-white
                              hover:translate-x-1
                              transition">

                        Breaking News

                    </a>


                    <a href="#"
                       class="block text-gray-400
                              hover:text-white
                              hover:translate-x-1
                              transition">

                        Featured Stories

                    </a>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- CATEGORIES --}}
            {{-- ================================================= --}}

            <div>

                <h3 class="text-white
                           font-black
                           text-sm
                           uppercase
                           tracking-wider
                           mb-5
                           flex items-center gap-2">

                    <span class="w-1.5 h-5 bg-red-600"></span>

                    Categories

                </h3>


                <div class="grid grid-cols-2 gap-y-3 gap-x-4 text-sm">

               @foreach($categories->take(10) as $category)
                <a href="{{ frontend_category_url($category->slug) }}"
               class="text-gray-400
              hover:text-red-500
              transition">

                 {{ $category->name }}

              </a>

                @endforeach

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- CONTACT / INFO --}}
            {{-- ================================================= --}}

            <div>

                <h3 class="text-white
                           font-black
                           text-sm
                           uppercase
                           tracking-wider
                           mb-5
                           flex items-center gap-2">

                    <span class="w-1.5 h-5 bg-red-600"></span>

                    Contact

                </h3>


                <div class="space-y-4 text-sm">


                    @if($setting?->email)

                        <div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-gray-500
                                        font-bold
                                        mb-1">

                                Email

                            </div>

                            <a href="mailto:{{ $setting->email }}"
                               class="text-gray-400
                                      hover:text-white
                                      break-all
                                      transition">

                                {{ $setting->email }}

                            </a>

                        </div>

                    @endif


                    @if($setting?->phone)

                        <div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-gray-500
                                        font-bold
                                        mb-1">

                                Phone

                            </div>

                            <a href="tel:{{ $setting->phone }}"
                               class="text-gray-400
                                      hover:text-white
                                      transition">

                                {{ $setting->phone }}

                            </a>

                        </div>

                    @endif


                    @if($setting?->address)

                        <div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-gray-500
                                        font-bold
                                        mb-1">

                                Address

                            </div>

                            <p class="text-gray-400 leading-6">

                                {{ $setting->address }}

                            </p>

                        </div>

                    @endif


                </div>

            </div>


        </div>


        {{-- ========================================================= --}}
        {{-- FOOTER NAVIGATION --}}
        {{-- ========================================================= --}}

        <div class="border-t
                    border-white/10
                    mt-12
                    pt-6
                    flex flex-col
                    md:flex-row
                    items-center
                    justify-between
                    gap-4">


            <div class="flex flex-wrap
                        justify-center
                        gap-x-6
                        gap-y-2
                        text-xs
                        text-gray-500">

                <a href="#"
                   class="hover:text-white transition">

                    Privacy Policy

                </a>

                <a href="#"
                   class="hover:text-white transition">

                    Terms & Conditions

                </a>

                <a href="#"
                   class="hover:text-white transition">

                    About Us

                </a>

                <a href="#"
                   class="hover:text-white transition">

                    Contact

                </a>

            </div>


            <div class="text-xs
                        text-gray-500">

                Updated daily • Trusted journalism

            </div>


        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- COPYRIGHT BAR --}}
    {{-- ========================================================= --}}

    <div class="border-t border-white/10
                bg-black/20">

        <div class="max-w-7xl mx-auto
                    px-4 sm:px-6 lg:px-8
                    py-5
                    flex flex-col
                    sm:flex-row
                    items-center
                    justify-between
                    gap-2
                    text-xs
                    text-gray-500">

            <span>

                © {{ date('Y') }}

                {{ $website->name ?? $setting->site_name ?? 'NewsHub' }}.

                All rights reserved.

            </span>


            <span>

                Powered by NewsHub CMS

            </span>

        </div>

    </div>


</footer>

{{-- ========================================================= --}}
{{-- SEARCH OVERLAY --}}
{{-- ========================================================= --}}

<div id="searchOverlay"
     class="fixed inset-0
            bg-black/60
            backdrop-blur-sm
            z-[100]
            hidden">

    <div class="min-h-full
                flex items-start
                justify-center
                px-4 pt-24">

        <div class="w-full max-w-2xl
                    bg-white
                    rounded-2xl
                    shadow-2xl
                    p-5 sm:p-7">

            <div class="flex items-center
                        justify-between
                        mb-5">

                <h2 class="text-xl sm:text-2xl
                           font-black
                           text-gray-900">

                    Search News

                </h2>

                <button
                    type="button"
                    onclick="closeSearch()"
                    class="w-10 h-10 rounded-lg
                           rounded-lg
                           border border-gray-200
                           flex items-center justify-center
                           text-gray-500
                           hover:bg-gray-900
                           hover:text-white
                           transition">

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
                    autofocus
                    class="flex-1
                           h-12
                           px-4
                           rounded-lg
                           border border-gray-300
                           outline-none
                           focus:border-red-600
                           focus:ring-2
                           focus:ring-red-100">

                <button
                    type="submit"
                    class="h-12
                           px-5
                           rounded-lg
                           bg-red-600
                           text-white
                           font-bold
                           hover:bg-red-700
                           transition">

                    Search

                </button>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchButton = document.getElementById('homeSearchButton');
    const searchOverlay = document.getElementById('searchOverlay');

    if (searchButton && searchOverlay) {

        searchButton.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            searchOverlay.classList.remove('hidden');

        });

    }

});
</script>

<script>

function openSearch() {
    const overlay = document.getElementById('searchOverlay');

    if (overlay) {
        overlay.classList.remove('hidden');
    }
}

function closeSearch() {
    const overlay = document.getElementById('searchOverlay');

    if (overlay) {
        overlay.classList.add('hidden');
    }
}

// ESC press karne par search close
document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
        closeSearch();
    }

});

</script>

</body>
</html>