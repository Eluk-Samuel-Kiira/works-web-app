<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ { Log, Artisan, Http, Cache };

class JobCategoryController extends Controller
{
    private $mainAppUrl;
    
    public function __construct()
    {
        $this->mainAppUrl = rtrim(config('api.main_app.api_base'), '/');
    }

    /**
     * Category landing page — /jobs/category/ngo
     */
    public function category(Request $request, $slug)
    {
        $mainAppUrl = config('api.main_app.api_base');

        // Get category info + jobs in parallel using cache
        $categoryData = Cache::remember("category_{$slug}", now()->addMinutes(10), function () use ($mainAppUrl, $slug) {
            $cat = Http::withoutVerifying()->timeout(15)
                ->get($mainAppUrl . '/v2/job-by-category', ['slug' => $slug, 'with_count' => true]);
            return $cat->successful() ? collect($cat->json())->firstWhere('slug', $slug) : null;
        });

        if (!$categoryData) {
            abort(404);
        }

        $params = array_filter([
            'category' => $slug,
            'page'     => $request->get('page', 1),
            'sort'     => $request->get('sort', 'newest'),
        ]);

        $cacheKey = "jobs_category_{$slug}_page_" . $request->get('page', 1);
        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($mainAppUrl, $params) {
            $response = Http::withoutVerifying()->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-data-from-main', $params);
            return $response->successful() ? $response->json() : null;
        });

        $jobs = $data['data'] ?? [];
        $pagination = [
            'current_page' => $data['current_page'] ?? 1,
            'last_page'    => $data['last_page'] ?? 1,
            'per_page'     => $data['per_page'] ?? 20,
            'total'        => $data['total'] ?? 0,
        ];

        // Get all categories for sidebar dropdown
        $allCategories = Cache::remember('all_categories', now()->addMinutes(30), function () use ($mainAppUrl) {
            $response = Http::withoutVerifying()->timeout(10)
                ->get($mainAppUrl . '/v2/job-by-category');
            if ($response->successful()) {
                $cats = $response->json();
                $cats = isset($cats['data']) ? $cats['data'] : $cats;
                return collect($cats)
                    ->filter(fn($c) => is_array($c) && !empty($c['slug']) && ($c['jobs_count'] ?? 0) > 0)
                    ->sortByDesc('jobs_count')
                    ->values()
                    ->toArray();
            }
            return [];
        });

