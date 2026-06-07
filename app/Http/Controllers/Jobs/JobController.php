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
        // Log::info("Country show request", ['country' => $country, 'slug' => $slug]);
        
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
     * ⭐ NEW: Country-specific jobs listing - handles /ke/jobs, /ug/jobs, /ng/jobs
     */
    public function countryIndex(Request $request, $country)
    {
        $mainAppUrl = $this->mainAppUrl;

        try {
            // Build query parameters with country filter
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
                'country'  => strtoupper($country), // Add country filter!
            ]);

            // Fetch jobs from MAIN APP with country filter
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-by-country', $params);

            if (!$response->successful()) {
                throw new \Exception('API request failed: ' . $response->status());
            }

            $data = $response->json();

            // Fetch popular searches (country-specific)
            $popularSearchesResponse = Http::withoutVerifying()
                ->timeout(10)
                ->get($mainAppUrl . '/v2/popular-searches', ['country' => strtoupper($country)]);

            $popularSearches = $popularSearchesResponse->successful()
                ? $popularSearchesResponse->json()
                : $this->getDefaultPopularSearches($country);

            // Fetch categories with job counts (country-specific)
            $categoriesResponse = Http::withoutVerifying()
                ->timeout(10)
                ->get($mainAppUrl . '/v2/job-by-category', ['country' => strtoupper($country)]);

            if ($categoriesResponse->successful()) {
                $cats = $categoriesResponse->json();
                $categories = isset($cats['data']) ? $cats['data'] : $cats;
            } else {
                $categories = [];
            }

            // Fetch featured jobs (country-specific)
            $featuredJobsResponse = Http::withoutVerifying()
                ->timeout(10)
                ->get($mainAppUrl . '/v2/featured-jobs', ['country' => strtoupper($country)]);

            $featuredJobs = $featuredJobsResponse->successful() 
                ? $featuredJobsResponse->json() 
                : [];

            if ($data) {
                if (isset($data['data'])) {
                    $jobs       = $data['data'];
                    $pagination = [
                        'current_page' => $data['current_page'] ?? 1,
                        'last_page'    => $data['last_page'] ?? 1,
                        'per_page'     => $data['per_page'] ?? count($jobs),
                        'total'        => $data['total'] ?? count($jobs),
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

                // Use a different view or reuse jobs.index with country data
                return view('jobs.country-index', compact(
                    'jobs', 'featuredJobs', 'pagination',
                    'popularSearches', 'totalJobs', 'categories', 'country'
                ));
            }

            throw new \Exception('API returned no data');

        } catch (\Exception $e) {
            Log::error("Error fetching jobs for country {$country}: " . $e->getMessage());

            $jobs            = [];
            $featuredJobs    = [];
            $totalJobs       = 0;
            $pagination      = ['current_page' => 1, 'last_page' => 1, 'per_page' => 0, 'total' => 0];
            $error           = 'Unable to fetch jobs at this time. Please try again later.';
            $popularSearches = $this->getDefaultPopularSearches($country);
            $categories      = [];

            return view('jobs.country-index', compact(
                'jobs', 'featuredJobs', 'pagination',
                'error', 'popularSearches', 'totalJobs', 'categories', 'country'
            ));
        }
    }

    /**
     * Country-specific category page - shows jobs filtered by category AND country
     * For URLs like: /ke/jobs/category/middle-management, /ug/jobs/category/technology
     */
    public function countryCategory(Request $request, $country, $slug)
    {
        $mainAppUrl = $this->mainAppUrl;
        
        try {
            // Build query parameters with country and category
            $params = array_filter([
                'page'     => $request->get('page', 1),
                'sort'     => $request->get('sort', 'newest'),
                'country'  => strtoupper($country),
                'category' => $slug,
            ]);
            
            // Fetch category-specific jobs filtered by country
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-by-category-country', $params);
            
            if (!$response->successful()) {
                throw new \Exception('API request failed: ' . $response->status());
            }
            
            $data = $response->json();
            
            // Get category data
            $categoryData = $data['category'] ?? [
                'name' => ucfirst(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'icon' => 'bi-briefcase',
                'description' => "Find {$country} jobs in this category",
            ];
            
            // Get all categories (may be cached)
            $allCategories = $this->getAllCategories($country);
            
            $jobs = $data['jobs']['data'] ?? [];
            $pagination = $data['jobs']['pagination'] ?? [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 18,
                'total' => 0,
            ];
            
            $totalJobs = $pagination['total'] ?? 0;
            
            // Country name for display
            $countryNames = [
                'ke' => 'Kenya',
                'ug' => 'Uganda',
                'ng' => 'Nigeria',
                'tz' => 'Tanzania',
                'rw' => 'Rwanda',
                'bi' => 'Burundi',
                'ss' => 'South Sudan',
                'za' => 'South Africa',
            ];
            $countryName = $countryNames[$country] ?? strtoupper($country);
            
            return view('jobs.country-category', compact(
                'jobs', 'pagination', 'categoryData', 'allCategories', 
                'totalJobs', 'country', 'countryName', 'slug'
            ));
            
        } catch (\Exception $e) {
            Log::error("Error fetching category {$slug} for country {$country}: " . $e->getMessage());
            
            $categoryData = [
                'name' => ucfirst(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'icon' => 'bi-briefcase',
            ];
            $jobs = [];
            $pagination = ['current_page' => 1, 'last_page' => 1, 'total' => 0];
            $totalJobs = 0;
            $allCategories = $this->getAllCategories($country);
            
            $countryNames = [
                'ke' => 'Kenya', 'ug' => 'Uganda', 'ng' => 'Nigeria',
                'tz' => 'Tanzania', 'rw' => 'Rwanda', 'bi' => 'Burundi',
                'ss' => 'South Sudan', 'za' => 'South Africa',
            ];
            $countryName = $countryNames[$country] ?? strtoupper($country);
            
            return view('jobs.country-category', compact(
                'jobs', 'pagination', 'categoryData', 'allCategories', 
                'totalJobs', 'country', 'countryName', 'slug'
            ));
        }
    }



    private function getAllCategories($country = null)
    {
        $mainAppUrl = $this->mainAppUrl;
        $cacheKey = $country ? "categories_{$country}" : "categories_all";
        
        // Debug: Log what country is being passed
        // \Log::info('getAllCategories called', [
        //     'country_param' => $country,
        //     'cache_key' => $cacheKey
        // ]);
        
        try {
            $params = $country ? ['country' => strtoupper($country)] : []; // Convert to uppercase
            
            \Log::info('Calling MAIN APP API', [
                'url' => $mainAppUrl . '/v2/job-categories',
                'params' => $params
            ]);
            
            $response = Cache::remember($cacheKey, now()->addHours(6), function () use ($mainAppUrl, $params) {
                $http = Http::withoutVerifying()->timeout(15);
                $resp = $http->get($mainAppUrl . '/v2/job-categories', $params);
                
                \Log::info('MAIN APP Response', [
                    'status' => $resp->status(),
                    'successful' => $resp->successful()
                ]);
                
                if ($resp->successful()) {
                    return $resp->json();
                }
                return null;
            });
            
            if ($response && is_array($response)) {
                if (isset($response['data']) && is_array($response['data'])) {
                    // \Log::info('Categories found (wrapped in data)', [
                    //     'country' => $country,
                    //     'count' => count($response['data'])
                    // ]);
                    return $response['data'];
                }
                
                if (isset($response[0]) && (isset($response[0]['id']) || isset($response[0]['name']))) {
                    // \Log::info('Categories found (direct array)', [
                    //     'country' => $country,
                    //     'count' => count($response)
                    // ]);
                    return $response;
                }
            }
            
            \Log::warning('No valid categories returned', [
                'country' => $country,
                'response' => $response
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error fetching categories for {$country}: " . $e->getMessage());
        }
        
        return [];
    }


    /**
     * Get fallback categories
     */
    private function getFallbackCategories($country = null)
    {
        return [
            ['id' => 1, 'name' => 'Accounting', 'slug' => 'accounting', 'icon' => 'bi-calculator', 'jobs_count' => 0],
            ['id' => 2, 'name' => 'Administration', 'slug' => 'administration', 'icon' => 'bi-person-workspace', 'jobs_count' => 0],
            ['id' => 3, 'name' => 'Healthcare', 'slug' => 'healthcare', 'icon' => 'bi-heart-pulse', 'jobs_count' => 0],
            ['id' => 4, 'name' => 'IT & Software', 'slug' => 'it-software', 'icon' => 'bi-code-square', 'jobs_count' => 0],
            ['id' => 5, 'name' => 'Management', 'slug' => 'management', 'icon' => 'bi-graph-up', 'jobs_count' => 0],
            ['id' => 6, 'name' => 'Sales & Marketing', 'slug' => 'sales-marketing', 'icon' => 'bi-megaphone', 'jobs_count' => 0],
            ['id' => 7, 'name' => 'Engineering', 'slug' => 'engineering', 'icon' => 'bi-gear', 'jobs_count' => 0],
            ['id' => 8, 'name' => 'Education', 'slug' => 'education', 'icon' => 'bi-book', 'jobs_count' => 0],
            ['id' => 9, 'name' => 'Hospitality', 'slug' => 'hospitality', 'icon' => 'bi-cup-straw', 'jobs_count' => 0],
            ['id' => 10, 'name' => 'Transport & Logistics', 'slug' => 'transport-logistics', 'icon' => 'bi-truck', 'jobs_count' => 0],
        ];
    }


    /**
     * Get default popular searches based on country
     */
    private function getDefaultPopularSearches($country)
    {
        $defaults = [
            'ke' => ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Remote', 'IT', 'Finance', 'Teaching'],
            'ug' => ['Kampala', 'Entebbe', 'Jinja', 'Gulu', 'Remote', 'NGO', 'Teaching', 'Healthcare'],
            'ng' => ['Lagos', 'Abuja', 'Port Harcourt', 'Ibadan', 'Remote', 'Oil & Gas', 'Banking', 'IT'],
            'tz' => ['Dar es Salaam', 'Arusha', 'Mwanza', 'Remote', 'Tourism', 'Agriculture'],
            'rw' => ['Kigali', 'Musanze', 'Remote', 'Tech', 'Hospitality'],
        ];
        
        return $defaults[$country] ?? ['Remote', 'Full Time', 'Part Time', 'Internship'];
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