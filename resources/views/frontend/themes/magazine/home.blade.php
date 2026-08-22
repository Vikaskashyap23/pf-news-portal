 <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $website->name }}</title>

    <meta name="description"
          content="{{ $setting->meta_description ?? 'Latest news, breaking stories and top headlines.' }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Arial', 'Helvetica', 'sans-serif'],
                        editorial: ['Georgia', 'Times New Roman', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .editorial {
            font-family: Georgia, "Times New Roman", serif;
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


<body class="bg-[#f5f6fa] text-[#111827]">


{{-- ========================================================= --}}
{{-- TOP BAR --}}
{{-- ========================================================= --}}

<div class="bg-[#17152b] text-white">

    <div class="max-w-7xl mx-auto px-4
                h-9
                flex items-center
                justify-between">

        <div class="text-[10px]
                    uppercase
                    tracking-[0.25em]
                    text-gray-300">

            Latest • Independent • Trusted

        </div>


        <div class="hidden sm:block
                    text-[10px]
                    uppercase
                    tracking-widest
                    text-gray-400">

            {{ now()->format('l, d F Y') }}

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- MAIN HEADER --}}
{{-- ========================================================= --}}

<header class="bg-white
               border-b
               border-gray-200
               sticky top-0
               z-50">

    <div class="max-w-7xl mx-auto px-4">

        <div class="h-20
                    flex items-center
                    justify-between">


            {{-- LOGO / BRAND --}}
            <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
               class="flex items-center gap-3">

                <div class="w-11 h-11
                            rounded-xl
                            bg-gradient-to-br
                            from-purple-600
                            to-pink-500
                            text-white
                            flex items-center
                            justify-center
                            font-black
                            text-xl
                            shadow-lg">

                      {{ strtoupper(substr($website->name, 0, 1 )) }}
                    

                </div>


                <div>

                    <div class="text-2xl sm:text-3xl
                                font-black
                                tracking-tight">

                        {{ $website->name }}

                    </div>

                    <div class="text-[8px]
                                uppercase
                                tracking-[0.35em]
                                text-gray-400">

                        Magazine • News • Culture

                    </div>

                </div>

            </a>


            {{-- DESKTOP ACTIONS --}}
            <div class="hidden md:flex items-center gap-3">

                <a href="{{ route('frontend.search', [
                    'slug' => $website->slug
                         ]) }}"
                   class="px-4 py-2.5
                          rounded-lg
                          border border-gray-200
                          text-xs
                          font-bold
                          hover:bg-gray-100
                          transition">

                    🔍 {{ __('messages.search') }}

                </a>


                <button type="button"
                        class="w-10 h-10
                               rounded-lg
                               bg-[#17152b]
                               text-white
                               flex items-center
                               justify-center
                               hover:bg-purple-700
                               transition">

                    ☰

                </button>

            </div>

        </div>


        {{-- CATEGORY BAR --}}
        <nav class="border-t border-gray-100">

            <div class="flex
                        items-center
                        gap-7
                        overflow-x-auto
                        whitespace-nowrap
                        hide-scrollbar">

                <a href="{{ route('frontend.website', [
                    'slug' => $website->slug
                ]) }}"
                   class="py-4
                          text-[10px]
                          uppercase
                          tracking-widest
                          font-black
                          text-purple-600
                          border-b-2
                          border-purple-600">

                    {{ __('messages.home') }}

                </a>


                @foreach($categories as $category)

                    <a href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                        'categorySlug' => $category->slug
                    ]) }}"
                       class="py-4
                              text-[10px]
                              uppercase
                              tracking-widest
                              font-bold
                              text-gray-500
                              hover:text-purple-600
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
                from-purple-700
                via-fuchsia-600
                to-pink-500
                text-white">

    <div class="max-w-7xl mx-auto px-4">

        <div class="flex items-center">

            <div class="flex-shrink-0
                        bg-black/20
                        px-5 py-3
                        text-[9px]
                        uppercase
                        tracking-[0.2em]
                        font-black">

                Breaking

            </div>


            <div class="flex-1
                        overflow-x-auto
                        hide-scrollbar">

                <div class="flex
                            items-center
                            gap-8
                            px-5
                            py-3
                            whitespace-nowrap">

                    @foreach($breakingNews as $breaking)

                        <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $breaking->slug
                        ]) }}"
                           class="text-sm
                                  font-bold
                                  hover:underline">

                            {{ $breaking->title }}

                        </a>

                    @endforeach

                </div>

            </div>

        </div>

    </div>
 </section>

