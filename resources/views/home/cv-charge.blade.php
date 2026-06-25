@extends('layouts.jobs')

@section('title', 'AI CV Enhancement | Boost Your Job Search | Stardena Works')
@section('meta_description', 'AI-powered CV enhancement and cover letter generator. Get ATS-optimized CVs, keyword matching, and custom cover letters. Starting at $5/month for job seekers in Uganda, Kenya, Tanzania, Rwanda.')
@section('canonical', url('/cv-enhancement'))
@section('robots', 'index, follow')

{{-- Override OG tags specifically for this page --}}
@section('og_title', 'AI CV Enhancement - Land Your Dream Job Faster')
@section('og_description', 'AI-powered CV optimization and cover letter generator. Get noticed by employers with ATS-friendly CVs.')
@section('og_url', url('/cv-enhancement'))
@section('og_type', 'website')
@section('og_image', getFavicon())

{{-- Override Twitter Card --}}
@section('twitter_title', 'AI CV Enhancement | Stardena Works')
@section('twitter_description', 'Boost your job search with AI-powered CV enhancement. Starting at $5/month.')
@section('twitter_image', getFavicon())

@section('job-content')

@php
    $API_BASE = rtrim(config('api.main_app.api_base'), '/');
    $API_TOKEN = session('api_token', '');
    $IS_LOGGED_IN = session()->has('web_user');
    
    // Fetch subscription status via API
    $hasActiveSubscription = false;
    $subscriptionPlan = null;
    $subscriptionPeriod = null;
    $subscriptionExpiry = null;
    $isOnTrial = false;
    $trialDaysLeft = 0;
    $trialExpiry = null;
    
    if ($API_TOKEN) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $API_BASE . '/v1/subscription/status');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $API_TOKEN,
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200) {
                $data = json_decode($response, true);
                if ($data['success'] && $data['data']['has_active_subscription']) {
                    $hasActiveSubscription = true;
                    $subscriptionPlan = $data['data']['plan'] ?? null;
                    $subscriptionPeriod = $data['data']['period'] ?? null;
                    $subscriptionExpiry = $data['data']['expiry_date'] ?? null;
                    
                    // Check if on trial
                    if ($subscriptionPlan === 'seeker_trial' && $subscriptionExpiry) {
                        $isOnTrial = true;
                        $trialExpiry = \Carbon\Carbon::parse($subscriptionExpiry);
                        $trialDaysLeft = max(0, (int) ceil(now()->diffInDays($trialExpiry, false)));
                    }
                }
            }
        } catch (Exception $e) {
            // Fallback to false
        }
    }
@endphp

{{-- ============================================================= --}}
{{-- SECTION: PRICING PLANS (shown when NOT logged in OR logged in but NOT subscribed) --}}
{{-- ============================================================= --}}
@if(!$IS_LOGGED_IN || !$hasActiveSubscription)

<section id="seeker-pricing" class="py-5 py-lg-6" style="background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); scroll-margin-top: 80px;">
  <div class="container-xl px-3 px-md-4">
    
    {{-- Campaign Header --}}
    <div class="text-center mb-5">
      <div class="d-inline-flex align-items-center gap-2 bg-warning bg-opacity-20 rounded-pill px-4 py-2 mb-3">
        <i class="bi bi-gift-fill text-warning"></i>
        <span class="small fw-semibold text-warning">Limited Time Offer</span>
      </div>
      <h1 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">Land Your Dream Job <span style="color: #f59e0b;">Faster</span></h1>
      <p class="text-muted fs-5 mb-3">AI-powered CV enhancement + cover letter generator that gets you noticed</p>
      <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>ATS Score Optimization</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Keyword Matching</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Custom Cover Letters</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Instant Download</span></div>
      </div>
    </div>

    {{-- Currency Selector --}}
    <div class="d-flex justify-content-end mb-4">
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" id="currencyDropdownBtn">
          <i class="bi bi-currency-exchange me-1"></i> <span id="selectedCurrencyDisplay">USD ($)</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" id="currencyList" style="max-height: 300px; overflow-y: auto;"></ul>
      </div>
    </div>

    {{-- Loading State --}}
    <div id="plansLoading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-muted mt-2">Loading pricing plans...</p>
    </div>

    {{-- Pricing Packages Container --}}
    <div id="plansContainer" class="row g-4 mb-5" style="display: none;"></div>

    {{-- Login Required Message for non-logged in users --}}
    @if(!$IS_LOGGED_IN)
    <div class="text-center mt-3">
      <p class="text-muted small">Already have an account? <a href="{{ route('login.register') }}" class="text-primary fw-semibold">Sign in</a> to subscribe</p>
    </div>
    @endif

  </div>
</section>

@endif {{-- end pricing section --}}

{{-- ============================================================= --}}
{{-- SECTION 2: ACTIVE SUBSCRIPTION DASHBOARD (shown when logged in AND subscribed) --}}
{{-- ============================================================= --}}
@if($IS_LOGGED_IN && $hasActiveSubscription)

