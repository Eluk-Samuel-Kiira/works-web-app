@extends('layouts.home')

@section('home-content')

<!-- HERO SECTION -->
<section class="hero-section">
  <div class="container position-relative" style="z-index:2;">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="hero-badge">
          <span class="dot"></span>
          AI-Powered Talent Matching · Uganda & Africa
        </div>
        <h1 class="hero-title">
          Hire the <span class="text-primary">Top 1%</span><br>of Talent,<br>AI Verified
        </h1>
        <p class="hero-subtitle">
          Stardena Works connects employers with skilled workers using AI. Find full-time jobs, quick gigs, or scan millions of CVs — all in one place.
        </p>

        <!-- Search Bar -->
        <div class="search-hero">
          <input type="text" class="form-control" placeholder="🔍  Job title, skill or keyword">
          <input type="text" class="form-control" placeholder="📍  Kampala, Uganda">
          <select class="form-control">
            <option>All Types</option>
            <option>Full-time</option>
            <option>Quick Gig</option>
            <option>Remote</option>
          </select>
          <button class="btn btn-primary">Search Jobs</button>
        </div>

        <!-- Popular Searches -->
        <div class="mb-4">
          <span style="font-size:12px;color:#8898aa;font-weight:600;margin-right:8px;">Popular:</span>
          <span class="tag-pill">Driver</span>
          <span class="tag-pill">Sales Rep</span>
          <span class="tag-pill green">Delivery</span>
          <span class="tag-pill orange">Software Dev</span>
          <span class="tag-pill red">Nurse</span>
          <span class="tag-pill">Accountant</span>
        </div>

        <!-- Social Proof -->
        <div class="d-flex align-items-center gap-3 flex-wrap">
          <div class="avatar-stack d-flex">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="user">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="user">
            <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="user">
            <img src="https://randomuser.me/api/portraits/women/17.jpg" alt="user">
          </div>
          <div>
            <div class="d-flex gap-1 mb-1">
              <i class="bi bi-star-fill text-warning" style="font-size:12px;"></i>
              <i class="bi bi-star-fill text-warning" style="font-size:12px;"></i>
              <i class="bi bi-star-fill text-warning" style="font-size:12px;"></i>
              <i class="bi bi-star-fill text-warning" style="font-size:12px;"></i>
              <i class="bi bi-star-half text-warning" style="font-size:12px;"></i>
            </div>
            <p class="mb-0" style="font-size:13px;color:#5a6a85;font-weight:500;">Trusted by <strong>10,000+</strong> workers & employers</p>
          </div>
        </div>
      </div>

      <!-- Hero Visual Panel -->
      <div class="col-lg-6 d-none d-lg-block">
        <div class="hero-visual" style="max-width:420px;margin-left:auto;">
          <span class="floating-badge">✨ AI Match Active</span>
          
          <!-- AI Match Score Card -->
          <div class="match-score-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div>
                <p style="font-size:12px;opacity:.8;margin:0 0 4px;">AI Match Score</p>
                <p style="font-size:16px;font-weight:700;margin:0;">Software Engineer · Kampala</p>
              </div>
              <div class="score-circle">92%</div>
            </div>
            <div style="background:rgba(255,255,255,.15);border-radius:8px;height:6px;margin-bottom:8px;">
              <div style="background:#fff;border-radius:8px;height:100%;width:92%;"></div>
            </div>
            <p style="font-size:12px;opacity:.75;margin:0;">3 skills verified · CV tailored · Instantly applied</p>
          </div>

          <!-- Mini Job Cards -->
          <div class="job-mini-card">
            <div class="company-logo" style="background:linear-gradient(135deg,#5D87FF,#4470f5);">M</div>
            <div class="flex-grow-1">
              <p style="font-size:13px;font-weight:700;margin:0;color:#2a3547;">MTN Uganda</p>
              <p style="font-size:12px;color:#8898aa;margin:0;">Sales Manager · UGX 2.5M/mo</p>
            </div>
            <span class="badge bg-primary-subtle text-primary" style="font-size:11px;">New</span>
          </div>

          <div class="job-mini-card">
            <div class="company-logo" style="background:linear-gradient(135deg,#FA896B,#f4614a);">A</div>
            <div class="flex-grow-1">
              <p style="font-size:13px;font-weight:700;margin:0;color:#2a3547;">Airtel Uganda</p>
              <p style="font-size:12px;color:#8898aa;margin:0;">Customer Support · Full-time</p>
            </div>
            <span class="badge" style="background:rgba(19,222,185,.1);color:#13DEB9;font-size:11px;">Match</span>
          </div>

          <div class="job-mini-card">
            <div class="company-logo" style="background:linear-gradient(135deg,#13DEB9,#06b599);">S</div>
            <div class="flex-grow-1">
              <p style="font-size:13px;font-weight:700;margin:0;color:#2a3547;">Stanbic Bank</p>
              <p style="font-size:12px;color:#8898aa;margin:0;">IT Officer · UGX 3.8M/mo</p>
            </div>
            <span class="badge bg-warning-subtle text-warning" style="font-size:11px;">Hot</span>
          </div>

          <!-- Quick action -->
          <div class="d-flex gap-2 mt-3">
            <button class="btn btn-primary flex-fill btn-sm"><i class="ti ti-robot me-2"></i>Tailor My CV</button>
            <button class="btn btn-outline-secondary flex-fill btn-sm"><i class="bi bi-whatsapp me-2" style="color:#25d366;"></i>Apply via WhatsApp</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Bar -->
