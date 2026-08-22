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

        $theme = $website->theme ?? 'default';

        return view('frontend.themes.' . $theme . '.home', compact(
            'website',
            'setting',
            'breakingNews',
            'featuredNews',
            'latestNews',
            'categories'
        ));

    }

  public function search(string $slug)
    {
        $website = Website::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $setting = Setting::first();

        $query = request('q');

        $categories = Category::where('website_id', $website->id)
            ->where('status', true)
            ->latest()
            ->get();

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

        $searchResults = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->when($query, function ($q) use ($query) {
                $q->where(function ($search) use ($query) {

                    $search->where('title', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%')
                        ->orWhere('meta_title', 'like', '%' . $query . '%')
                        ->orWhere('meta_description', 'like', '%' . $query . '%');

                });
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

           return view('frontend.search', compact(
            'website',
            'setting',
            'categories',
            'breakingNews',
            'searchResults',
            'query'
        ));
    }
}