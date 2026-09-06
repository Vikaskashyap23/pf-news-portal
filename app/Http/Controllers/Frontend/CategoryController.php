<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Website;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Existing /site/{slug}/category/{categorySlug}
    |--------------------------------------------------------------------------
    */

    public function show(string $websiteSlug, string $categorySlug)
    {
        $website = Website::where('slug', $websiteSlug)
            ->where('status', true)
            ->firstOrFail();

        return $this->loadCategory($website, $categorySlug);
    }


    /*
    |--------------------------------------------------------------------------
    | Domain Based Category
    |--------------------------------------------------------------------------
    */

    public function domainShow(string $categorySlug)
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

        return $this->loadCategory($website, $categorySlug);
    }


    /*
    |--------------------------------------------------------------------------
    | Common Category Loader
    |--------------------------------------------------------------------------
    */

    private function loadCategory(
        Website $website,
        string $categorySlug
    ) {
        $category = Category::where('website_id', $website->id)
            ->where('slug', $categorySlug)
            ->where('status', true)
            ->firstOrFail();

        $news = $category->news()
            ->with(['category', 'website'])
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

        return view('frontend.category', compact(
            'website',
            'category',
            'news',
            'categories'
        ));
    }
}

