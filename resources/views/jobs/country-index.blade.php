@extends('layouts.jobs')

@php
    $countryNames = [
        'ke' => 'Kenya',
        'ug' => 'Uganda',
        'ng' => 'Nigeria',
        'tz' => 'Tanzania',
        'rw' => 'Rwanda',
        'bi' => 'Burundi',
        'ss' => 'South Sudan',
        'za' => 'South Africa',
    ];
    $countryName = $countryNames[$country] ?? ucfirst($country);
    $countryUpper = strtoupper($country);
@endphp

@section('title', "Jobs in {$countryName} — Browse " . number_format($totalJobs ?? 0) . " Opportunities | Stardena Works")
@section('meta_description', "Browse " . number_format($totalJobs ?? 0) . " latest jobs, internships and careers in {$countryName}. Find full-time, part-time and remote opportunities on Stardena Works.")
@section('canonical', url("/{$country}/jobs"))
@section('og_title', "Jobs in {$countryName} | Stardena Works")
@section('og_description', "Browse the latest jobs and careers in {$countryName} on Stardena Works.")

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

  {{-- HERO — Country-specific SEARCH --}}
  <section class="bg-primary py-5 py-lg-7">
    <div class="container-xl px-3 px-md-4">
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 text-center">
          <p class="text-white-50 text-uppercase small mb-2" style="letter-spacing:.1em">Stardena Works {{ $countryName }}</p>
          <h1 class="text-white fw-bold mb-2" style="font-size:clamp(1.6rem,4vw,2.5rem)">
            Find your <span style="color:#fdd835">dream job</span> in {{ $countryName }}
          </h1>
          <p class="text-white-50 mb-4" style="font-size:.9375rem">{{ number_format($totalJobs ?? 0) }}+ verified opportunities from top employers</p>

          {{-- Search bar - points to country-specific route --}}
          <form action="{{ route('jobs.country.index', ['country' => $country]) }}" method="GET"
                class="bg-white rounded-3 shadow p-2 d-flex flex-column flex-sm-row gap-2 align-items-stretch">
            <div class="d-flex align-items-center flex-grow-1 px-2">
              <i class="bi bi-search text-muted me-2 flex-shrink-0"></i>
              <input type="text" name="keyword" class="form-control border-0 p-0 shadow-none"
                     placeholder="Job title, keyword or company"
                     value="{{ request('keyword') }}" aria-label="Keywords">
            </div>
            <div class="d-flex align-items-center flex-grow-1 px-2 border-top border-sm-top-0 border-sm-start pt-2 pt-sm-0">
              <i class="bi bi-geo-alt text-muted me-2 flex-shrink-0"></i>
              <input type="text" name="location" class="form-control border-0 p-0 shadow-none"
                     placeholder="City or Remote"
                     value="{{ request('location') }}" aria-label="Location">
            </div>
            <button type="submit" class="btn btn-primary fw-semibold px-4 flex-shrink-0">
              Search Jobs
            </button>
          </form>

          {{-- Popular searches --}}
          @if(isset($popularSearches) && count($popularSearches) > 0)
          <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3">
            <span class="text-white-50 small">Popular in {{ $countryName }}:</span>
            @foreach($popularSearches as $kw)
              <a href="{{ route('jobs.country.index', ['country' => $country, 'keyword' => $kw]) }}"
                 class="badge rounded-pill fw-normal text-white border border-white border-opacity-25 text-decoration-none"
                 style="background:rgba(255,255,255,.12);font-size:12px">{{ $kw }}</a>
            @endforeach
          </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- FEATURED JOBS --}}
  @if(isset($featuredJobs) && count($featuredJobs) > 0)
  <section class="py-4 py-lg-5 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h6 fw-semibold mb-0">Featured jobs in {{ $countryName }}</h2>
        <a href="{{ route('jobs.country.index', ['country' => $country, 'featured' => true]) }}" class="text-primary small text-decoration-none">
          View all <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>
      <div class="row g-3">
        @foreach($featuredJobs as $job)
        <div class="col-12 col-lg-6">
          <div class="card border rounded-3 shadow-sm h-100 featured-job-card">
            <div class="card-body p-3 p-md-4 d-flex flex-column gap-3">
              <div class="d-flex align-items-start gap-3 position-relative">
                  @php $logoUrl = companyLogo($job['company'] ?? null); @endphp
                  @if($logoUrl)
                      <img src="{{ $logoUrl }}"
                          alt="{{ $job['company']['name'] ?? 'Company' }}"
                          width="48" height="48"
                          class="rounded-2 border flex-shrink-0"
                          style="object-fit:contain; background:#fff; padding:4px;"
                          loading="lazy"
                          onerror="this.src='{{ asset('default-logo.png') }}';">
                  @else
                      <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px;height:48px">
                          <i class="bi bi-building fs-5 text-primary"></i>
                      </div>
                  @endif
                  <div class="flex-grow-1 min-w-0 pe-5">
                      <h3 class="h6 fw-semibold mb-1" style="font-size:.85rem; line-height:1.4;">
                          <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}"
                            class="text-body text-decoration-none">
                              {{ $job['job_title'] }}
                          </a>
                      </h3>
                      <div class="d-flex flex-wrap text-muted" style="font-size:11px;gap:3px 12px">
                          <span><i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? '—' }}</span>
                          <span><i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</span>
                      </div>
                  </div>
                  <span class="badge text-bg-primary fw-normal position-absolute top-0 end-0" style="font-size:10px; white-space:nowrap;">Featured</span>
              </div>
              <p class="text-body-secondary mb-0" style="font-size:.75rem;line-height:1.5">
                {{ Str::limit(strip_tags($job['job_description']), 100) }}
              </p>
              <div class="d-flex flex-wrap gap-2">
                <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:10px">
                  {{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}
                </span>
                <span class="badge rounded-pill fw-normal text-primary" style="font-size:10px;background:rgba(var(--bs-primary-rgb),.1)">
                  {{ $job['formatted_salary'] ?? 'Negotiable' }}
                </span>
              </div>
              <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                <span class="text-muted" style="font-size:11px">
                  <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                </span>
                <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}"
                   class="btn btn-outline-primary btn-sm fw-semibold py-1 px-3" style="font-size:12px">Apply Now</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- AD SLOT 2 — After Featured Jobs --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
          style="display:block"
          data-ad-client="ca-pub-3587587638253109"
          data-ad-slot="8206210573"
          data-ad-format="auto"
          data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- ALL JOBS LIST --}}
  <section class="py-4 py-lg-5">
    <div class="container-xl px-3 px-md-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <h2 class="h6 fw-semibold mb-0">
          Latest jobs in {{ $countryName }}
          @if(isset($pagination['total']))
            <span class="badge rounded-pill fw-normal ms-1 text-primary"
                  style="font-size:11px;background:rgba(var(--bs-primary-rgb),.1)">
              {{ number_format($pagination['total']) }}
            </span>
          @endif
        </h2>
        <div class="d-flex align-items-center gap-2">
          <form action="{{ route('jobs.country.index', ['country' => $country]) }}" method="GET" class="d-flex align-items-center gap-2">
            <label class="text-muted small mb-0 d-none d-sm-inline">Sort:</label>
            <select name="sort" class="form-select form-select-sm" style="width:130px"
                    onchange="this.form.submit()" aria-label="Sort jobs">
              <option value="newest"      {{ request('sort')=='newest'      ? 'selected':'' }}>Newest</option>
              <option value="oldest"      {{ request('sort')=='oldest'      ? 'selected':'' }}>Oldest</option>
              <option value="salary_high" {{ request('sort')=='salary_high' ? 'selected':'' }}>Salary ↑</option>
              <option value="salary_low"  {{ request('sort')=='salary_low'  ? 'selected':'' }}>Salary ↓</option>
            </select>
          </form>
          @if(request()->anyFilled(['sort','keyword','location','category']))
          <a href="{{ route('jobs.country.index', ['country' => $country]) }}" class="text-muted small text-decoration-none" title="Clear filters">
            <i class="bi bi-x-circle me-1"></i><span class="d-none d-sm-inline">Clear</span>
          </a>
          @endif
        </div>
      </div>

      @if(isset($jobs) && count($jobs) > 0)
      <div class="row g-3">
        @foreach($jobs as $index => $job)

          {{-- AD SLOT 3 — After every 10 job listings --}}
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
            <div class="card border rounded-3 shadow-sm h-100 job-list-card">
              <div class="card-body p-3">
                <div class="d-flex gap-3">
                  @php $logoUrl = companyLogo($job['company'] ?? null); @endphp
                  @if($logoUrl)
                    <img src="{{ $logoUrl }}"
                        alt="{{ $job['company']['name'] ?? 'Company' }}"
                        width="48" height="48"
                        class="rounded-2 border flex-shrink-0"
                        style="object-fit:contain; background:#fff; padding:3px;"
                        loading="lazy"
                        onerror="this.src='{{ asset('default-logo.png') }}';">
                  @else
                    <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px;height:48px">
                      <i class="bi bi-building fs-5 text-primary"></i>
                    </div>
                  @endif
                  <div class="flex-grow-1 min-w-0">
                    <h3 class="fw-semibold mb-1" style="font-size:.85rem; line-height:1.35;">
                      <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}"
                         class="text-body text-decoration-none">
                        {{ $job['job_title'] }}
                      </a>
                    </h3>
                    <div class="d-flex flex-wrap text-muted" style="font-size:10px; gap:2px 8px">
                      <span><i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? '—' }}</span>
                      <span><i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</span>
                    </div>
                  </div>
                </div>
                <div class="d-flex flex-wrap gap-1 mt-2 pt-1">
                  <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:9px">
                    {{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}
                  </span>
                  <span class="badge rounded-pill fw-normal text-primary" style="font-size:9px;background:rgba(var(--bs-primary-rgb),.1)">
                    {{ $job['formatted_salary'] ?? 'Negotiable' }}
                  </span>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 mt-2 border-top">
                  <span class="text-muted" style="font-size:10px">
                    <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                  </span>
                  <a href="{{ route('jobs.country.show', ['country' => $country, 'slug' => $job['slug']]) }}"
                     class="btn btn-primary btn-sm fw-semibold py-1 px-2" style="font-size:11px">
                    Apply <i class="bi bi-arrow-right-short"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- PAGINATION --}}
      @if(isset($pagination) && $pagination['last_page'] > 1)
      @php
        $cur   = $pagination['current_page'];
        $last  = $pagination['last_page'];
        $start = max(1, $cur - 2);
        $end   = min($last, $cur + 2);
        $q     = request()->query();
      @endphp
      <nav class="d-flex justify-content-center mt-4" aria-label="Page navigation">
        <ul class="pagination gap-1 flex-wrap justify-content-center mb-0">
          <li class="page-item {{ $cur <= 1 ? 'disabled' : '' }}">
            <a class="page-link rounded-2" style="padding:6px 12px"
               href="{{ $cur > 1 ? route('jobs.country.index', array_merge($q, ['country' => $country, 'page' => $cur - 1])) : '#' }}"
               aria-label="Previous">
              <i class="bi bi-chevron-left" style="font-size:11px"></i>
            </a>
          </li>
          @if($start > 1)
            <li class="page-item"><a class="page-link rounded-2" href="{{ route('jobs.country.index', array_merge($q, ['country' => $country, 'page' => 1])) }}">1</a></li>
            @if($start > 2)<li class="page-item disabled"><span class="page-link border-0 bg-transparent px-1">…</span></li>@endif
          @endif
          @for($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $cur ? 'active' : '' }}">
              @if($i == $cur)
                <span class="page-link rounded-2">{{ $i }}</span>
              @else
                <a class="page-link rounded-2" href="{{ route('jobs.country.index', array_merge($q, ['country' => $country, 'page' => $i])) }}">{{ $i }}</a>
              @endif
            </li>
          @endfor
          @if($end < $last)
            @if($end < $last - 1)<li class="page-item disabled"><span class="page-link border-0 bg-transparent px-1">…</span></li>@endif
            <li class="page-item"><a class="page-link rounded-2" href="{{ route('jobs.country.index', array_merge($q, ['country' => $country, 'page' => $last])) }}">{{ $last }}</a></li>
          @endif
          <li class="page-item {{ $cur >= $last ? 'disabled' : '' }}">
            <a class="page-link rounded-2" href="{{ $cur < $last ? route('jobs.country.index', array_merge($q, ['country' => $country, 'page' => $cur + 1])) : '#' }}"><i class="bi bi-chevron-right"></i></a>
          </li>
        </ul>
      </nav>
      @endif
      @else
      <div class="text-center py-5">
        <i class="bi bi-briefcase fs-1 text-muted opacity-50"></i>
        <p class="mt-3 text-muted">No jobs found matching your criteria in {{ $countryName }}.</p>
        <a href="{{ route('jobs.country.index', ['country' => $country]) }}" class="btn btn-outline-primary btn-sm">Clear filters</a>
      </div>
      @endif
    </div>
  </section>

  {{-- AD SLOT 4 — Before CTA --}}
  <div class="bg-body border-top border-bottom py-2 text-center">
    <div class="container-xl px-3 px-md-4">
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

  {{-- CTA SECTION --}}
  <section class="bg-primary py-5">
    <div class="container-xl px-3 px-md-4">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
          <p class="text-white-50 small text-uppercase mb-2" style="letter-spacing:.1em">Take the next step</p>
          <h2 class="text-white fw-semibold fs-4 mb-2">Ready to start your career journey?</h2>
          <p class="text-white-50 small mb-4">Join thousands of professionals who found their dream jobs through Stardena Works.</p>
          <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
            <a href="javascript:void(0)" onclick="signupToBegin()" class="btn btn-light fw-semibold px-4">
              <i class="bi bi-person-plus me-2"></i>Create Account
            </a>
            <a href="javascript:void(0)" onclick="signupToBegin()" class="btn btn-outline-light fw-semibold px-4">
              <i class="bi bi-briefcase me-2"></i>Post a Job
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- AD SLOT 5 — Footer Banner --}}
  <div class="bg-body border-top py-2 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-3587587638253109"
        data-ad-slot="5875560702"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

</div>
@endsection