<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\Website;


class ThemeController extends Controller
{
    public function index($websiteSlug)

    {

        $website = Website::where('slug', $websiteSlug)->firstOrFail();

        $themes = Theme::where('status', 1)
            ->latest()
            ->paginate(12);

        return view('frontend.themes.index', compact(
            'themes',
            'website',
            'websiteSlug'

        ));
    }

    public function activate($websiteSlug, $themeId)
{
    $website = Website::where('slug', $websiteSlug)->firstOrFail();

    $theme = Theme::where('id', $themeId)
        ->where('status', 1)
        ->where('type', 'free')
        ->firstOrFail();

    $website->theme_id = $theme->id;
    $website->save();

    return redirect()
        ->route('frontend.themes', $websiteSlug)
        ->with('success', 'Theme activated successfully!');
}



public function preview($websiteSlug, $themeId)
{
    $website = Website::where('slug', $websiteSlug)
        ->firstOrFail();

    $theme = Theme::where('id', $themeId)
        ->where('status', 1)
        ->firstOrFail();

    $themePath = $theme->theme_path ?? 'default';

    $breakingNews = \App\Models\News::with(['category', 'website'])
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

    $featuredNews = \App\Models\News::with(['category', 'website'])
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

    $latestNews = \App\Models\News::with(['category', 'website'])
        ->where('website_id', $website->id)
        ->where('status', 'published')
        ->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
        ->latest('published_at')
        ->paginate(10);

    $categories = \App\Models\Category::where('website_id', $website->id)
        ->where('status', true)
        ->latest()
        ->get();

    $setting = \App\Models\Setting::first();

    return view(
        'frontend.themes.' . $themePath . '.home',
        compact(
            'setting',
            'website',
            'breakingNews',
            'featuredNews',
            'latestNews',
            'categories',
            'theme'
        )
    );
}


}