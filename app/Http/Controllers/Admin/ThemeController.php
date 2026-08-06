<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Theme;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Illuminate\Validation\Rule;



class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themes = Theme::latest()->paginate(10);

        return view('admin.themes.index', compact('themes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.themes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:themes,name',

        ]);
         Theme::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 1,
         ]);

         return redirect()
         ->route('themes.index')
         ->with('success', 'Theme Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        return view('admin.themes.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('themes','name')->ignore($theme->id),
            ],
        ]);

          $theme->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),

          ]);

          return redirect()
          ->route('themes.index')
          ->with('success', 'Theme Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();

        return redirect()
        ->route('themes.index')
        ->with('success', 'Theme Deleted Successfully');
    }
}
