<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ { Log, Http, Cache };
use App\Services\StructuredDataService;

class JobController extends Controller
{
    private $mainAppUrl;
    
    public function __construct()
    {
        $this->mainAppUrl = rtrim(config('api.main_app.api_base'), '/');
    }
    
    /**
     * Display the jobs listing page.
     */
    public function index(Request $request)
    {
        $mainAppUrl = $this->mainAppUrl;

        try {
            // Build query parameters
            $params = array_filter([
                'page'     => $request->get('page', 1),
                'sort'     => $request->get('sort'),
                'keyword'  => $request->get('keyword'),
                'location' => $request->get('location'),
                'category' => $request->get('category'),
                'company'  => $request->get('company'),   
                'industry' => $request->get('industry'),  
                'featured' => $request->get('featured'),  
                'type'     => $request->get('type'),
            ]);

            // Fetch jobs directly from MAIN APP
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-data-from-main', $params);

            if (!$response->successful()) {
                throw new \Exception('API request failed: ' . $response->status());
            }

            $data = $response->json();

            // Fetch popular searches
            $popularSearchesResponse = Http::withoutVerifying()
                ->timeout(10)
                ->get($mainAppUrl . '/v2/popular-searches');

            $popularSearches = $popularSearchesResponse->successful()
                ? $popularSearchesResponse->json()
                : ['Remote', 'NGO', 'Finance', 'Health', 'Education', 'Manager'];

            // Fetch categories with job counts
            $categoriesResponse = Http::withoutVerifying()
                ->timeout(10)
                ->get($mainAppUrl . '/v2/job-by-category');

            if ($categoriesResponse->successful()) {
                $cats = $categoriesResponse->json();
                $categories = isset($cats['data']) ? $cats['data'] : $cats;
            } else {
                $categories = [];
            }

            // Fetch featured jobs
            $featuredJobs = $this->getFeaturedJobs();

            if ($data) {
                if (isset($data['data'])) {
                    $jobs       = $data['data'];
                    $pagination = [
                        'current_page' => $data['current_page'],
                        'last_page'    => $data['last_page'],
                        'per_page'     => $data['per_page'],
                        'total'        => $data['total'],
                    ];
                } else {
                    $jobs       = $data;
                    $pagination = [
                        'current_page' => 1,
                        'last_page'    => 1,
                        'per_page'     => count($jobs),
                        'total'        => count($jobs),
                    ];
                }

                $totalJobs = $pagination['total'];

                return view('jobs.index', compact(
                    'jobs', 'featuredJobs', 'pagination',
                    'popularSearches', 'totalJobs', 'categories'
                ));
            }

            throw new \Exception('API returned no data');

        } catch (\Exception $e) {
            Log::error('Error fetching jobs: ' . $e->getMessage());

            $jobs            = [];
            $featuredJobs    = [];
            $totalJobs       = 0;
            $pagination      = ['current_page' => 1, 'last_page' => 1, 'per_page' => 0, 'total' => 0];
            $error           = 'Unable to fetch jobs at this time. Please try again later.';
            $popularSearches = ['Remote', 'NGO', 'Finance', 'Health', 'Education', 'Manager'];
            $categories      = [];

            return view('jobs.index', compact(
                'jobs', 'featuredJobs', 'pagination',
                'error', 'popularSearches', 'totalJobs', 'categories'
            ));
        }
    }

