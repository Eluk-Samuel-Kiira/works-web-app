<!-- -------------------------------------------- -->
<!-- Header start - Hide on scroll down, show on scroll up -->
<!-- -------------------------------------------- -->
<header class="header-fp p-0 w-100 header-sticky" id="main-header">
  <nav class="navbar navbar-expand-lg" style="padding:12px 0; min-height: auto;">
    <div class="container d-flex justify-content-between align-items-center">

      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="/" style="flex-shrink: 0;">
        <img src="{{ getFavicon() }}" alt="logo" style="width:22px;height:auto;"/>
        <span style="font-size:17px;font-weight:700;letter-spacing:-.3px;color:#fff; white-space: nowrap;">
          {{__('Stardena')}} <span style="background:linear-gradient(135deg,#818cf8,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{__('Works')}}</span>
        </span>
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler border-0 p-1 shadow-none mobile-menu-button" type="button"
              data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" style="flex-shrink: 0;">
        <i class="bi bi-list" style="font-size:22px;color:#818cf8;"></i>
      </button>

      <!-- Desktop Menu -->
      <div class="collapse navbar-collapse desktop-menu" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-0 gap-1">
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="{{ route('jobs.index') }}" target="_blank">Find Jobs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="{{ route('companies') }}">Companies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link d-flex align-items-center gap-1" href="{{ route('seeker.dashboard') }}">
              CV Enhancement
              <span style="background:rgba(79,110,247,.2);border:1px solid rgba(79,110,247,.4);color:#818cf8;font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;">New</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="javascript:void(0)" onclick="comingSoon()">Post a Job</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="javascript:void(0)" onclick="comingSoon()">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="{{ route('blog.index') }}" target="_blank">Blogs</a>
          </li>
        </ul>

        @if(!session('web_user'))
        <div class="d-flex gap-2 align-items-center">
          <a href="{{ route('login.register') }}?tab=register"
            class="btn-signup"
            style="font-size:13px;font-weight:600;padding:7px 18px;border-radius:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:#fff;text-decoration:none;transition:background .15s,border-color .15s; white-space: nowrap;">
            Sign Up
          </a>
          <a href="{{ route('login.register') }}?tab=login"
            class="btn-login"
            style="font-size:13px;font-weight:600;padding:7px 18px;border-radius:8px;background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;text-decoration:none; white-space: nowrap;">
            Log In
          </a>
        </div>
        @endif

        @if(session('web_user'))
        <div class="dropdown">
          <button class="dropdown-toggle d-flex align-items-center gap-2" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:40px;padding:5px 12px 5px 8px;color:#fff;font-size:13px;font-weight:500;" data-bs-toggle="dropdown">
            <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center" style="width:28px;height:28px;background:linear-gradient(135deg,#4f6ef7,#7c3aed);">
              <span style="font-size:12px;font-weight:600;">{{ strtoupper(substr(session('web_user.first_name', 'U'), 0, 1)) }}</span>
            </div>
            <span>{{ session('web_user.first_name') }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" style="background:#0f1022;border:1px solid rgba(255,255,255,.1);">
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="comingSoon()" style="color:rgba(255,255,255,.75);"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="comingSoon()" style="color:rgba(255,255,255,.75);"><i class="bi bi-person me-2"></i> My Profile</a></li>
            @if(session('web_user.role') === 'employer')
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="comingSoon()" style="color:rgba(255,255,255,.75);"><i class="bi bi-plus-circle me-2"></i> My Jobs</a></li>
            @endif
            @if(session('web_user.role') === 'job_seeker')
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="comingSoon()" style="color:rgba(255,255,255,.75);"><i class="bi bi-file-text me-2"></i> My Applications</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="comingSoon()" style="color:rgba(255,255,255,.75);"><i class="bi bi-bookmark me-2"></i> Saved Jobs</a></li>
            @endif
            <li><hr class="dropdown-divider" style="border-color:rgba(255,255,255,.1);"></li>
            <li>
              <form method="POST" action="{{ route('web.logout') }}" id="logout-form-desktop">
                @csrf
                <button type="submit" class="dropdown-item text-danger" style="color:#f56565 !important;"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
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
<div class="offcanvas offcanvas-end mobile-offcanvas" tabindex="-1" id="offcanvasRight"
     style="background:#0f1022;border-left:1px solid rgba(255,255,255,.09);">
  <div class="offcanvas-header py-3" style="border-bottom:1px solid rgba(255,255,255,.09);">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
      <img src="{{ getFavicon() }}" alt="logo" style="width:22px;height:auto;"/>
      <span style="font-size:17px;font-weight:700;color:#fff;">
        {{__('Stardena')}} <span style="background:linear-gradient(135deg,#818cf8,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{__('Works')}}</span>
      </span>
    </a>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body pt-3">
    <!-- User Profile Section for Mobile -->
    @if(session('web_user'))
    <div class="mb-4 pb-3" style="border-bottom:1px solid rgba(255,255,255,.09);">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:linear-gradient(135deg,#4f6ef7,#7c3aed);">
          <span class="fw-bold fs-5 text-white">
            {{ strtoupper(substr(session('web_user.first_name', 'U'), 0, 1)) }}
            {{ strtoupper(substr(session('web_user.last_name', ''), 0, 1)) }}
          </span>
        </div>
        <div class="flex-grow-1">
          <div class="fw-semibold text-white">{{ session('web_user.full_name') ?? session('web_user.first_name') . ' ' . session('web_user.last_name') }}</div>
          <small style="color:rgba(255,255,255,.5);">{{ session('web_user.email') }}</small>
          <div class="mt-1">
            <span class="badge" style="background:rgba(79,110,247,.2);color:#818cf8;">{{ ucwords(str_replace('_', ' ', session('web_user.role', 'user'))) }}</span>
          </div>
        </div>
      </div>
    </div>
    @endif

    <ul class="list-unstyled ps-0">
      <li class="mb-1"><a href="{{ route('jobs.index') }}" target="_blank" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Find Jobs</a></li>
      <li class="mb-1"><a href="{{ route('companies') }}" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Companies</a></li>
      <li class="mb-1">
        <a href="{{ route('seeker.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">
          CV Enhancement
          <span style="background:rgba(79,110,247,.2);border:1px solid rgba(79,110,247,.4);color:#818cf8;font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;">New</span>
        </a>
      </li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Post a Job</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Pricing</a></li>
      <li class="mb-1"><a href="{{ route('blog.index') }}" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Blogs</a></li>
      
      @if(session('web_user'))
      <!-- Dashboard Links for Mobile -->
      <li class="mt-3 pt-2" style="border-top:1px solid rgba(255,255,255,.09);">
        <div class="small px-3 mb-2" style="color:rgba(255,255,255,.4);">ACCOUNT</div>
      </li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);"><i class="bi bi-person me-2"></i> My Profile</a></li>
      @if(session('web_user.role') === 'employer')
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);"><i class="bi bi-briefcase me-2"></i> My Jobs</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);"><i class="bi bi-plus-circle me-2"></i> Post a Job</a></li>
      @endif
      @if(session('web_user.role') === 'job_seeker')
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);"><i class="bi bi-file-text me-2"></i> My Applications</a></li>
      <li class="mb-1"><a href="javascript:void(0)" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);"><i class="bi bi-bookmark me-2"></i> Saved Jobs</a></li>
      @endif
      <li class="mt-3">
        <form method="POST" action="{{ route('web.logout') }}" id="logout-form-mobile">
          @csrf
          <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center gap-2" style="background:rgba(245,101,101,.15);border:1px solid rgba(245,101,101,.3);color:#f56565;font-size:14px;font-weight:600;padding:10px;">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
      </li>
      @else
      <!-- Auth Buttons for Mobile -->
      <li class="mt-4">
          <a href="{{ route('login.register') }}?tab=login"
            class="d-block text-center text-white text-decoration-none py-2 rounded-3 fw-600"
            style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);font-size:14px;font-weight:600;">
            Log In
          </a>
      </li>
      <li class="mt-2">
          <a href="{{ route('login.register') }}?tab=register"
            class="d-block text-center text-decoration-none py-2 rounded-3"
            style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);color:#fff;font-size:14px;font-weight:600;">
            Sign Up
          </a>
      </li>
      @endif
    </ul>
  </div>
