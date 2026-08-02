<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Category;
use App\Models\Website;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
      $categories = Category:: with('website')->get();

      return view ('admin.categories.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $websites = Website::all();

        $parents = Category::all();

        return view ('admin.categories.create', compact('websites', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category::create([
            'website_id' => $request->website_id,
            'parent_id'  => $request->parent_id,
            'name' =>  $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);

        return redirect()
        ->route('categories.index')
        ->with('success ', 'Category Created Successfully.' );
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
        $category = Category::findOrfail($id);

        $websites = Website::all();

        $parents = Category::where('id', '!=' , $id)->get();

        return view('admin.categories.edit', compact(

            'category',
            'websites',
            'parents'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::FindOrfail($id);

        $category->update([
            'website_id' => $request->website_id,
            'parent_id'  => $request->parent_id,
            'name'       => $request->name,
            'slug'       => $request->slug,
            'status'     => $request->status,
        ]);

        return redirect()
        ->route('categories.index')
        ->with('success' , 'Category Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrfail($id);

        $category->delete();

        return redirect()
        ->route('categories.index')
        ->with('success', 'Category Deleted Successfully.');
    }
}
