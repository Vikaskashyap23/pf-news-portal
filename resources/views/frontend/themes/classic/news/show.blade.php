 <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        {{ $news->title }} | {{ $website->name }}
    </title>

    <meta name="description"
          content="{{ \Illuminate\Support\Str::limit(strip_tags($news->description), 160) }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Arial', 'sans-serif'],
                        serif: ['Georgia', 'Times New Roman', 'serif'],
                    }
                }
            }
        }
    </script>

</head>


<body class="bg-[#f4f1eb] text-[#171717]">


{{-- ========================================================= --}}
{{-- TOP BLACK UTILITY BAR --}}
{{-- ========================================================= --}}

<div class="bg-[#111111] text-gray-300">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                h-10
                flex items-center
                justify-between">

        <div class="flex items-center gap-2
                    text-[10px]
                    uppercase
                    tracking-[0.22em]
                    font-bold">

            <span class="w-2 h-2
                         rounded-full
                         bg-[#a71930]">
            </span>

            Independent • Fast • Trusted News

        </div>

        <div class="hidden sm:block
                    text-[10px]
                    uppercase
                    tracking-widest
                    text-gray-500">

            {{ now()->format('l, d F Y') }}

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- PREMIUM CLASSIC HEADER --}}
{{-- ========================================================= --}}

<header class="sticky top-0 z-50
               bg-[#f8f5ef]/95
               backdrop-blur-md
               border-b border-[#d4cec3]
               shadow-sm">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8">


        {{-- BRAND ROW --}}

        <div class="min-h-[92px]
                    flex items-center
                    justify-between
                    gap-5">


            {{-- BRAND --}}

            <a href="{{ route('frontend.website', [
                    'slug' => $website->slug
                ]) }}"
               class="flex items-center gap-4
                      group
                      min-w-0">


                {{-- CLASSIC LOGO --}}

                <div class="relative
                            w-12 h-12
                            sm:w-14 sm:h-14
                            flex-shrink-0
                            bg-[#a71930]
                            text-white
                            flex items-center
                            justify-center
                            shadow-md
                            group-hover:bg-[#8d1428]
                            transition">

                    <span class="font-serif
                                 text-2xl sm:text-3xl
                                 font-black">

                        {{ strtoupper(substr($website->name, 0, 1)) }}

                    </span>

                </div>


                {{-- WEBSITE NAME --}}

                <div class="min-w-0">

                    <div class="font-serif
                                text-2xl sm:text-3xl lg:text-4xl
                                font-black
                                tracking-tight
                                text-[#171717]
                                truncate">

                        {{ $website->name }}

                    </div>
                         <div class="hidden sm:block
                                mt-1
                                text-[9px]
                                uppercase
                                tracking-[0.35em]
                                font-bold
                                text-gray-500">

                        News • Ideas • Perspective

                    </div>

                </div>

            </a>


            {{-- HEADER RIGHT --}}

            <div class="flex items-center gap-3">

                <a href="{{ route('frontend.website', [
                        'slug' => $website->slug
                    ]) }}"
                   class="hidden sm:flex
                          items-center
                          gap-2
                          border border-[#bcb5a9]
                          px-4 py-2.5
                          text-[10px]
                          uppercase
                          tracking-widest
                          font-black
                          text-[#292524]
                          hover:bg-[#a71930]
                          hover:border-[#a71930]
                          hover:text-white
                          transition">

                    ← Home

                </a>

                <span class="hidden md:block
                             w-px h-7
                             bg-[#d0c9be]">
                </span>

                <span class="hidden md:block
                             text-[9px]
                             uppercase
                             tracking-widest
                             font-bold
                             text-gray-400">

                    News Desk

                </span>

            </div>

        </div>


        {{-- CATEGORY NAVIGATION --}}

        <nav class="border-t border-[#ded8ce]">

            <div class="flex items-center
                        gap-7
                        overflow-x-auto
                        whitespace-nowrap
                        scrollbar-hide">


                <a href="{{ route('frontend.website', [
                        'slug' => $website->slug
                    ]) }}"
                   class="relative
                          py-4
                          text-[10px]
                          uppercase
                          tracking-[0.16em]
                          font-black
                          text-[#a71930]">

                    Home

                    <span class="absolute
                                 left-0 right-0
                                 bottom-0
                                 h-0.5
                                 bg-[#a71930]">
                    </span>

                </a>


                @php

                    $categories = \App\Models\Category::where(
                        'website_id',
                        $website->id
                    )
                    ->where('status', true)
                    ->latest()
                    ->get();

                @endphp


                @foreach($categories as $category)

                    <a href="{{ route('frontend.category', [
                            'websiteSlug' => $website->slug,
                            'categorySlug' => $category->slug
                        ]) }}"
                       class="py-4
                              text-[10px]
                              uppercase
                              tracking-[0.16em]
                              font-bold
                              text-gray-500
                              hover:text-[#a71930]
                              transition">

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>

        </nav>

    </div>

</header>


{{-- ========================================================= --}}
{{-- BREAKING NEWS STRIP --}}
{{-- ========================================================= --}}

@php

 $breakingNews = \App\Models\News::where(
        'website_id',
        $website->id
    )
    ->where('status', 'published')
    ->where('is_breaking', true)
    ->where('id', '!=', $news->id)
    ->where(function ($query) {

        $query->whereNull('published_at')
              ->orWhere('published_at', '<=', now());

    })
    ->latest('published_at')
    ->take(5)
    ->get();

@endphp


@if($breakingNews->count())

<section class="bg-[#191919]
                text-white
                border-b border-black">

    <div class="max-w-7xl mx-auto
                flex items-stretch">

        <div class="flex-shrink-0
                    bg-[#a71930]
                    px-5
                    py-3
                    flex items-center
                    gap-2
                    text-[10px]
                    uppercase
                    tracking-[0.16em]
                    font-black">

            <span class="w-2 h-2
                         rounded-full
                         bg-white
                         animate-pulse">
            </span>

            Breaking

        </div>


        <div class="flex-1
                    overflow-x-auto
                    whitespace-nowrap">

            <div class="flex items-center
                        gap-8
                        px-5 py-3">

                @foreach($breakingNews as $breaking)

                    <a href="{{ route('frontend.news', [
                            'websiteSlug' => $website->slug,
                            'newsSlug' => $breaking->slug
                        ]) }}"
                       class="text-sm
                              font-semibold
                              text-gray-300
                              hover:text-white
                              transition">

                        {{ $breaking->title }}

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endif


