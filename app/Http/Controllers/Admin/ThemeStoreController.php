<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\Website;
use Illuminate\Http\Request;

class ThemeStoreController extends Controller
{
    /**
     * Display Admin Theme Store.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        /*
         * Super Admin:
         * Can see all active websites.
         */
        if ($user->role === 'super_admin') {
            $websites = Website::where('status', true)
                ->orderBy('name')
                ->get();
        } else {
            /*
             * Admin:
             * Only assigned website.
             */
            $websites = Website::where('id', $user->website_id)
                ->where('status', true)
                ->get();
        }

        /*
         * Selected website
         */
        $selectedWebsite = null;

        if ($request->filled('website')) {
            $selectedWebsite = $websites
                ->where('id', (int) $request->website)
                ->first();
        }

        /*
         * If no website selected, use first available website.
         */
        if (!$selectedWebsite) {
            $selectedWebsite = $websites->first();
        }

        /*
         * Active themes available in Theme Store.
         */
        $themes = Theme::where('status', true)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.theme-store.index',
            compact(
                'themes',
                'websites',
                'selectedWebsite'
            )
        );
    }
}