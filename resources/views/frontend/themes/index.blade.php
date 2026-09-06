 <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Theme Store - NewsHub</title>

    <meta name="description"
          content="Choose professional free and premium themes for your news website.">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>

</head>


<body class="bg-slate-50 text-slate-900">


{{-- =====================================================
     HEADER
====================================================== --}}

<header class="sticky top-0 z-50 bg-white border-b border-slate-200">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="h-16 flex items-center justify-between">

            {{-- LOGO --}}

            <a href="{{ url('/') }}"
               class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-lg
                            bg-slate-900 text-white
                            flex items-center justify-center
                            font-black text-lg">

                    N

                </div>

                <div>

                    <div class="text-xl font-black tracking-tight">
                        NewsHub
                    </div>

                    <div class="text-[10px] uppercase
                                tracking-[0.2em]
                                text-slate-400 font-bold">

                        Theme Store

                    </div>

                </div>

            </a>


            {{-- BACK TO NEWS --}}

            <a href="{{ url('/') }}"
               class="hidden sm:inline-flex
                      items-center gap-2
                      px-4 py-2
                      rounded-lg
                      border border-slate-200
                      text-sm font-bold
                      text-slate-700
                      hover:bg-slate-900
                      hover:text-white
                      transition">

                ← Back to News

            </a>

        </div>

    </div>

</header>



{{-- =====================================================
     HERO
====================================================== --}}

<section class="relative overflow-hidden
                bg-slate-950 text-white">

    <div class="absolute inset-0">

        <div class="absolute -top-32 -right-32
                    w-96 h-96
                    rounded-full
                    bg-blue-600/20
                    blur-3xl">
        </div>

        <div class="absolute -bottom-40 -left-32
                    w-96 h-96
                    rounded-full
                    bg-purple-600/20
                    blur-3xl">
        </div>

    </div>


    <div class="relative max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8">

        <div class="py-20 sm:py-24
                    text-center">

            <span class="inline-flex items-center
                         px-4 py-2
                         rounded-full
                         bg-white/10
                         border border-white/10
                         text-xs font-bold
                         text-slate-300">

                ✨ Professional News Themes

            </span>


            <h1 class="mt-6
                       text-4xl sm:text-5xl lg:text-6xl
                       font-black
                       tracking-tight">

                Build Your News Website
                <span class="block text-blue-400">
                    Your Way
                </span>

            </h1>


            <p class="max-w-2xl mx-auto
                      mt-6
                      text-base sm:text-lg
                      leading-8
                      text-slate-400">
                Choose from professionally designed free and
                premium themes and give your news website
                a unique identity.

            </p>

        </div>

    </div>

</section>



{{-- =====================================================
     THEME STORE
====================================================== --}}

