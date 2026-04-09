<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VT1BQTKZZ5"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-VT1BQTKZZ5');
    </script>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>@yield('title', 'Stardena Works — Jobs & Talent in Uganda')</title>
    <meta name="description" content="@yield('meta_description', 'AI-powered jobs, gigs and talent platform for Uganda and Africa. Find your next opportunity on Stardena Works.')">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('og_title', 'Stardena Works')">
    <meta property="og:description" content="@yield('og_description', 'AI-powered jobs, gigs and talent platform for Uganda and Africa.')">
    <meta property="og:url"         content="@yield('canonical', url()->current())">
    <meta property="og:image"       content="@yield('og_image', asset('front/images/og-default.png'))">
    <meta property="og:site_name"   content="Stardena Works">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('og_title', 'Stardena Works')">
    <meta name="twitter:description" content="@yield('og_description', 'AI-powered jobs, gigs and talent platform for Uganda and Africa.')">
    <meta name="twitter:image"       content="@yield('og_image', asset('front/images/og-default.png'))">

    @yield('schema')
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ getFavicon() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS Only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

        :root {
            --ink:      #0b0c1a;
            --ink-2:    #13152e;
            --ink-3:    #1c1f3a;
            --accent:   #4f6ef7;
            --accent-2: #7c3aed;
            --glow:     rgba(79,110,247,.35);
            --green:    #22c55e;
            --amber:    #f59e0b;
            --surface:  rgba(255,255,255,.04);
            --border:   rgba(255,255,255,.09);
            --text:     rgba(255,255,255,.88);
            --muted:    rgba(255,255,255,.45);
            --radius:   14px;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--ink); color: var(--text); }

        /* ── Mesh hero background ── */
        .hero-mesh {
            background:
            radial-gradient(ellipse 80% 60% at 10% 20%, rgba(79,110,247,.22) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 70%, rgba(124,58,237,.18) 0%, transparent 55%),
            radial-gradient(ellipse 40% 40% at 50% 50%, rgba(34,197,94,.06) 0%, transparent 60%),
            var(--ink);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 100vh;
        }

        /* ADD this media query */
        @media (max-width: 991.98px) {
            .hero-mesh {
                min-height: auto;
                align-items: flex-start;
            }
        }


        .hero-mesh::before {
            content:'';
            position: absolute; inset: 0;
            background-image:
            linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        /* Ensure row is properly centered */
        .hero-mesh .row {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
            justify-content: center;
        }

        /* ── Glow orbs ── */
        .orb {
            position: absolute; border-radius: 50%;
            filter: blur(80px); pointer-events: none; animation: drift 12s ease-in-out infinite alternate;
        }
        .orb-1 { width:380px;height:380px; background:rgba(79,110,247,.18); top:-80px; left:-60px; }
        .orb-2 { width:280px;height:280px; background:rgba(124,58,237,.15); bottom:60px; right:-40px; animation-delay:-4s; }
        .orb-3 { width:200px;height:200px; background:rgba(34,197,94,.10); top:40%; left:40%; animation-delay:-8s; }
        @keyframes drift { from { transform: translate(0,0) scale(1); } to { transform: translate(30px,20px) scale(1.08); } }

        /* ── Pill badge ── */
        .pill-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(79,110,247,.12); border: 1px solid rgba(79,110,247,.3);
            border-radius: 100px; padding: 6px 16px;
            font-size: 12px; font-weight: 600; color: #a5b4fc; letter-spacing: .03em;
        }
        .pill-dot { width:7px;height:7px;border-radius:50%;background:var(--green);box-shadow:0 0 8px var(--green);animation:pulse-dot 2s infinite; }
        @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }

        /* ── Hero headline ── */
        .hero-h1 {
            font-size: clamp(2.25rem, 5.5vw, 4rem);
            font-weight: 800; line-height: 1.12; letter-spacing: -.03em;
            color: #fff;
        }
        .hero-h1 .gradient-text {
            background: linear-gradient(135deg, #818cf8 0%, #7c3aed 50%, #4f6ef7 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        /* ── Search bar ── */
        .search-glass {
            background: rgba(255,255,255,.06);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            backdrop-filter: blur(12px);
            padding: 6px;
            overflow: hidden;
        }

        .search-glass input {
            background: transparent; border: none; outline: none;
            color: #fff; font-size: 14px; width: 100%;
        }
        .search-glass input::placeholder { color: var(--muted); }
        .search-divider { width: 1px; height: 24px; background: var(--border); flex-shrink: 0; }

        @media (max-width: 575.98px) {
            .search-glass .d-flex {
                flex-direction: column !important;
            }
            .search-glass button {
                width: 100%;
                border-radius: 8px !important;
            }
        }

        /* ── Glass card ── */
        .glass-card {
            background: rgba(255,255,255,.05);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            backdrop-filter: blur(16px);
            transition: border-color .2s, box-shadow .2s, transform .2s;
        }
        .glass-card:hover {
            border-color: rgba(79,110,247,.4);
            box-shadow: 0 0 0 1px rgba(79,110,247,.15), 0 20px 40px rgba(0,0,0,.3);
            transform: translateY(-2px);
        }

        /* ── AI score arc ── */
        .score-ring {
            width: 72px; height: 72px; border-radius: 50%;
            background: conic-gradient(#4f6ef7 0% 92%, rgba(255,255,255,.1) 92% 100%);
            display: flex; align-items: center; justify-content: center;
            position: relative;
        }
        .score-ring::after {
            content: ''; position: absolute; inset: 5px; border-radius: 50%;
            background: var(--ink-3);
        }
        .score-ring span { position: relative; z-index: 1; font-weight: 800; font-size: 15px; color: #fff; }

        /* ── Stat cards ── */
        .stat-card {
            background: rgba(255,255,255,.04);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px 20px;
            text-align: center;
        }
        .stat-num { font-size: 2.25rem; font-weight: 800; letter-spacing: -.04em; line-height: 1; }
        .stat-num.blue   { background: linear-gradient(135deg,#818cf8,#4f6ef7); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }
        .stat-num.purple { background: linear-gradient(135deg,#c084fc,#7c3aed); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }
        .stat-num.green  { background: linear-gradient(135deg,#4ade80,#22c55e); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }
        .stat-num.amber  { background: linear-gradient(135deg,#fcd34d,#f59e0b); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }

        /* ── Feature icon box ── */
        .feat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem; flex-shrink: 0;
        }

        /* ── Section headings ── */
        .section-eyebrow {
            font-size: 11px; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: #818cf8;
        }
        .section-h2 {
            font-size: clamp(1.6rem, 3vw, 2.5rem);
            font-weight: 800; letter-spacing: -.03em; color: #fff; line-height: 1.18;
        }

        /* ── Step number ── */
        .step-num {
            width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
        }

        /* ── Match bar ── */
        .match-track { height: 4px; background: rgba(255,255,255,.1); border-radius: 2px; }
        .match-fill  { height: 4px; border-radius: 2px; }

        /* ── Candidate row ── */
        .cand-row {
            background: rgba(255,255,255,.04);
            border: 1px solid var(--border);
            border-radius: 10px; padding: 14px;
            transition: border-color .2s;
        }
        .cand-row:hover { border-color: rgba(79,110,247,.35); }

        /* ── CTA section ── */
        .cta-section {
            background:
            radial-gradient(ellipse 70% 80% at 50% 50%, rgba(79,110,247,.2) 0%, transparent 70%),
            var(--ink-2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        /* ── Trusted logos ── */
        .trust-chip {
            background: rgba(255,255,255,.05);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px; font-weight: 600; color: var(--muted);
            white-space: nowrap;
        }

        /* ── Hover lift ── */
        .hover-lift { transition: transform .2s, box-shadow .2s; }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,.3); }

        /* ── Popular tags ── */
        .pop-tag {
            background: rgba(255,255,255,.07); border: 1px solid var(--border);
            border-radius: 100px; padding: 4px 14px; font-size: 12px; font-weight: 500;
            color: var(--muted); cursor: pointer; transition: background .15s, color .15s, border-color .15s;
        }
        .pop-tag:hover { background: rgba(79,110,247,.15); border-color: rgba(79,110,247,.4); color: #818cf8; }

        /* ── Entry animations ── */
        .fade-up { opacity: 0; transform: translateY(28px); transition: opacity .6s ease, transform .6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* ── Footer on dark ── */
        footer { background: #07080f !important; border-top: 1px solid var(--border); }
        footer a { transition: color .15s; }
        footer a:hover { color: #818cf8 !important; }
    </style>

</head>
<body>

    <!-- Include Navigation -->
    @include('layouts.nav-bar')

    <!-- Main Content -->
    @yield('home-content')

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Scroll to top functionality
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('scrollTop');
            if (btn && window.scrollY > 300) {
                btn.classList.add('show');
                btn.style.display = 'flex';
            } else if (btn) {
                btn.classList.remove('show');
                btn.style.display = 'none';
            }
        });
        
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        // Animate stats on scroll
        function animateCounter(element, target) {
            let count = 0;
            const duration = 2000;
            const step = target / (duration / 30);
            const timer = setInterval(() => {
                count += step;
                if (count >= target) {
                    count = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(count).toLocaleString();
            }, 30);
        }
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stats = document.querySelectorAll('.stat-number-value');
                    const targets = [15234, 2456, 8750, 523];
                    stats.forEach((stat, i) => animateCounter(stat, targets[i]));
                    observer.disconnect();
                }
            });
        });
        
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) observer.observe(statsSection);
        
        // Parallax effect on hero
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero-section');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
        });
    </script>
</body>
</html>