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
              <i class="bi bi-briefcase me-1"></i> {{ ucwords(str_replace('_', ' ', session('web_user.role', 'Job Seeker'))) }}
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

        {{-- Profile Completion Card --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold mb-0">Profile Strength</h6>
              <span class="badge bg-primary rounded-pill px-3 py-2">65%</span>
            </div>
            <div class="progress mb-3" style="height: 6px;">
              <div class="progress-bar bg-primary rounded-pill" style="width: 65%;"></div>
            </div>
            <div class="mb-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-check-circle-fill text-success fs-6"></i>
                <span class="small text-muted">Basic info completed</span>
              </div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-check-circle-fill text-success fs-6"></i>
                <span class="small text-muted">Email verified</span>
              </div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-circle text-secondary fs-6"></i>
                <span class="small text-muted">CV not uploaded</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-circle text-secondary fs-6"></i>
                <span class="small text-muted">Work experience missing</span>
              </div>
            </div>
            <button onclick="comingSoon()" class="btn btn-outline-primary w-100 rounded-pill">
              <i class="bi bi-arrow-up-circle me-2"></i>Complete Profile
            </button>
          </div>
        </div>

        {{-- CV Enhancement Card --}}
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
          <div class="card-body p-4 text-center text-white">
            <div class="rounded-2 bg-white bg-opacity-20 p-2 d-inline-block mb-3">
              <i class="bi bi-stars fs-3"></i>
            </div>
            <h5 class="fw-bold mb-2">AI-Powered CV Enhancement</h5>
            <p class="small opacity-90 mb-3">Get ATS score + custom cover letters</p>
            <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
              <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Uganda</span>
              <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Kenya</span>
              <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Tanzania</span>
              <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Rwanda</span>
            </div>
            <div class="mb-3">
              <span class="display-6 fw-bold text-white">$5</span>
              <span class="small text-white opacity-75">/month</span>
              <span class="badge bg-warning text-dark ms-2 rounded-pill">Save 40%</span>
            </div>
            <button onclick="subscribeAI()" class="btn btn-light text-primary fw-semibold rounded-pill px-4 py-2 w-100 shadow-sm">
              <i class="bi bi-lightning-charge me-2"></i>Get Instant Access
            </button>
          </div>
        </div>
      </div>

      {{-- RIGHT COLUMN - Tabs --}}
      <div class="col-lg-8">
        
        {{-- Tabs Navigation --}}
        <ul class="nav nav-tabs border-bottom gap-3 mb-4" id="dashboardTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active px-3 py-2 fw-semibold" id="applications-tab" data-bs-toggle="tab" 
                    data-bs-target="#applications" type="button" role="tab">
              <i class="bi bi-send me-2"></i>Applications
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 py-2 fw-semibold" id="saved-tab" data-bs-toggle="tab" 
                    data-bs-target="#saved" type="button" role="tab">
              <i class="bi bi-bookmark me-2"></i>Saved Jobs
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 py-2 fw-semibold" id="activity-tab" data-bs-toggle="tab" 
                    data-bs-target="#activity" type="button" role="tab">
              <i class="bi bi-activity me-2"></i>Activity
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
          
          {{-- Applications Tab --}}
          <div class="tab-pane fade show active" id="applications" role="tabpanel">
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

          {{-- Saved Jobs Tab --}}
          <div class="tab-pane fade" id="saved" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
              <div class="card-body p-4">
                <div class="text-center py-5" id="emptySaved">
                  <div class="rounded-circle bg-warning bg-opacity-10 p-4 d-inline-block mb-3">
                    <i class="bi bi-bookmark fs-1 text-warning"></i>
                  </div>
                  <p class="text-muted mb-3">No saved jobs yet. Save jobs you're interested in!</p>
                  <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-heart me-2"></i>Explore Jobs
                  </a>
                </div>
              </div>
            </div>
          </div>

          {{-- Activity Tab --}}
          <div class="tab-pane fade" id="activity" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3">
              <div class="card-body p-4">
                <div class="d-flex gap-3 mb-4">
                  <div class="rounded-circle bg-primary bg-opacity-10 p-3" style="width: 48px; height: 48px;">
                    <i class="bi bi-person-check text-primary"></i>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Profile created</p>
                    <small class="text-muted">{{ now()->format('M d, Y') }}</small>
                  </div>
                </div>
                <div class="d-flex gap-3">
                  <div class="rounded-circle bg-info bg-opacity-10 p-3" style="width: 48px; height: 48px;">
                    <i class="bi bi-envelope-check text-info"></i>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Email verified</p>
                    <small class="text-muted">{{ now()->format('M d, Y') }}</small>
                  </div>
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
      <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white border-bottom p-4">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-2 bg-primary bg-opacity-10 p-2">
              <i class="bi bi-robot fs-4 text-primary"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-0">AI-Powered Job Recommendations</h6>
              <small class="text-muted">Personalized matches based on your profile</small>
            </div>
            <span class="badge bg-primary ms-auto rounded-pill px-3 py-2">Smart Match</span>
          </div>
        </div>
        <div class="card-body p-4 bg-light">
          <div class="row g-3" id="recommendedJobs">
            <div class="col-12 text-center py-5">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <p class="text-muted small mt-3">Analyzing your profile for best matches...</p>
            </div>
          </div>
        </div>
      </div>
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

{{-- Subscribe Modal --}}
<div class="modal fade" id="subscribeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3 border-0 shadow">
      <div class="modal-body text-center py-5 px-4">
        <div class="rounded-2 bg-success bg-opacity-10 p-3 d-inline-block mb-3">
          <i class="bi bi-lightning-charge fs-1 text-success"></i>
        </div>
        <h5 class="fw-bold mb-2">Unlock AI CV Suite</h5>
        <p class="text-muted mb-3">Get instant access for just <strong class="text-primary">$5/month</strong></p>
        <div class="text-start bg-light rounded-3 p-3 mb-3">
          <p class="small fw-semibold mb-2">What's included:</p>
          <ul class="small text-muted mb-0 ps-3">
            <li>Unlimited AI resume reviews & ATS scoring</li>
            <li>100+ custom cover letters per month</li>
            <li>Keyword optimization suggestions</li>
            <li>Cancel anytime</li>
          </ul>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-primary rounded-pill flex-grow-1" onclick="processPayment()">
            <i class="bi bi-credit-card me-2"></i>Subscribe Now
          </button>
          <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Later</button>
        </div>
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
</style>

<script>
function comingSoon() { new bootstrap.Modal(document.getElementById('comingSoonModal')).show(); }
function subscribeAI() { new bootstrap.Modal(document.getElementById('subscribeModal')).show(); }
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

function loadRecommendedJobs() {
  const container = document.getElementById('recommendedJobs');
  if (!container) return;
  setTimeout(() => {
    container.innerHTML = `
      <div class="col-md-6 col-lg-4">
        <div class="card border rounded-3 h-100 shadow-sm">
          <div class="card-body p-3">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="rounded-2 bg-primary bg-opacity-10 p-2"><i class="bi bi-briefcase text-primary"></i></div>
              <h6 class="fw-bold mb-0">Senior Software Engineer</h6>
            </div>
            <p class="text-muted small mb-2">TechCorp Uganda</p>
            <div class="d-flex gap-2 mb-3 flex-wrap">
              <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Full-time</span>
              <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Remote</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-primary fw-semibold small">UGX 3M - 5M</span>
              <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="comingSoon()">View</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card border rounded-3 h-100 shadow-sm">
          <div class="card-body p-3">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="rounded-2 bg-primary bg-opacity-10 p-2"><i class="bi bi-briefcase text-primary"></i></div>
              <h6 class="fw-bold mb-0">Product Manager</h6>
            </div>
            <p class="text-muted small mb-2">Innovate Ltd</p>
            <div class="d-flex gap-2 mb-3 flex-wrap">
              <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Full-time</span>
              <span class="badge bg-info bg-opacity-10 text-info rounded-pill">Hybrid</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-primary fw-semibold small">UGX 4M - 6M</span>
              <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="comingSoon()">View</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card border rounded-3 h-100 shadow-sm">
          <div class="card-body p-3">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="rounded-2 bg-primary bg-opacity-10 p-2"><i class="bi bi-brush text-primary"></i></div>
              <h6 class="fw-bold mb-0">UI/UX Designer</h6>
            </div>
            <p class="text-muted small mb-2">Creative Studios</p>
            <div class="d-flex gap-2 mb-3 flex-wrap">
              <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Contract</span>
              <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">On-site</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-primary fw-semibold small">UGX 2.5M - 3.5M</span>
              <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="comingSoon()">View</button>
            </div>
          </div>
        </div>
      </div>
    `;
  }, 800);
}

document.addEventListener('DOMContentLoaded', function() {
  animateCounter(document.getElementById('stat-applications'), 12);
  animateCounter(document.getElementById('stat-interviews'), 3);
  animateCounter(document.getElementById('stat-views'), 128);
  animateCounter(document.getElementById('stat-saved'), 5);
  loadRecommendedJobs();
});
</script>

@endsection