@endif


{{-- ========================================================= --}}
{{-- MAIN --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto
             px-4
             py-8 sm:py-10">


{{-- ========================================================= --}}
{{-- HERO MAGAZINE GRID --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

@php

    $hero = $featuredNews->first();

    $secondaryNews = $featuredNews
        ->skip(1)
        ->take(4);

@endphp


<section class="grid
                lg:grid-cols-12
                gap-5
                mb-12">


    {{-- BIG HERO --}}
    <article class="lg:col-span-7
                    relative
                    min-h-[430px]
                    rounded-2xl
                    overflow-hidden
                    group
                    shadow-xl">


        @if($hero->featured_image)

            <img src="{{ asset('storage/' . $hero->featured_image) }}"
                 alt="{{ $hero->title }}"
                 class="absolute inset-0
                        w-full h-full
                        object-cover
                        group-hover:scale-105
                        transition-transform
                        duration-700">

        @else

            <div class="absolute inset-0
                        bg-gradient-to-br
                        from-purple-700
                        to-pink-500">
            </div>

        @endif


        <div class="absolute inset-0
                    bg-gradient-to-t
                    from-black
                    via-black/30
                    to-transparent">
        </div>


        <div class="absolute
                    left-6 right-6
                    bottom-6
                    text-white">


            <div class="inline-flex
                        px-3 py-1
                        rounded-full
                        bg-purple-600
                        text-[9px]
                        uppercase
                        tracking-widest
                        font-black
                        mb-3">

                Featured Story

            </div>


            <div class="text-[10px]
                        uppercase
                        tracking-widest
                        text-white/70
                        font-bold
                        mb-2">

                {{ $hero->category->name ?? 'News' }}

                •
                {{ optional($hero->published_at)->diffForHumans() }}

            </div>


            <a href="{{ route('frontend.news', [
                'websiteSlug' => $website->slug,
                'newsSlug' => $hero->slug
            ]) }}">

                <h1 class="editorial
                           text-3xl
                           sm:text-4xl
                           lg:text-5xl
                           font-bold
                           leading-tight
                           hover:text-purple-200
                           transition">

                    {{ $hero->title }}

                </h1>

            </a>


            <p class="mt-3
                      text-sm
                      text-gray-200
                      max-w-2xl
                      line-clamp-2">

                {{ \Illuminate\Support\Str::limit(
                    strip_tags($hero->description),
                    180
                ) }}

            </p>

        </div>

    </article>


    {{-- SMALL FEATURE CARDS --}}
    <div class="lg:col-span-5
                grid sm:grid-cols-2
                gap-5">

        @foreach($secondaryNews as $item)

            <article class="relative
                            min-h-[205px]
                            rounded-2xl
                            overflow-hidden
                            bg-white
                            shadow-sm
                            group">


                @if($item->featured_image)
                      <img src="{{ asset('storage/' . $item->featured_image) }}"
                         alt="{{ $item->title }}"
                         class="absolute inset-0
                                w-full h-full
                                object-cover
                                group-hover:scale-105
                                transition
                                duration-500">

                @else

                    <div class="absolute inset-0
                                bg-gradient-to-br
                                from-indigo-500
                                to-purple-600">
                    </div>

                @endif


                <div class="absolute inset-0
                            bg-gradient-to-t
                            from-black
                            via-black/20
                            to-transparent">
                </div>


                <div class="absolute
                            left-4 right-4
                            bottom-4
                            text-white">


                    <div class="text-[8px]
                                uppercase
                                tracking-widest
                                text-purple-200
                                font-black
                                mb-1">

                        {{ $item->category->name ?? 'News' }}

                    </div>


                    <a href="{{ route('frontend.news', [
                        'websiteSlug' => $website->slug,
                        'newsSlug' => $item->slug
                    ]) }}">

                        <h3 class="editorial
                                   text-lg
                                   font-bold
                                   leading-tight
                                   group-hover:text-purple-200">

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
{{-- SECTION HEADING --}}
{{-- ========================================================= --}}

<div class="flex items-end
            justify-between
            mb-6">

    <div>

        <div class="text-[9px]
                    uppercase
                    tracking-[0.3em]
                    font-black
                    text-purple-600">

            Editor's Choice

        </div>

        <h2 class="editorial
                   text-3xl sm:text-4xl
                   font-black
                   mt-1">

            {{ __('messages.latest_news') }}

        </h2>

    </div>


    <div class="hidden sm:block
                text-[10px]
                uppercase
                tracking-widest
                text-gray-400">

        Fresh Stories

    </div>

