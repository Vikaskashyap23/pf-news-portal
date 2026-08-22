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

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        modern: ['Inter', 'Arial', 'sans-serif'],
                        display: ['Poppins', 'Inter', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>

</head>


<body class="bg-slate-50 text-slate-900">


{{-- ========================================================= --}}
{{-- MODERN HEADER --}}
{{-- ========================================================= --}}

<header class="sticky top-0 z-50
               bg-white/95
               backdrop-blur-xl
               border-b border-slate-200
               shadow-sm">


    {{-- TOP BAR --}}

    <div class="bg-slate-950 text-slate-300">

        <div class="max-w-7xl mx-auto
                    px-4 sm:px-6 lg:px-8
                    h-9
                    flex items-center
                    justify-between">

            <div class="flex items-center gap-2
                        text-[10px]
                        uppercase
                        tracking-widest
                        font-bold">

                <span class="w-2 h-2
                             rounded-full
                             bg-cyan-400
                             animate-pulse">
                </span>

                Live News

            </div>


            <div class="hidden sm:block
                        text-[10px]
                        text-slate-400
                        uppercase
                        tracking-wider">

                {{ now()->format('l, d F Y') }}

            </div>

        </div>

    </div>



    {{-- BRAND HEADER --}}

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-5">

        <div class="flex items-center
                    justify-between
                    gap-5">


            {{-- BRAND --}}

            <a href="{{ route('frontend.website', [
                'slug' => $website->slug
            ]) }}"
               class="flex items-center gap-3
                      group">


                <div class="w-11 h-11
                            rounded-xl
                            bg-gradient-to-br
                            from-cyan-500
                            to-blue-600
                            text-white
                            flex items-center
                            justify-center
                            shadow-lg
                            shadow-blue-500/20
                            group-hover:scale-105
                            transition">

                    <span class="font-black text-xl">
                        
                      {{ strtoupper(substr($website->name, 0, 1 )) }}
                        
                    </span>

                </div>


                <div>

                    <div class="font-display
                                text-xl sm:text-2xl
                                font-black
                                tracking-tight
                                text-slate-900">

                        {{ $website->name }}

                    </div>

                    <div class="hidden sm:block
                                text-[9px]
                                uppercase
                                tracking-[0.3em]
                                text-slate-400
                                font-bold">

                        Modern News Network

                    </div>

                </div>

            </a>



            {{-- BACK HOME --}}
                   <a href="{{ route('frontend.website', [
                'slug' => $website->slug
            ]) }}"
               class="hidden sm:inline-flex
                      items-center gap-2
                      px-4 py-2.5
                      rounded-xl
                      border border-slate-200
                      bg-white
                      text-xs
                      font-bold
                      text-slate-600
                      hover:border-cyan-500
                      hover:text-cyan-600
                      transition">

                ← Home

            </a>

        </div>

    </div>



    {{-- CATEGORY NAVIGATION --}}

    <nav class="border-t border-slate-100">

        <div class="max-w-7xl mx-auto
                    px-4 sm:px-6 lg:px-8
                    flex items-center
                    gap-6
                    overflow-x-auto
                    whitespace-nowrap">

            <a href="{{ route('frontend.website', [
                'slug' => $website->slug
            ]) }}"
               class="py-3.5
                      text-[10px]
                      uppercase
                      tracking-widest
                      font-black
                      text-cyan-600">

                Home

            </a>


            @foreach($website->categories ?? [] as $category)

                <a href="{{ route('frontend.category', [
                    'websiteSlug' => $website->slug,
                    'categorySlug' => $category->slug
                ]) }}"
                   class="py-3.5
                          text-[10px]
                          uppercase
                          tracking-widest
                          font-bold
                          text-slate-500
                          hover:text-cyan-600
                          transition">

                    {{ $category->name }}

                </a>

            @endforeach

        </div>

    </nav>

</header>