</div>

<!-- Coming Soon Modal -->
<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-labelledby="comingSoonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background:#0f1022;border:1px solid rgba(255,255,255,.1);">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div class="mb-3">
          <i class="bi bi-tools fs-1" style="font-size:48px;color:#818cf8;"></i>
        </div>
        <h5 class="modal-title fs-4 fw-semibold mb-2 text-white" id="comingSoonModalLabel">Coming Soon!</h5>
        <p class="mb-0" style="color:rgba(255,255,255,.6);">We're working hard to bring you this feature. Stay tuned for updates!</p>
      </div>
      <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
        <button type="button" class="btn px-4" style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);color:#fff;border:none;" data-bs-dismiss="modal">Got it</button>
      </div>
    </div>
  </div>
</div>

<style>
  .header-fp {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    transition: transform 0.3s ease-in-out;
    background: #0a0b1a;
    border-bottom: 1px solid rgba(255,255,255,.08);
  }
  
  .header-fp.header-hidden {
    transform: translateY(-100%);
  }
  
  .header-fp .nav-item-link {
    font-size: 14px;
    font-weight: 500;
    color: rgba(255,255,255,.75);
    padding: 8px 14px;
    border-radius: 8px;
    transition: all 0.15s;
  }
  
  .header-fp .nav-item-link:hover {
    color: #fff;
    background: rgba(255,255,255,.08);
  }
  
  .header-fp .nav-item-link.active-nav {
    color: #818cf8;
    background: rgba(79,110,247,.12);
  }
  
  .dropdown-menu {
    background: #0f1022;
    border: 1px solid rgba(255,255,255,.1);
  }
  
  .dropdown-item {
    color: rgba(255,255,255,.75);
    font-size: 13px;
    padding: 8px 16px;
    transition: all 0.15s;
  }
  
  .dropdown-item:hover {
    background: rgba(255,255,255,.08);
    color: #fff;
  }
  
  .dropdown-divider {
    border-color: rgba(255,255,255,.1);
  }
  
  .offcanvas-link:hover {
    background: rgba(255,255,255,.08);
    color: #fff !important;
  }
  
  .offcanvas-link.active-nav {
    background: rgba(79,110,247,.15);
    color: #818cf8 !important;
  }
  
  #header-spacer {
    height: 65px;
  }
  
  @media (max-width: 991.98px) {
    .mobile-menu-button { display: block !important; }
    .desktop-menu { display: none !important; }
    #header-spacer { height: 57px; }
  }
  
  @media (min-width: 992px) {
    .mobile-menu-button { display: none !important; }
    .desktop-menu { display: flex !important; }
  }
