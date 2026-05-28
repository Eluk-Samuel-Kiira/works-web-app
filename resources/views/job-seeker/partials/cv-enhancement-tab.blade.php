{{-- resources/views/seeker/partials/cv-enhancement-tab.blade.php --}}
@php
    $API_BASE = rtrim(config('api.main_app.api_base'), '/');
    $API_TOKEN = session('api_token', '');
    
    // Fetch subscription status via API (or fallback to session if you store it)
    $hasActiveSubscription = false;
    $subscriptionPlan = null;
    $subscriptionPeriod = null;
    $subscriptionExpiry = null;
    
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
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200) {
                $data = json_decode($response, true);
                if ($data['success'] && $data['data']['has_active_subscription']) {
                    $hasActiveSubscription = true;
                    $subscriptionPlan = $data['data']['plan'];
                    $subscriptionPeriod = $data['data']['period'];
                    $subscriptionExpiry = $data['data']['expiry_date'];
                }
            }
        } catch (Exception $e) {
            // Fallback to false
        }
    }
@endphp

@if(!$hasActiveSubscription)
{{-- ── UPSELL ─────────────────────────────────────────────────────── --}}
<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
  <div class="card-body p-4" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
    <div class="text-center mb-3">
      <span class="badge bg-white text-dark rounded-pill px-3 py-1 mb-2" style="font-size:10px;">⚡ Limited Time Offer</span>
      <div class="rounded-circle bg-white bg-opacity-20 p-2 d-inline-flex mb-2"><i class="bi bi-stars fs-2 text-white"></i></div>
      <h5 class="fw-bold text-white mb-1">Land Your Dream Job <span style="text-decoration:underline;color:#fcd34d;">Faster</span></h5>
      <p class="small text-white-50 mb-0">AI-powered CV enhancement that gets you noticed</p>
    </div>
    <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
      @foreach(['📊 ATS Score','✍️ Cover Letters','🎯 Keyword Match','💼 Interview Prep'] as $f)
        <span class="badge bg-white text-dark rounded-pill px-2 py-1" style="font-size:10px;">{{ $f }}</span>
      @endforeach
    </div>
    <div class="text-center mb-3">
      <span class="fw-bold text-white" style="font-size:2.5rem;">$5</span><span class="text-white-50">/month</span>
      <span class="badge bg-warning text-dark rounded-pill ms-2" style="font-size:9px;">🔥 Save 40%</span>
    </div>
    <a href="{{ url('/#cv-enhancement') }}" class="btn btn-light fw-semibold rounded-pill w-100 py-2 shadow-sm" style="color:#f97316;">
      <i class="bi bi-lightning-charge me-2"></i>Upgrade Now — Get Hired Faster
    </a>
    <p class="small text-white-50 text-center mt-2 mb-0" style="font-size:10px;">🔒 Secure payment via Pesapal | Cancel anytime</p>
  </div>
</div>

@else
{{-- ── ACTIVE SUBSCRIPTION ─────────────────────────────────────────── --}}

{{-- Usage stats — loaded immediately via JS on DOMContentLoaded --}}
<div class="row g-3 mb-4">
  <div class="col-4">
    <div class="bg-primary bg-opacity-10 rounded-3 p-3 text-center">
      <div class="fw-bold text-primary fs-4" id="usageReviews">
        <span class="spinner-border spinner-border-sm text-primary"></span>
      </div>
      <div class="text-muted small">CV Reviews</div>
      <div class="progress mt-2" style="height:3px;">
        <div class="progress-bar bg-primary" id="usageReviewsBar" style="width:0%"></div>
      </div>
    </div>
  </div>
  <div class="col-4">
    <div class="bg-success bg-opacity-10 rounded-3 p-3 text-center">
      <div class="fw-bold text-success fs-4" id="usageRewrites">
        <span class="spinner-border spinner-border-sm text-success"></span>
      </div>
      <div class="text-muted small">Rewrites</div>
      <div class="progress mt-2" style="height:3px;">
        <div class="progress-bar bg-success" id="usageRewritesBar" style="width:0%"></div>
      </div>
    </div>
  </div>
  <div class="col-4">
    <div class="bg-warning bg-opacity-10 rounded-3 p-3 text-center">
      <div class="fw-bold text-warning fs-4" id="usageLetters">
        <span class="spinner-border spinner-border-sm text-warning"></span>
      </div>
      <div class="text-muted small">Cover Letters</div>
      <div class="progress mt-2" style="height:3px;">
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

      {{-- No CV warning (shown if needed) --}}
      <div id="noCvWarning" class="alert alert-warning small py-2 px-3 rounded-2 mb-3 d-none">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        No CV found on your profile. <a href="#" onclick="document.getElementById('manual-cv-tab')?.click()" class="alert-link">Upload your CV</a> first, or upload a file below.
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
                    placeholder="• Manage the bank's allocated monitoring portfolio PAR (1-90 days)&#10;• Analyse and minimise portfolio risk exposure&#10;• Generate detailed credit recovery reports..."></textarea>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Required Skills / Qualifications <span class="text-muted fw-normal">(paste from job ad)</span></label>
          <textarea class="form-control form-control-sm rounded-2" id="clSkills" rows="3"
                    placeholder="• Bachelor's degree in Finance&#10;• 5+ years credit risk experience&#10;• CPA qualification preferred..."></textarea>
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

      {{-- Filter bar --}}
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