<main class="max-w-7xl mx-auto
            px-4 sm:px-6 lg:px-8">


    {{-- STORE HEADER --}}

    <div class="py-10
                flex flex-col
                md:flex-row
                md:items-end
                md:justify-between
                gap-6">

        <div>

            <p class="text-sm font-bold
                      text-blue-600 uppercase
                      tracking-wider">

                Theme Marketplace

            </p>

            <h2 class="mt-2
                       text-3xl
                       font-black
                       tracking-tight">

                Explore Themes

            </h2>

            <p class="mt-2 text-sm
                      text-slate-500">

                Select the perfect design for your news website.

            </p>

        </div>


        {{-- FILTERS --}}

        <div class="flex flex-wrap gap-2">

            <button
                onclick="filterThemes('all', this)"
                class="filter-btn
                       px-4 py-2.5
                       rounded-lg
                       bg-slate-900
                       text-white
                       text-sm
                       font-bold">

                All Themes

            </button>


            <button
                onclick="filterThemes('free', this)"
                class="filter-btn
                       px-4 py-2.5
                       rounded-lg
                       bg-white
                       border border-slate-200
                       text-slate-700
                       text-sm
                       font-bold">

                Free

            </button>


            <button
                onclick="filterThemes('premium', this)"
                class="filter-btn
                       px-4 py-2.5
                       rounded-lg
                       bg-white
                       border border-slate-200
                       text-slate-700
                       text-sm
                       font-bold">

                Premium

            </button>

        </div>

    </div>



    {{-- =================================================
         THEME CARDS
    ================================================== --}}

    @if($themes->count())

        <div id="themeGrid"
             class="grid grid-cols-1
                    sm:grid-cols-2
                    lg:grid-cols-3
                    xl:grid-cols-4
                    gap-6
                    pb-12">


            @foreach($themes as $theme)


                <div class="theme-card
                            bg-white
                            rounded-2xl
                            overflow-hidden
                            border border-slate-200
                            shadow-sm
                            hover:shadow-xl
                            hover:-translate-y-1
                            transition-all duration-300"
                     data-type="{{ $theme->type }}">


                    {{-- IMAGE --}}

                    <div class="relative
                                h-56
                                overflow-hidden
                                bg-slate-100">

                        @if($theme->preview_image)

                            <img
                                src="{{ asset('storage/' . $theme->preview_image) }}"
                                alt="{{ $theme->name }}"
                                class="w-full h-full
                                       object-cover
                                       transition duration-500
                                       hover:scale-105">

                        @else
                               <div class="w-full h-full
                                        flex items-center
                                        justify-center
                                        bg-gradient-to-br
                                        from-slate-100
                                        to-slate-200">

                                <div class="text-center">

                                    <div class="text-5xl">
                                        🎨
                                    </div>

                                    <p class="mt-2
                                              text-xs
                                              font-bold
                                              text-slate-400">

                                        No Preview Image

                                    </p>

                                </div>

                            </div>

                        @endif


                        {{-- TYPE BADGE --}}

                        <div class="absolute top-4 left-4">

                            @if($theme->type === 'premium')

                                <span class="px-3 py-1.5
                                             rounded-full
                                             bg-amber-400
                                             text-amber-950
                                             text-xs
                                             font-black
                                             shadow">

                                    💎 PREMIUM

                                </span>

                            @else

                                <span class="px-3 py-1.5
                                             rounded-full
                                             bg-emerald-500
                                             text-white
                                             text-xs
                                             font-black
                                             shadow">

                                    FREE

                                </span>

                            @endif

                        </div>

                    </div>



                    {{-- CARD CONTENT --}}

                    <div class="p-5">


                        <div class="flex
                                    items-start
                                    justify-between
                                    gap-3">

                            <div>

                                <h3 class="text-lg
                                           font-black
                                           text-slate-900">

                                    {{ $theme->name }}

                                </h3>

                                <p class="mt-1
                                          text-[11px]
                                          uppercase
                                          tracking-wider
                                          font-bold
                                          text-slate-400">

                                    News Website Theme

                                </p>

                            </div>


                            {{-- PRICE --}}

                            <div class="text-right">

                                @if($theme->type === 'premium')

                                    <div class="text-lg
                                                font-black">

                                        ₹{{ number_format($theme->price, 0) }}

                                    </div>

                                @else

                                    <div class="text-lg
                                                font-black
                                                text-emerald-600">

                                        FREE

                                    </div>

                                @endif

                            </div>

                        </div>

                        {{-- DESCRIPTION --}}

                        <p class="mt-4
                                  text-sm
                                  leading-6
                                  text-slate-500">

                            @if($theme->description)

                                {{ Str::limit($theme->description, 100) }}

                            @else

                                Clean and responsive design
                                specially created for modern
                                news websites.

                            @endif

                        </p>



                        {{-- TRIAL --}}

                        @if($theme->type === 'premium' &&
                            $theme->trial_days > 0)

                            <div class="mt-4
                                        flex items-center
                                        gap-2
                                        text-xs
                                        font-bold
                                        text-blue-600">

                                <span>⏱️</span>

                                {{ $theme->trial_days }}
                                Days Free Trial

                            </div>

                        @endif



                        {{-- ACTION BUTTONS --}}

                        <div class="mt-5
                                    flex gap-2">

                            {{-- PREVIEW --}}
                            
