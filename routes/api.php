<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\WelcomeController;
use App\Http\Controllers\Blog\ { BlogApiController };



Route::post('/view/welcome', [WelcomeController::class, 'welcome']);
Route::post('/view/{view}', [WelcomeController::class, 'show']);

Route::prefix('v2')->name('api.v1.')->group(function () {
    // ... existing routes ...
    Route::get('/blogs',               [BlogApiController::class, 'index']);
    Route::get('/blogs/featured',      [BlogApiController::class, 'featured']);
    Route::get('/blogs/categories',    [BlogApiController::class, 'categories']);
    Route::get('/blogs/related/{slug}',[BlogApiController::class, 'related']);
    Route::get('/blogs/{slug}',        [BlogApiController::class, 'show']);
});





