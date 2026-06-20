@extends('layouts.jobs')

@section('title', $company['name'] . ' Jobs in ' . $countryName . ' | Stardena Works')
@section('meta_description', 'Browse ' . number_format($pagination['total']) . ' jobs at ' . $company['name'] . ' in ' . $countryName . '. Find career opportunities and apply directly.')
@section('canonical', url("/{$country}/jobs/company/{$slug}"))
@section('robots', 'index, follow')

@section('job-content')
<div class="main-wrapper">

  {{-- AD SLOT 1 --}}
  

  {{-- Company Hero --}}
  <div class="bg-primary py-4">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item">
            <a href="{{ route('jobs.country.index', ['country' => $country]) }}" class="text-white-50">Jobs in {{ $countryName }}</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('jobs.country.companies', ['country' => $country]) }}" class="text-white-50">Companies</a>
          </li>
          <li class="breadcrumb-item text-white active">{{ $company['name'] }}</li>
        </ol>
      </nav>
      
      <div class="d-flex align-items-center gap-4">
        @php $logoUrl = companyLogo($company); @endphp
        <div class="rounded-3 bg-white d-flex align-items-center justify-content-center flex-shrink-0 p-2"
             style="width:80px;height:80px;">
          @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $company['name'] }}" style="width:100%;height:100%;object-fit:contain;">
          @else
            <i class="bi bi-building fs-1 text-primary"></i>
          @endif
        </div>
        <div>
          <h1 class="text-white fw-bold mb-1">{{ $company['name'] }} <span style="color:#fdd835">Jobs in</span> {{ $countryName }}</h1>
          <p class="text-white-50 mb-0 small">
            {{ number_format($pagination['total']) }} open positions
            @if(!empty($company['industry']['name']))
            · {{ $company['industry']['name'] }}
            @endif
          </p>
          @if($company['is_verified'] ?? false)
          <span class="badge bg-success mt-2">Verified Employer</span>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="container-xl px-3 px-md-4 py-4">
    <div class="row g-4">
      {{-- Sidebar with company info (Desktop) --}}
      <div class="col-12 col-lg-3">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body p-3">
            <h6 class="fw-semibold mb-3">About {{ $company['name'] }}</h6>
            @if(!empty($company['description']))
              <p class="small text-muted mb-3">{{ Str::limit(strip_tags($company['description']), 200) }}</p>
            @endif
            
            @if(!empty($company['website']))
            <div class="mb-2">
              <i class="bi bi-globe me-2 text-primary"></i>
              <a href="{{ $company['website'] }}" target="_blank" class="small">Visit Website</a>
            </div>
            @endif
            
            @if(!empty($company['company_size']))
            <div class="mb-2">
              <i class="bi bi-people me-2 text-primary"></i>
              <span class="small">{{ $company['company_size'] }}</span>
            </div>
            @endif
            
            {{-- Location from location_id relationship --}}
            @php
              $locationName = '';
              if (!empty($company['location']['district'])) {
                  $locationName = $company['location']['district'];
              }
              if (!empty($company['location']['country']) && !empty($locationName)) {
                  $locationName .= ', ' . $company['location']['country'];
              } elseif (!empty($company['location']['country'])) {
                  $locationName = $company['location']['country'];
              }
            @endphp
            @if(!empty($locationName))
            <div class="mb-2">
              <i class="bi bi-geo-alt me-2 text-primary"></i>
              <span class="small">{{ $locationName }}</span>
            </div>
            @endif
          </div>
        </div>
        
        {{-- Similar Companies Card (Desktop - shows in sidebar) --}}
        @if(isset($similarCompanies) && count($similarCompanies) > 0)
        <div class="card border-0 shadow-sm mb-4 d-none d-lg-block">
            <div class="card-body p-3">
                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-building me-2 text-primary"></i>Similar Companies ({{ count($similarCompanies) }})
                </h6>
                <div class="d-flex flex-column gap-2">
                    @foreach($similarCompanies as $similarCompany)
                        <a href="{{ route('jobs.country.company', ['country' => $country, 'slug' => $similarCompany['slug']]) }}" 
                          class="d-flex align-items-center gap-3 text-decoration-none p-2 rounded-2 hover-bg">
                            <div class="rounded-2 border flex-shrink-0 d-flex align-items-center justify-content-center" 
                                style="width:40px;height:40px;background:#fff">
                                @if(!empty($similarCompany['logo']))
                                    <img src="{{ $similarCompany['logo'] }}" alt="{{ $similarCompany['name'] }}" 
                                        style="width:100%;height:100%;object-fit:contain;padding:4px"
                                        onerror="this.src='{{ asset('default-logo.png') }}'">
                                @else
                                    <i class="bi bi-building text-primary"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ $similarCompany['name'] }}</div>
                                @if(!empty($similarCompany['industry']['name']))
                                    <div class="text-muted" style="font-size:10px">{{ $similarCompany['industry']['name'] }}</div>
                                @endif
                            </div>
                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary" style="font-size:10px">
                                {{ number_format($similarCompany['jobs_count'] ?? 0) }} jobs
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
      </div>

      {{-- Jobs list --}}
      <div class="col-12 col-lg-9">
        @if(count($jobs) > 0)
          <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-muted small mb-0">{{ number_format($pagination['total']) }} jobs found</p>
          </div>
          
          <div class="row g-3">
            @foreach($jobs as $job)
            <div class="col-12">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center">
                            {{-- Job Title & Details - Left side --}}
                            <div class="col-12 col-md-8 mb-2 mb-md-0">
                                <h3 class="h6 fw-semibold mb-1">
                                    <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}" class="text-body text-decoration-none">
                                        {{ $job['job_title'] }}
                                    </a>
                                </h3>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <span class="small text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $job['duty_station'] ?? $job['job_location']['district'] ?? $countryName }}
                                    </span>
                                    <span class="small text-muted">
                                        <i class="bi bi-briefcase me-1"></i>
                                        {{ $job['job_type']['name'] ?? 'Full Time' }}
                                    </span>
                                    <span class="small text-primary">
                                        <i class="bi bi-currency-dollar me-1"></i>
                                        {{ $job['formatted_salary'] ?? 'Negotiable' }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Apply button & Date - Right side (inline) --}}
                            <div class="col-12 col-md-4">
                                <div class="d-flex align-items-center justify-content-start justify-content-md-end gap-3">
                                    <div class="small text-muted text-nowrap">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                                    </div>
                                    <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}" 
                                      class="btn btn-primary btn-sm text-nowrap">Apply Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          @if($pagination['last_page'] > 1)
          <nav class="d-flex justify-content-center mt-4">
            <ul class="pagination gap-1">
              @for($i = 1; $i <= $pagination['last_page']; $i++)
                <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                  <a class="page-link" href="{{ route('jobs.country.company', ['country' => $country, 'slug' => $slug, 'page' => $i]) }}">{{ $i }}</a>
                </li>
              @endfor
            </ul>
          </nav>
          @endif
          
        @else
          <div class="text-center py-5">
            <i class="bi bi-briefcase fs-1 text-muted opacity-50"></i>
            <p class="mt-3 text-muted">No active jobs at {{ $company['name'] }} in {{ $countryName }} right now.</p>
            <a href="{{ route('jobs.country.companies', ['country' => $country]) }}" class="btn btn-outline-primary btn-sm">Browse other companies</a>
          </div>
        @endif
        
        {{-- Similar Companies Section (Mobile - appears after job listings) --}}
        @if(isset($similarCompanies) && count($similarCompanies) > 0)
        <div class="mt-4 d-block d-lg-none">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-building me-2 text-primary"></i>Similar Companies ({{ count($similarCompanies) }})
                    </h6>
                    <div class="d-flex flex-column gap-2">
                        @foreach($similarCompanies as $similarCompany)
                            <a href="{{ route('jobs.country.company', ['country' => $country, 'slug' => $similarCompany['slug']]) }}" 
                              class="d-flex align-items-center gap-3 text-decoration-none p-2 rounded-2 hover-bg">
                                <div class="rounded-2 border flex-shrink-0 d-flex align-items-center justify-content-center" 
                                    style="width:40px;height:40px;background:#fff">
                                    @if(!empty($similarCompany['logo']))
                                        <img src="{{ $similarCompany['logo'] }}" alt="{{ $similarCompany['name'] }}" 
                                            style="width:100%;height:100%;object-fit:contain;padding:4px"
                                            onerror="this.src='{{ asset('default-logo.png') }}'">
                                    @else
                                        <i class="bi bi-building text-primary"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">{{ $similarCompany['name'] }}</div>
                                    @if(!empty($similarCompany['industry']['name']))
                                        <div class="text-muted" style="font-size:10px">{{ $similarCompany['industry']['name'] }}</div>
                                    @endif
                                </div>
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary" style="font-size:10px">
                                    {{ number_format($similarCompany['jobs_count'] ?? 0) }} jobs
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        
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