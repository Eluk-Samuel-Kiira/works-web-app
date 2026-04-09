<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\ { WelcomeController };
use App\Http\Controllers\Jobs\ { JobController, JobCategoryController };
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

// ads.txt for Google AdSense
Route::get('/ads.txt', function () {
    $content = "google.com, pub-3587587638253109, DIRECT, f08c47fec0942fa0\n";
    return response($content, 200)->header('Content-Type', 'text/plain');
});


use App\Http\Controllers\Admin\ArtisanCommandController;

Route::get('/admin/artisan', [ArtisanCommandController::class, 'index']);
Route::post('/admin/command-run', [ArtisanCommandController::class, 'run']);

Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))->name('privacy-policy');
Route::get('/about',          fn() => view('pages.about'))->name('about');
Route::get('/contact',        fn() => view('pages.contact'))->name('contact');
Route::get('/terms-of-service', fn() => view('pages.terms'))->name('terms-of-service');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email',
        'subject' => 'nullable|string',
        'message' => 'required|string|min:10|max:2000',
    ]);

    // Log it for now — add Mail::to() when you set up email
    \Log::info('Contact form submission', $request->only(['name', 'email', 'subject', 'message']));

    return back()->with('success', 'Thank you! We will get back to you within 24 hours.');
})->name('contact.send');


// Category landing pages
Route::get('/jobs/category/{slug}', [JobCategoryController::class, 'category'])->name('jobs.category');

// Industry landing pages  
Route::get('/jobs/industry/{slug}', [JobCategoryController::class, 'industry'])->name('jobs.industry');

// Location landing pages
Route::get('/jobs/location/{slug}', [JobCategoryController::class, 'location'])->name('jobs.location');

// Companies directory
Route::get('/companies', [JobCategoryController::class, 'companies'])->name('companies');
Route::get('/companies/{slug}', [JobCategoryController::class, 'company'])->name('companies.show');



// Fallback Route (404)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});



require __DIR__.'/api.php';