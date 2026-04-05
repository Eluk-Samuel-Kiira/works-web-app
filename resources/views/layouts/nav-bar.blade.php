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
            <a class="nav-link nav-item-link" href="{{ route('jobs.index') }}">Find Jobs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="{{ route('companies') }}">Companies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link d-flex align-items-center gap-1" href="/coming-soon" onclick="comingSoon()">
              Career Advice
              <span style="background:rgba(79,110,247,.2);border:1px solid rgba(79,110,247,.4);color:#818cf8;font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;">New</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="/coming-soon" onclick="comingSoon()">Post a Job</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="/coming-soon" onclick="comingSoon()">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-item-link" href="/coming-soon" onclick="comingSoon()">Contact</a>
          </li>
        </ul>
        <div class="d-flex gap-2 align-items-center">
          <a href="/coming-soon" onclick="comingSoon()"
             style="font-size:13px;font-weight:600;padding:7px 18px;border-radius:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);color:#fff;text-decoration:none;transition:background .15s,border-color .15s; white-space: nowrap;"
             onmouseover="this.style.background='rgba(255,255,255,.13)'"
             onmouseout="this.style.background='rgba(255,255,255,.08)'">Sign Up</a>
          <a href="/coming-soon" onclick="comingSoon()"
             style="font-size:13px;font-weight:600;padding:7px 18px;border-radius:8px;background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;text-decoration:none; white-space: nowrap;">Log In</a>
        </div>
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
    <ul class="list-unstyled ps-0">
      <li class="mb-1"><a href="{{ route('jobs.index') }}" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Find Jobs</a></li>
      <li class="mb-1"><a href="{{ route('companies') }}" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Companies</a></li>
      <li class="mb-1">
        <a href="/coming-soon" onclick="comingSoon()" class="d-flex align-items-center gap-2 text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">
          Career Advice
          <span style="background:rgba(79,110,247,.2);border:1px solid rgba(79,110,247,.4);color:#818cf8;font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;">New</span>
        </a>
      </li>
      <li class="mb-1"><a href="/coming-soon" onclick="comingSoon()" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Post a Job</a></li>
      <li class="mb-1"><a href="/coming-soon" onclick="comingSoon()" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Pricing</a></li>
      <li class="mb-1"><a href="/coming-soon" onclick="comingSoon()" class="d-block text-decoration-none py-2 px-3 rounded-2 offcanvas-link" style="font-size:14px;color:rgba(255,255,255,.75);">Contact</a></li>
      <li class="mt-4">
        <a href="/coming-soon" onclick="comingSoon()"
           class="d-block text-center text-white text-decoration-none py-2 rounded-3 fw-600"
           style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);font-size:14px;font-weight:600;">Log In</a>
      </li>
      <li class="mt-2">
        <a href="/coming-soon" onclick="comingSoon()"
           class="d-block text-center text-decoration-none py-2 rounded-3"
           style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);color:#fff;font-size:14px;font-weight:600;">Sign Up</a>
      </li>
    </ul>
  </div>
</div>

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
  
  function comingSoon() {
    var el = document.getElementById('comingSoonModal');
    if (el) new bootstrap.Modal(el).show();
  }
</script>