@extends('layouts.jobs')

@section('title', __('Job Details - Stardena Works'))

{{-- @section('new-badge', __("We're hiring! 50+ tech positions available")) --}}

@section('job-content')

@php
  $shareBtns = [
    ['id' => 'whatsapp',  'tip' => 'WhatsApp',   'color' => '#25D366',
     'svg' => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.126.554 4.118 1.527 5.845L.057 23.493a.5.5 0 0 0 .613.612l5.701-1.463A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 0 1-5.021-1.377l-.36-.214-3.733.957.986-3.643-.234-.374A9.818 9.818 0 1 1 12 21.818z"/>'],
    ['id' => 'facebook',  'tip' => 'Facebook',   'color' => '#1877F2',
     'svg' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>'],
    ['id' => 'twitter',   'tip' => 'X / Twitter', 'color' => '#000000',
     'svg' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
    ['id' => 'linkedin',  'tip' => 'LinkedIn',    'color' => '#0A66C2',
     'svg' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
    ['id' => 'telegram',  'tip' => 'Telegram',    'color' => '#229ED9',
     'svg' => '<path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.96 6.504-1.356 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>'],
  ];
  $daysLeft = isset($job['deadline']) ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($job['deadline']), false) : null;
@endphp

<div class="main-wrapper">

  {{-- ─────────────────────────────────────────────────────
       BREADCRUMB
  ───────────────────────────────────────────────────── --}}
  <div class="py-2 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small flex-nowrap overflow-x-auto"
            style="scrollbar-width:none;-ms-overflow-style:none;white-space:nowrap">
          <li class="breadcrumb-item flex-shrink-0">
            <a href="{{ route('jobs.index') }}">Jobs</a>
          </li>
          @if(isset($job['job_category']['name']))
          <li class="breadcrumb-item flex-shrink-0">
            <a href="{{ route('jobs.index', ['category' => $job['job_category']['slug'] ?? $job['job_category']['id']]) }}">
              {{ $job['job_category']['name'] }}
            </a>
          </li>
          @endif
          <li class="breadcrumb-item active flex-shrink-0" aria-current="page">
            {{ $job['job_title'] ?? 'Job Details' }}
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <style>
  .breadcrumb::-webkit-scrollbar { display: none; }
  </style>

  {{-- ─────────────────────────────────────────────────────
       AD SLOT 1 — LEADERBOARD (above fold, highest CPM)
       Replace data-ad-* values with your AdSense config
  ───────────────────────────────────────────────────── --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-xl">
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
       MAIN LAYOUT
  ───────────────────────────────────────────────────── --}}
  <div class="container-xl px-3 px-md-4 py-4 py-lg-5">
    <div class="row g-4 align-items-start">

      {{-- ═══════════════════════════════════════════════
           LEFT COLUMN — Main content
      ═══════════════════════════════════════════════ --}}
      <div class="col-12 col-lg-8">

        {{-- ──────────────────────────────────────────
             JOB HEADER CARD
        ────────────────────────────────────────── --}}
        <div class="card border rounded-3 shadow-sm mb-4">
          <div class="card-body p-3 p-md-4">

            {{-- Company logo + title row --}}
            <div class="d-flex flex-column flex-sm-row gap-3 mb-3">
              <div class="flex-shrink-0">
                @if(isset($job['company']['logo']) && $job['company']['logo'])
                  <img src="{{ $job['company']['logo'] }}"
                      alt="{{ $job['company']['name'] }}"
                      width="60" height="60"
                      class="rounded-2 border"
                      style="object-fit:cover">
                @else
                  <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center" style="width:60px;height:60px">
                    <i class="bi bi-building fs-4 text-primary"></i>
                  </div>
                @endif
              </div>
              <div class="min-w-0 flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                  <h1 class="h5 fw-semibold mb-0 text-body">{{ $job['job_title'] ?? 'Job Title' }}</h1>
                  @if($job['is_featured'] ?? false)
                    <span class="badge text-bg-primary fw-normal" style="font-size:11px">Featured</span>
                  @endif
                  @if($job['is_urgent'] ?? false)
                    <span class="badge text-bg-danger fw-normal" style="font-size:11px">Urgent</span>
                  @endif
                </div>
                <div class="d-flex flex-wrap text-muted" style="font-size:13px;gap:4px 12px">
                  <span><i class="bi bi-building me-1"></i>{{ $job['company']['name'] ?? 'Unknown Company' }}</span>
                  <span><i class="bi bi-geo-alt me-1"></i>{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</span>
                  <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}</span>
                  @if(isset($job['view_count']))
                    <span><i class="bi bi-eye me-1"></i>{{ number_format($job['view_count']) }} views</span>
                  @endif
                </div>
              </div>
            </div>

            {{-- Tags row --}}
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:12px">
                <i class="bi bi-briefcase me-1"></i>{{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}
              </span>
              @if(isset($job['experience_level']['name']))
              <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:12px">
                <i class="bi bi-bar-chart me-1"></i>{{ $job['experience_level']['name'] }}
              </span>
              @endif
              <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary" style="font-size:12px">
                <i class="bi bi-house me-1"></i>{{ $job['location_type'] ?? 'On-site' }}
              </span>
              @if($job['is_verified'] ?? false)
              <span class="badge rounded-pill text-bg-success fw-normal" style="font-size:12px">
                <i class="bi bi-patch-check me-1"></i>Verified
              </span>
              @endif
            </div>

            <hr class="my-3">

            {{-- Salary + CTA row — fully centred --}}
            <div class="text-center mb-3">
              <div class="fw-semibold text-primary fs-5 lh-sm">{{ $job['formatted_salary'] ?? 'Negotiable' }}</div>
              @if(isset($job['salary_range']['name']))
                <div class="text-muted" style="font-size:12px">{{ $job['salary_range']['name'] }}</div>
              @endif
            </div>

            {{-- Action row: Apply + Share — centred on all breakpoints --}}
            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">

              <button class="btn btn-primary fw-semibold px-4" onclick="openApplyModal()">
                <i class="bi bi-send me-2"></i>Apply Now
              </button>

              <span class="text-muted d-none d-sm-block vr mx-1" style="height:32px;opacity:.3"></span>

              <span class="text-muted small d-none d-sm-inline">Share:</span>

              @foreach($shareBtns as $s)
              <button type="button"
                      class="btn btn-light border d-inline-flex align-items-center justify-content-center p-0 share-btn"
                      style="width:36px;height:36px;border-radius:8px"
                      onclick="shareOn('{{ $s['id'] }}')"
                      title="{{ $s['tip'] }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="{{ $s['color'] }}">{!! $s['svg'] !!}</svg>
              </button>
              @endforeach

              <button type="button"
                      class="btn btn-light border d-inline-flex align-items-center justify-content-center p-0 share-btn"
                      style="width:36px;height:36px;border-radius:8px"
                      onclick="copyJobLink()"
                      title="Copy link">
                <i class="bi bi-link-45deg text-body-secondary fs-5"></i>
              </button>
            </div>

          </div>
        </div>
        {{-- END JOB HEADER --}}


        {{-- ──────────────────────────────────────────
             JOB DESCRIPTION
        ────────────────────────────────────────── --}}
        <div class="card border rounded-3 shadow-sm mb-4">
          <div class="card-body p-3 p-md-4">
            <h2 class="h6 fw-semibold mb-3 pb-2 border-bottom">Job Description</h2>
            <div class="text-body-secondary job-prose">
              {!! nl2br($job['job_description'] ?? 'No description provided') !!}
            </div>

            @if(!empty($job['responsibilities']))
            <h3 class="h6 fw-semibold mt-4 mb-2">Key Responsibilities</h3>
            <div class="text-body-secondary job-prose">
              {!! nl2br($job['responsibilities']) !!}
            </div>
            @endif

            @if(!empty($job['qualifications']))
            <h3 class="h6 fw-semibold mt-4 mb-2">Qualifications</h3>
            <div class="text-body-secondary job-prose">
              {!! nl2br($job['qualifications']) !!}
            </div>
            @endif
          </div>
        </div>


        {{-- ──────────────────────────────────────────
             AD SLOT 2 — In-content (after description)
             High viewability: users pause here before scrolling
        ────────────────────────────────────────── --}}
        <div class="mb-4 text-center">
          <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
          <ins class="adsbygoogle" style="display:block;text-align:center"
               data-ad-layout="in-article"
               data-ad-format="fluid"
               data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
               data-ad-slot="2222222222"></ins>
          <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>


        {{-- ──────────────────────────────────────────
             SKILLS
        ────────────────────────────────────────── --}}
        @if(!empty($job['skills']))
        <div class="card border rounded-3 shadow-sm mb-4">
          <div class="card-body p-3 p-md-4">
            <h2 class="h6 fw-semibold mb-3 pb-2 border-bottom">Required Skills</h2>
            <div class="d-flex flex-wrap gap-2">
              @foreach(explode(',', $job['skills']) as $skill)
                @if(trim($skill))
                <span class="badge rounded-pill fw-normal border text-body-secondary bg-body-secondary px-3 py-2" style="font-size:12px">{{ trim($skill) }}</span>
                @endif
              @endforeach
            </div>
          </div>
        </div>
        @endif


        {{-- ──────────────────────────────────────────
             APPLICATION DETAILS
        ────────────────────────────────────────── --}}
        @if(!empty($job['application_procedure']) || !empty($job['email']) || !empty($job['telephone']) || !empty($job['deadline']))
        <div class="card border rounded-3 shadow-sm mb-4">
          <div class="card-body p-3 p-md-4">
            <h2 class="h6 fw-semibold mb-3 pb-2 border-bottom">Application Details</h2>
            <div class="row g-3">

              @if(!empty($job['application_procedure']))
              <div class="col-12">
                <div class="d-flex gap-3 rounded-2 bg-body-secondary p-3">
                  <div class="flex-shrink-0 text-primary" style="font-size:18px"><i class="bi bi-file-earmark-text"></i></div>
                  <div>
                    <div class="fw-semibold small mb-1">How to Apply</div>
                    <p class="text-body-secondary small mb-0">{{ $job['application_procedure'] }}</p>
                  </div>
                </div>
              </div>
              @endif

              @if(!empty($job['email']) || !empty($job['telephone']))
              <div class="col-md-6">
                <div class="d-flex gap-3 rounded-2 bg-body-secondary p-3 h-100">
                  <div class="flex-shrink-0 text-success" style="font-size:18px"><i class="bi bi-person-lines-fill"></i></div>
                  <div>
                    <div class="fw-semibold small mb-2">Contact Information</div>
                    @if(!empty($job['email']))
                    <div class="d-flex align-items-center gap-2 mb-1">
                      <i class="bi bi-envelope text-muted small"></i>
                      <a href="mailto:{{ $job['email'] }}" class="text-body-secondary small text-decoration-none">{{ $job['email'] }}</a>
                    </div>
                    @endif
                    @if(!empty($job['telephone']))
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-telephone text-muted small"></i>
                      <a href="tel:{{ $job['telephone'] }}" class="text-body-secondary small text-decoration-none">{{ $job['telephone'] }}</a>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
              @endif

              @if(!empty($job['deadline']))
              <div class="col-md-6">
                <div class="d-flex gap-3 rounded-2 bg-body-secondary p-3 h-100">
                  <div class="flex-shrink-0 text-warning" style="font-size:18px"><i class="bi bi-calendar-event"></i></div>
                  <div>
                    <div class="fw-semibold small mb-1">Application Deadline</div>
                    <div class="text-body-secondary small mb-1">{{ \Carbon\Carbon::parse($job['deadline'])->format('F j, Y') }}</div>
                    @if($daysLeft > 0)
                      <span class="badge text-bg-warning fw-normal" style="font-size:11px">{{ round($daysLeft) }} days left</span>
                    @elseif($daysLeft === 0)
                      <span class="badge text-bg-danger fw-normal" style="font-size:11px">Last day!</span>
                    @else
                      <span class="badge text-bg-secondary fw-normal" style="font-size:11px">Expired</span>
                    @endif
                  </div>
                </div>
              </div>
              @endif

            </div>
          </div>
        </div>
        @endif

      </div>
      {{-- END LEFT COLUMN --}}


      {{-- ═══════════════════════════════════════════════
           RIGHT SIDEBAR
      ═══════════════════════════════════════════════ --}}
      <div class="col-12 col-lg-4">
        <div class="js-sidebar-sticky">

          {{-- Stats strip --}}
          <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body py-3 px-3">
              <div class="row g-0 text-center">
                <div class="col-4 border-end">
                  <div class="py-1">
                    <div class="fw-semibold" style="font-size:17px">{{ number_format($job['application_count'] ?? 0) }}</div>
                    <div class="text-muted" style="font-size:11px">Applicants</div>
                  </div>
                </div>
                <div class="col-4 border-end">
                  <div class="py-1">
                    <div class="fw-semibold" style="font-size:17px">{{ number_format($job['view_count'] ?? 0) }}</div>
                    <div class="text-muted" style="font-size:11px">Views</div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="py-1">
                    <div class="fw-semibold" style="font-size:17px">{{ number_format($job['social_shares'] ?? 0) }}</div>
                    <div class="text-muted" style="font-size:11px">Shares</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Apply CTA (sidebar) --}}
          <div class="d-grid mb-4">
            <button class="btn btn-primary btn-lg fw-semibold" onclick="openApplyModal()">
              <i class="bi bi-send me-2"></i>Apply Now
            </button>
          </div>

          {{-- Quick Overview --}}
          <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body p-3 p-md-4">
              <h3 class="h6 fw-semibold mb-3 pb-2 border-bottom">Job Overview</h3>
              <dl class="row g-0 mb-0">
                @if(isset($job['job_category']['name']))
                <div class="col-5 py-2 border-bottom">
                  <dt class="fw-normal text-muted small"><i class="bi bi-tag me-1"></i>Category</dt>
                </div>
                <div class="col-7 py-2 border-bottom text-end">
                  <dd class="mb-0 fw-semibold small">{{ $job['job_category']['name'] }}</dd>
                </div>
                @endif

                <div class="col-5 py-2 border-bottom">
                  <dt class="fw-normal text-muted small"><i class="bi bi-briefcase me-1"></i>Type</dt>
                </div>
                <div class="col-7 py-2 border-bottom text-end">
                  <dd class="mb-0 fw-semibold small">{{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}</dd>
                </div>

                @if(isset($job['experience_level']['name']))
                <div class="col-5 py-2 border-bottom">
                  <dt class="fw-normal text-muted small"><i class="bi bi-bar-chart me-1"></i>Level</dt>
                </div>
                <div class="col-7 py-2 border-bottom text-end">
                  <dd class="mb-0 fw-semibold small">{{ $job['experience_level']['name'] }}</dd>
                </div>
                @endif

                @if(isset($job['education_level']['name']))
                <div class="col-5 py-2 border-bottom">
                  <dt class="fw-normal text-muted small"><i class="bi bi-mortarboard me-1"></i>Education</dt>
                </div>
                <div class="col-7 py-2 border-bottom text-end">
                  <dd class="mb-0 fw-semibold small">{{ $job['education_level']['name'] }}</dd>
                </div>
                @endif

                <div class="col-5 py-2 border-bottom">
                  <dt class="fw-normal text-muted small"><i class="bi bi-geo-alt me-1"></i>Location</dt>
                </div>
                <div class="col-7 py-2 border-bottom text-end">
                  <dd class="mb-0 fw-semibold small">{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</dd>
                </div>

                <div class="col-5 py-2 border-bottom">
                  <dt class="fw-normal text-muted small"><i class="bi bi-house me-1"></i>Work Mode</dt>
                </div>
                <div class="col-7 py-2 border-bottom text-end">
                  <dd class="mb-0 fw-semibold small">{{ $job['location_type'] ?? 'On-site' }}</dd>
                </div>

                <div class="col-5 py-2">
                  <dt class="fw-normal text-muted small"><i class="bi bi-calendar me-1"></i>Posted</dt>
                </div>
                <div class="col-7 py-2 text-end">
                  <dd class="mb-0 fw-semibold small">{{ \Carbon\Carbon::parse($job['created_at'])->format('M d, Y') }}</dd>
                </div>
              </dl>
            </div>
          </div>

          {{-- AD SLOT 3 — Sidebar 300×250
               Best performing ad format. Stays visible as user scrolls content.
          --}}
          <div class="mb-4 text-center">
            <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
            <ins class="adsbygoogle" style="display:block"
                 data-ad-client="ca-pub-XXXXXXXXXXXXXXXX"
                 data-ad-slot="3333333333"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
          </div>

          {{-- Company Info --}}
          @if(isset($job['company']))
          <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body p-3 p-md-4">
              <h3 class="h6 fw-semibold mb-3 pb-2 border-bottom">About the Company</h3>
              <div class="d-flex flex-column flex-sm-row gap-3 mb-3">
                <div class="flex-shrink-0">
                  @if(isset($job['company']['logo']) && $job['company']['logo'])
                    <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] }}"
                        width="48" height="48" class="rounded-2 border" style="object-fit:cover">
                  @else
                    <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center" style="width:48px;height:48px">
                      <i class="bi bi-building text-primary fs-5"></i>
                    </div>
                  @endif
                </div>
                <div>
                  <div class="fw-semibold small">{{ $job['company']['name'] ?? 'Company Name' }}</div>
                  @if(isset($job['company']['industry']['name']))
                    <div class="text-muted" style="font-size:12px">{{ $job['company']['industry']['name'] }}</div>
                  @endif
                </div>
              </div>
              @if(!empty($job['company']['description']))
                <p class="text-body-secondary small mb-3">{{ Str::limit($job['company']['description'], 140) }}</p>
              @endif
              @if(isset($job['company']['website']))
                <a href="{{ $job['company']['website'] }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm w-100">
                  <i class="bi bi-globe me-2"></i>Visit Website
                </a>
              @endif
            </div>
          </div>
          @endif

          {{-- Similar Jobs --}}
          @if(isset($similarJobs) && count($similarJobs) > 0)
          <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body p-3 p-md-4">
              <h3 class="h6 fw-semibold mb-3 pb-2 border-bottom">Similar Jobs</h3>
              <div class="d-flex flex-column gap-2">

                @foreach($similarJobs as $sj)
                <a href="{{ route('jobs.show', $sj['slug'] ?? $sj['id']) }}"
                  class="similar-job-link d-flex flex-column p-2 rounded-2 border text-decoration-none"
                  style="gap:8px">

                  {{-- Row 1: logo + title + salary --}}
                  <div class="d-flex align-items-center" style="gap:8px">

                    {{-- Logo --}}
                    <div style="width:36px;height:36px;flex-shrink:0">
                      @if(isset($sj['company']['logo']) && $sj['company']['logo'])
                        <img src="{{ $sj['company']['logo'] }}" alt="{{ $sj['company']['name'] }}"
                            width="36" height="36" class="rounded-2 border w-100 h-100"
                            style="object-fit:cover;display:block">
                      @else
                        <div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center w-100 h-100">
                          <i class="bi bi-building text-primary" style="font-size:14px"></i>
                        </div>
                      @endif
                    </div>

                    {{-- Title --}}
                    <div class="fw-semibold text-body text-truncate flex-grow-1" style="font-size:13px;min-width:0">
                      {{ $sj['job_title'] }}
                    </div>

                    {{-- Salary --}}
                    @if(!empty($sj['formatted_salary']))
                    <div class="text-primary fw-semibold flex-shrink-0" style="font-size:12px;white-space:nowrap">
                      {{ $sj['formatted_salary'] }}
                    </div>
                    @endif

                  </div>

                  {{-- Row 2: company + location --}}
                  <div class="d-flex flex-wrap" style="gap:2px 12px;padding-left:44px">
                    <span class="text-muted" style="font-size:12px">
                      <i class="bi bi-building me-1"></i>{{ $sj['company']['name'] ?? 'Unknown' }}
                    </span>
                    <span class="text-muted" style="font-size:12px">
                      <i class="bi bi-geo-alt me-1"></i>{{ $sj['duty_station'] ?? 'Remote' }}
                    </span>
                  </div>

                </a>
                @endforeach

              </div>

              <a href="{{ route('jobs.index', ['category' => $job['job_category']['slug'] ?? null]) }}"
                class="d-block text-center text-primary small mt-3">
                View all similar <i class="bi bi-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
          @endif

        </div>
      </div>
      {{-- END RIGHT SIDEBAR --}}

    </div>
  </div>
  {{-- END CONTAINER --}}


  {{-- ─────────────────────────────────────────────────────
       AD SLOT 4 — Between content & CTA
       High-intent zone: user has finished reading = best CTR
  ───────────────────────────────────────────────────── --}}
  <div class="bg-body border-top border-bottom py-2 text-center">
    <div class="container-xl">
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
          <p class="text-white-50 small text-uppercase mb-2" style="letter-spacing:.1em">Don't miss out</p>
          <h2 class="text-white fw-semibold fs-4 mb-2">Ready to join {{ $job['company']['name'] ?? 'the team' }}?</h2>
          <p class="text-white-50 small mb-4">Apply for <strong class="text-white">{{ $job['job_title'] }}</strong> today.</p>

          <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
            <button class="btn btn-light fw-semibold px-4 py-2" onclick="openApplyModal()">
              <i class="bi bi-send me-2"></i>Apply Now
            </button>

            <span class="vr bg-white opacity-25 d-none d-sm-block" style="height:36px"></span>

            @foreach($shareBtns as $s)
              <button type="button"
                      class="btn btn-light border d-inline-flex align-items-center justify-content-center p-0 share-btn"
                      style="width:36px;height:36px;border-radius:8px"
                      onclick="shareOn('{{ $s['id'] }}')"
                      title="{{ $s['tip'] }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="{{ $s['color'] }}">{!! $s['svg'] !!}</svg>
              </button>
              @endforeach

              <button type="button"
                      class="btn btn-light border d-inline-flex align-items-center justify-content-center p-0 share-btn"
                      style="width:36px;height:36px;border-radius:8px"
                      onclick="copyJobLink()"
                      title="Copy link">
                <i class="bi bi-link-45deg text-body-secondary fs-5"></i>
              </button>
          </div>
        </div>
      </div>
    </div>
  </section>


  {{-- ─────────────────────────────────────────────────────
       AD SLOT 5 — Footer banner
       Low intrusion, page already consumed, high fill rate
  ───────────────────────────────────────────────────── --}}
  <div class="bg-body border-top py-2 text-center">
    <div class="container-xl">
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


{{-- ─────────────────────────────────────────────────────
     SHARE JAVASCRIPT
───────────────────────────────────────────────────── --}}
<script>
const shareData = {
  id:       @json($job['id'] ?? null),
  title:    @json($job['job_title'] ?? 'Job Opportunity'),
  company:  @json($job['company']['name'] ?? ''),
  location: @json($job['duty_station'] ?? ($job['job_location']['district'] ?? ($job['job_location']['country'] ?? 'Uganda'))),
  url:      window.location.href,
};

const apiBase = document.querySelector('meta[name="api-base-url"]')?.content
             || '{{ config("api.main_app.api_base") }}';

const buildText = () => `${shareData.title} at ${shareData.company} — ${shareData.location}`;
const buildMsg  = () => `${shareData.title} at ${shareData.company}\n📍 ${shareData.location}\n\nApply: ${shareData.url}`;

async function incrementShareCount(platform) {
  if (!shareData.id) return;
  try {
    await fetch(`${apiBase}/v2/jobs/${shareData.id}/increment-share`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: JSON.stringify({ platform }),
    });
  } catch (e) { /* non-blocking */ }
}

