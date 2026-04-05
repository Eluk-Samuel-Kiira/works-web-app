@extends('layouts.jobs')

@php
    $catName    = $categoryData['name'] ?? ucfirst(str_replace('-', ' ', request()->segment(3)));
    $totalCount = $pagination['total'] ?? 0;
@endphp

@section('title',            "{$catName} Jobs in Uganda — " . number_format($totalCount) . " Listings | Stardena Works")
@section('meta_description', "Browse " . number_format($totalCount) . " {$catName} jobs in Uganda. Find the latest {$catName} opportunities, salaries and apply directly on Stardena Works.")
@section('canonical',        url('/jobs/category/' . ($categoryData['slug'] ?? '')))
@section('robots',           'index, follow')
@section('og_title',         "{$catName} Jobs in Uganda | Stardena Works")
@section('og_description',   "Find {$catName} jobs in Uganda. Browse verified listings from top organisations.")

@section('job-content')
<div class="main-wrapper">

  {{-- AD SLOT 1 — Top leaderboard --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-fluid">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle" style="display:block"
           data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
           data-ad-slot="1111111111"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

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
            {{ $catName }} Jobs in Uganda
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
          <div class="mb-4 text-center">
            <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
            <ins class="adsbygoogle" style="display:block"
                 data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                 data-ad-slot="3333333333"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
          </div>

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
            <div class="col-12">
              <div class="border rounded-3 py-1 px-3 text-center bg-body">
                <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
                <ins class="adsbygoogle" style="display:block"
                     data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                     data-ad-slot="2222222222"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
              </div>
            </div>
            @endif

            <div class="col-12 col-md-6">
              <div class="card border rounded-3 shadow-sm h-100 job-list-card">
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
                      <h3 class="fw-semibold mb-0 text-truncate" style="font-size:.875rem">
                        <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                           class="text-body text-decoration-none">{{ $job['job_title'] }}</a>
                      </h3>
                      <div class="text-muted" style="font-size:12px">
                        <i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? '—' }}
                        <span class="mx-1">·</span>
                        <i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $job['job_location']['district'] ?? 'Uganda' }}
                      </div>
                    </div>
                  </div>
                  <div class="d-flex flex-wrap gap-1">
                    <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:11px">
                      {{ $job['job_type']['name'] ?? 'Full Time' }}
                    </span>
                    <span class="badge rounded-pill fw-normal text-primary" style="font-size:11px;background:rgba(var(--bs-primary-rgb),.1)">
                      {{ $job['formatted_salary'] ?? 'Negotiable' }}
                    </span>
                    @if($job['is_featured'] ?? false)
                    <span class="badge rounded-pill text-bg-primary fw-normal" style="font-size:11px">Featured</span>
                    @endif
                  </div>
                  <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto">
                    <span class="text-muted" style="font-size:12px">
                      <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}
                    </span>
                    <a href="{{ route('jobs.show', $job['slug'] ?? $job['id']) }}"
                       class="btn btn-primary btn-sm fw-semibold">Apply</a>
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
        <div class="mt-4 text-center">
          <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
          <ins class="adsbygoogle" style="display:block"
               data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
               data-ad-slot="4444444444"
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
.hover-bg:hover { background: rgba(var(--bs-primary-rgb),.08); }
.job-list-card { transition: border-color .15s, box-shadow .15s; }
.job-list-card:hover { border-color: var(--bs-primary) !important; box-shadow: 0 2px 10px rgba(var(--bs-primary-rgb),.1) !important; }
</style>
@endpush