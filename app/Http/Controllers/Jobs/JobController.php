<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display the jobs listing page.
     * Replace $jobs with your actual Eloquent query when models are ready.
     */
    public function index(Request $request)
    {
        // Sample data — replace with: Job::with('company')->latest()->paginate(20);
        $jobs      = collect([]);   // paginator or collection
        $totalJobs = 2840;
        $newToday  = 48;

        return view('jobs.index', compact('jobs', 'totalJobs', 'newToday'));
    }

    /**
     * Display a single job detail page.
     * Replace with: $job = Job::with(['company','skills'])->findOrFail($id);
     */
    public function show($id)
    {
        // Sample job data — replace with Eloquent lookup
        $job = [
            'id'          => $id,
            'title'       => 'Senior Software Engineer',
            'company'     => 'MTN Uganda',
            'location'    => 'Kampala, Uganda',
            'type'        => 'Full-time',
            'salary_min'  => 4500000,
            'salary_max'  => 6500000,
            'experience'  => '5+ Years',
            'deadline'    => '2026-04-30',
            'posted_at'   => now()->subHours(2),
            'featured'    => true,
            'ai_match'    => 94,
            'applicants'  => 127,
        ];

        return view('jobs.show', compact('job'));
    }
}