</style>

<script>
  // Hide header on scroll down, show on scroll up
  (function() {
    let lastScrollY = window.scrollY;
    const header = document.getElementById('main-header');
    
    window.addEventListener('scroll', function() {
      if (window.scrollY > lastScrollY && window.scrollY > 80) {
        // Scrolling down - hide header
        header.classList.add('header-hidden');
      } else {
        // Scrolling up - show header
        header.classList.remove('header-hidden');
      }
      lastScrollY = window.scrollY;
    });
  })();

  function comingSoon() {
    const modalElement = document.getElementById('comingSoonModal');
    if (modalElement) {
      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    } else {
      alert('Coming Soon!!');
    }
  }

  // Active nav highlighting
  (function() {
    const current = window.location.pathname;
    document.querySelectorAll('.nav-item-link, .offcanvas-link').forEach(link => {
      const href = link.getAttribute('href');
      if (href && href !== '#' && href !== 'javascript:void(0)') {
        const linkPath = new URL(href, window.location.origin).pathname;
        const isActive = linkPath !== '/' && current.startsWith(linkPath) || linkPath === '/' && current === '/';
        if (isActive) {
          link.classList.add('active-nav');
        }
      }
    });
  })();

  // Logout confirmation
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

<!-- Coming Soon Modal -->
<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg" style="background:#13152e;border:1px solid rgba(255,255,255,.09)!important;">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="width:60px;height:60px;border-radius:16px;background:rgba(79,110,247,.15);border:1px solid rgba(79,110,247,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
          <i class="bi bi-tools" style="font-size:1.5rem;color:#818cf8;"></i>
        </div>
        <h5 class="fw-bold mb-2" style="color:#fff;">Coming Soon!</h5>
        <p style="color:rgba(255,255,255,.45);font-size:14px;margin:0;">We're working hard to bring you this feature. Stay tuned!</p>
      </div>
      <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
        <button type="button" class="btn btn-sm px-4" data-bs-dismiss="modal"
                style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);color:#fff;border:none;border-radius:8px;padding:8px 24px;font-weight:600;">Got it</button>
      </div>
    </div>
  </div>
