@extends('layouts.home')
@section('title', __('Stardena Works - AI-Powered Job Platform'))
@section('home-content')


{{-- ═══════════════════════════════════════════════════════
     NOTIFICATION BAR
═══════════════════════════════════════════════════════ --}}
{{--
<div style="background:linear-gradient(90deg,#4f6ef7,#7c3aed);padding:9px 0;">
  <div class="container">
    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
      <span class="badge bg-white text-primary fw-bold px-2" style="font-size:10px;">🚀 NEW</span>
      <span style="font-size:13px;color:rgba(255,255,255,.9)">AI-powered CV Tailoring is live — get matched to the right job in seconds!</span>
      <a href="javascript:void(0);" onclick="comingSoon()" style="color:#fff;font-size:13px;font-weight:700;text-decoration:underline;">Try it Free →</a>
    </div>
  </div>
</div>
--}}

{{-- ═══════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════ --}}
<section class="hero-mesh">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>

  <div class="container py-5 py-lg-0" style="min-height:calc(100vh - 120px);display:flex;align-items:center;">
    <div class="row align-items-center g-5 w-100 py-4">

      {{-- Left --}}
      <div class="col-lg-6 fade-up">
        <div class="pill-badge mb-4">
          <span class="pill-dot"></span>
          AI-Powered Talent Matching · Uganda &amp; Africa
        </div>

        <h1 class="hero-h1 mb-4">
          Hire the <span class="gradient-text">Top 1%</span><br>
          of Talent,<br>AI&#8202;Verified
        </h1>

        <p style="font-size:1rem;line-height:1.7;color:var(--muted);max-width:480px;margin-bottom:2rem;">
          Stardena Works connects employers with skilled workers using AI. Find full-time jobs, quick gigs, or scan millions of CVs — all in one place.
        </p>

        {{-- Search --}}
        <div class="search-glass mb-4">
          <form action="{{ route('jobs.index') }}" method="GET">
            <div class="d-flex flex-column flex-sm-row gap-2 align-items-stretch">
              <div class="d-flex align-items-center flex-grow-1 px-3" style="min-width:0">
                <i class="bi bi-search me-2" style="color:var(--muted);flex-shrink:0"></i>
                <input type="text" name="keyword" placeholder="Job title, skill or keyword">
              </div>
              <div class="search-divider d-none d-sm-block"></div>
              <div class="d-flex align-items-center flex-grow-1 px-3" style="min-width:0">
                <i class="bi bi-geo-alt me-2" style="color:var(--muted);flex-shrink:0"></i>
                <input type="text" name="location" placeholder="Kampala, Uganda">
              </div>
              <button type="submit"
                      style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;border-radius:10px;padding:10px 24px;font-weight:600;font-size:14px;white-space:nowrap;flex-shrink:0;">
                Search Jobs
              </button>
            </div>
          </form>
        </div>

        {{-- Popular tags --}}
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
          <span style="font-size:12px;font-weight:600;color:var(--muted)">Popular:</span>
          @foreach(['Driver','Sales Rep','Delivery','Software Dev','Nurse','Teacher'] as $tag)
            <a href="{{ route('jobs.index', ['keyword' => $tag]) }}" class="pop-tag text-decoration-none">{{ $tag }}</a>
          @endforeach
        </div>

        {{-- Social proof --}}
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex">
            @foreach(['men/48','women/73','men/55','men/83'] as $p)
              <img src="https://randomuser.me/api/portraits/{{ $p }}.jpg"
                   class="rounded-circle" width="36" height="36"
                   style="border:2px solid var(--ink-2);margin-right:-10px;object-fit:cover;">
            @endforeach
          </div>
          <div>
            <div class="text-warning mb-1" style="font-size:12px">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
            </div>
            <small style="color:var(--muted);font-size:12px">Trusted by <strong style="color:#fff">10,000+</strong> workers &amp; employers</small>
          </div>
        </div>
      </div>

      {{-- Right — Live AI panel --}}
      <div class="col-lg-6 d-none d-lg-block fade-up" style="animation-delay:.15s">
        <div class="glass-card p-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span style="font-size:12px;font-weight:600;color:var(--muted)">AI MATCH DASHBOARD</span>
            <span class="pill-badge" style="padding:4px 10px;font-size:11px;">
              <span class="pill-dot"></span> Live
            </span>
          </div>

          {{-- Score card --}}
          <div style="background:linear-gradient(135deg,rgba(79,110,247,.25),rgba(124,58,237,.2));border:1px solid rgba(79,110,247,.3);border-radius:12px;padding:20px;" class="mb-3">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <div style="font-size:11px;color:var(--muted);margin-bottom:4px;">AI Match Score</div>
                <div style="font-weight:700;font-size:15px;color:#fff;">Software Engineer · Kampala</div>
                <div style="font-size:12px;color:var(--muted);margin-top:6px;">3 skills verified · CV tailored · Instantly applied</div>
              </div>
              <div class="score-ring"><span>92%</span></div>
            </div>
          </div>

          {{-- Job rows --}}
          @foreach([
            ['M','bg-primary','MTN Uganda','Sales Manager · UGX 2.5M/mo','New','rgba(79,110,247,.2)','#818cf8'],
            ['A','rgba(239,68,68,.8)','Airtel Uganda','Customer Support · Full-time','Match','rgba(34,197,94,.15)','#4ade80'],
            ['S','rgba(34,197,94,.8)','Stanbic Bank','IT Officer · UGX 3.8M/mo','Hot','rgba(245,158,11,.15)','#fcd34d'],
          ] as [$letter,$bg,$name,$sub,$badge,$badgeBg,$badgeColor])
          <div class="d-flex align-items-center gap-3 mb-2" style="background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:10px;padding:12px;">
            <div class="d-flex align-items-center justify-content-center fw-bold text-white rounded-3 flex-shrink-0"
                 style="width:40px;height:40px;background:{{ $bg }};font-size:15px;">{{ $letter }}</div>
            <div class="flex-grow-1" style="min-width:0">
              <div style="font-weight:600;font-size:14px;color:#fff;">{{ $name }}</div>
              <div style="font-size:12px;color:var(--muted);">{{ $sub }}</div>
            </div>
            <span style="background:{{ $badgeBg }};color:{{ $badgeColor }};font-size:11px;font-weight:600;padding:3px 10px;border-radius:100px;white-space:nowrap;">{{ $badge }}</span>
          </div>
          @endforeach

          <div class="d-flex gap-2 mt-3">
            <button onclick="comingSoon()" style="flex:1;background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;border-radius:10px;padding:10px;font-weight:600;font-size:13px;">
              <i class="bi bi-robot me-1"></i> Tailor My CV
            </button>
            <button onclick="comingSoon()" style="flex:1;background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.3);color:#4ade80;border-radius:10px;padding:10px;font-weight:600;font-size:13px;">
              <i class="bi bi-whatsapp me-1"></i> Apply via WhatsApp
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     STATS
═══════════════════════════════════════════════════════ --}}
<section class="stats-section py-5" style="background:var(--ink-2);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
  <div class="container">
    <div class="row g-3 text-center">
      <div class="col-6 col-md-3 fade-up">
        <div class="stat-card">
          <div class="stat-num blue mb-1">15K+</div>
          <div style="font-size:12px;font-weight:600;color:var(--muted)">Registered Workers</div>
        </div>
      </div>
      <div class="col-6 col-md-3 fade-up" style="transition-delay:.08s">
        <div class="stat-card">
          <div class="stat-num purple mb-1">2.4K+</div>
          <div style="font-size:12px;font-weight:600;color:var(--muted)">Companies Hiring</div>
        </div>
      </div>
      <div class="col-6 col-md-3 fade-up" style="transition-delay:.16s">
        <div class="stat-card">
          <div class="stat-num green mb-1">8.7K+</div>
          <div style="font-size:12px;font-weight:600;color:var(--muted)">Jobs Filled</div>
        </div>
      </div>
      <div class="col-6 col-md-3 fade-up" style="transition-delay:.24s">
        <div class="stat-card">
          <div class="stat-num amber mb-1">500+</div>
          <div style="font-size:12px;font-weight:600;color:var(--muted)">Quick Gigs Today</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     TRUSTED BY
