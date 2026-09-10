<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Theme;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $news = \App\Models\News::with(['website','category']);

if ($request->filled('search')) {
    $news->where('title', 'like', '%' . $request->search . '%');
}

if ($request->filled('website_id')) {
    $news->where('website_id', $request->website_id);
}

if ($request->filled('category_id')) {
    $news->where('category_id', $request->category_id);
}

$news = $news->latest()->paginate(10);

$websites = \App\Models\Website::all();

$categories = \App\Models\Category::all();

        return view('admin.news.index', compact('news', 'websites', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $websites = \App\Models\Website::all();
    $categories = \App\Models\Category::all();
    $languages = Language::where('status', 1)->get();
    $themes  = Theme::where('status', 1)->get();

    return view('admin.news.create', compact('websites', 'categories', 'languages','themes'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

           $request->validate([

           'website_id' => 'required',
           'category_id' =>'required',
           'title'  => 'required',
           'slug' => 'required|unique:news,slug',
           'description' => 'required',
           'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
           'published_at' => 'nullable|date',
           'language_id' => 'required|exists:languages,id',
           'theme_id'   => 'required|exists:themes,id',
           'status' => 'required|in:draft,published',
           'video' => 'nullable|mimes:mp4,webm,ogg,mov|max:51200',

           ]);
         
        
          $featuredImage = null;

          if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image')
            ->store('news' , 'public');
          }

          $video = null;

         if ($request->hasFile('video')) {
         $video = $request->file('video')->store('news/videos', 'public');

        }


        \App\Models\News::create([

            'website_id' => $request->website_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            // 'status' => 1,
            'featured_image' => $featuredImage,
            'is_breaking' => $request->has('is_breaking'),
            'is_featured' => $request->has('is_featured'),
            'published_at' => $request->published_at,
            'language_id' => $request->language_id,
            'theme_id'  => $request->theme_id,
            'video' => $video,
            'status'  => $request->status,
        ]);

        return redirect()
           ->route('news.index')
           ->with('success', 'News Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news = \App\Models\News::findOrFail($id);

        $websites = \App\Models\Website::all();
        $categories = \App\Models\Category::all();
        $languages = Language::where('status', 1)->get();
        $themes = Theme::where('status', 1)->get();

        return view('admin.news.edit' , compact(
            'news',
            'websites',
            'categories',
            'languages',
            'themes'

        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $news = \App\Models\News::findOrFail($id);

    $request->validate([
        'website_id' => 'required',
        'category_id' => 'required',
        'title' => 'required',
        'slug' => 'required|unique:news,slug,' . $id,
        'description' => 'required',
        'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        'theme_id'   => 'required|exists:themes,id',
        'video' => 'nullable|mimes:mp4,webm,ogg,mov|max:51200',
        'status' => 'required|in:draft,published',

    ]);

    if ($request->hasFile('featured_image')) {

        if ($news->featured_image && \Storage::disk('public')->exists($news->featured_image)) {
            \Storage::disk('public')->delete($news->featured_image);
        }

        $featuredImage = $request->file('featured_image')->store('news', 'public');

    } else {

        $featuredImage = $news->featured_image;
    }


       if ($request->hasFile('video')) {

    if ($news->video && \Storage::disk('public')->exists($news->video)) {
        \Storage::disk('public')->delete($news->video);
    }

    $video = $request->file('video')->store('news/videos', 'public');

   } else {

    $video = $news->video;
  }



    $news->update([
        'website_id' => $request->website_id,
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => $request->slug,
        'description' => $request->description,
        'meta_title' => $request->meta_title,
        'meta_description' => $request->meta_description,
        'meta_keywords' => $request->meta_keywords,
        'featured_image' => $featuredImage,
        'is_breaking' => $request->has('is_breaking'),
        'is_featured' => $request->has('is_featured'),
        'theme_id'  => $request->theme_id,
        'video' => $video,
        'status'  => $request->status,


    ]);

    return redirect()->route('news.index')
        ->with('success', 'News Updated Successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = \App\Models\News::findOrfail($id);

        $news->delete();

        return redirect()
          ->route('news.index')
          ->with('success', 'News Deleted Successfully');
    }

    public function toggleStatus($id)
    {
        $news = \App\Models\News::findOrFail($id);

        $news->status = !$news->status;

        $news->save();

        return redirect()
            ->route('news.index')
            ->with('success', 'News Status Updated Successfully');

    }
}
