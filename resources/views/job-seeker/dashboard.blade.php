@extends('layouts.jobs')

@section('title', 'Dashboard | Stardena Works')
@section('meta_description', 'Manage your job applications, profile, and career on Stardena Works dashboard.')

@section('job-content')

<div class="main-wrapper" style="background: #f8faff;">
  <div class="container-xl px-3 px-md-4 py-4 py-lg-5">
    
    {{-- Welcome Header with Blue Accent --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
      <div>
        <h1 class="h3 fw-bold mb-1" style="color: #1e2a3e;">Dashboard</h1>
        <p class="text-muted mb-0">
          Welcome back, <span class="fw-semibold text-primary">{{ session('web_user.first_name') ?? 'Guest' }}</span>
        </p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ url('/#cv-enhancement') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
          <i class="bi bi-stars me-2"></i> Upgrade CV
        </a>
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
          <i class="bi bi-briefcase me-2"></i> Browse Jobs
        </a>
      </div>
    </div>

    {{-- Stats Cards - Matching jobs index styling --}}
    <div class="row g-3 g-lg-4 mb-5">
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted small text-uppercase fw-semibold">Applications</span>
              <div class="rounded-2 bg-primary bg-opacity-10 p-2">
                <i class="bi bi-send text-primary"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold fs-2 text-primary" id="stat-applications">0</span>
              <span class="text-muted small">total</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted small text-uppercase fw-semibold">Interviews</span>
              <div class="rounded-2 bg-success bg-opacity-10 p-2">
                <i class="bi bi-calendar-check text-success"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold fs-2 text-success" id="stat-interviews">0</span>
              <span class="text-muted small">scheduled</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted small text-uppercase fw-semibold">Profile Views</span>
              <div class="rounded-2 bg-info bg-opacity-10 p-2">
                <i class="bi bi-eye text-info"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold fs-2 text-info" id="stat-views">0</span>
              <span class="text-muted small">this week</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted small text-uppercase fw-semibold">Saved Jobs</span>
              <div class="rounded-2 bg-warning bg-opacity-10 p-2">
                <i class="bi bi-bookmark text-warning"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold fs-2 text-warning" id="stat-saved">0</span>
              <span class="text-muted small">jobs</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Main Content Row --}}
    <div class="row g-3 g-lg-4">
      
      {{-- LEFT COLUMN - Profile Section --}}
      <div class="col-lg-4">
        
        {{-- Profile Card --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
          <div class="card-body p-4 text-center">
            <div class="position-relative d-inline-block mx-auto mb-3">
              <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto shadow-sm" 
                   style="width: 90px; height: 90px;">
                <span class="fw-bold fs-2 text-white">
                  {{ strtoupper(substr(session('web_user.first_name', 'U'), 0, 1)) }}{{ strtoupper(substr(session('web_user.last_name', ''), 0, 1)) }}
                </span>
              </div>
              <button onclick="comingSoon()" class="btn btn-sm btn-light rounded-circle position-absolute bottom-0 end-0 p-1 shadow-sm border-2 border-white">
                <i class="bi bi-camera-fill fs-6 text-primary"></i>
              </button>
            </div>
            
            <h5 class="fw-bold mb-1">{{ session('web_user.first_name') }} {{ session('web_user.last_name') }}</h5>
            <p class="text-muted small mb-2">{{ session('web_user.email') }}</p>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">
              <i class="bi bi-briefcase me-1"></i> 
              {{ is_string(session('web_user.role')) ? ucwords(str_replace('_', ' ', session('web_user.role'))) : 'Job Seeker' }}
            </span>
            
            <div class="border-top pt-3 mt-2">
              <div class="row g-2">
                <div class="col-6">
                  <div class="text-start p-2 rounded-2 bg-light">
                    <div class="text-muted small">Member since</div>
                    <div class="fw-semibold text-primary">Nov 2024</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-start p-2 rounded-2 bg-light">
                    <div class="text-muted small">Last active</div>
                    <div class="fw-semibold text-primary">Today</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        @include('job-seeker.cv-upload')
      </div>

      {{-- RIGHT COLUMN - Tabs --}}
      <div class="col-lg-8">
        
        {{-- Tabs Navigation --}}
        <ul class="nav nav-tabs border-bottom gap-3 mb-4" id="dashboardTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active px-3 py-2 fw-semibold" id="activity-tab" data-bs-toggle="tab" 
                    data-bs-target="#activity" type="button" role="tab">
              <i class="bi bi-activity me-2"></i>Upgrade CV
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 py-2 fw-semibold" id="manual-cv-tab" data-bs-toggle="tab" 
                    data-bs-target="#manual-cv" type="button" role="tab">
              <i class="bi bi-send me-2"></i>Manual CV Update
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 py-2 fw-semibold" id="applications-tab" data-bs-toggle="tab" 
                    data-bs-target="#applications" type="button" role="tab">
              <i class="bi bi-send me-2"></i>Applications
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 py-2 fw-semibold" id="settings-tab" data-bs-toggle="tab" 
                    data-bs-target="#settings" type="button" role="tab">
              <i class="bi bi-gear me-2"></i>Settings
            </button>
          </li>
        </ul>

        <div class="tab-content">

          {{-- Activity Tab --}}
          <div class="tab-pane fade show active" id="activity" role="tabpanel">
              <div class="card border-0 shadow-sm rounded-3">
                  {{-- CV Enhancement Card --}}
                  <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                      @php
                          $hasActiveSubscription = false; // Check from database if user has active subscription
                          $subscriptionPlan = null; // Get from database
                      @endphp
                      
                      @if($hasActiveSubscription)
                          {{-- Active Subscription View --}}
                          <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
                              <div class="rounded-2 bg-white bg-opacity-20 p-2 d-inline-block mb-3">
                                  <i class="bi bi-check-circle-fill fs-3 text-white"></i>
                              </div>
                              <h5 class="fw-bold mb-1 text-white">🚀 Pro Active</h5>
                              <p class="small text-white-50 mb-3">{{ ucfirst($subscriptionPlan) }} Plan Active</p>
                              <div class="mb-3">
                                  <span class="display-6 fw-bold text-white">Active</span>
                                  <span class="small text-white-50">until {{ now()->addDays(30)->format('M d, Y') }}</span>
                              </div>
                              <button onclick="manageSubscription()" class="btn btn-light text-primary fw-semibold rounded-pill px-4 py-2 w-100 shadow-sm">
                                  <i class="bi bi-gear me-2"></i>Manage Subscription
                              </button>
                          </div>
                      @else
                          {{-- No Subscription - Show Upgrade Card --}}
                          <div class="card-body p-4" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                              
                              {{-- Header Section --}}
                              <div class="text-center mb-4">
                                  <span class="badge bg-white text-dark rounded-pill px-3 py-1 mb-2" style="font-size: 10px;">
                                      ⚡ Limited Time Offer
                                  </span>
                                  <div class="rounded-circle bg-white bg-opacity-20 p-2 d-inline-flex mb-2">
                                      <i class="bi bi-stars fs-2 text-white"></i>
                                  </div>
                                  <h4 class="fw-bold mb-1 text-white">Land Your Dream Job <span style="text-decoration: underline; color: #fcd34d;">Faster</span></h4>
                                  <p class="small text-white-50 mb-0">AI-powered CV enhancement that gets you noticed</p>
                              </div>
                              
                              {{-- Feature Badges Row - Centered --}}
                              <div class="d-flex justify-content-center gap-2 mb-4 flex-wrap">
                                  <span class="badge bg-white text-dark rounded-pill px-3 py-2" style="font-size: 11px;">
                                      📊 ATS Score
                                  </span>
                                  <span class="badge bg-white text-dark rounded-pill px-3 py-2" style="font-size: 11px;">
                                      ✍️ Cover Letters
                                  </span>
                                  <span class="badge bg-white text-dark rounded-pill px-3 py-2" style="font-size: 11px;">
                                      🎯 Keyword Match
                                  </span>
                                  <span class="badge bg-white text-dark rounded-pill px-3 py-2" style="font-size: 11px;">
                                      💼 Interview Prep
                                  </span>
                              </div>
                              
                              {{-- Pricing Section - Centered --}}
                              <div class="text-center mb-4">
                                  <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                      <span class="fw-bold text-white" style="font-size: 3rem;">$5</span>
                                      <span class="text-white-50">/month</span>
                                      <span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size: 9px;">🔥 Save 40%</span>
                                  </div>
                                  <p class="small text-white-50 mb-0" style="font-size: 11px;">≈ UGX 18,750 per month</p>
                              </div>
                              
                              {{-- Benefits Grid - Centered with proper structure --}}
                              <div class="row justify-content-center g-2 mb-4">
                                  <div class="col-5 col-sm-4">
                                      <div class="d-flex align-items-center justify-content-center gap-2">
                                          <i class="bi bi-check-circle-fill text-white" style="font-size: 12px;"></i>
                                          <span class="small text-white">Unlimited CV reviews</span>
                                      </div>
                                  </div>
                                  <div class="col-5 col-sm-4">
                                      <div class="d-flex align-items-center justify-content-center gap-2">
                                          <i class="bi bi-check-circle-fill text-white" style="font-size: 12px;"></i>
                                          <span class="small text-white">ATS score optimization</span>
                                      </div>
                                  </div>
                                  <div class="col-5 col-sm-4">
                                      <div class="d-flex align-items-center justify-content-center gap-2">
                                          <i class="bi bi-check-circle-fill text-white" style="font-size: 12px;"></i>
                                          <span class="small text-white">Unlimited cover letters</span>
                                      </div>
                                  </div>
                                  <div class="col-5 col-sm-4">
                                      <div class="d-flex align-items-center justify-content-center gap-2">
                                          <i class="bi bi-check-circle-fill text-white" style="font-size: 12px;"></i>
                                          <span class="small text-white">Priority support</span>
                                      </div>
                                  </div>
                              </div>
                              
                              {{-- Social Proof - Centered --}}
                              <div class="d-flex justify-content-center align-items-center gap-4 mb-4">
                                  <div class="text-center">
                                      <div class="fw-bold text-white">500+</div>
                                      <small class="text-white-50" style="font-size: 10px;">Happy Users</small>
                                  </div>
                                  <div class="vr bg-white bg-opacity-25" style="height: 30px;"></div>
                                  <div class="text-center">
                                      <div class="fw-bold text-white">4.9★</div>
                                      <small class="text-white-50" style="font-size: 10px;">Rating</small>
                                  </div>
                                  <div class="vr bg-white bg-opacity-25" style="height: 30px;"></div>
                                  <div class="text-center">
                                      <div class="fw-bold text-white">30-Day</div>
                                      <small class="text-white-50" style="font-size: 10px;">Guarantee</small>
                                  </div>
                              </div>
                              
                              {{-- CTA Button - Centered --}}
                              <div class="text-center mb-3">
                                  <a href="{{ url('/#cv-enhancement') }}" class="btn btn-light fw-semibold rounded-pill px-5 py-2 shadow-sm" style="color: #f97316; font-size: 14px;">
                                      <i class="bi bi-lightning-charge me-2"></i>Upgrade Now — Get Hired Faster
                                  </a>
                              </div>
                              
                              {{-- Trust Message - Centered --}}
                              <div class="text-center">
                                  <p class="small text-white-50 mb-0" style="font-size: 10px;">
                                      <i class="bi bi-lock me-1"></i> Secure payment via Pesapal | Cancel anytime
                                  </p>
                              </div>
                              
                          </div>
                      @endif
                  </div>
              </div>
          </div>
          
          {{-- Manual CV Tab - inline the component, no AJAX --}}
          <div class="tab-pane fade" id="manual-cv" role="tabpanel">
              <div id="cvEditorContainer">
                  @include('job-seeker.cv-editor-component')
              </div>
          </div>
          
          {{-- Applications Tab --}}
          <div class="tab-pane fade" id="applications" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
              <div class="card-body p-4">
                <div class="text-center py-5" id="emptyApplications">
                  <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">
                    <i class="bi bi-inbox fs-1 text-primary"></i>
                  </div>
                  <p class="text-muted mb-3">No applications yet. Start your job search!</p>
                  <a href="{{ route('jobs.index') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-search me-2"></i>Browse Jobs
                  </a>
                </div>
              </div>
            </div>
          </div>


          {{-- Settings Tab --}}
          <div class="tab-pane fade" id="settings" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
              <div class="card-body p-4">
                <form id="profileSettingsForm">
                  <h6 class="fw-bold mb-3">Personal Information</h6>
                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <label class="form-label small fw-semibold">First Name</label>
                      <input type="text" class="form-control rounded-2" value="{{ session('web_user.first_name') }}">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label small fw-semibold">Last Name</label>
                      <input type="text" class="form-control rounded-2" value="{{ session('web_user.last_name') }}">
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Email Address</label>
                      <input type="email" class="form-control rounded-2 bg-light" value="{{ session('web_user.email') }}" readonly disabled>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Phone Number</label>
                      <input type="tel" class="form-control rounded-2" placeholder="+256 XXX XXX XXX">
                    </div>
                  </div>
                  
                  <h6 class="fw-bold mb-3">Notification Preferences</h6>
                  <div class="mb-3">
                    <div class="form-check form-switch mb-2">
                      <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                      <label class="form-check-label" for="emailNotif">Email job recommendations</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                      <input class="form-check-input" type="checkbox" id="appNotif" checked>
                      <label class="form-check-label" for="appNotif">Application status updates</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="newsNotif">
                      <label class="form-check-label" for="newsNotif">News and announcements</label>
                    </div>
                  </div>

                  <hr>
                  
                  <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                      <i class="bi bi-check-lg me-2"></i>Save Changes
                    </button>
                    <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="logoutConfirm()">
                      <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- AI Recommendation Section --}}
    <div class="mt-5">
      @include('job-seeker.recommended-jobs')
    </div>

  </div>
