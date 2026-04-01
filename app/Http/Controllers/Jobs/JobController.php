<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ { Log, Artisan, Http };
use App\Services\StructuredDataService;

class JobController extends Controller
{
    
    /**
     * Display the jobs listing page.
     */
    public function index(Request $request)
    {
        // Get URL from config
        $mainAppUrl = config('api.main_app.api_base');
        
        try {
            // Build query parameters
            $params = [
                'page' => $request->get('page', 1),
            ];
            
            if ($request->has('sort')) {
                $params['sort'] = $request->sort;
            }
            if ($request->has('keyword') && !empty($request->keyword)) {
                $params['keyword'] = $request->keyword;
            }
            if ($request->has('location') && !empty($request->location)) {
                $params['location'] = $request->location;
            }
            
            // Get jobs data
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-data-from-main', $params);
            
            // Get popular searches
            $popularResponse = Http::withoutVerifying()
                ->timeout(10)
                ->get($mainAppUrl . '/v2/popular-searches');
            
            $popularSearches = $popularResponse->successful() 
                ? $popularResponse->json() 
                : ['Remote', 'Full Stack', 'Product Manager', 'Data Scientist', 'UX Designer', 'Developer']; // Fallback
            
            if ($response->successful()) {
                $data = $response->json();
        
                if (isset($data['data'])) {
                        $jobs = $data['data'];
                        $pagination = [
                            'current_page' => $data['current_page'],
                            'last_page'    => $data['last_page'],
                            'per_page'     => $data['per_page'],
                            'total'        => $data['total'],
                        ];
                    } else {
                        $jobs = $data;
                        $pagination = [
                            'current_page' => 1,
                            'last_page'    => 1,
                            'per_page'     => count($jobs),
                            'total'        => count($jobs),
                        ];
                    }

                    $totalJobs   = $pagination['total'];  // ← add this
                    $featuredJobs = $this->getFeaturedJobs();

                    return view('jobs.index', compact(
                        'jobs', 'featuredJobs', 'pagination',
                        'popularSearches', 'totalJobs'          // ← add totalJobs here
                    ));

                } else {
                Log::error('Failed to fetch jobs: ' . $response->status());

                $jobs         = [];
                $featuredJobs = [];
                $totalJobs    = 0;                          // ← add this
                $pagination   = ['current_page'=>1,'last_page'=>1,'per_page'=>0,'total'=>0];
                $error        = 'Unable to fetch jobs at this time.';

                return view('jobs.index', compact(
                    'jobs', 'featuredJobs', 'pagination',
                    'error', 'popularSearches', 'totalJobs' // ← add totalJobs here
                ));
            }
        } catch (\Exception $e) {
            Log::error('Exception fetching jobs: ' . $e->getMessage());

            $jobs            = [];
            $featuredJobs    = [];
            $totalJobs       = 0;                       // ← add this
            $pagination      = ['current_page'=>1,'last_page'=>1,'per_page'=>0,'total'=>0];
            $error           = 'Unable to fetch jobs at this time.';
            $popularSearches = ['Remote', 'Full Stack', 'Product Manager', 'Data Scientist', 'UX Designer', 'Developer'];

            return view('jobs.index', compact(
                'jobs', 'featuredJobs', 'pagination',
                'error', 'popularSearches', 'totalJobs' // ← add totalJobs here
            ));
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
    
            
    public function show(Request $request, $slug)
    {
        $mainAppUrl = config('api.main_app.api_base');

        try {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get($mainAppUrl . '/v2/jobs-data-from-main/' . $slug);

            // Job completely gone (hard deleted) → 301 to /jobs
            if ($response->status() === 404) {
                return redirect()->route('jobs.index', [], 301);
            }

            if ($response->successful()) {
                $data        = $response->json();
                $job         = $data;
                $similarJobs = $data['similar_jobs'] ?? [];
                $structuredData = app(StructuredDataService::class)->jobPosting($job);

                // Job expired or inactive → show expired view (keep URL alive for SEO)
                if (($data['is_expired'] ?? false) || ($data['is_inactive'] ?? false)) {
                    return view('jobs.show', compact('job', 'similarJobs', 'structuredData'))
                        ->header('X-Robots-Tag', 'noindex, follow'); // tell Google don't index
                }

                return view('jobs.show', compact('job', 'similarJobs', 'structuredData'));

            } else {
                // Any other error → redirect to jobs list
                return redirect()->route('jobs.index', [], 301);
            }

        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage());
            return redirect()->route('jobs.index', [], 301);
        }
    }
    

}