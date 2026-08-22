@extends('frontend.layout')

@section('title')
      {{ $category->name }} - {{ $website->name }}
 @endsection
 
 @section('meta_description')
      Latest {{ $category->name }} news from {{ $website->name }}.
 @endsection     

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- HEADER --}}
    <div class="border-b-2 border-gray-900 pb-4 mb-8">

        <div class="flex items-center gap-3">

            <span class="w-2 h-7 bg-red-600"></span>

            <div>

                <p class="text-xs uppercase font-bold text-gray-500">
                    {{ $website->name }}
                </p>

                <h1 class="text-3xl font-black">
                    {{ $category->name }}
                </h1>

            </div>

        </div>

    </div>


    {{-- NEWS --}}
    <div class="grid lg:grid-cols-3 gap-6">

        @forelse($news as $item)

            <article class="bg-white border border-gray-200 overflow-hidden">

                @if($item->featured_image)

                    <div class="aspect-[16/9] overflow-hidden">

                        <img
                            src="{{ asset('storage/' . $item->featured_image) }}"
                            alt="{{ $item->title }}"
                            class="w-full h-full object-cover hover:scale-105 transition duration-500"
                        >

                    </div>

                @endif


                <div class="p-5">

                    <div class="text-xs uppercase font-bold text-red-600">

                        {{ $category->name }}

                    </div>

                    <a href="{{ route('frontend.news' , [
                             'websiteSlug' => $website->slug,
                             'newsSlug' => $item->slug
                             ]) }}"
                             class="block-group">
                    <h2 class="font-serif text-xl font-bold mt-2 leading-snug">

                        {{ $item->title }}

                    </h2>

                    </a>


                    <p class="text-sm text-gray-500 mt-3">

                        {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 120) }}

                    </p>


                    <div class="text-xs text-gray-400 mt-4">

                        {{ optional($item->published_at)->diffForHumans() }}

                    </div>

                </div>

            </article>

        @empty

            <div class="lg:col-span-3 text-center py-16 text-gray-500">

                No published news available in this category.

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}
    <div class="mt-8">

        {{ $news->links() }}

    </div>

</div>

@endsection