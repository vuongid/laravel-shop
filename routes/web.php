<?php

use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ArticleController;
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
    Route::get('slider/change-status-{status}/{id}', [SliderController::class, 'status'])
        ->name('slider.status');

    // ================= ARTICLE CATEGORY =================
    Route::resource('articleCategory', ArticleCategoryController::class);
    Route::get('articleCategory/change-status-{status}/{id}', [ArticleCategoryController::class, 'status'])
        ->name('articleCategory.status');
    Route::get('articleCategory/move/{articleCategory}/{type}', [ArticleCategoryController::class, 'move'])
        ->name('articleCategory.move');
    Route::post('articleCategory/updateTree', [ArticleCategoryController::class, 'updateTree'])
        ->name('articleCategory.updateTree');

    // ================= ARTICLE =================
    Route::resource('article', ArticleController::class);
    Route::get('article/change-status-{status}/{id}', [ArticleController::class, 'status'])
        ->name('article.status');
});
