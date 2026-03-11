<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\ { WelcomeController };
use App\Http\Controllers\Jobs\ { JobController };
use Illuminate\Support\Facades\Http;


Route::get('/', [WelcomeController::class, 'index'])->name('home.welcome');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');

// Both routes work - one for slug, one for ID as fallback
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/jobs/id/{id}', [JobController::class, 'showById'])->name('jobs.show.id');


// Fallback Route (404)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});



require __DIR__.'/api.php';