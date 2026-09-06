<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ThemeController as FrontendThemeController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\WebsiteController as FrontendWebsiteController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\ThemePaymentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DomainController;
use App\Models\User;
use App\Models\Website;
use App\Models\News;
use App\Models\Category;

// =====================================================
// PUBLIC ROUTES
// =====================================================

Route::get('/', [HomeController::class, 'index'])
    ->name('frontend.home');


 Route::get('/theme-store/{websiteSlug}', [FrontendThemeController::class, 'index'])
    ->name('frontend.themes');   


Route::get('/category/{categorySlug}', [FrontendCategoryController::class, 'domainShow'])
    ->name('frontend.domain.category');


Route::get('/search', [FrontendWebsiteController::class, 'domainSearch'])
    ->name('frontend.domain.search');



Route::get('/language/{locale}', function ($locale) {

    if (!in_array($locale, ['en', 'hi', 'mr'])) {
        abort(404);
    }

    abort_unless(
        app()->bound('currentWebsite'),
        404
    );

    $website = app('currentWebsite');

    abort_unless(
        $website->status,
        404
    );

    session(['locale' => $locale]);

    return redirect()->to(
        frontend_home_url()
    );

})->name('frontend.domain.language');




// =====================================================
// THEME PAYMENT
// =====================================================

Route::get(
    '/theme-store/{websiteSlug}/buy/{themeId}',
    [ThemePaymentController::class, 'checkout']
)->name('frontend.themes.checkout');


Route::post(
    '/theme-store/{websiteSlug}/buy/{themeId}',
    [ThemePaymentController::class, 'startPayment']
)->name('frontend.themes.start-payment');

Route::post(
    '/theme-store/payment/success',
    [ThemePaymentController::class, 'success']
)->name('frontend.themes.payment.success');

Route::get(
    '/theme-store/{websiteSlug}/payment-failed',
    [ThemePaymentController::class, 'failed']
)->name('frontend.themes.payment.failed');




    Route::get('/theme-store/{websiteSlug}/preview/{themeId}', 
    [\App\Http\Controllers\Frontend\ThemeController::class, 'preview']
    )->name('frontend.themes.preview');


    Route::post('/theme-store/{websiteSlug}/activate/{themeId}', [FrontendThemeController::class, 'activate'])
    ->name('frontend.themes.activate');


Route::get('/site/{slug}', [FrontendWebsiteController::class, 'show'])
    ->name('frontend.website');

Route::get('/site/{websiteSlug}/category/{categorySlug}', [FrontendCategoryController::class, 'show'])
    ->name('frontend.category');

Route::get('/site/{websiteSlug}/news/{newsSlug}', [FrontendNewsController::class, 'show'])
  ->name('frontend.news');

Route::get('/site/{slug}/search', [FrontendWebsiteController::class, 'search'])
         ->name('frontend.search');


 Route::get('/site/{websiteSlug}/language/{locale}', function ($websiteSlug, $locale) {

       if (!in_array($locale, ['en', 'hi' , 'mr'])) {

        abort(404);

       }

       session(['locale' => $locale]);

       return redirect()->route('frontend.website',[

        'slug'  => $websiteSlug

       ]);

    })->name('language.switch');  


  
// =====================================================
// WEBSITES
// =====================================================

Route::get('/websites/create', [WebsiteController::class, 'create']);

Route::resource('websites', WebsiteController::class);



Route::post(
            '/websites/{website}/domains/{domain}/verify',
           [\App\Http\Controllers\Admin\DomainController::class, 'verify']
            )->name('admin.websites.domains.verify');


// =====================================================
// WEBSITE DOMAINS
// =====================================================

Route::prefix('websites/{website}/domains')
    ->name('admin.websites.domains.')
    ->group(function () {

        Route::get('/', [DomainController::class, 'index'])
            ->name('index');

        Route::get('/create', [DomainController::class, 'create'])
            ->name('create');

        Route::post('/', [DomainController::class, 'store'])
            ->name('store');

        Route::get('/{domain}/edit', [DomainController::class, 'edit'])
            ->name('edit');

        Route::put('/{domain}', [DomainController::class, 'update'])
            ->name('update');

        



        Route::delete('/{domain}', [DomainController::class, 'destroy'])
            ->name('destroy');
    });


// =====================================================
// CATEGORIES
// =====================================================

Route::resource('categories', CategoryController::class);


// =====================================================
// NEWS - HYBRID PERMISSION CONTROL
// =====================================================

Route::get('/news', [NewsController::class, 'index'])
    ->middleware('permission:news.view')
    ->name('news.index');

Route::get('/news/create', [NewsController::class, 'create'])
    ->middleware('permission:news.create')
    ->name('news.create');

