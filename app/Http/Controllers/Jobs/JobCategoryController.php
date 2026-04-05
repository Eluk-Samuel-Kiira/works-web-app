<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\ { Log, Artisan, Http, Cache };

class JobCategoryController extends Controller
{
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
        $pagination = [
            'current_page' => $result['current_page'] ?? 1,
            'last_page'    => $result['last_page']    ?? 1,
            'total'        => $result['total']        ?? 0,
        ];

        return view('jobs.companies', compact('companies', 'pagination', 'search'));
    }
    
}
