{{-- ═══════════════════════════════════════════════════════════════════
     AI JOB RECOMMENDATIONS SECTION
     Drop this wherever you had the old loadRecommendedJobs() section
════════════════════════════════════════════════════════════════════ --}}
<div class="card border-0 shadow-sm rounded-3 overflow-hidden">

  <div class="card-header bg-white border-bottom p-3 p-md-4">
    <div class="d-flex align-items-center gap-2 gap-md-3 flex-nowrap">
      <div class="rounded-2 bg-primary bg-opacity-10 p-2 flex-shrink-0">
        <i class="bi bi-robot fs-5 fs-md-4 text-primary"></i>
      </div>
      <div class="flex-grow-1 min-width-0">
        <h6 class="fw-bold mb-0 text-truncate">Job Recommendations</h6>
        <small class="text-muted text-truncate d-block" id="recSubtitle" style="font-size: 0.7rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Personalised matches based on your CV</small>
      </div>
      <div class="flex-shrink-0 d-flex align-items-center gap-2">
        <span class="badge bg-primary rounded-pill px-2 px-md-3 py-1 py-md-2" id="recModeBadge" style="display:none!important"></span>
        <button class="btn btn-sm btn-outline-primary rounded-pill px-2 px-md-3" onclick="refreshRecommendations()" id="recRefreshBtn" style="display:none">
          <i class="bi bi-arrow-clockwise me-0 me-md-1"></i>
          <span class="d-none d-md-inline">Refresh</span>
        </button>
      </div>
    </div>
  </div>

  <div class="card-body p-4 bg-light">
    <div class="row g-3" id="recommendedJobs">

      {{-- Skeleton loaders --}}
      @for($i = 0; $i < 3; $i++)
      <div class="col-md-6 col-lg-4 rec-skeleton">
        <div class="card border rounded-3 h-100 shadow-sm">
          <div class="card-body p-3">
            <div class="d-flex gap-3 mb-3">
              <div class="rounded-2 bg-secondary opacity-10 flex-shrink-0" style="width:48px;height:48px;background:#e9ecef!important;"></div>
              <div class="flex-grow-1">
                <div class="rounded-2 mb-2" style="height:14px;background:#e9ecef;width:80%;"></div>
                <div class="rounded-2" style="height:11px;background:#e9ecef;width:55%;"></div>
              </div>
            </div>
            <div class="d-flex gap-1 mb-3">
              <div class="rounded-pill" style="height:20px;width:60px;background:#e9ecef;"></div>
              <div class="rounded-pill" style="height:20px;width:50px;background:#e9ecef;"></div>
            </div>
            <div class="d-flex justify-content-between align-items-center border-top pt-2">
              <div class="rounded-2" style="height:11px;width:60px;background:#e9ecef;"></div>
              <div class="rounded-pill" style="height:26px;width:52px;background:#e9ecef;"></div>
            </div>
          </div>
        </div>
      </div>
      @endfor

    </div>
  </div>
</div>


