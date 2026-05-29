@extends('layouts.jobs')
@section('title', 'Stardena Works - AI-Powered Job Platform')
@section('meta_description', 'Find jobs in Uganda, get AI-powered CV enhancement, and connect with top employers on Stardena Works.')

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
          <button type="submit" class="btn btn-primary fw-semibold px-4" style="background: #1e40af; border: none;">
            Search Jobs
          </button>
        </form>

        {{-- Popular Tags --}}
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
          <span class="text-white-50 small">Popular:</span>
          @foreach(['Driver', 'Sales Rep', 'Delivery', 'Software Dev', 'Nurse', 'Teacher'] as $tag)
            <a href="{{ route('jobs.index', ['keyword' => $tag]) }}" 
              class="badge bg-white text-primary text-decoration-none rounded-pill px-3 py-1" 
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
              <a href="{{ url('/#cv-enhancement') }}" class="btn btn-primary rounded-pill flex-grow-1" style="background: linear-gradient(135deg, #2563eb, #1e3a8a); border: none;">
                <i class="bi bi-magic me-1"></i> Tailor My CV
              </a>
              <button onclick="comingSoon()" class="btn btn-outline-success rounded-pill flex-grow-1">
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
<section class="py-4 py-lg-5 border-bottom" style="background: #f8faff;">
  <div class="container-xl px-3 px-md-4">
    <div class="row g-3 text-center">
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
          <div class="stat-num display-6 fw-bold text-primary mb-1">15K+</div>
          <div class="small text-muted">Registered Workers</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
          <div class="stat-num display-6 fw-bold text-primary mb-1">2.4K+</div>
          <div class="small text-muted">Companies Hiring</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
          <div class="stat-num display-6 fw-bold text-primary mb-1">8.7K+</div>
          <div class="small text-muted">Jobs Filled</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-3">
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
<div class="border-bottom py-3 bg-white">
  <div class="container-xl px-3 px-md-4">
    <p class="small text-uppercase text-muted text-center mb-2" style="letter-spacing: 0.1em; font-size: 10px;">Trusted by companies across Uganda</p>
    <div class="d-flex flex-wrap justify-content-center gap-1 px-2">
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
        <a href="javascript:void(0)" onclick="comingSoon()" 
           class="d-inline-flex align-items-center gap-1 bg-light border rounded-pill px-2 py-1 text-decoration-none"
           style="transition: all 0.2s ease;">
          <span style="font-size: 12px;">{{ $icon }}</span>
          <span class="fw-normal text-dark" style="font-size: 11px;">{{ $company }}</span>
        </a>
      @endforeach
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     FEATURES SECTION (Icons + Title on same line)
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-2">What We Offer</span>
      <h2 class="h2 fw-bold mb-2" style="color: #1e2a3e;">Everything you need to<br>work or hire smarter</h2>
      <p class="text-muted">From quick gig alerts on WhatsApp to AI-ranked talent shortlists</p>
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
        <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift">
          <div class="card-body p-3 p-md-4">
            {{-- Icon + Title on same line --}}
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="rounded-2 bg-light-{{ $color }} d-inline-flex p-2 flex-shrink-0">
                <i class="bi bi-{{ $icon }} fs-5 text-{{ $color }}"></i>
              </div>
              <h6 class="fw-bold mb-0" style="line-height: 1.3;">{{ $title }}</h6>
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



