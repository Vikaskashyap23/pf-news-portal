<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Models\News;
use App\Models\Language;
use App\Models\Theme;
use App\Models\Website;
use App\Models\Category;

class NewsController extends Controller
{
    /**
     * News list
     */
    public function index(Request $request)
    {
        $currentUser = auth()->user();

        $news = News::with(['website', 'category']);

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        | Admin can see only news belonging to his assigned website.
        */
        if ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {
                $news->whereRaw('1 = 0');
            } else {
                $news->where(
                    'website_id',
                    $currentUser->website_id
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $news->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | WEBSITE FILTER
        |--------------------------------------------------------------------------
        */
        if ($request->filled('website_id')) {

            if ($currentUser->role === 'super_admin') {

                $news->where(
                    'website_id',
                    $request->website_id
                );

            } elseif ($currentUser->role === 'admin') {

                $news->where(
                    'website_id',
                    $currentUser->website_id
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category_id')) {

            if ($currentUser->role === 'super_admin') {

                $news->where(
                    'category_id',
                    $request->category_id
                );

            } elseif ($currentUser->role === 'admin') {

                $news->where('category_id', $request->category_id)
                    ->where(
                        'website_id',
                        $currentUser->website_id
                    );
            }
        }

        $news = $news
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | WEBSITE DROPDOWN
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $websites = Website::orderBy('name')->get();

        } else {

            $websites = Website::where(
                'id',
                $currentUser->website_id
            )->get();
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY DROPDOWN
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $categories = Category::orderBy('name')->get();

        } else {

            $categories = Category::where(
                'website_id',
                $currentUser->website_id
            )
                ->orderBy('name')
                ->get();
        }

        return view(
            'admin.news.index',
            compact(
                'news',
                'websites',
                'categories'
            )
        );
    }


    /**
     * Create news page
     */
    public function create()
    {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | WEBSITE
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $websites = Website::orderBy('name')->get();

        } else {

            $websites = Website::where(
                'id',
                $currentUser->website_id
            )->get();
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $categories = Category::orderBy('name')->get();

        } else {

            $categories = Category::where(
                'website_id',
                $currentUser->website_id
            )
                ->orderBy('name')
                ->get();
        }

        $languages = Language::where(
            'status',
            1
        )->get();

        $themes = Theme::where(
            'status',
            1
        )->get();

        return view(
            'admin.news.create',
            compact(
                'websites',
                'categories',
                'languages',
                'themes'
            )
        );
    }


    /**
     * Store news
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | BASIC VALIDATION
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'website_id' => [
                'required',
                'integer',
                'exists:websites,id',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'title' => [
                'required',
                'string',
            ],

            'slug' => [
                'required',
                'string',
                'unique:news,slug',
            ],

            'description' => [
                'required',
            ],

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'language_id' => [
                'required',
                'exists:languages,id',
            ],

            'theme_id' => [
                'required',
                'exists:themes,id',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            'video' => [
                'nullable',
                'mimes:mp4,webm,ogg,mov',
                'max:51200',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | WEBSITE SECURITY
        |--------------------------------------------------------------------------
        |
        | Super Admin can choose any website.
        |
        | Admin cannot choose another website even if he modifies
        | website_id manually in the request.
        |
        */
        if ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {
                abort(
                    403,
                    'Your account is not assigned to any website.'
                );
            }

            $websiteId = $currentUser->website_id;

        } else {

            $websiteId = $request->website_id;
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY SECURITY
        |--------------------------------------------------------------------------
        */
        $category = Category::findOrFail(
            $request->category_id
        );

        if (
            $currentUser->role === 'admin' &&
            $category->website_id != $currentUser->website_id
        ) {
            abort(
                403,
                'You cannot use a category from another website.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FEATURED IMAGE
        |--------------------------------------------------------------------------
        */
        $featuredImage = null;

        if ($request->hasFile('featured_image')) {

            $featuredImage = $request
                ->file('featured_image')
                ->store(
                    'news',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | VIDEO
        |--------------------------------------------------------------------------
        */
        $video = null;

        if ($request->hasFile('video')) {

            $video = $request
                ->file('video')
                ->store(
                    'news/videos',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE NEWS
        |--------------------------------------------------------------------------
        */
        News::create([
            'website_id' => $websiteId,

            'category_id' => $request->category_id,

            'title' => $request->title,

            'slug' => $request->slug,

            'description' => $request->description,

            'meta_description' => $request->meta_description,

            'meta_title' => $request->meta_title,

            'meta_keywords' => $request->meta_keywords,

            'featured_image' => $featuredImage,

            'is_breaking' => $request->has(
                'is_breaking'
            ),

            'is_featured' => $request->has(
                'is_featured'
            ),

            'published_at' => $request->published_at,

            'language_id' => $request->language_id,

            'theme_id' => $request->theme_id,

            'video' => $video,

            'status' => $request->status,
        ]);

        return redirect()
            ->route('news.index')
            ->with(
                'success',
                'News Added Successfully'
            );
    }


    /**
     * Show news
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);

        $this->authorizeNewsAccess($news);

        return view(
            'admin.news.show',
            compact('news')
        );
    }


    /**
     * Edit news
     */
    public function edit(string $id)
    {
        $news = News::findOrFail($id);

        $this->authorizeNewsAccess($news);

        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | WEBSITE
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $websites = Website::orderBy('name')->get();

        } else {

            $websites = Website::where(
                'id',
                $currentUser->website_id
            )->get();
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {

            $categories = Category::orderBy('name')->get();

        } else {

            $categories = Category::where(
                'website_id',
                $currentUser->website_id
            )
                ->orderBy('name')
                ->get();
        }

        $languages = Language::where(
            'status',
            1
        )->get();

        $themes = Theme::where(
            'status',
            1
        )->get();

        return view(
            'admin.news.edit',
            compact(
                'news',
                'websites',
                'categories',
                'languages',
                'themes'
            )
        );
    }


    /**
     * Update news
     */
    public function update(
        Request $request,
        $id
    ) {
        $news = News::findOrFail($id);

        $this->authorizeNewsAccess($news);

        $currentUser = auth()->user();

        $request->validate([
            'website_id' => [
                'required',
                'integer',
                'exists:websites,id',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'title' => [
                'required',
                'string',
            ],

            'slug' => [
                'required',
                'string',
                Rule::unique('news', 'slug')
                    ->ignore($id),
            ],

            'description' => [
                'required',
            ],

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'theme_id' => [
                'required',
                'exists:themes,id',
            ],

            'video' => [
                'nullable',
                'mimes:mp4,webm,ogg,mov',
                'max:51200',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | WEBSITE SECURITY
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {
                abort(
                    403,
                    'Your account is not assigned to any website.'
                );
            }

            $websiteId = $currentUser->website_id;

        } else {

            $websiteId = $request->website_id;
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY SECURITY
        |--------------------------------------------------------------------------
        */
        $category = Category::findOrFail(
            $request->category_id
        );

        if (
            $currentUser->role === 'admin' &&
            $category->website_id != $currentUser->website_id
        ) {
            abort(
                403,
                'You cannot use a category from another website.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FEATURED IMAGE
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('featured_image')) {

            if (
                $news->featured_image &&
                Storage::disk('public')->exists(
                    $news->featured_image
                )
            ) {
                Storage::disk('public')->delete(
                    $news->featured_image
                );
            }

            $featuredImage = $request
                ->file('featured_image')
                ->store(
                    'news',
                    'public'
                );

        } else {

            $featuredImage = $news->featured_image;
        }

        /*
        |--------------------------------------------------------------------------
        | VIDEO
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('video')) {

            if (
                $news->video &&
                Storage::disk('public')->exists(
                    $news->video
                )
            ) {
                Storage::disk('public')->delete(
                    $news->video
                );
            }

            $video = $request
                ->file('video')
                ->store(
                    'news/videos',
                    'public'
                );

        } else {

            $video = $news->video;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE NEWS
        |--------------------------------------------------------------------------
        */
        $news->update([
            'website_id' => $websiteId,

            'category_id' => $request->category_id,

            'title' => $request->title,

            'slug' => $request->slug,

            'description' => $request->description,

            'meta_title' => $request->meta_title,

            'meta_description' => $request->meta_description,

            'meta_keywords' => $request->meta_keywords,

            'featured_image' => $featuredImage,

            'is_breaking' => $request->has(
                'is_breaking'
            ),

            'is_featured' => $request->has(
                'is_featured'
            ),

            'theme_id' => $request->theme_id,

            'video' => $video,

            'status' => $request->status,
        ]);

        return redirect()
            ->route('news.index')
            ->with(
                'success',
                'News Updated Successfully'
            );
    }


    /**
     * Delete news
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);

        $this->authorizeNewsAccess($news);

        /*
        |--------------------------------------------------------------------------
        | DELETE IMAGE
        |--------------------------------------------------------------------------
        */
        if (
            $news->featured_image &&
            Storage::disk('public')->exists(
                $news->featured_image
            )
        ) {
            Storage::disk('public')->delete(
                $news->featured_image
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE VIDEO
        |--------------------------------------------------------------------------
        */
        if (
            $news->video &&
            Storage::disk('public')->exists(
                $news->video
            )
        ) {
            Storage::disk('public')->delete(
                $news->video
            );
        }

        $news->delete();

        return redirect()
            ->route('news.index')
            ->with(
                'success',
                'News Deleted Successfully'
            );
    }


    /**
     * Toggle news status
     *
     * NOTE:
     * Current News status is draft/published.
     * Therefore this method switches between those two values.
     */
    public function toggleStatus($id)
    {
        $news = News::findOrFail($id);

        $this->authorizeNewsAccess($news);

        $news->status =
            $news->status === 'published'
                ? 'draft'
                : 'published';

        $news->save();

        return redirect()
            ->route('news.index')
            ->with(
                'success',
                'News Status Updated Successfully'
            );
    }


    /**
     * Check whether current user can access this news.
     */
    private function authorizeNewsAccess(
        News $news
    ): void {
        $currentUser = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'super_admin') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        if ($currentUser->role === 'admin') {

            if (!$currentUser->website_id) {

                abort(
                    403,
                    'Your account is not assigned to any website.'
                );
            }

            if (
                (int) $news->website_id !==
                (int) $currentUser->website_id
            ) {
                abort(
                    403,
                    'You do not have access to this website news.'
                );
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | OTHER ROLES
        |--------------------------------------------------------------------------
        */
        abort(
            403,
            'Unauthorized access.'
        );
    }
}

