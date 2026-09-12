<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Services\ThemeInstallerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ThemeController extends Controller
{
    /**
     * Make sure only Super Admin can access theme management.
     */
    private function authorizeSuperAdmin(): void
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'super_admin') {
            abort(
                403,
                'Only Super Admin can manage themes.'
            );
        }
    }

    /**
     * Display all themes.
     */
    public function index()
    {
        $this->authorizeSuperAdmin();

        $themes = Theme::latest()
            ->paginate(10);

        return view(
            'admin.themes.index',
            compact('themes')
        );
    }

    /**
     * Show create theme form.
     */
    public function create()
    {
        $this->authorizeSuperAdmin();

        return view(
            'admin.themes.create'
        );
    }

    /**
     * Store a new theme.
     */
    public function store(
        Request $request,
        ThemeInstallerService $themeInstaller
    ) {
        $this->authorizeSuperAdmin();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:themes,name',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'type' => [
                'required',
                'in:free,premium',
            ],

            'price' => [
                'required_if:type,premium',
                'nullable',
                'numeric',
                'min:0',
            ],

            'trial_days' => [
                'required_if:type,premium',
                'nullable',
                'integer',
                'min:0',
            ],

            'preview_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'theme_zip' => [
                'required',
                'file',
                'mimes:zip',
                'max:10240',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Theme slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug(
            $request->name
        );

        if (!$slug) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Invalid theme name.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check theme folder
        |--------------------------------------------------------------------------
        */

        $themeFolder = resource_path(
            'views/frontend/themes/' . $slug
        );

        if (File::exists($themeFolder)) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' =>
                        'A theme with this name already exists.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Install Theme ZIP
        |--------------------------------------------------------------------------
        */

        try {

            $themeInstaller->install(
                $request->file('theme_zip'),
                $request->name
            );

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->withErrors([
                    'theme_zip' =>
                        $e->getMessage(),
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
                ->store(
                    'themes/previews',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Free / Premium
        |--------------------------------------------------------------------------
        */

        $price = 0;
        $trialDays = 0;

        if ($request->type === 'premium') {

            $price = $request->price ?? 0;

            $trialDays =
                $request->trial_days ?? 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Save Theme
        |--------------------------------------------------------------------------
        */

        Theme::create([
            'name' =>
                $request->name,

            'slug' =>
                $slug,

            'description' =>
                $request->description,

            'type' =>
                $request->type,

            'price' =>
                $price,

            'trial_days' =>
                $trialDays,

            'theme_path' =>
                $slug,

            'preview_image' =>
                $previewImage,

            'status' =>
                $request->status,
        ]);

        return redirect()
            ->route('themes.index')
            ->with(
                'success',
                'Theme Added Successfully'
            );
    }

    /**
     * Display specified theme.
     */
    public function show(Theme $theme)
    {
        $this->authorizeSuperAdmin();

        return view(
            'admin.themes.show',
            compact('theme')
        );
    }

    /**
     * Show edit theme form.
     */
    public function edit(Theme $theme)
    {
        $this->authorizeSuperAdmin();

        return view(
            'admin.themes.edit',
            compact('theme')
        );
    }

    /**
     * Update theme.
     */
    public function update(Request $request, Theme $theme)
    {
        $this->authorizeSuperAdmin();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(
                    'themes',
                    'name'
                )->ignore($theme->id),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'type' => [
                'required',
                'in:free,premium',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'trial_days' => [
                'required',
                'integer',
                'min:0',
            ],

            'preview_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'theme_zip' => [
                'nullable',
                'file',
                'mimes:zip',
                'max:10240',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Theme slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug(
            $request->name
        );

        /*
        |--------------------------------------------------------------------------
        | Theme data
        |--------------------------------------------------------------------------
        */

        $data = [
            'name' =>
                $request->name,

            'slug' =>
                $slug,

            'description' =>
                $request->description,

            'type' =>
                $request->type,

            'price' =>
                $request->type === 'premium'
                    ? $request->price
                    : 0,

            'trial_days' =>
                $request->type === 'premium'
                    ? $request->trial_days
                    : 0,

            'theme_path' =>
                $slug,

            'status' =>
                $request->status,
        ];

        /*
        |--------------------------------------------------------------------------
        | New Preview Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('preview_image')) {

            if ($theme->preview_image) {

                Storage::disk('public')->delete(
                    $theme->preview_image
                );
            }

            $imagePath = $request
                ->file('preview_image')
                ->store(
                    'themes/previews',
                    'public'
                );

            $data['preview_image'] =
                $imagePath;
        }

        /*
        |--------------------------------------------------------------------------
        | Replace Theme ZIP
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('theme_zip')) {

            $themeFolder = resource_path(
                'views/frontend/themes/' .
                $slug
            );

            if (File::exists($themeFolder)) {

                File::deleteDirectory(
                    $themeFolder
                );
            }

            try {

                app(ThemeInstallerService::class)
                    ->install(
                        $request->file('theme_zip'),
                        $request->name
                    );

            } catch (\Throwable $e) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'theme_zip' =>
                            $e->getMessage(),
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update database
        |--------------------------------------------------------------------------
        */

        $theme->update($data);

        return redirect()
            ->route('themes.index')
            ->with(
                'success',
                'Theme Updated Successfully'
            );
    }

    /**
     * Delete theme.
     */
    public function destroy(Theme $theme)
    {
        $this->authorizeSuperAdmin();

        $themeFolder = resource_path(
            'views/frontend/themes/' .
            $theme->theme_path
        );

        /*
        |--------------------------------------------------------------------------
        | Delete theme files
        |--------------------------------------------------------------------------
        */

        if (File::exists($themeFolder)) {

            File::deleteDirectory(
                $themeFolder
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete preview image
        |--------------------------------------------------------------------------
        */

        if ($theme->preview_image) {

            Storage::disk('public')->delete(
                $theme->preview_image
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete database record
        |--------------------------------------------------------------------------
        */

        $theme->delete();

        return redirect()
            ->route('themes.index')
            ->with(
                'success',
                'Theme Deleted Successfully'
            );
    }
}