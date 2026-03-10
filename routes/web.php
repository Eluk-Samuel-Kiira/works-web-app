<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\ { WelcomeController };
use App\Http\Controllers\Jobs\ { JobController };


Route::get('/', [WelcomeController::class, 'index'])->name('home.welcome');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

// Fallback Route (404)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


require __DIR__.'/api.php';