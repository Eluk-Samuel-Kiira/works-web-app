@extends('layouts.jobs')

@section('title', "Companies Hiring in {$countryName} | Stardena Works")
@section('meta_description', "Browse top companies hiring in {$countryName}. Find company profiles, open positions and apply directly on Stardena Works.")
@section('canonical', url("/{$country}/companies"))
@section('robots', 'index, follow')

@section('job-content')
<div class="main-wrapper">

  {{-- AD SLOT 1 --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-fluid">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-3587587638253109"
        data-ad-slot="8711079786"
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
          <li class="breadcrumb-item text-white active">Companies</li>
        </ol>
      </nav>
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
        <div>
          <h1 class="text-white fw-bold mb-1" style="font-size:clamp(1.3rem,3vw,1.9rem)">
            Companies <span style="color:#fdd835">Hiring</span> in {{ $countryName }}
          </h1>
          <p class="text-white-50 mb-0 small">
            {{ number_format($pagination['total']) }} organisations actively recruiting
          </p>
        </div>
        {{-- Search --}}
        <form method="GET" action="{{ route('jobs.country.companies', ['country' => $country]) }}"
              class="d-flex gap-2" style="min-width:280px;max-width:400px">
          <div class="input-group">
            <span class="input-group-text bg-white border-0">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="search"
                   class="form-control border-0 shadow-none"
                   placeholder="Search companies..."
                   value="{{ $search ?? '' }}">
            @if(!empty($search))
            <a href="{{ route('jobs.country.companies', ['country' => $country]) }}" class="btn btn-light border-0" title="Clear">
              <i class="bi bi-x"></i>
            </a>
            @endif
            <button type="submit" class="btn btn-light border-0 fw-semibold">
              Search
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container-xl px-3 px-md-4 py-4">

    @if(!empty($search))
    <p class="text-muted small mb-3">
      Showing results for <strong>"{{ $search }}"</strong> —
      <a href="{{ route('jobs.country.companies', ['country' => $country]) }}" class="text-primary">clear search</a>
    </p>
    @endif

    @if(count($companies) > 0)
    <div class="row g-3">
      @foreach($companies as $index => $company)

        {{-- AD every 12 companies --}}
        @if($index > 0 && $index % 12 === 0)
        <div class="col-12">
          <div class="border rounded-3 py-3 px-3 text-center bg-light">
            <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
            <ins class="adsbygoogle"
              style="display:block"
              data-ad-client="ca-pub-3587587638253109"
              data-ad-slot="2939878350"
              data-ad-format="auto"
              data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
          </div>
        </div>
        @endif

        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card border rounded-3 shadow-sm h-100 company-card">
            <div class="card-body p-3 p-md-4 d-flex flex-column gap-3">
              <div class="d-flex align-items-start gap-3">
                  @php $logoUrl = companyLogo($company); @endphp
                  <div class="rounded-2 border flex-shrink-0 overflow-hidden d-flex align-items-center justify-content-center"
                      style="width:52px;height:52px;background:#fff">
                      @if($logoUrl)
                          <img src="{{ $logoUrl }}"
                              alt="{{ $company['name'] ?? 'Company' }}"
                              width="52" height="52"
                              loading="lazy"
                              style="width:100%;height:100%;object-fit:contain;padding:4px"
                              onerror="this.src='{{ asset('default-logo.png') }}';">
                      @else
                          <img src="{{ asset('default-logo.png') }}"
                              alt="Default logo"
                              width="52" height="52"
                              style="width:100%;height:100%;object-fit:contain;padding:4px">
                      @endif
                  </div>
                  <div class="min-w-0 flex-grow-1 text-start">
                      <div class="fw-semibold text-body" style="font-size:clamp(0.75rem, 3vw, 0.875rem);">
                          {{ $company['name'] ?? 'Unknown' }}
                      </div>
                      @if(!empty($company['industry']['name']))
                      <div class="text-muted" style="font-size:clamp(10px, 2.5vw, 12px);">
                          {{ $company['industry']['name'] }}
                      </div>
                      @endif
                      @if(!empty($company['location']['district']))
                      <div class="text-muted mt-1" style="font-size:clamp(10px, 2.5vw, 11px);">
                          <i class="bi bi-geo-alt me-1"></i>
                          {{ $company['location']['district'] }}, {{ $company['location']['country'] }}
                      </div>
                      @endif
                      @if($company['is_verified'] ?? false)
                      <span class="badge text-bg-success fw-normal mt-1" style="font-size:9px">
                          <i class="bi bi-patch-check me-1"></i>Verified
                      </span>
                      @endif
                  </div>
              </div>

              @if(!empty($company['description']))
              <p class="text-body-secondary mb-0" style="font-size:clamp(11px, 2.5vw, 12px);line-height:1.55;
                        display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                  {{ Str::limit(strip_tags($company['description']), 100) }}
              </p>
              @endif

              <div class="d-flex flex-wrap gap-2 mt-auto">
                @if(!empty($company['company_size']))
                <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary"
                      style="font-size:clamp(9px, 2vw, 11px); padding:4px 8px;">
                  <i class="bi bi-people me-1"></i>{{ $company['company_size'] }}
                </span>
                @endif
                @if(($company['jobs_count'] ?? 0) > 0)
                <span class="badge rounded-pill fw-normal text-primary"
                      style="font-size:clamp(9px, 2vw, 11px); padding:4px 8px; background:rgba(var(--bs-primary-rgb),.1)">
                  <i class="bi bi-briefcase me-1"></i>
                  {{ number_format($company['jobs_count']) }} open {{ Str::plural('job', $company['jobs_count']) }}
                </span>
                @endif
              </div>

              <div class="d-flex gap-2 pt-2 border-top">
                <a href="{{ route('jobs.country.company', ['country' => $country, 'slug' => $company['slug']]) }}"
                  class="btn btn-primary btn-sm fw-semibold flex-grow-1">
                    <i class="bi bi-briefcase me-1"></i>
                    View Jobs
                </a>
                @if(!empty($company['website']))
                <a href="{{ $company['website'] }}" target="_blank" rel="noopener noreferrer"
                  class="btn btn-outline-secondary btn-sm px-2" title="Visit website">
                    <i class="bi bi-globe"></i>
                </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    @if($pagination['last_page'] > 1)
    @php
      $cur  = $pagination['current_page'];
      $last = $pagination['last_page'];
      $q    = array_filter(request()->only(['search']));
    @endphp
    <nav class="d-flex justify-content-center mt-4">
      <ul class="pagination gap-1 flex-wrap justify-content-center mb-0">
        <li class="page-item {{ $cur <= 1 ? 'disabled' : '' }}">
          <a class="page-link rounded-2" href="{{ $cur > 1 ? route('jobs.country.companies', array_merge(['country' => $country], $q, ['page' => $cur - 1])) : '#' }}">
            <i class="bi bi-chevron-left"></i>
          </a>
        </li>
        @for($i = max(1, $cur - 2); $i <= min($last, $cur + 2); $i++)
          <li class="page-item {{ $i == $cur ? 'active' : '' }}">
            @if($i == $cur)
              <span class="page-link rounded-2">{{ $i }}</span>
            @else
              <a class="page-link rounded-2" href="{{ route('jobs.country.companies', array_merge(['country' => $country], $q, ['page' => $i])) }}">{{ $i }}</a>
            @endif
          </li>
        @endfor
        <li class="page-item {{ $cur >= $last ? 'disabled' : '' }}">
          <a class="page-link rounded-2" href="{{ $cur < $last ? route('jobs.country.companies', array_merge(['country' => $country], $q, ['page' => $cur + 1])) : '#' }}">
            <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      </ul>
    </nav>
    @endif

    @else
    <div class="text-center py-5">
      <i class="bi bi-building fs-1 text-muted opacity-50 d-block mb-3"></i>
      @if(!empty($search))
        <p class="text-muted">No companies found for "{{ $search }}" in {{ $countryName }}.</p>
        <a href="{{ route('jobs.country.companies', ['country' => $country]) }}" class="btn btn-outline-primary btn-sm">
          View all companies
        </a>
      @else
        <p class="text-muted">No companies found in {{ $countryName }}.</p>
      @endif
    </div>
    @endif
  </div>
</div>
@endsection