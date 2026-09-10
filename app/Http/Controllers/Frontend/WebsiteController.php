<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\News;
use App\Models\Category;
use App\Models\Setting;

class WebsiteController extends Controller
{
public function show(string $slug)
{
    $website = Website::where('slug', $slug)
        ->where('status', true)
        ->firstOrFail();

    // Make current website available to helpers
    app()->instance('currentWebsite', $website);

    return $this->loadWebsiteHome($website);
}
    public function domainSearch()
    {
        abort_unless(
            app()->bound('currentWebsite'),
            404
        );

        $website = app('currentWebsite');

        abort_unless(
            $website->status,
            404
        );

        return $this->loadSearch($website);
    }
public function search(string $slug)
{
    $website = Website::where('slug', $slug)
        ->where('status', true)
        ->firstOrFail();

    app()->instance('currentWebsite', $website);

    return $this->loadSearch($website);
}

    private function loadWebsiteHome(Website $website)
    {
        app()->setLocale($website->language);

        $setting = Setting::first();

        $breakingNews = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('status', 'published')
            ->where('is_breaking', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->take(5)
            ->get();

        $featuredNews = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('status', 'published')
            ->where('is_featured', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->take(6)
            ->get();

        $latestNews = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->paginate(10);

        $categories = Category::where('website_id', $website->id)
            ->where('status', true)
            ->latest()
            ->get();

        $themePath = $website->selectedTheme?->theme_path ?? 'default';

        return view(
            'frontend.themes.' . $themePath . '.home',
            compact(
                'website',
                'setting',
                'breakingNews',
                'featuredNews',
                'latestNews',
                'categories'
            )
        );
    }

    private function loadSearch(Website $website)
    {
        app()->setLocale(
            request('lang', $website->language ?? 'en')
        );

        $setting = Setting::first();

        /*
        |--------------------------------------------------------------------------
        | SEARCH PARAMETERS
        |--------------------------------------------------------------------------
        */

        $query = trim((string) request('q', ''));

        $categorySlug = request('category');

        $sort = request('sort', 'latest');

        $view = request('view', 'list');

        $lang = request(
            'lang',
            $website->language ?? 'en'
        );

        /*
        |--------------------------------------------------------------------------
        | VALIDATE PARAMETERS
        |--------------------------------------------------------------------------
        */

        if (!in_array($sort, ['latest', 'oldest'], true)) {
            $sort = 'latest';
        }

        if (!in_array($view, ['list', 'compact'], true)) {
            $view = 'list';
        }

        if (!in_array($lang, ['en', 'hi', 'mr'], true)) {
            $lang = $website->language ?? 'en';
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = Category::where('website_id', $website->id)
            ->where('status', true)
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | BREAKING NEWS
        |--------------------------------------------------------------------------
        */

        $breakingNews = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('status', 'published')
            ->where('is_breaking', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SEARCH QUERY
        |--------------------------------------------------------------------------
        */

        $searchResults = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })

            /*
            |--------------------------------------------------------------------------
            | TEXT SEARCH
            |--------------------------------------------------------------------------
            */
            ->when($query !== '', function ($q) use ($query) {

                $q->where(function ($search) use ($query) {

                    $search->where(
                        'title',
                        'like',
                        '%' . $query . '%'
                    )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $query . '%'
                    )
                    ->orWhere(
                        'meta_title',
                        'like',
                        '%' . $query . '%'
                    )
                    ->orWhere(
                        'meta_description',
                        'like',
                        '%' . $query . '%'
                    );
                });
            })

            /*
            |--------------------------------------------------------------------------
            | CATEGORY FILTER
            |--------------------------------------------------------------------------
            */
            ->when($categorySlug, function ($q) use ($categorySlug, $website) {

                $q->whereHas('category', function ($categoryQuery) use (
                    $categorySlug,
                    $website
                ) {
                    $categoryQuery
                        ->where('website_id', $website->id)
                        ->where('slug', $categorySlug)
                        ->where('status', true);
                });
            })

            /*
            |--------------------------------------------------------------------------
            | SORT
            |--------------------------------------------------------------------------
            */
            ->when(
                $sort === 'oldest',
                function ($q) {
                    $q->orderBy('published_at', 'asc');
                },
                function ($q) {
                    $q->latest('published_at');
                }
            )

            ->paginate(10)

            /*
            |--------------------------------------------------------------------------
            | KEEP PARAMETERS IN PAGINATION
            |--------------------------------------------------------------------------
            */
            ->withQueryString();

        return view(
            'frontend.search',
            compact(
                'website',
                'setting',
                'categories',
                'breakingNews',
                'searchResults',
                'query',
                'categorySlug',
                'sort',
                'view',
                'lang'
            )
        );
    }
}