</div>


{{-- ========================================================= --}}
{{-- LATEST + SIDEBAR --}}
{{-- ========================================================= --}}

<div class="grid
            lg:grid-cols-12
            gap-8">


    {{-- LATEST --}}
    <section class="lg:col-span-8">

        <div class="grid sm:grid-cols-2 gap-5">


            @forelse($latestNews as $item)

                <article class="bg-white
                                rounded-2xl
                                overflow-hidden
                                border border-gray-100
                                shadow-sm
                                hover:shadow-xl
                                group
                                transition">


                    @if($item->featured_image)

                        <div class="relative
                                    aspect-[16/10]
                                    overflow-hidden">
                                <img
                                src="{{ asset('storage/' . $item->featured_image) }}"
                                alt="{{ $item->title }}"
                                class="w-full h-full
                                       object-cover
                                       group-hover:scale-105
                                       transition-transform
                                       duration-500">


                            <span class="absolute
                                         top-3 left-3
                                         px-3 py-1
                                         rounded-full
                                         bg-white
                                         text-purple-700
                                         text-[8px]
                                         uppercase
                                         tracking-widest
                                         font-black
                                         shadow">

                                {{ $item->category->name ?? 'News' }}

                            </span>

                        </div>

                    @endif


                    <div class="p-5">


                        <div class="text-[9px]
                                    uppercase
                                    tracking-widest
                                    text-gray-400
                                    font-bold">

                            {{ optional($item->published_at)->diffForHumans() }}

                        </div>


                        <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $item->slug
                        ]) }}">

                            <h3 class="editorial
                                       text-xl
                                       font-black
                                       leading-tight
                                       mt-2
                                       group-hover:text-purple-700
                                       transition">

                                {{ $item->title }}

                            </h3>

                        </a>


                        <p class="text-sm
                                  text-gray-500
                                  leading-6
                                  mt-3">

                            {{ \Illuminate\Support\Str::limit(
                                strip_tags($item->description),
                                120
                            ) }}

                        </p>


                        <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $item->slug
                        ]) }}"
                           class="inline-block
                                  mt-4
                                  text-[9px]
                                  uppercase
                                  tracking-widest
                                  font-black
                                  text-purple-600
                                  hover:text-pink-600">

                            {{ __('messages.read_story') }} →

                        </a>

                    </div>

                </article>


            @empty

                <div class="sm:col-span-2
                            bg-white
                            rounded-2xl
                            p-12
                            text-center">

                    <div class="text-4xl">
                        📰
                    </div>

                    <h3 class="editorial
                               text-xl
                               font-bold
                               mt-3">

                        No published news available.

                    </h3>

                </div>

            @endforelse

        </div>


        @if($latestNews->hasPages())
                  <div class="mt-8">

                {{ $latestNews->links() }}

            </div>

        @endif

    </section>


    {{-- SIDEBAR --}}
    <aside class="lg:col-span-4 space-y-6">


        {{-- TRENDING --}}
        <section class="bg-[#17152b]
                        rounded-2xl
                        overflow-hidden
                        text-white">


            <div class="p-5
                        border-b
                        border-white/10">

                <div class="text-[9px]
                            uppercase
                            tracking-[0.3em]
                            text-purple-300
                            font-black">

                    Trending

                </div>


                <h2 class="editorial
                           text-2xl
                           font-bold
                           mt-1">

                    Most Read

                </h2>

            </div>


            <div>

                @foreach($latestNews->take(5) as $index => $item)

                    <article class="p-5
                                    border-b
                                    border-white/10
                                    last:border-0
                                    group">

                        <div class="flex gap-4">


                            <span class="text-3xl
                                         font-black
                                         text-white/20
                                         group-hover:text-purple-400">

                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                            </span>


                            <div>

                                <div class="text-[8px]
                                            uppercase
                                            tracking-widest
                                            text-pink-400
                                            font-black">

                                    {{ $item->category->name ?? 'News' }}

                                </div>


                                <a href="{{ route('frontend.news', [
                                    'websiteSlug' => $website->slug,
                                    'newsSlug' => $item->slug
                                ]) }}">

                                    <h3 class="editorial
                                               text-base
                                               font-bold
                                               leading-snug
                                               mt-1
                                               group-hover:text-purple-300">

                                        {{ $item->title }}

                                    </h3>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        </section>


        {{-- CATEGORY CLOUD --}}
        <section class="bg-white
                        rounded-2xl
                        p-6
                        border border-gray-100">


            <div class="text-[9px]
                        uppercase
                        tracking-[0.3em]
                        font-black
                        text-purple-600">

                Explore

            </div>


            <h2 class="editorial
                       text-2xl
                       font-black
                       mt-1 mb-5">

                Categories

            </h2>


            <div class="flex flex-wrap gap-2">

                @foreach($categories as $category)

                    <a href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                       'categorySlug' => $category->slug
                    ]) }}"
                       class="px-3 py-2
                              rounded-full
                              bg-gray-100
                              text-[9px]
                              uppercase
                              tracking-wider
                              font-bold
                              hover:bg-purple-600
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
                        rounded-2xl
                        bg-gradient-to-br
                        from-purple-700
                        via-fuchsia-600
                        to-pink-500
                        text-white
                        p-6">


            <div class="absolute
                        -right-12
                        -top-12
                        w-36 h-36
                        rounded-full
                        bg-white/10">
            </div>


            <div class="relative">

                <div class="text-[9px]
                            uppercase
                            tracking-[0.25em]
                            font-black
                            text-purple-100">

                    Newsletter

                </div>


                <h2 class="editorial
                           text-3xl
                           font-black
                           mt-3">

                    Stay in the know.

                </h2>


                <p class="text-sm
                          text-white/80
                          leading-6
                          mt-3">

                    Get the biggest stories
                    and latest updates
                    directly in your inbox.

                </p>


                <input
                    type="email"
                    placeholder="Enter your email"
                    class="w-full
                           mt-5
                           rounded-xl
                           px-4 py-3
                           text-gray-900
                           text-sm
                           outline-none">


                <button type="button"
                        class="w-full
                               mt-2
                               rounded-xl
                               bg-[#17152b]
                               py-3
                               text-[10px]
                               uppercase
                               tracking-widest
                               font-black
                               hover:bg-black
                               transition">

                    Subscribe →

                </button>

            </div>

        </section>

    </aside>

</div>

</main>


{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#17152b] text-gray-400 mt-12">

    <div class="max-w-7xl mx-auto px-4 py-12">


        <div class="grid
                    md:grid-cols-3
                    gap-10">


            <div>

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10
                                rounded-xl
                                bg-gradient-to-br
                                from-purple-600
                                to-pink-500
                                text-white
                                flex items-center
                                justify-center
                                font-black">

                        N

                    </div>


                    <div class="text-2xl
                                text-white
                                font-black">
                      {{ $website->name }}

                    </div>

                </div>


                <p class="text-sm
                          leading-6
                          mt-4
                          text-gray-500">

                    Independent journalism,
                    culture, ideas and stories
                    that matter.

                </p>

            </div>


            <div>

                <h3 class="text-white
                           text-xs
                           uppercase
                           tracking-widest
                           font-black
                           mb-5">

                    Categories

                </h3>


                <div class="grid grid-cols-2 gap-3">

                    @foreach($categories->take(10) as $category)

                        <a href="{{ route('frontend.category', [
                            'websiteSlug' => $website->slug,
                            'categorySlug' => $category->slug
                        ]) }}"
                           class="text-xs
                                  hover:text-purple-400
                                  transition">

                            {{ $category->name }}

                        </a>

                    @endforeach

                </div>

            </div>


            <div>

                <h3 class="text-white
                           text-xs
                           uppercase
                           tracking-widest
                           font-black
                           mb-5">

                    Contact

                </h3>


                @if($setting?->email)

                    <a href="mailto:{{ $setting->email }}"
                       class="text-sm
                              break-all
                              hover:text-white">

                        {{ $setting->email }}

                    </a>

                @endif


                @if($setting?->phone)

                    <div class="text-sm mt-3">

                        {{ $setting->phone }}

                    </div>

                @endif

            </div>

        </div>


        <div class="border-t
                    border-white/10
                    mt-10 pt-5
                    flex flex-col
                    sm:flex-row
                    justify-between
                    gap-3">

            <span class="text-[10px]
                         uppercase
                         tracking-widest">

                © {{ date('Y') }}
                {{ $website->name }}

            </span>


            <span class="text-[10px]
                         uppercase
                         tracking-widest">

                Powered by NewsHub CMS

            </span>

        </div>

    </div>

</footer>

</body>
</html>