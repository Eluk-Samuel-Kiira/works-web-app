@extends('layouts.jobs')

@section('title', 'Jobs in Uganda — Browse ' . number_format($totalJobs ?? 0) . ' Opportunities | Stardena Works')
@section('meta_description', 'Browse ' . number_format($totalJobs ?? 0) . ' latest jobs, internships and careers in Uganda. Find full-time, part-time and remote opportunities on Stardena Works.')
@section('canonical', url('/jobs'))
@section('og_title', 'Jobs in Uganda | Stardena Works')
@section('og_description', 'Browse the latest jobs and careers in Uganda on Stardena Works.')

{{-- @section('new-badge', __("We're hiring! 50+ tech positions available")) --}}

@section('job-content')

<div class="main-wrapper">

  {{-- ─────────────────────────────────────────────────────
       AD SLOT 1 — Top Leaderboard (highest CPM, above fold)
  ───────────────────────────────────────────────────── --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block"
           data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
           data-ad-slot="1111111111"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- ─────────────────────────────────────────────────────
       HERO — SEARCH
  ───────────────────────────────────────────────────── --}}
  <section class="bg-primary py-5 py-lg-7">
    <div class="container-xl px-3 px-md-4">
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 text-center">
          <p class="text-white-50 text-uppercase small mb-2" style="letter-spacing:.1em">Stardena Works</p>
          <h1 class="text-white fw-bold mb-2" style="font-size:clamp(1.6rem,4vw,2.5rem)">
            Find your <span style="color:#fdd835">dream job</span> today
          </h1>
          <p class="text-white-50 mb-4" style="font-size:.9375rem">Browse thousands of verified listings from top organisations</p>

          {{-- Search bar --}}
          <form action="{{ route('jobs.search') }}" method="GET"
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
            <span class="text-white-50 small">Popular:</span>
            @foreach($popularSearches as $kw)
              <a href="{{ route('jobs.index', ['keyword' => $kw]) }}"
                 class="badge rounded-pill fw-normal text-white border border-white border-opacity-25 text-decoration-none"
                 style="background:rgba(255,255,255,.12);font-size:12px">{{ $kw }}</a>
            @endforeach
          </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- ─────────────────────────────────────────────────────
       CATEGORIES
  ───────────────────────────────────────────────────── --}}
  @if(isset($categories) && count($categories) > 0)
  <section class="py-4 py-lg-5 border-bottom">
    <div class="container-xl px-3 px-md-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h6 fw-semibold mb-0">Browse by category</h2>
        <a href="{{ route('jobs.index') }}" class="text-primary small text-decoration-none">
          View all <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>
      <div class="row g-2 g-md-3">
        @foreach($categories as $cat)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
          <a href="{{ route('jobs.index', ['category' => $cat->slug ?? $cat->id]) }}"
             class="card border rounded-3 text-center p-3 text-decoration-none h-100 category-card">
            <div class="mx-auto mb-2 rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                 style="width:40px;height:40px">
              <i class="bi {{ $cat->icon ?? 'bi-folder2' }} text-primary"></i>
            </div>
            <div class="fw-semibold text-body" style="font-size:12px;line-height:1.3">{{ $cat->name }}</div>
            <div class="text-muted mt-1" style="font-size:11px">{{ number_format($cat->jobs_count ?? 0) }} jobs</div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- ─────────────────────────────────────────────────────
       FEATURED JOBS
  ───────────────────────────────────────────────────── --}}
  @if(isset($featuredJobs) && count($featuredJobs) > 0)
  <section class="py-4 py-lg-5 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h6 fw-semibold mb-0">Featured jobs</h2>
        <a href="{{ route('jobs.index', ['featured' => true]) }}" class="text-primary small text-decoration-none">
          View all <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>
      <div class="row g-3">
        @foreach($featuredJobs as $job)
        <div class="col-12 col-lg-6">
          <div class="card border rounded-3 shadow-sm h-100 featured-job-card">
            <div class="card-body p-3 p-md-4 d-flex flex-column gap-3">

              {{-- Header --}}
              <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between gap-2">
                  @if(!empty($job['company']['logo']))
                    <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] }}"
                         width="48" height="48" class="rounded-2 border" style="object-fit:cover">
                  @else
                    <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;flex-shrink:0">
                      <i class="bi bi-building fs-5 text-primary"></i>
                    </div>
                  @endif
                  <span class="badge text-bg-primary fw-normal ms-auto" style="font-size:11px">Featured</span>
                </div>
                <div class="min-w-0">
                  <h3 class="h6 fw-semibold mb-1 text-truncate">
                    <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                       class="text-body text-decoration-none">{{ $job['job_title'] }}</a>
                  </h3>
                  <div class="d-flex flex-wrap text-muted" style="font-size:12px;gap:3px 10px">
                    <span><i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? '—' }}</span>
                    <span><i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $job['job_location']['name'] ?? 'Remote' }}</span>
                  </div>
                </div>
              </div>

              {{-- Excerpt --}}
              <p class="text-body-secondary mb-0" style="font-size:.8125rem;line-height:1.6">
                {{ Str::limit(strip_tags($job['job_description']), 120) }}
              </p>

              {{-- Tags --}}
              <div class="d-flex flex-wrap gap-2">
                <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:11px">
                  {{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}
                </span>
                @if(!empty($job['experience_level']['name']))
                <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:11px">
                  {{ $job['experience_level']['name'] }}
                </span>
                @endif
                <span class="badge rounded-pill fw-normal text-primary" style="font-size:11px;background:rgba(var(--bs-primary-rgb),.1)">
                  {{ $job['formatted_salary'] ?? 'Negotiable' }}
                </span>
              </div>

              {{-- Footer --}}
              <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                <span class="text-muted" style="font-size:12px">
                  <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                </span>
                <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                   class="btn btn-outline-primary btn-sm fw-semibold">Apply Now</a>
              </div>

            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- ─────────────────────────────────────────────────────
       AD SLOT 2 — In-feed (after featured, high viewability)
  ───────────────────────────────────────────────────── --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block;text-align:center"
           data-ad-layout="in-article"
           data-ad-format="fluid"
           data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
           data-ad-slot="2222222222"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- ─────────────────────────────────────────────────────
       ALL JOBS LIST
  ───────────────────────────────────────────────────── --}}
  <section class="py-4 py-lg-5">
    <div class="container-xl px-3 px-md-4">

      {{-- Section header + sort --}}
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <h2 class="h6 fw-semibold mb-0">
          Latest jobs
          @if(isset($pagination['total']))
            <span class="badge rounded-pill fw-normal ms-1 text-primary"
                  style="font-size:11px;background:rgba(var(--bs-primary-rgb),.1)">
              {{ number_format($pagination['total']) }}
            </span>
          @endif
        </h2>
        <div class="d-flex align-items-center gap-2">
          <form action="{{ route('jobs.index') }}" method="GET" class="d-flex align-items-center gap-2">
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
          <a href="{{ route('jobs.index') }}" class="text-muted small text-decoration-none" title="Clear filters">
            <i class="bi bi-x-circle me-1"></i><span class="d-none d-sm-inline">Clear</span>
          </a>
          @endif
        </div>
      </div>

      @if(isset($jobs) && count($jobs) > 0)

      <div class="row g-3">
        @foreach($jobs as $index => $job)

          {{-- AD SLOT 3 — Mid-list native ad, every 10 items --}}
          @if($index > 0 && $index % 10 === 0)
          <div class="col-12">
            <div class="border rounded-3 py-1 px-3 text-center bg-body">
              <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
              <ins class="adsbygoogle" style="display:block"
                   data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                   data-ad-slot="3333333333"
                   data-ad-format="auto"
                   data-full-width-responsive="true"></ins>
              <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
          </div>
          @endif

          <div class="col-12 col-lg-6">
            <div class="card border rounded-3 shadow-sm h-100 job-list-card">
              <div class="card-body p-3 d-flex flex-column gap-2">

                {{-- Header --}}
                <div class="d-flex flex-column gap-2">
                  <div class="d-flex align-items-center justify-content-between gap-2">
                    @if(!empty($job['company']['logo']))
                      <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] }}"
                           width="40" height="40" class="rounded-2 border" style="object-fit:cover" loading="lazy">
                    @else
                      <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center"
                           style="width:40px;height:40px;flex-shrink:0">
                        <i class="bi bi-building text-primary" style="font-size:14px"></i>
                      </div>
                    @endif
                    @if($job['is_urgent'] ?? false)
                      <span class="badge text-bg-danger fw-normal ms-auto" style="font-size:11px">Urgent</span>
                    @endif
                  </div>
                  <div class="min-w-0">
                    <h3 class="fw-semibold mb-0 text-truncate" style="font-size:.9rem">
                      <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                         class="text-body text-decoration-none">{{ $job['job_title'] }}</a>
                    </h3>
                    <div class="d-flex flex-wrap text-muted" style="font-size:12px;gap:2px 8px;margin-top:2px">
                      <span><i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? '—' }}</span>
                      @if(!empty($job['duty_station']) || !empty($job['job_location']))
                      <span><i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</span>
                      @endif
                    </div>
                  </div>
                </div>

                {{-- Tags --}}
                <div class="d-flex flex-wrap gap-1">
                  <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:11px">
                    {{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}
                  </span>
                  @if(!empty($job['experience_level']['name']))
                  <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:11px">
                    {{ $job['experience_level']['name'] }}
                  </span>
                  @endif
                  <span class="badge rounded-pill fw-normal text-primary" style="font-size:11px;background:rgba(var(--bs-primary-rgb),.1)">
                    {{ $job['formatted_salary'] ?? 'Negotiable' }}
                  </span>
                </div>

                {{-- Footer --}}
                <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto">
                  <span class="text-muted" style="font-size:12px">
                    <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                  </span>
                  <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                     class="btn btn-primary btn-sm fw-semibold">
                    Apply <i class="bi bi-arrow-right-short"></i>
                  </a>
                </div>

              </div>
            </div>
          </div>

        @endforeach
      </div>

      {{-- ── PAGINATION ── --}}
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
               href="{{ $cur > 1 ? route('jobs.index', array_merge($q, ['page' => $cur - 1])) : '#' }}"
               aria-label="Previous">
              <i class="bi bi-chevron-left" style="font-size:11px"></i>
            </a>
          </li>

          @if($start > 1)
            <li class="page-item">
              <a class="page-link rounded-2" style="padding:6px 12px"
                 href="{{ route('jobs.index', array_merge($q, ['page' => 1])) }}">1</a>
            </li>
            @if($start > 2)
              <li class="page-item disabled">
                <span class="page-link border-0 bg-transparent px-1">…</span>
              </li>
            @endif
          @endif

          @for($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $cur ? 'active' : '' }}">
              @if($i == $cur)
                <span class="page-link rounded-2" style="padding:6px 12px">{{ $i }}</span>
              @else
                <a class="page-link rounded-2" style="padding:6px 12px"
                   href="{{ route('jobs.index', array_merge($q, ['page' => $i])) }}">{{ $i }}</a>
              @endif
            </li>
          @endfor

          @if($end < $last)
            @if($end < $last - 1)
              <li class="page-item disabled">
                <span class="page-link border-0 bg-transparent px-1">…</span>
              </li>
            @endif
            <li class="page-item">
              <a class="page-link rounded-2" style="padding:6px 12px"
                 href="{{ route('jobs.index', array_merge($q, ['page' => $last])) }}">{{ $last }}</a>
            </li>
          @endif

          <li class="page-item {{ $cur >= $last ? 'disabled' : '' }}">
            <a class="page-link rounded-2" style="padding:6px 12px"
               href="{{ $cur < $last ? route('jobs.index', array_merge($q, ['page' => $cur + 1])) : '#' }}"
               aria-label="Next">
              <i class="bi bi-chevron-right" style="font-size:11px"></i>
            </a>
          </li>

        </ul>
      </nav>
      @endif

      @else
      <div class="text-center py-5">
        <i class="bi bi-briefcase fs-1 text-muted opacity-50"></i>
        <p class="mt-3 text-muted">No jobs found matching your criteria.</p>
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm">Clear filters</a>
      </div>
      @endif

    </div>
  </section>

  {{-- ─────────────────────────────────────────────────────
       AD SLOT 4 — Pre-CTA (high intent, best CTR)
  ───────────────────────────────────────────────────── --}}
  <div class="bg-body border-top border-bottom py-2 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block"
           data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
           data-ad-slot="4444444444"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- ─────────────────────────────────────────────────────
       CTA SECTION
  ───────────────────────────────────────────────────── --}}
  <section class="bg-primary py-5">
    <div class="container-xl px-3 px-md-4">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
          <p class="text-white-50 small text-uppercase mb-2" style="letter-spacing:.1em">Take the next step</p>
          <h2 class="text-white fw-semibold fs-4 mb-2">Ready to start your career journey?</h2>
          <p class="text-white-50 small mb-4">Join thousands of professionals who found their dream jobs through Stardena Works.</p>
          <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
            <a href="javascript:void(0);" onclick="comingSoon()" class="btn btn-light fw-semibold px-4">
              <i class="bi bi-person-plus me-2"></i>Create Account
            </a>
            <a href="javascript:void(0);" onclick="comingSoon()" class="btn btn-outline-light fw-semibold px-4">
              <i class="bi bi-briefcase me-2"></i>Post a Job
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ─────────────────────────────────────────────────────
       AD SLOT 5 — Footer banner (low intrusion, high fill rate)
  ───────────────────────────────────────────────────── --}}
  <div class="bg-body border-top py-2 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block"
           data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
           data-ad-slot="5555555555"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

