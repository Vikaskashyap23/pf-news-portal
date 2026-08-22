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
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\WebsiteController as FrontendWebsiteController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;

// =====================================================
// PUBLIC ROUTES
// =====================================================

Route::get('/', [HomeController::class, 'index'])
    ->name('frontend.home');


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

    return view('admin.dashboard');

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
});


// =====================================================
// AUTH ROUTES
// =====================================================

require __DIR__.'/auth.php';