@extends('layouts.jobs')
@section('title', 'About Us | Stardena Works — Jobs in Uganda')
@section('meta_description', 'Stardena Works is an AI-powered job listing platform connecting job seekers with top employers across Uganda and Africa.')
@section('canonical', url('/about'))
@section('robots', 'index, follow')

@section('job-content')
<div class="main-wrapper">

  <div class="py-2 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Home</a></li>
          <li class="breadcrumb-item active">About Us</li>
        </ol>
      </nav>
    </div>
  </div>

  {{-- Hero --}}
  <section class="bg-primary py-5">
    <div class="container-xl px-3 px-md-4">
      <div class="row justify-content-center text-center">
        <div class="col-12 col-md-8">
          <p class="text-white-50 text-uppercase small mb-2" style="letter-spacing:.1em">About Stardena Works</p>
          <h1 class="text-white fw-bold mb-3" style="font-size:clamp(1.6rem,4vw,2.5rem)">
            Connecting Uganda's talent with opportunity
          </h1>
          <p class="text-white-50 mb-0" style="font-size:.9375rem">
            We're building the most trusted job platform for Uganda and Africa — where every job seeker finds their next opportunity and every employer finds the right talent.
          </p>
        </div>
      </div>
    </div>
  </section>

  <div class="container-xl px-3 px-md-4 py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8">

        {{-- Mission --}}
        <div class="mb-5">
          <h2 class="h4 fw-semibold mb-3">Our Mission</h2>
          <p class="text-body-secondary">Stardena Works exists to reduce unemployment in Uganda and across Africa by making job opportunities accessible to everyone. We aggregate verified job listings from NGOs, government bodies, private companies, and startups — all in one place.</p>
          <p class="text-body-secondary">We believe that finding a job should be simple, transparent, and free for job seekers.</p>
        </div>

        {{-- Stats --}}
        <div class="row g-3 mb-5">
          <div class="col-6 col-md-3">
            <div class="text-center p-3 bg-body-secondary rounded-3">
              <div class="fw-bold text-primary" style="font-size:1.75rem">500+</div>
              <div class="text-muted small">Jobs posted</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="text-center p-3 bg-body-secondary rounded-3">
              <div class="fw-bold text-primary" style="font-size:1.75rem">100+</div>
              <div class="text-muted small">Employers</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="text-center p-3 bg-body-secondary rounded-3">
              <div class="fw-bold text-primary" style="font-size:1.75rem">10+</div>
              <div class="text-muted small">Industries</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="text-center p-3 bg-body-secondary rounded-3">
              <div class="fw-bold text-primary" style="font-size:1.75rem">UG</div>
              <div class="text-muted small">Based in Uganda</div>
            </div>
          </div>
        </div>

        {{-- What we offer --}}
        <div class="mb-5">
          <h2 class="h4 fw-semibold mb-4">What We Offer</h2>
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3 h-100">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-briefcase text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">Verified Job Listings</div>
                  <p class="text-muted mb-0" style="font-size:13px">All jobs are reviewed before going live. No scams, no fake listings.</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3 h-100">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-bell text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">Job Alerts</div>
                  <p class="text-muted mb-0" style="font-size:13px">Get notified when new jobs matching your profile are posted.</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3 h-100">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-building text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">For Employers</div>
                  <p class="text-muted mb-0" style="font-size:13px">Post jobs and reach thousands of qualified candidates across Uganda.</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3 h-100">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-phone text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">Mobile Friendly</div>
                  <p class="text-muted mb-0" style="font-size:13px">Find and apply for jobs from your phone anywhere in Uganda.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- CTA --}}
        <div class="text-center py-4 bg-body-secondary rounded-3">
          <h3 class="h5 fw-semibold mb-2">Ready to find your next job?</h3>
          <p class="text-muted small mb-3">Browse hundreds of verified listings across Uganda.</p>
          <a href="{{ route('jobs.index') }}" class="btn btn-primary fw-semibold px-4">
            <i class="bi bi-briefcase me-2"></i>Browse Jobs
          </a>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection