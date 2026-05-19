<!-- -------------------------------------------- -->
<!-- Header start - Hide on scroll down, show on scroll up -->
<!-- -------------------------------------------- -->
<header class="header-fp p-0 w-100 header-sticky" id="main-header">
  <nav class="navbar navbar-expand-lg" style="padding:12px 0; min-height: auto;">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="/" style="flex-shrink: 0;">
        <img src="{{ getFavicon() }}" alt="logo" style="width:22px;height:auto;"/>
        <span style="font-size:20px;font-weight:700;letter-spacing:-.3px;color:#2a3547; white-space: nowrap;">
          {{__('Stardena')}} <span style="color:var(--bs-primary);">{{__('Works')}}</span>
        </span>
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler border-0 p-1 shadow-none mobile-menu-button" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" style="flex-shrink: 0;">
        <i class="bi bi-list" style="font-size:22px;color:var(--bs-primary);"></i>
      </button>

      <!-- Desktop Menu -->
      <div class="collapse navbar-collapse desktop-menu" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-0 gap-1">
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="{{ route('jobs.index') }}">Find Jobs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="{{ route('companies') }}">Companies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link d-flex align-items-center gap-1" href="{{ route('seeker.dashboard') }}">
              CV Enhancement
              <span style="background:rgba(var(--bs-primary-rgb),.15);border:1px solid rgba(var(--bs-primary-rgb),.3);color:var(--bs-primary);font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;">New</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="javascript:void(0)" onclick="comingSoon()">Post a Job</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="javascript:void(0)" onclick="comingSoon()">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="{{ route('blog.index') }}">Blogs</a>
          </li>
        </ul>

        @if(!session('web_user'))
        <div class="d-flex gap-2 align-items-center">
          <a href="{{ route('login.register') }}?tab=register"
            style="font-size:13px;font-weight:600;padding:7px 18px;border-radius:8px;background:rgba(var(--bs-primary-rgb),.08);border:1px solid rgba(var(--bs-primary-rgb),.2);color:var(--bs-primary);text-decoration:none;transition:all .15s; white-space: nowrap;"
            onmouseover="this.style.background='rgba(var(--bs-primary-rgb),.15)';this.style.borderColor='rgba(var(--bs-primary-rgb),.4)'"
            onmouseout="this.style.background='rgba(var(--bs-primary-rgb),.08)';this.style.borderColor='rgba(var(--bs-primary-rgb),.2)'">Sign Up</a>
          <a href="{{ route('login.register') }}?tab=login"
            style="font-size:13px;font-weight:600;padding:7px 18px;border-radius:8px;background:var(--bs-primary);border:none;color:#fff;text-decoration:none; white-space: nowrap;transition:all .15s;"
            onmouseover="this.style.opacity='0.9'"
            onmouseout="this.style.opacity='1'">Log In</a>
        </div>
        @endif

        @if(session('web_user'))
        <div class="dropdown">
          <button class="dropdown-toggle d-flex align-items-center gap-2" style="background:rgba(var(--bs-primary-rgb),.08);border:1px solid rgba(var(--bs-primary-rgb),.2);border-radius:40px;padding:5px 12px 5px 8px;color:#2a3547;font-size:13px;font-weight:500;" data-bs-toggle="dropdown">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:28px;height:28px;background:var(--bs-primary);">
              <span style="font-size:12px;font-weight:600;color:#fff;">{{ strtoupper(substr(session('web_user.first_name', 'U'), 0, 1)) }}{{ strtoupper(substr(session('web_user.last_name', ''), 0, 1)) }}</span>
            </div>
            <span>{{ session('web_user.first_name') }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('seeker.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)" onclick="comingSoon()"><i class="bi bi-person"></i> My Profile</a></li>
            @if(session('web_user.role') === 'employer')
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)" onclick="comingSoon()"><i class="bi bi-briefcase"></i> My Jobs</a></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)" onclick="comingSoon()"><i class="bi bi-plus-circle"></i> Post a Job</a></li>
            @endif
            @if(session('web_user.role') === 'job_seeker')
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)" onclick="comingSoon()"><i class="bi bi-file-text"></i> My Applications</a></li>
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0)" onclick="comingSoon()"><i class="bi bi-bookmark"></i> Saved Jobs</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('web.logout') }}" id="logout-form-desktop">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
              </form>
            </li>
          </ul>
        </div>
        @endif
      </div>

    </div>
  </nav>
</header>

<!-- Spacer to prevent content jump when header hides -->
<div id="header-spacer" style="display: block; width: 100%;"></div>

