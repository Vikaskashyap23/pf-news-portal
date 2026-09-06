<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $news->title }} - {{ $website->name }}</title>

    <meta name="description"
          content="{{ \Illuminate\Support\Str::limit(strip_tags($news->description), 160) }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        magazine: ['Georgia', 'Times New Roman', 'serif'],
                        sans: ['Inter', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>


<body class="bg-[#f5f1e8] text-[#171717]">


{{-- ========================================================= --}}
{{-- MAGAZINE HEADER --}}
{{-- ========================================================= --}}

<header class="bg-[#f5f1e8] border-b-4 border-black">

    {{-- TOP BAR --}}
    <div class="border-b border-black/20">

        <div class="max-w-7xl mx-auto
                    px-4 sm:px-6 lg:px-8
                    py-2
                    flex items-center
                    justify-between
                    text-[10px]
                    uppercase
                    tracking-[0.2em]
                    font-bold">

            <span>
                Independent Journalism
            </span>

            <span class="hidden sm:block">
                {{ now()->format('l, d F Y') }}
            </span>

        </div>

    </div>


    {{-- BRAND --}}
    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-7">

        <div class="flex flex-col
                    md:flex-row
                    md:items-end
                    md:justify-between
                    gap-5">

            {{-- WEBSITE NAME --}}

            <a href="{{ frontend_home_url() }}"
               class="group">

                <div class="font-magazine
                            text-4xl
                            sm:text-5xl
                            lg:text-6xl
                            font-black
                            uppercase
                            leading-none
                            tracking-tight
                            group-hover:text-red-700
                            transition">

                    {{ $website->name }}

                </div>

                <div class="mt-2
                            text-[10px]
                            uppercase
                            tracking-[0.35em]
                            font-bold
                            text-gray-500">

                    News • Ideas • Perspective

                </div>

            </a>


            {{-- DATE / EDITION --}}

            <div class="text-left md:text-right">

                <div class="text-xs
                            uppercase
                            tracking-widest
                            font-black">

                    Today's Edition

                </div>

                <div class="text-[11px]
                            text-gray-500
                            mt-1">

                    Updated {{ now()->format('d M Y') }}

                </div>

            </div>

        </div>

    </div>


    {{-- NAVIGATION --}}

    <nav class="border-t border-black
                overflow-x-auto">

        <div class="max-w-7xl mx-auto
                    px-4 sm:px-6 lg:px-8
                    flex items-center
                    gap-6
                    whitespace-nowrap">

            <a href="{{ frontend_home_url() }}"
               class="py-4
                      text-xs
                      uppercase
                      tracking-widest
                      font-black
                      hover:text-red-700
                      transition">

                {{ __('messages.home') }}

            </a>
                      @foreach($website->categories ?? [] as $category)

                <a href="{{ frontend_category_url($category->slug) }}"
                   class="py-4
                          text-xs
                          uppercase
                          tracking-widest
                          font-bold
                          text-gray-600
                          hover:text-red-700
                          transition">

                    {{ $category->name }}

                </a>

            @endforeach

        </div>

    </nav>

</header>



{{-- ========================================================= --}}
{{-- ARTICLE AREA --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto
             px-4 sm:px-6 lg:px-8
             py-8 sm:py-12">


    {{-- BREADCRUMB --}}

    <div class="mb-8
                text-[10px]
                uppercase
                tracking-widest
                font-bold
                text-gray-500">

        <a href="{{ frontend_home_url() }}"
           class="hover:text-red-700">

            Home

        </a>

        <span class="mx-2">
            /
        </span>

        <span>
            {{ $news->category->name ?? 'News' }}
        </span>

    </div>



    {{-- MAGAZINE ARTICLE GRID --}}

    <div class="grid lg:grid-cols-12
                gap-10">


        {{-- ================================================= --}}
        {{-- MAIN ARTICLE --}}
        {{-- ================================================= --}}

        <article class="lg:col-span-8">


            {{-- CATEGORY --}}

            <div class="mb-4">

                <span class="inline-block
                             bg-black
                             text-white
                             px-4 py-2
                             text-[10px]
                             uppercase
                             tracking-[0.2em]
                             font-black">

                    {{ $news->category->name ?? 'News' }}

                </span>

            </div>



            {{-- BIG MAGAZINE HEADLINE --}}

            <h1 class="font-magazine
                       text-4xl
                       sm:text-5xl
                       lg:text-7xl
                       leading-[0.95]
                       font-black
                       tracking-tight
                       mb-6">

                {{ $news->title }}

            </h1>



            {{-- SHORT META --}}

            <div class="border-y
                        border-black/20
                        py-3
                        mb-7
                        flex flex-wrap
                        items-center
                        gap-4
                        text-[10px]
                        uppercase
                        tracking-widest
                        font-bold
                        text-gray-600">

                <span>

                    {{ $website->name }}

                </span>

                <span class="text-red-700">
                    •
                </span>

                <span>

                    {{ optional($news->published_at)->format('d M Y') }}

                </span>

                @if($news->published_at)

                    <span class="text-red-700">
                        •
                    </span>

                    <span>

                        {{ $news->published_at->diffForHumans() }}

                    </span>

                @endif

            </div>



            {{-- FEATURED IMAGE --}}

            @if($news->featured_image)

                <figure class="mb-8">

                    <div class="overflow-hidden
                                border border-black">
                             <img
                            src="{{ asset('storage/' . $news->featured_image) }}"
                            alt="{{ $news->title }}"
                            class="w-full
                                   max-h-[650px]
                                   object-cover">

                    </div>

                    <figcaption class="mt-2
                                        text-[10px]
                                        uppercase
                                        tracking-wider
                                        text-gray-500">

                        {{ $news->title }}

                    </figcaption>

                </figure>

            @endif



            {{-- ARTICLE CONTENT --}}

            <div class="font-magazine
                        text-lg
                        sm:text-xl
                        leading-[1.9]
                        text-gray-800">

                {!! $news->description !!}

            </div>



            {{-- ARTICLE FOOTER --}}

            <div class="mt-10
                        pt-5
                        border-t-2
                        border-black">

                <div class="flex flex-wrap
                            items-center
                            justify-between
                            gap-4">

                    <div>

                        <div class="text-[9px]
                                    uppercase
                                    tracking-widest
                                    text-gray-500
                                    font-bold">

                            Published By

                        </div>

                        <div class="font-bold
                                    mt-1">

                            {{ $website->name }}

                        </div>

                    </div>


                    <a href="{{ frontend_home_url() }}"
                       class="inline-flex
                              items-center
                              gap-2
                              bg-black
                              text-white
                              px-5 py-3
                              text-xs
                              uppercase
                              tracking-widest
                              font-black
                              hover:bg-red-700
                              transition">

                        ← Back To Home

                    </a>

                </div>

            </div>

        </article>



        {{-- ================================================= --}}
        {{-- SIDEBAR --}}
        {{-- ================================================= --}}

        <aside class="lg:col-span-4">


            {{-- SIDEBAR HEADING --}}

            <div class="border-t-4
                        border-black
                        pt-3
                        mb-5">

                <div class="flex items-center
                            justify-between">

                    <h2 class="font-magazine
                               text-2xl
                               font-black
                               uppercase">

                        Latest News

                    </h2>

                    <span class="text-[9px]
                                 uppercase
                                 tracking-widest
                                 text-gray-500">

                        Updates

                    </span>

                </div>

            </div>



            {{-- LATEST NEWS --}}

            @php

                $latestNews = \App\Models\News::where(
                    'website_id',
                    $website->id
                )
                ->where('status', 'published')
                ->where('id', '!=', $news->id)
                ->latest('published_at')
                ->take(5)
                ->get();

            @endphp
             <div class="divide-y
                        divide-black/20">


                @forelse($latestNews as $index => $item)

                    <article class="py-5
                                    group">

                        <div class="flex gap-4">


                            {{-- NUMBER --}}

                            <div class="flex-shrink-0">

                                <span class="font-magazine
                                             text-3xl
                                             font-black
                                             text-gray-300
                                             group-hover:text-red-700
                                             transition">

                                    {{ str_pad(
                                        $index + 1,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </span>

                            </div>



                            {{-- CONTENT --}}

                            <div class="min-w-0">

                                <div class="text-[9px]
                                            uppercase
                                            tracking-widest
                                            font-black
                                            text-red-700
                                            mb-2">

                                    {{ $item->category->name ?? 'News' }}

                                </div>


                                <a href="{{ frontend_news_url($item->slug) }}">

                                    <h3 class="font-magazine
                                               text-xl
                                               font-black
                                               leading-tight
                                               group-hover:text-red-700
                                               transition">

                                        {{ $item->title }}

                                    </h3>

                                </a>


                                @if($item->published_at)

                                    <div class="mt-2
                                                text-[9px]
                                                uppercase
                                                tracking-widest
                                                text-gray-500">

                                        {{ $item->published_at->diffForHumans() }}

                                    </div>

                                @endif

                            </div>

                        </div>

                    </article>

                @empty

                    <p class="py-5
                              text-sm
                              text-gray-500">

                        No latest news available.

                    </p>

                @endforelse

            </div>



            {{-- SIDEBAR BOX --}}

            <div class="mt-8
                        bg-black
                        text-white
                        p-6">

                <div class="text-[9px]
                            uppercase
                            tracking-[0.25em]
                            text-red-400
                            font-black">

                    {{ $website->name }}

                </div>

                <h3 class="font-magazine
                           text-3xl
                           font-black
                           leading-tight
                           mt-3">

                    Stories that
                    matter.

                </h3>
               <p class="text-sm
                          text-gray-400
                          leading-6
                          mt-3">

                    Read the latest stories,
                    opinions and important
                    updates from our newsroom.

                </p>

                <a href="{{ frontend_home_url() }}"
                   class="inline-block
                          mt-5
                          bg-red-700
                          px-5 py-3
                          text-[10px]
                          uppercase
                          tracking-widest
                          font-black
                          hover:bg-red-600
                          transition">

                    Explore News →

                </a>

            </div>

        </aside>

    </div>

</main>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="border-t-4
               border-black
               bg-[#111111]
               text-gray-300">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-10">

        <div class="flex flex-col
                    md:flex-row
                    items-center
                    justify-between
                    gap-5">

            <div>

                <div class="font-magazine
                            text-2xl
                            font-black
                            text-white">

                    {{ $website->name }}

                </div>

                <p class="text-xs
                          text-gray-500
                          mt-1">

                    Independent journalism and trusted news.

                </p>

            </div>


            <div class="text-[10px]
                        uppercase
                        tracking-widest
                        text-gray-500">

                © {{ date('Y') }}
                {{ $website->name }}
                • All Rights Reserved

            </div>

        </div>

    </div>

</footer>

</body>
</html>