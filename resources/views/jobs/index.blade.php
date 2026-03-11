@extends('layouts.jobs')

@section('title', __('Job Listing - Stardena Works'))
@section('new-badge', __("We're hiring! 50+ tech positions available"))

@section('job-content')

  <div class="main-wrapper overflow-hidden">
    <!-- ------------------------------------- -->
    <!-- Hero Banner Start -->
    <!-- ------------------------------------- -->
    <section class="py-7 py-lg-12 bg-primary-subtle position-relative">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">Find your <span class="text-primary">dream job</span> today</h1>
            <p class="fs-5 text-muted mb-7">Browse thousands of jobs from top companies around the world</p>
            
            <!-- Search Bar -->
            <form action="{{ route('jobs.search') }}" method="GET" class="bg-white p-3 rounded-3 shadow-sm">
              <div class="row g-2">
                <div class="col-md-5">
                  <div class="d-flex align-items-center ps-3">
                    <i class="bi bi-search text-muted me-2"></i>
                    <input type="text" name="keyword" class="form-control border-0 p-0" placeholder="Job title, keywords, or company" value="{{ request('keyword') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="d-flex align-items-center ps-3 border-start">
                    <i class="bi bi-geo-alt text-muted me-2"></i>
                    <input type="text" name="location" class="form-control border-0 p-0" placeholder="City or remote" value="{{ request('location') }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <button type="submit" class="btn btn-primary w-100">Search Jobs</button>
                </div>
              </div>
            </form>
            
            <!-- Popular Searches -->
            @if(isset($popularSearches) && count($popularSearches) > 0)
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-5">
              <span class="text-muted">Popular:</span>
              @foreach($popularSearches as $keyword)
              <a href="{{ route('jobs.index', ['keyword' => $keyword]) }}" class="text-dark link-primary">{{ $keyword }}</a>
              @endforeach
            </div>
            @endif
          </div>
        </div>
      </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- Hero Banner End -->
    <!-- ------------------------------------- -->

    <!-- ------------------------------------- -->
    <!-- Job Categories Start -->
    <!-- ------------------------------------- -->
    @if(isset($categories) && count($categories) > 0)
    <section class="py-7">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-7">
          <h2 class="fs-9 fw-semibold">Browse by category</h2>
          <a href="#" class="text-primary link-primary">View all <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        
        <div class="row g-4">
          @foreach($categories as $category)
          <div class="col-lg-3 col-md-6">
            <div class="card text-center p-6 h-100 border-0 shadow-sm">
              <div class="d-flex justify-content-center mb-4">
                <div class="company-icon">
                  <i class="bi {{ $category->icon ?? 'bi-folder' }} fs-3 text-primary"></i>
                </div>
              </div>
              <h5 class="fw-semibold mb-2">{{ $category->name }}</h5>
              <p class="text-muted mb-0 fs-2">{{ $category->jobs_count ?? 0 }} jobs available</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif
    <!-- ------------------------------------- -->
    <!-- Job Categories End -->
    <!-- ------------------------------------- -->

    <!-- ------------------------------------- -->
    <!-- Featured Jobs Start -->
    <!-- ------------------------------------- -->
    @if(isset($featuredJobs) && count($featuredJobs) > 0)
    <section class="py-3 py-md-7 py-lg-12 bg-light">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-7">
          <h2 class="fs-9 fw-semibold">Featured jobs</h2>
          <a href="{{ route('jobs.index', ['featured' => true]) }}" class="text-primary link-primary">View all <i class="bi bi-arrow-right ms-2"></i></a>
        </div>

        <!-- Featured Job Cards -->
        <div class="row g-3 g-lg-4">
          @foreach($featuredJobs as $job)
          <div class="col-12 col-lg-6">
            <div class="card job-card featured-job p-4 p-lg-5 h-100 border-0 shadow-sm">
              <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-3 mb-3">
                <div class="d-flex gap-2 gap-sm-3 w-100">
                  <div class="company-icon flex-shrink-0">
                    @if($job['company'] && $job['company']['logo'])
                      <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] }}" class="rounded-circle" width="48" height="48">
                    @else
                      <i class="bi bi-building fs-4 fs-lg-3 text-primary"></i>
                    @endif
                  </div>
                  <div class="flex-grow-1" style="min-width: 0;">
                    <h4 class="fw-semibold mb-1 fs-6 fs-lg-5">
                      <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}" target="_blank" class="text-dark text-decoration-none">
                        {{ $job['job_title'] }}
                      </a>
                    </h4>
                    <div class="d-flex flex-wrap align-items-center gap-2 text-muted small">
                      <span class="d-flex align-items-center gap-1">
                        <i class="bi bi-building"></i>
                        <span>{{ $job['company']['name'] ?? 'Unknown Company' }}</span>
                      </span>
                      <span class="d-none d-sm-inline">•</span>
                      <span class="d-flex align-items-center gap-1 w-100 w-sm-auto">
                        <i class="bi bi-geo-alt"></i>
                        <span class="text-truncate" style="max-width: 180px;">{{ $job['duty_station'] ?? $job['job_location']['name'] ?? 'Remote' }}</span>
                      </span>
                    </div>
                  </div>
                </div>
                @if($job['is_featured'])
                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 px-lg-3 py-lg-2 align-self-start align-self-sm-center flex-shrink-0">Featured</span>
                @endif
              </div>
              
              <p class="text-muted small mb-3">{{ Str::limit(strip_tags($job['job_description']), 120) }}</p>
              
              <div class="d-flex flex-wrap gap-1 gap-lg-2 mb-3">
                <span class="job-type-badge">{{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}</span>
                <span class="job-type-badge">{{ $job['experience_level']['name'] ?? 'Not Specified' }}</span>
                <span class="job-type-badge">{{ $job['formatted_salary'] ?? 'Negotiable' }}</span>
              </div>
              
              <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mt-auto">
                <div class="d-flex flex-wrap gap-2 gap-sm-3">
                  <div class="d-flex align-items-center gap-1">
                    <i class="bi bi-eye text-muted small"></i>
                    <span class="fs-2 text-muted">{{ $job['view_count'] ?? 0 }} applicants</span>
                  </div>
                  <div class="d-flex align-items-center gap-1">
                    <i class="bi bi-clock text-muted small"></i>
                    <span class="fs-2 text-muted">{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}</span>
                  </div>
                </div>
                <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 w-sm-auto">Apply Now</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    <!-- ------------------------------------- -->
    <!-- All Jobs List Start -->
    <!-- ------------------------------------- -->
    <section class="py-5 py-lg-7">
      <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 mb-lg-7">
          <h2 class="fs-8 fs-lg-9 fw-semibold mb-0">Latest jobs</h2>
          
          <div class="d-flex align-items-center gap-3">
            <form action="{{ route('jobs.index') }}" method="GET" class="d-flex align-items-center gap-2">
              <label class="text-muted small mb-0 d-none d-sm-block">Sort by:</label>
              <select name="sort" class="form-select form-select-sm border-0 bg-light" style="width: 130px;" onchange="this.form.submit()">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Salary ↑</option>
                <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Salary ↓</option>
              </select>
            </form>
            
            <a href="{{ route('jobs.index') }}" class="text-decoration-none small text-muted">
              <i class="bi bi-funnel"></i> Clear
            </a>
          </div>
        </div>
        
        <!-- Job List - 2 Columns on Desktop -->
        @if(isset($jobs) && count($jobs) > 0)
        <div class="row g-3 g-lg-4">
          @foreach($jobs as $job)
          <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="p-3 p-lg-4">
                <div class="d-flex flex-column gap-2">
                  <!-- Header with icon and title -->
                  <div class="d-flex align-items-start gap-2">
                    <div class="company-icon flex-shrink-0" style="width: 40px; height: 40px;">
                      @if($job['company'] && $job['company']['logo'])
                        <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] }}" class="rounded-circle" width="40" height="40">
                      @else
                        <i class="bi bi-building fs-5 text-primary"></i>
                      @endif
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="fw-semibold mb-0 lh-sm">
                        <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}" target="_blank" class="text-dark text-decoration-none">
                          {{ $job['job_title'] }}
                        </a>
                      </h6>
                      <div class="d-flex align-items-center gap-1 text-muted small mt-1">
                        <i class="bi bi-building"></i>
                        <span class="fw-medium">{{ $job['company']['name'] ?? 'Unknown Company' }}</span>
                        @if($job['job_location'] || $job['duty_station'])
                        <span class="mx-1">•</span>
                        <i class="bi bi-geo-alt"></i>
                        <span>{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  
                  <!-- Compact badges -->
                  <div class="d-flex flex-wrap align-items-center gap-1 mt-1">
                    <span class="job-type-badge" style="font-size: 11px; padding: 3px 8px;">{{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}</span>
                    @if($job['experience_level']['name'])
                    <span class="job-type-badge" style="font-size: 11px; padding: 3px 8px;">{{ $job['experience_level']['name'] }}</span>
                    @endif
                    <span class="job-type-badge" style="font-size: 11px; padding: 3px 8px;">{{ $job['formatted_salary'] ?? 'Negotiable' }}</span>
                    @if($job['is_urgent'])
                    <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 11px; padding: 3px 8px;">Urgent</span>
                    @endif
                  </div>
                  
                  <!-- Footer with time and apply button -->
                  <div class="d-flex align-items-center justify-content-between mt-2 pt-1 border-top">
                    <div class="d-flex align-items-center gap-2 text-muted small">
                      <i class="bi bi-clock"></i>
                      <span>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}</span>
                    </div>
                    
                    <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}" target="_blank" class="btn btn-sm btn-primary py-1 px-3" style="font-size: 13px;">
                      Apply <i class="bi bi-arrow-right-short ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Larger Pagination Section -->
        @if(isset($pagination) && $pagination['last_page'] > 1)
        <div class="d-flex justify-content-center mt-5 mt-lg-6">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              {{-- Previous Page Link --}}
              @if($pagination['current_page'] > 1)
              <li class="page-item">
                <a class="page-link px-3 px-lg-4 py-2" href="{{ route('jobs.index', array_merge(request()->query(), ['page' => $pagination['current_page'] - 1])) }}" aria-label="Previous">
                  <span aria-hidden="true"><i class="bi bi-chevron-left me-1"></i> Prev</span>
                </a>
              </li>
              @else
              <li class="page-item disabled">
                <span class="page-link px-3 px-lg-4 py-2"><i class="bi bi-chevron-left me-1"></i> Prev</span>
              </li>
              @endif

              {{-- Pagination Elements - Show limited pages with ellipsis for many pages --}}
              @php
                $start = max(1, $pagination['current_page'] - 2);
                $end = min($pagination['last_page'], $pagination['current_page'] + 2);
              @endphp
              
              @if($start > 1)
                <li class="page-item">
                  <a class="page-link px-3 py-2" href="{{ route('jobs.index', array_merge(request()->query(), ['page' => 1])) }}">1</a>
                </li>
                @if($start > 2)
                  <li class="page-item disabled"><span class="page-link px-3 py-2">...</span></li>
                @endif
              @endif
              
              @for($i = $start; $i <= $end; $i++)
                @if($i == $pagination['current_page'])
                <li class="page-item active"><span class="page-link px-3 py-2">{{ $i }}</span></li>
                @else
                <li class="page-item">
                  <a class="page-link px-3 py-2" href="{{ route('jobs.index', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
                </li>
                @endif
              @endfor
              
              @if($end < $pagination['last_page'])
                @if($end < $pagination['last_page'] - 1)
                  <li class="page-item disabled"><span class="page-link px-3 py-2">...</span></li>
                @endif
                <li class="page-item">
                  <a class="page-link px-3 py-2" href="{{ route('jobs.index', array_merge(request()->query(), ['page' => $pagination['last_page']])) }}">{{ $pagination['last_page'] }}</a>
                </li>
              @endif

              {{-- Next Page Link --}}
              @if($pagination['current_page'] < $pagination['last_page'])
              <li class="page-item">
                <a class="page-link px-3 px-lg-4 py-2" href="{{ route('jobs.index', array_merge(request()->query(), ['page' => $pagination['current_page'] + 1])) }}" aria-label="Next">
                  <span aria-hidden="true">Next <i class="bi bi-chevron-right ms-1"></i></span>
                </a>
              </li>
              @else
              <li class="page-item disabled">
                <span class="page-link px-3 px-lg-4 py-2">Next <i class="bi bi-chevron-right ms-1"></i></span>
              </li>
              @endif
            </ul>
          </nav>
        </div>
        @endif

        @else
        <div class="text-center py-5">
          <i class="bi bi-briefcase fs-1 text-muted"></i>
          <p class="mt-3">No jobs found</p>
        </div>
        @endif
      </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- All Jobs List End -->
    <!-- ------------------------------------- -->

    <!-- ------------------------------------- -->
    <!-- CTA Start -->
    <!-- ------------------------------------- -->
    <section class="bg-primary py-6 position-relative">
      <div class="position-absolute top-50 start-0 translate-middle-y">
        <i class="bi bi-layers fs-1 text-white opacity-25 d-xxl-block d-none" style="font-size: 150px;"></i>
      </div>
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h3 class="fs-5 my-3 fw-semibold text-white">Ready to take the next step in your career?</h3>
            <p class="text-white small mb-4 opacity-75">Join thousands of professionals who found their dream jobs through Stardena Works</p>
            <div class="d-flex gap-3 justify-content-center">
              <a href="#" class="btn btn-light btn-sm px-4 py-2" style="font-size: 13px;">
                <i class="bi bi-person-plus me-1" style="font-size: 12px;"></i>Create Account
              </a>
              <a href="#" class="btn btn-outline-light btn-sm px-4 py-2" style="font-size: 13px;">
                <i class="bi bi-briefcase me-1" style="font-size: 12px;"></i>Post a Job
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="position-absolute top-50 end-0 translate-middle-y">
        <i class="bi bi-layers fs-1 text-white opacity-25 d-xxl-block d-none" style="font-size: 150px;"></i>
      </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- CTA End -->
    <!-- ------------------------------------- -->
  </div>

@endsection

@push('styles')
<style>
  /* Pagination styling */
  .pagination {
    gap: 5px;
  }
  .page-item .page-link {
    border-radius: 8px;
    color: var(--bs-primary);
    padding: 8px 14px;
    font-size: 14px;
  }
  .page-item.active .page-link {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
  }
  .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
  }
</style>
@endpush