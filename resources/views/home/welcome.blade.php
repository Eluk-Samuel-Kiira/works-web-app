@extends('layouts.jobs')
@section('title', 'Stardena Works - AI-Powered Job Platform')
@section('meta_description', 'Find jobs in Africa, get AI-powered CV enhancement, and connect with top employers on Stardena Works.')

@section('job-content')

{{-- ═══════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════ --}}
<section class="bg-primary py-5 py-lg-7" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
  <div class="container-xl px-3 px-md-4">
    <div class="row align-items-center g-4 g-lg-5">
      
      {{-- Left Column --}}
      <div class="col-lg-6 text-center text-lg-start">
        <div class="d-inline-flex align-items-center gap-2 rounded-pill px-3 py-1 mb-4" 
            style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.3);">
          <span class="badge bg-warning text-dark px-2 py-1 rounded-pill" style="font-size: 10px;">AI-Powered</span>
          <span class="text-white small">Uganda &amp; Africa</span>
        </div>

        <h1 class="display-4 fw-bold text-white mb-3" style="font-size: clamp(1.75rem, 5vw, 2.5rem);">
          Hire the <span style="color: #fcd34d;">Top 1%</span><br>of Talent, AI Verified
        </h1>

        <p class="text-white-50 mb-4" style="font-size: 1rem; line-height: 1.6;">
          Stardena Works connects employers with skilled workers using AI. Find full-time jobs, quick gigs, or scan millions of CVs — all in one place.
        </p>

        {{-- Search Bar --}}
        <form action="{{ route('jobs.search') }}" method="GET" class="bg-white rounded-3 shadow-sm p-2 d-flex flex-column flex-sm-row gap-2 align-items-stretch mb-4">
          <div class="d-flex align-items-center flex-grow-1 px-2">
            <i class="bi bi-search text-muted me-2"></i>
            <input type="text" name="keyword" class="form-control border-0 p-0 shadow-none" placeholder="Job title, skill or keyword">
          </div>
          <div class="d-flex align-items-center flex-grow-1 px-2 border-top border-sm-top-0 border-sm-start pt-2 pt-sm-0">
            <i class="bi bi-geo-alt text-muted me-2"></i>
            <input type="text" name="location" class="form-control border-0 p-0 shadow-none" placeholder="Kampala, Uganda">
          </div>
          <button type="submit" class="btn btn-warning fw-semibold px-4 hover-scale-btn" style="background: #f59e0b; border: none; color: #1e3a8a;">
            Search Jobs
          </button>
        </form>

        {{-- Popular Tags --}}
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
          <span class="text-white-50 small">Popular:</span>
          @foreach(['Driver', 'Sales Rep', 'Delivery', 'Software Dev', 'Nurse', 'Teacher'] as $tag)
            <a href="{{ route('jobs.index', ['keyword' => $tag]) }}" 
              class="badge bg-white text-primary text-decoration-none rounded-pill px-3 py-1 hover-yellow-accent" 
              style="font-size: 11px; background: rgba(255,255,255,0.95) !important; color: #1e3a8a !important; font-weight: 500;">
              {{ $tag }}
            </a>
          @endforeach
        </div>

        {{-- Social Proof --}}
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex">
            @foreach(['men/48', 'women/73', 'men/55', 'men/83'] as $p)
              <img src="https://randomuser.me/api/portraits/{{ $p }}.jpg" class="rounded-circle border border-2 border-white" width="36" height="36" style="margin-right: -8px; object-fit: cover;">
            @endforeach
          </div>
          <div>
            <div class="text-warning mb-1" style="font-size: 11px;">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
            </div>
            <small class="text-white-50">Trusted by <strong class="text-white">10,000+</strong> workers &amp; employers</small>
          </div>
        </div>
      </div>

