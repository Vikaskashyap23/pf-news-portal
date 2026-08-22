<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $news->meta_title ?: $news->title }}
        - {{ $website->name }}
    </title>

    <meta name="description"
          content="{{ $news->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($news->description), 160) }}">

    @if($news->meta_keywords)
        <meta name="keywords" content="{{ $news->meta_keywords }}">
    @endif

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


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md
               border-b border-gray-200 shadow-sm">


    {{-- TOP BAR --}}

    <div class="bg-[#111827] text-gray-300">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8
                    h-9 flex items-center justify-between">

            <div class="flex items-center gap-2 text-[11px]
                        font-semibold tracking-wide">

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


    {{-- BRAND HEADER --}}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-20 flex items-center justify-between">


            {{-- BRAND --}}

            <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
               class="flex items-center gap-3 group">


                {{-- LOGO --}}

                <div class="relative w-11 h-11 sm:w-12 sm:h-12
                            bg-red-600 text-white
                            flex items-center justify-center
                            rounded-md shadow-md
                            group-hover:bg-red-700
                            transition duration-300">

                    @if($website->logo)

                        <img
                            src="{{ asset('storage/' . $website->logo) }}"
                            alt="{{ $website->name }}"
                            class="w-full h-full object-cover rounded-md">

                    @else

                        <span class="text-xl sm:text-2xl font-black">
                            {{ strtoupper(substr($website->name, 0, 1)) }}
                        </span>

                    @endif

                </div>


                {{-- WEBSITE NAME --}}

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


            {{-- MOBILE MENU --}}

            <details class="relative">
                 <summary
                    class="list-none cursor-pointer
                           w-11 h-11
                           border border-gray-300
                           rounded-md
                           flex items-center justify-center
                           text-gray-700
                           hover:bg-gray-900
                           hover:text-white
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


                <div class="absolute right-0 top-14
                            w-56 bg-white
                            border border-gray-200
                            rounded-lg shadow-xl
                            p-3">

                    <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
                       class="block px-4 py-3
                              rounded-md
                              text-sm font-bold
                              text-red-600
                              hover:bg-gray-100">

                        Home

                    </a>


                    @foreach($website->categories ?? [] as $category)

                        <a href="{{ route('frontend.category', [
                            'websiteSlug' => $website->slug,
                            'categorySlug' => $category->slug
                        ]) }}"
                           class="block px-4 py-3
                                  rounded-md
                                  text-sm font-semibold
                                  text-gray-700
                                  hover:bg-gray-100">

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


                <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
                   class="relative py-4
                          text-xs font-black uppercase
                          tracking-wide
                          text-gray-500
                          hover:text-red-600
                          transition">

                    HOME

                </a>


                @foreach($news->website->categories ?? [] as $category)

                    <a href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                        'categorySlug' => $category->slug
                    ]) }}"
                       class="relative py-4
                              text-xs font-bold uppercase
                              tracking-wide
                              text-gray-500
                              hover:text-red-600
                              transition">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>

        </nav>

    </div>

</header>



{{-- ========================================================= --}}
{{-- NEWS ARTICLE --}}
{{-- ========================================================= --}}

<main class="max-w-5xl mx-auto
             px-4 sm:px-6 lg:px-8
             py-10 sm:py-14">


    {{-- BREADCRUMB --}}
                <div class="flex flex-wrap items-center
                gap-2
                text-[10px]
                uppercase
                tracking-widest
                font-bold
                text-gray-400
                mb-7">

        <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
           class="hover:text-red-600 transition">

            {{ $website->name }}

        </a>

        <span>•</span>

        @if($news->category)

            <a href="{{ route('frontend.category', [
                'websiteSlug' => $website->slug,
                'categorySlug' => $news->category->slug
            ]) }}"
               class="text-red-600 hover:text-red-700">

                {{ $news->category->name }}

            </a>

        @endif

        <span>•</span>

        <span>

            {{ optional($news->published_at)->format('d M Y, h:i A') }}

        </span>

    </div>



    {{-- TITLE --}}

    <h1 class="font-serif
               text-3xl sm:text-4xl
               lg:text-5xl
               leading-tight
               font-black
               tracking-tight
               text-gray-900">

        {{ $news->title }}

    </h1>



    {{-- META --}}

    <div class="flex flex-wrap items-center
                gap-4
                mt-5
                pb-6
                border-b border-gray-200">

        <span class="text-sm
                     font-semibold
                     text-gray-500">

            {{ $website->name }}

        </span>


        @if($news->category)

            <span class="text-gray-300">
                •
            </span>

            <span class="text-sm
                         font-semibold
                         text-red-600">

                {{ $news->category->name }}

            </span>

        @endif


        @if($news->published_at)

            <span class="text-gray-300">
                •
            </span>

            <span class="text-sm text-gray-500">

                {{ $news->published_at->diffForHumans() }}

            </span>

        @endif

    </div>



    {{-- FEATURED IMAGE --}}

    @if($news->featured_image)

        <div class="mt-8
                    rounded-2xl
                    overflow-hidden
                    bg-gray-100
                    shadow-sm">

            <img
                src="{{ asset('storage/' . $news->featured_image) }}"
                alt="{{ $news->title }}"
                class="w-full
                       max-h-[600px]
                       object-cover">

        </div>

    @endif



    {{-- ARTICLE CONTENT --}}

    <article class="mt-8
                    bg-white
                    rounded-2xl
                    border border-gray-200
                    shadow-sm
                    p-5 sm:p-8 lg:p-10">


        <div class="prose
                    prose-lg
                    max-w-none
                    text-gray-700
                    leading-8">

            {!! $news->description !!}

        </div>


    </article>



    {{-- BACK TO HOME --}}

    <div class="mt-8">

        <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
           class="inline-flex items-center gap-3
                  rounded-lg
                  bg-[#111827]
                  text-white
                  px-5 py-3
                  text-sm
                  font-bold
                  hover:bg-red-600
                  transition">

            ← Back to {{ $website->name }}

        </a>

    </div>

</main>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#0b1120]
               text-gray-300
               mt-16">


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
                            text-xl
                            font-black">

                    {{ $website->name }}

                </div>

                <div class="text-[9px]
                            uppercase
                            tracking-[0.25em]
                            text-gray-500
                            mt-1">

                    News • Ideas • Perspective

                </div>

            </div>


            <div class="text-xs text-gray-500">

                © {{ date('Y') }}
                {{ $website->name }}.
                All rights reserved.

            </div>


            <div class="text-xs text-gray-500">

                Powered by NewsHub CMS

            </div>

        </div>

    </div>

</footer>


</body>
</html>