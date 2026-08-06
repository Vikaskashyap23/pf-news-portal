<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ThemeController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/websites/create', [WebsiteController::class, 'create']);

Route::resource('websites', WebsiteController::class);

Route::resource('categories', CategoryController::class);

Route::resource('news', NewsController::class);

Route::resource('languages', LanguageController::class);

Route::resource('themes',ThemeController::class);

Route::put('/themes/{id}/status', [ThemeController::class, 'toggleStatus'])
    ->name('themes.status');

Route::put('/languages/{id}/status', [LanguageController::class, 'toggleStatus'])
  ->name('languages.status');

Route::put('/news/{id}/status', [NewsController::class, 'toggleStatus'])
    ->name('news.status');


Route::get('/admin', function (){

    return view('admin.dashboard');

})->middleware('auth');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