{{-- ========================================================= --}}
{{-- MAIN ARTICLE --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto
             px-4 sm:px-6 lg:px-8
             py-8 sm:py-12">


    {{-- BREADCRUMB --}}

    <div class="mb-8
                flex flex-wrap
                items-center
                gap-2
                text-[10px]
                uppercase
                tracking-widest
                font-bold
                text-slate-400">

        <a href="{{ route('frontend.website', [
            'slug' => $website->slug
        ]) }}"
           class="hover:text-cyan-600">

            Home

        </a>

        <span>
            /
        </span>

        <span class="text-cyan-600">

            {{ $news->category->name ?? 'News' }}

        </span>

    </div>



    {{-- ARTICLE GRID --}}

    <div class="grid lg:grid-cols-12
                gap-8 lg:gap-12">


        {{-- ================================================= --}}
        {{-- ARTICLE CONTENT --}}
        {{-- ================================================= --}}

        <article class="lg:col-span-8">


            {{-- CATEGORY BADGE --}}

            <div class="mb-5">

                <span class="inline-flex
                             items-center
                             gap-2
                             rounded-full
                             bg-cyan-50
                             border border-cyan-100
                             px-4 py-2
                             text-[10px]
                             uppercase
                             tracking-widest
                             font-black
                             text-cyan-700">

                    <span class="w-1.5 h-1.5
                                 rounded-full
                                 bg-cyan-500">
                    </span>

                    {{ $news->category->name ?? 'News' }}

                </span>

            </div>



            {{-- BIG MODERN HEADLINE --}}
                        <h1 class="font-display
                       text-4xl
                       sm:text-5xl
                       lg:text-6xl
                       xl:text-7xl
                       leading-[1.02]
                       font-black
                       tracking-tight
                       text-slate-950">

                {{ $news->title }}

            </h1>



            {{-- META --}}

            <div class="mt-6
                        flex flex-wrap
                        items-center
                        gap-4
                        text-[10px]
                        uppercase
                        tracking-widest
                        font-bold
                        text-slate-400">

                <span class="text-slate-700">

                    {{ $website->name }}

                </span>

                <span class="w-1 h-1
                             rounded-full
                             bg-cyan-500">
                </span>

                @if($news->published_at)

                    <span>

                        {{ $news->published_at->format('d M Y') }}

                    </span>

                    <span class="w-1 h-1
                                 rounded-full
                                 bg-cyan-500">
                    </span>

                    <span>

                        {{ $news->published_at->diffForHumans() }}

                    </span>

                @endif

            </div>



            {{-- FEATURED IMAGE --}}

            @if($news->featured_image)

                <div class="mt-8
                            relative
                            overflow-hidden
                            rounded-2xl
                            bg-slate-200
                            shadow-xl
                            shadow-slate-900/10">

                    <img
                        src="{{ asset('storage/' . $news->featured_image) }}"
                        alt="{{ $news->title }}"
                        class="w-full
                               max-h-[650px]
                               object-cover">

                    <div class="absolute
                                inset-0
                                bg-gradient-to-t
                                from-black/20
                                via-transparent
                                to-transparent
                                pointer-events-none">
                    </div>

                </div>

            @endif



            {{-- ARTICLE BODY --}}

            <div class="mt-9
                        prose
                        prose-lg
                        max-w-none
                        prose-headings:font-black
                        prose-headings:text-slate-900
                        prose-p:text-slate-700
                        prose-p:leading-8
                        prose-a:text-cyan-600
                        prose-strong:text-slate-900">

                {!! $news->description !!}

            </div>



            {{-- ARTICLE FOOTER --}}

            <div class="mt-10
                        pt-6
                        border-t border-slate-200">

                <div class="flex flex-col
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-5">


                    <div>

                        <div class="text-[9px]
                                    uppercase
                                    tracking-widest
                                    text-slate-400
                                    font-black">

                            Published By

                        </div>

                        <div class="mt-1
                                    font-bold
                                    text-slate-800">

                            {{ $website->name }}

                        </div>

                    </div>
                       <a href="{{ route('frontend.website', [
                        'slug' => $website->slug
                    ]) }}"
                       class="inline-flex
                              items-center
                              justify-center
                              gap-2
                              rounded-xl
                              bg-slate-950
                              px-5 py-3
                              text-xs
                              font-black
                              uppercase
                              tracking-wider
                              text-white
                              hover:bg-cyan-600
                              transition">

                        ← Back To News

                    </a>

                </div>

            </div>

        </article>



        {{-- ================================================= --}}
        {{-- MODERN SIDEBAR --}}
        {{-- ================================================= --}}

        <aside class="lg:col-span-4">


            {{-- STICKY SIDEBAR --}}

            <div class="lg:sticky
                        lg:top-32
                        space-y-6">


                {{-- LATEST NEWS CARD --}}

                <section class="rounded-2xl
                                bg-white
                                border border-slate-200
                                overflow-hidden
                                shadow-sm">


                    <div class="px-5 py-4
                                border-b border-slate-100
                                flex items-center
                                justify-between">

                        <div class="flex items-center gap-2">

                            <span class="w-1.5 h-6
                                         rounded-full
                                         bg-cyan-500">
                            </span>

                            <h2 class="font-display
                                       text-lg
                                       font-black">

                                Latest News

                            </h2>

                        </div>

                        <span class="text-[9px]
                                     uppercase
                                     tracking-widest
                                     text-slate-400
                                     font-bold">

                            Live

                        </span>

                    </div>



                    @php

                        $latestNews = \App\Models\News::with('category')
                            ->where('website_id', $website->id)
                            ->where('status', 'published')
                            ->where('id', '!=', $news->id)
                            ->latest('published_at')
                            ->take(5)
                            ->get();

                    @endphp


                    <div class="divide-y divide-slate-100">

                        @forelse($latestNews as $index => $item)

                            <article class="p-5
                                            group
                                            hover:bg-slate-50
                                            transition">

                                <div class="flex gap-4">


                                    <div class="flex-shrink-0">

                                        <span class="flex items-center
                                                     justify-center
                                                     w-8 h-8
                                                     rounded-lg
                                                     bg-slate-100
                                                    text-slate-500
                                                     text-[10px]
                                                     font-black
                                                     group-hover:bg-cyan-500
                                                     group-hover:text-white
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
                                                    text-cyan-600
                                                    mb-1">

                                            {{ $item->category->name ?? 'News' }}

                                        </div>


                                        <a href="{{ route('frontend.news', [
                                            'websiteSlug' => $website->slug,
                                            'newsSlug' => $item->slug
                                        ]) }}">

                                            <h3 class="font-display
                                                       text-base
                                                       font-bold
                                                       leading-snug
                                                       text-slate-800
                                                       group-hover:text-cyan-600
                                                       transition">

                                                {{ $item->title }}

                                            </h3>

                                        </a>


                                        @if($item->published_at)

                                            <div class="mt-2
                                                        text-[9px]
                                                        text-slate-400
                                                        uppercase
                                                        tracking-wider">

                                                {{ $item->published_at->diffForHumans() }}

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div class="p-6
                                        text-sm
                                        text-slate-400">

                                No latest news available.

                            </div>

                        @endforelse

                    </div>

                </section>



                {{-- MODERN CTA --}}

                <section class="relative
                                overflow-hidden
                                rounded-2xl
                                bg-gradient-to-br
                                from-slate-950
                                via-slate-900
                                to-blue-950
                                p-6
                                text-white
                                shadow-xl">
                       <div class="absolute
                                -right-10
                                -top-10
                                w-32 h-32
                                rounded-full
                                bg-cyan-500/20">
                    </div>


                    <div class="relative">

                        <div class="text-[9px]
                                    uppercase
                                    tracking-[0.25em]
                                    font-black
                                    text-cyan-400">

                            {{ $website->name }}

                        </div>


                        <h2 class="font-display
                                   text-3xl
                                   font-black
                                   leading-tight
                                   mt-3">

                            Stay informed.
                            Stay ahead.

                        </h2>


                        <p class="mt-3
                                  text-sm
                                  leading-6
                                  text-slate-400">

                            Discover the latest stories,
                            breaking updates and important
                            news from our newsroom.

                        </p>


                        <a href="{{ route('frontend.website', [
                            'slug' => $website->slug
                        ]) }}"
                           class="inline-flex
                                  mt-5
                                  items-center
                                  gap-2
                                  rounded-xl
                                  bg-cyan-500
                                  px-5 py-3
                                  text-xs
                                  font-black
                                  uppercase
                                  tracking-wider
                                  text-slate-950
                                  hover:bg-cyan-400
                                  transition">

                            Explore News →

                        </a>

                    </div>

                </section>

            </div>

        </aside>

    </div>

</main>



{{-- ========================================================= --}}
{{-- MODERN FOOTER --}}
{{-- ========================================================= --}}

<footer class="mt-12
               bg-slate-950
               text-slate-400">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-10">

        <div class="flex flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-5">

            <div>

                <div class="font-display
                            text-xl
                            font-black
                            text-white">

                    {{ $website->name }}

                </div>

                <div class="mt-1
                            text-[9px]
                            uppercase
                            tracking-[0.25em]
                            text-slate-500">

                    Modern News Network

                </div>

            </div>


            <div class="text-[10px]
                        uppercase
                        tracking-widest
                        text-slate-500">

                © {{ date('Y') }}
                {{ $website->name }}
                • All Rights Reserved

            </div>

        </div>

    </div>

</footer>


</body>
</html>