<a href="{{ route('frontend.themes.preview', [
    'websiteSlug' => $website->slug,
    'themeId' => $theme->id
]) }}"
   target="_blank"
   class="btn btn-outline-primary">
    Preview
</a>

                                  {{-- ACTION --}}

@if($theme->type === 'free')

    @if($website->theme_id == $theme->id)

        <button
            type="button"
            disabled
            class="flex-1
                   px-4 py-2.5
                   rounded-lg
                   bg-emerald-500
                   text-white
                   text-sm
                   font-black
                   cursor-not-allowed">

            ✓ Activated

        </button>

    @else

        <form method="POST"
              action="{{ route('frontend.themes.activate', [
                  'websiteSlug' => $websiteSlug,
                  'themeId' => $theme->id
              ]) }}"
              class="flex-1">

            @csrf

            <button
                type="submit"
                class="w-full
                       px-4 py-2.5
                       rounded-lg
                       bg-slate-900
                       text-white
                       text-sm
                       font-black
                       hover:bg-slate-800
                       transition">

                Use Theme

            </button>

        </form>

    @endif

@else


    @if($website->theme_id == $theme->id)

        <button
            type="button"
            disabled
            class="flex-1
                   px-4 py-2.5
                   rounded-lg
                   bg-emerald-500
                   text-white
                   text-sm
                   font-black
                   cursor-not-allowed">

            ✓ Active Theme

        </button>

    @else

        <a href="{{ route('frontend.themes.checkout', [
            'websiteSlug' => $websiteSlug,
            'themeId' => $theme->id,
        ]) }}"
        class="flex-1 inline-flex
               items-center justify-center
               px-4 py-2.5
               rounded-lg
               bg-blue-600
               text-white
               text-sm
               font-black
               hover:bg-blue-700
               transition">

            Get Theme

        </a>

    @endif

@endif



                        </div>

                    </div>

                </div>


            @endforeach

        </div>



        {{-- PAGINATION --}}

        <div class="pb-16">

            {{ $themes->links() }}

        </div>


    @else


        {{-- EMPTY STATE --}}

        <div class="py-24 text-center">
          <div class="text-6xl">
                🎨
            </div>

            <h2 class="mt-5
                       text-2xl
                       font-black">

                No Themes Available

            </h2>

            <p class="mt-2
                      text-sm
                      text-slate-500">

                Themes will appear here once they are added
                from the admin panel.

            </p>

        </div>


    @endif

</main>



{{-- =====================================================
     FOOTER
====================================================== --}}

<footer class="mt-10
               bg-slate-950
               text-slate-400">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-10">

        <div class="flex flex-col
                    sm:flex-row
                    items-center
                    justify-between
                    gap-4">

            <div>

                <div class="text-white
                            font-black
                            text-lg">

                    NewsHub

                </div>

                <p class="mt-1 text-xs">

                    Professional themes for modern news websites.

                </p>

            </div>


            <div class="text-xs">

                © {{ date('Y') }} NewsHub.
                All rights reserved.

            </div>

        </div>

    </div>

</footer>



{{-- =====================================================
     FILTER SCRIPT
====================================================== --}}

<script>

function filterThemes(type, clickedButton) {

    const cards =
        document.querySelectorAll('.theme-card');

    const buttons =
        document.querySelectorAll('.filter-btn');


    buttons.forEach(button => {

        button.classList.remove(
            'bg-slate-900',
            'text-white'
        );

        button.classList.add(
            'bg-white',
            'text-slate-700'
        );

    });


    clickedButton.classList.remove(
        'bg-white',
        'text-slate-700'
    );

    clickedButton.classList.add(
        'bg-slate-900',
        'text-white'
    );


    cards.forEach(card => {

        if (
            type === 'all' ||
            card.dataset.type === type
        ) {

            card.style.display = '';

        } else {

            card.style.display = 'none';

        }

    });

}

</script>


</body>
</html>