{{-- Right Column - AI Match Panel --}}
      <div class="col-lg-6 d-none d-lg-block">
        <div class="card border-0 shadow-lg rounded-4" style="background: #f8faff;">
          <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                <i class="bi bi-robot me-1"></i> AI MATCH DASHBOARD
              </span>
              <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                <span class="badge bg-success rounded-circle me-1" style="width: 6px; height: 6px; padding: 0;"></span> Live
              </span>
            </div>

            {{-- Score Card --}}
            <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-3" style="border-left: 4px solid #2563eb;">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <div class="small text-muted mb-1">AI Match Score</div>
                  <div class="fw-bold text-primary">Software Engineer · Kampala</div>
                  <div class="small text-muted mt-1">3 skills verified · CV tailored</div>
                </div>
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width: 55px; height: 55px; font-size: 18px;">92%</div>
              </div>
            </div>

            {{-- Job Rows --}}
            @foreach([
              ['M', 'MTN Uganda', 'Sales Manager · UGX 2.5M/mo', 'New', '#e8f0fe', '#2563eb'],
              ['A', 'Airtel Uganda', 'Customer Support · Full-time', 'Match', '#e6f4ea', '#16a34a'],
              ['S', 'Stanbic Bank', 'IT Officer · UGX 3.8M/mo', 'Hot', '#fff3e0', '#f59e0b'],
            ] as [$letter, $name, $sub, $badge, $bgBadge, $colorBadge])
            <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background: #f0f4f9;">
              <div class="d-flex align-items-center justify-content-center fw-bold text-white rounded-3 flex-shrink-0" style="width: 40px; height: 40px; background: #2563eb; font-size: 16px;">{{ $letter }}</div>
              <div class="flex-grow-1">
                <div class="fw-semibold" style="font-size: 14px;">{{ $name }}</div>
                <div class="small text-muted">{{ $sub }}</div>
              </div>
              <span class="badge rounded-pill px-3 py-1" style="background: {{ $bgBadge }}; color: {{ $colorBadge }}; font-size: 10px;">{{ $badge }}</span>
            </div>
            @endforeach

            <div class="d-flex gap-2 mt-3">
              <a href="{{ route('home.cv-charge') }}" class="btn btn-primary rounded-pill flex-grow-1" style="background: linear-gradient(135deg, #2563eb, #1e3a8a); border: none;">
                <i class="bi bi-magic me-1"></i> Tailor My CV
              </a>
              <button onclick="signupToBegin()" class="btn btn-outline-success rounded-pill flex-grow-1">
                <i class="bi bi-whatsapp me-1"></i> Apply via WhatsApp
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     STATS SECTION
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6 stats-section" style="background: #ffffff;">
  <div class="container-xl px-3 px-md-4">
    <div class="row g-3 text-center">
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 stat-card-hover" style="border-top: 3px solid #f59e0b;">
          <div class="stat-num display-6 fw-bold text-primary mb-1">15K+</div>
          <div class="small text-muted">Registered Workers</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 stat-card-hover" style="border-top: 3px solid #f59e0b;">
          <div class="stat-num display-6 fw-bold text-primary mb-1">2.4K+</div>
          <div class="small text-muted">Companies Hiring</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 stat-card-hover" style="border-top: 3px solid #f59e0b;">
          <div class="stat-num display-6 fw-bold text-primary mb-1">8.7K+</div>
          <div class="small text-muted">Jobs Filled</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 stat-card-hover" style="border-top: 3px solid #f59e0b;">
          <div class="stat-num display-6 fw-bold text-primary mb-1">500+</div>
          <div class="small text-muted">Quick Gigs Today</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     TRUSTED BY SECTION - Compact
