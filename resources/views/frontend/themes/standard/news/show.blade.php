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
                        sans: ['Inter', 'Arial', 'sans-serif'],
                        serif: ['Georgia', 'Times New Roman', 'serif'],
                    }
                }
            }
        }
    </script>

</head>


<body class="bg-gray-50 text-gray-900">


{{-- ========================================================= --}}
{{-- STANDARD NEWS HEADER --}}
{{-- ========================================================= --}}

<header class="sticky top-0 z-50
               bg-white
               border-b border-gray-200
               shadow-sm">


    {{-- TOP BAR --}}

    <div class="bg-gray-900 text-gray-300">

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
                             bg-red-500">
                </span>

                Latest News & Updates

            </div>


            <div class="hidden sm:block
                        text-[10px]
                        text-gray-400">

                {{ now()->format('l, d F Y') }}

            </div>

        </div>

    </div>



    {{-- BRAND HEADER --}}

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-5">

        <div class="flex items-center
                    justify-between">


            {{-- BRAND --}}

            <a href="{{ route('frontend.website', [
                'slug' => $website->slug
            ]) }}"
               class="flex items-center gap-3
                      group">


                <div class="w-11 h-11
                            rounded-lg
                            bg-red-600
                            text-white
                            flex items-center
                            justify-center
                            shadow-md
                            group-hover:bg-red-700
                            transition">

                    <span class="text-xl font-black">
                        
                      {{ strtoupper(substr($website->name, 0, 1 )) }}
                        
                    </span>

                </div>


                <div>

                    <div class="text-2xl
                                sm:text-3xl
                                font-black
                                tracking-tight
                                text-gray-900
                                group-hover:text-red-600
                                transition">

                        {{ $website->name }}

                    </div>

                    <div class="hidden sm:block
                                text-[9px]
                                uppercase
                                tracking-[0.3em]
                                text-gray-500
                                font-bold">

                        News • Ideas • Perspective

                    </div>

                </div>

            </a>



            {{-- HOME BUTTON --}}

            <a href="{{ route('frontend.website', [
                  'slug' => $website->slug
            ]) }}"
               class="hidden sm:inline-flex
                      items-center gap-2
                      border border-gray-300
                      rounded-lg
                      px-4 py-2.5
                      text-xs
                      font-bold
                      text-gray-700
                      hover:bg-gray-900
                      hover:text-white
                      hover:border-gray-900
                      transition">

                ← Home

            </a>

        </div>

    </div>



    {{-- CATEGORY NAVIGATION --}}

    <nav class="border-t border-gray-100">

        <div class="max-w-7xl mx-auto
                    px-4 sm:px-6 lg:px-8
                    flex items-center
                    gap-7
                    overflow-x-auto
                    whitespace-nowrap">

            <a href="{{ route('frontend.website', [
                'slug' => $website->slug
            ]) }}"
               class="py-4
                      text-xs
                      uppercase
                      tracking-wide
                      font-black
                      text-red-600">

                Home

            </a>


            @foreach($website->categories ?? [] as $category)

                <a href="{{ route('frontend.category', [
                    'websiteSlug' => $website->slug,
                    'categorySlug' => $category->slug
                ]) }}"
                   class="py-4
                          text-xs
                          uppercase
                          tracking-wide
                          font-bold
                          text-gray-500
                          hover:text-red-600
                          transition">

                    {{ $category->name }}

                </a>

            @endforeach

        </div>

    </nav>

</header>



{{-- ========================================================= --}}
{{-- MAIN CONTENT --}}
{{-- ========================================================= --}}

