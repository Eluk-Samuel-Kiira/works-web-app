<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ { Log, Artisan, Http, Cache };
use App\Services\StructuredDataService;

class JobController extends Controller
{
        
    /**
     * Display the jobs listing page.
     */
    public function index(Request $request)
    {
        $mainAppUrl = config('api.main_app.api_base');

        try {
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

            if ($request->has('featured')) {
                $params['featured'] = $request->get('featured');
            }

            $isDefaultRequest = !$request->hasAny(['keyword', 'location', 'sort'])
                                && $request->get('page', 1) == 1;

            // Cache key includes page so page 2, 3 etc are cached separately
            $cacheKey = 'jobs_index_page_' . $request->get('page', 1);

            // Fetch data — cached for default requests, live for filtered
            $data = $isDefaultRequest
                ? Cache::remember($cacheKey, now()->addMinutes(5), function () use ($mainAppUrl, $params) {
                    $response = Http::withoutVerifying()->timeout(30)
                        ->get($mainAppUrl . '/v2/jobs-data-from-main', $params);
                    return $response->successful() ? $response->json() : null;
                })
                : function () use ($mainAppUrl, $params) {
                    $response = Http::withoutVerifying()->timeout(30)
                        ->get($mainAppUrl . '/v2/jobs-data-from-main', $params);
                    return $response->successful() ? $response->json() : null;
                };

            // Execute closure if not cached path
            if (is_callable($data)) {
                $data = $data();
            }

            // Popular searches — cache for 1 hour (rarely changes)
            $popularSearches = Cache::remember('popular_searches', now()->addHour(), function () use ($mainAppUrl) {
                $response = Http::withoutVerifying()->timeout(10)
                    ->get($mainAppUrl . '/v2/popular-searches');
                return $response->successful()
                    ? $response->json()
                    : ['Remote', 'NGO', 'Finance', 'Health', 'Education', 'Manager'];
            });

            // Fetch categories with job counts — cached for 1 hour
            $categories = Cache::remember('job_categories_with_count', now()->addHour(), function () use ($mainAppUrl) {
                $response = Http::withoutVerifying()->timeout(10)
                    ->get($mainAppUrl . '/v2/job-by-category');
                if ($response->successful()) {
                    $cats = $response->json();
                    // Handle both paginated and plain array responses
                    return isset($cats['data']) ? $cats['data'] : $cats;
                }
                return [];
            });

            // Featured jobs — cache for 10 minutes
            $featuredJobs = Cache::remember('featured_jobs', now()->addMinutes(10), function () {
                return $this->getFeaturedJobs();
            });

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

            // Data was null — API failed
            throw new \Exception('API returned no data');

        } catch (\Exception $e) {
            Log::error('Exception fetching jobs: ' . $e->getMessage());

            $jobs            = [];
            $featuredJobs    = [];
            $totalJobs       = 0;
            $pagination      = ['current_page' => 1, 'last_page' => 1, 'per_page' => 0, 'total' => 0];
            $error           = 'Unable to fetch jobs at this time.';
            $popularSearches = ['Remote', 'NGO', 'Finance', 'Health', 'Education', 'Manager'];

            return view('jobs.index', compact(
                'jobs', 'featuredJobs', 'pagination',
                'error', 'popularSearches', 'totalJobs'
            ));
        }
    }

    /**
     * Display a single job.
     */
    public function show(Request $request, $slug)
    {
        $mainAppUrl = config('api.main_app.api_base');

        try {
            // Cache individual job for 10 minutes
            $cachedData = Cache::remember("job_{$slug}", now()->addMinutes(10), function () use ($mainAppUrl, $slug) {
                $response = Http::withoutVerifying()->timeout(30)
                    ->get($mainAppUrl . '/v2/jobs-data-from-main/' . $slug);

                return [
                    'status' => $response->status(),
                    'data'   => $response->successful() ? $response->json() : null,
                    'body'   => $response->body(),
                ];
            });

            // Check if job exists
            if ($cachedData['status'] === 404 || !$cachedData['data']) {
                Cache::forget("job_{$slug}");
                abort(404, 'Job not found');
            }

            $job = $cachedData['data'];
            
            // Debug: Log the job to see what's coming
            Log::info('Job data retrieved', ['slug' => $slug, 'has_data' => !empty($job)]);
            
            // \Log::info($job);
            
            // If job is empty or doesn't have job_title, something is wrong
            if (empty($job['job_title'])) {
                Log::error('Invalid job data', ['slug' => $slug, 'data' => $job]);
                abort(404, 'Job not found');
            }

            $similarJobs = $job['similar_jobs'] ?? [];
            $structuredData = app(StructuredDataService::class)->jobPosting($job);

            $isExpired = ($job['deadline'] ?? null) && now()->isAfter(\Carbon\Carbon::parse($job['deadline']));
            $isActive = ($job['is_active'] ?? true);

            $view = view('jobs.show', compact('job', 'similarJobs', 'structuredData'));

            // Expired or inactive jobs — serve page but tell Google not to index
            if ($isExpired || !$isActive) {
                return $view->header('X-Robots-Tag', 'noindex, follow');
            }

            return $view;

        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage(), [
                'slug' => $slug,
                'trace' => $e->getTraceAsString()
            ]);
            abort(404, 'Job not found');
        }
    }
    
    /**
     * Get featured jobs
     */
    private function getFeaturedJobs()
    {
        $mainAppUrl = config('api.main_app.api_base');
        
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
        // Redirect to index with search parameters
        return redirect()->route('jobs.index', $request->query());
    }
    
            

    

}