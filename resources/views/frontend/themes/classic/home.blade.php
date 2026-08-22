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
                    fontFamily: {
                        news: ['Georgia', 'Times New Roman', 'serif'],
                        sans: ['Arial', 'Helvetica', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: Georgia, "Times New Roman", serif;
        }

        .headline {
            font-family: Georgia, "Times New Roman", serif;
        }

        .sans {
            font-family: Arial, Helvetica, sans-serif;
        }

        .newspaper-rule {
            border-color: #1f2937;
        }

        .dropcap:first-letter {
            float: left;
            font-size: 4.5rem;
            line-height: 0.8;
            padding-right: 8px;
            font-weight: 900;
        }
    </style>
</head>

<body class="bg-[#f4f0e6] text-[#171717]">

{{-- ========================================================= --}}
{{-- TOP DATE BAR --}}
{{-- ========================================================= --}}

<div class="bg-[#171717] text-white">

    <div class="max-w-7xl mx-auto px-4 py-2
                flex flex-col sm:flex-row
                items-center justify-between
                gap-1">

        <div class="sans text-[10px] uppercase tracking-[0.25em] text-gray-300">
            Independent Journalism • Trusted News
        </div>

        <div class="sans text-[10px] uppercase tracking-widest text-gray-400">
            {{ now()->format('l, d F Y') }}
        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- MAIN NEWSPAPER HEADER --}}
{{-- ========================================================= --}}

<header class="bg-[#f8f5ec] border-b-4 border-[#171717]">

    <div class="max-w-7xl mx-auto px-4">

        {{-- BRAND --}}
        <div class="py-7 sm:py-9 text-center">

            <div class="sans text-[9px] uppercase tracking-[0.45em]
                        text-gray-500 mb-3">
                The Daily Chronicle
            </div>

            <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
               class="block">

                <h1 class="headline text-4xl sm:text-6xl lg:text-7xl
                           font-black uppercase tracking-tight
                           leading-none">

                    {{ $website->name }}

                </h1>

            </a>

            <div class="flex items-center justify-center gap-3 mt-4">

                <span class="h-px w-12 bg-gray-400"></span>

                <span class="sans text-[9px] uppercase tracking-[0.3em] text-gray-500">
                    News • Ideas • Perspective
                </span>

                <span class="h-px w-12 bg-gray-400"></span>

            </div>

        </div>


        {{-- NAVIGATION --}}
        <nav class="border-t-2 border-b border-gray-800">

            <div class="flex items-center
                        overflow-x-auto whitespace-nowrap">

                <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
                   class="sans px-4 py-3
                          text-[11px] font-black uppercase tracking-wider
                          bg-[#171717] text-white">

                    {{ __('messages.home') }}

                </a>


                @foreach($categories as $category)
                       <a href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                        'categorySlug' => $category->slug
                    ]) }}"
                       class="sans px-4 py-3
                              text-[11px] font-bold uppercase
                              tracking-wider
                              hover:bg-[#ded8c9]
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

<section class="bg-[#b91c1c] text-white">

    <div class="max-w-7xl mx-auto px-4">

        <div class="flex items-stretch">

            <div class="sans flex-shrink-0
                        bg-[#7f1d1d]
                        px-5 py-3
                        text-[10px]
                        font-black
                        uppercase
                        tracking-[0.2em]
                        flex items-center">

                BREAKING

            </div>

            <div class="flex-1 overflow-x-auto">

                <div class="flex items-center
                            gap-8 px-5 py-3
                            whitespace-nowrap">

                    @foreach($breakingNews as $breaking)

                        <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $breaking->slug
                        ]) }}"
                           class="text-sm font-bold
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

<main class="max-w-7xl mx-auto px-4 py-8">


{{-- ========================================================= --}}
{{-- EDITION BAR --}}
{{-- ========================================================= --}}

<div class="flex items-center justify-between
            border-b border-gray-400
            pb-2 mb-7">

    <span class="sans text-[10px]
                 uppercase tracking-[0.25em]
                 font-black">

        Today's Edition

    </span>

    <span class="sans text-[10px]
                 uppercase tracking-widest
                 text-gray-500">

        {{ now()->format('d M Y') }}

    </span>