    /**
     * ⭐ NEW: Country-specific show - handles /ke/jobs/{slug}, /ug/jobs/{slug}, etc.
     */
    public function countryShow(Request $request, $country, $slug)
    {
        $mainAppUrl = $this->mainAppUrl;
        
        // Log for debugging
        Log::info("Country show request", ['country' => $country, 'slug' => $slug]);
        
        try {
            // Cache individual job for 10 minutes
            $cachedData = Cache::remember("job_{$slug}", now()->addMinutes(10), function () use ($mainAppUrl, $slug) {
                $response = Http::withoutVerifying()->timeout(30)
                    ->get($mainAppUrl . '/v2/jobs-data-from-main/' . $slug);

                return [
                    'status' => $response->status(),
                    'data'   => $response->successful() ? $response->json() : null,
                ];
            });

            // Hard 404 — job truly does not exist
            if ($cachedData['status'] === 404 || !$cachedData['data']) {
                Cache::forget("job_{$slug}");
                abort(404, 'Job not found');
            }

            $job = $cachedData['data'];

            if (empty($job['job_title'])) {
                Log::error('Invalid job data', ['slug' => $slug, 'data' => $job]);
                abort(404, 'Job not found');
            }

            // Verify job belongs to this country (optional - good for SEO)
            $jobCountry = isset($job['job_location']['country']) 
                ? strtolower($job['job_location']['country']) 
                : null;
            
            $requestedCountry = strtolower($country);
            
            if ($jobCountry && $jobCountry !== $requestedCountry) {
                // Wrong country - redirect to correct country URL
                $correctSlug = $slug;
                $correctCountry = $jobCountry;
                Log::info("Redirecting to correct country", [
                    'from' => $requestedCountry, 
                    'to' => $correctCountry,
                    'slug' => $slug
                ]);
                return redirect()->away(url("/{$correctCountry}/jobs/{$slug}"), 301);
            }

            $similarJobs    = $job['similar_jobs'] ?? [];
            $structuredData = app(StructuredDataService::class)->jobPosting($job);

            // Return view with country context
            return response(view('jobs.show', compact('job', 'similarJobs', 'structuredData')));

        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage(), [
                'slug'  => $slug,
                'trace' => $e->getTraceAsString(),
            ]);
            abort(404, 'Job not found');
        }
    }
    
    /**
     * Original show method - also handles redirect to country URL if slug has suffix
     */
    public function show(Request $request, $slug)
    {
        $mainAppUrl = $this->mainAppUrl;
        
        // Check if slug has country suffix and redirect to country-prefixed URL
        $suffixes = ['-ke', '-tz', '-rw', '-ug', '-ng', '-za', '-bi', '-ss'];
        foreach ($suffixes as $suffix) {
            if (str_ends_with($slug, $suffix)) {
                $countryCode = ltrim($suffix, '-');
                Log::info("Redirecting slug with suffix to country URL", [
                    'old_slug' => $slug,
                    'country' => $countryCode,
                    'new_url' => url("/{$countryCode}/jobs/{$slug}")
                ]);
                return redirect()->away(url("/{$countryCode}/jobs/{$slug}"), 301);
            }
        }

        try {
            // Cache individual job for 10 minutes
            $cachedData = Cache::remember("job_{$slug}", now()->addMinutes(10), function () use ($mainAppUrl, $slug) {
                $response = Http::withoutVerifying()->timeout(30)
                    ->get($mainAppUrl . '/v2/jobs-data-from-main/' . $slug);

                return [
                    'status' => $response->status(),
                    'data'   => $response->successful() ? $response->json() : null,
                ];
            });

            // Hard 404 — job truly does not exist
            if ($cachedData['status'] === 404 || !$cachedData['data']) {
                Cache::forget("job_{$slug}");
                abort(404, 'Job not found');
            }

            $job = $cachedData['data'];

            if (empty($job['job_title'])) {
                Log::error('Invalid job data', ['slug' => $slug, 'data' => $job]);
                abort(404, 'Job not found');
            }

            $similarJobs    = $job['similar_jobs'] ?? [];
            $structuredData = app(StructuredDataService::class)->jobPosting($job);

            return response(view('jobs.show', compact('job', 'similarJobs', 'structuredData')));

        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage(), [
                'slug'  => $slug,
                'trace' => $e->getTraceAsString(),
            ]);
            abort(404, 'Job not found');
        }
    }
    
    /**
     * Get featured jobs
     */
    private function getFeaturedJobs()
    {
        $mainAppUrl = $this->mainAppUrl;
        
        try {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-data-from-main/featured');
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Exception fetching featured jobs: ' . $e->getMessage());
        }
        
        return [];
    }
    
    /**
     * Search jobs
     */
    public function search(Request $request)
    {
        return redirect()->route('jobs.index', $request->query());
    }
}