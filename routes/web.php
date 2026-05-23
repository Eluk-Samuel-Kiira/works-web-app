<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\ { WelcomeController };
use App\Http\Controllers\Jobs\ { JobController, JobCategoryController };
use App\Http\Controllers\Blog\ { BlogApiController };
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





// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    // Web view routes
    Route::get('/', [BlogApiController::class, 'blogIndex'])->name('index');
    Route::get('/{slug}', [BlogApiController::class, 'blogShow'])->name('show');
    Route::get('/category/{category}', [BlogApiController::class, 'blogCategory'])->name('category'); 
    Route::get('/tag/{tag}', [BlogApiController::class, 'blogTag'])->name('tag');
});

// API routes for AJAX (prefix with api)
Route::prefix('api/v2')->name('api.v2.')->group(function () {
    Route::get('/blogs', [BlogApiController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/featured', [BlogApiController::class, 'featured'])->name('blogs.featured');
    Route::get('/blogs/categories', [BlogApiController::class, 'categories'])->name('blogs.categories');
    Route::get('/blogs/related/{slug}', [BlogApiController::class, 'related'])->name('blogs.related');
    Route::get('/blogs/{slug}', [BlogApiController::class, 'show'])->name('blogs.show');
});




// Sitemaps for search engines
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


Route::get('/blog-sitemap.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/blog-sitemap.xml');

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


// authenticating routes 
use App\Http\Controllers\Auth\WebAuthController;
 
// Public — magic link landing
Route::get('/auth/magic/{token}', [WebAuthController::class, 'authenticate'])
    ->name('web.magic.authenticate');
 
// Public — logout
Route::post('/auth/logout', [WebAuthController::class, 'logout'])
    ->name('web.logout');
 
Route::get('/login-register', function () {
    return view('auth.login-register');
})->name('login.register');



use App\Http\Controllers\JS\ {
    DashboardController,
    CVController
};

// Protected routes — wrap with the middleware
Route::middleware('web.auth')->group(function () {
    // Seeker Dashboard
    Route::get('/dashboard', [DashboardController::class, 'seekerDashboard'])->name('seeker.dashboard');
});


// WEB APP: routes/web.php - Add this debug route temporarily

Route::middleware(['web.auth'])->get('/debug-session', function () {
    return response()->json([
        'has_web_user' => session()->has('web_user'),
        'has_api_token' => session()->has('api_token'),
        'web_user' => session('web_user'),
        'api_token_preview' => session('api_token') ? substr(session('api_token'), 0, 30) . '...' : null,
    ]);
});

require __DIR__.'/api.php';