        return view('jobs.category', compact('jobs', 'pagination', 'categoryData', 'allCategories'));
    }

    /**
     * Industry landing page — /jobs/industry/ngo
     */
    public function industry(Request $request, $slug)
    {
        $mainAppUrl = config('api.main_app.api_base');

        $industryData = Cache::remember("industry_{$slug}", now()->addMinutes(10), function () use ($mainAppUrl, $slug) {
            $res = Http::withoutVerifying()->timeout(15)
                ->get($mainAppUrl . '/v1/industries', ['slug' => $slug]);
            return $res->successful() ? collect($res->json())->firstWhere('slug', $slug) : null;
        });

        if (!$industryData) {
            abort(404);
        }

        $params = array_filter([
            'industry' => $slug,
            'page'     => $request->get('page', 1),
            'sort'     => $request->get('sort', 'newest'),
        ]);

        $data = Cache::remember("jobs_industry_{$slug}_page_" . $request->get('page', 1), now()->addMinutes(5), function () use ($mainAppUrl, $params) {
            $response = Http::withoutVerifying()->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-data-from-main', $params);
            return $response->successful() ? $response->json() : null;
        });

        $jobs = $data['data'] ?? [];
        $pagination = [
            'current_page' => $data['current_page'] ?? 1,
            'last_page'    => $data['last_page'] ?? 1,
            'per_page'     => $data['per_page'] ?? 20,
            'total'        => $data['total'] ?? 0,
        ];

        $allIndustries = Cache::remember('all_industries', now()->addHour(), function () use ($mainAppUrl) {
            $response = Http::withoutVerifying()->timeout(10)
                ->get($mainAppUrl . '/v1/industries');
            return $response->successful() ? $response->json() : [];
        });

        return view('jobs.industry', compact('jobs', 'pagination', 'industryData', 'allIndustries'));
    }

    /**
     * Companies directory — /companies
     */
    public function companies(Request $request)
    {
        $mainAppUrl = config('api.main_app.api_base');

        $page   = $request->get('page', 1);
        $search = $request->get('search', '');

        // Don't cache search results — only cache the default first page
        $cacheKey = $search ? null : 'companies_directory_page_' . $page;

        $fetch = function () use ($mainAppUrl, $page, $search) {
            $response = Http::withoutVerifying()->timeout(15)
                ->get($mainAppUrl . '/v2/company-jobs', array_filter([
                    'page'          => $page,
                    'per_page'      => 24,
                    'with_jobs_only'=> true,
                    'search'        => $search ?: null,
                ]));
            return $response->successful()
                ? $response->json()
                : ['data' => [], 'total' => 0, 'current_page' => 1, 'last_page' => 1];
        };

        $result = $cacheKey
            ? Cache::remember($cacheKey, now()->addMinutes(15), $fetch)
            : $fetch();

        $companies = $result['data'] ?? [];
        // \Log::info($companies);
        $pagination = [
            'current_page' => $result['current_page'] ?? 1,
            'last_page'    => $result['last_page']    ?? 1,
            'total'        => $result['total']        ?? 0,
        ];

        return view('jobs.companies', compact('companies', 'pagination', 'search'));
    }

    
    /**
     * Country-specific companies directory
     * URL: /ke/companies, /ug/companies, /ng/companies
     */
    public function countryCompanies(Request $request, $country)
    {
        $mainAppUrl = config('api.main_app.api_base');
        
        $page   = $request->get('page', 1);
        $search = $request->get('search', '');
        
        $cacheKey = $search ? null : "companies_{$country}_page_" . $page;
        
        $fetch = function () use ($mainAppUrl, $page, $search, $country) {
            $response = Http::withoutVerifying()->timeout(15)
                ->get($mainAppUrl . '/v2/company-jobs-by-country', array_filter([
                    'page'          => $page,
                    'per_page'      => 24,
                    'search'        => $search ?: null,
                    'country'       => strtoupper($country),
                ]));
            
            return $response->successful()
                ? $response->json()
                : ['data' => [], 'total' => 0, 'current_page' => 1, 'last_page' => 1];
        };
        
        $result = $cacheKey
            ? Cache::remember($cacheKey, now()->addMinutes(15), $fetch)
            : $fetch();
        
        $companies = $result['data'] ?? [];
        $pagination = [
            'current_page' => $result['current_page'] ?? 1,
            'last_page'    => $result['last_page'] ?? 1,
            'total'        => $result['total'] ?? 0,
        ];
        
        $countryNames = [
            'ke' => 'Kenya', 'ug' => 'Uganda', 'ng' => 'Nigeria',
        ];
        $countryName = $countryNames[$country] ?? strtoupper($country);
        
        return view('jobs.country-companies', compact('companies', 'pagination', 'search', 'country', 'countryName'));
    }


    /**
     * Country-specific company detail page with jobs
     * URL: /ke/jobs/company/company-slug
     */
    public function countryCompanyJobs(Request $request, $country, $slug)
    {
        $mainAppUrl = config('api.main_app.api_base');
        
        try {
            // Fetch company details and jobs
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->get($mainAppUrl . '/v2/company/' . $slug, [
                    'country' => strtoupper($country)
                ]);
            
            if (!$response->successful()) {
                abort(404, 'Company not found');
            }
            
            $data = $response->json();
            $company = $data['company'] ?? [];
            $similarCompanies = $data['similar_companies'] ?? [];
            $jobs = $data['jobs']['data'] ?? [];
            $pagination = $data['jobs']['pagination'] ?? [
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ];
            
            if (empty($company)) {
                abort(404, 'Company not found');
            }
            
            $countryNames = [
                'ke' => 'Kenya', 'ug' => 'Uganda', 'ng' => 'Nigeria',
            ];
            $countryName = $countryNames[$country] ?? strtoupper($country);
            
            return view('jobs.country-company-jobs', compact(
                'company', 'similarCompanies', 'jobs', 'pagination', 
                'country', 'countryName', 'slug'
            ));
            
        } catch (\Exception $e) {
            Log::error("Error fetching company {$slug} for {$country}: " . $e->getMessage());
            abort(404, 'Company not found');
        }
    }


    /**
     * Country-specific location page - lists jobs by location
     * URL: /ke/jobs/location/nairobi-jobs-in-ke
     */
    public function countryLocation(Request $request, $country, $slug)
    {
        $mainAppUrl = $this->mainAppUrl;
        
        try {
            // Fetch location data and jobs
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-by-location/' . $slug, [
                    'country' => strtoupper($country),
                    'page' => $request->get('page', 1),
                    'sort' => $request->get('sort', 'newest'),
                ]);
            
            if (!$response->successful()) {
                abort(404, 'Location not found');
            }
            
            $data = $response->json();
            $location = $data['location'] ?? [];
            $jobs = $data['jobs']['data'] ?? [];
            $pagination = $data['jobs']['pagination'] ?? [
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ];
            
            if (empty($location)) {
                abort(404, 'Location not found');
            }
            
            // Get similar locations in same country for sidebar
            $similarLocations = $this->getSimilarLocations($country, $location['id'] ?? null);
            
            // Country name for display
            $countryNames = [
                'ke' => 'Kenya', 'ug' => 'Uganda', 'ng' => 'Nigeria',
                'tz' => 'Tanzania', 'rw' => 'Rwanda', 'bi' => 'Burundi',
                'ss' => 'South Sudan', 'za' => 'South Africa',
            ];
            $countryName = $countryNames[$country] ?? strtoupper($country);
            
            // Format location name for display
            $displayLocationName = $location['district'] ?? $location['city'] ?? $location['name'];
            
            return view('jobs.country-location', compact(
                'location', 'jobs', 'pagination', 'country', 'countryName', 
                'similarLocations', 'slug', 'displayLocationName'
            ));
            
        } catch (\Exception $e) {
            Log::error("Error fetching location {$slug} for country {$country}: " . $e->getMessage());
            abort(404, 'Location not found');
        }
    }

    /**
     * Get similar locations in the same country (ONLY 5)
     */
    private function getSimilarLocations($country, $currentLocationId = null)
    {
        $mainAppUrl = $this->mainAppUrl;
        $cacheKey = "similar_locations_{$country}";
        
        try {
            $response = Cache::remember($cacheKey, now()->addHours(6), function () use ($mainAppUrl, $country) {
                $resp = Http::withoutVerifying()
                    ->timeout(10)
                    ->get($mainAppUrl . '/v2/locations-by-country', ['country' => strtoupper($country)]);
                
                return $resp->successful() ? $resp->json() : [];
            });
            
            // Filter out current location AND limit to 5
            $filtered = [];
            if (is_array($response)) {
                foreach ($response as $loc) {
                    if (($loc['id'] ?? null) != $currentLocationId) {
                        $filtered[] = $loc;
                    }
                    // Stop after collecting 5
                    if (count($filtered) >= 5) {
                        break;
                    }
                }
            }
            
            return $filtered;
            
        } catch (\Exception $e) {
            Log::error("Error fetching similar locations: " . $e->getMessage());
            return [];
        }
    }
            
}