<section class="stats-section">
  <div class="container">
    <div class="row justify-content-center text-center g-4">
      <div class="col-6 col-md-3">
        <div class="stat-item">
          <div class="stat-number">15K+</div>
          <div class="stat-label">Registered Workers</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item border-start">
          <div class="stat-number">2.4K+</div>
          <div class="stat-label">Companies Hiring</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item border-start">
          <div class="stat-number">8.7K+</div>
          <div class="stat-label">Jobs Filled</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-item border-start">
          <div class="stat-number">500+</div>
          <div class="stat-label">Quick Gigs Today</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Trusted by -->
<div class="logos-strip text-center">
  <div class="container">
    <p>Trusted by companies across Uganda</p>
    <div>
      <span class="partner-logo"><iconify-icon icon="logos:google" width="20"></iconify-icon> Google</span>
      <span class="partner-logo">🏦 Stanbic Bank</span>
      <span class="partner-logo">📱 MTN Uganda</span>
      <span class="partner-logo">✈️ Uganda Airlines</span>
      <span class="partner-logo">🏥 Nakasero Hospital</span>
      <span class="partner-logo">🛒 Jinja Supermart</span>
    </div>
  </div>
</div>

<!-- FEATURES SECTION -->
<section class="features-section" id="features">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-chip">What We Offer</span>
      <h2 class="section-title">Everything you need to<br>work or hire smarter</h2>
      <p class="section-sub">From quick gig alerts on WhatsApp to AI-ranked talent shortlists — Stardena Works handles the heavy lifting.</p>
    </div>
    <div class="row g-4">
      <!-- Feature 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrap bg-primary-subtle">
            <iconify-icon icon="material-symbols:work-outline-rounded" style="color:var(--bs-primary);font-size:28px;"></iconify-icon>
          </div>
          <h5>Job Listings & Direct Apply</h5>
          <p>Browse thousands of verified jobs. Apply directly through the platform — no email chains, no guessing. Get instant confirmation.</p>
        </div>
      </div>
      <!-- Feature 2 -->
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background:rgba(19,222,185,.12);">
            <iconify-icon icon="material-symbols:timer-outline" style="color:#13DEB9;font-size:28px;"></iconify-icon>
          </div>
          <h5>Quick Gigs — Earn Today</h5>
          <p>Delivery, cleaning, tutoring, coding tasks. Register as a casual worker and find hourly work near you. Get paid same day.</p>
        </div>
      </div>
      <!-- Feature 3 -->
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background:rgba(255,174,31,.12);">
            <iconify-icon icon="material-symbols:auto-awesome" style="color:#FFAE1F;font-size:28px;"></iconify-icon>
          </div>
          <h5>AI CV Tailoring</h5>
          <p>Upload your CV and our AI rewrites it to perfectly match any job description. Boost your interview chances by up to 3x.</p>
        </div>
      </div>
      <!-- Feature 4 -->
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background:rgba(250,137,107,.12);">
            <iconify-icon icon="material-symbols:person-search-outline" style="color:#FA896B;font-size:28px;"></iconify-icon>
          </div>
          <h5>AI Talent Scanner for Employers</h5>
          <p>Scan millions of CVs in under 5 minutes. Our AI ranks the best-fit candidates so you shortlist only the top 10%.</p>
        </div>
      </div>
      <!-- Feature 5 -->
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background:rgba(37,211,102,.12);">
            <iconify-icon icon="logos:whatsapp-icon" style="font-size:28px;"></iconify-icon>
          </div>
          <h5>Apply via WhatsApp</h5>
          <p>Data-friendly and accessible. Receive job alerts, apply, and track your applications entirely through WhatsApp — no app needed.</p>
        </div>
      </div>
      <!-- Feature 6 -->
      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="feature-icon-wrap" style="background:rgba(93,135,255,.12);">
            <iconify-icon icon="material-symbols:notifications-active-outline" style="color:var(--bs-primary);font-size:28px;"></iconify-icon>
          </div>
          <h5>Smart Job Alerts</h5>
          <p>Set your preferences once. Get personalized email and WhatsApp alerts the moment a matching job is posted.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section" id="gigs">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-chip">How It Works</span>
      <h2 class="section-title">Up and running in minutes</h2>
      <p class="section-sub">Three simple steps for workers, three for employers. No complicated processes.</p>
    </div>

    <div class="row g-5">
      <!-- For Workers -->
      <div class="col-lg-6">
        <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
          <span class="badge bg-primary rounded-pill">For Workers</span>
        </h5>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="step-card pt-5">
              <div class="step-number">1</div>
              <div class="step-icon" style="background:rgba(93,135,255,.1);">
                <iconify-icon icon="material-symbols:person-add-outline" style="color:var(--bs-primary);font-size:28px;"></iconify-icon>
              </div>
              <h5>Register Free</h5>
              <p>Create your profile and upload your CV in under 5 minutes.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="step-card pt-5">
              <div class="step-number">2</div>
              <div class="step-icon" style="background:rgba(255,174,31,.1);">
                <iconify-icon icon="material-symbols:auto-awesome" style="color:#FFAE1F;font-size:28px;"></iconify-icon>
              </div>
              <h5>AI Matches You</h5>
              <p>Our AI scans jobs daily and matches you to the best opportunities.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="step-card pt-5">
              <div class="step-number">3</div>
              <div class="step-icon" style="background:rgba(19,222,185,.1);">
                <iconify-icon icon="material-symbols:check-circle-outline" style="color:#13DEB9;font-size:28px;"></iconify-icon>
              </div>
              <h5>Apply & Get Hired</h5>
              <p>Apply in one click or directly via WhatsApp. Track every application.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- For Employers -->
      <div class="col-lg-6">
        <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
          <span class="badge bg-success rounded-pill">For Employers</span>
        </h5>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="step-card pt-5">
              <div class="step-number">1</div>
              <div class="step-icon" style="background:rgba(250,137,107,.1);">
                <iconify-icon icon="material-symbols:post-add-outline" style="color:#FA896B;font-size:28px;"></iconify-icon>
              </div>
              <h5>Post a Job</h5>
              <p>Describe the role. Our AI writes a compelling job ad for you.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="step-card pt-5">
              <div class="step-number">2</div>
              <div class="step-icon" style="background:rgba(93,135,255,.1);">
                <iconify-icon icon="material-symbols:manage-search" style="color:var(--bs-primary);font-size:28px;"></iconify-icon>
              </div>
              <h5>AI Pre-Screens</h5>
              <p>AI conducts initial screening. You only see the top verified candidates.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="step-card pt-5">
              <div class="step-number">3</div>
              <div class="step-icon" style="background:rgba(19,222,185,.1);">
                <iconify-icon icon="material-symbols:groups-outline-rounded" style="color:#13DEB9;font-size:28px;"></iconify-icon>
              </div>
              <h5>Hire in Days</h5>
              <p>Interview a shortlist of 5–10 qualified candidates. Hire faster.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AI SECTION -->