═══════════════════════════════════════════════════════ --}}
<div style="background:var(--ink);padding:28px 0;border-bottom:1px solid var(--border);">
  <div class="container text-center">
    <p style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);font-weight:700;margin-bottom:16px;">Trusted by companies across Uganda</p>
    <div class="d-flex flex-wrap justify-content-center gap-2">
      <span class="trust-chip">🏢 Stanbic Bank</span>
      <span class="trust-chip">📱 MTN Uganda</span>
      <span class="trust-chip">✈️ Uganda Airlines</span>
      <span class="trust-chip">🏥 Nakasero Hospital</span>
      <span class="trust-chip">🛒 Jumia Uganda</span>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     FEATURES
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6 fade-up" style="background:var(--ink);">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-eyebrow mb-2">What We Offer</div>
      <h2 class="section-h2 mb-2">Everything you need to<br>work or hire smarter</h2>
      <p style="color:var(--muted);font-size:.9375rem">From quick gig alerts on WhatsApp to AI-ranked talent shortlists</p>
    </div>
    <div class="row g-3">
      @foreach([
        ['bi-briefcase',   'rgba(79,110,247,.15)',  '#818cf8', 'Job Listings & Direct Apply',   'Browse thousands of verified jobs. Apply directly — no email chains.'],
        ['bi-clock',       'rgba(34,197,94,.12)',   '#4ade80', 'Quick Gigs — Earn Today',        'Delivery, cleaning, tutoring, coding. Find hourly work near you. Get paid same day.'],
        ['bi-stars',       'rgba(245,158,11,.12)',  '#fcd34d', 'AI CV Tailoring',                'Upload your CV and our AI rewrites it to match any job description perfectly.'],
        ['bi-person-search','rgba(239,68,68,.12)',  '#f87171', 'AI Talent Scanner',              'Scan millions of CVs in minutes. Our AI ranks the best-fit candidates.'],
        ['bi-whatsapp',    'rgba(34,197,94,.12)',   '#4ade80', 'Apply via WhatsApp',             'Receive alerts, apply, and track applications through WhatsApp — no app needed.'],
        ['bi-bell',        'rgba(99,179,237,.12)',  '#93c5fd', 'Smart Job Alerts',               'Set preferences once. Get personalized alerts when matching jobs are posted.'],
      ] as [$icon,$bg,$color,$title,$desc])
      <div class="col-md-6 col-lg-4">
        <div class="glass-card p-4 h-100 hover-lift">
          <div class="feat-icon mb-3" style="background:{{ $bg }};">
            <i class="bi {{ $icon }}" style="color:{{ $color }};"></i>
          </div>
          <h6 style="font-weight:700;color:#fff;margin-bottom:8px;">{{ $title }}</h6>
          <p style="color:var(--muted);font-size:13px;line-height:1.6;margin:0;">{{ $desc }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6" style="background:var(--ink-2);border-top:1px solid var(--border);">
  <div class="container">
    <div class="text-center mb-5 fade-up">
      <div class="section-eyebrow mb-2">How It Works</div>
      <h2 class="section-h2 mb-2">Up and running in minutes</h2>
      <p style="color:var(--muted);">Simple steps for workers and employers.</p>
    </div>
    <div class="row g-4">
      {{-- Workers --}}
      <div class="col-lg-6 fade-up">
        <div class="d-flex align-items-center gap-2 mb-4">
          <span style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);color:#fff;font-size:12px;font-weight:700;padding:5px 14px;border-radius:100px;">For Workers</span>
        </div>
        <div class="d-flex flex-column gap-3">
          @foreach([
            ['1','#4f6ef7','bi-person-plus','Register Free','Create your profile in minutes'],
            ['2','#7c3aed','bi-stars','AI Matches You','Get matched to the best opportunities'],
            ['3','#22c55e','bi-check-circle','Apply &amp; Get Hired','One-click apply via WhatsApp'],
          ] as [$n,$color,$icon,$title,$sub])
          <div class="glass-card p-4 d-flex gap-4 align-items-start">
            <div class="step-num" style="background:{{ $color }}1a;border:1px solid {{ $color }}44;color:{{ $color }};">{{ $n }}</div>
            <div>
              <i class="bi {{ $icon }} mb-2 d-block" style="font-size:1.5rem;color:{{ $color }};"></i>
              <div style="font-weight:700;color:#fff;margin-bottom:4px;">{!! $title !!}</div>
              <div style="font-size:13px;color:var(--muted);">{{ $sub }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      {{-- Employers --}}
      <div class="col-lg-6 fade-up" style="transition-delay:.1s">
        <div class="d-flex align-items-center gap-2 mb-4">
          <span style="background:rgba(34,197,94,.15);color:#4ade80;border:1px solid rgba(34,197,94,.3);font-size:12px;font-weight:700;padding:5px 14px;border-radius:100px;">For Employers</span>
        </div>
        <div class="d-flex flex-column gap-3">
          @foreach([
            ['1','#ef4444','bi-pencil-square','Post a Job','Describe the role — AI writes the ad'],
            ['2','#4f6ef7','bi-search','AI Pre-Screens','See only top verified candidates'],
            ['3','#a78bfa','bi-people','Hire in Days','Interview a shortlist of top candidates'],
          ] as [$n,$color,$icon,$title,$sub])
          <div class="glass-card p-4 d-flex gap-4 align-items-start">
            <div class="step-num" style="background:{{ $color }}1a;border:1px solid {{ $color }}44;color:{{ $color }};">{{ $n }}</div>
            <div>
              <i class="bi {{ $icon }} mb-2 d-block" style="font-size:1.5rem;color:{{ $color }};"></i>
              <div style="font-weight:700;color:#fff;margin-bottom:4px;">{{ $title }}</div>
              <div style="font-size:13px;color:var(--muted);">{{ $sub }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     AI SECTION
═══════════════════════════════════════════════════════ --}}
<section class="py-5 py-lg-6 fade-up" style="background:var(--ink);border-top:1px solid var(--border);">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="pill-badge mb-4"><i class="bi bi-stars me-1"></i> Powered by AI</div>
        <h2 class="section-h2 mb-3">Stop reading 500 CVs.<br>Let AI do it in 5 mins.</h2>
        <p style="color:var(--muted);line-height:1.7;margin-bottom:1.75rem;">Our AI Talent Scanner reads, ranks, and explains every candidate. You get a shortlist — not a pile of documents.</p>
        <ul class="list-unstyled mb-4 d-flex flex-column gap-3">
          @foreach([
            'AI conducts voice/chat pre-screening with every applicant',
            'Semantic matching — finds great talent even with non-standard CVs',
            'Instant rejection with constructive feedback',
            'Candidates ranked with explainable AI match score',
          ] as $feat)
          <li class="d-flex gap-3 align-items-start">
            <i class="bi bi-check-circle-fill text-success flex-shrink-0" style="margin-top:2px;"></i>
            <span style="font-size:14px;color:var(--muted);">{{ $feat }}</span>
          </li>
          @endforeach
        </ul>
        <div class="d-flex gap-2 flex-wrap">
          <button onclick="comingSoon()" style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;border-radius:10px;padding:11px 24px;font-weight:600;font-size:14px;">Post a Job Now</button>
          <button onclick="comingSoon()" style="background:transparent;border:1px solid var(--border);color:#fff;border-radius:10px;padding:11px 24px;font-weight:600;font-size:14px;">Watch Demo</button>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="glass-card p-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <span class="section-eyebrow">AI Match Dashboard</span>
              <div style="font-weight:700;color:#fff;margin-top:4px;">Live Candidate Rankings</div>
              <div style="font-size:12px;color:var(--muted);">Top matches for: <strong style="color:#818cf8">Marketing Manager · Kampala</strong></div>
            </div>
          </div>
          @foreach([
            ['women/30','Sarah Achieng','5 yrs experience · FMCG background','96%','var(--green)'],
            ['men/59','Wamala Peterson','4 yrs experience · Telecom sector','88%','#818cf8'],
            ['women/16','Lydia Nakato','3 yrs experience · Banking sector','81%','#fcd34d'],
          ] as [$portrait,$name,$sub,$score,$color])
          <div class="cand-row mb-2">
            <div class="d-flex gap-3 align-items-center">
              <img src="https://randomuser.me/api/portraits/{{ $portrait }}.jpg"
                   class="rounded-circle flex-shrink-0" width="44" height="44" style="object-fit:cover;">
              <div class="flex-grow-1" style="min-width:0">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span style="font-weight:600;font-size:14px;color:#fff;">{{ $name }}</span>
                  <span style="font-size:12px;font-weight:700;color:{{ $color }};">{{ $score }}</span>
                </div>
                <div style="font-size:12px;color:var(--muted);margin-bottom:6px;">{{ $sub }}</div>
                <div class="match-track"><div class="match-fill" style="width:{{ $score }};background:{{ $color }};"></div></div>
              </div>
            </div>
          </div>
          @endforeach
          <div style="background:rgba(79,110,247,.08);border:1px solid rgba(79,110,247,.2);border-radius:8px;padding:12px;margin-top:12px;">
            <div class="d-flex gap-2 align-items-center">
              <i class="bi bi-info-circle" style="color:#818cf8;flex-shrink:0;"></i>
              <small style="color:var(--muted);">AI scanned <strong style="color:#fff">347 CVs</strong> and shortlisted <strong style="color:#fff">3 candidates</strong> in <strong style="color:#fff">4 minutes</strong></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════ --}}
