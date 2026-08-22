<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Website;

class CategoryController extends Controller
{
    public function show(string $websiteSlug, string $categorySlug)
    {
        $website = Website::where('slug', $websiteSlug)
            ->where('status', true)
            ->firstOrFail();

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