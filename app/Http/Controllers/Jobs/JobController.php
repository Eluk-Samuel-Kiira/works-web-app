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
            ]);

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
                    'popularSearches', 'totalJobs'
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
            // Expired/inactive jobs are also cached so we don't hammer the API
            $data = Cache::remember("job_{$slug}", now()->addMinutes(10), function () use ($mainAppUrl, $slug) {
                $response = Http::withoutVerifying()->timeout(30)
                    ->get($mainAppUrl . '/v2/jobs-data-from-main/' . $slug);

                // Store the HTTP status alongside data so we can act on it after cache retrieval
                return [
                    'status' => $response->status(),
                    'body'   => $response->successful() ? $response->json() : null,
                ];
            });

            // Job completely gone (hard deleted) → forget cache + 301
            if ($data['status'] === 404) {
                Cache::forget("job_{$slug}");
                return redirect()->route('jobs.index', [], 301);
            }

            // Any other non-success → 301
            if (!$data['body']) {
                Cache::forget("job_{$slug}");
                return redirect()->route('jobs.index', [], 301);
            }

            $job            = $data['body'];
            $similarJobs    = $job['similar_jobs'] ?? [];
            $structuredData = app(StructuredDataService::class)->jobPosting($job);

            $isExpired = ($job['is_expired'] ?? false) || ($job['is_inactive'] ?? false);

            $view = view('jobs.show', compact('job', 'similarJobs', 'structuredData'));

            // Expired jobs — serve page but tell Google not to index
            if ($isExpired) {
                return $view->header('X-Robots-Tag', 'noindex, follow');
            }

            return $view;

        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage());
            return redirect()->route('jobs.index', [], 301);
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