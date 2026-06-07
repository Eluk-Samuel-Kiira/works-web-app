@extends('layouts.jobs')

@php
    $locationName = $displayLocationName ?? $location['district'] ?? $location['city'] ?? $location['name'] ?? 'Jobs';
    $totalJobs = $pagination['total'] ?? 0;
@endphp

@section('title', "{$locationName} Jobs in {$countryName} — " . number_format($totalJobs) . " Listings | Stardena Works")
@section('meta_description', "Browse " . number_format($totalJobs) . " jobs in {$locationName}, {$countryName}. Find latest career opportunities, vacancies and employment in {$locationName}. Apply today!")
@section('canonical', url("/{$country}/jobs/location/{$slug}"))
@section('og_title', "{$locationName} Jobs in {$countryName} | Stardena Works")
@section('og_description', "Find the latest jobs in {$locationName}, {$countryName}. Browse career opportunities and apply directly.")

@section('job-content')
<div class="main-wrapper">

  {{-- AD SLOT 1 — Top Leaderboard --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-3587587638253109"
        data-ad-slot="1832373916"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- Hero --}}
  <div class="bg-primary py-4">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item">
            <a href="{{ route('jobs.country.index', ['country' => $country]) }}" class="text-white-50">Jobs in {{ $countryName }}</a>
          </li>
          <li class="breadcrumb-item text-white active">{{ $locationName }}</li>
        </ol>
      </nav>
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 bg-white bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:56px;height:56px">
          <i class="bi bi-geo-alt-fill text-white fs-4"></i>
        </div>
        <div>
          <h1 class="text-white fw-bold mb-0" style="font-size:clamp(1.3rem,3vw,1.9rem)">
            {{ $locationName }} <span style="color:#fdd835">Jobs in</span> {{ $countryName }}
          </h1>
          <p class="text-white-50 mb-0 small">
            {{ number_format($totalJobs) }} active positions in {{ $locationName }}
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="container-xl px-3 px-md-4 py-4">
    <div class="row g-4">

      {{-- Sidebar with location info (Desktop only) --}}
      <div class="col-12 col-lg-3">
        <div style="position:sticky;top:72px">
          
          {{-- Location Info Card --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
              <h6 class="fw-semibold mb-3">
                <i class="bi bi-info-circle me-2 text-primary"></i>About {{ $locationName }}
              </h6>
              @if(!empty($location['description']))
                <p class="small text-muted mb-3">{{ $location['description'] }}</p>
              @else
                <p class="small text-muted mb-3">
                  Find the best job opportunities in {{ $locationName }}, {{ $countryName }}. 
                  Browse through {{ number_format($totalJobs) }} current vacancies from top employers.
                </p>
              @endif
              
              @if(!empty($location['country']))
              <div class="mb-2">
                <i class="bi bi-building me-2 text-primary"></i>
                <span class="small">{{ $location['country_name'] ?? $countryName }}</span>
              </div>
              @endif
            </div>
          </div>
          
          {{-- Similar Locations (Desktop - shows in sidebar) --}}
          @if(isset($similarLocations) && count($similarLocations) > 0)
          <div class="card border-0 shadow-sm mb-4 d-none d-lg-block">
            <div class="card-body p-3">
              <h6 class="fw-semibold mb-3">
                <i class="bi bi-pin-map me-2 text-primary"></i>Similar Locations ({{ count($similarLocations) }})
              </h6>
              <div class="d-flex flex-column gap-2">
                @foreach($similarLocations as $loc)
                  <a href="{{ route('jobs.country.location', ['country' => $country, 'slug' => $loc['slug']]) }}" 
                    class="d-flex justify-content-between align-items-center text-decoration-none p-2 rounded-2 hover-bg">
                    <span class="small">
                      <i class="bi bi-geo-alt me-2 text-muted"></i>
                      {{ $loc['name'] ?? $loc['district'] ?? $loc['city'] }}
                    </span>
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary" style="font-size:10px">
                      {{ number_format($loc['jobs_count'] ?? 0) }} jobs
                    </span>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
          @endif
          
          {{-- AD SLOT — Sidebar --}}
          <div class="mb-4 text-center">
            <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-3587587638253109"
                data-ad-slot="1944054556"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
          </div>
          
        </div>
      </div>

      {{-- Main Content - Jobs List --}}
      <div class="col-12 col-lg-9">
        
        {{-- Sort Bar --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
          <p class="text-muted small mb-0">
            Showing <strong>{{ number_format($totalJobs) }}</strong> jobs in {{ $locationName }}
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
            
            {{-- AD SLOT — After every 10 jobs --}}
            @if($index > 0 && $index % 10 === 0)
            <div class="col-12">
              <div class="border rounded-3 py-3 px-3 text-center bg-light">
                <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
                <ins class="adsbygoogle"
                  style="display:block"
                  data-ad-client="ca-pub-3587587638253109"
                  data-ad-slot="8014638881"
                  data-ad-format="auto"
                  data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
              </div>
            </div>
            @endif
            
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card border rounded-3 shadow-sm h-100">
                <div class="card-body p-3 d-flex flex-column gap-2">
                  
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
                    
                    <div class="min-w-0 flex-grow-1">
                      <h3 class="fw-semibold mb-0" style="font-size: clamp(0.75rem, 3vw, 0.875rem);">
                        <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}"
                          class="text-body text-decoration-none">
                          {{ $job['job_title'] }}
                        </a>
                      </h3>
                      <div class="text-muted mt-1" style="font-size: clamp(10px, 2.5vw, 12px);">
                        <div class="d-flex flex-wrap align-items-center gap-1">
                          <span><i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? '—' }}</span>
                          <span class="d-none d-sm-inline">·</span>
                          <span><i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $locationName }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="d-flex flex-wrap gap-1 mt-1">
                    <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size: clamp(9px, 2vw, 11px);">
                      {{ $job['job_type']['name'] ?? 'Full Time' }}
                    </span>
                    <span class="badge rounded-pill fw-normal text-primary" style="font-size: clamp(9px, 2vw, 11px); background:rgba(var(--bs-primary-rgb),.1)">
                      {{ $job['formatted_salary'] ?? 'Negotiable' }}
                    </span>
                    @if($job['is_featured'] ?? false)
                    <span class="badge rounded-pill text-bg-primary fw-normal" style="font-size: clamp(9px, 2vw, 11px);">Featured</span>
                    @endif
                  </div>
                  
                  <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto">
                    <span class="text-muted" style="font-size: clamp(10px, 2.5vw, 12px);">
                      <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                    </span>
                    <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}"
                      class="btn btn-primary btn-sm fw-semibold text-nowrap">
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
        <nav class="d-flex justify-content-center mt-4">
          <ul class="pagination gap-1 flex-wrap justify-content-center mb-0">
            <li class="page-item {{ $cur <= 1 ? 'disabled' : '' }}">
              <a class="page-link rounded-2" style="padding:6px 12px"
                 href="{{ $cur > 1 ? route('jobs.country.location', array_merge(['country' => $country, 'slug' => $slug], $q, ['page' => $cur - 1])) : '#' }}">
                <i class="bi bi-chevron-left" style="font-size:11px"></i>
              </a>
            </li>
            @for($i = max(1, $cur - 2); $i <= min($last, $cur + 2); $i++)
              <li class="page-item {{ $i == $cur ? 'active' : '' }}">
                @if($i == $cur)
                  <span class="page-link rounded-2">{{ $i }}</span>
                @else
                  <a class="page-link rounded-2" href="{{ route('jobs.country.location', array_merge(['country' => $country, 'slug' => $slug], $q, ['page' => $i])) }}">{{ $i }}</a>
                @endif
              </li>
            @endfor
            <li class="page-item {{ $cur >= $last ? 'disabled' : '' }}">
              <a class="page-link rounded-2" href="{{ $cur < $last ? route('jobs.country.location', array_merge(['country' => $country, 'slug' => $slug], $q, ['page' => $cur + 1])) : '#' }}">
                <i class="bi bi-chevron-right" style="font-size:11px"></i>
              </a>
            </li>
          </ul>
        </nav>
        @endif
        
        {{-- Similar Locations (Mobile - appears after job listings) --}}
        @if(isset($similarLocations) && count($similarLocations) > 0)
        <div class="mt-4 d-block d-lg-none">
          <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
              <h6 class="fw-semibold mb-3">
                <i class="bi bi-pin-map me-2 text-primary"></i>Similar Locations ({{ count($similarLocations) }})
              </h6>
              <div class="d-flex flex-column gap-2">
                @foreach($similarLocations as $loc)
                  <a href="{{ route('jobs.country.location', ['country' => $country, 'slug' => $loc['slug']]) }}" 
                    class="d-flex justify-content-between align-items-center text-decoration-none p-2 rounded-2 hover-bg">
                    <span class="small">
                      <i class="bi bi-geo-alt me-2 text-muted"></i>
                      {{ $loc['name'] ?? $loc['district'] ?? $loc['city'] }}
                    </span>
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary" style="font-size:10px">
                      {{ number_format($loc['jobs_count'] ?? 0) }} jobs
                    </span>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endif
        
        @else
        <div class="text-center py-5">
          <i class="bi bi-geo-alt fs-1 text-muted opacity-50"></i>
          <p class="mt-3 text-muted">No jobs found in {{ $locationName }}, {{ $countryName }} right now.</p>
          <a href="{{ route('jobs.country.index', ['country' => $country]) }}" class="btn btn-outline-primary btn-sm">
            Browse all jobs in {{ $countryName }}
          </a>
        </div>
        
        {{-- Similar Locations (Mobile - even when no jobs) --}}
        @if(isset($similarLocations) && count($similarLocations) > 0)
        <div class="mt-4 d-block d-lg-none">
          <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
              <h6 class="fw-semibold mb-3">
                <i class="bi bi-pin-map me-2 text-primary"></i>Similar Locations ({{ count($similarLocations) }})
              </h6>
              <div class="d-flex flex-column gap-2">
                @foreach($similarLocations as $loc)
                  <a href="{{ route('jobs.country.location', ['country' => $country, 'slug' => $loc['slug']]) }}" 
                    class="d-flex justify-content-between align-items-center text-decoration-none p-2 rounded-2 hover-bg">
                    <span class="small">
                      <i class="bi bi-geo-alt me-2 text-muted"></i>
                      {{ $loc['name'] ?? $loc['district'] ?? $loc['city'] }}
                    </span>
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary" style="font-size:10px">
                      {{ number_format($loc['jobs_count'] ?? 0) }} jobs
                    </span>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endif
        @endif
        
        {{-- AD SLOT — Bottom --}}
        <div class="mt-4 text-center">
          <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
          <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-3587587638253109"
            data-ad-slot="9822544573"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
          <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.hover-bg:hover {
  background: rgba(var(--bs-primary-rgb), .05);
}
.card {
  transition: border-color .15s, box-shadow .15s;
}
.card:hover {
  border-color: var(--bs-primary) !important;
  box-shadow: 0 2px 10px rgba(var(--bs-primary-rgb), .1) !important;
}
</style>
@endpush