═══════════════════════════════════════════════════════ --}}
<div class="py-4" style="background: linear-gradient(135deg, #ffffff 0%, #fffbeb 50%, #ffffff 100%); border-bottom: 1px solid rgba(245, 158, 11, 0.1);">
  <div class="container-xl px-3 px-md-4">
    <p class="small text-uppercase text-muted text-center mb-3" style="letter-spacing: 0.1em; font-size: 10px;">Trusted by companies across Africa</p>
    <div class="d-flex flex-wrap justify-content-center gap-2 px-2">
      @foreach([
        ['🏢', 'Stanbic Bank'],
        ['📱', 'MTN Uganda'],
        ['✈️', 'Uganda Airlines'],
        ['🏥', 'Nakasero Hospital'],
        ['🛒', 'Jumia Uganda'],
        ['🏦', 'Centenary Bank'],
        ['⚡', 'Umeme'],
        ['🏛️', 'NSSF Uganda']
      ] as [$icon, $company])
        <a href="javascript:void(0)" onclick="signupToBegin()" 
           class="d-inline-flex align-items-center gap-2 bg-white border rounded-pill px-3 py-2 text-decoration-none company-badge-hover"
           style="transition: all 0.2s ease; border-color: rgba(245, 158, 11, 0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
          <span style="font-size: 14px;">{{ $icon }}</span>
          <span class="fw-normal text-dark" style="font-size: 12px;">{{ $company }}</span>
        </a>
      @endforeach
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     FEATURES SECTION (Icons + Title on same line)
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6" style="background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 50%, #fef3c7 100%); position: relative;">
  <div style="position: absolute; top: 0; right: 0; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.4); border-radius: 50%; z-index: 0;"></div>
  <div style="position: absolute; bottom: 0; left: 0; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.3); border-radius: 50%; z-index: 0;"></div>
  <div class="container-xl px-3 px-md-4" style="position: relative; z-index: 1;">
    <div class="text-center mb-5">
      <span class="badge rounded-pill px-3 py-2 mb-2" style="background: rgba(255,255,255,0.7); color: #92400e; font-weight: 600; border: 1px solid rgba(255,255,255,0.5);">✨ What We Offer</span>
      <h2 class="h2 fw-bold mb-2" style="color: #1e3a8a;">Everything you need to<br>work or hire smarter</h2>
      <p style="color: #78350f; font-weight: 500;">From quick gig alerts on WhatsApp to AI-ranked talent shortlists</p>
    </div>
    
    <div class="row g-3">
      @foreach([
        ['briefcase', 'Job Listings & Direct Apply', 'Browse thousands of verified jobs. Apply directly — no email chains.', 'primary'],
        ['clock', 'Quick Gigs — Earn Today', 'Delivery, cleaning, tutoring, coding. Find hourly work near you.', 'warning'],
        ['magic', 'AI CV Tailoring', 'Upload your CV and our AI rewrites it to match any job description.', 'success'],
        ['robot', 'AI Talent Scanner', 'Scan millions of CVs in minutes. AI ranks the best-fit candidates.', 'info'],
        ['whatsapp', 'Apply via WhatsApp', 'Receive alerts, apply, and track applications through WhatsApp.', 'success'],
        ['bell', 'Smart Job Alerts', 'Set preferences once. Get personalized alerts when matching jobs post.', 'danger'],
      ] as [$icon, $title, $desc, $color])
      <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-lg rounded-3 h-100 feature-card-hover" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.6);">
          <div class="card-body p-3 p-md-4">
            {{-- Icon + Title on same line --}}
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="rounded-2 bg-light-{{ $color }} d-inline-flex p-2 flex-shrink-0 feature-icon-hover">
                <i class="bi bi-{{ $icon }} fs-5 text-{{ $color }}"></i>
              </div>
              <h6 class="fw-bold mb-0" style="line-height: 1.3; color: #1e3a8a;">{{ $title }}</h6>
            </div>
            {{-- Description below --}}
            <p class="text-muted small mb-0 ms-0 mt-2">{{ $desc }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section id="" class="py-5 py-lg-6" style="background: #ffffff;">
  <div class="container-xl px-3 px-md-4">
    {{-- Campaign Banner --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden campaign-banner-hover" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); position: relative; overflow: hidden;">
      <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(245, 158, 11, 0.08); border-radius: 50%; z-index: 0;"></div>
      <div class="card-body p-4 p-lg-5 text-center text-white" style="position: relative; z-index: 1;">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div class="text-start">
            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-2" style="font-weight: 600;">🚀 SPECIAL LAUNCH OFFER</span>
            <h3 class="fw-bold mb-2 text-white">Get 50% off your first 3 months</h3>
            <p class="mb-0 text-white-50">Use code: <strong class="bg-dark bg-opacity-30 px-2 py-1 rounded text-white" style="font-family: monospace;">STARDENA50</strong> at checkout</p>
          </div>
          <button onclick="signupToBegin()" class="btn btn-warning fw-semibold rounded-pill px-5 py-3 shadow-lg hover-scale-btn" style="color: #1e3a8a; white-space: nowrap;">
            Sign Up Now <i class="bi bi-arrow-right ms-2"></i>
          </button>
        </div>
        <div class="row mt-4 pt-3 g-3 text-center">
          <div class="col-6 col-md-3">
            <div class="bg-dark bg-opacity-30 rounded-3 p-3">
              <i class="bi bi-file-text fs-3 text-white"></i>
              <div class="small fw-semibold text-white mt-1">CV Templates</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bg-dark bg-opacity-30 rounded-3 p-3">
              <i class="bi bi-graph-up fs-3 text-white"></i>
              <div class="small fw-semibold text-white mt-1">ATS Score</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bg-dark bg-opacity-30 rounded-3 p-3">
              <i class="bi bi-envelope-paper fs-3 text-white"></i>
              <div class="small fw-semibold text-white mt-1">Cover Letters</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bg-dark bg-opacity-30 rounded-3 p-3">
              <i class="bi bi-person-check fs-3 text-white"></i>
              <div class="small fw-semibold text-white mt-1">Interview Prep</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6" style="background: linear-gradient(135deg, #f0f4f9 0%, #fffbeb 50%, #f0f4f9 100%); border-top: 1px solid rgba(245, 158, 11, 0.1);">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5">
      <span class="badge bg-warning bg-opacity-15 text-warning rounded-pill px-3 py-2 mb-2" style="border: 1px solid rgba(245, 158, 11, 0.3);">How It Works</span>
      <h2 class="h2 fw-bold mb-2">Up and running in minutes</h2>
      <p class="text-muted">Simple steps for workers and employers.</p>
    </div>
    <div class="row g-4">
      
      {{-- For Workers Card --}}
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 process-card-hover">
          <div class="card-body p-4">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-4">For Workers</span>
            
            {{-- Step 1 --}}
            <div class="d-flex gap-3 mb-4">
              <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0 step-circle" style="width: 48px; height: 48px;">
                <span class="fw-bold text-primary">1</span>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi bi-person-plus text-primary fs-5"></i>
                  <span class="fw-semibold">Register Free</span>
                </div>
                <p class="text-muted small mb-0">Create your profile in minutes</p>
              </div>
            </div>
            
            {{-- Step 2 --}}
            <div class="d-flex gap-3 mb-4">
              <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0 step-circle" style="width: 48px; height: 48px;">
                <span class="fw-bold text-primary">2</span>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi bi-stars text-primary fs-5"></i>
                  <span class="fw-semibold">AI Matches You</span>
                </div>
                <p class="text-muted small mb-0">Get matched to the best opportunities</p>
              </div>
            </div>
            
            {{-- Step 3 --}}
            <div class="d-flex gap-3">
              <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0 step-circle" style="width: 48px; height: 48px;">
                <span class="fw-bold text-primary">3</span>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi bi-check-circle text-primary fs-5"></i>
                  <span class="fw-semibold">Apply &amp; Get Hired</span>
                </div>
                <p class="text-muted small mb-0">One-click apply via WhatsApp</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      {{-- For Employers Card --}}
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100 process-card-hover">
          <div class="card-body p-4">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-4">For Employers</span>
            
            {{-- Step 1 --}}
            <div class="d-flex gap-3 mb-4">
              <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0 step-circle" style="width: 48px; height: 48px;">
                <span class="fw-bold text-success">1</span>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi bi-pencil-square text-success fs-5"></i>
                  <span class="fw-semibold">Post a Job</span>
                </div>
                <p class="text-muted small mb-0">Describe the role — AI writes the ad</p>
              </div>
            </div>
            
            {{-- Step 2 --}}
            <div class="d-flex gap-3 mb-4">
              <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0 step-circle" style="width: 48px; height: 48px;">
                <span class="fw-bold text-success">2</span>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi bi-search text-success fs-5"></i>
                  <span class="fw-semibold">AI Pre-Screens</span>
                </div>
                <p class="text-muted small mb-0">See only top verified candidates</p>
              </div>
            </div>
            
            {{-- Step 3 --}}
            <div class="d-flex gap-3">
              <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0 step-circle" style="width: 48px; height: 48px;">
                <span class="fw-bold text-success">3</span>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <i class="bi bi-people text-success fs-5"></i>
                  <span class="fw-semibold">Hire in Days</span>
                </div>
                <p class="text-muted small mb-0">Interview a shortlist of top candidates</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6 bg-primary" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); position: relative; overflow: hidden;">
  <div style="position: absolute; bottom: -50px; left: -50px; width: 300px; height: 300px; background: rgba(245, 158, 11, 0.1); border-radius: 50%; z-index: 0;"></div>
  <div class="container-xl px-3 px-md-4 text-center" style="position: relative; z-index: 1;">
    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-3" style="font-weight: 600;">Start your journey today</span>
    <!-- <h2 class="h2 fw-bold text-white mb-3">Start your journey today</h2> -->
    <p class="text-white-50 mb-4" style="max-width: 480px; margin: 0 auto;">Join thousands of workers and employers on Stardena Works — the smart way to hire and be hired.</p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <button onclick="signupToBegin()" class="btn btn-light fw-semibold rounded-pill px-5 py-3 hover-scale-btn">
        <i class="bi bi-person me-2"></i>I'm a Worker
      </button>
      <button onclick="signupToBegin()" class="btn btn-outline-light fw-semibold rounded-pill px-5 py-3 hover-scale-btn">
        <i class="bi bi-building me-2"></i>I'm an Employer
      </button>
      <button onclick="openSocialModal()" class="btn btn-success fw-semibold rounded-pill px-5 py-3 hover-scale-btn">
        <i class="bi bi-whatsapp me-2"></i>Apply on WhatsApp
      </button>
    </div>
  </div>
</section>

<style>
/* ─── Professional Yellow Accent Styling ─────────────────────────────── */

/* Scroll to top button */
.scroll-top {
  position: fixed; 
  bottom: 28px; 
  left: 28px; 
  z-index: 9999;
  width: 40px; 
  height: 40px; 
  border-radius: 10px;
  background: #f59e0b; 
  color: #fff; 
  font-size: 18px;
  display: none; 
  align-items: center; 
  justify-content: center;
  box-shadow: 0 4px 16px rgba(245, 158, 11, 0.4); 
  cursor: pointer;
  border: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.scroll-top.show { 
  display: flex; 
}
.scroll-top:hover {
  background: #e5910a;
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(245, 158, 11, 0.5);
}
.scroll-top:active {
  transform: translateY(-2px);
}

/* Hover effects for buttons */
.hover-scale-btn {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.hover-scale-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* AI Match Card Styling */
.ai-match-card {
  border: 1px solid rgba(245, 158, 11, 0.15);
  transition: all 0.3s ease;
}
.ai-match-card:hover {
  border-color: rgba(245, 158, 11, 0.4);
  box-shadow: 0 20px 40px rgba(245, 158, 11, 0.1);
}

/* Job Row Hover */
.job-row-hover {
  transition: all 0.2s ease;
  cursor: pointer;
}
.job-row-hover:hover {
  background: #e8eef7 !important;
  transform: translateX(4px);
}

/* Stat Card Hover */
.stat-card-hover {
  transition: all 0.3s ease;
  border: 1px solid transparent;
}
.stat-card-hover:hover {
  border-color: #f59e0b;
  box-shadow: 0 12px 30px rgba(245, 158, 11, 0.12);
  transform: translateY(-4px);
}

/* Feature Card Hover */
.feature-card-hover {
  transition: all 0.3s ease;
  border: 1px solid transparent;
}
.feature-card-hover:hover {
  border-color: #f59e0b;
  box-shadow: 0 15px 35px rgba(245, 158, 11, 0.15);
  transform: translateY(-6px);
}

/* Feature Icon Animation */
.feature-icon-hover {
  transition: all 0.3s ease;
}
.feature-card-hover:hover .feature-icon-hover {
  transform: scale(1.1) rotateY(10deg);
}

/* Company Badge Hover */
.company-badge-hover {
  transition: all 0.2s ease;
  border: 1px solid #e5e7eb !important;
}
.company-badge-hover:hover {
  background: #fffbeb !important;
  border-color: #f59e0b !important;
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.12);
}

/* Process Card Hover */
.process-card-hover {
  transition: all 0.3s ease;
  border: 1px solid transparent;
}
.process-card-hover:hover {
  border-color: #f59e0b;
  box-shadow: 0 15px 35px rgba(245, 158, 11, 0.12);
  transform: translateY(-4px);
}

/* Step Circle Animation */
.step-circle {
  transition: all 0.3s ease;
}
.process-card-hover:hover .step-circle {
  transform: scale(1.05);
}

/* Campaign Banner Hover */
.campaign-banner-hover {
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.1);
}
.campaign-banner-hover:hover {
  box-shadow: 0 25px 50px rgba(245, 158, 11, 0.15);
  border-color: rgba(255, 255, 255, 0.2);
}

/* Yellow accent on popular tags hover */
.hover-yellow-accent {
  transition: all 0.2s ease;
}
.hover-yellow-accent:hover {
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05)) !important;
  box-shadow: inset 0 0 20px rgba(245, 158, 11, 0.08);
  transform: scale(1.05);
}

/* Stat section gradient background */
.stats-section {
  position: relative;
}

/* Professional text gradient accent */
.text-accent-yellow {
  color: #f59e0b;
}

/* Badge accents */
.badge-yellow-accent {
  background: rgba(245, 158, 11, 0.15) !important;
  color: #f59e0b !important;
  border: 1px solid rgba(245, 158, 11, 0.3);
}

/* Light background for hover states */
.bg-light-primary {
  background: rgba(37, 99, 235, 0.1);
}
.bg-light-warning {
  background: rgba(245, 158, 11, 0.1);
}
.bg-light-success {
  background: rgba(22, 163, 74, 0.1);
}
.bg-light-info {
  background: rgba(6, 182, 212, 0.1);
}
.bg-light-danger {
  background: rgba(220, 53, 69, 0.1);
}

/* Smooth transitions for all interactive elements */
a, button {
  transition: all 0.2s ease;
}

/* Yellow accent on section badges */
.badge-warning {
  box-shadow: 0 4px 15px rgba(245, 158, 11, 0.15);
}

/* Section divider accent */
.border-bottom {
  border-bottom-color: rgba(245, 158, 11, 0.15) !important;
}

/* Responsive scaling for mobile */
@media (max-width: 768px) {
  .hover-scale-btn:hover {
    transform: translateY(-1px);
  }
  
  .feature-card-hover:hover {
    transform: translateY(-3px);
  }
  
  .stat-card-hover:hover {
    transform: translateY(-2px);
  }
}
</style>

<script>


  // Stat counter animation
  const statObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const targets = { '15K+': 15000, '2.4K+': 2400, '8.7K+': 8700, '500+': 500 };
      document.querySelectorAll('.stat-num').forEach(el => {
        const raw = el.textContent.trim();
        const target = targets[raw];
        if (!target) return;
        let count = 0;
        const suffix = raw.includes('K') ? 'K+' : '+';
        const divisor = raw.includes('K') ? 1000 : 1;
        const step = target / 60;
        const timer = setInterval(() => {
          count += step;
          if (count >= target) { count = target; clearInterval(timer); }
          el.textContent = (count / divisor).toFixed(count < target ? 1 : 0).replace('.0', '') + suffix;
        }, 25);
      });
      statObserver.disconnect();
    });
  }, { threshold: 0.5 });
  const statsSection = document.querySelector('.stats-section');
  if (statsSection) statObserver.observe(statsSection);
</script>

@endsection