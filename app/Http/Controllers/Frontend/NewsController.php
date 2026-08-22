<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\News;

class NewsController extends Controller
{
    public function show(string $websiteSlug, string $newsSlug)
    {
        // Find active website
        $website = Website::where('slug', $websiteSlug)
            ->where('status', true)
            ->firstOrFail();

        // Find published news belonging to this website
        $news = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('slug', $newsSlug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->firstOrFail();

            $theme = $website->theme ?? 'default';

        return view('frontend.themes.'. $theme . '.news.show', compact(
            'website',
            'news'
        ));
    }
}