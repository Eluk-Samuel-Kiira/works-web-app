<!-- -------------------------------------------- -->
<!-- Header start -->
<!-- -------------------------------------------- -->
<header class="header-fp p-0 w-100 bg-primary-subtle header-sticky" style="padding:0!important" id="main-header">
  <nav class="navbar navbar-expand-lg py-10">
    <div class="container-fluid d-flex justify-content-between">
      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="{{ getFavicon() }}" alt="loader" style="width: 24px; height: auto;"/>
        <span style="font-size:25px;font-weight:700;color:#2a3547;">{{__('Stardena')}} <span style="color:var(--bs-primary);">{{__('Works')}}</span></span>
      </a>

      <!-- Mobile Toggle Button - Only visible on mobile -->
      <button class="navbar-toggler border-0 p-0 shadow-none mobile-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <i class="bi bi-list text-primary" style="font-size: 24px;"></i>
      </button>

      <!-- Desktop Menu - Hidden on mobile -->
      <div class="collapse navbar-collapse desktop-menu" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 gap-xl-7 gap-8 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link fs-4 text-dark link-primary px-6" href="{{ route('jobs.index') }}">Find Jobs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-4 text-dark link-primary px-6" href="/coming-soon" onclick="comingSoon()">Companies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-4 text-dark link-primary px-6 d-flex gap-2" href="/coming-soon" onclick="comingSoon()">Career Advice
              <span class="badge text-white bg-primary fs-2 fw-semibold hstack">New</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-4 text-dark link-primary px-6" href="/coming-soon" onclick="comingSoon()">Post a Job</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-4 text-dark link-primary px-6" href="/coming-soon" onclick="comingSoon()">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-4 text-dark link-primary px-6" href="/coming-soon" onclick="comingSoon()">Contact</a>
          </li>
        </ul>
        <div class="d-flex gap-3">
          <a href="/coming-soon" onclick="comingSoon()" class="btn btn-outline-primary">Sign Up</a>
          <a href="/coming-soon" onclick="comingSoon()" class="btn btn-primary">Log In</a>
        </div>
      </div>
    </div>
  </nav>
</header>
<!-- -------------------------------------------- -->
<!-- Header End -->
<!-- -------------------------------------------- -->

<!-- ------------------------------------- -->
<!-- Responsive Header Start - Mobile Only -->
<!-- ------------------------------------- -->
<div class="offcanvas offcanvas-end mobile-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
      <img src="{{ getFavicon() }}" alt="loader" style="width: 24px; height: auto;"/>
      <span style="font-size:25px;font-weight:700;color:#2a3547;">{{__('Stardena')}} <span style="color:var(--bs-primary);">{{__('Works')}}</span></span>
    </a>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <a href="{{ route('jobs.index') }}" class="px-0 fs-4 d-block text-dark link-primary w-100 py-2">Find Jobs</a>
      </li>
      <li class="mb-1">
        <a href="/coming-soon" onclick="comingSoon()" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">Companies</a>
      </li>
      <li class="mb-1">
        <a href="/coming-soon" onclick="comingSoon()" class="px-0 fs-4 d-flex align-items-center justify-content-start gap-2 w-100 py-2 text-dark link-primary">
          Career Advice
          <span class="badge text-white bg-primary fs-2 fw-semibold hstack">New</span>
        </a>
      </li>
      <li class="mb-1">
        <a href="/coming-soon" onclick="comingSoon()" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">Post a Job</a>
      </li>
      <li class="mb-1">
        <a href="/coming-soon" onclick="comingSoon()" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">Pricing</a>
      </li>
      <li class="mb-1">
        <a href="/coming-soon" onclick="comingSoon()" class="px-0 fs-4 d-block w-100 py-2 text-dark link-primary">Contact</a>
      </li>
      <li class="mt-3">
        <a href="/coming-soon" onclick="comingSoon()" class="btn btn-primary w-100">Log In</a>
      </li>
      <li class="mt-2">
        <a href="/coming-soon" onclick="comingSoon()" class="btn btn-outline-primary w-100">Sign Up</a>
      </li>
    </ul>
  </div>
</div>
<!-- ------------------------------------- -->
<!-- Responsive Header End -->
<!-- ------------------------------------- -->

<!-- Coming Soon Modal -->
<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-labelledby="comingSoonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div class="mb-3">
          <i class="bi bi-tools fs-1 text-primary" style="font-size: 48px;"></i>
        </div>
        <h5 class="modal-title fs-4 fw-semibold mb-2" id="comingSoonModalLabel">Coming Soon!</h5>
        <p class="text-secondary mb-0">We're working hard to bring you this feature. Stay tuned for updates!</p>
      </div>
      <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Got it</button>
      </div>
    </div>
  </div>
</div>

<style>
  /* ── Sticky header with proper positioning ── */
  .header-fp.header-sticky {
    position: sticky;
    top: 0;
    z-index: 1030;
    background-color: var(--bs-primary-bg-subtle);
  }
  
  /* ── Reduce header height ── */
  .header-fp.header-sticky,
  .header-fp.header-sticky .navbar {
    min-height: unset !important;
    height: auto !important;
    padding-top: 6px !important;
    padding-bottom: 6px !important;
  }
  
  .header-fp.header-sticky .navbar .nav-link {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
  }

  /* ── Main content wrapper - NO extra padding, just scroll normally ── */
  .main-wrapper {
    padding-top: 0 !important;
  }

  @media (min-width: 992px) {
    .mobile-menu-button { display: none !important; }
    .desktop-menu { display: flex !important; }
    .mobile-offcanvas { display: none !important; }
  }
  
  @media (max-width: 991.98px) {
    .mobile-menu-button { display: block !important; }
    .desktop-menu { display: none !important; }
  }
</style>

<script>
  (function() {
    // Add scroll margin to the first element after header to prevent overlap
    function addScrollMargin() {
      const header = document.getElementById('main-header');
      const mainWrapper = document.querySelector('.main-wrapper');
      
      if (header && mainWrapper) {
        // Get the first child element inside main-wrapper
        const firstElement = mainWrapper.firstElementChild;
        
        if (firstElement) {
          // Add scroll-margin-top to the first element
          firstElement.style.scrollMarginTop = header.offsetHeight + 'px';
          
          // Also add a small negative margin to the first element to pull it up
          // This prevents white space while keeping content accessible
          if (window.scrollY === 0) {
            firstElement.style.marginTop = '0';
          }
        }
      }
    }
    
    // Run on load
    window.addEventListener('load', addScrollMargin);
    window.addEventListener('resize', addScrollMargin);
    setTimeout(addScrollMargin, 100);
  })();

  function comingSoon() {
    // Initialize modal if not already initialized
    const modalElement = document.getElementById('comingSoonModal');
    if (modalElement) {
      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    } else {
      // Fallback alert if modal not found
      alert('Coming Soon!!');
    }
  }
</script>