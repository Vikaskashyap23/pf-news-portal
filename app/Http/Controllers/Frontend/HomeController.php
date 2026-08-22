<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Website;

class HomeController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        /*
        |--------------------------------------------------------------------------
        | Default website
        |--------------------------------------------------------------------------
        | Root URL (/) par first active website show hogi.
        | Website-specific pages /site/{slug} se open hongi.
        |--------------------------------------------------------------------------
        */

        $website = Website::where('status', true)
            ->orderBy('id')
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Breaking News
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
        | Featured News
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Latest News
        |--------------------------------------------------------------------------
        */

        $latestNews = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::where('website_id', $website->id)
            ->where('status', true)
            ->latest()
            ->get();

        return view('frontend.home', compact(
            'setting',
            'website',
            'breakingNews',
            'featuredNews',
            'latestNews',
            'categories'
        ));
    }
}