</div>

<style>
/* ── Sticky dark header with hide/show animation ── */
.header-fp.header-sticky {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1030;
  background: rgba(11,12,26,.95);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid rgba(255,255,255,.08);
  width: 100%;
  transform: translateY(0);
  transition: transform 0.3s ease-in-out;
}

/* Hidden state */
.header-fp.header-sticky.header-hidden {
  transform: translateY(-100%);
}

.header-fp.header-sticky .navbar {
  min-height: unset !important;
  height: auto !important;
  padding: 12px 0;
}

/* Spacer to prevent content jump */
#header-spacer {
  display: block;
  width: 100%;
  transition: height 0.3s ease-in-out;
}

/* ── Nav links ── */
.nav-item-link {
  font-size: 13.5px !important;
  font-weight: 500;
  padding: 6px 10px !important;
  border-radius: 6px;
  color: rgba(255,255,255,.7) !important;
  transition: background .15s, color .15s;
  white-space: nowrap;
}
.nav-item-link:hover {
  background: rgba(79,110,247,.1);
  color: #818cf8 !important;
}

/* ── Offcanvas links ── */
.offcanvas-link { transition: background .15s, color .15s; }
.offcanvas-link:hover {
  background: rgba(79,110,247,.1) !important;
  color: #818cf8 !important;
}

/* Mobile specific styles */
@media (max-width: 991.98px) {
  .header-fp.header-sticky .container {
    padding-left: 16px;
    padding-right: 16px;
  }
  
  .header-fp.header-sticky .navbar-brand {
    max-width: 70%;
  }
  
  .header-fp.header-sticky .navbar-brand span {
    font-size: 15px;
    white-space: nowrap;
  }
  
  .header-fp.header-sticky .navbar {
    padding: 10px 0 !important;
  }
  
  .mobile-menu-button {
    display: block !important;
  }
  
  .desktop-menu {
    display: none !important;
  }
}

/* Very small screens */
@media (max-width: 480px) {
  .header-fp.header-sticky .navbar-brand span {
    font-size: 14px;
  }
  
  .header-fp.header-sticky .navbar {
    padding: 8px 0 !important;
  }
}

@media (min-width: 992px) {
  .mobile-menu-button { display: none !important; }
  .desktop-menu { display: flex !important; }
  .mobile-offcanvas { display: none !important; }
}

/* iOS Safari specific fixes */
@supports (-webkit-touch-callout: none) {
  .header-fp.header-sticky {
    position: fixed;
    top: 0;
  }
}
</style>

<script>
  (function() {
    var header = document.getElementById('main-header');
    var spacer = document.getElementById('header-spacer');
    var lastScrollTop = 0;
    var ticking = false;
    
    // Set spacer height to match header
    function updateSpacer() {
      if (header && spacer) {
        var headerHeight = header.offsetHeight;
        spacer.style.height = headerHeight + 'px';
      }
    }
    
    // Handle scroll hide/show
    function handleScroll() {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      
      if (!ticking) {
        requestAnimationFrame(function() {
          // Always show header at the very top
          if (scrollTop <= 10) {
            header.classList.remove('header-hidden');
          }
          // Hide on scroll down, show on scroll up
          else if (scrollTop > lastScrollTop && scrollTop > 50) {
            // Scrolling down - hide header
            header.classList.add('header-hidden');
          } else if (scrollTop < lastScrollTop) {
            // Scrolling up - show header
            header.classList.remove('header-hidden');
          }
          
          lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
          ticking = false;
        });
        ticking = true;
      }
    }
    
    // Initialize
    function init() {
      updateSpacer();
      window.addEventListener('load', updateSpacer);
      window.addEventListener('resize', updateSpacer);
      window.addEventListener('scroll', handleScroll);
      
      // Also update after any font loading
      setTimeout(updateSpacer, 100);
      setTimeout(updateSpacer, 300);
    }
    
    init();
  })();
  

</script>