{{-- ========================================================= --}}
{{-- MAIN ARTICLE AREA --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto
             px-4 sm:px-6 lg:px-8
             py-10 sm:py-14">


    {{-- BREADCRUMB --}}

    <div class="flex items-center
                gap-2
                text-[9px]
                uppercase
                tracking-[0.18em]
                font-bold
                text-gray-400
                mb-8">

        <a href="{{ route('frontend.website', [
                'slug' => $website->slug
            ]) }}"
           class="hover:text-[#a71930]">

            Home

        </a>

        <span>/</span>

        <span class="text-[#a71930]">

            {{ $news->category->name ?? 'News' }}

        </span>

        <span>/</span>

        <span class="text-gray-500">

            Story

        </span>

    </div>


    <div class="grid
                lg:grid-cols-12
                gap-10
                lg:gap-12">


        {{-- ================================================= --}}
        {{-- MAIN STORY --}}
        {{-- ================================================= --}}

        <article class="lg:col-span-8">


            {{-- CATEGORY LABEL --}}

            <div class="flex items-center gap-3 mb-5">

                <span class="w-10 h-1
                             bg-[#a71930]">
                </span>

                <span class="text-[10px]
                             uppercase
                             tracking-[0.22em]
                             font-black
                             text-[#a71930]">

                    {{ $news->category->name ?? 'News' }}

                </span>

            </div>


            {{-- BIG CLASSIC HEADLINE --}}

            <h1 class="font-serif
                       text-4xl
                       sm:text-5xl
                       lg:text-[62px]
                       leading-[0.98]
                       font-black
                       tracking-[-0.025em]
                       text-[#171717]">
              {{ $news->title }}

            </h1>


            {{-- SHORT INTRO --}}

            @if($news->description)

                <p class="mt-7
                          font-serif
                          text-lg
                          sm:text-xl
                          leading-8
                          text-gray-600
                          max-w-3xl">

                    {{ \Illuminate\Support\Str::limit(
                        strip_tags($news->description),
                        260
                    ) }}

                </p>

            @endif


            {{-- META ROW --}}

            <div class="mt-7
                        py-4
                        border-y
                        border-[#d5cec3]
                        flex flex-wrap
                        items-center
                        justify-between
                        gap-4">


                <div class="flex items-center
                            gap-3">

                    <div class="w-9 h-9
                                bg-[#171717]
                                text-white
                                flex items-center
                                justify-center
                                font-serif
                                font-bold">

                        {{ strtoupper(substr($website->name, 0, 1)) }}

                    </div>


                    <div>

                        <div class="text-[10px]
                                    uppercase
                                    tracking-widest
                                    font-black">

                            {{ $website->name }}

                        </div>

                        <div class="text-[10px]
                                    text-gray-500
                                    mt-1">

                            News Desk

                        </div>

                    </div>

                </div>


                <div class="text-right
                            text-[10px]
                            uppercase
                            tracking-widest
                            text-gray-500">

                    <div>

                        {{ optional($news->published_at)->format('d F Y') }}

                    </div>

                    @if($news->published_at)

                        <div class="mt-1">

                            {{ $news->published_at->diffForHumans() }}

                        </div>

                    @endif

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- HERO IMAGE --}}
            {{-- ================================================= --}}

            @if($news->featured_image)

                <figure class="mt-9">

                    <div class="relative
                                overflow-hidden
                                bg-gray-200
                                shadow-lg">

                        <img
                            src="{{ asset('storage/' . $news->featured_image) }}"
                            alt="{{ $news->title }}"
                            class="w-full
                                   aspect-[16/9]
                                   object-cover">

                        <div class="absolute
                                    left-0
                                    bottom-0
                                    w-full
                                    h-24
                                    bg-gradient-to-t
                                    from-black/30
                                    to-transparent">
                        </div>

                    </div>

                    <figcaption class="mt-2
                                        text-[9px]
                                        uppercase
                                        tracking-widest
                                        text-gray-400">

                        {{ $website->name }} • Special Report
                </figcaption>

                </figure>

            @endif


            {{-- ================================================= --}}
            {{-- SHARE BAR --}}
            {{-- ================================================= --}}

            <div class="mt-7
                        flex flex-wrap
                        items-center
                        gap-2">

                <span class="mr-2
                             text-[9px]
                             uppercase
                             tracking-[0.2em]
                             font-black
                             text-gray-500">

                    Share Story

                </span>


                <button
                    type="button"
                    onclick="copyArticleLink()"
                    class="px-4 py-2
                           border border-[#c8c0b5]
                           bg-[#f8f5ef]
                           text-[9px]
                           uppercase
                           tracking-widest
                           font-bold
                           hover:bg-[#171717]
                           hover:text-white
                           transition">

                    Copy Link

                </button>


                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="px-4 py-2
                          bg-[#171717]
                          text-white
                          text-[9px]
                          uppercase
                          tracking-widest
                          font-bold
                          hover:bg-[#a71930]
                          transition">

                    Facebook

                </a>


                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="px-4 py-2
                          bg-[#171717]
                          text-white
                          text-[9px]
                          uppercase
                          tracking-widest
                          font-bold
                          hover:bg-[#a71930]
                          transition">

                    X

                </a>

            </div>


            {{-- ================================================= --}}
            {{-- ARTICLE BODY --}}
            {{-- ================================================= --}}

            <div class="mt-10
                        font-serif
                        text-lg
                        sm:text-xl
                        leading-[1.9]
                        text-[#292524]">


                @if($news->description)

                    <div class="mb-7
                                first-letter:text-5xl
                                first-letter:font-bold
                                first-letter:text-[#a71930]
                                first-letter:mr-1">

                        {!! $news->description !!}

                    </div>

                @endif


                @if(isset($news->content) && $news->content)

                    <div class="prose
                                prose-lg
                                max-w-none
                                prose-headings:font-serif
                                prose-headings:font-black
                                prose-headings:text-[#171717]
                                prose-p:leading-8
                                prose-p:text-[#292524]
                                prose-a:text-[#a71930]
                                prose-strong:text-[#171717]">

                        {!! $news->content !!}

                    </div>

                @endif

            </div>
                  {{-- ================================================= --}}
            {{-- ARTICLE END --}}
            {{-- ================================================= --}}

            <div class="mt-12
                        pt-6
                        border-t
                        border-[#d5cec3]
                        flex items-center
                        justify-between">

                <span class="text-[9px]
                             uppercase
                             tracking-[0.2em]
                             font-black
                             text-gray-400">

                    End of Story

                </span>

                <span class="text-[#a71930]
                             font-serif
                             text-xl">

                    ◆

                </span>

            </div>


        </article>


        {{-- ================================================= --}}
        {{-- CLASSIC SIDEBAR --}}
        {{-- ================================================= --}}

        <aside class="lg:col-span-4">

            <div class="lg:sticky
                        lg:top-28
                        space-y-7">


                {{-- LATEST STORIES --}}

                <section class="bg-[#f8f5ef]
                                border
                                border-[#d5cec3]
                                shadow-sm">


                    <div class="px-5 py-5
                                border-b
                                border-[#d5cec3]
                                flex items-center
                                gap-3">

                        <span class="w-1.5 h-7
                                     bg-[#a71930]">
                        </span>

                        <div>

                            <div class="text-[9px]
                                        uppercase
                                        tracking-[0.2em]
                                        font-black
                                        text-[#a71930]">

                                News Desk

                            </div>

                            <h2 class="font-serif
                                       text-2xl
                                       font-black">

                                Latest Stories

                            </h2>

                        </div>

                    </div>


                    @php

                        $sidebarNews = \App\Models\News::with('category')
                            ->where('website_id', $website->id)
                            ->where('status', 'published')
                            ->where('id', '!=', $news->id)
                            ->where(function ($query) {

                                $query->whereNull('published_at')
                                      ->orWhere('published_at', '<=', now());

                            })
                            ->latest('published_at')
                            ->take(6)
                            ->get();

                    @endphp


                    <div class="divide-y
                                divide-[#ddd6ca]">


                        @forelse($sidebarNews as $index => $item)

                            <a href="{{ route('frontend.news', [
                                    'websiteSlug' => $website->slug,
                                    'newsSlug' => $item->slug
                                ]) }}"
                               class="block p-5
                                      group
                                      hover:bg-[#ebe7df]
                                      transition">


                                <div class="flex gap-4">


                                    <div class="flex-shrink-0">
                             <span class="font-serif
                                                     text-3xl
                                                     font-black
                                                     text-[#d2cbc0]
                                                     group-hover:text-[#a71930]
                                                     transition">

                                            {{ str_pad(
                                                $index + 1,
                                                2,
                                                '0',
                                                STR_PAD_LEFT
                                            ) }}

                                        </span>

                                    </div>


                                    <div class="min-w-0">


                                        <div class="text-[9px]
                                                    uppercase
                                                    tracking-widest
                                                    font-black
                                                    text-[#a71930]
                                                    mb-1">

                                            {{ $item->category->name ?? 'News' }}

                                        </div>


                                        <h3 class="font-serif
                                                   text-base
                                                   font-bold
                                                   leading-snug
                                                   text-[#292524]
                                                   group-hover:text-[#a71930]
                                                   transition">

                                            {{ $item->title }}

                                        </h3>


                                        <div class="mt-2
                                                    text-[9px]
                                                    uppercase
                                                    tracking-widest
                                                    text-gray-400">

                                            {{ optional($item->published_at)->diffForHumans() }}

                                        </div>

                                    </div>

                                </div>

                            </a>

                        @empty

                            <div class="p-6
                                        text-sm
                                        text-gray-500">

                                No latest stories available.

                            </div>

                        @endforelse

                    </div>

                </section>


                {{-- CLASSIC NEWSLETTER --}}

                <section class="relative
                                overflow-hidden
                                bg-[#171717]
                                text-white
                                p-7">


                    <div class="absolute
                                -right-10
                                -top-10
                                w-32 h-32
                                rounded-full
                                border-[18px]
                                border-[#a71930]/20">
                    </div>


                    <div class="relative">


                        <div class="text-[9px]
                                    uppercase
                                    tracking-[0.25em]
                                    font-black
                                    text-[#d9a3aa]">

                            The Daily Brief

                        </div>
                     <h2 class="font-serif
                                   text-3xl
                                   font-black
                                   leading-tight
                                   mt-3">

                            News that
                            matters.

                        </h2>


                        <p class="text-sm
                                  text-gray-400
                                  leading-6
                                  mt-3">

                            Stay informed with the
                            latest headlines and
                            important stories.

                        </p>


                        <input
                            type="email"
                            placeholder="Enter your email"
                            class="mt-5
                                   w-full
                                   px-4 py-3
                                   bg-white
                                   text-gray-900
                                   text-sm
                                   outline-none">


                        <button
                            type="button"
                            class="mt-2
                                   w-full
                                   bg-[#a71930]
                                   py-3
                                   text-white
                                   text-[10px]
                                   uppercase
                                   tracking-widest
                                   font-black
                                   hover:bg-[#8d1428]
                                   transition">

                            Subscribe →

                        </button>


                    </div>

                </section>


            </div>

        </aside>

    </div>

</main>


{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="bg-[#111111]
               text-gray-400
               mt-12">


    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-12">


        <div class="grid
                    md:grid-cols-3
                    gap-10">


            <div>

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11
                                bg-[#a71930]
                                text-white
                                flex items-center
                                justify-center
                                font-serif
                                text-xl
                                font-black">

                        {{ strtoupper(substr($website->name, 0, 1)) }}

                    </div>


                    <div>

                        <div class="font-serif
                                    text-xl
                                    font-black
                                    text-white">

                            {{ $website->name }}

                        </div>

                        <div class="text-[8px]
                                    uppercase
                                    tracking-[0.25em]
                                    text-gray-600">

                            News • Ideas • Perspective

                        </div>

                    </div>

                </div>


                <p class="mt-5
                          text-sm
                          leading-7
                          text-gray-500">

                    Independent journalism,
                    trusted reporting and
                    stories that matter.

                </p>

            </div>


            <div>

                <h3 class="text-white
                           text-[10px]
                           uppercase
                           tracking-[0.2em]
                           font-black
                           mb-5">
                            Explore

                </h3>


                <div class="space-y-3 text-sm">

                    <a href="{{ route('frontend.website', [
                            'slug' => $website->slug
                        ]) }}"
                       class="block hover:text-white">

                        Home

                    </a>


                    @foreach($categories->take(6) as $category)

                        <a href="{{ route('frontend.category', [
                                'websiteSlug' => $website->slug,
                                'categorySlug' => $category->slug
                            ]) }}"
                           class="block hover:text-white">

                            {{ $category->name }}

                        </a>

                    @endforeach

                </div>

            </div>


            <div>

                <h3 class="text-white
                           text-[10px]
                           uppercase
                           tracking-[0.2em]
                           font-black
                           mb-5">

                    Publication

                </h3>

                <p class="text-sm
                          leading-7
                          text-gray-500">

                    {{ $website->name }}

                    <br>

                    Digital News Publication

                </p>

            </div>

        </div>


        <div class="border-t
                    border-white/10
                    mt-10
                    pt-5
                    flex flex-col
                    sm:flex-row
                    justify-between
                    gap-3
                    text-[10px]
                    text-gray-600
                    uppercase
                    tracking-wider">

            <span>

                © {{ date('Y') }}
                {{ $website->name }}.
                All Rights Reserved.

            </span>

            <span>

                Powered by NewsHub CMS

            </span>

        </div>

    </div>

</footer>


<script>

function copyArticleLink() {

    if (navigator.clipboard) {

        navigator.clipboard.writeText(
            window.location.href
        ).then(function () {

            alert('Article link copied!');

        });

    }

}

</script>


</body>

</html>