<section class="cta-section py-5 py-lg-6">
  <div class="container text-center">
    <div class="pill-badge mb-4 mx-auto" style="width:fit-content">🇺🇬 Built in Uganda, for Africa</div>
    <h2 class="section-h2 mb-3">Start your journey today</h2>
    <p style="color:var(--muted);font-size:.9375rem;margin-bottom:2rem;max-width:480px;margin-left:auto;margin-right:auto;">
      Join thousands of workers and employers on Stardena Works — the smart way to hire and be hired.
    </p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <button onclick="comingSoon()" style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;border-radius:10px;padding:13px 28px;font-weight:700;font-size:14px;">
        <i class="bi bi-person me-2"></i>I'm a Worker
      </button>
      <button onclick="comingSoon()" style="background:transparent;border:1px solid var(--border);color:#fff;border-radius:10px;padding:13px 28px;font-weight:700;font-size:14px;">
        <i class="bi bi-building me-2"></i>I'm an Employer
      </button>
      <button onclick="comingSoon()" style="background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.3);color:#4ade80;border-radius:10px;padding:13px 28px;font-weight:700;font-size:14px;">
        <i class="bi bi-whatsapp me-2"></i>Apply on WhatsApp
      </button>
    </div>
  </div>
</section>

{{-- ── Scroll-triggered fade-up ── --}}
<script>
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: .12 });
  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

  // Stat counter animation
  const statObserver = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
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
          el.textContent = (count / divisor).toFixed(count < target ? 1 : 0).replace('.0','') + suffix;
        }, 25);
      });
      statObserver.disconnect();
    });
  }, { threshold: .5 });
  const statsSection = document.querySelector('.stats-section');
  if (statsSection) statObserver.observe(statsSection);
</script>

@endsection