<!-- -------------------------------------------- -->
<!-- Mobile Offcanvas -->
<!-- -------------------------------------------- -->
<div class="offcanvas offcanvas-end mobile-offcanvas" tabindex="-1" id="offcanvasRight">
  <div class="offcanvas-header">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
      <img src="{{ getFavicon() }}" alt="logo" style="width:22px;height:auto;"/>
      <span style="font-size:20px;font-weight:700;color:#2a3547;">
        {{__('Stardena')}} <span style="color:var(--bs-primary);">{{__('Works')}}</span>
      </span>
    </a>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <!-- User Profile Section for Mobile -->
    @if(session('web_user'))
    <div class="mb-4 pb-3 border-bottom">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:var(--bs-primary);">
          <span class="fw-bold fs-5 text-white">
            {{ strtoupper(substr(session('web_user.first_name', 'U'), 0, 1)) }}
            {{ strtoupper(substr(session('web_user.last_name', ''), 0, 1)) }}
          </span>
        </div>
        <div class="flex-grow-1">
          <div class="fw-semibold">{{ session('web_user.full_name') ?? session('web_user.first_name') . ' ' . session('web_user.last_name') }}</div>
          <small class="text-muted">{{ session('web_user.email') }}</small>
          <div class="mt-1">
            <span class="badge" style="background:rgba(var(--bs-primary-rgb),.15);color:var(--bs-primary);">{{ ucwords(str_replace('_', ' ', session('web_user.role', 'user'))) }}</span>
          </div>
        </div>
      </div>
    </div>
    @endif

    <ul class="list-unstyled ps-0">
      <li class="mb-1"><a href="{{ route('jobs.index') }}" target="_blank" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;">Find Jobs</a></li>
      <li class="mb-1"><a href="{{ route('companies') }}" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;">Companies</a></li>
      <li class="mb-1">
        <a href="{{ route('seeker.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;">
          CV Enhancement
          <span style="background:rgba(var(--bs-primary-rgb),.15);border:1px solid rgba(var(--bs-primary-rgb),.3);color:var(--bs-primary);font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;">New</span>
        </a>
      </li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;">Post a Job</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;">Pricing</a></li>
      <li class="mb-1"><a href="{{ route('blog.index') }}" target="_blank" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;">Blogs</a></li>
      
      @if(session('web_user'))
      <!-- Dashboard Links for Mobile -->
      <li class="mt-3 pt-2 border-top">
        <div class="small text-muted px-3 mb-2">ACCOUNT</div>
      </li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;"><i class="bi bi-person"></i> My Profile</a></li>
      @if(session('web_user.role') === 'employer')
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;"><i class="bi bi-briefcase"></i> My Jobs</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;"><i class="bi bi-plus-circle"></i> Post a Job</a></li>
      @endif
      @if(session('web_user.role') === 'job_seeker')
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;"><i class="bi bi-file-text"></i> My Applications</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:#2a3547;"><i class="bi bi-bookmark"></i> Saved Jobs</a></li>
      @endif
      <li class="mt-3">
        <form method="POST" action="{{ route('web.logout') }}" id="logout-form-mobile">
          @csrf
          <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center gap-2" style="background:rgba(220,53,69,.1);border:1px solid rgba(220,53,69,.3);color:#dc3545;font-size:14px;font-weight:600;padding:10px;border-radius:8px;">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
      </li>
      @else
      <!-- Auth Buttons for Mobile -->
      <li class="mt-4">
          <a href="{{ route('login.register') }}?tab=login"
            class="d-block text-center text-white text-decoration-none py-2 rounded-3 fw-600"
            style="background:var(--bs-primary);font-size:14px;font-weight:600;">Log In</a>
      </li>
      <li class="mt-2">
          <a href="{{ route('login.register') }}?tab=register"
            class="d-block text-center text-decoration-none py-2 rounded-3"
            style="background:rgba(var(--bs-primary-rgb),.08);border:1px solid rgba(var(--bs-primary-rgb),.2);color:var(--bs-primary);font-size:14px;font-weight:600;">Sign Up</a>
      </li>
      @endif
    </ul>
  </div>
</div>

<!-- Coming Soon Modal -->
<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="width:60px;height:60px;border-radius:16px;background:rgba(var(--bs-primary-rgb),.15);border:1px solid rgba(var(--bs-primary-rgb),.3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
          <i class="bi bi-tools" style="font-size:1.5rem;color:var(--bs-primary);"></i>
        </div>
        <h5 class="fw-bold mb-2">Coming Soon!</h5>
        <p style="color:#6c757d;font-size:14px;margin:0;">We're working hard to bring you this feature. Stay tuned!</p>
      </div>
      <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
        <button type="button" class="btn btn-sm px-4" data-bs-dismiss="modal"
                style="background:var(--bs-primary);color:#fff;border:none;border-radius:8px;padding:8px 24px;font-weight:600;">Got it</button>
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
<script>
  // ── Active nav highlighting ──────────────────────────────
  (function () {
    const current = window.location.pathname;

    document.querySelectorAll('.navbar-nav .nav-link, .mobile-offcanvas .list-unstyled a').forEach(link => {
      try {
        const linkPath = new URL(link.href, window.location.origin).pathname;

        // Exact match OR starts-with for sub-routes (e.g. /jobs/some-slug highlights Find Jobs)
        const isActive = linkPath !== '/' && current.startsWith(linkPath)
                      || linkPath === '/' && current === '/';

        if (isActive) {
          link.classList.add('active-nav');
        }
      } catch (_) {}
    });
  })();
</script>

<style>
  /* ── Desktop nav active link ── */
  .navbar-nav .nav-link.active-nav {
    color: var(--bs-primary) !important;
    font-weight: 600;
    position: relative;
  }
  .navbar-nav .nav-link.active-nav::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 24px;
    height: 3px;
    background: var(--bs-primary);
    border-radius: 99px;
  }

  /* ── Mobile offcanvas active link ── */
  .mobile-offcanvas .list-unstyled a.active-nav {
    color: var(--bs-primary) !important;
    font-weight: 600;
    border-left: 3px solid var(--bs-primary);
    padding-left: 10px !important;
    background: rgba(var(--bs-primary-rgb), 0.05);
    border-radius: 0 8px 8px 0;
  }
</style>
<script>

  function comingSoon() {
    const modalElement = document.getElementById('comingSoonModal');
    if (modalElement) {
      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    } else {
      alert('Coming Soon!!');
    }
  }

  // Logout confirmation for both desktop and mobile
  document.getElementById('logout-form-desktop')?.addEventListener('submit', function(e) {
    if (!confirm('Are you sure you want to logout?')) {
      e.preventDefault();
    }
  });
  
  document.getElementById('logout-form-mobile')?.addEventListener('submit', function(e) {
    if (!confirm('Are you sure you want to logout?')) {
      e.preventDefault();
    }
  });
</script>