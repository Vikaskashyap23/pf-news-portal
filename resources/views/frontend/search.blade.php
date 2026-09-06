
@extends('frontend.layout')

@section('title')
    @if($query)
        Search: {{ $query }} - {{ $website->name }}
    @else
        Search - {{ $website->name }}
    @endif
@endsection

@section('meta_description')
    Search results for {{ $query ?: 'latest news' }} on {{ $website->name }}
@endsection

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- HEADER --}}
    <div class="mb-8">

        <h1 class="text-3xl sm:text-4xl font-black text-gray-900">
            Search News
        </h1>

        @if($query)

            <p class="mt-2 text-gray-500">

                Search results for:

                <span class="font-bold text-red-600">
                    "{{ $query }}"
                </span>

            </p>

        @else

            <p class="mt-2 text-gray-500">
                Search the latest news from {{ $website->name }}.
            </p>

        @endif

    </div>


    {{-- SEARCH FORM --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 mb-10">

        <form
            method="GET"
            action="{{ frontend_search_url() }}"
            class="space-y-5"
        >

            {{-- SEARCH INPUT --}}
            <div>

                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Search
                </label>

                <input
                    type="text"
                    name="q"
                    value="{{ $query }}"
                    placeholder="Search news..."
                    class="w-full rounded-xl border-gray-300
                           focus:border-red-500 focus:ring-red-500
                           px-4 py-3"
                >

            </div>


            {{-- FILTERS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- CATEGORY --}}
                <div>

                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Category
                    </label>

                    <select
                        name="category"
                        class="w-full rounded-xl border-gray-300
                               focus:border-red-500 focus:ring-red-500"
                    >

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->slug }}"
                                @selected($categorySlug === $category->slug)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- SORT --}}
                <div>

                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Sort
                    </label>

                    <select
                        name="sort"
                        class="w-full rounded-xl border-gray-300
                               focus:border-red-500 focus:ring-red-500"
                    >

                        <option
                            value="latest"
                            @selected($sort === 'latest')
                        >
                            Latest First
                        </option>

                        <option
                            value="oldest"
                            @selected($sort === 'oldest')
                        >
                            Oldest First
                        </option>

                    </select>

                </div>


                {{-- LANGUAGE --}}
                <div>

                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Language
                    </label>

                    <select
                        name="lang"
                        class="w-full rounded-xl border-gray-300
                               focus:border-red-500 focus:ring-red-500"
                    >

                        <option
                            value="en"
                            @selected($lang === 'en')
                        >
                            English
                        </option>

                        <option
                            value="hi"
                            @selected($lang === 'hi')
                        >
                            Hindi
                        </option>

                        <option
                            value="mr"
                            @selected($lang === 'mr')
                        >
                            Marathi
                        </option>

                    </select>

                </div>

            </div>


            {{-- VIEW --}}
            <div class="flex flex-col sm:flex-row
                        sm:items-center sm:justify-between gap-4">

                <div>

                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Result View
                    </label>

                    <select
                        name="view"
                        class="rounded-xl border-gray-300
                               focus:border-red-500 focus:ring-red-500"
                    >

                        <option
                            value="list"
                            @selected($view === 'list')
                        >
                            List View
                        </option>

                        <option
                            value="compact"
                            @selected($view === 'compact')
                        >
                            Compact View
                        </option>

                    </select>

                </div>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center
                           rounded-xl bg-red-600 px-7 py-3
                           text-sm font-bold text-white
                           hover:bg-red-700 transition"
                >
                    🔍 Search News
                </button>

            </div>

        </form>

    </div>


    {{-- ACTIVE FILTERS --}}
    @if($query || $categorySlug || $sort !== 'latest' || $lang !== ($website->language ?? 'en'))

        <div class="flex flex-wrap items-center gap-2 mb-6">

            <span class="text-sm font-bold text-gray-700">
                Active filters:
            </span>

            @if($query)

                <span class="px-3 py-1 rounded-full
                             bg-red-100 text-red-700 text-xs font-bold">
                    Search: {{ $query }}
                </span>

            @endif

            @if($categorySlug)

                <span class="px-3 py-1 rounded-full
                             bg-blue-100 text-blue-700 text-xs font-bold">
                    Category: {{ $categorySlug }}
                </span>

            @endif

            @if($sort === 'oldest')

                <span class="px-3 py-1 rounded-full
                             bg-yellow-100 text-yellow-700 text-xs font-bold">
                    Oldest First
                </span>

            @endif

            @if($lang)

                <span class="px-3 py-1 rounded-full
                             bg-green-100 text-green-700 text-xs font-bold">
                    Language: {{ strtoupper($lang) }}
                </span>

            @endif

        </div>

    @endif


    {{-- RESULTS --}}
    @if($searchResults->count())

        <div class="grid gap-6">

            @foreach($searchResults as $news)

                @if($view === 'compact')

                    {{-- COMPACT VIEW --}}

                    <article
                        class="bg-white border border-gray-200
                               rounded-xl p-5 shadow-sm
                               hover:shadow-md transition"
                    >

                        <div class="flex items-start gap-4">

                            @if($news->featured_image)

                                <img
                                    src="{{ asset('storage/' . $news->featured_image) }}"
                                    alt="{{ $news->title }}"
                                    class="w-28 h-20 object-cover
                                           rounded-lg flex-shrink-0"
                                >

                            @endif

                            <div class="min-w-0">

                                @if($news->category)

                                    <div class="text-xs font-bold uppercase
                                                tracking-wide text-red-600 mb-1">

                                        {{ $news->category->name }}

                                    </div>

                                @endif

                                <h2 class="text-lg font-black text-gray-900">

                                    {{ $news->title }}

                                </h2>

                                @if($news->published_at)

                                    <div class="text-xs text-gray-400 mt-2">

                                        {{ $news->published_at->format('d M Y, h:i A') }}

                                    </div>

                                @endif

                                <a
                                    href="{{ frontend_news_url($news->slug) }}"
                                    class="inline-block mt-3
                                           text-sm font-bold text-red-600
                                           hover:text-red-700"
                                >
                                    Read More →
                                </a>

                            </div>

                        </div>

                    </article>

                @else

                    {{-- LIST VIEW --}}

                    <article
                        class="bg-white border border-gray-200
                               rounded-xl overflow-hidden shadow-sm
                               hover:shadow-md transition"
                    >

                        <div class="flex flex-col sm:flex-row">

                            @if($news->featured_image)

                                <div class="sm:w-64 h-48 sm:h-auto flex-shrink-0">

                                    <img
                                        src="{{ asset('storage/' . $news->featured_image) }}"
                                        alt="{{ $news->title }}"
                                        class="w-full h-full object-cover"
                                    >

                                </div>

                            @endif


                            <div class="p-5">

                                @if($news->category)

                                    <div class="text-xs font-bold uppercase
                                                tracking-wide text-red-600 mb-2">

                                        {{ $news->category->name }}

                                    </div>

                                @endif


                                <h2 class="text-xl font-black text-gray-900">

                                    {{ $news->title }}

                                </h2>


                                @if($news->published_at)

                                    <div class="text-xs text-gray-400 mt-2">

                                        {{ $news->published_at->format('d M Y, h:i A') }}

                                    </div>

                                @endif


                                <p class="text-sm text-gray-600 mt-3 leading-6">

                                    {{ \Illuminate\Support\Str::limit(
                                        strip_tags($news->description),
                                        180
                                    ) }}

                                </p>


                                <a
                                    href="{{ frontend_news_url($news->slug) }}"
                                    class="inline-block mt-4
                                           text-sm font-bold text-red-600
                                           hover:text-red-700"
                                >
                                    Read More →
                                </a>

                            </div>

                        </div>

                    </article>

                @endif

            @endforeach

        </div>


        {{-- PAGINATION --}}

        <div class="mt-10">

            {{ $searchResults->links() }}

        </div>


    @else

        {{-- NO RESULTS --}}

        <div
            class="bg-white border border-gray-200
                   rounded-xl p-10 text-center"
        >

            <div class="text-4xl mb-4">
                🔍
            </div>

            <h2 class="text-xl font-black text-gray-900">
                No News Found
            </h2>

            <p class="text-gray-500 mt-2">
                We couldn't find any news matching
                "{{ $query }}".
            </p>

        </div>

    @endif

</div>

@endsection