<section class="ai-section" id="talent">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6">
        <div class="ai-panel">
          <div class="ai-glow-badge">
            <iconify-icon icon="material-symbols:auto-awesome" style="font-size:14px;"></iconify-icon>
            Powered by AI
          </div>
          <h2>Stop reading 500 CVs.<br>Let AI do it in 5 mins.</h2>
          <p>Our AI Talent Scanner reads, ranks, and explains every candidate. You get a shortlist — not a pile of documents.</p>

          <ul class="ai-feature-list">
            <li>
              <div class="check-icon"><i class="ti ti-check" style="font-size:10px;"></i></div>
              <span>AI conducts voice/chat pre-screening with every applicant</span>
            </li>
            <li>
              <div class="check-icon"><i class="ti ti-check" style="font-size:10px;"></i></div>
              <span>Semantic matching — finds great talent even with non-standard CVs</span>
            </li>
            <li>
              <div class="check-icon"><i class="ti ti-check" style="font-size:10px;"></i></div>
              <span>Instant rejection with constructive feedback (no more ghosting)</span>
            </li>
            <li>
              <div class="check-icon"><i class="ti ti-check" style="font-size:10px;"></i></div>
              <span>Candidates ranked with an explainable AI match score</span>
            </li>
          </ul>

          <div class="d-flex gap-3 flex-wrap">
            <a href="/register?type=employer" class="btn btn-primary px-5 py-2">Post a Job Now</a>
            <a href="#" class="btn btn-outline-light px-4 py-2">Watch Demo</a>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="mb-3">
          <span class="section-chip">AI Match Dashboard</span>
          <h3 class="fw-bold mt-2 mb-1" style="font-size:22px;">Live Candidate Rankings</h3>
          <p class="text-muted" style="font-size:14px;">Top matches for: <strong>Marketing Manager · Kampala</strong></p>
        </div>

        <!-- Candidate cards -->
        <div class="d-flex flex-column gap-3">
          <div style="background:#fff;border-radius:14px;padding:16px 20px;border:1px solid #eef0f4;display:flex;align-items:center;gap:14px;">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" style="width:46px;height:46px;border-radius:50%;object-fit:cover;" alt="">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <p style="font-size:14px;font-weight:700;margin:0;color:#2a3547;">Sarah Achieng</p>
                <span class="badge" style="background:rgba(19,222,185,.12);color:#13DEB9;font-size:12px;font-weight:700;">96% Match</span>
              </div>
              <p style="font-size:12px;color:#8898aa;margin:0;">5 yrs experience · FMCG background · English fluent</p>
              <div style="background:#f6f9fc;border-radius:4px;height:4px;margin-top:8px;">
                <div style="background:#13DEB9;height:100%;border-radius:4px;width:96%;"></div>
              </div>
            </div>
          </div>
          <div style="background:#fff;border-radius:14px;padding:16px 20px;border:1px solid #eef0f4;display:flex;align-items:center;gap:14px;">
            <img src="https://randomuser.me/api/portraits/men/45.jpg" style="width:46px;height:46px;border-radius:50%;object-fit:cover;" alt="">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <p style="font-size:14px;font-weight:700;margin:0;color:#2a3547;">David Ochieng</p>
                <span class="badge bg-primary-subtle text-primary" style="font-size:12px;font-weight:700;">88% Match</span>
              </div>
              <p style="font-size:12px;color:#8898aa;margin:0;">4 yrs experience · Telecom sector · Pre-screened ✓</p>
              <div style="background:#f6f9fc;border-radius:4px;height:4px;margin-top:8px;">
                <div style="background:var(--bs-primary);height:100%;border-radius:4px;width:88%;"></div>
              </div>
            </div>
          </div>
          <div style="background:#fff;border-radius:14px;padding:16px 20px;border:1px solid #eef0f4;display:flex;align-items:center;gap:14px;">
            <img src="https://randomuser.me/api/portraits/women/22.jpg" style="width:46px;height:46px;border-radius:50%;object-fit:cover;" alt="">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <p style="font-size:14px;font-weight:700;margin:0;color:#2a3547;">Fatuma Nakato</p>
                <span class="badge" style="background:rgba(255,174,31,.12);color:#FFAE1F;font-size:12px;font-weight:700;">82% Match</span>
              </div>
              <p style="font-size:12px;color:#8898aa;margin:0;">3 yrs experience · NGO marketing · Interview ready</p>
              <div style="background:#f6f9fc;border-radius:4px;height:4px;margin-top:8px;">
                <div style="background:#FFAE1F;height:100%;border-radius:4px;width:82%;"></div>
              </div>
            </div>
          </div>
        </div>

        <div style="background:var(--bs-primary-subtle);border-radius:12px;padding:14px 18px;margin-top:16px;display:flex;align-items:center;gap:12px;">
          <iconify-icon icon="material-symbols:info-outline" style="color:var(--bs-primary);font-size:20px;flex-shrink:0;"></iconify-icon>
          <p style="font-size:13px;color:#2a3547;margin:0;">AI scanned <strong>347 CVs</strong> and shortlisted <strong>3 top candidates</strong> in <strong>4 minutes 12 seconds</strong>.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING SECTION -->
