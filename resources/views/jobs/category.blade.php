@extends('layouts.jobs')

@php
    $catName    = $categoryData['name'] ?? ucfirst(str_replace('-', ' ', request()->segment(3)));
    $totalCount = $pagination['total'] ?? 0;
@endphp

@section('title',            "{$catName} Jobs in Africa — " . number_format($totalCount) . " Listings | Stardena Works")
@section('meta_description', "Browse " . number_format($totalCount) . " {$catName} jobs in Africa. Find the latest {$catName} opportunities, salaries and apply directly on Stardena Works.")
@section('canonical',        url('/jobs/category/' . ($categoryData['slug'] ?? '')))
@section('robots',           'index, follow')
@section('og_title',         "{$catName} Jobs in Africa | Stardena Works")
@section('og_description',   "Find {$catName} jobs in Africa. Browse verified listings from top organisations.")

@section('job-content')
<div class="main-wrapper">

  {{-- AD SLOT 1 — Top leaderboard --}}
  

  {{-- Hero --}}
  <div class="bg-primary py-4">
    <div class="container-fluid px-4">
      <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}" class="text-white-50">Jobs</a></li>
          <li class="breadcrumb-item text-white active">{{ $catName }}</li>
        </ol>
      </nav>
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 bg-white bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:56px;height:56px">
          <i class="bi {{ $categoryData['icon'] ?? 'bi-briefcase' }} text-white fs-4"></i>
        </div>
        <div>
          <h1 class="text-white fw-bold mb-0" style="font-size:clamp(1.3rem,3vw,1.9rem)">
            {{ $catName }} <span style="color:#fdd835">Jobs in</span> Africa
          </h1>
          <p class="text-white-50 mb-0 small">
            {{ number_format($totalCount) }} active {{ strtolower($catName) }} opportunities
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid px-4 py-4">
    <div class="row g-4">

      {{-- ── SIDEBAR ── --}}
      <div class="col-12 col-lg-3">
        <div style="position:sticky;top:72px">

          {{-- Browse other categories --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
              <h6 class="fw-semibold mb-3 pb-2 border-bottom">
                <i class="bi bi-grid me-2 text-primary"></i>All Categories
              </h6>
              <div class="d-flex flex-column gap-1" style="max-height:320px;overflow-y:auto">
                @foreach($allCategories as $cat)
                  @if(!is_array($cat)) @continue @endif
                  <a href="{{ route('jobs.category', ['slug' => $cat['slug'] ?? $cat['id']]) }}"
                    class="d-flex align-items-center justify-content-between px-2 py-2 rounded-2 text-decoration-none
                            {{ ($cat['slug'] ?? '') === ($categoryData['slug'] ?? '') ? 'bg-primary text-white' : 'text-body hover-bg' }}"
                    style="font-size:13px;transition:background .15s">
                    <span>
                      {{-- icon already stored as "bi bi-briefcase" — no extra "bi" prefix --}}
                      <i class="{{ $cat['icon'] ?? 'bi bi-folder2' }} me-2"></i>
                      {{ $cat['name'] }}
                    </span>
                    @if(isset($cat['jobs_count']))
                    <span class="badge rounded-pill {{ ($cat['slug'] ?? '') === ($categoryData['slug'] ?? '') ? 'bg-white text-primary' : 'bg-primary bg-opacity-10 text-primary' }}"
                          style="font-size:10px">
                      {{ number_format($cat['jobs_count']) }}
                    </span>
                    @endif
                  </a>
                @endforeach
              </div>
            </div>
          </div>

          {{-- AD SLOT — Sidebar --}}

        </div>
      </div>

      {{-- ── MAIN CONTENT ── --}}
      <div class="col-12 col-lg-9">

        {{-- Sort bar --}}
        <div class="d-flex align-items-center justify-content-between mb-3">
          <p class="text-muted small mb-0">
            Showing <strong>{{ number_format($totalCount) }}</strong> {{ strtolower($catName) }} jobs
          </p>
          <form method="GET" class="d-flex align-items-center gap-2">
            <label class="text-muted small mb-0 d-none d-sm-inline">Sort:</label>
            <select name="sort" class="form-select form-select-sm" style="width:130px"
                    onchange="this.form.submit()" aria-label="Sort">
              <option value="newest"      {{ request('sort','newest')=='newest'      ? 'selected':'' }}>Newest</option>
              <option value="oldest"      {{ request('sort')=='oldest'      ? 'selected':'' }}>Oldest</option>
              <option value="salary_high" {{ request('sort')=='salary_high' ? 'selected':'' }}>Salary ↑</option>
              <option value="salary_low"  {{ request('sort')=='salary_low'  ? 'selected':'' }}>Salary ↓</option>
            </select>
          </form>
        </div>

        @if(count($jobs) > 0)
        <div class="row g-3">
          @foreach($jobs as $index => $job)

            {{-- AD every 10 jobs --}}
            @if($index > 0 && $index % 10 === 0)
            
            @endif

            <div class="col-12 col-md-6 col-lg-4">
              <div class="card border rounded-3 shadow-sm h-100 job-list-card">
                <div class="card-body p-3 d-flex flex-column gap-2">
                  
                  {{-- Header - Logo and Title (Responsive) --}}
                  <div class="d-flex gap-3">
                    @php $logoUrl = companyLogo($job['company'] ?? null); @endphp
                    @if($logoUrl)
                      <img src="{{ $logoUrl }}" alt="{{ $job['company']['name'] ?? 'Company' }}"
                          width="44" height="44" loading="lazy"
                          class="rounded-2 border flex-shrink-0"
                          style="object-fit:contain;background:#fff;padding:3px"
                          onerror="this.src='{{ asset('default-logo.png') }}'">
                    @else
                      <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center flex-shrink-0"
                          style="width:44px;height:44px">
                        <i class="bi bi-building text-primary"></i>
                      </div>
                    @endif
                    
                    {{-- Title and Company Info (Responsive) --}}
                    <div class="min-w-0 flex-grow-1">
                      <h3 class="fw-semibold mb-0" style="font-size: clamp(0.75rem, 3vw, 0.875rem); line-height: 1.35;">
                        <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                          class="text-body text-decoration-none">
                          {{ $job['job_title'] }}
                        </a>
                      </h3>
                      <div class="text-muted mt-1" style="font-size: clamp(10px, 2.5vw, 12px);">
                        <div class="d-flex flex-wrap align-items-center gap-1">
                          <span><i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? '—' }}</span>
                          <span class="d-none d-sm-inline">·</span>
                          <span><i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $job['job_location']['district'] ?? 'Africa' }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  {{-- Tags --}}
                  <div class="d-flex flex-wrap gap-1 mt-1">
                    <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size: clamp(9px, 2vw, 11px); padding: 4px 8px;">
                      {{ $job['job_type']['name'] ?? 'Full Time' }}
                    </span>
                    <span class="badge rounded-pill fw-normal text-primary" style="font-size: clamp(9px, 2vw, 11px); padding: 4px 8px; background:rgba(var(--bs-primary-rgb),.1)">
                      {{ $job['formatted_salary'] ?? 'Negotiable' }}
                    </span>
                    @if($job['is_featured'] ?? false)
                    <span class="badge rounded-pill text-bg-primary fw-normal" style="font-size: clamp(9px, 2vw, 11px); padding: 4px 8px;">Featured</span>
                    @endif
                  </div>
                  
                  {{-- Footer --}}
                  <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto">
                    <span class="text-muted" style="font-size: clamp(10px, 2.5vw, 12px);">
                      <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                    </span>
                    <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                      class="btn btn-primary btn-sm fw-semibold" style="font-size: clamp(11px, 2.5vw, 13px); padding: 5px 12px;">
                      Apply <i class="bi bi-arrow-right-short"></i>
                    </a>
                  </div>
                  
                </div>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Pagination --}}
        @if($pagination['last_page'] > 1)
        @php
          $cur = $pagination['current_page'];
          $last = $pagination['last_page'];
          $q = request()->query();
        @endphp
        <nav class="d-flex justify-content-center mt-4" aria-label="Page navigation">
          <ul class="pagination gap-1 flex-wrap justify-content-center mb-0">
            <li class="page-item {{ $cur <= 1 ? 'disabled' : '' }}">
              <a class="page-link rounded-2" style="padding:6px 12px"
                 href="{{ $cur > 1 ? route('jobs.category', array_merge(['slug' => $categoryData['slug']], $q, ['page' => $cur - 1])) : '#' }}"
                 aria-label="Previous"><i class="bi bi-chevron-left" style="font-size:11px"></i></a>
            </li>
            @for($i = max(1,$cur-2); $i <= min($last,$cur+2); $i++)
            <li class="page-item {{ $i==$cur ? 'active' : '' }}">
              @if($i==$cur)
                <span class="page-link rounded-2" style="padding:6px 12px">{{ $i }}</span>
              @else
                <a class="page-link rounded-2" style="padding:6px 12px"
                   href="{{ route('jobs.category', array_merge(['slug' => $categoryData['slug']], $q, ['page' => $i])) }}">{{ $i }}</a>
              @endif
            </li>
            @endfor
            <li class="page-item {{ $cur >= $last ? 'disabled' : '' }}">
              <a class="page-link rounded-2" style="padding:6px 12px"
                 href="{{ $cur < $last ? route('jobs.category', array_merge(['slug' => $categoryData['slug']], $q, ['page' => $cur + 1])) : '#' }}"
                 aria-label="Next"><i class="bi bi-chevron-right" style="font-size:11px"></i></a>
            </li>
          </ul>
        </nav>
        @endif

        @else
        <div class="text-center py-5">
          <i class="bi bi-briefcase fs-1 text-muted opacity-50"></i>
          <p class="mt-3 text-muted">No {{ strtolower($catName) }} jobs found right now.</p>
          <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm">Browse all jobs</a>
        </div>
        @endif

        {{-- AD SLOT — Bottom --}}

      </div>
    </div>
  </div>

