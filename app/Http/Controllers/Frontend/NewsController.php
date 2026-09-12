<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\News;
use App\Services\ThemeViewService;

class NewsController extends Controller
{
    public function show(
        string $websiteSlug,
        string $newsSlug
    ) {
        $website = Website::where('slug', $websiteSlug)
            ->where('status', true)
            ->firstOrFail();

        return $this->loadNews(
            $website,
            $newsSlug
        );
    }

    public function domainShow(
        string $newsSlug
    ) {
        if (app()->bound('currentWebsite')) {
            $website = app('currentWebsite');
        } else {
            $website = Website::where('status', true)
                ->orderBy('id')
                ->firstOrFail();
        }

        return $this->loadNews(
            $website,
            $newsSlug
        );
    }

    private function loadNews(
        Website $website,
        string $newsSlug
    ) {
        $news = News::with([
                'category',
                'website'
            ])
            ->where(
                'website_id',
                $website->id
            )
            ->where(
                'slug',
                $newsSlug
            )
            ->where(
                'status',
                'published'
            )
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere(
                        'published_at',
                        '<=',
                        now()
                    );
            })
            ->firstOrFail();

        return app(ThemeViewService::class)->render(
            $website,
            'news.show',
            compact(
                'website',
                'news'
            )
        );
    }
}