@endif {{-- end hasSubscription --}}


{{-- ══════════════════════════════════════════════════════════════
     JAVASCRIPT — completely self-contained
═══════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    // ── Config ────────────────────────────────────────────────────────────
    const API_BASE  = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    const API_TOKEN = '{{ session("api_token") }}';
    const CSRF      = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Limits (match backend)
    const LIMITS = { review: 5, rewrite: 2, cover_letter: 10 };

    // State
    let reviewFile   = null;
    let rewriteFile  = null;
    let allHistory   = [];   // full dataset from API
    let currentPage  = 1;
    const PER_PAGE   = 10;
    let histFilter   = { search: '', type: 'all', status: 'all' };
    let historyLoaded = false;

    // ── Boot — load usage stats immediately ───────────────────────────────
    loadUsageStats();

    // ── Tab switching ─────────────────────────────────────────────────────
    window.switchEnhanceTab = function (tab, btn) {
        document.querySelectorAll('.enhance-tab-pane').forEach(p => p.classList.add('d-none'));
        document.getElementById('enhance-' + tab)?.classList.remove('d-none');
        document.querySelectorAll('#cvEnhanceTabs .nav-link').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        if (tab === 'history' && !historyLoaded) loadHistory();
    };

    // ── Usage stats (loaded on mount, not on tab click) ───────────────────
    async function loadUsageStats() {
        try {
            const res  = await apiCall('/v1/cv-enhancement/history', 'GET');
            const data = await safeJson(res);
            if (!data) return;
            const u = data.data?.usage ?? {};
            setUsage('usageReviews',  'usageReviewsBar',  u.cv_reviews_count  ?? 0, LIMITS.review);
            setUsage('usageRewrites', 'usageRewritesBar', u.cv_rewrites_count ?? 0, LIMITS.rewrite);
            setUsage('usageLetters',  'usageLettersBar',  u.cover_letters_count ?? 0, LIMITS.cover_letter);
            // Cache the history data so switching to History tab is instant
            if (data.data?.all_history) {
                allHistory = data.data.all_history;
            }
        } catch (e) {
            // Usage display failure is silent — not critical
            ['usageReviews','usageRewrites','usageLetters'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = '—';
            });
        }
    }

    function setUsage(countId, barId, used, limit) {
        const countEl = document.getElementById(countId);
        const barEl   = document.getElementById(barId);
        if (countEl) countEl.textContent = used;
        if (barEl)   barEl.style.width   = Math.min((used / limit) * 100, 100) + '%';
    }

    // ── File handlers ─────────────────────────────────────────────────────
    window.handleEnhDrop = function (e, type) {
        e.preventDefault();
        document.getElementById(type + 'DropZone').style.background = '#f8faff';
        applyFile(e.dataTransfer.files[0], type);
    };

    window.handleReviewFile  = (inp) => inp.files[0] && applyFile(inp.files[0], 'review');
    window.handleRewriteFile = (inp) => inp.files[0] && applyFile(inp.files[0], 'rewrite');

    window.clearReviewFile = function () {
        reviewFile = null;
        document.getElementById('reviewFileInput').value = '';
        document.getElementById('reviewFilePreview').classList.add('d-none');
    };
    window.clearRewriteFile = function () {
        rewriteFile = null;
        document.getElementById('rewriteFileInput').value = '';
        document.getElementById('rewriteFilePreview').classList.add('d-none');
    };

    function applyFile(file, type) {
        if (!file) return;
        if (file.size > 5 * 1024 * 1024) { toast('File must be under 5MB.', 'error'); return; }
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['pdf','doc','docx'].includes(ext)) { toast('Only PDF, DOC, or DOCX files accepted.', 'error'); return; }
        if (type === 'review')  { reviewFile  = file; }
        if (type === 'rewrite') { rewriteFile = file; }
        document.getElementById(type + 'FileName').textContent = file.name;
        document.getElementById(type + 'FilePreview').classList.remove('d-none');
    }

    // ── CV REVIEW ─────────────────────────────────────────────────────────
    window.submitCVReview = async function () {
        const btn    = document.getElementById('reviewBtn');
        const result = document.getElementById('reviewResult');

        result.innerHTML = '';
        setBtnLoading(btn, 'Analysing your CV…');

        const fd = new FormData();
        if (reviewFile) fd.append('cv_file', reviewFile);
        const role = document.getElementById('reviewTargetRole')?.value?.trim();
        if (role) fd.append('target_role', role);

        try {
            const res  = await apiCall('/v1/cv-enhancement/review', 'POST', fd);
            const data = await safeJson(res);
            result.innerHTML = res.ok
                ? renderReviewResult(data?.data)
                : errorBox(data?.message || 'Review failed. Please try again.');
            result.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (res.ok) loadUsageStats();
        } catch (e) {
            result.innerHTML = errorBox('Network error. Please check your connection and try again.');
        } finally {
            resetBtn(btn, '<i class="bi bi-clipboard2-pulse me-2"></i>Analyse My CV');
        }
    };

    // ── CV REWRITE ────────────────────────────────────────────────────────
    window.submitCVRewrite = async function () {
        const btn    = document.getElementById('rewriteBtn');
        const result = document.getElementById('rewriteResult');

        result.innerHTML = '';
        setBtnLoading(btn, 'Rewriting your CV… (~30 seconds)');

        const fd = new FormData();
        if (rewriteFile) fd.append('cv_file', rewriteFile);
        const role = document.getElementById('rewriteTargetRole')?.value?.trim();
        if (role) fd.append('target_role', role);

        try {
            const res  = await apiCall('/v1/cv-enhancement/rewrite', 'POST', fd);
            const data = await safeJson(res);
            result.innerHTML = res.ok
                ? renderRewriteResult(data?.data)
                : errorBox(data?.message || 'Rewrite failed. Please try again.');
            result.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (res.ok) { loadUsageStats(); historyLoaded = false; }
        } catch (e) {
            result.innerHTML = errorBox('Network error. Please try again.');
        } finally {
            resetBtn(btn, '<i class="bi bi-magic me-2"></i>Rewrite My CV');
        }
    };

    // ── COVER LETTER ──────────────────────────────────────────────────────
    window.submitCoverLetter = async function () {
        const btn    = document.getElementById('clBtn');
        const result = document.getElementById('clResult');

        // Client-side validation
        const jobTitle = document.getElementById('clJobTitle')?.value?.trim();
        const jobDesc  = document.getElementById('clJobDesc')?.value?.trim();
        let valid = true;

        document.getElementById('clJobTitleErr').classList.add('d-none');
        document.getElementById('clJobDescErr').classList.add('d-none');

        if (!jobTitle) {
            document.getElementById('clJobTitleErr').textContent = 'Job title is required.';
            document.getElementById('clJobTitleErr').classList.remove('d-none');
            valid = false;
        }
        if (!jobDesc || jobDesc.length < 50) {
            document.getElementById('clJobDescErr').textContent = 'Job description must be at least 50 characters.';
            document.getElementById('clJobDescErr').classList.remove('d-none');
            valid = false;
        }
        if (!valid) return;

        result.innerHTML = '';
        setBtnLoading(btn, 'Generating cover letter…');

        const fd = new FormData();
        fd.append('job_title',        jobTitle);
        fd.append('job_description',  jobDesc);
        fd.append('responsibilities', document.getElementById('clResponsibilities')?.value || '');
        fd.append('required_skills',  document.getElementById('clSkills')?.value || '');
        fd.append('company_name',     document.getElementById('clCompany')?.value?.trim() || '');
        fd.append('hiring_manager',   document.getElementById('clHiringManager')?.value?.trim() || '');

        const cvFile = document.getElementById('clCvFile')?.files[0];
        if (cvFile) fd.append('cv_file', cvFile);

        try {
            const res  = await apiCall('/v1/cv-enhancement/cover-letter', 'POST', fd);
            const data = await safeJson(res);
            result.innerHTML = res.ok
                ? renderCoverLetterResult(data?.data)
                : errorBox(data?.message || 'Cover letter generation failed.');
            result.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (res.ok) { loadUsageStats(); historyLoaded = false; }
        } catch (e) {
            result.innerHTML = errorBox('Network error. Please try again.');
        } finally {
            resetBtn(btn, '<i class="bi bi-envelope-paper me-2"></i>Generate Cover Letter');
        }
    };

    // Cover letter char counter
    document.getElementById('clJobDesc')?.addEventListener('input', function () {
        const el = document.getElementById('clJobDescCount');
        if (el) el.textContent = this.value.length + ' chars';
    });

    // ── HISTORY ───────────────────────────────────────────────────────────
    async function loadHistory() {
        const container = document.getElementById('historyList');
        if (!container) return;

        // If we already have data from the usage stats load, use it
        if (allHistory.length > 0) {
            historyLoaded = true;
            renderHistoryItems();
            return;
        }

        container.innerHTML = loadingSpinner('Loading history…');

        try {
            const res  = await apiCall('/v1/cv-enhancement/history', 'GET');
            const data = await safeJson(res);
            if (!res.ok || !data) { container.innerHTML = errorBox('Could not load history.'); return; }

            const u = data.data?.usage ?? {};
            setUsage('usageReviews',  'usageReviewsBar',  u.cv_reviews_count  ?? 0, LIMITS.review);
            setUsage('usageRewrites', 'usageRewritesBar', u.cv_rewrites_count ?? 0, LIMITS.rewrite);
            setUsage('usageLetters',  'usageLettersBar',  u.cover_letters_count ?? 0, LIMITS.cover_letter);

            allHistory    = data.data?.all_history ?? [];
            historyLoaded = true;
            currentPage   = 1;
            renderHistoryItems();
        } catch (e) {
            container.innerHTML = errorBox('Network error loading history.');
        }
    }

    window.refreshHistory = function () {
        historyLoaded = false;
        allHistory    = [];
        document.getElementById('historySearch').value       = '';
        document.getElementById('historyTypeFilter').value   = 'all';
        document.getElementById('historyStatusFilter').value = 'all';
        histFilter = { search: '', type: 'all', status: 'all' };
        currentPage = 1;
        loadHistory();
    };

    window.filterHistory = function () {
        histFilter.search = document.getElementById('historySearch')?.value?.toLowerCase() || '';
        histFilter.type   = document.getElementById('historyTypeFilter')?.value || 'all';
        histFilter.status = document.getElementById('historyStatusFilter')?.value || 'all';
        currentPage = 1;
        renderHistoryItems();
    };

    window.changePage = function (p) {
        currentPage = p;
        renderHistoryItems();
    };

    function renderHistoryItems() {
        const container = document.getElementById('historyList');
        const pagDiv    = document.getElementById('historyPagination');
        if (!container) return;

        // Filter
        let filtered = allHistory.filter(item => {
            const txt = ((item.job_title || '') + ' ' + (item.company_name || '') + ' ' + (item.created_at || '')).toLowerCase();
            const matchSearch = !histFilter.search || txt.includes(histFilter.search);
            const matchType   = histFilter.type   === 'all' || item.type   === histFilter.type;
            const matchStatus = histFilter.status === 'all' || item.status === histFilter.status;
            return matchSearch && matchType && matchStatus;
        });

        if (!filtered.length) {
            container.innerHTML = `<div class="text-center py-5 text-muted small">
                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>
                No history found. Start with a CV review!
            </div>`;
            if (pagDiv) pagDiv.classList.add('d-none');
            return;
        }

        const total      = filtered.length;
        const totalPages = Math.ceil(total / PER_PAGE);
        const start      = (currentPage - 1) * PER_PAGE;
        const paginated  = filtered.slice(start, start + PER_PAGE);

        container.innerHTML = paginated.map(item => historyItemHtml(item)).join('');

        // Pagination
        if (pagDiv) {
            pagDiv.classList.toggle('d-none', totalPages <= 1);
            document.getElementById('historyInfo').textContent =
                `Showing ${start + 1}–${Math.min(start + PER_PAGE, total)} of ${total}`;
            renderPagination(totalPages);
        }
    }

    function historyItemHtml(item) {
        const typeMap  = { review:'CV Review', rewrite:'CV Rewrite', cover_letter:'Cover Letter' };
        const colorMap = { review:'primary', rewrite:'success', cover_letter:'warning' };
        const iconMap  = { review:'clipboard2-pulse', rewrite:'magic', cover_letter:'envelope-paper' };
        const sColor   = { completed:'success', failed:'danger', processing:'warning', pending:'secondary' };

        const type  = item.type || 'review';
        const color = colorMap[type] || 'secondary';
        const icon  = iconMap[type]  || 'file-text';
        const label = typeMap[type]  || 'Unknown';
        const sc    = sColor[item.status] || 'secondary';

        const hasDl = item.has_rewrite || item.has_letter || item.has_feedback;
        const dlBtns = hasDl ? `
            <div class="d-flex gap-1 flex-wrap">
                ${item.has_rewrite ? `
                <button class="btn btn-outline-success rounded-pill px-2 py-1" onclick="downloadItem(${item.id},'word')" style="font-size:10px;">
                    <i class="bi bi-filetype-docx me-1"></i>Word
                </button>
                <button class="btn btn-outline-secondary rounded-pill px-2 py-1" onclick="downloadItem(${item.id},'text')" style="font-size:10px;">
                    <i class="bi bi-filetype-txt me-1"></i>Text
                </button>` : ''}
                ${item.has_letter ? `
                <button class="btn btn-outline-warning rounded-pill px-2 py-1" onclick="downloadLetter(${item.id})" style="font-size:10px;">
                    <i class="bi bi-download me-1"></i>Letter
                </button>` : ''}
            </div>` : '';

        return `
        <div class="d-flex align-items-center gap-3 p-3 border-bottom history-item">
          <div class="rounded-2 bg-${color} bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px;">
            <i class="bi bi-${icon} text-${color}"></i>
          </div>
          <div class="flex-grow-1 min-w-0">
            <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap">
              <div class="min-w-0">
                <div class="fw-semibold small">${label}
                  ${item.ats_score   ? `<span class="badge bg-primary bg-opacity-10 text-primary ms-1 rounded-pill" style="font-size:9px;">ATS: ${item.ats_score}%</span>` : ''}
                  ${item.match_score ? `<span class="badge bg-warning bg-opacity-10 text-warning ms-1 rounded-pill" style="font-size:9px;">Match: ${item.match_score}%</span>` : ''}
                </div>
                ${item.job_title ? `<div class="text-muted text-truncate" style="font-size:10px;">${esc(item.job_title)}${item.company_name ? ' · ' + esc(item.company_name) : ''}</div>` : ''}
                <div class="text-muted" style="font-size:10px;">${esc(item.created_at || '')}</div>
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
        html += `<li class="page-item ${currentPage===1?'disabled':''}"><a class="page-link" href="#" onclick="changePage(${currentPage-1});return false;">&laquo;</a></li>`;
        for (let i = Math.max(1, currentPage-2); i <= Math.min(totalPages, currentPage+2); i++) {
            html += `<li class="page-item ${currentPage===i?'active':''}"><a class="page-link" href="#" onclick="changePage(${i});return false;">${i}</a></li>`;
        }
        html += `<li class="page-item ${currentPage===totalPages?'disabled':''}"><a class="page-link" href="#" onclick="changePage(${currentPage+1});return false;">&raquo;</a></li>`;
        ul.innerHTML = html;
    }

    // ── Download — uses Authorization header, NOT direct URL redirect ─────
    // Direct URL redirect logs user out because the route requires auth:sanctum
    // but the browser sends no Authorization header on URL navigation.
    // We fetch the file as a blob and trigger download client-side.
    window.downloadItem = async function (id, format) {
        toast('Preparing download…', 'info');
        try {
            const res = await fetch(`${API_BASE}/v1/cv-enhancement/download/${id}?format=${format}`, {
                headers: { 'Authorization': `Bearer ${API_TOKEN}` },
            });
            if (res.status === 401) { toast('Session expired. Please refresh the page.', 'error'); return; }
            if (!res.ok) { toast('Download failed. Please try again.', 'error'); return; }

            const blob = await res.blob();
            const ext  = format === 'word' ? 'docx' : (format === 'html' ? 'html' : 'txt');
            triggerDownload(blob, `cv_rewrite_${id}.${ext}`);
            toast('Download started!', 'success');
        } catch (e) {
            toast('Network error during download.', 'error');
        }
    };

    window.downloadLetter = async function (letterId) {
        toast('Preparing cover letter…', 'info');
        try {
            const res = await fetch(`${API_BASE}/v1/cv-enhancement/cover-letter/download/${letterId}`, {
                headers: { 'Authorization': `Bearer ${API_TOKEN}` },
            });
            if (!res.ok) { toast('Download failed.', 'error'); return; }
            triggerDownload(await res.blob(), `cover_letter_${letterId}.txt`);
            toast('Download started!', 'success');
        } catch (e) {
            toast('Network error.', 'error');
        }
    };

    function triggerDownload(blob, filename) {
        const url = URL.createObjectURL(blob);
        const a   = document.createElement('a');
        a.href = url; a.download = filename;
        document.body.appendChild(a); a.click();
        a.remove(); URL.revokeObjectURL(url);
    }

    // ── Render results ────────────────────────────────────────────────────
    function renderReviewResult(d) {
        if (!d || d.status === 'failed') return errorBox(d?.error || 'Review failed. Please try again.');

        const fb       = d.feedback || {};
        const score    = d.ats_score ?? fb.ats_score ?? 0;
        const sColor   = score >= 75 ? 'success' : score >= 50 ? 'warning' : 'danger';
        const issues   = fb.critical_issues || [];
        const strengths= fb.strengths || [];
        const actions  = fb.recommended_actions || [];
        const kwGaps   = Array.isArray(d.keyword_gaps) ? d.keyword_gaps : (fb.keyword_gaps || []);
        const rewrites = fb.achievement_rewrites || [];

        return `
        <div class="border rounded-3 overflow-hidden">
          <div class="bg-${sColor} bg-opacity-10 p-4 border-bottom d-flex align-items-center gap-3">
            <div class="rounded-circle bg-${sColor} bg-opacity-20 d-flex align-items-center justify-content-center flex-shrink-0" style="width:64px;height:64px;">
              <span class="fw-bold fs-4 text-${sColor}">${score}</span>
            </div>
            <div>
              <div class="fw-bold">ATS Compatibility Score</div>
              <div class="text-muted small">${score>=75?'✅ Good — most ATS systems will parse your CV':score>=50?'⚠️ Fair — improvements will increase interview callbacks':'❌ Poor — high risk of being filtered before a human sees it'}</div>
              <div class="progress mt-1" style="height:5px;width:180px;"><div class="progress-bar bg-${sColor}" style="width:${score}%"></div></div>
            </div>
          </div>

          <div class="p-4">
            ${fb.overall_impression ? `
            <div class="mb-4 p-3 bg-light rounded-2 border-start border-4 border-primary">
              <div class="fw-semibold small text-primary mb-1">HR Assessment</div>
              <p class="small text-muted mb-0">${esc(fb.overall_impression)}</p>
            </div>` : ''}

            ${strengths.length ? `
            <div class="mb-4">
              <h6 class="fw-bold small text-success mb-2"><i class="bi bi-check-circle me-2"></i>Strengths</h6>
              <ul class="list-unstyled mb-0">${strengths.map(s=>`<li class="d-flex gap-2 mb-1 small"><i class="bi bi-check2 text-success flex-shrink-0 mt-1"></i><span>${esc(s)}</span></li>`).join('')}</ul>
            </div>` : ''}

            ${issues.length ? `
            <div class="mb-4">
              <h6 class="fw-bold small text-danger mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Critical Issues</h6>
              ${issues.map(i=>`
              <div class="border border-danger border-opacity-25 rounded-2 p-3 mb-2" style="background:#fff5f5;">
                <div class="d-flex gap-2 align-items-center mb-1">
                  <span class="badge bg-danger rounded-pill" style="font-size:9px;">${esc(i.section||'Issue')}</span>
                </div>
                <p class="small fw-semibold text-danger mb-1">⚠️ ${esc(i.issue)}</p>
                <p class="small text-muted mb-0"><i class="bi bi-lightbulb text-warning me-1"></i><strong>Fix:</strong> ${esc(i.fix)}</p>
              </div>`).join('')}
            </div>` : ''}

            ${rewrites.length ? `
            <div class="mb-4">
              <h6 class="fw-bold small mb-2"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Achievement Rewrites</h6>
              ${rewrites.map(r=>`
              <div class="mb-3">
                <div class="small p-2 rounded-2 bg-danger bg-opacity-10 text-danger mb-1"><i class="bi bi-x me-1"></i>${esc(r.original)}</div>
                <div class="small p-2 rounded-2 bg-success bg-opacity-10 text-success"><i class="bi bi-check2 me-1"></i>${esc(r.improved)}</div>
              </div>`).join('')}
            </div>` : ''}

            ${kwGaps.length ? `
            <div class="mb-4">
              <h6 class="fw-bold small text-warning mb-2"><i class="bi bi-key me-2"></i>Missing Keywords</h6>
              <div class="d-flex flex-wrap gap-1">
                ${kwGaps.map(k=>`<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2 py-1" style="font-size:10px;">${esc(k)}</span>`).join('')}
              </div>
            </div>` : ''}

            ${actions.length ? `
            <div class="mb-4">
              <h6 class="fw-bold small text-primary mb-2"><i class="bi bi-list-check me-2"></i>Your Action Plan</h6>
              <ol class="small ps-3 mb-0">${actions.map(a=>`<li class="mb-1">${esc(a)}</li>`).join('')}</ol>
            </div>` : ''}

            <div class="border-top pt-3 d-flex gap-2 flex-wrap align-items-center">
              <button class="btn btn-sm btn-success rounded-pill px-3" onclick="switchEnhanceTab('rewrite',document.getElementById('enh-tab-rewrite'))">
                <i class="bi bi-magic me-1"></i>Get a Full AI Rewrite
              </button>
              <span class="small text-muted"><i class="bi bi-envelope me-1"></i>Full report sent to your email</span>
            </div>
          </div>
        </div>`;
    }

    function renderRewriteResult(d) {
        if (!d || d.status === 'failed') return errorBox(d?.error || 'Rewrite failed. Please try again.');

        const text = d.rewritten_cv_text || '';
        const id   = d.id;
        const html = mdToHtml(text);

        return `
        <div class="border rounded-3 overflow-hidden">
          <div class="bg-success bg-opacity-10 p-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
              <span class="fw-semibold"><i class="bi bi-check-circle-fill text-success me-2"></i>CV Successfully Rewritten</span>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-success rounded-pill px-3" onclick="downloadItem(${id},'word')">
                  <i class="bi bi-filetype-docx me-1"></i>Word (Editable)
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="downloadItem(${id},'text')">
                  <i class="bi bi-filetype-txt me-1"></i>Plain Text
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-2" onclick="copyText('rewrittenCvText_${id}')" title="Copy to clipboard">
                  <i class="bi bi-clipboard"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="p-4">
            <div id="rewrittenCvText_${id}" class="border rounded-2 p-3 bg-white"
                 style="font-family:'Courier New',Courier,monospace;font-size:12px;line-height:1.6;max-height:550px;overflow-y:auto;white-space:pre-wrap;">
${esc(text)}
            </div>
            <div class="mt-3 small text-muted text-center">
              <i class="bi bi-envelope me-1"></i>Word &amp; plain text copies sent to your email
            </div>
          </div>
        </div>`;
    }

    function renderCoverLetterResult(d) {
        if (!d || d.status === 'failed') return errorBox(d?.error || 'Cover letter generation failed.');

        const letter = d.generated_letter || '';
        const id     = d.id || 0;
        const score  = d.match_score || 0;
        const matched = Array.isArray(d.matched_skills) ? d.matched_skills : [];
        const missing = Array.isArray(d.missing_skills)  ? d.missing_skills  : [];
        const sColor  = score >= 70 ? 'success' : score >= 40 ? 'warning' : 'danger';

        return `
        <div class="border rounded-3 overflow-hidden">
          <div class="bg-warning bg-opacity-10 p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="fw-semibold"><i class="bi bi-check-circle-fill text-warning me-2"></i>Cover Letter Generated</span>
            <div class="d-flex gap-2 align-items-center">
              ${score ? `<span class="badge bg-${sColor} rounded-pill">Match: ${score}%</span>` : ''}
              <button class="btn btn-sm btn-outline-secondary rounded-pill px-2" onclick="copyText('clLetterText_${id}')" title="Copy">
                <i class="bi bi-clipboard"></i>
              </button>
            </div>
          </div>
          <div class="p-4">
            ${matched.length ? `<div class="mb-3"><span class="text-muted small"><i class="bi bi-check2 text-success me-1"></i>Matched: ${matched.slice(0,5).map(esc).join(', ')}</span></div>` : ''}
            ${missing.length ? `<div class="mb-3"><span class="text-muted small"><i class="bi bi-exclamation-circle text-warning me-1"></i>Address in interview: ${missing.slice(0,3).map(esc).join(', ')}</span></div>` : ''}

            <div id="clLetterText_${id}" class="border rounded-2 p-4 bg-white"
                 style="font-family:Georgia,serif;font-size:13px;line-height:1.8;max-height:550px;overflow-y:auto;white-space:pre-wrap;">
${esc(letter)}
            </div>
            <div class="mt-3 d-flex gap-2 justify-content-center flex-wrap">
              <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="copyText('clLetterText_${id}')">
                <i class="bi bi-clipboard me-1"></i>Copy Letter
              </button>
              <span class="small text-muted d-flex align-items-center"><i class="bi bi-envelope me-1"></i>Copy sent to your email</span>
            </div>
          </div>
        </div>`;
    }

    // ── Utilities ─────────────────────────────────────────────────────────
    async function apiCall(endpoint, method = 'GET', body = null) {
        const opts = {
            method,
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${API_TOKEN}`,
                'X-CSRF-TOKEN': CSRF,
            },
        };
        if (body) opts.body = body;
        return fetch(`${API_BASE}${endpoint}`, opts);
    }

    async function safeJson(res) {
        try { return await res.json(); } catch { return null; }
    }

    function esc(text) {
        if (text === null || text === undefined) return '';
        const d = document.createElement('div');
        d.textContent = String(text);
        return d.innerHTML;
    }

    function mdToHtml(text) {
        if (!text) return '';
        let h = esc(text);
        h = h.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        h = h.replace(/^[•\-]\s+(.*?)$/gm, '• $1');
        return h;
    }

    window.copyText = function (elementId) {
        const el = document.getElementById(elementId);
        if (!el) return;
        navigator.clipboard.writeText(el.textContent || el.innerText)
            .then(() => toast('Copied to clipboard!', 'success'))
            .catch(() => toast('Copy failed — please select and copy manually.', 'error'));
    };

    function errorBox(msg) {
        return `<div class="alert alert-danger small py-2 px-3 rounded-2 mb-0">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>${esc(msg)}
        </div>`;
    }

    function loadingSpinner(label) {
        return `<div class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div>
            <p class="text-muted small mt-2 mb-0">${label}</p></div>`;
    }

    function setBtnLoading(btn, label) {
        if (btn) { btn.disabled = true; btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${label}`; }
    }

    function resetBtn(btn, label) {
        if (btn) { btn.disabled = false; btn.innerHTML = label; }
    }

    function toast(msg, type) {
        const colors = { success:'#198754', error:'#dc3545', info:'#0dcaf0', warning:'#e5a900' };
        let c = document.getElementById('enhToastCont');
        if (!c) {
            c = document.createElement('div');
            c.id = 'enhToastCont';
            c.style.cssText = 'position:fixed;bottom:1.25rem;right:1.25rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;min-width:260px;';
            document.body.appendChild(c);
        }
        const t = document.createElement('div');
        t.style.cssText = `background:${colors[type]||colors.info};color:#fff;padding:.75rem 1rem;border-radius:.5rem;font-size:.875rem;box-shadow:0 4px 12px rgba(0,0,0,.15);cursor:pointer;`;
        t.textContent = msg;
        t.onclick = () => t.remove();
        c.appendChild(t);
        setTimeout(() => t.remove(), 4000);
    }

})();
</script>

<style>
.enhance-tab-pane { animation: enhFadeIn .2s ease; }
@keyframes enhFadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
#cvEnhanceTabs .nav-link { color:#4b5563; font-size:13px; }
#cvEnhanceTabs .nav-link.active { background:var(--bs-primary); color:#fff; }
#cvEnhanceTabs .nav-link:hover:not(.active) { background:rgba(var(--bs-primary-rgb),.07); }
.history-item:last-child { border-bottom: none !important; }
.cv-preview { font-family:'Courier New',Courier,monospace; font-size:12px; line-height:1.5; white-space:pre-wrap; }
</style>