function shareOn(platform) {
  incrementShareCount(platform);
  const t   = encodeURIComponent(buildText());
  const msg = encodeURIComponent(buildMsg());
  const u   = encodeURIComponent(shareData.url);
  const map = {
    whatsapp: `https://wa.me/?text=${msg}`,
    facebook: `https://www.facebook.com/sharer/sharer.php?u=${u}`,
    twitter:  `https://twitter.com/intent/tweet?text=${t}&url=${u}`,
    linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${u}`,
    telegram: `https://t.me/share/url?url=${u}&text=${t}`,
  };
  if (map[platform]) window.open(map[platform], '_blank', 'width=600,height=500,noopener,noreferrer');
}

function copyJobLink() {
  incrementShareCount('copy_link');
  const text = buildMsg();
  navigator.clipboard.writeText(text)
    .then(() => showToast?.('Link copied!', 'success'))
    .catch(() => {
      const ta = document.createElement('textarea');
      ta.value = text; document.body.appendChild(ta); ta.select();
      document.execCommand('copy'); document.body.removeChild(ta);
      showToast?.('Link copied!', 'success');
    });
}
</script>
@section('schema')
  <script type="application/ld+json">
  {!! json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
  </script>
@endsection

@include('jobs.partials.apply-modal')
@endsection


@push('styles')
<style>
  .container-xl { max-width: 1280px; }

  /* Sticky sidebar — desktop only */
  @media (min-width: 992px) {
    .js-sidebar-sticky {
      position: sticky;
      top: 72px;
    }
  }

  /* Share button hover */
  .share-btn { transition: background .15s, transform .15s; }
  .share-btn:hover { transform: translateY(-2px); }
  .share-btn:active { transform: none; }

  /* CTA share buttons */
  .cta-share-btn {
    border-radius: 8px;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    cursor: pointer;
    transition: background .15s, transform .15s;
  }
  .cta-share-btn:hover {
    background: rgba(255,255,255,.28);
    transform: translateY(-2px);
  }
  .cta-share-btn:active { transform: none; }

  /* Similar job link */
  .similar-job-link { transition: border-color .15s, background .15s; }
  .similar-job-link:hover { border-color: var(--bs-primary) !important; background: rgba(var(--bs-primary-rgb),.04); }

  /* Job description prose */
  .job-prose { font-size: .875rem; line-height: 1.75; }
  .job-prose ul, .job-prose ol { padding-left: 1.25rem; margin-bottom: .5rem; }
  .job-prose li { margin-bottom: .25rem; }

  /* Breadcrumb clean */
  .breadcrumb-item + .breadcrumb-item::before { color: var(--bs-secondary-color); }

  /* Mobile: stack salary above CTA cleanly */
  @media (max-width: 575px) {
    .share-btn { width: 34px !important; height: 34px !important; }
    .cta-share-btn { width: 34px !important; height: 34px !important; }
  }

  /* Fix text overflow issues */
  .job-prose {
      font-size: .875rem;
      line-height: 1.75;
      word-wrap: break-word;
      overflow-wrap: break-word;
      word-break: break-word;
  }

  .job-prose p,
  .job-prose div,
  .job-prose span {
      max-width: 100%;
      word-wrap: break-word;
      overflow-wrap: break-word;
      word-break: break-word;
  }

  .job-prose a {
      word-break: break-all;
      overflow-wrap: break-word;
  }

  /* Fix any long URLs or text in the job description */
  .job-prose a,
  .job-prose code,
  .job-prose pre {
      word-break: break-all;
      white-space: normal;
      max-width: 100%;
      display: inline-block;
  }

  /* Ensure all text containers wrap properly */
  .card-body {
      overflow-x: hidden;
  }

  /* Fix similar jobs links */
  .similar-job-link {
      word-break: break-word;
      overflow-wrap: break-word;
  }

  .similar-job-link .text-truncate {
      white-space: normal;
      word-break: break-word;
  }
</style>
@endpush
