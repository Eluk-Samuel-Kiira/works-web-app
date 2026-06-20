<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\ { WelcomeController };
use App\Http\Controllers\Jobs\ { JobController, JobCategoryController };
use App\Http\Controllers\Blog\ { BlogApiController };
use Illuminate\Support\Facades\Http;



// Ads
Route::get('/ads.txt', function () {
    $content = "ezoic.com, 19390, DIRECT\n";
    $content .= "google.com, pub-3587587638253109, DIRECT, f08c47fec0942fa0\n";
    
    return response($content, 200)
        ->header('Content-Type', 'text/plain');
});

// =============================================
// COUNTRY ROOT REDIRECTS (must be first!)
// =============================================
// Redirect /ke, /ug, /ng to homepage
Route::get('/{country}', function ($country) {
    $validCountries = ['ke', 'ug', 'ng'];
    
    if (in_array($country, $validCountries)) {
        // Permanent redirect (301) for SEO
        return redirect('/', 301);
    }
    
    abort(404);
})->whereIn('country', ['ke', 'ug', 'ng']);

// =============================================
// MAIN ROUTES
// =============================================
Route::get('/', [WelcomeController::class, 'index'])->name('home.welcome');

// Job routes (without country prefix)
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/jobs/id/{id}', [JobController::class, 'showById'])->name('jobs.show.id');

// =============================================
// COUNTRY-SPECIFIC JOB ROUTES
// =============================================
Route::prefix('{country}')->whereIn('country', ['ke', 'ug', 'ng'])->group(function () {
    // Country-specific jobs listing
    Route::get('/jobs', [JobController::class, 'countryIndex'])->name('jobs.country.index');
    
    // Country-specific job detail (slug already contains country suffix)
    Route::get('/jobs/{slug}', [JobController::class, 'countryShow'])->name('jobs.country.show');

    // specific categories 
    Route::get('/jobs/category/{slug}', [JobController::class, 'countryCategory'])->name('jobs.country.category');
    
    // Country-specific location pages (if needed)
    Route::get('/jobs/location/{slug}', [JobController::class, 'countryLocation'])->name('jobs.country.location');

    Route::get('/companies', [JobCategoryController::class, 'countryCompanies'])->name('jobs.country.companies');
    Route::get('/jobs/company/{slug}', [JobCategoryController::class, 'countryCompanyJobs'])->name('jobs.country.company');

    Route::get('/jobs/location/{slug}', [JobCategoryController::class, 'countryLocation'])->name('jobs.country.location');
});


// Category landing pages
Route::get('/jobs/category/{slug}', [JobCategoryController::class, 'category'])->name('jobs.category');























Route::get('/coming-soon', function () {
    return view('jobs.coming-soon');
})->name('coming-soon');


// Pricing Tags 
Route::get('/post-featured-jobs', function () {
    return view('employer.feature-jobs');
})->name('featured.addons');

Route::get('/job-seeker-cv-pricing', function () {
    return view('home.cv-charge');
})->name('home.cv-charge');


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
    $validated = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email',
        'subject' => 'nullable|string|max:200',
        'message' => 'required|string|min:10|max:2000',
    ]);

    // Get MAIN API URL from config
    $mainApiBase = rtrim(config('api.main_app.api_base'), '/');
    
    // Send to MAIN API - it will handle storage and email
    try {
        $response = Http::timeout(30)
            ->post($mainApiBase . '/v1/contact', $validated);
        
        if ($response->successful()) {
            \Log::info('Contact form sent to MAIN API', [
                'email' => $validated['email'],
                'response' => $response->json()
            ]);
            
            return back()->with('success', 'Thank you! We will get back to you within 24 hours.');
        } else {
            \Log::warning('Contact form MAIN API failed', [
                'email' => $validated['email'],
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            
            return back()->with('error', 'Unable to send message. Please try again later.');
        }
    } catch (\Exception $e) {
        \Log::error('Contact form API error', [
            'email' => $validated['email'],
            'error' => $e->getMessage()
        ]);
        
        return back()->with('error', 'Unable to send message. Please try again later.');
    }
})->name('contact.send');


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
require __DIR__.'/payment.php';
require __DIR__.'/sitemaps.php';