</div>
@endsection

@push('styles')
<style>
.hover-bg:hover { background: rgba(var(--bs-primary-rgb),.08); }
.job-list-card { transition: border-color .15s, box-shadow .15s; }
.job-list-card:hover { border-color: var(--bs-primary) !important; box-shadow: 0 2px 10px rgba(var(--bs-primary-rgb),.1) !important; }
</style>
<style>
  /* Responsive Job Cards */
@media (max-width: 768px) {
  .job-list-card .card-body {
    padding: 0.75rem !important;
  }
  
  /* Make logo smaller on mobile */
  .job-list-card .flex-shrink-0 {
    width: 36px !important;
    height: 36px !important;
  }
  
  .job-list-card .flex-shrink-0 img,
  .job-list-card .flex-shrink-0 div {
    width: 36px !important;
    height: 36px !important;
  }
  
  .job-list-card .flex-shrink-0 i {
    font-size: 14px !important;
  }
  
  /* Allow title to wrap properly */
  .job-list-card h3 {
    -webkit-line-clamp: 2;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  /* Stack company and location on mobile */
  .job-list-card .text-muted .d-flex {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 4px;
  }
  
  .job-list-card .text-muted .d-none {
    display: none !important;
  }
  
  /* Tags wrap better */
  .job-list-card .d-flex.flex-wrap.gap-1 {
    gap: 4px !important;
  }
  
  .job-list-card .badge {
    font-size: 9px !important;
    padding: 3px 6px !important;
  }
}

/* Tablet view */
@media (min-width: 769px) and (max-width: 991px) {
  .job-list-card .card-body {
    padding: 1rem !important;
  }
  
  .job-list-card h3 {
    font-size: 0.8rem !important;
  }
}

/* Desktop view */
@media (min-width: 992px) {
  .job-list-card h3 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}
</style>
@endpush