{{-- ═══════════════════════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    const API_BASE  = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    const API_TOKEN = '{{ session("api_token") }}';
    const IS_AUTH   = {{ session()->has('api_token') ? 'true' : 'false' }};
    const CSRF      = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // ── Boot ──────────────────────────────────────────────────────────────
    if (IS_AUTH) {
        // Defer so it doesn't compete with first paint
        if ('requestIdleCallback' in window) {
            requestIdleCallback(loadRecommendedJobs);
        } else {
            setTimeout(loadRecommendedJobs, 300);
        }
    } else {
        renderNoAuth();
    }

    // ── Load ─────────────────────────────────────────────────────────────
    async function loadRecommendedJobs() {
        try {
            const res    = await fetch(`${API_BASE}/seeker/recommendations?limit=6`, {
                headers: {
                    'Accept'       : 'application/json',
                    'Authorization': `Bearer ${API_TOKEN}`,
                    'X-CSRF-TOKEN' : CSRF,
                },
            });
            const result = await res.json();

            if (!res.ok) throw new Error(result.message || 'Request failed');

            const jobs = result.data ?? [];
            updateHeader(result);

            if (jobs.length === 0) {
                renderEmpty(result);
            } else {
                renderJobs(jobs, result);
            }

        } catch (err) {
            console.error('[Recommendations]', err);
            renderError();
        }
    }

    // ── Expose refresh globally so the button works ───────────────────────
    window.refreshRecommendations = async function () {
        const btn = document.getElementById('recRefreshBtn');
        if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'; }
        showSkeletons();

        try {
            // Bust server cache first
            await fetch(`${API_BASE}/seeker/recommendations/refresh`, {
                method : 'POST',
                headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${API_TOKEN}`, 'X-CSRF-TOKEN': CSRF },
            });
        } catch (_) {}

        await loadRecommendedJobs();
        if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i>Refresh'; }
    };


    function renderJobs(jobs, result) {
        const c = document.getElementById('recommendedJobs');
        if (!c) return;

        const DEFAULT_LOGO = '{{ asset("default-logo.png") }}';

        c.innerHTML = jobs.map(job => {
            const slug  = job.slug || job.id;
            const score = job.recommendation_score ?? 0;
            const logoUrl = job.company?.logo_url || null;

            // ── Logo ──────────────────────────────────────────────────────────
            const logoHtml = logoUrl
                ? `<img src="${esc(logoUrl)}"
                        width="40" height="40"
                        class="rounded-2 border flex-shrink-0"
                        style="object-fit:contain;background:#fff;padding:3px;min-width:40px;"
                        loading="lazy"
                        onerror="this.onerror=null;this.src='${DEFAULT_LOGO}';">`
                : `<div class="rounded-2 border bg-body-secondary d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:40px;height:40px;min-width:40px;">
                    <i class="bi bi-building text-primary" style="font-size:16px;"></i>
                  </div>`;

            // ── Badges ────────────────────────────────────────────────────────
            const featuredBadge = job.is_featured
                ? `<span class="badge bg-warning text-dark rounded-pill" style="font-size:8px;padding:2px 6px;">
                    <i class="bi bi-star-fill"></i> Featured
                  </span>` : '';
            const urgentBadge = job.is_urgent
                ? `<span class="badge bg-danger rounded-pill" style="font-size:8px;padding:2px 6px;">
                    <i class="bi bi-lightning-fill"></i> Urgent
                  </span>` : '';

            // ── Match bar ─────────────────────────────────────────────────────
            const scoreBar = score > 0
                ? `<div class="d-flex align-items-center gap-1 mb-1">
                    <span class="text-muted" style="font-size:9px;white-space:nowrap;flex-shrink:0;">Match</span>
                    <div class="progress flex-grow-1" style="height:3px;min-width:0;">
                      <div class="progress-bar ${score >= 70 ? 'bg-success' : score >= 40 ? 'bg-warning' : 'bg-secondary'}"
                            style="width:${score}%"></div>
                    </div>
                    <span class="fw-semibold text-muted" style="font-size:9px;flex-shrink:0;">${score}%</span>
                  </div>` : '';

            // ── Reason ────────────────────────────────────────────────────────
            const reason = (job.match_reasons ?? []).slice(0, 1).map(r =>
                `<p class="text-muted mb-1 text-truncate" style="font-size:9px;">
                  <i class="bi bi-check2 text-success me-1"></i>${esc(r)}
                </p>`
            ).join('');

            return `
            <div class="col-12 col-sm-6 col-lg-4">
              <div class="card border rounded-3 h-100 shadow-sm" style="min-width:0;">
                <div class="card-body p-3 d-flex flex-column" style="min-width:0;overflow:hidden;">

                  {{-- Badges row (only if present) --}}
                  ${(featuredBadge || urgentBadge)
                    ? `<div class="d-flex gap-1 mb-2 flex-wrap">${featuredBadge}${urgentBadge}</div>`
                    : ''}

                  {{-- Logo + Title row --}}
                  <div class="d-flex gap-2 mb-2" style="min-width:0;">
                    ${logoHtml}
                    <div style="min-width:0;flex:1 1 0;overflow:hidden;">
                      <h3 class="fw-semibold mb-0" style="font-size:.8rem;line-height:1.3;
                          display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
                          overflow:hidden;word-break:break-word;">
                        <a href="/jobs/${slug}" class="text-body text-decoration-none stretched-link">
                          ${esc(job.job_title)}
                        </a>
                      </h3>
                      <p class="text-muted mb-0 text-truncate" style="font-size:10px;">
                        <i class="bi bi-building me-1"></i>${esc(job.company?.name ?? '—')}
                      </p>
                      <p class="text-muted mb-0 text-truncate" style="font-size:10px;">
                        <i class="bi bi-geo-alt me-1"></i>${esc(job.duty_station ?? 'Uganda')}
                        ${job.location_type === 'remote'
                          ? `<span class="badge bg-success bg-opacity-10 text-success" style="font-size:8px;">Remote</span>`
                          : ''}
                      </p>
                    </div>
                  </div>

                  {{-- Type / Level / Salary badges --}}
                  <div class="d-flex flex-wrap gap-1 mb-2" style="min-width:0;">
                    <span class="badge rounded-pill border text-body-secondary fw-normal text-truncate"
                          style="font-size:9px;background:#f8f9fa;max-width:100%;">
                      ${esc(job.job_type?.name || job.employment_type || 'Full Time')}
                    </span>
                    ${job.experience_level?.name
                      ? `<span class="badge rounded-pill border text-body-secondary fw-normal text-truncate"
                              style="font-size:9px;background:#f8f9fa;max-width:100%;">
                          ${esc(job.experience_level.name)}
                        </span>` : ''}
                    <span class="badge rounded-pill fw-semibold text-primary text-truncate"
                          style="font-size:9px;background:rgba(var(--bs-primary-rgb),.1);max-width:100%;">
                      ${esc(job.formatted_salary || 'Negotiable')}
                    </span>
                  </div>

                  {{-- Match + footer pushed to bottom --}}
                  <div class="mt-auto" style="min-width:0;">
                    ${scoreBar}
                    ${reason}
                    <div class="d-flex align-items-center justify-content-between border-top pt-2 gap-1"
                        style="min-width:0;">
                      <span class="text-muted text-truncate" style="font-size:9px;min-width:0;flex:1 1 0;">
                        <i class="bi bi-clock me-1"></i>${fmtDate(job.created_at)}
                        ${job.deadline
                          ? `<span class="text-danger d-none d-sm-inline"> · Closes ${esc(job.deadline)}</span>`
                          : ''}
                      </span>
                      <a href="/jobs/${slug}"
                        class="btn btn-primary btn-sm rounded-pill flex-shrink-0 position-relative"
                        style="font-size:10px;padding:3px 10px;z-index:2;white-space:nowrap;">
                        Apply <i class="bi bi-arrow-right-short"></i>
                      </a>
                    </div>
                  </div>

                </div>
              </div>
            </div>`;
        }).join('');

        // No-profile nudge
        if (!result.has_profile || result.mode === 'trending') {
            const nudge = document.createElement('div');
            nudge.className = 'col-12 mt-1';
            nudge.innerHTML = `
              <div class="alert alert-light border py-2 px-3 rounded-3 d-flex align-items-center
                          gap-2 mb-0 flex-wrap small">
                <i class="bi bi-info-circle text-primary flex-shrink-0"></i>
                <span class="text-muted flex-grow-1">
                  ${esc(result.message || 'Complete your CV for better matches.')}
                </span>
                <a href="#manual-cv"
                  onclick="document.getElementById('manual-cv-tab')?.click()"
                  class="btn btn-sm btn-primary rounded-pill px-3 flex-shrink-0"
                  style="z-index:2;position:relative;">
                  Update CV
                </a>
              </div>`;
            c.appendChild(nudge);
        }
    }

    // ── Render: no jobs found ─────────────────────────────────────────────
    function renderEmpty(result) {
        const c = document.getElementById('recommendedJobs');
        if (!c) return;

        if (!result.has_profile) {
            // No CV at all
            c.innerHTML = `
              <div class="col-12">
                <div class="text-center py-5">
                  <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">
                    <i class="bi bi-file-earmark-person fs-1 text-primary"></i>
                  </div>
                  <h6 class="fw-bold mb-1">No CV Found</h6>
                  <p class="text-muted small mb-4" style="max-width:360px;margin:0 auto;">
                    Upload your CV or fill in your profile so we can match you with the right jobs.
                  </p>
                  <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <button class="btn btn-primary rounded-pill px-4"
                            onclick="document.getElementById('manual-cv-tab')?.click();document.getElementById('manual-cv-tab')?.scrollIntoView({behavior:'smooth'});">
                      <i class="bi bi-pencil-square me-2"></i>Fill CV Manually
                    </button>
                    <button class="btn btn-outline-primary rounded-pill px-4"
                            onclick="document.getElementById('cvParseFileInput')?.click()">
                      <i class="bi bi-cloud-upload me-2"></i>Upload CV
                    </button>
                  </div>
                  <p class="text-muted mt-3 mb-0" style="font-size:11px;">
                    <i class="bi bi-shield-lock me-1"></i>Your data is secure and never shared without your consent.
                  </p>
                </div>
              </div>`;
        } else {
            // Has CV but no matches
            c.innerHTML = `
              <div class="col-12">
                <div class="text-center py-5">
                  <div class="rounded-circle bg-warning bg-opacity-10 p-4 d-inline-block mb-3">
                    <i class="bi bi-search fs-1 text-warning"></i>
                  </div>
                  <h6 class="fw-bold mb-1">No Matches Yet</h6>
                  <p class="text-muted small mb-4" style="max-width:360px;margin:0 auto;">
                    ${esc(result.message || "We couldn't find strong matches right now. Try updating your skills or browsing all jobs.")}
                  </p>
                  <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary rounded-pill px-4">
                      <i class="bi bi-briefcase me-2"></i>Browse All Jobs
                    </a>
                    <button class="btn btn-outline-primary rounded-pill px-4"
                            onclick="document.getElementById('manual-cv-tab')?.click()">
                      <i class="bi bi-pencil-square me-2"></i>Update CV
                    </button>
                  </div>
                </div>
              </div>`;
        }
    }

    // ── Render: not logged in ─────────────────────────────────────────────
    function renderNoAuth() {
        const c = document.getElementById('recommendedJobs');
        if (!c) return;
        c.innerHTML = `
          <div class="col-12 text-center py-5">
            <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">
              <i class="bi bi-box-arrow-in-right fs-1 text-primary"></i>
            </div>
            <h6 class="fw-bold mb-1">Login for Personalised Matches</h6>
            <p class="text-muted small mb-3">Create an account to get job recommendations tailored to your skills.</p>
            <a href="{{ route('login.register') }}" class="btn btn-primary rounded-pill px-5">
              <i class="bi bi-person-plus me-2"></i>Login / Register
            </a>
          </div>`;
        document.getElementById('recSubtitle').textContent = 'Login to see personalised matches';
    }

    // ── Render: error ─────────────────────────────────────────────────────
    function renderError() {
        const c = document.getElementById('recommendedJobs');
        if (!c) return;
        c.innerHTML = `
          <div class="col-12 text-center py-4">
            <i class="bi bi-wifi-off fs-2 text-muted opacity-50 d-block mb-2"></i>
            <p class="text-muted small mb-2">Couldn't load recommendations right now.</p>
            <button class="btn btn-sm btn-outline-primary rounded-pill px-4" onclick="loadRecommendedJobs()">
              <i class="bi bi-arrow-clockwise me-1"></i>Try Again
            </button>
          </div>`;
    }

    // ── Skeletons ─────────────────────────────────────────────────────────
    function showSkeletons() {
        const c = document.getElementById('recommendedJobs');
        if (!c) return;
        c.innerHTML = [0,1,2].map(() => `
          <div class="col-md-6 col-lg-4">
            <div class="card border rounded-3 h-100 shadow-sm">
              <div class="card-body p-3">
                <div class="d-flex gap-2 mb-3">
                  <div class="rounded-2 flex-shrink-0 placeholder-glow" style="width:44px;height:44px;">
                    <span class="placeholder w-100 h-100 rounded-2"></span>
                  </div>
                  <div class="flex-grow-1 placeholder-glow">
                    <span class="placeholder col-8 rounded mb-1 d-block"></span>
                    <span class="placeholder col-5 rounded d-block" style="height:10px;"></span>
                  </div>
                </div>
                <div class="d-flex gap-1 mb-3 placeholder-glow">
                  <span class="placeholder rounded-pill" style="width:60px;height:18px;"></span>
                  <span class="placeholder rounded-pill" style="width:50px;height:18px;"></span>
                </div>
                <div class="border-top pt-2 d-flex justify-content-between placeholder-glow">
                  <span class="placeholder rounded" style="width:60px;height:10px;"></span>
                  <span class="placeholder rounded-pill" style="width:52px;height:26px;"></span>
                </div>
              </div>
            </div>
          </div>`).join('');
    }

    // ── Update header after load ──────────────────────────────────────────
    function updateHeader(result) {
        const subtitle = document.getElementById('recSubtitle');
        const badge    = document.getElementById('recModeBadge');
        const refresh  = document.getElementById('recRefreshBtn');

        if (subtitle) {
            subtitle.textContent = result.mode === 'personalised'
                ? 'Matched to your skills and experience'
                : 'Popular jobs · Upload your CV for personal matches';
        }
        if (badge && result.mode === 'personalised') {
            badge.textContent = 'Smart Match';
            badge.style.removeProperty('display');
        }
        if (refresh) refresh.style.removeProperty('display');
    }

    // ── Utilities ─────────────────────────────────────────────────────────
    function esc(text) {
        if (!text) return '';
        const d = document.createElement('div');
        d.textContent = String(text);
        return d.innerHTML;
    }

    function fmtDate(dateStr) {
        if (!dateStr) return 'Recently';
        const d    = new Date(dateStr);
        const days = Math.floor((Date.now() - d) / 86400000);
        if (days === 0) return 'Today';
        if (days === 1) return 'Yesterday';
        if (days < 7)  return days + ' days ago';
        if (days < 30) return Math.floor(days / 7) + ' weeks ago';
        return Math.floor(days / 30) + ' months ago';
    }

    // Expose for external calls (e.g. after CV save)
    window.loadRecommendedJobs = loadRecommendedJobs;
})();
</script>









<style>
  #recommendedJobs .card          { min-width: 0; }
  #recommendedJobs .card-body     { min-width: 0; overflow: hidden; }
  #recommendedJobs .card-body *   { max-width: 100%; }

  /* Job title: 2-line clamp on all screens */
  #recommendedJobs h3 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      word-break: break-word;
      hyphens: auto;
  }

  /* Badges never overflow their container */
  #recommendedJobs .badge {
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
  }

  /* Mobile: single column, tighter padding */
  @media (max-width: 575px) {
      #recommendedJobs .card-body { padding: 0.65rem !important; }
      #recommendedJobs h3         { font-size: 0.78rem !important; }
  }
</style>