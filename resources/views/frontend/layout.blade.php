 <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', $website->name . ' - NewsHub')
    </title>

    <meta name="description"
          content="@yield('meta_description', 'Latest news and updates from ' . $website->name)">

    @yield('meta_keywords')

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


    {{-- BRAND --}}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-20 flex items-center justify-between">

            <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
               class="flex items-center gap-3 group">

                <div class="relative w-11 h-11 sm:w-12 sm:h-12
                            bg-red-600 text-white
                            flex items-center justify-center
                            rounded-md shadow-md
                            group-hover:bg-red-700
                            transition">

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


             {{-- HEADER ACTIONS --}}

<div class="flex items-center gap-2">

    {{-- ================= SEARCH ================= --}}

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

            {{-- SEARCH ICON --}}

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m21 21-4.35-4.35
                         M10.5 18a7.5 7.5 0 1 1 0-15
                         7.5 7.5 0 0 1 0 15z"/>

            </svg>

        </summary>


        {{-- SEARCH BOX --}}

        <div class="absolute right-0 top-14
                    w-[300px] sm:w-[400px]
                    bg-white
                    border border-gray-200
                    rounded-xl
                    shadow-2xl
                    p-4
                    z-[100]">

            <form
                action="{{ route('frontend.search', ['slug' => $website->slug]) }}"
                method="GET"
                class="flex gap-2">

                <input
                    type="search"
                    name="q"
                    placeholder="Search news..."
                    class="flex-1
                           h-11
                           px-4
                           rounded-lg
                           border border-gray-300
                           text-sm
                           outline-none
                           focus:border-red-600
                           focus:ring-2
                           focus:ring-red-100">

                <button
                    type="submit"
                    class="h-11
                           px-4
                           rounded-lg
                           bg-red-600
                           text-white
                           font-bold
                           text-sm
                           hover:bg-red-700
                           transition">

                    Search

                </button>

            </form>

        </div>

    </details>


    {{-- ================= THREE LINE MENU ================= --}}

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

            {{-- THREE LINE ICON --}}

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


        {{-- MENU DROPDOWN --}}

        <div class="absolute right-0 top-14
                    w-56
                    bg-white
                    border border-gray-200
                    rounded-xl
                    shadow-2xl
                    p-3
                    z-[100]">

            {{-- HOME --}}

            <a
                     href="{{ route('frontend.website', [
                    'slug' => $website->slug
                ]) }}"
                class="block px-4 py-3
                       rounded-lg
                       text-sm
                       font-bold
                       text-red-600
                       hover:bg-gray-100">

                Home

            </a>


            {{-- CATEGORIES --}}

            @foreach($categories ?? [] as $category)

                <a
                    href="{{ route('frontend.category', [
                        'websiteSlug' => $website->slug,
                        'categorySlug' => $category->slug
                    ]) }}"
                    class="block px-4 py-3
                           rounded-lg
                           text-sm
                           font-semibold
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
                        whitespace-nowrap">

                <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
                   class="relative py-4
                          text-xs font-black uppercase
                          tracking-wide
                          text-gray-500
                          hover:text-red-600">

                    HOME

                </a>


                @foreach($categories ?? [] as $category)

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


{{-- BREAKING NEWS --}}

@if(isset($breakingNews) && $breakingNews->count())

<section class="bg-[#111827] text-white border-y border-gray-800">

    <div class="max-w-7xl mx-auto flex items-stretch">

        <div class="flex-shrink-0 bg-red-600
                    px-5 sm:px-7 py-3
                    flex items-center gap-2
                    font-black text-[11px]
                    uppercase tracking-[0.15em]">

            <span class="w-2.5 h-2.5 rounded-full bg-white"></span>

            Breaking

        </div>

        <div class="flex-1 overflow-hidden">

            <div class="flex items-center gap-8
                        overflow-x-auto whitespace-nowrap
                        px-5 py-3">

                @foreach($breakingNews as $breaking)

                    <span class="text-sm font-semibold text-gray-200">

                        • {{ $breaking->title }}

                    </span>

                @endforeach

            </div>

        </div>
 </div>

</section>

@endif


{{-- PAGE CONTENT --}}

<main>

    @yield('content')

</main>


{{-- FOOTER --}}

<footer class="bg-[#0b1120] text-gray-300 mt-16">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

            <div>

                <div class="text-white text-2xl font-black">
                    {{ $website->name }}
                </div>

                <p class="text-sm text-gray-400 leading-7 mt-5">

                    Independent journalism, breaking news
                    and stories that matter.

                </p>

            </div>


            <div>

                <h3 class="text-white font-black text-sm uppercase mb-5">
                    Explore
                </h3>

                <a href="{{ route('frontend.website', ['slug' => $website->slug]) }}"
                   class="block text-gray-400 hover:text-white text-sm">

                    Home

                </a>

            </div>


            <div>

                <h3 class="text-white font-black text-sm uppercase mb-5">
                    Categories
                </h3>

                <div class="grid grid-cols-2 gap-3 text-sm">

                    @foreach(($categories ?? collect())->take(10) as $category)

                        <a href="{{ route('frontend.category', [
                            'websiteSlug' => $website->slug,
                            'categorySlug' => $category->slug
                        ]) }}"
                           class="text-gray-400 hover:text-red-500">

                            {{ $category->name }}

                        </a>

                    @endforeach

                </div>

            </div>


            

        </div>


        <div class="border-t border-white/10 mt-12 pt-6
                    text-center text-xs text-gray-500">

            © {{ date('Y') }}
            {{ $website->name }}.
            All rights reserved.

        </div>

    </div>

</footer>


{{-- SEARCH OVERLAY --}}

</body>
</html>