</div>


{{-- ========================================================= --}}
{{-- HERO NEWS --}}
{{-- ========================================================= --}}

@if($featuredNews->count())

@php

    $hero = $featuredNews->first();

    $secondaryNews = $featuredNews->skip(1)->take(4);

@endphp

<section class="grid lg:grid-cols-12 gap-7
                border-b-4 border-[#171717]
                pb-8 mb-10">


    {{-- MAIN STORY --}}
    <article class="lg:col-span-8
                    border-r-0 lg:border-r
                    border-gray-400
                    lg:pr-7">

        @if($hero->featured_image)

            <div class="relative overflow-hidden mb-5">

                <img
                    src="{{ asset('storage/' . $hero->featured_image) }}"
                    alt="{{ $hero->title }}"
                    class="w-full
                           aspect-[16/9]
                           object-cover">

                <div class="absolute bottom-0 left-0
                             bg-[#b91c1c]
                            text-white
                            px-4 py-2
                            sans text-[9px]
                            font-black
                            uppercase
                            tracking-widest">

                    FEATURED

                </div>

            </div>

        @endif


        <div class="sans text-[10px]
                    uppercase tracking-[0.2em]
                    text-[#b91c1c]
                    font-black mb-2">

            {{ $hero->category->name ?? 'News' }}

        </div>


        <a href="{{ route('frontend.news', [
            'websiteSlug' => $website->slug,
            'newsSlug' => $hero->slug
        ]) }}">

            <h2 class="headline
                       text-3xl sm:text-4xl lg:text-5xl
                       font-black
                       leading-[1.05]
                       hover:text-[#b91c1c]
                       transition">

                {{ $hero->title }}

            </h2>

        </a>


        <div class="sans text-[10px]
                    uppercase tracking-widest
                    text-gray-500
                    mt-4 mb-4">

            {{ optional($hero->published_at)->format('d M Y, h:i A') }}

        </div>


        <p class="text-base sm:text-lg
                  leading-7
                  text-gray-700
                  dropcap">

            {{ \Illuminate\Support\Str::limit(
                strip_tags($hero->description),
                320
            ) }}

        </p>


        <a href="{{ route('frontend.news', [
            'websiteSlug' => $website->slug,
            'newsSlug' => $hero->slug
        ]) }}"
           class="inline-block
                  mt-5
                  sans text-[10px]
                  font-black
                  uppercase
                  tracking-widest
                  border-b-2
                  border-[#b91c1c]
                  pb-1
                  hover:text-[#b91c1c]">

            {{ __('messages.read_full_story') }} →

        </a>

    </article>


    {{-- SECONDARY STORIES --}}
    <div class="lg:col-span-4">

        <div class="sans text-[10px]
                    uppercase tracking-[0.2em]
                    font-black
                    border-b-2 border-gray-900
                    pb-2 mb-4">

            Top Stories

        </div>


        <div>

            @foreach($secondaryNews as $index => $item)

                <article class="py-4
                                border-b border-gray-400
                                last:border-0">

                    <div class="flex gap-4">

                        <span class="headline
                                     text-3xl
                                     font-black
                                     text-gray-300">

                            {{ str_pad($index + 2, 2, '0', STR_PAD_LEFT) }}

                        </span>


                        <div>

                            <div class="sans text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-[#b91c1c]
                                        font-black mb-1">

                                {{ $item->category->name ?? 'News' }}

                            </div>


                            <a href="{{ route('frontend.news', [
                                'websiteSlug' => $website->slug,
                                'newsSlug' => $item->slug
                            ]) }}">

                                <h3 class="headline
                                           text-lg
                                           font-bold
                                           leading-snug
                                           hover:text-[#b91c1c]
                                           transition">

                                    {{ $item->title }}

                                </h3>

                            </a>
                                        <div class="sans text-[9px]
                                        text-gray-500
                                        uppercase
                                        tracking-wider
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
{{-- CONTENT COLUMNS --}}
{{-- ========================================================= --}}

<div class="grid lg:grid-cols-12 gap-8">


    {{-- ========================================================= --}}
    {{-- LATEST NEWS --}}
    {{-- ========================================================= --}}

    <section class="lg:col-span-8">

        <div class="flex items-center justify-between
                    border-b-4 border-[#171717]
                    pb-2 mb-5">

            <h2 class="headline
                       text-2xl sm:text-3xl
                       font-black
                       uppercase">

                {{ __('messages.latest_news') }}

            </h2>

            <span class="sans text-[9px]
                         uppercase tracking-widest
                         text-gray-500">

                Latest

            </span>

        </div>


        <div>

            @forelse($latestNews as $index => $item)

                <article class="py-5
                                border-b border-gray-400">

                    <div class="grid sm:grid-cols-12 gap-5">

                        {{-- IMAGE --}}
                        @if($item->featured_image)

                            <div class="sm:col-span-4">

                                <img
                                    src="{{ asset('storage/' . $item->featured_image) }}"
                                    alt="{{ $item->title }}"
                                    class="w-full
                                           aspect-[4/3]
                                           object-cover
                                           grayscale-[15%]">

                            </div>

                        @endif


                        {{-- CONTENT --}}
                        <div class="{{ $item->featured_image ? 'sm:col-span-8' : 'sm:col-span-12' }}">

                            <div class="sans text-[9px]
                                        uppercase
                                        tracking-[0.2em]
                                        font-black
                                        text-[#b91c1c]
                                        mb-2">

                                {{ $item->category->name ?? 'News' }}

                                <span class="text-gray-400 mx-1">
                                    •
                                </span>

                                <span class="text-gray-500">

                                    {{ optional($item->published_at)->diffForHumans() }}

                                </span>

                            </div>


                            <a href="{{ route('frontend.news', [
                                'websiteSlug' => $website->slug,
                                'newsSlug' => $item->slug
                            ]) }}">

                                <h3 class="headline
                                           text-2xl sm:text-3xl
                                           font-black
                                           leading-tight
                                           hover:text-[#b91c1c]
                                           transition">

                                    {{ $item->title }}

                                </h3>

                            </a>
                                     <p class="mt-3
                                      text-sm sm:text-base
                                      leading-6
                                      text-gray-600">

                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags($item->description),
                                    180
                                ) }}

                            </p>


                            <a href="{{ route('frontend.news', [
                                'websiteSlug' => $website->slug,
                                'newsSlug' => $item->slug
                            ]) }}"
                               class="inline-block
                                      mt-3
                                      sans text-[9px]
                                      font-black
                                      uppercase
                                      tracking-widest
                                      text-[#b91c1c]">

                                {{ __('messages.read_story') }} →

                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div class="py-16
                            text-center
                            border border-dashed
                            border-gray-400">

                    <div class="text-4xl mb-3">
                        📰
                    </div>

                    <h3 class="headline
                               text-xl
                               font-bold">

                        No published news available.

                    </h3>

                    <p class="sans text-sm
                              text-gray-500
                              mt-2">

                        Published stories will appear here.

                    </p>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($latestNews->hasPages())

            <div class="mt-7
                        border-t
                        border-gray-400
                        pt-5">

                {{ $latestNews->links() }}

            </div>

        @endif

    </section>


    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}

    <aside class="lg:col-span-4">


        {{-- TRENDING --}}
        <section class="border-t-4
                        border-[#171717]
                        bg-[#ebe6d9]">

            <div class="px-5 py-4
                        border-b border-gray-400">

                <h2 class="headline
                           text-xl
                           font-black
                           uppercase">

                    {{ __('messages.trending') }}

                </h2>

                <div class="sans text-[9px]
                            uppercase
                            tracking-[0.2em]
                            text-gray-500
                            mt-1">

                    Most Read Today

                </div>

            </div>


            <div class="px-5">

                @foreach($latestNews->take(5) as $index => $item)

                    <article class="py-4
                                    border-b border-gray-400
                                    last:border-0">

                        <div class="flex gap-4">

                            <div class="headline
                                        text-3xl
                                        font-black
                                        text-gray-400">

                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                            </div>


                            <div>
                                 <div class="sans text-[8px]
                                            uppercase
                                            tracking-widest
                                            text-[#b91c1c]
                                            font-black">

                                    {{ $item->category->name ?? 'News' }}

                                </div>


                                <a href="{{ route('frontend.news', [
                                    'websiteSlug' => $website->slug,
                                    'newsSlug' => $item->slug
                                ]) }}">

                                    <h3 class="headline
                                               text-base
                                               font-bold
                                               leading-snug
                                               mt-1
                                               hover:text-[#b91c1c]">

                                        {{ $item->title }}

                                    </h3>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        </section>


        {{-- CATEGORIES --}}
        <section class="mt-8
                        border-t-4
                        border-[#171717]
                        pt-4">

            <h2 class="headline
                       text-xl
                       font-black
                       uppercase
                       mb-4">

                Categories

            </h2>


            <div class="grid grid-cols-2 gap-2">

                @foreach($categories->take(12) as $category)

                    <a href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                        'categorySlug' => $category->slug
                    ]) }}"
                       class="sans
                              border
                              border-gray-400
                              px-3 py-3
                              text-[10px]
                              font-bold
                              uppercase
                              tracking-wider
                              hover:bg-[#171717]
                              hover:text-white
                              transition">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>

        </section>


        {{-- NEWSLETTER --}}
        <section class="mt-8
                        bg-[#171717]
                        text-white
                        p-6">

            <div class="sans text-[9px]
                        uppercase
                        tracking-[0.25em]
                        text-red-400
                        font-black">

                Daily Newsletter

            </div>


            <h2 class="headline
                       text-2xl
                       font-black
                       mt-3
                       leading-tight">

                News worth
                knowing.

            </h2>


            <p class="sans text-sm
                      text-gray-400
                      leading-6
                      mt-3">

                Get the important headlines
                and latest stories directly
                in your inbox.

            </p>


            <form class="mt-5">

                <input
                    type="email"
                    placeholder="Your email address"
                    class="w-full
                           bg-white
                           text-gray-900
                           px-4 py-3
                           text-sm
                           outline-none">
                          <button
                    type="button"
                    class="w-full
                           mt-2
                           bg-[#b91c1c]
                           text-white
                           py-3
                           sans text-[10px]
                           font-black
                           uppercase
                           tracking-widest
                           hover:bg-red-800
                           transition">

                    Subscribe →

                </button>

            </form>

        </section>

    </aside>

</div>

</main>


{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#171717] text-gray-300 mt-12">

    <div class="max-w-7xl mx-auto px-4 py-12">


        <div class="grid md:grid-cols-3 gap-10">


            {{-- BRAND --}}
            <div>

                <div class="headline
                            text-3xl
                            text-white
                            font-black">

                    {{ $website->name }}

                </div>

                <p class="sans text-sm
                          text-gray-500
                          leading-6
                          mt-4">

                    Independent journalism,
                    breaking news and stories
                    that matter.

                </p>

            </div>


            {{-- CATEGORIES --}}
            <div>

                <h3 class="sans text-[10px]
                           uppercase
                           tracking-[0.2em]
                           font-black
                           text-white
                           mb-4">

                    Categories

                </h3>


                <div class="grid grid-cols-2 gap-3">

                    @foreach($categories->take(8) as $category)

                        <a href="{{ route('frontend.category', [
                            'websiteSlug' => $website->slug,
                            'categorySlug' => $category->slug
                        ]) }}"
                           class="sans text-xs
                                  text-gray-500
                                  hover:text-white
                                  transition">

                            {{ $category->name }}

                        </a>

                    @endforeach

                </div>

            </div>


            {{-- CONTACT --}}
            <div>

                <h3 class="sans text-[10px]
                           uppercase
                           tracking-[0.2em]
                           font-black
                           text-white
                           mb-4">

                    Contact

                </h3>


                @if($setting?->email)

                    <a href="mailto:{{ $setting->email }}"
                       class="sans text-sm
                              text-gray-500
                              hover:text-white
                              break-all">

                        {{ $setting->email }}

                    </a>

                @endif


                @if($setting?->phone)

                    <div class="sans text-sm
                                text-gray-500
                                mt-3">

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
                    gap-2">

            <span class="sans text-[10px]
                         uppercase
                         tracking-widest
                         text-gray-600">

                © {{ date('Y') }}
                {{ $website->name }}
                — All Rights Reserved

            </span>
                       <span class="sans text-[10px]
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