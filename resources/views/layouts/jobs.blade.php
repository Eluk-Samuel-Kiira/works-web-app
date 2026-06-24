<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VT1BQTKZZ5"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-VT1BQTKZZ5');
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SVWSLQ2GVZ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-SVWSLQ2GVZ');
    </script>


    <!-- Google Adsense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3587587638253109"
     crossorigin="anonymous"></script>



    <!-- monetag -->
    <meta name="monetag" content="b5705ff2a229e3bee594236644171e88">
    <script src="https://5gvci.com/act/files/tag.min.js?z=11176707" data-cfasync="false" async></script>

    <!-- pop under OnClick (Popunder) -->
    <!-- <script>(function(s){s.dataset.zone='11176761',s.src='https://al5sm.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script> -->

    <!-- modals on screen and top right  -->
    <!-- <script>(function(s){s.dataset.zone='11176879',s.src='https://nap5k.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
    <script>(function(s){s.dataset.zone='11176882',s.src='https://n6wxm.com/vignette.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script> -->
    

    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ getFavicon() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ web_asset('front/css/styles.css') }}" />

    <title>@yield('title', 'Stardena Works — Jobs in Uganda & East Africa | Free CV Builder')</title>
    <meta name="description" content="@yield('meta_description', 'Find jobs in Uganda, Kenya, Tanzania, Rwanda, DRC & East Africa. Free CV builder — create a professional CV online in minutes. Apply today on Stardena Works.')">    <meta name="robots"             content="@yield('robots', 'index, follow')">
    <link rel="canonical"           href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('og_title', 'Stardena Works — Jobs & Free CV Builder for Africa')">
    <meta property="og:description" content="@yield('og_description', 'Search jobs across Uganda, Kenya, Tanzania, Rwanda, DRC & Africa. Free CV builder included.')">
    <meta property="og:url"         content="@yield('canonical', url()->current())">
    <meta property="og:image"       content="@yield('og_image', getFavicon())">
    <meta property="og:site_name"   content="Stardena Works">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('og_title', 'Stardena Works — Jobs & Free CV Builder for Africa')">
    <meta name="twitter:description" content="@yield('og_description', 'Search jobs across Uganda, Kenya, Tanzania, Rwanda, DRC & Africa. Free CV builder included.')">
    <meta name="twitter:image"       content="@yield('og_image', getFavicon())">

    @yield('schema')

    {{-- Keywords --}}
    <meta name="keywords" content="jobs in Uganda, Uganda jobs, job vacancies Uganda, jobs Kampala, jobs in Kenya, Nairobi jobs, jobs in Tanzania, jobs in Rwanda, jobs in DRC, Congo jobs, jobs in Zambia, jobs in Zimbabwe, East Africa jobs, Central Africa jobs, Southern Africa jobs, free CV builder Uganda, CV builder Africa, free CV maker East Africa, professional CV template Uganda, ATS friendly CV Africa, resume builder East Africa, CV builder Kenya, CV builder Tanzania, CV builder Rwanda, build CV online Africa, free resume maker Africa">

    {{-- Geo targeting --}}
    <meta name="geo.region"    content="UG">
    <meta name="geo.placename" content="Uganda, East Africa, Central Africa, Southern Africa">
    <meta name="geo.position"  content="1.3733;32.2903">
    <meta name="ICBM"          content="1.3733, 32.2903">

    {{-- OG locale --}}
    <meta property="og:locale"                 content="en_UG">
    <meta property="og:locale:alternate"       content="en_KE">
    <meta property="og:locale:alternate"       content="en_TZ">
    <meta property="og:locale:alternate"       content="en_RW">
    <meta property="og:locale:alternate"       content="en_ZM">
    <meta property="og:locale:alternate"       content="en_ZW">
    <meta property="og:site_name"              content="Stardena Works">

    <!-- Owl Carousel  -->
    <link  href="{{ web_asset('front/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
    <!-- Bootstrap Icons -->    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      /* Reusing styles from the listing page */
      .job-card {
        transition: all 0.2s ease;
        border: 1px solid transparent;
      }
      .job-card:hover {
        border-color: var(--bs-primary);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      }
      .company-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(var(--bs-primary-rgb), 0.1);
        border-radius: 12px;
      }
      .company-icon-large {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(var(--bs-primary-rgb), 0.1);
        border-radius: 16px;
      }
      .job-type-badge {
        background: rgba(var(--bs-primary-rgb), 0.05);
        color: var(--bs-primary);
        font-weight: 500;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
      }
      .info-item-compact {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 10px;
        text-align: center;
      }
      .info-item-compact i {
        font-size: 1.25rem;
      }
      .info-item-compact h5 {
        font-size: 1rem;
        margin-top: 4px !important;
        margin-bottom: 0 !important;
      }
      .info-item-compact p {
        font-size: 0.7rem;
      }
      .benefit-item-compact {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
      }
      .benefit-item-compact i {
        font-size: 1.25rem;
      }
      .benefit-item-compact h6 {
        font-size: 0.9rem;
        margin-bottom: 2px;
      }
      .benefit-item-compact p {
        font-size: 0.7rem;
      }
      .similar-job-card-compact {
        transition: all 0.2s ease;
        border: 1px solid #eef0f2;
        text-decoration: none;
        display: block;
        padding: 12px !important;
      }
      .similar-job-card-compact:hover {
        border-color: var(--bs-primary);
        transform: translateY(-2px);
      }
      .similar-job-card-compact .company-icon {
        width: 40px;
        height: 40px;
      }
      .similar-job-card-compact h6 {
        font-size: 0.9rem;
        margin-bottom: 2px;
      }
      .similar-job-card-compact .text-muted.small {
        font-size: 0.75rem;
      }
      .similar-job-card-compact .badge {
        font-size: 0.65rem;
        padding: 2px 8px;
      }
      .similar-job-card-compact .text-primary.small {
        font-size: 0.75rem;
      }

      /* Sticky sidebar */
      .sticky-sidebar {
        position: sticky;
        top: 20px;
      }

      /* Mobile menu fix */
      .navbar-toggler {
        display: block !important;
      }
      @media (max-width: 991px) {
        .navbar-collapse {
          display: none;
        }
        .offcanvas {
          visibility: visible !important;
        }
      }

      /* Card padding optimization */
      .card-compact {
        padding: 1.25rem !important;
      }
      .card-compact-sm {
        padding: 1rem !important;
      }
    </style>

</head>

<body style="background: #fffbeb;">
    <div class="costom-logo-fp preloader">
          <img src="{{ getFavicon() }}" alt="loader" class="lds-ripple img-fluid" />
    </div>

  <!-- ------------------------------------- -->
  <!-- Top Bar Start -->
  <!-- ------------------------------------- -->
  {{--
  <div class="topbar-image bg-primary py-8  rounded-0 mb-0 alert alert-dismissible fade show" role="alert">
      <div class="d-flex justify-content-center gap-sm-2 gap-1 align-items-center text-center flex-md-nowrap flex-wrap">
          <span class="badge bg-white bg-opacity-10 fw-semibold px-2" style="font-size:11px">{{__('New')}}</span>
          <p class="mb-0 text-white" style="font-size:13px">{{__('This is Breaking News')}}</p>
      </div>
      <button type="button" class="btn-close btn-close-white p-2" style="font-size:10px" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  --}}



  <!-- ------------------------------------- -->
  <!-- Top Bar End -->
  <!-- ------------------------------------- -->

  <!-- navigation  -->
  @include('layouts.nav-header')
  <!-- end navigation -->

  @yield('job-content')
  @include('layouts.social-media')

  {{-- Login Required Modal --}}
  <div class="modal fade" id="loginChoiceModal" tabindex="-1" aria-hidden="true">
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

  
  <!-- ------------------------------------- -->
  <!-- Footer Start - Compact -->
  <!-- ------------------------------------- -->
  <footer class="bg-dark">
    <div class="container-fluid">
      <div class="row py-5">
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">For Job Seekers</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="/jobs" class="text-light small">Browse Jobs</a></li>
            <li class="mb-2"><a href="/jobs/#job-category" class="text-light small">Categories</a></li>
            <li class="mb-2">
              <a href="{{ route('seeker.dashboard') }}?tab=settings" class="text-light small">
                <i class="bi bi-bell me-1"></i> Job Alerts
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">For Employers</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="{{ route('featured.addons') }}" class="text-light small">Post a Job</a></li>
            <li class="mb-2"><a href="{{ route('featured.addons') }}" class="text-light small">Pricing</a></li>
            <li class="mb-2"><a href="/jobs"  class="text-light small">Resources</a></li>
            <li class="mb-2"><a href="blog.index"  class="text-light small">Blogs</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">Company</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="{{ route('about') }}" class="text-light small">About Us</a></li>
            <li class="mb-2"><a href="{{ route('contact') }}" class="text-light small">Contact</a></li>
            <li class="mb-2"><a href="{{ route('privacy-policy') }}" class="text-light small">Privacy</a></li>
            <li class="mb-2"><a href="{{ route('terms-of-service') }}" class="text-light small">Terms</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">Follow Us</h6>
          <div class="d-flex gap-3">
            <a href="https://www.linkedin.com/company/126473897/" 
              target="_blank" 
              rel="noopener noreferrer" 
              class="text-light"
              title="Follow us on LinkedIn">
              <i class="bi bi-linkedin fs-5"></i>
            </a>
            <a href="https://x.com/stardena_works" 
              target="_blank" 
              rel="noopener noreferrer" 
              class="text-light"
              title="Follow us on X">
              <i class="bi bi-twitter-x fs-5"></i>
            </a>
            <a href="https://www.facebook.com/profile.php?id=61590522782942" 
              target="_blank" 
              rel="noopener noreferrer" 
              class="text-light"
              title="Follow us on Facebook">
              <i class="bi bi-facebook fs-5"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="text-center py-3 border-top border-secondary">
        <p class="text-light small mb-0">
          By<a href="https://stardena.org/" target="_blank" class="text-light"> Stardena</a>
        </p>
      </div>
    </div>
  </footer>
  <!-- ------------------------------------- -->
  <!-- Footer End -->
  <!-- ------------------------------------- -->


  <script>
    function signupToBegin() {
      // Check if user is already logged in
      const isLoggedIn = {{ session()->has('web_user') ? 'true' : 'false' }};
      
      if (isLoggedIn) {
        // Already logged in - go to dashboard
        window.location.href = '{{ route("seeker.dashboard") }}';
      } else {
        // Not logged in - show login/register modal
        const loginModal = new bootstrap.Modal(document.getElementById('loginChoiceModal'));
        loginModal.show();
      }
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Check URL parameter for tab
        const urlParams = new URLSearchParams(window.location.search);
        const tabToOpen = urlParams.get('tab');
        
        if (tabToOpen) {
            // Find the button that controls the tab
            const targetButton = document.querySelector(`#dashboardTabs button[data-bs-target="#${tabToOpen}"]`);
            
            if (targetButton) {
                // Use Bootstrap's Tab API to activate the tab
                const tab = new bootstrap.Tab(targetButton);
                tab.show();
                
                // Update URL without reload to remove the parameter
                const newUrl = window.location.pathname;
                window.history.replaceState({}, '', newUrl);
            }
        }
    });
  </script>

  <style>
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
  </style>


  <!-- Social Media Float Button -->
  <style>
  @keyframes wa-pulse {
      0%   { box-shadow: 0 0 0 0 rgba(93,135,255,0.5); }
      70%  { box-shadow: 0 0 0 16px rgba(93,135,255,0); }
      100% { box-shadow: 0 0 0 0 rgba(93,135,255,0); }
  }
  @keyframes ring-outer {
      0%   { box-shadow: 0 0 0 0 rgba(93,135,255,0.3), 0 0 0 0 rgba(93,135,255,0.15); }
      70%  { box-shadow: 0 0 0 18px rgba(93,135,255,0), 0 0 0 32px rgba(93,135,255,0); }
      100% { box-shadow: 0 0 0 0 rgba(93,135,255,0.3), 0 0 0 0 rgba(93,135,255,0.15); }
  }
  </style>

  <button onclick="openSocialModal()"
      style="position:fixed;bottom:24px;right:24px;width:56px;height:56px;border-radius:50%;
            background:var(--bs-primary);border:none;
            display:flex;align-items:center;justify-content:center;z-index:1000;
            cursor:pointer;animation:ring-outer 2.2s infinite;
            box-shadow:0 4px 20px rgba(93,135,255,.45);">
      <i class="bi bi-share-fill text-white" style="font-size:1.35rem;"></i>
  </button>
  
  <button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
      <i class="bi bi-arrow-up"></i>
  </button>

  <script>
    // Scroll to top visibility
    window.addEventListener('scroll', function() {
        const btn = document.getElementById('scrollTop');
        if (window.scrollY > 300) btn.classList.add('show');
        else btn.classList.remove('show');
    });
    
  </script>

  <script  src="{{ web_asset('front/js/vendor.min.js') }}"></script>
  <!-- Import Js Files -->
  <script  src="{{ web_asset('front/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script  src="{{ web_asset('front/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script  src="{{ web_asset('front/js/theme/app.init.js') }}"></script>
  <script  src="{{ web_asset('front/js/theme/theme.js') }}"></script>
  <script  src="{{ web_asset('front/js/theme/app.min.js') }}"></script>
  <script  src="{{ web_asset('front/js/theme/feather.min.js') }}"></script>

  <!-- solar icons -->
  <script  src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script  src="{{ web_asset('front/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
  <script  src="{{ web_asset('front/js/frontend-landingpage/homepage.js') }}"></script>

  <script>
    // ─── Universal Toast Function ─────────────────────────────────────────────
    function showToast(message, type = 'success') {
        if (!message) return;
        let container = document.getElementById('globalToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'globalToastContainer';
            container.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem;';
            document.body.appendChild(container);
        }
        const colors = {
            success: { bg: '#28a745', icon: '✓' },
            danger:  { bg: '#dc3545', icon: '✕' },
            warning: { bg: '#e0a800', icon: '⚠' },
            info:    { bg: '#17a2b8', icon: 'ℹ' },
        };
        const { bg, icon } = colors[type] ?? colors.success;
        const toast = document.createElement('div');
        toast.style.cssText = `
            background:${bg};color:#fff;padding:0.75rem 1rem;border-radius:0.5rem;
            box-shadow:0 0.5rem 1rem rgba(0,0,0,.2);min-width:260px;max-width:360px;
            font-size:0.875rem;cursor:pointer;animation:fadeInUp .2s ease;
        `;
        toast.innerHTML = `
            <div style="display:flex;align-items:center;gap:0.6rem;">
                <strong style="font-size:1.1rem;flex-shrink:0;">${icon}</strong>
                <span style="flex:1;">${message}</span>
                <button onclick="this.closest('[data-toast]').remove()"
                        style="background:none;border:none;color:#fff;font-size:1rem;cursor:pointer;line-height:1;">✕</button>
            </div>
        `;
        toast.dataset.toast = '';
        toast.addEventListener('click', e => {
            if (e.target.tagName !== 'BUTTON') toast.remove();
        });
        container.appendChild(toast);
        setTimeout(() => toast?.remove(), 5000);
    }

    window.toast = showToast;

    const _toastStyle = document.createElement('style');
    _toastStyle.textContent = '@keyframes fadeInUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}';
    document.head.appendChild(_toastStyle);

    // ─── DEBUG: paste this in browser console to check what Laravel rendered ──
    window.__flashDebug = {
        success: @json(session('success')),
        error:   @json(session('error')),
        warning: @json(session('warning')),
        info:    @json(session('info')),
    };
    console.log('[Flash Debug]', window.__flashDebug);

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif
        @if(session('error'))
            showToast(@json(session('error')), 'danger');
        @endif
        @if(session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif
        @if(session('info'))
            showToast(@json(session('info')), 'info');
        @endif
    });
</script>
<script>
(function fixMobileInputs() {
    // Hide preloader
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        preloader.style.display = 'none';
    }
    
    // Ensure all inputs are enabled
    function enableAllInputs() {
        const inputs = document.querySelectorAll('input, textarea, select, button');
        inputs.forEach(input => {
            input.disabled = false;
            input.readOnly = false;
            input.style.pointerEvents = 'auto';
            input.style.touchAction = 'manipulation';
        });
    }
    
    // Run immediately and after DOM changes
    enableAllInputs();
    
    // Watch for dynamically added content
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                enableAllInputs();
            }
        });
    });
    
    observer.observe(document.body, { childList: true, subtree: true });
    
    // Fix for iOS - ensure focus works
    document.body.addEventListener('touchstart', function(e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
            e.target.focus();
        }
    });
})();
</script>
</body>

</html>
