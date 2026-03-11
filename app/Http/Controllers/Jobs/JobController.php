<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ { Log, Artisan, Http };

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
                ->get($mainAppUrl . '/jobs-data-from-main', $params);
            
            // Get popular searches
            $popularResponse = Http::withoutVerifying()
                ->timeout(10)
                ->get($mainAppUrl . '/popular-searches');
            
            $popularSearches = $popularResponse->successful() 
                ? $popularResponse->json() 
                : ['Remote', 'Full Stack', 'Product Manager', 'Data Scientist', 'UX Designer', 'Developer']; // Fallback
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Handle paginated response
                if (isset($data['data'])) {
                    $jobs = $data['data'];
                    $pagination = [
                        'current_page' => $data['current_page'],
                        'last_page' => $data['last_page'],
                        'per_page' => $data['per_page'],
                        'total' => $data['total'],
                    ];
                } else {
                    $jobs = $data;
                    $pagination = [
                        'current_page' => 1,
                        'last_page' => 1,
                        'per_page' => count($jobs),
                        'total' => count($jobs),
                    ];
                }
                
                // Get featured jobs separately
                $featuredJobs = $this->getFeaturedJobs();
                
                return view('jobs.index', compact('jobs', 'featuredJobs', 'pagination', 'popularSearches'));
            } else {
                Log::error('Failed to fetch jobs: ' . $response->status());
                
                $jobs = [];
                $featuredJobs = [];
                $pagination = [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 0,
                    'total' => 0,
                ];
                $error = 'Unable to fetch jobs at this time.';
                return view('jobs.index', compact('jobs', 'featuredJobs', 'pagination', 'error', 'popularSearches'));
            }
        } catch (\Exception $e) {
            Log::error('Exception fetching jobs: ' . $e->getMessage());
            
            $jobs = [];
            $featuredJobs = [];
            $pagination = [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 0,
                'total' => 0,
            ];
            $error = 'Unable to fetch jobs at this time.';
            $popularSearches = ['Remote', 'Full Stack', 'Product Manager', 'Data Scientist', 'UX Designer', 'Developer'];
            return view('jobs.index', compact('jobs', 'featuredJobs', 'pagination', 'error', 'popularSearches'));
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
                ->get($mainAppUrl . '/jobs-data-from-main/featured');
            
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
                ->get($mainAppUrl . '/jobs-data-from-main/' . $slug);
            
            if ($response->successful()) {
                $data = $response->json();
                $job = $data;
                $similarJobs = $data['similar_jobs'] ?? [];
                
                return view('jobs.show', compact('job', 'similarJobs'));
            } else {
                abort(404, 'Job not found');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage());
            abort(404, 'Job not found');
        }
    }
    

}