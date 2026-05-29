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
    {{--
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
    --}}

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
        <ul class="nav nav-tabs border-bottom gap-1 gap-md-3 mb-4" id="dashboardTabs" role="tablist" style="flex-wrap: nowrap; overflow-x: auto; scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
          <li class="nav-item flex-shrink-0" role="presentation">
            <button class="nav-link active px-2 px-md-3 py-2 fw-semibold" id="activity-tab" data-bs-toggle="tab" 
                    data-bs-target="#activity" type="button" role="tab">
              <i class="bi bi-activity me-1 me-md-2"></i>
              <span class="d-none d-sm-inline">Upgrade CV</span>
              <span class="d-inline d-sm-none">Upgrade</span>
            </button>
          </li>
          <li class="nav-item flex-shrink-0" role="presentation">
            <button class="nav-link px-2 px-md-3 py-2 fw-semibold" id="cover-letter-tab" data-bs-toggle="tab" 
                    data-bs-target="#cover-letter" type="button" role="tab">
              <i class="bi bi-envelope-paper me-1 me-md-2"></i>
              <span class="d-none d-sm-inline">Cover Letters</span>
              <span class="d-inline d-sm-none">Letters</span>
            </button>
          </li>
          <li class="nav-item flex-shrink-0" role="presentation">
            <button class="nav-link px-2 px-md-3 py-2 fw-semibold" id="manual-cv-tab" data-bs-toggle="tab" 
                  data-bs-target="#manual-cv" type="button" role="tab">
              <i class="bi bi-pencil-square me-1 me-md-2"></i>
              <span class="d-none d-sm-inline">Update CV</span>
              <span class="d-inline d-sm-none">Update CV</span>
            </button>
          </li>
          <li class="nav-item flex-shrink-0" role="presentation">
            <button class="nav-link px-2 px-md-3 py-2 fw-semibold" id="myplan-tab" data-bs-toggle="tab" 
                    data-bs-target="#myplan" type="button" role="tab">
              <i class="bi bi-star me-1 me-md-2"></i>
              <span class="d-none d-sm-inline">My Plan</span>
              <span class="d-inline d-sm-none">My Plan</span>
            </button>
          </li>
          <li class="nav-item flex-shrink-0" role="presentation">
            <button class="nav-link px-2 px-md-3 py-2 fw-semibold" id="settings-tab" data-bs-toggle="tab" 
                  data-bs-target="#settings" type="button" role="tab">
              <i class="bi bi-gear me-1 me-md-2"></i>
              <span class="d-none d-sm-inline">Settings</span>
              <span class="d-inline d-sm-none">Settings</span>
            </button>
          </li>
        </ul>

        <style>
          /* Mobile tab scrolling */
          @media (max-width: 576px) {
            #dashboardTabs {
              scrollbar-width: thin;
            }
            #dashboardTabs::-webkit-scrollbar {
              height: 2px;
            }
            #dashboardTabs::-webkit-scrollbar-track {
              background: #e2e8f0;
              border-radius: 10px;
            }
            #dashboardTabs::-webkit-scrollbar-thumb {
              background: #cbd5e1;
              border-radius: 10px;
            }
          }
        </style>

        <div class="tab-content">

          {{-- Activity Tab --}}
          <div class="tab-pane fade show active" id="activity" role="tabpanel">
              <div class="card border-0 shadow-sm rounded-3">  
                @include('job-seeker.partials.cv-enhancement-tab')
              </div>
          </div>
          
          {{-- Cover Letters Tab --}}
          <div class="tab-pane fade" id="cover-letter" role="tabpanel">
            @include('job-seeker.partials.cover-letter-tab')
          </div>
          
          {{-- Manual CV Tab --}}
          <div class="tab-pane fade" id="manual-cv" role="tabpanel">
            <div id="cvEditorContainer">
              @include('job-seeker.cv-editor-component')
            </div>
          </div>

          {{-- My Plan Tab --}}
          <div class="tab-pane fade" id="myplan" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
              <div id="planStatusContainer">
                <div class="card-body text-center py-5">
                  <div class="spinner-border text-primary" role="status"></div>
                  <p class="text-muted mt-2">Loading your plan information...</p>
                </div>
              </div>
            </div>
          </div>


          {{-- Settings Tab --}}
          <div class="tab-pane fade" id="settings" role="tabpanel">
              @include('job-seeker.partials.setting-component')
          </div>

        </div>
      </div>
    </div>

    {{-- AI Recommendation Section --}}
    <div class="mt-5" id="job-matching">
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