<section id="cv-enhancement-dashboard" class="py-5 py-lg-6" style="background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); scroll-margin-top: 80px;">
  <div class="container-xl px-3 px-md-4">

    {{-- Trial Banner (shown when on trial) --}}
    @if($isOnTrial)
    <div class="alert alert-warning rounded-3 mb-4" style="background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border: 1px solid #f59e0b;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <i class="bi bi-clock-history me-2 text-warning"></i>
                <span class="fw-semibold">🎉 You're on a Free Trial!</span>
                <span class="text-muted ms-2">
                    <span id="trialDaysLeft">{{ $trialDaysLeft }}</span> days remaining
                </span>
                <span class="text-muted small d-block">
                    Expires: {{ $trialExpiry ? $trialExpiry->format('M d, Y') : 'N/A' }}
                </span>
            </div>
            <div>
                <button class="btn btn-primary btn-sm rounded-pill px-4" onclick="showUpgradeModal()">
                    <i class="bi bi-arrow-up-circle me-1"></i>Upgrade Now
                </button>
            </div>
        </div>
        <div class="progress mt-2" style="height:4px;">
            <div class="progress-bar bg-warning" id="trialProgressBar" style="width:{{ max(0, ($trialDaysLeft / 7) * 100) }}%"></div>
        </div>
    </div>
    @endif

    {{-- Welcome Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
      <div>
        <h1 class="display-6 fw-bold mb-1" style="color: #1e3a8a;">AI CV Enhancement Suite</h1>
        <p class="text-muted mb-0">Professional CV tools powered by artificial intelligence</p>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
          <i class="bi bi-check-circle-fill me-1"></i> Active Plan: {{ ucfirst(str_replace('seeker_', '', $subscriptionPlan ?? 'Pro')) }}
        </span>
        @if($subscriptionExpiry)
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
            <i class="bi bi-calendar me-1"></i> Expires: {{ \Carbon\Carbon::parse($subscriptionExpiry)->format('M d, Y') }}
        </span>
        @endif
        @if(!$isOnTrial)
        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="showUpgradeModal()">
          <i class="bi bi-arrow-up-circle me-1"></i>Change Plan
        </button>
        @endif
      </div>
    </div>

    {{-- Usage Stats Cards --}}
    <div class="row g-3 mb-4">
      <div class="col-4">
        <div class="rounded-3 p-3 text-center" style="background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%); border: 1px solid rgba(59, 130, 246, 0.1);">
          <div class="fw-bold text-primary fs-4" id="usageReviews">
            <span class="spinner-border spinner-border-sm text-primary"></span>
          </div>
          <div class="text-muted small">CV Reviews</div>
          <div class="progress mt-2" style="height:4px;">
            <div class="progress-bar bg-primary" id="usageReviewsBar" style="width:0%"></div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="rounded-3 p-3 text-center" style="background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%); border: 1px solid rgba(34, 197, 94, 0.1);">
          <div class="fw-bold text-success fs-4" id="usageRewrites">
            <span class="spinner-border spinner-border-sm text-success"></span>
          </div>
          <div class="text-muted small">Rewrites</div>
          <div class="progress mt-2" style="height:4px;">
            <div class="progress-bar bg-success" id="usageRewritesBar" style="width:0%"></div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="rounded-3 p-3 text-center" style="background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border: 1px solid rgba(245, 158, 11, 0.1);">
          <div class="fw-bold text-warning fs-4" id="usageLetters">
            <span class="spinner-border spinner-border-sm text-warning"></span>
          </div>
          <div class="text-muted small">Cover Letters</div>
          <div class="progress mt-2" style="height:4px;">
            <div class="progress-bar bg-warning" id="usageLettersBar" style="width:0%"></div>
          </div>
        </div>
      </div>
    </div>

    {{-- Sub-tabs nav --}}
    <ul class="nav nav-pills gap-2 mb-4" id="cvEnhanceTabs" role="tablist">
      <li class="nav-item">
        <button class="nav-link active rounded-pill px-3 py-2 fw-semibold" id="enh-tab-review"
                onclick="switchEnhanceTab('review',this)">
          <i class="bi bi-clipboard2-pulse me-1"></i>CV Review
        </button>
      </li>
      <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" id="enh-tab-rewrite"
                onclick="switchEnhanceTab('rewrite',this)">
          <i class="bi bi-magic me-1"></i>CV Rewrite
        </button>
      </li>
      <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" id="enh-tab-coverletter"
                onclick="switchEnhanceTab('coverletter',this)">
          <i class="bi bi-envelope-paper me-1"></i>Cover Letter
        </button>
      </li>
      <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" id="enh-tab-history"
                onclick="switchEnhanceTab('history',this)">
          <i class="bi bi-clock-history me-1"></i>History
        </button>
      </li>
    </ul>

    {{-- ══════════════════════════ TAB PANES ══════════════════════════ --}}

    {{-- ── CV REVIEW ────────────────────────────────────────────────── --}}
    <div id="enhance-review" class="enhance-tab-pane">
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
          <h6 class="fw-bold mb-1"><i class="bi bi-clipboard2-pulse me-2 text-primary"></i>Professional CV Review</h6>
          <p class="text-muted small mb-3">Our AI HR professional analyses your CV and provides detailed feedback — ATS score, missing keywords, section critique, and specific fixes.</p>

          <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-4">
            <div class="row g-1">
              @foreach([
                ['bi-graph-up','ATS Compatibility Score (0–100)'],
                ['bi-list-check','Section-by-section critique'],
                ['bi-exclamation-triangle','Critical issues with specific fixes'],
                ['bi-key','Missing keywords for your target role'],
                ['bi-stars','Rewritten achievement bullet examples'],
                ['bi-envelope-check','Full report sent to your email'],
              ] as [$icon,$label])
              <div class="col-12 col-sm-6">
                <div class="d-flex align-items-center gap-2 small py-1">
                  <i class="bi {{ $icon }} text-primary flex-shrink-0"></i>
                  <span class="text-muted">{{ $label }}</span>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          {{-- Upload --}}
          <div class="mb-3">
            <label class="form-label small fw-semibold">Upload CV <span class="text-muted fw-normal">(or we'll use the one on your profile)</span></label>
            <div class="border border-2 border-dashed rounded-3 text-center p-4"
                 style="border-color:#c7d7f5!important;background:#f8faff;cursor:pointer;"
                 id="reviewDropZone"
                 onclick="document.getElementById('reviewFileInput').click()"
                 ondragover="event.preventDefault();this.style.background='#eef3ff'"
                 ondragleave="this.style.background='#f8faff'"
                 ondrop="handleEnhDrop(event,'review')">
              <input type="file" id="reviewFileInput" class="d-none" accept=".pdf,.doc,.docx"
                     onchange="handleReviewFile(this)">
              <i class="bi bi-cloud-arrow-up fs-2 text-primary opacity-75 mb-1 d-block"></i>
              <p class="small fw-semibold text-primary mb-0">Click or drag &amp; drop your CV</p>
              <p class="small text-muted mb-0">PDF, DOC, DOCX — max 5MB</p>
            </div>
            <div id="reviewFilePreview" class="d-none mt-2">
              <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-2 border">
                <i class="bi bi-file-earmark-text text-primary fs-5"></i>
                <span class="small fw-semibold flex-grow-1 text-truncate" id="reviewFileName"></span>
                <button class="btn btn-sm btn-link text-danger p-0" onclick="clearReviewFile()"><i class="bi bi-x-lg"></i></button>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label small fw-semibold">Target Role <span class="text-muted fw-normal">(optional but improves accuracy)</span></label>
            <input type="text" class="form-control form-control-sm rounded-2" id="reviewTargetRole"
                   placeholder="e.g., Senior Software Engineer, Credit Risk Manager, Marketing Officer">
          </div>

          <button class="btn btn-primary rounded-pill w-100 py-2 fw-semibold" id="reviewBtn" onclick="submitCVReview()">
            <i class="bi bi-clipboard2-pulse me-2"></i>Analyse My CV
          </button>

          <div id="reviewResult" class="mt-4"></div>
        </div>
      </div>
    </div>

    {{-- ── CV REWRITE ───────────────────────────────────────────────── --}}
    <div id="enhance-rewrite" class="enhance-tab-pane d-none">
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
          <h6 class="fw-bold mb-1"><i class="bi bi-magic me-2 text-success"></i>AI CV Rewrite</h6>
          <p class="text-muted small mb-3">Our AI rewrites your CV to professional East African job market standards — ATS-ready, recruiter-approved, 2 pages maximum.</p>

          <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-4">
            <div class="row g-1">
              @foreach([
                ['bi-check2','Maximum 2 pages — clean and focused'],
                ['bi-check2','Strong action verbs and quantified achievements'],
                ['bi-check2','ATS-optimised formatting'],
                ['bi-check2','Professional HR-standard section order'],
                ['bi-check2','Tailored to your target industry'],
                ['bi-check2','Word + Text download + Email delivery'],
              ] as [$icon,$label])
              <div class="col-12 col-sm-6">
                <div class="d-flex align-items-center gap-2 small py-1">
                  <i class="bi {{ $icon }} text-success flex-shrink-0"></i>
                  <span class="text-muted">{{ $label }}</span>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold">Upload CV</label>
            <div class="border border-2 border-dashed rounded-3 text-center p-4"
                 style="border-color:#c7d7f5!important;background:#f8faff;cursor:pointer;"
                 id="rewriteDropZone"
                 onclick="document.getElementById('rewriteFileInput').click()"
                 ondragover="event.preventDefault();this.style.background='#eef3ff'"
                 ondragleave="this.style.background='#f8faff'"
                 ondrop="handleEnhDrop(event,'rewrite')">
              <input type="file" id="rewriteFileInput" class="d-none" accept=".pdf,.doc,.docx"
                     onchange="handleRewriteFile(this)">
              <i class="bi bi-cloud-arrow-up fs-2 text-primary opacity-75 mb-1 d-block"></i>
              <p class="small fw-semibold text-primary mb-0">Click or drag &amp; drop your CV</p>
              <p class="small text-muted mb-0">PDF, DOC, DOCX — max 5MB</p>
            </div>
            <div id="rewriteFilePreview" class="d-none mt-2">
              <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-2 border">
                <i class="bi bi-file-earmark-text text-primary fs-5"></i>
                <span class="small fw-semibold flex-grow-1 text-truncate" id="rewriteFileName"></span>
                <button class="btn btn-sm btn-link text-danger p-0" onclick="clearRewriteFile()"><i class="bi bi-x-lg"></i></button>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label small fw-semibold">Target Role / Industry</label>
            <input type="text" class="form-control form-control-sm rounded-2" id="rewriteTargetRole"
                   placeholder="e.g., Banking, Education, Technology, Healthcare">
          </div>

          <button class="btn btn-success rounded-pill w-100 py-2 fw-semibold" id="rewriteBtn" onclick="submitCVRewrite()">
            <i class="bi bi-magic me-2"></i>Rewrite My CV
          </button>

          <div id="rewriteResult" class="mt-4"></div>
        </div>
      </div>
    </div>

    {{-- ── COVER LETTER ─────────────────────────────────────────────── --}}
    <div id="enhance-coverletter" class="enhance-tab-pane d-none">
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
          <h6 class="fw-bold mb-1"><i class="bi bi-envelope-paper me-2 text-warning"></i>AI Cover Letter Generator</h6>
          <p class="text-muted small mb-3">Paste the job details below. Our AI will compare it against your CV and write a tailored, professional cover letter that highlights your most relevant experience.</p>

          <div id="noCvWarning" class="alert alert-warning small py-2 px-3 rounded-2 mb-3 d-none">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            No CV found on your profile. Upload your CV first using the CV Review or Rewrite tab.
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Job Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control form-control-sm rounded-2" id="clJobTitle"
                     placeholder="e.g., Senior Credit Risk Officer">
              <div class="text-danger small mt-1 d-none" id="clJobTitleErr"></div>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Company Name</label>
              <input type="text" class="form-control form-control-sm rounded-2" id="clCompany"
                     placeholder="e.g., Stanbic Bank Uganda">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Hiring Manager Name</label>
              <input type="text" class="form-control form-control-sm rounded-2" id="clHiringManager"
                     placeholder="e.g., Mr. John Okello (leave blank if unknown)">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Upload CV <span class="text-muted fw-normal">(if not on profile)</span></label>
              <input type="file" class="form-control form-control-sm rounded-2" id="clCvFile" accept=".pdf,.doc,.docx">
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Job Description <span class="text-danger">*</span></label>
              <textarea class="form-control form-control-sm rounded-2" id="clJobDesc" rows="5"
                        placeholder="Paste the full job description here. The more detail you provide, the better the letter."></textarea>
              <div class="text-danger small mt-1 d-none" id="clJobDescErr"></div>
              <div class="d-flex justify-content-between mt-1">
                <small class="text-muted">Minimum 50 characters</small>
                <small class="text-muted" id="clJobDescCount">0 chars</small>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Key Responsibilities <span class="text-muted fw-normal">(paste from job ad)</span></label>
              <textarea class="form-control form-control-sm rounded-2" id="clResponsibilities" rows="4"
                        placeholder="• Manage portfolio&#10;• Analyse risk exposure&#10;• Generate reports..."></textarea>
            </div>
            <div class="col-12">
              <label class="form-label small fw-semibold">Required Skills / Qualifications <span class="text-muted fw-normal">(paste from job ad)</span></label>
              <textarea class="form-control form-control-sm rounded-2" id="clSkills" rows="3"
                        placeholder="• Bachelor's degree&#10;• 5+ years experience&#10;• CPA qualification..."></textarea>
            </div>
          </div>

          <div class="mt-4">
            <button class="btn btn-warning rounded-pill w-100 py-2 fw-semibold text-dark" id="clBtn" onclick="submitCoverLetter()">
              <i class="bi bi-envelope-paper me-2"></i>Generate Cover Letter
            </button>
          </div>

          <div id="clResult" class="mt-4"></div>
        </div>
      </div>
    </div>

    {{-- ── HISTORY ──────────────────────────────────────────────────── --}}
    <div id="enhance-history" class="enhance-tab-pane d-none">
      <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
          <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Enhancement History</h6>

          <div class="bg-light rounded-3 p-3 mb-3">
            <div class="row g-2 align-items-center">
              <div class="col-md-5">
                <div class="input-group input-group-sm">
                  <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                  <input type="text" class="form-control" id="historySearch"
                         placeholder="Search job title, company..." oninput="filterHistory()">
                </div>
              </div>
              <div class="col-md-3">
                <select class="form-select form-select-sm" id="historyTypeFilter" onchange="filterHistory()">
                  <option value="all">All Types</option>
                  <option value="review">CV Reviews</option>
                  <option value="rewrite">CV Rewrites</option>
                  <option value="cover_letter">Cover Letters</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-select form-select-sm" id="historyStatusFilter" onchange="filterHistory()">
                  <option value="all">All Status</option>
                  <option value="completed">Completed</option>
                  <option value="failed">Failed</option>
                  <option value="processing">Processing</option>
                </select>
              </div>
              <div class="col-md-2">
                <button class="btn btn-sm btn-outline-secondary w-100 rounded-pill" onclick="refreshHistory()">
                  <i class="bi bi-arrow-repeat me-1"></i>Refresh
                </button>
              </div>
            </div>
          </div>

          <div id="historyList">
            <div class="text-center py-4">
              <div class="spinner-border spinner-border-sm text-primary"></div>
              <p class="text-muted small mt-2 mb-0">Loading history…</p>
            </div>
          </div>

          <div id="historyPagination" class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top d-none">
            <div class="small text-muted" id="historyInfo"></div>
            <nav><ul class="pagination pagination-sm mb-0" id="historyPageLinks"></ul></nav>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

@endif {{-- end hasActiveSubscription --}}

{{-- ============================================================= --}}
{{-- MODALS (Always available) --}}
{{-- ============================================================= --}}

{{-- Payment Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-header border-0 p-4 pb-0">
        <h5 class="modal-title fw-bold">Complete Your Subscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-4">
          <div class="col-md-5">
            <div class="bg-primary bg-opacity-10 rounded-4 p-4 text-center">
              <div class="rounded-2 bg-primary bg-opacity-20 d-inline-flex p-2 mb-3" id="modalIcon">
                <i class="bi bi-stars fs-2 text-primary"></i>
              </div>
              <h4 class="fw-bold mb-1" id="modalPlanTitle">Pro Plan</h4>
              <p class="text-muted small mb-2" id="modalPlanDesc">For serious job seekers</p>
              <div class="mb-3">
                <span class="display-6 fw-bold text-primary" id="modalPrice">$12</span>
                <span class="text-muted" id="modalPeriod">/month</span>
              </div>
              <hr>
              <ul class="list-unstyled text-start small" id="modalFeatures"></ul>
            </div>
          </div>
          <div class="col-md-7">
            <h6 class="fw-bold mb-3">Your Details</h6>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Full Name</label>
              <input type="text" class="form-control rounded-3" id="payerName" placeholder="John Doe">
              <div class="text-danger small mt-1 d-none" id="payerNameErr"></div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Email Address</label>
              <input type="email" class="form-control rounded-3" id="payerEmail" placeholder="john@example.com">
              <div class="text-danger small mt-1 d-none" id="payerEmailErr"></div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Phone Number</label>
              <input type="tel" class="form-control rounded-3" id="payerPhone" placeholder="+256 XXX XXX XXX">
            </div>
            <div class="alert alert-info small p-3 rounded-3" style="background: #e8f0fe; border: none;">
              <i class="bi bi-shield-check me-2"></i>
              Secured by <strong>Pesapal</strong> — Trusted payment gateway for East Africa
            </div>
            <button type="button" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold" id="payNowBtn" onclick="processSeekerPayment()">
              <i class="bi bi-lock me-2"></i>Pay with Pesapal
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Login Required Modal --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-body text-center p-5">
        <div class="rounded-2 bg-warning bg-opacity-20 d-inline-flex p-3 mb-3">
          <i class="bi bi-box-arrow-in-right fs-1 text-warning"></i>
        </div>
        <h5 class="fw-bold mb-2">Login Required</h5>
        <p class="text-muted mb-4">Please sign in to continue with your subscription.</p>
        <div class="d-flex gap-2">
          <a href="{{ route('login.register') }}" class="btn btn-primary rounded-pill px-4 flex-grow-1">Sign In</a>
          <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Upgrade Modal (3 plans: Basic, Pro, Elite - NO FREE TRIAL) --}}
<div class="modal fade" id="upgradeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-header border-0 p-4 pb-0">
        <h5 class="modal-title fw-bold">Upgrade Your Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center mb-4">
          <div class="rounded-2 bg-primary bg-opacity-10 d-inline-flex p-3 mb-3">
            <i class="bi bi-rocket-takeoff fs-1 text-primary"></i>
          </div>
          <h6 class="fw-bold">Choose Your Plan</h6>
          <p class="text-muted small">Select a plan that best fits your needs</p>
        </div>
        <div class="row g-3">
          {{-- Basic Plan --}}
          <div class="col-4">
            <div class="card h-100 border-2 rounded-3 text-center p-3" style="border-color: #e5e7eb; cursor:pointer;" onclick="document.getElementById('upgradeModal').querySelector('.btn-close').click(); window.openSeekerPaymentModal('seeker_basic', 5, 'monthly')">
              <div class="rounded-2 bg-primary bg-opacity-10 d-inline-flex p-2 mb-2">
                <i class="bi bi-file-text fs-3 text-primary"></i>
              </div>
              <h6 class="fw-bold mb-1">Basic</h6>
              <p class="text-muted small">$5/month</p>
              <ul class="list-unstyled text-start small">
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> 5 CV reviews</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> 5 rewrites</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> 10 cover letters</li>
              </ul>
              <button class="btn btn-outline-primary btn-sm rounded-pill w-100">Select</button>
            </div>
          </div>

          {{-- Pro Plan (Popular) --}}
          <div class="col-4">
            <div class="card h-100 border-2 rounded-3 text-center p-3" style="border-color: #1e3a8a; background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%); cursor:pointer;" onclick="document.getElementById('upgradeModal').querySelector('.btn-close').click(); window.openSeekerPaymentModal('seeker_pro', 12, 'monthly')">
              <div class="position-relative">
                <span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size:9px; position:absolute; top:-10px; right:0;">🔥 Popular</span>
              </div>
              <div class="rounded-2 bg-primary bg-opacity-20 d-inline-flex p-2 mb-2">
                <i class="bi bi-stars fs-3 text-primary"></i>
              </div>
              <h6 class="fw-bold mb-1 text-primary">Pro</h6>
              <p class="text-muted small">$12/month</p>
              <ul class="list-unstyled text-start small">
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> Unlimited reviews</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> Unlimited rewrites</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> Unlimited cover letters</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> PDF download</li>
              </ul>
              <button class="btn btn-primary btn-sm rounded-pill w-100">Select</button>
            </div>
          </div>

          {{-- Elite Plan --}}
          <div class="col-4">
            <div class="card h-100 border-2 rounded-3 text-center p-3" style="border-color: #8b5cf6; background: linear-gradient(135deg, #f5f3ff 0%, #ffffff 100%); cursor:pointer;" onclick="document.getElementById('upgradeModal').querySelector('.btn-close').click(); window.openSeekerPaymentModal('seeker_elite', 49, 'yearly')">
              <div class="rounded-2 bg-purple bg-opacity-10 d-inline-flex p-2 mb-2">
                <i class="bi bi-diamond fs-3 text-purple" style="color: #8b5cf6;"></i>
              </div>
              <h6 class="fw-bold mb-1" style="color: #7c3aed;">Elite</h6>
              <p class="text-muted small">$49/year</p>
              <ul class="list-unstyled text-start small">
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> Everything in Pro</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> Aptitude test prep</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> Interview scripts</li>
                <li><i class="bi bi-check-circle-fill text-success me-1" style="font-size:8px;"></i> Career advisor</li>
              </ul>
              <button class="btn btn-outline-purple btn-sm rounded-pill w-100" style="color:#7c3aed; border-color:#7c3aed;">Select</button>
            </div>
          </div>
        </div>
        <div class="text-center mt-3">
          <p class="text-muted small mb-0">All plans include AI-powered CV enhancement tools.</p>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ============================================================= --}}
{{-- SHARED JAVASCRIPT (works for both sections) --}}
{{-- ============================================================= --}}

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes enhFadeIn { 
    from { opacity:0; transform:translateY(6px); } 
    to { opacity:1; transform:translateY(0); } 
}

.dropdown-item.active { background-color: rgba(var(--bs-primary-rgb), 0.1) !important; color: var(--bs-primary) !important; }
.shadow-xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }

