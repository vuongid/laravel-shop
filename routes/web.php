<?php

use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.pages.dashboard.index');
});



// Route::prefix('admin')->group(function () {
//     Route::resource('slider', SliderController::class);
// });

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::resource('slider', SliderController::class);
});
