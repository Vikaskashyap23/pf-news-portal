<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\ThemeStoreController;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\WebsiteController as FrontendWebsiteController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\ThemeController as FrontendThemeController;
use App\Http\Controllers\Frontend\ThemePaymentController;
// Models
use App\Models\User;
use App\Models\Website;
use App\Models\News;
use App\Models\Category;


/*
|--------------------------------------------------------------------------
| PUBLIC FRONTEND ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Main Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', [
    HomeController::class,
    'index'
])->name('frontend.home');


/*
|--------------------------------------------------------------------------
| Domain Based Frontend
|--------------------------------------------------------------------------
*/

Route::get('/category/{categorySlug}', [
    FrontendCategoryController::class,
    'domainShow'
])->name('frontend.domain.category');

Route::get('/search', [
    FrontendWebsiteController::class,
    'domainSearch'
])->name('frontend.domain.search');

Route::get('/news/{newsSlug}', [
    FrontendNewsController::class,
    'domainShow'
])->name('frontend.domain.news');


/*
|--------------------------------------------------------------------------
| Domain Language Switch
|--------------------------------------------------------------------------
*/

Route::get('/language/{locale}', function ($locale) {

    if (!in_array($locale, ['en', 'hi', 'mr'])) {
        abort(404);
    }

    abort_unless(app()->bound('currentWebsite'), 404);

    $website = app('currentWebsite');

    abort_unless($website->status, 404);

    session(['locale' => $locale]);

    return redirect()->to(frontend_home_url());

})->name('frontend.domain.language');


/*
|--------------------------------------------------------------------------
| Website Slug Frontend
|--------------------------------------------------------------------------
*/

Route::get('/site/{slug}', [
    FrontendWebsiteController::class,
    'show'
])->name('frontend.website');

Route::get('/site/{websiteSlug}/category/{categorySlug}', [
    FrontendCategoryController::class,
    'show'
])->name('frontend.category');

Route::get('/site/{websiteSlug}/news/{newsSlug}', [
    FrontendNewsController::class,
    'show'
])->name('frontend.news');

Route::get('/site/{slug}/search', [
    FrontendWebsiteController::class,
    'search'
])->name('frontend.search');



/*
|--------------------------------------------------------------------------
| THEME PREVIEW
|--------------------------------------------------------------------------
*/

Route::get('/site/{websiteSlug}/theme-preview/{themeId}', [
    FrontendThemeController::class,
    'preview'
])->whereNumber('themeId')
  ->name('frontend.themes.preview');



  /*
|--------------------------------------------------------------------------
| PREMIUM THEME CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/site/{websiteSlug}/theme-checkout/{themeId}', [
    ThemePaymentController::class,
    'checkout'
])->whereNumber('themeId')
  ->name('frontend.themes.checkout');



  /*
|--------------------------------------------------------------------------
| FREE THEME ACTIVATION
|--------------------------------------------------------------------------
*/

Route::post('/site/{websiteSlug}/theme-activate/{themeId}', [
    FrontendThemeController::class,
    'activate'
])->whereNumber('themeId')
  ->name('frontend.themes.activate');


  /*
|--------------------------------------------------------------------------
| START THEME PAYMENT
|--------------------------------------------------------------------------
*/

Route::post('/site/{websiteSlug}/theme-payment/{themeId}', [
    ThemePaymentController::class,
    'startPayment'
])->whereNumber('themeId')
  ->name('frontend.themes.start-payment');



  Route::post('/theme-payment-success', [
    ThemePaymentController::class,
    'success'
])->name('frontend.themes.payment.success');

/*
|--------------------------------------------------------------------------
| Website Language Switch
|--------------------------------------------------------------------------
*/

