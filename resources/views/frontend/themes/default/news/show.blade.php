<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        {{ $news->title }} - {{ $website->name }}
    </title>

    <meta name="description"
          content="{{ \Illuminate\Support\Str::limit(strip_tags($news->description), 160) }}">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f7f7f5] text-gray-900">

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md
               border-b border-gray-200 shadow-sm">

    <div class="bg-[#111827] text-gray-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
                    h-9 flex items-center justify-between">

            <div class="flex items-center gap-2 text-[11px] font-semibold">

                <span class="w-1.5 h-1.5 bg-red-500
                             rounded-full animate-pulse"></span>

                <span>
                    Independent • Fast • Trusted News
                </span>

            </div>

            <div class="hidden sm:block text-[11px] text-gray-400">
                {{ now()->format('l, d F Y') }}
            </div>

        </div>

    </div>


    {{-- BRAND --}}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-20 flex items-center justify-between">

            <a href="{{ frontend_home_url() }}"
               class="flex items-center gap-3">

                <div class="w-11 h-11
                            bg-red-600
                            text-white
                            flex items-center justify-center
                            rounded-md
                            shadow-md">

                    <span class="text-xl font-black">

                      {{ strtoupper(substr($website->name, 0, 1 )) }}

                    </span>

                </div>

                <div>

                    <div class="text-2xl sm:text-3xl
                                font-black tracking-tight">

                        {{ $website->name }}

                    </div>

                    <div class="hidden sm:block
                                text-[9px]
                                uppercase
                                tracking-[0.3em]
                                text-gray-500
                                font-semibold">

                        News • Ideas • Perspective

                    </div>

                </div>

            </a>

        </div>


        {{-- CATEGORY NAVIGATION --}}

        <nav class="border-t border-gray-100">

            <div class="flex items-center gap-8
                        overflow-x-auto
                        whitespace-nowrap">

                <a href="{{ frontend_home_url() }}"
                   class="relative py-4
                          text-xs font-black uppercase
                          tracking-wide
                          text-red-600">

                    Home

                    <span class="absolute
                                 left-0 right-0 bottom-0
                                 h-0.5 bg-red-600">
                    </span>

                </a>

                @foreach($website->categories ?? [] as $category)

                    <a href="{{ frontend_category_url($category->slug) }}"
                       class="py-4
                              text-xs font-bold uppercase
                              tracking-wide
                              text-gray-500
                              hover:text-red-600">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>

        </nav>

    </div>
 </header>