<main class="max-w-7xl mx-auto
             px-4 sm:px-6 lg:px-8
             py-8 sm:py-12">


    {{-- BREADCRUMB --}}

    <div class="mb-7
                flex flex-wrap
                items-center
                gap-2
                text-xs
                text-gray-500">

        <a href="{{ route('frontend.website', [
            'slug' => $website->slug
        ]) }}"
           class="hover:text-red-600">

            Home

        </a>

        <span>
            /
        </span>

        <span class="text-red-600 font-semibold">

            {{ $news->category->name ?? 'News' }}

        </span>

    </div>



    {{-- ARTICLE GRID --}}

    <div class="grid lg:grid-cols-12
                gap-8 lg:gap-10">


        {{-- ================================================= --}}
        {{-- ARTICLE --}}
        {{-- ================================================= --}}

        <article class="lg:col-span-8
                        bg-white
                        border border-gray-200
                        rounded-xl
                        overflow-hidden
                        shadow-sm">


            {{-- ARTICLE HEADER --}}

            <div class="p-5 sm:p-8">


                {{-- CATEGORY --}}

                <div class="mb-4">

                    <span class="inline-flex
                                 items-center
                                 gap-2
                                 bg-red-50
                                 border border-red-100
                                 text-red-600
                                 px-3 py-1.5
                                 rounded-md
                                 text-[10px]
                                 uppercase
                                 tracking-wider
                                 font-black">

                        {{ $news->category->name ?? 'News' }}

                    </span>

                </div>



                {{-- HEADLINE --}}
                           <h1 class="font-serif
                           text-3xl
                           sm:text-4xl
                           lg:text-5xl
                           leading-tight
                           font-bold
                           text-gray-900">

                    {{ $news->title }}

                </h1>



                {{-- META --}}

                <div class="mt-5
                            flex flex-wrap
                            items-center
                            gap-3
                            text-xs
                            text-gray-500">

                    <span class="font-semibold
                                 text-gray-700">

                        {{ $website->name }}

                    </span>

                    <span>
                        •
                    </span>

                    @if($news->published_at)

                        <span>

                            {{ $news->published_at->format('d M Y') }}

                        </span>

                        <span>
                            •
                        </span>

                        <span>

                            {{ $news->published_at->diffForHumans() }}

                        </span>

                    @endif

                </div>

            </div>



            {{-- FEATURED IMAGE --}}

            @if($news->featured_image)

                <div class="px-5 sm:px-8">

                    <div class="overflow-hidden
                                rounded-lg
                                bg-gray-100">

                        <img
                            src="{{ asset('storage/' . $news->featured_image) }}"
                            alt="{{ $news->title }}"
                            class="w-full
                                   max-h-[600px]
                                   object-cover">

                    </div>

                </div>

            @endif



            {{-- ARTICLE BODY --}}

            <div class="p-5 sm:p-8">


                <div class="prose
                            prose-lg
                            max-w-none
                            prose-headings:text-gray-900
                            prose-headings:font-bold
                            prose-p:text-gray-700
                            prose-p:leading-8
                            prose-a:text-red-600
                            prose-strong:text-gray-900">

                    {!! $news->description !!}

                </div>



                {{-- ARTICLE FOOTER --}}

                <div class="mt-10
                            pt-6
                            border-t border-gray-200
                            flex flex-col
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-4">


                    <div>

                        <div class="text-[9px]
                                    uppercase
                                    tracking-widest
                                    text-gray-400
                                    font-bold">

                            Published By

                        </div>

                        <div class="mt-1
                                    font-semibold
                                    text-gray-800">

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
                              rounded-lg
                              bg-red-600
                              text-white
                              px-5 py-3
                              text-xs
                              font-bold
                              uppercase
                              tracking-wider
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


            <div class="lg:sticky
                        lg:top-32
                        space-y-6">


                {{-- LATEST NEWS --}}

                <section class="bg-white
                                border border-gray-200
                                rounded-xl
                                overflow-hidden
                                shadow-sm">


                    <div class="px-5 py-4
                                bg-gray-900
                                text-white
                                flex items-center
                                justify-between">

                        <div class="flex items-center gap-3">

                            <span class="w-1.5 h-6
                                         bg-red-600">
                            </span>

                            <h2 class="text-sm
                                       font-black
                                       uppercase
                                       tracking-wider">

                                Latest News

                            </h2>

                        </div>


                        <span class="text-[9px]
                                     uppercase
                                     tracking-widest
                                     text-gray-400">

                            Today

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



                    <div class="divide-y divide-gray-100">


                        @forelse($latestNews as $index => $item)

                            <article class="p-5
                                            group
                                            hover:bg-gray-50
                                            transition">


                                <div class="flex gap-4">


                                    {{-- NUMBER --}}

                                    <div class="flex-shrink-0">

                                        <span class="flex items-center
                                                     justify-center
                                                     w-8 h-8
                                                     rounded-full
                                                     bg-gray-100
                                                     text-gray-500
                                                     text-[10px]
                                                     font-black
                                                     group-hover:bg-red-600
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



                                    {{-- CONTENT --}}

                                    <div class="min-w-0">

                                        <div class="text-[9px]
                                                    uppercase
                                                    tracking-widest
                                                    font-black
                                                    text-red-600
                                                    mb-1">

                                            {{ $item->category->name ?? 'News' }}

                                        </div>


                                        <a href="{{ route('frontend.news', [
                                            'websiteSlug' => $website->slug,
                                            'newsSlug' => $item->slug
                                        ]) }}">

                                            <h3 class="font-serif
                                                       text-lg
                                                       font-bold
                                                       leading-snug
                                                       text-gray-900
                                                       group-hover:text-red-600
                                                       transition">

                                                {{ $item->title }}

                                            </h3>

                                        </a>


                                        @if($item->published_at)

                                            <div class="mt-2
                                                        text-[10px]
                                                        text-gray-400">

                                                {{ $item->published_at->diffForHumans() }}

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div class="p-6
                                        text-sm
                                        text-gray-400">

                                No latest news available.

                            </div>

                        @endforelse

                    </div>

                </section>



                {{-- NEWSLETTER / CTA --}}

                <section class="rounded-xl
                                bg-gray-900
                                text-white
                                p-6
                                shadow-lg">

                    <div class="text-[9px]
                                uppercase
                                tracking-[0.25em]
                                text-red-400
                                font-black">

                        {{ $website->name }}

                    </div>


                    <h2 class="text-2xl
                               sm:text-3xl
                               font-black
                               leading-tight
                               mt-3">

                        Stay informed.

                    </h2>


                    <p class="text-sm
                              text-gray-400
                              leading-6
                              mt-3">

                        Read the latest breaking news,
                        stories and updates from our
                        newsroom.

                    </p>
                       <a href="{{ route('frontend.website', [
                        'slug' => $website->slug
                    ]) }}"
                       class="inline-flex
                              mt-5
                              items-center
                              gap-2
                              rounded-lg
                              bg-red-600
                              px-5 py-3
                              text-xs
                              font-black
                              uppercase
                              tracking-wider
                              hover:bg-red-700
                              transition">

                        Explore News →

                    </a>

                </section>

            </div>

        </aside>

    </div>

</main>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="mt-12
               bg-gray-900
               text-gray-400">


    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-10">


        <div class="flex flex-col
                    md:flex-row
                    items-center
                    justify-between
                    gap-4">


            <div>

                <div class="text-xl
                            font-black
                            text-white">

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