Route::post('/news', [NewsController::class, 'store'])
    ->middleware('permission:news.create')
    ->name('news.store');

Route::get('/news/{news}', [NewsController::class, 'show'])
    ->whereNumber('news')
    ->middleware('permission:news.view')
    ->name('news.show');

Route::get('/news/{news}/edit', [NewsController::class, 'edit'])
    ->middleware('permission:news.edit')
    ->name('news.edit');

Route::put('/news/{news}', [NewsController::class, 'update'])
    ->middleware('permission:news.edit')
    ->name('news.update');

Route::delete('/news/{news}', [NewsController::class, 'destroy'])
    ->middleware('permission:news.delete')
    ->name('news.destroy');

Route::put('/news/{id}/status', [NewsController::class, 'toggleStatus'])
    ->middleware('permission:news.edit')
    ->name('news.status');

    Route::get('/users/{user}/permissions', [UserController::class, 'permissions'])
    ->name('users.permissions');

Route::put('/users/{user}/permissions', [UserController::class, 'updatePermissions'])
    ->name('users.permissions.update');

Route::get('/news/{newsSlug}', [FrontendNewsController::class, 'domainShow'])
    ->name('frontend.domain.news');

// =====================================================
// LANGUAGES
// =====================================================

Route::resource('languages', LanguageController::class);


// =====================================================
// THEMES
// =====================================================

Route::resource('themes', ThemeController::class);


// =====================================================
// USERS
// =====================================================

// =====================================================
// USERS - HYBRID PERMISSION CONTROL
// =====================================================

Route::get('/users', [UserController::class, 'index'])
    ->middleware('permission:users.view')
    ->name('users.index');

Route::get('/users/create', [UserController::class, 'create'])
    ->middleware('permission:users.create')
    ->name('users.create');

Route::post('/users', [UserController::class, 'store'])
    ->middleware('permission:users.create')
    ->name('users.store');

Route::get('/users/{user}', [UserController::class, 'show'])
    ->middleware('permission:users.view')
    ->name('users.show');

Route::get('/users/{user}/edit', [UserController::class, 'edit'])
    ->middleware('permission:users.edit')
    ->name('users.edit');

Route::put('/users/{user}', [UserController::class, 'update'])
    ->middleware('permission:users.edit')
    ->name('users.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware('permission:users.delete')
    ->name('users.destroy');

Route::put('/users/{id}/status', [UserController::class, 'toggleStatus'])
    ->middleware('permission:users.edit')
    ->name('users.status');


// -----------------------------------------------------
// USER PER-USER PERMISSION OVERRIDES
// -----------------------------------------------------

Route::get('/users/{user}/permissions', [UserController::class, 'permissions'])
    ->middleware('permission:users.edit')
    ->name('users.permissions');

Route::put('/users/{user}/permissions', [UserController::class, 'updatePermissions'])
    ->middleware('permission:users.edit')
    ->name('users.permissions.update');







// =====================================================
// SETTINGS
// =====================================================

Route::get('/settings', [SettingController::class, 'index'])
    ->name('settings.index');

Route::put('/settings', [SettingController::class, 'update'])
    ->name('settings.update');


// =====================================================
// OTHER STATUS ROUTES
// =====================================================

Route::put('/themes/{id}/status', [ThemeController::class, 'toggleStatus'])
    ->name('themes.status');

Route::put('/languages/{id}/status', [LanguageController::class, 'toggleStatus'])
    ->name('languages.status');


// =====================================================
// ADMIN DASHBOARD
// =====================================================

Route::get('/admin', function () {

      $totalUsers = User::count();

      $totalSuperAdmins = User::where('role', 'super_admin')->count();

      $totalAdmins = User::where('role', 'admin')->count();

      $totalEditors = User::where('role', 'editor')->count();

      $totalWebsites = Website::count();

      $totalNews = News::count();

      $totalCategories = Category::count();


    return view('admin.dashboard', compact(

         'totalUsers',
         'totalSuperAdmins',
         'totalAdmins',
         'totalEditors',
         'totalWebsites',
         'totalNews',
         'totalCategories'

    ));

})->middleware(['auth', 'admin']);


// =====================================================
// USER DASHBOARD
// =====================================================

Route::get('/dashboard', function () {

    return view('dashboard');

})->middleware(['auth', 'verified'])
  ->name('dashboard');


// =====================================================
// PROFILE
// =====================================================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


        
Route::get('/payments', [PaymentController::class, 'index'])
    ->name('payments.index');

});


// =====================================================
// AUTH ROUTES
// =====================================================

require __DIR__.'/auth.php';