{{-- ═══════════════════════════════════════════════════════
     CV ENHANCEMENT SECTION (id="cv-enhancement")
═══════════════════════════════════════════════════════ --}}
@include('home.cv-charge')

    
    {{-- Campaign Banner --}}
    {{--
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
      <div class="card-body p-4 p-lg-5 text-center text-white">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div class="text-start">
            <span class="badge bg-white text-warning rounded-pill px-3 py-2 mb-2">🚀 SPECIAL LAUNCH OFFER</span>
            <h3 class="fw-bold mb-2">Get 50% off your first 3 months</h3>
            <p class="mb-0 opacity-90">Use code: <strong class="bg-white bg-opacity-20 px-2 py-1 rounded">STARDENA50</strong> at checkout</p>
          </div>
          <button onclick="signupToBegin()" class="btn btn-light fw-semibold rounded-pill px-5 py-3 shadow-lg" style="color: #f97316;">
            Sign Up Now <i class="bi bi-arrow-right ms-2"></i>
          </button>
        </div>
        <div class="row mt-4 pt-3 g-3 text-center">
          <div class="col-6 col-md-3">
            <div class="bg-white bg-opacity-15 rounded-3 p-2">
              <i class="bi bi-file-text fs-4"></i>
              <div class="small fw-semibold">CV Templates</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bg-white bg-opacity-15 rounded-3 p-2">
              <i class="bi bi-graph-up fs-4"></i>
              <div class="small fw-semibold">ATS Score</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bg-white bg-opacity-15 rounded-3 p-2">
              <i class="bi bi-envelope-paper fs-4"></i>
              <div class="small fw-semibold">Cover Letters</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bg-white bg-opacity-15 rounded-3 p-2">
              <i class="bi bi-person-check fs-4"></i>
              <div class="small fw-semibold">Interview Prep</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    --}}

  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6 border-top" style="background: #f8faff;">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5">
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-2">How It Works</span>
      <h2 class="h2 fw-bold mb-2">Up and running in minutes</h2>
      <p class="text-muted">Simple steps for workers and employers.</p>
    </div>
    <div class="row g-4">
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-3">
          <span class="badge bg-primary w-auto mb-3 px-3 py-2 rounded-pill" style="width: fit-content;">For Workers</span>
          <div class="d-flex gap-4 mb-3">
            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">1</div>
            <div><i class="bi bi-person-plus fs-4 text-primary"></i><div class="fw-bold">Register Free</div><div class="small text-muted">Create your profile in minutes</div></div>
          </div>
          <div class="d-flex gap-4 mb-3">
            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">2</div>
            <div><i class="bi bi-stars fs-4 text-primary"></i><div class="fw-bold">AI Matches You</div><div class="small text-muted">Get matched to the best opportunities</div></div>
          </div>
          <div class="d-flex gap-4">
            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">3</div>
            <div><i class="bi bi-check-circle fs-4 text-primary"></i><div class="fw-bold">Apply & Get Hired</div><div class="small text-muted">One-click apply via WhatsApp</div></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-3">
          <span class="badge bg-success w-auto mb-3 px-3 py-2 rounded-pill" style="width: fit-content;">For Employers</span>
          <div class="d-flex gap-4 mb-3">
            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">1</div>
            <div><i class="bi bi-pencil-square fs-4 text-success"></i><div class="fw-bold">Post a Job</div><div class="small text-muted">Describe the role — AI writes the ad</div></div>
          </div>
          <div class="d-flex gap-4 mb-3">
            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">2</div>
            <div><i class="bi bi-search fs-4 text-success"></i><div class="fw-bold">AI Pre-Screens</div><div class="small text-muted">See only top verified candidates</div></div>
          </div>
          <div class="d-flex gap-4">
            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">3</div>
            <div><i class="bi bi-people fs-4 text-success"></i><div class="fw-bold">Hire in Days</div><div class="small text-muted">Interview a shortlist of top candidates</div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6 bg-primary" style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
  <div class="container-xl px-3 px-md-4 text-center">
    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-3">Start your journey today</span>
    <!-- <h2 class="h2 fw-bold text-white mb-3">Start your journey today</h2> -->
    <p class="text-white-50 mb-4" style="max-width: 480px; margin: 0 auto;">Join thousands of workers and employers on Stardena Works — the smart way to hire and be hired.</p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <button onclick="signupToBegin()" class="btn btn-light fw-semibold rounded-pill px-5 py-3">
        <i class="bi bi-person me-2"></i>I'm a Worker
      </button>
      <button onclick="signupToBegin()" class="btn btn-outline-light fw-semibold rounded-pill px-5 py-3">
        <i class="bi bi-building me-2"></i>I'm an Employer
      </button>
      <button onclick="openSocialModal()" class="btn btn-success fw-semibold rounded-pill px-5 py-3">
        <i class="bi bi-whatsapp me-2"></i>Apply on WhatsApp
      </button>
    </div>
  </div>
</section>



<script>
  function comingSoon() {
    const modal = new bootstrap.Modal(document.getElementById('comingSoonModal'));
    modal.show();
  }



  function scrollToCVSection() {
    const section = document.getElementById('cv-enhancement');
    if (section) {
      section.scrollIntoView({ behavior: 'smooth' });
    }
  }

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