</div>

{{-- Coming Soon Modal --}}
<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3 border-0 shadow">
      <div class="modal-body text-center py-5 px-4">
        <div class="rounded-2 bg-primary bg-opacity-10 p-3 d-inline-block mb-3">
          <i class="bi bi-tools fs-1 text-primary"></i>
        </div>
        <h5 class="fw-bold mb-2">Coming Soon!</h5>
        <p class="text-muted mb-0">We're working hard to bring you this feature. Stay tuned!</p>
        <button type="button" class="btn btn-primary rounded-pill mt-4 px-5" data-bs-dismiss="modal">Got it</button>
      </div>
    </div>
  </div>
</div>


<style>
  .container-xl { max-width: 1280px; }
  .bg-light { background-color: #f8faff !important; }
  .nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 2px solid transparent;
  }
  .nav-tabs .nav-link:hover { color: #0d6efd; }
  .nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
    background: transparent;
  }
  .progress { background-color: #e9ecef; }
  .form-check-input:checked { background-color: #0d6efd; border-color: #0d6efd; }
  @media (max-width: 768px) {
    .fs-2 { font-size: 1.5rem !important; }
    .card-body { padding: 1rem !important; }
    .nav-tabs { flex-wrap: nowrap; overflow-x: auto; }
    .nav-tabs .nav-link { white-space: nowrap; }
  }

  .hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .hover-lift:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
  }
</style>

<script>
function comingSoon() { new bootstrap.Modal(document.getElementById('comingSoonModal')).show(); }
function processPayment() { showToast('Redirecting to secure payment gateway...', 'info'); setTimeout(() => { window.location.href = '/payment/subscribe?plan=ai_cv_suite'; }, 1000); }
function logoutConfirm() { if (confirm('Are you sure you want to logout?')) document.getElementById('logout-form')?.submit(); }
function showToast(message, type) { /* kept from parent layout, already defined */ }

function animateCounter(element, target) {
  if (!element) return;
  let current = 0, increment = target / 50, timer = setInterval(() => {
    current += increment;
    if (current >= target) { element.textContent = target; clearInterval(timer); }
    else element.textContent = Math.floor(current);
  }, 20);
}



document.addEventListener('DOMContentLoaded', function() {
    animateCounter(document.getElementById('stat-applications'), 12);
    animateCounter(document.getElementById('stat-interviews'), 3);
    animateCounter(document.getElementById('stat-views'), 128);
    animateCounter(document.getElementById('stat-saved'), 5);

    // Don't block first paint — load recommendations when browser is idle
    if ('requestIdleCallback' in window) {
        requestIdleCallback(loadRecommendedJobs);
    } else {
        setTimeout(loadRecommendedJobs, 200);
    }
});

</script>

@endsection