{{-- ========================================================= --}}
{{-- ARTICLE --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto
             px-4 sm:px-6 lg:px-8
             py-10 sm:py-14">

    <div class="grid lg:grid-cols-12
                gap-8 lg:gap-12">


        {{-- ================================================= --}}
        {{-- MAIN ARTICLE --}}
        {{-- ================================================= --}}

        <article class="lg:col-span-8">


            {{-- Breadcrumb --}}

            <div class="flex items-center
                        flex-wrap gap-2
                        text-xs
                        text-gray-500
                        mb-6">

                <a href="{{ frontend_home_url() }}"
                   class="hover:text-red-600">

                    Home

                </a>

                <span>›</span>

                @if($news->category)

                    <a href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                        'categorySlug' => $news->category->slug
                    ]) }}"
                       class="text-red-600 font-semibold">

                        {{ $news->category->name }}

                    </a>

                    <span>›</span>

                @endif

                <span class="text-gray-400">
                    Article
                </span>

            </div>


            {{-- CATEGORY --}}

            @if($news->category)

                <div class="mb-4">

                    <span class="inline-flex
                                 items-center
                                 bg-red-600
                                 text-white
                                 px-3 py-1.5
                                 rounded-full
                                 text-[10px]
                                 font-black
                                 uppercase
                                 tracking-wider">

                        {{ $news->category->name }}

                    </span>

                </div>

            @endif


            {{-- BIG ARTICLE HEADING --}}

            <h1 class="font-serif
                       text-4xl
                       sm:text-5xl
                       lg:text-6xl
                       leading-[1.05]
                       font-black
                       tracking-tight
                       text-gray-950">

                {{ $news->title }}

            </h1>


            {{-- META --}}

            <div class="flex items-center
                        flex-wrap gap-4
                        mt-6
                        pb-6
                        border-b border-gray-200">

                <div class="flex items-center gap-2">

                    <div class="w-9 h-9
                                rounded-full
                                bg-red-600
                                text-white
                                flex items-center justify-center
                                font-black">

                        N

                    </div>

                    <div>

                        <div class="text-xs
                                    font-black
                                    text-gray-800">

                            {{ $website->name }}

                        </div>

                        <div class="text-[10px]
                                    text-gray-400">

                            NewsHub Editorial

                        </div>

                    </div>

                </div>

                <span class="text-gray-300">
                    •
                </span>

                <span class="text-xs text-gray-500">

                    {{ optional($news->published_at)->format('d F Y') }}

                </span>

                <span class="text-gray-300">
                    •
                </span>
                     <span class="text-xs text-gray-500">

                    {{ optional($news->published_at)->diffForHumans() }}

                </span>

            </div>


            {{-- FEATURED IMAGE --}}

            @if($news->featured_image)

                <div class="mt-8
                            rounded-2xl
                            overflow-hidden
                            bg-gray-200
                            shadow-xl">

                    <img
                        src="{{ asset('storage/' . $news->featured_image) }}"
                        alt="{{ $news->title }}"
                        class="w-full
                               max-h-[620px]
                               object-cover">

                </div>

            @endif


            {{-- ARTICLE CONTENT --}}

            <div class="mt-8
                        bg-white
                        rounded-2xl
                        border border-gray-200
                        p-5 sm:p-8 lg:p-10
                        shadow-sm">

                <div class="prose
                            prose-lg
                            max-w-none
                            text-gray-700
                            leading-8">

                    {!! $news->description !!}

                </div>

            </div>


            {{-- SHARE / BACK --}}

            <div class="mt-8
                        flex flex-col sm:flex-row
                        items-center
                        justify-between
                        gap-4
                        border-y border-gray-200
                        py-5">

                <a href="{{ frontend_home_url() }}"
                   class="inline-flex
                          items-center gap-2
                          px-5 py-3
                          rounded-lg
                          bg-gray-900
                          text-white
                          text-sm
                          font-bold
                          hover:bg-red-600
                          transition">

                    ← Back to Home

                </a>

                <div class="text-xs
                            uppercase
                            tracking-widest
                            font-bold
                            text-gray-400">

                    Thanks for reading

                </div>

            </div>

        </article>


        {{-- ================================================= --}}
        {{-- SIDEBAR --}}
        {{-- ================================================= --}}

        <aside class="lg:col-span-4">


            <div class="sticky top-28
                        space-y-6">


                {{-- WEBSITE CARD --}}

                <section class="bg-[#111827]
                                text-white
                                rounded-2xl
                                p-6
                                shadow-lg">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11
                                    bg-red-600
                                    rounded-lg
                                    flex items-center justify-center
                                    font-black
                                    text-xl">

                            N

                        </div>

                        <div>

                            <div class="font-black text-lg">

                                {{ $website->name }}

                            </div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-gray-400">

                                Trusted News

                            </div>

                        </div>

                    </div>
                       <p class="text-sm
                              text-gray-400
                              leading-6
                              mt-5">

                        Stay informed with the latest
                        news, stories and updates.

                    </p>

                </section>


                {{-- ARTICLE INFO --}}

                <section class="bg-white
                                rounded-2xl
                                border border-gray-200
                                p-6">

                    <h2 class="text-sm
                               uppercase
                               tracking-widest
                               font-black
                               border-b
                               border-gray-200
                               pb-4">

                        Article Information

                    </h2>

                    <div class="space-y-4 mt-5">

                        @if($news->category)

                            <div>

                                <div class="text-[9px]
                                            uppercase
                                            tracking-widest
                                            text-gray-400
                                            font-bold">

                                    Category

                                </div>

                                <div class="text-sm
                                            font-bold
                                            text-red-600
                                            mt-1">

                                    {{ $news->category->name }}

                                </div>

                            </div>

                        @endif


                        <div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-gray-400
                                        font-bold">

                                Published

                            </div>

                            <div class="text-sm
                                        font-semibold
                                        mt-1">

                                {{ optional($news->published_at)->format('d M Y, h:i A') }}

                            </div>

                        </div>


                        <div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-gray-400
                                        font-bold">

                                Website

                            </div>

                            <div class="text-sm
                                        font-semibold
                                        mt-1">

                                {{ $website->name }}

                            </div>

                        </div>

                    </div>

                </section>


            </div>

        </aside>

    </div>

</main>


{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#0b1120]
               text-gray-400
               mt-10">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-10">

        <div class="flex flex-col
                    md:flex-row
                    items-center
                    justify-between
                    gap-4">

            <div>

                <div class="text-white
                            font-black
                            text-lg">

                    {{ $website->name }}

                </div>

                <div class="text-xs mt-1">

                    News • Ideas • Perspective

                </div>

            </div>
                <div class="text-xs">

                © {{ date('Y') }}
                {{ $website->name }}.
                All rights reserved.

            </div>

        </div>

    </div>

</footer>

</body>
</html>