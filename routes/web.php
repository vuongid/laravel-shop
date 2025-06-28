<?php

use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ArticleTagController;
use App\Http\Controllers\Admin\SlugController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.pages.dashboard.index');
});



// Route::prefix('admin')->group(function () {
//     Route::resource('slider', SliderController::class);
// });

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    // ================= SLIDER =================
    Route::resource('slider', SliderController::class);
    // Route::get('slider/change-status-{status}/{id}', [SliderController::class, 'status'])->name('slider.status');
    Route::post('slider/{id}/toggleStatus', [SliderController::class, 'toggleStatus'])->name('slider.toggleStatus');

    // ================= ARTICLE CATEGORY =================
    Route::resource('articleCategory', ArticleCategoryController::class);
    Route::post('articleCategory/{id}/toggleStatus', [ArticleCategoryController::class, 'toggleStatus'])->name('articleCategory.toggleStatus');
    Route::get('articleCategory/move/{articleCategory}/{type}', [ArticleCategoryController::class, 'move'])->name('articleCategory.move');
    Route::post('articleCategory/updateTree', [ArticleCategoryController::class, 'updateTree'])->name('articleCategory.updateTree');

    // ================= ARTICLE =================
    Route::resource('article', ArticleController::class);
    Route::post('article/{id}/toggleStatus', [ArticleController::class, 'toggleStatus'])->name('article.toggleStatus');

    // ================= TAG =================
    Route::resource('tag', TagController::class);
    Route::get('tag/change-status-{status}/{id}', [TagController::class, 'status'])
        ->name('tag.status');

    // ================= TAG =================
    Route::resource('articleTag', ArticleTagController::class);

    // =================  =================
    Route::get('/slug/generate', [SlugController::class, 'generate'])->name('slug.generate');

    // ================= Auth =================
    Route::get('auth/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::post('auth/profile', [AuthController::class, 'postProfile'])->name('auth.postProfile');
    Route::get('auth/changePassword', [AuthController::class, 'changePassword'])->name('auth.changePassword');
});

Route::get('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/register', [AuthController::class, 'postRegister'])->name('auth.postRegister');
Route::get('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/login', [AuthController::class, 'postLogin'])->name('auth.postLogin');