<section class="pricing-section" id="pricing">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-chip">Pricing</span>
      <h2 class="section-title">Fair pricing for every business</h2>
      <p class="section-sub">Start free. Only pay when you find value. Built for Ugandan SMEs and large enterprises alike.</p>
      
      <!-- Pricing toggle -->
      <div class="d-inline-flex align-items-center gap-3 bg-white rounded-pill px-4 py-2 border mt-3">
        <span style="font-size:13px;font-weight:600;color:#5a6a85;">For Workers</span>
        <div class="form-check form-switch mb-0">
          <input class="form-check-input" type="checkbox" id="pricingToggle">
        </div>
        <span style="font-size:13px;font-weight:600;color:#2a3547;">For Employers</span>
      </div>
    </div>

    <!-- Worker Pricing -->
    <div id="workerPricing">
      <div class="row g-4 justify-content-center">
        <div class="col-xl-3 col-md-6">
          <div class="plan-card">
            <h4 style="font-size:18px;font-weight:800;color:#2a3547;margin-bottom:6px;">Free Seeker</h4>
            <p style="font-size:13px;color:#8898aa;margin-bottom:20px;">Browse jobs, apply directly, get email alerts.</p>
            <div class="plan-price">UGX 0 <span>/ forever</span></div>
            <ul class="plan-features">
              <li><i class="ti ti-circle-check"></i> Browse all job listings</li>
              <li><i class="ti ti-circle-check"></i> Direct application on site</li>
              <li><i class="ti ti-circle-check"></i> WhatsApp job alerts</li>
              <li><i class="ti ti-circle-check"></i> Basic CV profile</li>
              <li class="muted"><i class="ti ti-circle-x"></i> AI CV Tailoring</li>
              <li class="muted"><i class="ti ti-circle-x"></i> Priority listing</li>
            </ul>
            <a href="/register" class="btn btn-outline-dark w-100 mt-auto">Get Started Free</a>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="plan-card featured">
            <h4 style="font-size:18px;font-weight:800;color:#2a3547;margin-bottom:6px;">Pro Worker <span class="plan-badge">Popular</span></h4>
            <p style="font-size:13px;color:#8898aa;margin-bottom:20px;">Get hired faster with AI-powered tools.</p>
            <div class="plan-price">UGX 15K <span>/ month</span></div>
            <ul class="plan-features">
              <li><i class="ti ti-circle-check"></i> Everything in Free</li>
              <li><i class="ti ti-circle-check"></i> AI CV Tailoring (10/mo)</li>
              <li><i class="ti ti-circle-check"></i> Mock AI Interview practice</li>
              <li><i class="ti ti-circle-check"></i> Priority profile listing</li>
              <li><i class="ti ti-circle-check"></i> WhatsApp apply + tracking</li>
              <li><i class="ti ti-circle-check"></i> Skills verification badge</li>
            </ul>
            <a href="/register" class="btn btn-primary w-100 mt-auto">Start Pro — Free 14 Days</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Employer Pricing (hidden by default) -->
    <div id="employerPricing" style="display:none;">
      <div class="row g-4">
        <div class="col-xl-3 col-md-6">
          <div class="plan-card">
            <h4 style="font-size:18px;font-weight:800;margin-bottom:6px;">Pay Per Match</h4>
            <p style="font-size:13px;color:#8898aa;margin-bottom:20px;">Only pay when you find a candidate you like.</p>
            <div class="plan-price">UGX 0 <span>to post</span></div>
            <ul class="plan-features">
              <li><i class="ti ti-circle-check"></i> Post unlimited jobs free</li>
              <li><i class="ti ti-circle-check"></i> Pay UGX 20K per unlock</li>
              <li><i class="ti ti-circle-check"></i> Basic AI ranking</li>
              <li><i class="ti ti-circle-check"></i> Email notifications</li>
              <li class="muted"><i class="ti ti-circle-x"></i> AI pre-screening</li>
              <li class="muted"><i class="ti ti-circle-x"></i> Priority listing</li>
            </ul>
            <a href="/register?type=employer" class="btn btn-outline-dark w-100 mt-auto">Post Free</a>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="plan-card">
            <h4 style="font-size:18px;font-weight:800;margin-bottom:6px;">SME Plan</h4>
            <p style="font-size:13px;color:#8898aa;margin-bottom:20px;">Perfect for growing Ugandan businesses.</p>
            <div class="plan-price">UGX 150K <span>/ month</span></div>
            <ul class="plan-features">
              <li><i class="ti ti-circle-check"></i> 5 active job posts</li>
              <li><i class="ti ti-circle-check"></i> AI CV scanning (100/mo)</li>
              <li><i class="ti ti-circle-check"></i> Shortlist of top 10 candidates</li>
              <li><i class="ti ti-circle-check"></i> Email + WhatsApp alerts</li>
              <li class="muted"><i class="ti ti-circle-x"></i> AI pre-screening calls</li>
              <li class="muted"><i class="ti ti-circle-x"></i> Dedicated account manager</li>
            </ul>
            <a href="/register?type=employer" class="btn btn-outline-dark w-100 mt-auto">Get SME Plan</a>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="plan-card featured">
            <h4 style="font-size:18px;font-weight:800;margin-bottom:6px;">Growth <span class="plan-badge">Popular</span></h4>
            <p style="font-size:13px;color:#8898aa;margin-bottom:20px;">AI-powered hiring at scale.</p>
            <div class="plan-price">UGX 450K <span>/ month</span></div>
            <ul class="plan-features">
              <li><i class="ti ti-circle-check"></i> 20 active job posts</li>
              <li><i class="ti ti-circle-check"></i> Unlimited AI CV scanning</li>
              <li><i class="ti ti-circle-check"></i> AI voice pre-screening</li>
              <li><i class="ti ti-circle-check"></i> Priority featured listings</li>
              <li><i class="ti ti-circle-check"></i> Branded employer page</li>
              <li><i class="ti ti-circle-check"></i> Analytics dashboard</li>
            </ul>
            <a href="/register?type=employer" class="btn btn-primary w-100 mt-auto">Start Growth Plan</a>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="plan-card">
            <h4 style="font-size:18px;font-weight:800;margin-bottom:6px;">Enterprise</h4>
            <p style="font-size:13px;color:#8898aa;margin-bottom:20px;">Custom solutions for large organizations.</p>
            <div class="plan-price" style="font-size:28px;">Custom</div>
            <ul class="plan-features">
              <li><i class="ti ti-circle-check"></i> Everything in Growth</li>
              <li><i class="ti ti-circle-check"></i> Dedicated account manager</li>
              <li><i class="ti ti-circle-check"></i> ATS/HRMS integration</li>
              <li><i class="ti ti-circle-check"></i> Mobile Money billing</li>
              <li><i class="ti ti-circle-check"></i> Custom AI model training</li>
              <li><i class="ti ti-circle-check"></i> SLA & priority support</li>
            </ul>
            <a href="/contact" class="btn btn-outline-dark w-100 mt-auto">Contact Sales</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment methods -->
    <div class="text-center mt-5">
      <p style="font-size:13px;color:#8898aa;margin-bottom:16px;">🔒 Secure payment via MTN Mobile Money · Airtel Money · Visa · Mastercard</p>
      <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
        <span class="partner-logo">📱 MTN MoMo</span>
        <span class="partner-logo">📱 Airtel Money</span>
        <span class="partner-logo">💳 Visa</span>
        <span class="partner-logo">💳 Mastercard</span>
        <span class="partner-logo">💰 PayPal</span>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials-section">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-chip">Testimonials</span>
      <h2 class="section-title">Real stories from real people</h2>
    </div>
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="testimonial-card">
          <div class="quote-mark"><i class="bi bi-quote"></i></div>
          <div class="stars">★★★★★</div>
          <p>"The AI tailored my CV and I got an interview within 3 days. Something I had been trying for 6 months on my own. Game changer!"</p>
          <div class="d-flex align-items-center gap-3">
            <img src="https://randomuser.me/api/portraits/women/55.jpg" style="width:44px;height:44px;border-radius:50%;object-fit:cover;" alt="">
            <div>
              <p class="reviewer-name">Grace Namukasa</p>
              <p class="reviewer-title">Software Developer, Kampala</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="testimonial-card">
          <div class="quote-mark"><i class="bi bi-quote"></i></div>
          <div class="stars">★★★★★</div>
          <p>"We posted a role and the AI shortlisted 8 amazing candidates out of 300+ applications. We hired in 10 days. Incredible efficiency."</p>
          <div class="d-flex align-items-center gap-3">
            <img src="https://randomuser.me/api/portraits/men/78.jpg" style="width:44px;height:44px;border-radius:50%;object-fit:cover;" alt="">
            <div>
              <p class="reviewer-name">James Mutumba</p>
              <p class="reviewer-title">HR Manager, Kampala SME</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="testimonial-card">
          <div class="quote-mark"><i class="bi bi-quote"></i></div>
          <div class="stars">★★★★☆</div>
          <p>"I got a delivery gig through WhatsApp in 20 minutes. Stardena Works is perfect for people like me who need income fast."</p>
          <div class="d-flex align-items-center gap-3">
            <img src="https://randomuser.me/api/portraits/men/23.jpg" style="width:44px;height:44px;border-radius:50%;object-fit:cover;" alt="">
            <div>
              <p class="reviewer-name">Paul Ssekindi</p>
              <p class="reviewer-title">Casual Worker, Mukono</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
  <div class="container position-relative" style="z-index:2;">
    <div class="text-center mb-5">
      <h2>Start your journey today</h2>
      <p>Join thousands of workers and employers on Stardena Works — the smart way to hire and be hired in Uganda.</p>
    </div>
    <div class="cta-cards-row">
      <a href="/register?type=worker" class="cta-mini-card text-decoration-none">
        <div class="icon">👷</div>
        <h5>I'm a Worker</h5>
        <p>Find jobs, quick gigs, and let AI boost your CV</p>
      </a>
      <a href="/register?type=employer" class="cta-mini-card text-decoration-none">
        <div class="icon">🏢</div>
        <h5>I'm an Employer</h5>
        <p>Post jobs and find top talent with AI</p>
      </a>
      <a href="#" class="cta-mini-card text-decoration-none">
        <div class="icon" style="color:#25d366;">
          <i class="bi bi-whatsapp"></i>
        </div>
        <h5>Apply on WhatsApp</h5>
        <p>Find gigs and jobs without leaving WhatsApp</p>
      </a>
    </div>
  </div>
</section>

@endsection