<script>
// Load plan status when My Plan tab is clicked or on page load
let planLoaded = false;

document.getElementById('myplan-tab').addEventListener('shown.bs.tab', function() {
    if (!planLoaded) {
        loadPlanStatus();
    }
});

// Also load on page load if My Plan is active
if (document.getElementById('myplan').classList.contains('show')) {
    loadPlanStatus();
}

async function loadPlanStatus() {
    const container = document.getElementById('planStatusContainer');
    
    try {
        const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
        const API_TOKEN = '{{ session("api_token") }}';
        
        const response = await fetch(`${API_BASE}/v1/subscription/status`, {
            headers: {
                'Authorization': `Bearer ${API_TOKEN}`,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            const sub = data.data;
            
            if (sub.has_active_subscription) {
                // Has active subscription
                container.innerHTML = `
                    <div class="card-body p-4 text-center" style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
                        <div class="rounded-2 bg-white bg-opacity-20 d-inline-flex p-3 mb-3">
                            <i class="bi bi-check-circle-fill fs-2 text-white"></i>
                        </div>
                        <h4 class="fw-bold mb-1 text-white">${sub.plan.toUpperCase()} Plan Active</h4>
                        <p class="text-white-50 small mb-2">${sub.period} subscription</p>
                        <div class="alert alert-light py-2 px-3 mb-3 d-inline-flex gap-2 rounded-pill" style="background: rgba(255,255,255,0.15); border: none; color: white;">
                            <i class="bi bi-calendar-check me-1"></i>
                            Valid until <strong>${sub.expiry_date || 'N/A'}</strong>
                        </div>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ url('/#cv-enhancement') }}" class="btn btn-light rounded-pill px-4">
                                <i class="bi bi-arrow-repeat me-2"></i>Manage
                            </a>
                            <button onclick="document.getElementById('activity-tab').click(); setTimeout(() => scrollToUpgrade?.(), 300);" class="btn btn-outline-light rounded-pill px-4">
                                <i class="bi bi-stars me-2"></i>Upgrade Plan
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-4 border-top">
                        <h6 class="fw-bold mb-3"><i class="bi bi-graph-up me-2 text-primary"></i>Plan Benefits</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span class="small">Unlimited CV reviews</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span class="small">Unlimited cover letters</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span class="small">Priority support</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span class="small">ATS optimization</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // No active subscription
                container.innerHTML = `
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-3 mb-3">
                            <i class="bi bi-star fs-2 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-2">No Active Plan</h4>
                        <p class="text-muted small mb-4">Subscribe to unlock AI-powered CV enhancement features.</p>
                        <button onclick="document.getElementById('activity-tab').click();" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-lightning-charge me-2"></i>View Plans
                        </button>
                    </div>
                `;
            }
            planLoaded = true;
        } else {
            throw new Error('Failed to load plan');
        }
    } catch (error) {
        container.innerHTML = `
            <div class="card-body text-center py-5">
                <i class="bi bi-exclamation-triangle fs-2 text-warning"></i>
                <p class="text-muted mt-2">Unable to load plan information. Please refresh the page.</p>
                <button onclick="location.reload()" class="btn btn-sm btn-outline-primary rounded-pill">Retry</button>
            </div>
        `;
    }
}
</script>

@endsection