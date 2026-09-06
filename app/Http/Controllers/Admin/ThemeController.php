<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use ZipArchive;
use Illuminate\Support\Facades\File;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::latest()->paginate(10);

        return view('admin.themes.index', compact('themes'));
    }

    public function create()
    {
        return view('admin.themes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:themes,name',
            'description' => 'nullable|string',
            'type' => 'required|in:free,premium',
            'price' => 'required_if:type,premium|nullable|numeric|min:0',
            'trial_days' => 'required_if:type,premium|nullable|integer|min:0',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'theme_zip' => 'required|file|mimes:zip|max:10240',
            'status' => 'required|boolean',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Theme slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);

        /*
        |--------------------------------------------------------------------------
        | Theme folder
        |--------------------------------------------------------------------------
        */

        $themeFolder = resource_path('views/frontend/themes/' . $slug);

        if (File::exists($themeFolder)) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'A theme with this name already exists.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Create theme folder
        |--------------------------------------------------------------------------
        */

        File::makeDirectory(
            $themeFolder,
            0755,
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Extract ZIP
        |--------------------------------------------------------------------------
        */

        $zip = new ZipArchive;

        if ($zip->open($request->file('theme_zip')->getRealPath()) === true) {

            $zip->extractTo($themeFolder);

            $zip->close();

        } else {

            File::deleteDirectory($themeFolder);

            return back()
                ->withInput()
                ->withErrors([
                    'theme_zip' => 'Unable to open the ZIP file.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Preview Image
        |--------------------------------------------------------------------------
        */

        $previewImage = null;

        if ($request->hasFile('preview_image')) {

            $previewImage = $request
                ->file('preview_image')
                ->store('themes/previews', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Premium / Free
        |--------------------------------------------------------------------------
        */

        $price = 0;
        $trialDays = 0;

        if ($request->type === 'premium') {

            $price = $request->price ?? 0;
            $trialDays = $request->trial_days ?? 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Save Theme
        |--------------------------------------------------------------------------
        */

        Theme::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $price,
            'trial_days' => $trialDays,
            'theme_path' => $slug,
            'preview_image' => $previewImage,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('themes.index')
            ->with('success', 'Theme Added Successfully');
    }

    public function show(Theme $theme)
    {
        //
    }

    public function edit(Theme $theme)
    {
        return view('admin.themes.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('themes', 'name')->ignore($theme->id),
            ],

            'description' => 'nullable|string',

            'type' => 'required|in:free,premium',

            'price' => 'required|numeric|min:0',

            'trial_days' => 'required|integer|min:0',

            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'theme_zip' => 'nullable|file|mimes:zip|max:10240',

            'status' => 'required|boolean',
        ]);

        $slug = Str::slug($request->name);

        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $request->type === 'premium'
                ? $request->price
                : 0,
            'trial_days' => $request->type === 'premium'
                ? $request->trial_days
                : 0,
            'theme_path' => $slug,
            'status' => $request->status,
        ];

        /*
        |--------------------------------------------------------------------------
        | New Preview
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('preview_image')) {

            $imagePath = $request
                ->file('preview_image')
                ->store('themes/previews', 'public');

            $data['preview_image'] = $imagePath;
        }

        /*
        |--------------------------------------------------------------------------
        | Replace Theme ZIP
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('theme_zip')) {

            $themeFolder = resource_path(
                'views/frontend/themes/' . $slug
            );

            if (File::exists($themeFolder)) {
                File::deleteDirectory($themeFolder);
            }

            File::makeDirectory(
                $themeFolder,
                0755,
                true
            );

            $zip = new ZipArchive;

            if ($zip->open($request->file('theme_zip')->getRealPath()) === true) {

                $zip->extractTo($themeFolder);

                $zip->close();

            } else {

                return back()
                    ->withInput()
                    ->withErrors([
                        'theme_zip' => 'Unable to open the ZIP file.'
                    ]);
            }
        }

        $theme->update($data);

        return redirect()
            ->route('themes.index')
            ->with('success', 'Theme Updated Successfully');
    }

    public function destroy(Theme $theme)
    {
        $themeFolder = resource_path(
            'views/frontend/themes/' . $theme->theme_path
        );

        if (File::exists($themeFolder)) {
            File::deleteDirectory($themeFolder);
        }

        $theme->delete();

        return redirect()
            ->route('themes.index')
            ->with('success', 'Theme Deleted Successfully');
    }
}