Route::get('/site/{websiteSlug}/language/{locale}', function (
    $websiteSlug,
    $locale
) {

    if (!in_array($locale, ['en', 'hi', 'mr'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->route('frontend.website', [
        'slug' => $websiteSlug
    ]);

})->name('language.switch');


/*
|--------------------------------------------------------------------------
| FRONTEND THEME STORE ENTRY
|--------------------------------------------------------------------------
|
| This route exists because the frontend Classic theme already uses:
|
| route('frontend.themes', [
|     'websiteSlug' => $website->slug
| ])
|
| The actual Theme Store is a Super Admin feature.
| For now this public entry redirects to the protected
| Super Admin Theme Store entry.
|
*/

Route::get('/theme-store', function () {

    return redirect()->route('admin.theme-store.index');

})->name('frontend.themes');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/admin', function () {

        $totalUsers = User::count();

        $totalSuperAdmins = User::where(
            'role',
            'super_admin'
        )->count();

        $totalAdmins = User::where(
            'role',
            'admin'
        )->count();

        $totalWebsites = Website::count();

        $totalNews = News::count();

        $totalCategories = Category::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSuperAdmins',
            'totalAdmins',
            'totalWebsites',
            'totalNews',
            'totalCategories'
        ));

    })->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | WEBSITES
    |--------------------------------------------------------------------------
    |
    | Super Admin only
    |
    */

    Route::resource(
        'websites',
        WebsiteController::class
    )->middleware('superadmin');


    /*
    |--------------------------------------------------------------------------
    | WEBSITE DOMAINS
    |--------------------------------------------------------------------------
    |
    | Super Admin only
    |
    */

    Route::prefix('websites/{website}/domains')
        ->name('admin.websites.domains.')
        ->middleware('superadmin')
        ->group(function () {

            Route::get('/', [
                DomainController::class,
                'index'
            ])->name('index');

            Route::get('/create', [
                DomainController::class,
                'create'
            ])->name('create');

            Route::post('/', [
                DomainController::class,
                'store'
            ])->name('store');

            Route::get('/{domain}/edit', [
                DomainController::class,
                'edit'
            ])->name('edit');

            Route::put('/{domain}', [
                DomainController::class,
                'update'
            ])->name('update');

            Route::delete('/{domain}', [
                DomainController::class,
                'destroy'
            ])->name('destroy');

            Route::post('/{domain}/verify', [
                DomainController::class,
                'verify'
            ])->name('verify');

        });


    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    |
    | Admin + Super Admin
    |
    */

    Route::get('/categories', [
        CategoryController::class,
        'index'
    ])
        ->middleware('permission:categories.view')
        ->name('categories.index');

    Route::get('/categories/create', [
        CategoryController::class,
        'create'
    ])
        ->middleware('permission:categories.create')
        ->name('categories.create');

    Route::post('/categories', [
        CategoryController::class,
        'store'
    ])
        ->middleware('permission:categories.create')
        ->name('categories.store');

    Route::get('/categories/{category}', [
        CategoryController::class,
        'show'
    ])
        ->middleware('permission:categories.view')
        ->name('categories.show');

    Route::get('/categories/{category}/edit', [
        CategoryController::class,
        'edit'
    ])
        ->middleware('permission:categories.edit')
        ->name('categories.edit');

    Route::put('/categories/{category}', [
        CategoryController::class,
        'update'
    ])
        ->middleware('permission:categories.edit')
        ->name('categories.update');

    Route::delete('/categories/{category}', [
        CategoryController::class,
        'destroy'
    ])
        ->middleware('permission:categories.delete')
        ->name('categories.destroy');


    /*
    |--------------------------------------------------------------------------
    | NEWS
    |--------------------------------------------------------------------------
    |
    | Admin + Super Admin
    |
    */

    Route::get('/news', [
        NewsController::class,
        'index'
    ])
        ->middleware('permission:news.view')
        ->name('news.index');

    Route::get('/news/create', [
        NewsController::class,
        'create'
    ])
        ->middleware('permission:news.create')
        ->name('news.create');

    Route::post('/news', [
        NewsController::class,
        'store'
    ])
        ->middleware('permission:news.create')
        ->name('news.store');

    Route::get('/news/{news}', [
        NewsController::class,
        'show'
    ])
        ->whereNumber('news')
        ->middleware('permission:news.view')
        ->name('news.show');

    Route::get('/news/{news}/edit', [
        NewsController::class,
        'edit'
    ])
        ->middleware('permission:news.edit')
        ->name('news.edit');

    Route::put('/news/{news}', [
        NewsController::class,
        'update'
    ])
        ->middleware('permission:news.edit')
        ->name('news.update');

    Route::delete('/news/{news}', [
        NewsController::class,
        'destroy'
    ])
        ->middleware('permission:news.delete')
        ->name('news.destroy');

    Route::put('/news/{id}/status', [
        NewsController::class,
        'toggleStatus'
    ])
        ->middleware('permission:news.edit')
        ->name('news.status');


    /*
    |--------------------------------------------------------------------------
    | LANGUAGES
    |--------------------------------------------------------------------------
    |
    | Super Admin only
    |
    */

    Route::resource(
        'languages',
        LanguageController::class
    )->middleware('superadmin');

    Route::put('/languages/{id}/status', [
        LanguageController::class,
        'toggleStatus'
    ])
        ->middleware('superadmin')
        ->name('languages.status');


    /*
    |--------------------------------------------------------------------------
    | THEMES
    |--------------------------------------------------------------------------
    |
    | Super Admin only
    |
    */

    Route::resource(
        'themes',
        ThemeController::class
    )->middleware('superadmin');

    Route::put('/themes/{id}/status', [
        ThemeController::class,
        'toggleStatus'
    ])
        ->middleware('superadmin')
        ->name('themes.status');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN THEME STORE ENTRY
    |--------------------------------------------------------------------------
    |
    | Separate from /themes.
    |
    | /themes        = Theme CRUD
    | /admin/theme-store = Theme Store
    |
    */