</div>{{-- /.main-wrapper --}}

@endsection

@push('styles')
<style>
.container-xl { max-width: 1280px; }

/* Category cards */
.category-card { transition: border-color .15s, box-shadow .15s, transform .15s; }
.category-card:hover {
  border-color: var(--bs-primary) !important;
  box-shadow: 0 2px 10px rgba(var(--bs-primary-rgb),.12) !important;
  transform: translateY(-2px);
}

/* Featured + list cards */
.featured-job-card,
.job-list-card { transition: border-color .15s, box-shadow .15s; }
.featured-job-card:hover,
.job-list-card:hover {
  border-color: var(--bs-primary) !important;
  box-shadow: 0 2px 10px rgba(var(--bs-primary-rgb),.1) !important;
}

/* Pagination */
.pagination .page-link { color: var(--bs-primary); font-size: 13px; font-weight: 500; }
.pagination .page-item.active .page-link { background-color: var(--bs-primary); border-color: var(--bs-primary); color: #fff; }
.pagination .page-item.disabled .page-link { color: var(--bs-secondary-color); }

/* Search bar location field — left border on sm+ */
@media (min-width: 576px) {
  .border-sm-top-0  { border-top: 0 !important; }
  .border-sm-start  { border-left: 1px solid var(--bs-border-color) !important; }
}
</style>
@endpush