
<!-- Top Notification Bar -->
<div class="topbar-strip alert alert-dismissible fade show mb-0 rounded-0" role="alert">
  <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
    <span class="badge bg-white bg-opacity-20 text-white fw-bold">{{__('🚀 NEW')}}</span>
    <span>{{__('AI-powered CV Tailoring is live — get matched to the right job in seconds!')}}</span>
    <a href="/register" class="text-white fw-bold text-decoration-underline">{{__('Try it Free →')}}</a>
  </div>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>

<!-- Navigation -->
<header class="header-fp">
  <nav class="navbar navbar-expand-lg py-2">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="/">
        <img src="{{ getFavicon() }}" alt="homepage" class="dark-logo" style="width: 20px; height: auto;" />
        <span style="font-size:18px;font-weight:800;color:#2a3547;">{{__('Stardena')}} <span style="color:var(--bs-primary);">{{__('Works')}}</span></span>
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
        <i class="ti ti-menu-2 fs-5"></i>
      </button>

      <!-- Desktop Nav -->
      <div class="collapse navbar-collapse" id="desktopNav">
        <ul class="navbar-nav mx-auto gap-1">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" target="_blank" href="{{ route('jobs.index') }}">Find Jobs</a></li>
          <li class="nav-item"><a class="nav-link" href="#gigs">Quick Gigs</a></li>
          <li class="nav-item"><a class="nav-link" href="#talent">For Employers</a></li>
          <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        </ul>
        <div class="d-flex align-items-center gap-2">
          <a href="/login" class="btn btn-outline-primary btn-sm px-4">Log In</a>
          <a href="/register" class="btn btn-primary btn-sm px-4">Join Free</a>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- Mobile Offcanvas -->
<div class="offcanvas offcanvas-end" id="mobileMenu">
  <div class="offcanvas-header border-bottom">
    <div class="d-flex align-items-center gap-2">
      <div style="width:32px;height:32px;background:linear-gradient(135deg,#5D87FF,#49BEFF);border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <iconify-icon icon="material-symbols:work-outline-rounded" style="color:#fff;font-size:16px;"></iconify-icon>
      </div>
      <span style="font-size:16px;font-weight:800;color:#2a3547;">Stardena <span style="color:var(--bs-primary);">Works</span></span>
    </div>
    <button class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled">
      <li><a href="#" class="d-block py-2 text-dark fw-medium border-bottom">Home</a></li>
      <li><a href="#features" class="d-block py-2 text-dark fw-medium border-bottom">Find Jobs</a></li>
      <li><a href="#gigs" class="d-block py-2 text-dark fw-medium border-bottom">Quick Gigs</a></li>
      <li><a href="#talent" class="d-block py-2 text-dark fw-medium border-bottom">For Employers</a></li>
      <li><a href="#pricing" class="d-block py-2 text-dark fw-medium border-bottom">Pricing</a></li>
      <li><a href="#about" class="d-block py-2 text-dark fw-medium">About</a></li>
    </ul>
    <div class="mt-4 d-flex flex-column gap-2">
      <a href="/login" class="btn btn-outline-primary">Log In</a>
      <a href="/register" class="btn btn-primary">Join Free</a>
    </div>
  </div>
</div>

