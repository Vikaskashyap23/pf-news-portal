<?php

namespace App\Services;

use App\Models\Website;
use Illuminate\Contracts\View\View;
use RuntimeException;

class ThemeViewService
{
    /**
     * Render a theme view with automatic fallback.
     */
    public function render(
        Website $website,
        string $page,
        array $data = []
    ): View {
        $themePath =
            $website->selectedTheme?->theme_path
            ?? 'default';

        $themeView =
            'frontend.themes.'
            . $themePath
            . '.'
            . $page;

        /*
        |--------------------------------------------------------------------------
        | Selected Theme View
        |--------------------------------------------------------------------------
        */

        if (view()->exists($themeView)) {
            return view(
                $themeView,
                $data
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Default NewsHub Theme Fallback
        |--------------------------------------------------------------------------
        */

        $defaultView =
            'frontend.themes.default.'
            . $page;

        if (view()->exists($defaultView)) {
            return view(
                $defaultView,
                $data
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Final Error
        |--------------------------------------------------------------------------
        */

        throw new RuntimeException(
            'Theme view not found: '
            . $page
            . '. Selected theme: '
            . $themePath
        );
    }
}