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

Route::get('/coming-soon', function () {
    return view('jobs.coming-soon');
})->name('coming-soon');

Route::get('/sitemap.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        Log::warning('Sitemap proxy failed: HTTP ' . $response->status());
        abort(404);

    } catch (\Exception $e) {
        Log::error('Sitemap proxy error: ' . $e->getMessage());
        abort(404);
    }
});



// Fallback Route (404)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});



require __DIR__.'/api.php';