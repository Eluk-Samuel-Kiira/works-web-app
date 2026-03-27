<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Stardena Works - AI-powered jobs, gigs & talent platform for Uganda and Africa" />
    <title>@yield('title')</title>
    
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ getFavicon() }}" />

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Iconify -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <style>
        :root {
        --bs-primary: #5D87FF;
        --bs-primary-rgb: 93,135,255;
        --bs-primary-subtle: #ECF2FF;
        --bs-secondary: #49BEFF;
        --bs-success: #13DEB9;
        --bs-warning: #FFAE1F;
        --bs-danger: #FA896B;
        --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
        --bs-border-radius: 8px;
        }

        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body { background: #f6f9fc; color: #2a3547; overflow-x: hidden; }

        /* ---- Topbar ---- */
        .topbar-strip {
        background: var(--bs-primary);
        padding: 10px 0;
        font-size: 13px;
        color: #fff;
        }

        /* ---- Navbar ---- */
        .header-fp {
        background: #fff;
        border-bottom: 1px solid #eef0f4;
        position: sticky;
        top: 0;
        z-index: 1030;
        box-shadow: 0 2px 12px rgba(93,135,255,.08);
        }
        .navbar-brand img { height: 38px; }
        .nav-link { font-size: 14px; font-weight: 500; color: #2a3547 !important; padding: 8px 14px !important; border-radius: 6px; transition: all .2s; }
        .nav-link:hover { color: var(--bs-primary) !important; background: var(--bs-primary-subtle); }

        /* ---- Hero ---- */
        .hero-section {
        background: linear-gradient(135deg, #ECF2FF 0%, #f0f9ff 60%, #f6f9fc 100%);
        padding: 90px 0 60px;
        position: relative;
        overflow: hidden;
        }
        .hero-section::before {
        content: '';
        position: absolute;
        top: -120px; right: -120px;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(93,135,255,.12) 0%, transparent 70%);
        border-radius: 50%;
        }
        .hero-section::after {
        content: '';
        position: absolute;
        bottom: -80px; left: -80px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(73,190,255,.1) 0%, transparent 70%);
        border-radius: 50%;
        }
        .hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fff; border: 1px solid #e0e7ff;
        padding: 6px 14px; border-radius: 50px;
        font-size: 13px; font-weight: 600; color: var(--bs-primary);
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(93,135,255,.1);
        }
        .hero-badge .dot { width: 8px; height: 8px; background: #13DEB9; border-radius: 50%; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.3)} }

        .hero-title { font-size: 52px; font-weight: 800; line-height: 1.15; color: #2a3547; margin-bottom: 20px; }
        .hero-title .text-primary { color: var(--bs-primary) !important; }
        .hero-subtitle { font-size: 16px; color: #5a6a85; line-height: 1.7; margin-bottom: 30px; max-width: 500px; }

        /* Search bar */
        .search-hero {
        background: #fff;
        border-radius: 14px;
        padding: 8px;
        box-shadow: 0 8px 32px rgba(93,135,255,.15);
        display: flex; gap: 8px; flex-wrap: wrap;
        margin-bottom: 30px;
        }
        .search-hero .form-control {
        border: none; font-size: 14px; background: #f6f9fc;
        border-radius: 10px; padding: 12px 16px; flex: 1; min-width: 140px;
        }
        .search-hero .form-control:focus { box-shadow: 0 0 0 2px rgba(93,135,255,.2); }
        .search-hero .btn { border-radius: 10px; padding: 12px 24px; font-weight: 600; font-size: 14px; }

        /* Avatar stack */
        .avatar-stack img {
        width: 36px; height: 36px; border-radius: 50%;
        border: 2px solid #fff;
        margin-left: -10px; object-fit: cover;
        }
        .avatar-stack img:first-child { margin-left: 0; }

        /* Hero visual panel */
        .hero-visual {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(93,135,255,.18);
        padding: 24px;
        position: relative;
        }
        .match-score-card {
        background: linear-gradient(135deg, #5D87FF, #49BEFF);
        border-radius: 16px; padding: 20px; color: #fff; margin-bottom: 16px;
        }
        .score-circle {
        width: 72px; height: 72px; border-radius: 50%;
        background: rgba(255,255,255,.2); border: 3px solid rgba(255,255,255,.5);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; font-weight: 800;
        }
        .job-mini-card {
        background: #f6f9fc; border-radius: 12px; padding: 12px 16px;
        display: flex; align-items: center; gap: 12px; margin-bottom: 10px;
        border: 1px solid #eef0f4; transition: .2s;
        }
        .job-mini-card:hover { background: var(--bs-primary-subtle); border-color: rgba(93,135,255,.3); }
        .company-logo {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; font-weight: 800; color: #fff; flex-shrink: 0;
        }
        .floating-badge {
        position: absolute; top: -12px; right: 20px;
        background: #13DEB9; color: #fff; border-radius: 50px;
        padding: 4px 12px; font-size: 11px; font-weight: 700;
        box-shadow: 0 4px 12px rgba(19,222,185,.3);
        }

        /* ---- Stats ---- */
        .stats-section { padding: 50px 0; background: #fff; border-top: 1px solid #eef0f4; border-bottom: 1px solid #eef0f4; }
        .stat-item { text-align: center; padding: 10px; }
        .stat-number { font-size: 36px; font-weight: 800; color: var(--bs-primary); line-height: 1; }
        .stat-label { font-size: 13px; color: #5a6a85; font-weight: 500; margin-top: 4px; }
        .stat-divider { width: 1px; background: #eef0f4; }

        /* ---- Features ---- */
        .features-section { padding: 80px 0; background: #f6f9fc; }
        .section-chip {
        display: inline-block; background: var(--bs-primary-subtle);
        color: var(--bs-primary); font-size: 12px; font-weight: 700;
        padding: 5px 14px; border-radius: 50px; margin-bottom: 12px; text-transform: uppercase; letter-spacing: .5px;
        }
        .section-title { font-size: 36px; font-weight: 800; color: #2a3547; line-height: 1.2; }
        .section-sub { font-size: 15px; color: #5a6a85; line-height: 1.7; max-width: 520px; margin: 12px auto 0; }

        .feature-card {
        background: #fff; border-radius: 16px; padding: 28px 24px;
        border: 1px solid #eef0f4; height: 100%;
        transition: all .3s; cursor: default;
        }
        .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(93,135,255,.12);
        border-color: rgba(93,135,255,.2);
        }
        .feature-icon-wrap {
        width: 56px; height: 56px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 18px; font-size: 24px;
        }
        .feature-card h5 { font-size: 16px; font-weight: 700; color: #2a3547; margin-bottom: 10px; }
        .feature-card p { font-size: 14px; color: #5a6a85; line-height: 1.65; margin: 0; }

        /* ---- Tabs Section ---- */
        .tabs-section { padding: 80px 0; background: #fff; }
        .nav-pills .nav-link {
        background: #f6f9fc; color: #5a6a85; border-radius: 10px;
        padding: 10px 18px; font-size: 14px; font-weight: 600;
        border: 1px solid #eef0f4; display: flex; align-items: center; gap: 8px;
        }
        .nav-pills .nav-link.active {
        background: var(--bs-primary); color: #fff; border-color: var(--bs-primary);
        }
        .tab-visual {
        background: linear-gradient(135deg, #1e2a42, #2a3a58);
        border-radius: 20px; padding: 30px; min-height: 320px;
        display: flex; align-items: center; justify-content: center;
        }
        .tab-visual img { border-radius: 12px; max-width: 100%; }

        /* ---- How It Works ---- */
        .how-section { padding: 80px 0; background: linear-gradient(135deg, #ECF2FF 0%, #f0f9ff 100%); }
        .step-card {
        background: #fff; border-radius: 16px; padding: 28px 24px;
        text-align: center; border: 1px solid #eef0f4;
        transition: all .3s; position: relative;
        }
        .step-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(93,135,255,.12); }
        .step-number {
        position: absolute; top: -16px; left: 50%; transform: translateX(-50%);
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--bs-primary); color: #fff;
        font-size: 13px; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(93,135,255,.3);
        }
        .step-icon {
        width: 64px; height: 64px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 10px auto 16px; font-size: 28px;
        }
        .step-card h5 { font-size: 15px; font-weight: 700; color: #2a3547; margin-bottom: 8px; }
        .step-card p { font-size: 13px; color: #5a6a85; line-height: 1.6; margin: 0; }

        /* ---- AI Section ---- */
        .ai-section { padding: 80px 0; background: #fff; }
        .ai-panel {
        background: linear-gradient(135deg, #1e2a42, #162032);
        border-radius: 24px; padding: 48px 40px; color: #fff; position: relative; overflow: hidden;
        }
        .ai-panel::before {
        content: '';
        position: absolute; top: -60px; right: -60px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(93,135,255,.25) 0%, transparent 70%);
        border-radius: 50%;
        }
        .ai-glow-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(93,135,255,.2); border: 1px solid rgba(93,135,255,.4);
        border-radius: 50px; padding: 6px 16px; font-size: 12px; font-weight: 700;
        color: #a0b4ff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: .5px;
        }
        .ai-panel h2 { font-size: 36px; font-weight: 800; line-height: 1.2; margin-bottom: 16px; }
        .ai-panel p { font-size: 15px; color: rgba(255,255,255,.7); line-height: 1.7; margin-bottom: 28px; }
        .ai-feature-list { list-style: none; padding: 0; margin: 0 0 32px; }
        .ai-feature-list li {
        display: flex; align-items: flex-start; gap: 12px;
        font-size: 14px; color: rgba(255,255,255,.85); margin-bottom: 14px;
        }
        .ai-feature-list li .check-icon {
        width: 22px; height: 22px; background: #13DEB9; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 11px; color: #fff; margin-top: 1px;
        }
        .ai-score-widget {
        background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
        border-radius: 16px; padding: 24px;
        }
        .progress { height: 8px; border-radius: 50px; background: rgba(255,255,255,.1); }
        .progress-bar { border-radius: 50px; }

        /* ---- Pricing ---- */
        .pricing-section { padding: 80px 0; background: #f6f9fc; }
        .plan-card {
        background: #fff; border-radius: 20px; padding: 32px 28px;
        border: 2px solid #eef0f4; height: 100%;
        display: flex; flex-direction: column;
        transition: all .3s;
        }
        .plan-card:hover { box-shadow: 0 20px 60px rgba(93,135,255,.14); transform: translateY(-4px); }
        .plan-card.featured {
        border-color: var(--bs-primary);
        background: linear-gradient(135deg, #ECF2FF 0%, #fff 100%);
        box-shadow: 0 20px 60px rgba(93,135,255,.2);
        }
        .plan-badge {
        display: inline-block; background: var(--bs-primary); color: #fff;
        font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 50px;
        margin-left: 8px; text-transform: uppercase; letter-spacing: .3px;
        }
        .plan-price { font-size: 40px; font-weight: 800; color: var(--bs-primary); line-height: 1; }
        .plan-price span { font-size: 14px; font-weight: 500; color: #5a6a85; }
        .plan-features { list-style: none; padding: 0; margin: 20px 0 28px; flex: 1; }
        .plan-features li {
        display: flex; align-items: center; gap: 10px;
        font-size: 14px; color: #2a3547; padding: 7px 0;
        border-bottom: 1px solid #f6f9fc;
        }
        .plan-features li .ti-circle-check { color: #13DEB9; font-size: 16px; }
        .plan-features li .ti-circle-x { color: #cdd5e0; font-size: 16px; }
        .plan-features li.muted { color: #adb5bd; }

        /* ---- Testimonials ---- */
        .testimonials-section { padding: 80px 0; background: #fff; }
        .testimonial-card {
        background: #f6f9fc; border-radius: 16px; padding: 28px 24px;
        border: 1px solid #eef0f4; height: 100%; position: relative;
        }
        .quote-mark {
        position: absolute; top: 16px; right: 20px;
        width: 36px; height: 36px; background: var(--bs-primary); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px;
        }
        .testimonial-card p { font-size: 14px; color: #5a6a85; line-height: 1.7; margin-bottom: 20px; font-style: italic; }
        .reviewer-name { font-size: 14px; font-weight: 700; color: #2a3547; margin: 0; }
        .reviewer-title { font-size: 12px; color: #8898aa; }
        .stars { color: #FFAE1F; font-size: 13px; margin-bottom: 14px; }

        /* ---- CTA ---- */
        .cta-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #5D87FF 0%, #49BEFF 100%);
        position: relative; overflow: hidden;
        }
        .cta-section::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: rgba(255,255,255,.08); border-radius: 50%;
        }
        .cta-section h2 { font-size: 42px; font-weight: 800; color: #fff; margin-bottom: 16px; }
        .cta-section p { font-size: 16px; color: rgba(255,255,255,.8); margin-bottom: 32px; }
        .cta-cards-row { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
        .cta-mini-card {
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
        border-radius: 16px; padding: 24px 28px; text-align: center; color: #fff;
        flex: 1; min-width: 200px; max-width: 240px;
        transition: .3s; cursor: pointer;
        }
        .cta-mini-card:hover { background: rgba(255,255,255,.25); transform: translateY(-3px); }
        .cta-mini-card .icon { font-size: 32px; margin-bottom: 10px; }
        .cta-mini-card h5 { font-size: 16px; font-weight: 700; margin: 0 0 6px; }
        .cta-mini-card p { font-size: 13px; opacity: .8; margin: 0; }

        /* ---- Footer ---- */
        footer { background: #1a2035; color: #fff; padding: 60px 0 0; }
        footer h6 { font-size: 13px; font-weight: 700; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 18px; }
        footer a { color: rgba(255,255,255,.65); text-decoration: none; font-size: 14px; transition: .2s; display: block; margin-bottom: 10px; }
        footer a:hover { color: #fff; padding-left: 4px; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding: 20px 0; margin-top: 40px; }
        .social-icons a {
        width: 36px; height: 36px; border-radius: 8px;
        background: rgba(255,255,255,.08); color: rgba(255,255,255,.6);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 16px; margin-right: 8px; transition: .2s; text-decoration: none;
        }
        .social-icons a:hover { background: var(--bs-primary); color: #fff; }

        /* ---- Whatsapp floating ---- */
        .whatsapp-float {
        position: fixed; bottom: 28px; right: 28px; z-index: 9999;
        width: 52px; height: 52px; border-radius: 50%;
        background: #25d366; color: #fff; font-size: 24px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(37,211,102,.35); cursor: pointer;
        text-decoration: none; transition: .3s;
        }
        .whatsapp-float:hover { transform: scale(1.1); color: #fff; }
        .whatsapp-tooltip {
        position: fixed; bottom: 88px; right: 28px; z-index: 9998;
        background: #fff; border-radius: 12px; padding: 12px 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,.1); font-size: 13px; font-weight: 500;
        max-width: 200px; display: none;
        }
        .whatsapp-float:hover + .whatsapp-tooltip,
        .whatsapp-tooltip:hover { display: block; }

        /* ---- Scroll to top ---- */
        .scroll-top {
        position: fixed; bottom: 28px; left: 28px; z-index: 9999;
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--bs-primary); color: #fff; font-size: 18px;
        display: none; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(93,135,255,.3); cursor: pointer;
        border: none;
        }
        .scroll-top.show { display: flex; }

        /* Trusted by logos */
        .logos-strip { padding: 40px 0; background: #fff; border-bottom: 1px solid #eef0f4; }
        .logos-strip p { font-size: 13px; color: #8898aa; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 20px; }
        .partner-logo {
        display: inline-flex; align-items: center; gap: 8px;
        background: #f6f9fc; border: 1px solid #eef0f4;
        border-radius: 10px; padding: 10px 20px; margin: 6px;
        font-size: 14px; font-weight: 700; color: #5a6a85;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
        .hero-title { font-size: 34px; }
        .section-title { font-size: 28px; }
        .plan-card { margin-bottom: 20px; }
        .ai-panel { padding: 28px 20px; }
        .ai-panel h2 { font-size: 26px; }
        }

        /* Tag pills */
        .tag-pill {
        display: inline-block; background: var(--bs-primary-subtle);
        color: var(--bs-primary); font-size: 12px; font-weight: 600;
        padding: 3px 10px; border-radius: 50px; margin: 2px;
        }
        .tag-pill.green { background: rgba(19,222,185,.1); color: #13DEB9; }
        .tag-pill.orange { background: rgba(255,174,31,.1); color: #FFAE1F; }
        .tag-pill.red { background: rgba(250,137,107,.1); color: #FA896B; }
    </style>
</head>
<body>

    <!-- navigation  -->
    @include('layouts.nav-bar')
    <!-- end navigation -->

    @yield('home-content')

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-3">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ getFavicon() }}" alt="homepage" class="dark-logo" style="width: 20px; height: auto;" />
                        <span style="font-size:18px;font-weight:800;">{{__('Stardena')}} <span style="color:var(--bs-primary);">{{__('Works')}}</span></span>
                    </div>
                    <p style="font-size:14px;color:rgba(255,255,255,.55);line-height:1.7;">Connecting talent with opportunity across Uganda and Africa. Powered by AI, built for people.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#" style="background:#25d366;color:#fff;"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6>For Workers</h6>
                    <a href="/jobs">Browse Jobs</a>
                    <a href="/gigs">Quick Gigs</a>
                    <a href="/cv-builder">AI CV Builder</a>
                    <a href="/alerts">Job Alerts</a>
                    <a href="/whatsapp">Apply via WhatsApp</a>
                </div>
                <div class="col-lg-2 col-6">
                    <h6>For Employers</h6>
                    <a href="/post-job">Post a Job</a>
                    <a href="/talent">Search Talent</a>
                    <a href="/pricing">Pricing</a>
                    <a href="/ai-scanner">AI CV Scanner</a>
                    <a href="/enterprise">Enterprise</a>
                </div>
                <div class="col-lg-4">
                    <h6>Stay Updated</h6>
                    <p style="font-size:14px;color:rgba(255,255,255,.55);margin-bottom:12px;">Get job alerts and platform news in your inbox.</p>
                    <div class="input-group mb-3">
                    <input type="email" class="form-control" style="background:#2a3547;border-color:#3a4a62;color:#fff;" placeholder="your@email.com">
                    <button class="btn btn-primary">Subscribe</button>
                    </div>
                    <p style="font-size:12px;color:rgba(255,255,255,.35);">📱 Or join our WhatsApp channel for instant alerts</p>
                </div>
            </div>
            <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p style="font-size:13px;color:rgba(255,255,255,.4);margin:0;">© 2026 Stardena Works. All rights reserved. · Built in Uganda 🇺🇬</p>
                <div class="d-flex gap-3">
                    <a href="#" style="font-size:12px;color:rgba(255,255,255,.4);">Privacy Policy</a>
                    <a href="#" style="font-size:12px;color:rgba(255,255,255,.4);">Terms of Service</a>
                    <a href="#" style="font-size:12px;color:rgba(255,255,255,.4);">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/256700000000" class="whatsapp-float" title="Apply via WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    <div class="whatsapp-tooltip">
        <strong>Apply via WhatsApp</strong><br>
        <span style="color:#8898aa;">Find jobs without a data plan!</span>
    </div>

    <!-- Scroll to Top -->
    <button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="ti ti-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Scroll to top visibility
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('scrollTop');
            if (window.scrollY > 300) btn.classList.add('show');
            else btn.classList.remove('show');
        });

        // Pricing toggle
        document.getElementById('pricingToggle').addEventListener('change', function() {
            const workerPricing = document.getElementById('workerPricing');
            const employerPricing = document.getElementById('employerPricing');
            if (this.checked) {
            workerPricing.style.display = 'none';
            employerPricing.style.display = 'block';
            } else {
            workerPricing.style.display = 'block';
            employerPricing.style.display = 'none';
            }
        });

        // Smooth scroll for nav links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            });
        });

        // Animate stats counter
        function animateCounter(el, target) {
            let count = 0;
            const step = target / 60;
            const timer = setInterval(() => {
            count += step;
            if (count >= target) { count = target; clearInterval(timer); }
            el.textContent = Math.floor(count).toLocaleString() + '+';
            }, 25);
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
            if (entry.isIntersecting) {
                const nums = [15000, 2400, 8700, 500];
                document.querySelectorAll('.stat-number').forEach((el, i) => {
                animateCounter(el, nums[i]);
                });
                observer.disconnect();
            }
            });
        });
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) observer.observe(statsSection);
    </script>
    <script>
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `position-fixed bottom-0 end-0 m-3 bg-${type === 'success' ? 'success' : 'danger'} text-white px-3 py-2 rounded-3 shadow`;
            toast.style.zIndex = 9999;
            toast.style.cursor = 'pointer';
            toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-1"></i>${message}`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
</body>
</html>


