@extends('frontend.layout')

@section('title')
    Search: {{ $query }} - {{ $website->name }}
@endsection

@section('meta_description')
    Search results for {{ $query }} on {{ $website->name }}
@endsection

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">

        <h1 class="text-3xl sm:text-4xl font-black text-gray-900">
            Search Results
        </h1>

        @if($query)
            <p class="mt-2 text-gray-500">
                Search results for:
                <span class="font-bold text-red-600">
                    "{{ $query }}"
                </span>
            </p>
        @endif

    </div>


    @if($searchResults->count())

        <div class="grid gap-6">

            @foreach($searchResults as $news)

                <article class="bg-white border border-gray-200 rounded-xl
                                overflow-hidden shadow-sm hover:shadow-md transition">

                    <div class="flex flex-col sm:flex-row">

                        @if($news->featured_image)

                            <div class="sm:w-64 h-48 sm:h-auto flex-shrink-0">

                                <img
                                    src="{{ asset('storage/' . $news->featured_image) }}"
                                    alt="{{ $news->title }}"
                                    class="w-full h-full object-cover">

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
                                href="{{ route('frontend.news', [
                                    'websiteSlug' => $website->slug,
                                    'newsSlug' => $news->slug
                                ]) }}"
                                class="inline-block mt-4
                                       text-sm font-bold
                                       text-red-600
                                       hover:text-red-700">

                                Read More →

                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>


        {{-- PAGINATION --}}

        <div class="mt-10">

            {{ $searchResults->links() }}

        </div>

    @else

        <div class="bg-white border border-gray-200
                    rounded-xl p-10 text-center">

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