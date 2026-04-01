@extends('layouts.jobs')

@section('title', 'Coming Soon | Stardena Works')
@section('meta_description', 'This feature is coming soon to Stardena Works.')
@section('robots', 'noindex, follow')
@section('canonical', url('/coming-soon'))

@section('job-content')
<div class="main-wrapper">
    <div class="container-xl py-5 text-center">
        <div class="py-5">
            <i class="bi bi-rocket-takeoff fs-1 text-primary mb-3 d-block"></i>
            <h1 class="h3 fw-semibold mb-2">Coming Soon</h1>
            <p class="text-muted mb-4">We're working on something great. Check back soon.</p>
            <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                <i class="bi bi-briefcase me-2"></i>Browse Jobs
            </a>
        </div>
    </div>
</div>
@endsection