Route::get('/admin/theme-store', [ThemeStoreController::class, 'index'])

    ->middleware('permission:theme_store.view')

    ->name('admin.theme-store.index');


    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    |
    | Admin + Super Admin
    |
    */

    Route::get('/users', [
        UserController::class,
        'index'
    ])
        ->middleware('permission:users.view')
        ->name('users.index');

    Route::get('/users/create', [
        UserController::class,
        'create'
    ])
        ->middleware('permission:users.create')
        ->name('users.create');

    Route::post('/users', [
        UserController::class,
        'store'
    ])
        ->middleware('permission:users.create')
        ->name('users.store');

    Route::get('/users/{user}', [
        UserController::class,
        'show'
    ])
        ->middleware('permission:users.view')
        ->name('users.show');

    Route::get('/users/{user}/edit', [
        UserController::class,
        'edit'
    ])
        ->middleware('permission:users.edit')
        ->name('users.edit');

    Route::put('/users/{user}', [
        UserController::class,
        'update'
    ])
        ->middleware('permission:users.edit')
        ->name('users.update');

    Route::delete('/users/{user}', [
        UserController::class,
        'destroy'
    ])
        ->middleware('permission:users.delete')
        ->name('users.destroy');

    Route::put('/users/{id}/status', [
        UserController::class,
        'toggleStatus'
    ])
        ->middleware('permission:users.edit')
        ->name('users.status');


    /*
    |--------------------------------------------------------------------------
    | USER PERMISSIONS
    |--------------------------------------------------------------------------
    */

    Route::get('/users/{user}/permissions', [
        UserController::class,
        'permissions'
    ])
        ->middleware('permission:users.edit')
        ->name('users.permissions');

    Route::put('/users/{user}/permissions', [
        UserController::class,
        'updatePermissions'
    ])
        ->middleware('permission:users.edit')
        ->name('users.permissions.update');


    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    |
    | Super Admin only
    |
    */

    Route::get('/settings', [
        SettingController::class,
        'index'
    ])
        ->middleware('superadmin')
        ->name('settings.index');

    Route::put('/settings', [
        SettingController::class,
        'update'
    ])
        ->middleware('superadmin')
        ->name('settings.update');


    /*
    |--------------------------------------------------------------------------
    | PAYMENTS
    |--------------------------------------------------------------------------
    |
    | Super Admin only
    |
    */

    Route::get('/payments', [
        PaymentController::class,
        'index'
    ])
        ->middleware('superadmin')
        ->name('payments.index');

});


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