/* Pricing plans cards */
#plansContainer .card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
#plansContainer .card:hover { transform: translateY(-4px); }

/* Active subscription tabs */
.enhance-tab-pane { animation: enhFadeIn .2s ease; }
#cvEnhanceTabs .nav-link { color: #4b5563; font-size: 13px; background: transparent; transition: all 0.2s ease; }
#cvEnhanceTabs .nav-link.active { background: linear-gradient(135deg, #1e3a8a, #2563eb); color: #fff; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2); }
#cvEnhanceTabs .nav-link:hover:not(.active) { background: rgba(37, 99, 235, 0.08); color: #1e3a8a; }

/* Cards in active subscription */
.enhance-tab-pane .card { transition: transform 0.2s ease, box-shadow 0.2s ease; border: 1px solid rgba(0, 0, 0, 0.05); }
.enhance-tab-pane .card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.12) !important; }

.border-dashed { border-style: dashed !important; }
.border-dashed:hover { background: #f0f4ff !important; border-color: #2563eb !important; }

.history-item:last-child { border-bottom: none !important; }
.cv-preview { font-family: 'Courier New', Courier, monospace; font-size: 12px; line-height: 1.5; white-space: pre-wrap; }
</style>






<script>
(function() {
    'use strict';

    // ── Config ────────────────────────────────────────────────────────────
    const API_BASE  = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    const API_TOKEN = '{{ session("api_token") }}';
    const CSRF      = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const IS_LOGGED_IN = {{ $IS_LOGGED_IN ? 'true' : 'false' }};
    const HAS_SUBSCRIPTION = {{ $hasActiveSubscription ? 'true' : 'false' }};

    // Limits (match backend)
    const LIMITS = { review: 5, rewrite: 2, cover_letter: 10 };

    // ── GLOBALLY AVAILABLE VARIABLES ─────────────────────────────────────
    let paymentPlans = [];
    let supportedCurrencies = [];
    let currentCurrency = { code: 'USD', symbol: '$', name: 'US Dollar', flag: '🇺🇸' };
    let selectedPackage = null;

    // State for active subscription section
    let reviewFile   = null;
    let rewriteFile  = null;
    let allHistory   = [];
    let currentPage  = 1;
    const PER_PAGE   = 10;
    let histFilter   = { search: '', type: 'all', status: 'all' };
    let historyLoaded = false;

    // ── SHARED FORMAT PRICE ──────────────────────────────────────────────
    function formatPrice(amount) {
        if (!currentCurrency) return `$${Math.round(amount)}`;
        return `${currentCurrency.symbol} ${Math.round(amount).toLocaleString()}`;
    }

    // ── SHOW UPGRADE MODAL ──────────────────────────────────────────────
    window.showUpgradeModal = function() {
        const modalElement = document.getElementById('upgradeModal');
        if (!modalElement) {
            console.warn('Upgrade modal not found');
            return;
        }
        try {
            let modal = bootstrap.Modal.getInstance(modalElement);
            if (!modal) {
                modal = new bootstrap.Modal(modalElement, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
            }
            modal.show();
        } catch (e) {
            console.error('Error showing upgrade modal:', e);
        }
    };

    // ── PAYMENT MODAL ─────────────────────────────────────────────────────
    window.openSeekerPaymentModal = function(planName, priceUsd, period) {
        if (!IS_LOGGED_IN) {
            new bootstrap.Modal(document.getElementById('loginRequiredModal')).show();
            return;
        }

        // If paymentPlans is not available, fetch it first
        if (!paymentPlans || paymentPlans.length === 0) {
            fetch(`${API_BASE}/v1/payment-plans?audience=seeker`, {
                headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${API_TOKEN}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    paymentPlans = data.data.plans || [];
                    supportedCurrencies = data.data.supported_currencies || [];
                    currentCurrency = data.data.detected_currency || { code: 'USD', symbol: '$', name: 'US Dollar', flag: '🇺🇸' };
                    openPaymentModal(planName, priceUsd, period);
                } else {
                    showToast('Failed to load payment details. Please refresh and try again.', 'error');
                }
            })
            .catch(err => {
                console.error('Error fetching plans:', err);
                showToast('Network error. Please try again.', 'error');
            });
            return;
        }

        openPaymentModal(planName, priceUsd, period);
    };

    function openPaymentModal(planName, priceUsd, period) {
        const plan = paymentPlans.find(p => p.name === planName);
        if (!plan) {
            showToast('Plan not found. Please refresh and try again.', 'error');
            return;
        }
        
        selectedPackage = { plan: planName, priceUsd: priceUsd, period: period };
        
        document.getElementById('modalPlanTitle').textContent = plan.display_name + ' Plan';
        document.getElementById('modalPlanDesc').textContent = plan.description;
        document.getElementById('modalPrice').textContent = formatPrice(plan.local_price);
        document.getElementById('modalPeriod').textContent = period === 'monthly' ? '/month' : '/year';
        
        const iconMap = { 'seeker_basic': 'file-text', 'seeker_pro': 'stars', 'seeker_elite': 'diamond' };
        const icon = iconMap[planName] || 'stars';
        document.getElementById('modalIcon').innerHTML = `<i class="bi bi-${icon} fs-2 text-primary"></i>`;
        
        const featuresList = document.getElementById('modalFeatures');
        featuresList.innerHTML = plan.features.map(f => `<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`).join('');
        
        @if(session()->has('web_user'))
        document.getElementById('payerName').value = '{{ session('web_user.first_name') }} {{ session('web_user.last_name') }}';
        document.getElementById('payerEmail').value = '{{ session('web_user.email') }}';
        document.getElementById('payerPhone').value = '{{ session('web_user.phone') ?? '' }}';
        @endif
        
        new bootstrap.Modal(document.getElementById('paymentModal')).show();
    }

    window.processSeekerPayment = async function() {
        const name  = document.getElementById('payerName')?.value?.trim();
        const email = document.getElementById('payerEmail')?.value?.trim();
        const phone = document.getElementById('payerPhone')?.value?.trim();

        document.getElementById('payerNameErr')?.classList.add('d-none');
        document.getElementById('payerEmailErr')?.classList.add('d-none');

        let valid = true;
        if (!name) { showError('payerNameErr', 'Full name is required'); valid = false; }
        if (!email || !email.includes('@')) { showError('payerEmailErr', 'Valid email is required'); valid = false; }
        if (!valid) return;

        const btn = document.getElementById('payNowBtn');
        const originalBtnHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing…';

        const nameParts = name.split(' ');
        const firstName = nameParts[0];
        const lastName  = nameParts.slice(1).join(' ') || firstName;
        const plan      = paymentPlans.find(p => p.name === selectedPackage.plan);

        const payload = {
            plan:         selectedPackage.plan,
            period:       selectedPackage.period,
            amount_usd:   selectedPackage.priceUsd,
            currency:     currentCurrency?.code || 'USD',
            amount_local: plan?.local_price || selectedPackage.priceUsd,
            first_name:   firstName,
            last_name:    lastName,
            email:        email,
            phone:        phone || '',
            country_code: currentCurrency?.country_code || 'UG',
        };

        try {
            const res = await fetch('/payment/initiate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            if (!res.ok) {
                if (data.errors) {
                    const firstError = Object.values(data.errors).flat()[0];
                    showToast(firstError, 'error');
                    if (data.errors.first_name || data.errors.last_name) showError('payerNameErr', data.errors.first_name?.[0] || data.errors.last_name?.[0]);
                    if (data.errors.email) showError('payerEmailErr', data.errors.email[0]);
                } else {
                    showToast(data.message || 'Payment initiation failed. Please try again.', 'error');
                }
                return;
            }

            if (data.success && data.redirect_url) {
                bootstrap.Modal.getInstance(document.getElementById('paymentModal'))?.hide();
                showToast('Redirecting to payment gateway…', 'info');
                setTimeout(() => { window.location.href = data.redirect_url; }, 600);
            } else {
                showToast(data.message || 'Unexpected error. Please try again.', 'error');
            }

        } catch (err) {
            console.error('Payment error:', err);
            showToast('Network error. Please check your connection and try again.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalBtnHtml;
        }
    };

    // =============================================================
    // SECTION 1: PRICING PLANS (only if not logged in or no subscription)
    // =============================================================
    @if(!$IS_LOGGED_IN || !$hasActiveSubscription)

    document.addEventListener('DOMContentLoaded', function() {
        detectAndSetCurrency();
    });

    async function detectAndSetCurrency() {
        try {
            let countryCode = null;
            
            try {
                const res = await fetch('https://freegeoip.app/json/', { signal: AbortSignal.timeout(5000) });
                if (res.ok) {
                    const data = await res.json();
                    countryCode = data.country_code;
                }
            } catch(e) { console.log('freegeoip.app failed:', e); }
            
            if (!countryCode) {
                try {
                    const res = await fetch('http://ip-api.com/json/', { signal: AbortSignal.timeout(5000) });
                    if (res.ok) {
                        const data = await res.json();
                        countryCode = data.countryCode;
                    }
                } catch(e) { console.log('ip-api.com failed:', e); }
            }
            
            await loadPlans(countryCode);
        } catch(error) {
            console.error('Detection failed:', error);
            await loadPlans(null);
        }
    }

    async function loadPlans(countryCode = null) {
        const loadingEl = document.getElementById('plansLoading');
        const container = document.getElementById('plansContainer');
        
        if (!loadingEl || !container) return;
        
        loadingEl.style.display = 'block';
        container.style.display = 'none';
        
        try {
            let url = `${API_BASE}/v1/payment-plans?audience=seeker`;
            if (currentCurrency && currentCurrency.code) {
                url += `&currency=${currentCurrency.code}`;
            } else if (countryCode) {
                url += `&country=${countryCode}`;
            }
            
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${API_TOKEN}` }
            });
            
            const data = await response.json();
            
            if (data.success && data.data) {
                paymentPlans = data.data.plans || [];
                supportedCurrencies = data.data.supported_currencies || [];
                
                if (!currentCurrency) {
                    currentCurrency = data.data.detected_currency || { code: 'USD', symbol: '$', name: 'US Dollar', flag: '🇺🇸' };
                }
                
                renderPlans();
                populateCurrencyList();
                updateCurrencyDisplay();
                
                loadingEl.style.display = 'none';
                container.style.display = 'flex';
                
                if (currentCurrency.code !== 'USD') {
                    showToast(`💱 Prices shown in ${currentCurrency.name} based on your location`, 'info');
                }
            } else {
                throw new Error('Invalid response');
            }
        } catch(error) {
            console.error('Error loading plans:', error);
            loadingEl.innerHTML = `<div class="alert alert-danger">Failed to load pricing plans. <a href="javascript:location.reload()">Refresh</a></div>`;
        }
    }

    async function reloadPlansWithCurrency(currencyCode) {
        const loadingEl = document.getElementById('plansLoading');
        const container = document.getElementById('plansContainer');
        
        loadingEl.style.display = 'block';
        container.style.display = 'none';
        
        try {
            const url = `${API_BASE}/v1/payment-plans?audience=seeker&currency=${currencyCode}`;
            const response = await fetch(url, {
                headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${API_TOKEN}` }
            });
            const data = await response.json();
            
            if (data.success && data.data) {
                paymentPlans = data.data.plans || [];
                supportedCurrencies = data.data.supported_currencies || [];
                renderPlans();
                populateCurrencyList();
                updateCurrencyDisplay();
                loadingEl.style.display = 'none';
                container.style.display = 'flex';
                showToast(`Currency changed to ${currentCurrency.name}`, 'success');
            }
        } catch(error) {
            console.error('Error reloading plans:', error);
        }
    }

    function renderPlans() {
        const container = document.getElementById('plansContainer');
        if (!container || !paymentPlans.length) return;
        
        // Filter out trial plan from display
        const displayPlans = paymentPlans.filter(p => p.name !== 'seeker_trial');
        
        container.innerHTML = displayPlans.map(plan => {
            const price = formatPrice(plan.local_price);
            const period = plan.billing_period === 'monthly' ? '/month' : '/year';
            const yearlyNote = plan.billing_period === 'yearly' ? `<div class="small text-muted mb-2">≈ ${formatPrice(plan.local_price / 12)}/month</div>` : '';
            
            const popularBadge = plan.is_popular ? `<div class="position-absolute top-0 end-0 bg-warning text-dark fw-bold px-3 py-1 rounded-start-pill" style="font-size: 11px; z-index: 1;">${plan.badge_text || '🔥 MOST POPULAR'}</div>` : '';
            const cardStyle = plan.is_popular ? 'background: linear-gradient(135deg, #1e3a8a, #2563eb);' : '';
            const textColor = plan.is_popular ? 'text-white' : '';
            const mutedColor = plan.is_popular ? 'text-white-50' : 'text-muted';
            const btnClass = plan.is_popular ? 'btn-light text-primary' : 'btn-outline-primary';
            
            const iconMap = { 'seeker_basic': 'file-text', 'seeker_pro': 'stars', 'seeker_elite': 'diamond' };
            const icon = iconMap[plan.name] || 'stars';
            const bgIcon = plan.is_popular ? 'bg-white bg-opacity-20' : 'bg-primary bg-opacity-10';
            
            return `
            <div class="col-md-4" style="animation: fadeInUp 0.3s ease both;">
                <div class="card border-0 shadow-lg rounded-4 h-100 position-relative overflow-hidden" style="${cardStyle}">
                    ${popularBadge}
                    <div class="card-body p-4 text-center">
                        <div class="rounded-2 ${bgIcon} d-inline-flex p-2 mb-3">
                            <i class="bi bi-${icon} fs-3 ${textColor}"></i>
                        </div>
                        <h5 class="fw-bold mb-1 ${textColor}">${escapeHtml(plan.display_name)}</h5>
                        <p class="${mutedColor} small mb-3">${escapeHtml(plan.description)}</p>
                        <div class="mb-1">
                            <span class="display-5 fw-bold ${textColor}">${price}</span>
                            <span class="${mutedColor} small">${period}</span>
                        </div>
                        ${yearlyNote}
                        <ul class="list-unstyled text-start mb-4 ${textColor}" style="font-size: 13px;">
                            ${plan.features.map(f => `<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`).join('')}
                        </ul>
                        <button onclick="window.openSeekerPaymentModal('${plan.name}', ${plan.price_usd}, '${plan.billing_period}')" class="btn ${btnClass} rounded-pill w-100 py-2 fw-semibold">
                            ${plan.is_popular ? 'Start Pro Trial' : 'Get Started'}
                        </button>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    function populateCurrencyList() {
        const list = document.getElementById('currencyList');
        if (!list || !supportedCurrencies.length) return;
        
        list.innerHTML = supportedCurrencies.map(c => `
            <li><a class="dropdown-item ${currentCurrency?.code === c.code ? 'active' : ''}" 
                   href="#" onclick="window.changeSeekerCurrency('${c.code}'); return false;">
                <span class="me-2">${c.flag || '🏦'}</span>${c.name} (${c.code})
                <span class="float-end text-muted small">${c.symbol}</span>
            </a></li>
        `).join('');
    }

    function updateCurrencyDisplay() {
        const display = document.getElementById('selectedCurrencyDisplay');
        if (display && currentCurrency) {
            display.innerHTML = `${currentCurrency.flag || ''} ${currentCurrency.code} (${currentCurrency.symbol})`;
        }
    }

    window.changeSeekerCurrency = async function(code) {
        const currency = supportedCurrencies.find(c => c.code === code);
        if (currency) {
            currentCurrency = currency;
            await reloadPlansWithCurrency(code);
            updateCurrencyDisplay();
            populateCurrencyList();
        }
    };

    // ── TRIAL ACTIVATION ──────────────────────────────────────────────────
    window.activateTrial = async function(planName) {
        if (!IS_LOGGED_IN) {
            new bootstrap.Modal(document.getElementById('loginRequiredModal')).show();
            return;
        }

        try {
            const checkRes = await fetch(`${API_BASE}/v1/payment/trial-status`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${API_TOKEN}`,
                }
            });
            const checkData = await checkRes.json();
            
            if (checkData.data?.has_used_trial) {
                showToast('You have already used your free trial. Please subscribe to continue.', 'warning');
                return;
            }
        } catch (e) {
            console.error('Error checking trial status:', e);
        }

        const btn = event?.target;
        const originalHtml = btn?.innerHTML || '';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Activating...';
        }

        try {
            const res = await fetch(`${API_BASE}/v1/payment/activate-trial`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${API_TOKEN}`,
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify({
                    plan: 'seeker_trial',
                    period: 'monthly',
                }),
            });

            const data = await res.json();

            if (!res.ok) {
                showToast(data.message || 'Failed to activate trial.', 'error');
                return;
            }

            if (data.success) {
                showToast('🎉 Free trial activated! You have 7 days to explore all features.', 'success');
                setTimeout(() => location.reload(), 1500);
            }
        } catch (err) {
            console.error('Trial activation error:', err);
            showToast('Network error. Please try again.', 'error');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        }
    };

    @endif

    // =============================================================
    // SECTION 2: ACTIVE SUBSCRIPTION FUNCTIONS
    // =============================================================
    @if($IS_LOGGED_IN && $hasActiveSubscription)

    // Tab switching
    window.switchEnhanceTab = function(tab, btn) {
        document.querySelectorAll('.enhance-tab-pane').forEach(p => p.classList.add('d-none'));
        document.getElementById('enhance-' + tab)?.classList.remove('d-none');
        document.querySelectorAll('#cvEnhanceTabs .nav-link').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        if (tab === 'history' && !historyLoaded) loadHistory();
    };

    // Load usage stats
    async function loadUsageStats() {
        try {
            const res = await apiCall('/v1/cv-enhancement/history', 'GET');
            const data = await safeJson(res);
            if (!data) return;
            const u = data.data?.usage ?? {};
            setUsage('usageReviews', 'usageReviewsBar', u.cv_reviews_count ?? 0, LIMITS.review);
            setUsage('usageRewrites', 'usageRewritesBar', u.cv_rewrites_count ?? 0, LIMITS.rewrite);
            setUsage('usageLetters', 'usageLettersBar', u.cover_letters_count ?? 0, LIMITS.cover_letter);
            if (data.data?.all_history) allHistory = data.data.all_history;
        } catch (e) {
            ['usageReviews','usageRewrites','usageLetters'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = '—';
            });
        }
    }

    function setUsage(countId, barId, used, limit) {
        const countEl = document.getElementById(countId);
        const barEl = document.getElementById(barId);
        if (countEl) countEl.textContent = used;
        if (barEl) barEl.style.width = Math.min((used / limit) * 100, 100) + '%';
    }

    // File handlers
    window.handleEnhDrop = function(e, type) {
        e.preventDefault();
        document.getElementById(type + 'DropZone').style.background = '#f8faff';
        applyFile(e.dataTransfer.files[0], type);
    };
    window.handleReviewFile = (inp) => inp.files[0] && applyFile(inp.files[0], 'review');
    window.handleRewriteFile = (inp) => inp.files[0] && applyFile(inp.files[0], 'rewrite');
    window.clearReviewFile = function() { clearFile('review'); };
    window.clearRewriteFile = function() { clearFile('rewrite'); };

    function applyFile(file, type) {
        if (!file) return;
        if (file.size > 5 * 1024 * 1024) { toast('File must be under 5MB.', 'error'); return; }
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['pdf','doc','docx'].includes(ext)) { toast('Only PDF, DOC, or DOCX files accepted.', 'error'); return; }
        if (type === 'review') reviewFile = file;
        if (type === 'rewrite') rewriteFile = file;
        document.getElementById(type + 'FileName').textContent = file.name;
        document.getElementById(type + 'FilePreview').classList.remove('d-none');
    }

    function clearFile(type) {
        if (type === 'review') reviewFile = null;
        if (type === 'rewrite') rewriteFile = null;
        document.getElementById(type + 'FileInput').value = '';
        document.getElementById(type + 'FilePreview').classList.add('d-none');
    }

    // CV Review
    window.submitCVReview = async function() {
        const btn = document.getElementById('reviewBtn');
        const result = document.getElementById('reviewResult');
        result.innerHTML = '';
        setBtnLoading(btn, 'Analysing your CV…');

        const fd = new FormData();
        if (reviewFile) fd.append('cv_file', reviewFile);
        const role = document.getElementById('reviewTargetRole')?.value?.trim();
        if (role) fd.append('target_role', role);

        try {
            const res = await apiCall('/v1/cv-enhancement/review', 'POST', fd);
            const data = await safeJson(res);
            result.innerHTML = res.ok ? renderReviewResult(data?.data) : errorBox(data?.message || 'Review failed.');
            result.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (res.ok) loadUsageStats();
        } catch (e) {
            result.innerHTML = errorBox('Network error. Please try again.');
        } finally {
            resetBtn(btn, '<i class="bi bi-clipboard2-pulse me-2"></i>Analyse My CV');
        }
    };

    // CV Rewrite
    window.submitCVRewrite = async function() {
        const btn = document.getElementById('rewriteBtn');
        const result = document.getElementById('rewriteResult');
        result.innerHTML = '';
        setBtnLoading(btn, 'Rewriting your CV… (~30 seconds)');

        const fd = new FormData();
        if (rewriteFile) fd.append('cv_file', rewriteFile);
        const role = document.getElementById('rewriteTargetRole')?.value?.trim();
        if (role) fd.append('target_role', role);

        try {
            const res = await apiCall('/v1/cv-enhancement/rewrite', 'POST', fd);
            const data = await safeJson(res);
            result.innerHTML = res.ok ? renderRewriteResult(data?.data) : errorBox(data?.message || 'Rewrite failed.');
            result.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (res.ok) { loadUsageStats(); historyLoaded = false; }
        } catch (e) {
            result.innerHTML = errorBox('Network error. Please try again.');
        } finally {
            resetBtn(btn, '<i class="bi bi-magic me-2"></i>Rewrite My CV');
        }
    };

    // Cover Letter
    window.submitCoverLetter = async function() {
        const btn = document.getElementById('clBtn');
        const result = document.getElementById('clResult');
        const jobTitle = document.getElementById('clJobTitle')?.value?.trim();
        const jobDesc = document.getElementById('clJobDesc')?.value?.trim();

        document.getElementById('clJobTitleErr')?.classList.add('d-none');
        document.getElementById('clJobDescErr')?.classList.add('d-none');

        let valid = true;
        if (!jobTitle) { showError('clJobTitleErr', 'Job title is required.'); valid = false; }
        if (!jobDesc || jobDesc.length < 50) { showError('clJobDescErr', 'Job description must be at least 50 characters.'); valid = false; }
        if (!valid) return;

        result.innerHTML = '';
        setBtnLoading(btn, 'Generating cover letter…');

        const fd = new FormData();
        fd.append('job_title', jobTitle);
        fd.append('job_description', jobDesc);
        fd.append('responsibilities', document.getElementById('clResponsibilities')?.value || '');
        fd.append('required_skills', document.getElementById('clSkills')?.value || '');
        fd.append('company_name', document.getElementById('clCompany')?.value?.trim() || '');
        fd.append('hiring_manager', document.getElementById('clHiringManager')?.value?.trim() || '');

        const cvFile = document.getElementById('clCvFile')?.files[0];
        if (cvFile) fd.append('cv_file', cvFile);

        try {
            const res = await apiCall('/v1/cv-enhancement/cover-letter', 'POST', fd);
            const data = await safeJson(res);
            result.innerHTML = res.ok ? renderCoverLetterResult(data?.data) : errorBox(data?.message || 'Cover letter generation failed.');
            result.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (res.ok) { loadUsageStats(); historyLoaded = false; }
        } catch (e) {
            result.innerHTML = errorBox('Network error. Please try again.');
        } finally {
            resetBtn(btn, '<i class="bi bi-envelope-paper me-2"></i>Generate Cover Letter');
        }
    };

    // History
    async function loadHistory() {
        const container = document.getElementById('historyList');
        if (!container) return;

        if (allHistory.length > 0) {
            historyLoaded = true;
            renderHistoryItems();
            return;
        }

        container.innerHTML = loadingSpinner('Loading history…');

        try {
            const res = await apiCall('/v1/cv-enhancement/history', 'GET');
            const data = await safeJson(res);
            if (!res.ok || !data) { container.innerHTML = errorBox('Could not load history.'); return; }

            const u = data.data?.usage ?? {};
            setUsage('usageReviews', 'usageReviewsBar', u.cv_reviews_count ?? 0, LIMITS.review);
            setUsage('usageRewrites', 'usageRewritesBar', u.cv_rewrites_count ?? 0, LIMITS.rewrite);
            setUsage('usageLetters', 'usageLettersBar', u.cover_letters_count ?? 0, LIMITS.cover_letter);

            allHistory = data.data?.all_history ?? [];
            historyLoaded = true;
            currentPage = 1;
            renderHistoryItems();
        } catch (e) {
            container.innerHTML = errorBox('Network error loading history.');
        }
    }

    window.refreshHistory = function() {
        historyLoaded = false;
        allHistory = [];
        document.getElementById('historySearch').value = '';
        document.getElementById('historyTypeFilter').value = 'all';
        document.getElementById('historyStatusFilter').value = 'all';
        histFilter = { search: '', type: 'all', status: 'all' };
        currentPage = 1;
        loadHistory();
    };

    window.filterHistory = function() {
        histFilter.search = document.getElementById('historySearch')?.value?.toLowerCase() || '';
        histFilter.type = document.getElementById('historyTypeFilter')?.value || 'all';
        histFilter.status = document.getElementById('historyStatusFilter')?.value || 'all';
        currentPage = 1;
        renderHistoryItems();
    };

    window.changePage = function(p) { currentPage = p; renderHistoryItems(); };

    function renderHistoryItems() {
        const container = document.getElementById('historyList');
        const pagDiv = document.getElementById('historyPagination');
        if (!container) return;

        let filtered = allHistory.filter(item => {
            const txt = ((item.job_title || '') + ' ' + (item.company_name || '') + ' ' + (item.created_at || '')).toLowerCase();
            const matchSearch = !histFilter.search || txt.includes(histFilter.search);
            const matchType = histFilter.type === 'all' || item.type === histFilter.type;
            const matchStatus = histFilter.status === 'all' || item.status === histFilter.status;
            return matchSearch && matchType && matchStatus;
        });

        if (!filtered.length) {
            container.innerHTML = `<div class="text-center py-5 text-muted small"><i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>No history found. Start with a CV review!</div>`;
            if (pagDiv) pagDiv.classList.add('d-none');
            return;
        }

        const total = filtered.length;
        const totalPages = Math.ceil(total / PER_PAGE);
        const start = (currentPage - 1) * PER_PAGE;
        const paginated = filtered.slice(start, start + PER_PAGE);

        container.innerHTML = paginated.map(item => historyItemHtml(item)).join('');

        if (pagDiv) {
            pagDiv.classList.toggle('d-none', totalPages <= 1);
            document.getElementById('historyInfo').textContent = `Showing ${start + 1}–${Math.min(start + PER_PAGE, total)} of ${total}`;
            renderPagination(totalPages);
        }
    }

    function historyItemHtml(item) {
        const typeMap = { review: 'CV Review', rewrite: 'CV Rewrite', cover_letter: 'Cover Letter' };
        const colorMap = { review: 'primary', rewrite: 'success', cover_letter: 'warning' };
        const iconMap = { review: 'clipboard2-pulse', rewrite: 'magic', cover_letter: 'envelope-paper' };
        const sColor = { completed: 'success', failed: 'danger', processing: 'warning', pending: 'secondary' };

        const type = item.type || 'review';
        const color = colorMap[type] || 'secondary';
        const icon = iconMap[type] || 'file-text';
        const label = typeMap[type] || 'Unknown';
        const sc = sColor[item.status] || 'secondary';

        let dlBtns = '';
        
        if (type === 'rewrite') {
            dlBtns = `
                <div class="d-flex gap-1 flex-wrap">
                    <button class="btn btn-outline-success rounded-pill px-2 py-1" onclick="downloadItem(${item.id},'word')" style="font-size:10px;border-width:1px;" title="Download as Word">
                        <i class="bi bi-filetype-docx me-1"></i>Word
                    </button>
                    <button class="btn btn-outline-danger rounded-pill px-2 py-1" onclick="downloadItem(${item.id},'pdf')" style="font-size:10px;border-width:1px;" title="Download as PDF">
                        <i class="bi bi-filetype-pdf me-1"></i>PDF
                    </button>
                </div>`;
        } else if (type === 'cover_letter') {
            dlBtns = `
                <div class="d-flex gap-1 flex-wrap">
                    <button class="btn btn-outline-danger rounded-pill px-2 py-1" onclick="downloadLetter(${item.id},'pdf')" style="font-size:10px;border-width:1px;" title="Download as PDF">
                        <i class="bi bi-filetype-pdf me-1"></i>PDF
                    </button>
                    <button class="btn btn-outline-success rounded-pill px-2 py-1" onclick="downloadLetter(${item.id},'word')" style="font-size:10px;border-width:1px;" title="Download as Word">
                        <i class="bi bi-filetype-docx me-1"></i>Word
                    </button>
                </div>`;
        } else if (type === 'review') {
            dlBtns = `
                <div class="d-flex gap-1 flex-wrap">
                    <button class="btn btn-outline-danger rounded-pill px-2 py-1" onclick="downloadReview(${item.id},'pdf')" style="font-size:10px;border-width:1px;" title="Download as PDF">
                        <i class="bi bi-filetype-pdf me-1"></i>PDF
                    </button>
                </div>`;
        }

        return `<div class="d-flex align-items-center gap-3 p-3 border-bottom history-item">
            <div class="rounded-2 bg-${color} bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;">
                <i class="bi bi-${icon} text-${color}"></i>
            </div>
            <div class="flex-grow-1 min-w-0">
                <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap">
                    <div class="min-w-0">
                        <div class="fw-semibold small">${label}
                            ${item.ats_score ? `<span class="badge bg-primary bg-opacity-10 text-primary ms-1 rounded-pill" style="font-size:9px;">ATS: ${item.ats_score}%</span>` : ''}
                            ${item.match_score ? `<span class="badge bg-warning bg-opacity-10 text-warning ms-1 rounded-pill" style="font-size:9px;">Match: ${item.match_score}%</span>` : ''}
                        </div>
                        ${item.job_title ? `<div class="text-muted text-truncate" style="font-size:10px;">${escapeHtml(item.job_title)}${item.company_name ? ' · ' + escapeHtml(item.company_name) : ''}</div>` : ''}
                        <div class="text-muted" style="font-size:10px;">${escapeHtml(item.created_at || '')}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        ${dlBtns}
                        <span class="badge bg-${sc} bg-opacity-10 text-${sc} rounded-pill" style="font-size:9px;">${item.status}</span>
                    </div>
                </div>
            </div>
        </div>`;
    }

    function renderPagination(totalPages) {
        const ul = document.getElementById('historyPageLinks');
        if (!ul) return;
        let html = '';
        html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" onclick="changePage(${currentPage - 1});return false;">&laquo;</a></li>`;
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
            html += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" onclick="changePage(${i});return false;">${i}</a></li>`;
        }
        html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" onclick="changePage(${currentPage + 1});return false;">&raquo;</a></li>`;
        ul.innerHTML = html;
    }

    // Download functions
    window.downloadItem = async function(id, format) {
        const formatLabels = { 'word': 'Word', 'pdf': 'PDF' };
        toast(`Preparing ${formatLabels[format] || format} download…`, 'info');
        try {
            const res = await fetch(`${API_BASE}/v1/cv-enhancement/download/${id}?format=${format}`, {
                headers: { 'Authorization': `Bearer ${API_TOKEN}` },
            });
            if (res.status === 401) { 
                toast('Session expired. Please refresh.', 'error'); 
                return; 
            }
            if (!res.ok) { 
                const errorData = await res.json().catch(() => ({}));
                toast(errorData.error || 'Download failed.', 'error'); 
                return; 
            }
            const blob = await res.blob();
            const extMap = { 'word': 'docx', 'pdf': 'pdf' };
            const ext = extMap[format] || 'txt';
            triggerDownload(blob, `cv_rewrite_${id}.${ext}`);
            toast('Download started!', 'success');
        } catch (e) { 
            console.error('Download error:', e);
            toast('Network error.', 'error'); 
        }
    };

    window.downloadLetter = async function(letterId, format = 'pdf') {
        toast('Preparing cover letter…', 'info');
        try {
            const res = await fetch(`${API_BASE}/v1/cv-enhancement/cover-letter/download/${letterId}?format=${format}`, {
                headers: { 'Authorization': `Bearer ${API_TOKEN}` },
            });
            if (!res.ok) { 
                const errorData = await res.json().catch(() => ({}));
                toast(errorData.error || 'Download failed.', 'error'); 
                return; 
            }
            const blob = await res.blob();
            const extMap = { 'pdf': 'pdf', 'word': 'docx' };
            const ext = extMap[format] || 'txt';
            triggerDownload(blob, `cover_letter_${letterId}.${ext}`);
            toast('Download started!', 'success');
        } catch (e) { 
            console.error('Download error:', e);
            toast('Network error.', 'error'); 
        }
    };

    window.downloadReview = async function(reviewId, format = 'pdf') {
        toast('Preparing review report…', 'info');
        try {
            const res = await fetch(`${API_BASE}/v1/cv-enhancement/review/download/${reviewId}?format=${format}`, {
                headers: { 'Authorization': `Bearer ${API_TOKEN}` },
            });
            if (!res.ok) { 
                const errorData = await res.json().catch(() => ({}));
                toast(errorData.error || 'Download failed.', 'error'); 
                return; 
            }
            const blob = await res.blob();
            const extMap = { 'pdf': 'pdf' };
            const ext = extMap[format] || 'txt';
            triggerDownload(blob, `cv_review_${reviewId}.${ext}`);
            toast('Download started!', 'success');
        } catch (e) { 
            console.error('Download error:', e);
            toast('Network error.', 'error'); 
        }
    };

    function triggerDownload(blob, filename) {
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; 
        a.download = filename;
        document.body.appendChild(a); 
        a.click();
        a.remove(); 
        URL.revokeObjectURL(url);
    }

    // Render result functions
    function renderReviewResult(d) {
        if (!d || d.status === 'failed') return errorBox(d?.error || 'Review failed.');

        const fb = d.feedback || {};
        const score = d.ats_score ?? fb.ats_score ?? 0;
        const sColor = score >= 75 ? 'success' : score >= 50 ? 'warning' : 'danger';
        const issues = fb.critical_issues || [];
        const strengths = fb.strengths || [];
        const actions = fb.recommended_actions || [];
        const kwGaps = Array.isArray(d.keyword_gaps) ? d.keyword_gaps : (fb.keyword_gaps || []);
        const rewrites = fb.achievement_rewrites || [];

        return `<div class="border rounded-3 overflow-hidden">
            <div class="bg-${sColor} bg-opacity-10 p-4 border-bottom d-flex align-items-center gap-3">
                <div class="rounded-circle bg-${sColor} bg-opacity-20 d-flex align-items-center justify-content-center flex-shrink-0" style="width:64px;height:64px;">
                    <span class="fw-bold fs-4 text-${sColor}">${score}</span>
                </div>
                <div>
                    <div class="fw-bold">ATS Compatibility Score</div>
                    <div class="text-muted small">${score >= 75 ? '✅ Good — most ATS systems will parse your CV' : score >= 50 ? '⚠️ Fair — improvements will increase interview callbacks' : '❌ Poor — high risk of being filtered'}</div>
                    <div class="progress mt-1" style="height:5px;width:180px;"><div class="progress-bar bg-${sColor}" style="width:${score}%"></div></div>
                </div>
            </div>
            <div class="p-4">
                ${strengths.length ? `<div class="mb-4"><h6 class="fw-bold small text-success mb-2"><i class="bi bi-check-circle me-2"></i>Strengths</h6><ul class="list-unstyled mb-0">${strengths.map(s => `<li class="d-flex gap-2 mb-1 small"><i class="bi bi-check2 text-success"></i><span>${escapeHtml(s)}</span></li>`).join('')}</ul></div>` : ''}
                ${issues.length ? `<div class="mb-4"><h6 class="fw-bold small text-danger mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Critical Issues</h6>${issues.map(i => `<div class="border border-danger border-opacity-25 rounded-2 p-3 mb-2" style="background:#fff5f5;"><p class="small fw-semibold text-danger mb-1">⚠️ ${escapeHtml(i.issue)}</p><p class="small text-muted mb-0"><i class="bi bi-lightbulb text-warning me-1"></i><strong>Fix:</strong> ${escapeHtml(i.fix)}</p></div>`).join('')}</div>` : ''}
                ${rewrites.length ? `<div class="mb-4"><h6 class="fw-bold small mb-2"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Achievement Rewrites</h6>${rewrites.map(r => `<div class="mb-3"><div class="small p-2 rounded-2 bg-danger bg-opacity-10 text-danger mb-1"><i class="bi bi-x me-1"></i>${escapeHtml(r.original)}</div><div class="small p-2 rounded-2 bg-success bg-opacity-10 text-success"><i class="bi bi-check2 me-1"></i>${escapeHtml(r.improved)}</div></div>`).join('')}</div>` : ''}
                ${kwGaps.length ? `<div class="mb-4"><h6 class="fw-bold small text-warning mb-2"><i class="bi bi-key me-2"></i>Missing Keywords</h6><div class="d-flex flex-wrap gap-1">${kwGaps.map(k => `<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2 py-1" style="font-size:10px;">${escapeHtml(k)}</span>`).join('')}</div></div>` : ''}
                ${actions.length ? `<div class="mb-4"><h6 class="fw-bold small text-primary mb-2"><i class="bi bi-list-check me-2"></i>Your Action Plan</h6><ol class="small ps-3 mb-0">${actions.map(a => `<li class="mb-1">${escapeHtml(a)}</li>`).join('')}</ol></div>` : ''}
                <div class="border-top pt-3"><button class="btn btn-sm btn-success rounded-pill px-3" onclick="switchEnhanceTab('rewrite',document.getElementById('enh-tab-rewrite'))"><i class="bi bi-magic me-1"></i>Get a Full AI Rewrite</button></div>
            </div>
        </div>`;
    }

    function renderRewriteResult(d) {
        if (!d || d.status === 'failed') return errorBox(d?.error || 'Rewrite failed.');
        const text = d.rewritten_cv_text || '';
        const id = d.id;
        return `<div class="border rounded-3 overflow-hidden">
            <div class="bg-success bg-opacity-10 p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="fw-semibold"><i class="bi bi-check-circle-fill text-success me-2"></i>CV Successfully Rewritten</span>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-success rounded-pill px-3" onclick="downloadItem(${id},'word')"><i class="bi bi-filetype-docx me-1"></i>Word</button>
                    <button class="btn btn-sm btn-danger rounded-pill px-3" onclick="downloadItem(${id},'pdf')"><i class="bi bi-filetype-pdf me-1"></i>PDF</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-2" onclick="copyText('rewrittenCvText_${id}')"><i class="bi bi-clipboard"></i></button>
                </div>
            </div>
            <div class="p-4"><div id="rewrittenCvText_${id}" class="border rounded-2 p-3 bg-white" style="font-family:'Courier New',monospace;font-size:12px;line-height:1.6;max-height:550px;overflow-y:auto;white-space:pre-wrap;">${escapeHtml(text)}</div></div>
        </div>`;
    }

    function renderCoverLetterResult(d) {
        if (!d || d.status === 'failed') return errorBox(d?.error || 'Cover letter generation failed.');
        const letter = d.generated_letter || '';
        const id = d.id || 0;
        const score = d.match_score || 0;
        const matched = Array.isArray(d.matched_skills) ? d.matched_skills : [];
        const missing = Array.isArray(d.missing_skills) ? d.missing_skills : [];
        const sColor = score >= 70 ? 'success' : score >= 40 ? 'warning' : 'danger';

        return `<div class="border rounded-3 overflow-hidden">
            <div class="bg-warning bg-opacity-10 p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="fw-semibold"><i class="bi bi-check-circle-fill text-warning me-2"></i>Cover Letter Generated</span>
                <div class="d-flex gap-2 align-items-center">
                    ${score ? `<span class="badge bg-${sColor} rounded-pill">Match: ${score}%</span>` : ''}
                    <button class="btn btn-sm btn-danger rounded-pill px-2" onclick="downloadLetter(${id},'pdf')"><i class="bi bi-filetype-pdf me-1"></i>PDF</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-2" onclick="copyText('clLetterText_${id}')"><i class="bi bi-clipboard"></i></button>
                </div>
            </div>
            <div class="p-4">
                <div id="clLetterText_${id}" class="border rounded-2 p-4 bg-white" style="font-family:Georgia,serif;font-size:13px;line-height:1.8;max-height:550px;overflow-y:auto;white-space:pre-wrap;">${escapeHtml(letter)}</div>
                <div class="mt-3 d-flex gap-2 justify-content-center flex-wrap">
                    <button class="btn btn-sm btn-danger rounded-pill px-3" onclick="downloadLetter(${id},'pdf')"><i class="bi bi-filetype-pdf me-1"></i>Download PDF</button>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="copyText('clLetterText_${id}')"><i class="bi bi-clipboard me-1"></i>Copy Letter</button>
                </div>
            </div>
        </div>`;
    }

    // Cover letter char counter
    document.getElementById('clJobDesc')?.addEventListener('input', function() {
        const el = document.getElementById('clJobDescCount');
        if (el) el.textContent = this.value.length + ' chars';
    });

    @endif

    // =============================================================
    // SHARED UTILITIES
    // =============================================================

    async function apiCall(endpoint, method = 'GET', body = null) {
        const opts = {
            method,
            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${API_TOKEN}`, 'X-CSRF-TOKEN': CSRF },
        };
        if (body) opts.body = body;
        return fetch(`${API_BASE}${endpoint}`, opts);
    }

    async function safeJson(res) {
        try { return await res.json(); } catch { return null; }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function errorBox(msg) {
        return `<div class="alert alert-danger small py-2 px-3 rounded-2 mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>${escapeHtml(msg)}</div>`;
    }

    function loadingSpinner(label) {
        return `<div class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div><p class="text-muted small mt-2 mb-0">${label}</p></div>`;
    }

    function setBtnLoading(btn, label) {
        if (btn) { btn.disabled = true; btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${label}`; }
    }

    function resetBtn(btn, label) {
        if (btn) { btn.disabled = false; btn.innerHTML = label; }
    }

    function showError(elementId, message) {
        const el = document.getElementById(elementId);
        if (el) { el.textContent = message; el.classList.remove('d-none'); }
    }

    function showToast(message, type) {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem;';
            document.body.appendChild(container);
        }
        const colors = { success: '#28a745', error: '#dc3545', warning: '#ffc107', info: '#17a2b8' };
        const toast = document.createElement('div');
        toast.style.cssText = `background:${colors[type] || colors.info};color:#fff;padding:0.75rem 1rem;border-radius:0.5rem;min-width:260px;font-size:0.875rem;cursor:pointer;animation:fadeInUp .2s ease;`;
        toast.textContent = message;
        toast.onclick = () => toast.remove();
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    window.toast = showToast;
    window.copyText = function(elementId) {
        const el = document.getElementById(elementId);
        if (el) navigator.clipboard.writeText(el.textContent || el.innerText).then(() => showToast('Copied!', 'success')).catch(() => showToast('Copy failed', 'error'));
    };

    // Initialize based on state
    @if($IS_LOGGED_IN && $hasActiveSubscription)
    loadUsageStats();
    @endif

})();
</script>

@endsection