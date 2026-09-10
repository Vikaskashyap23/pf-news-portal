<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\News;

class NewsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Existing /site/{slug}/news/{newsSlug}
    |--------------------------------------------------------------------------
    */

    public function show(string $websiteSlug, string $newsSlug)
    {
        $website = Website::where('slug', $websiteSlug)
            ->where('status', true)
            ->firstOrFail();

        return $this->loadNews($website, $newsSlug);
    }


    /*
    |--------------------------------------------------------------------------
    | Domain Based News
    |--------------------------------------------------------------------------
    */
public function domainShow(string $newsSlug)
{
    if (app()->bound('currentWebsite')) {
        $website = app('currentWebsite');
    } else {
        // Localhost par first active website use karo
        $website = Website::where('status', true)
            ->orderBy('id')
            ->firstOrFail();
    }

    return $this->loadNews($website, $newsSlug);
}


    /*
    |--------------------------------------------------------------------------
    | Common News Loader
    |--------------------------------------------------------------------------
    */

    private function loadNews(
        Website $website,
        string $newsSlug
    ) {
        $news = News::with(['category', 'website'])
            ->where('website_id', $website->id)
            ->where('slug', $newsSlug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Theme
        |--------------------------------------------------------------------------
        */

        $themePath = $website->selectedTheme?->theme_path ?? 'default';


        return view(
            'frontend.themes.' . $themePath . '.news.show',
            compact(
                'website',
                'news'
            )
        );
    }
}

