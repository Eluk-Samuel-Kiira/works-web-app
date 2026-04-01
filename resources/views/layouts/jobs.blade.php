<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ getFavicon() }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ web_asset('front/css/styles.css') }}" />

    <title>@yield('title', 'Stardena Works — Jobs in Uganda')</title>
    <meta name="description"        content="@yield('meta_description', 'Find the latest jobs in Uganda on Stardena Works.')">
    <meta name="robots"             content="@yield('robots', 'index, follow')">
    <link rel="canonical"           href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('og_title', 'Stardena Works')">
    <meta property="og:description" content="@yield('og_description', 'Find the latest jobs in Uganda on Stardena Works.')">
    <meta property="og:url"         content="@yield('canonical', url()->current())">
    <meta property="og:image"       content="@yield('og_image', asset('front/images/og-default.png'))">
    <meta property="og:site_name"   content="Stardena Works">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('og_title', 'Stardena Works')">
    <meta name="twitter:description" content="@yield('og_description', 'Find the latest jobs in Uganda on Stardena Works.')">
    <meta name="twitter:image"       content="@yield('og_image', asset('front/images/og-default.png'))">

    @yield('schema')

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ web_asset('front/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
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

<body>
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

  
  <!-- ------------------------------------- -->
  <!-- Footer Start - Compact -->
  <!-- ------------------------------------- -->
  <footer class="bg-dark">
    <div class="container-fluid">
      <div class="row py-5">
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">For Job Seekers</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Browse Jobs</a></li>
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Categories</a></li>
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Job Alerts</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">For Employers</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Post a Job</a></li>
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Pricing</a></li>
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Resources</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">Company</h6>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">About Us</a></li>
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Contact</a></li>
            <li class="mb-2"><a href="javascript:void(0);" onclick="comingSoon()" class="text-light small">Privacy</a></li>
          </ul>
        </div>
        <div class="col-md-3 col-6 mb-4 mb-md-0">
          <h6 class="fs-4 text-white fw-semibold mb-3">Follow Us</h6>
          <div class="d-flex gap-3">
            <a href="javascript:void(0);" onclick="comingSoon()" class="text-light"><i class="bi bi-linkedin"></i></a>
            <a href="javascript:void(0);" onclick="comingSoon()" class="text-light"><i class="bi bi-twitter-x"></i></a>
            <a href="javascript:void(0);" onclick="comingSoon()" class="text-light"><i class="bi bi-facebook"></i></a>
          </div>
        </div>
      </div>
      <div class="text-center py-3 border-top border-secondary">
        <p class="text-light small mb-0">
          By<a href="https://stardena.com/" target="_blank" class="text-light"> Stardena</a>
        </p>
      </div>
    </div>
  </footer>
  <!-- ------------------------------------- -->
  <!-- Footer End -->
  <!-- ------------------------------------- -->

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

  <script src="{{ web_asset('front/js/vendor.min.js') }}"></script>
  <!-- Import Js Files -->
  <script src="{{ web_asset('front/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ web_asset('front/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script src="{{ web_asset('front/js/theme/app.init.js') }}"></script>
  <script src="{{ web_asset('front/js/theme/theme.js') }}"></script>
  <script src="{{ web_asset('front/js/theme/app.min.js') }}"></script>
  <script src="{{ web_asset('front/js/theme/feather.min.js') }}"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="{{ web_asset('front/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ web_asset('front/js/frontend-landingpage/homepage.js') }}"></script>
</body>

</html>
