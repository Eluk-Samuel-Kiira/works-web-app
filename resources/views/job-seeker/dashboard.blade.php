@extends('layouts.jobs')

@section('title', 'Dashboard | Stardena Works')
@section('meta_description', 'Manage your job applications, profile, and career on Stardena Works dashboard.')

@section('job-content')

<div class="main-wrapper" style="background: linear-gradient(180deg, #f0f7ff 0%, #ffffff 100%);">
  <div class="container-xl px-3 px-md-4 py-4 py-lg-5">
    
    {{-- Welcome Header with Blue Accent --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <div class="rounded-3 bg-primary bg-opacity-10 p-2">
            <i class="bi bi-grid-1x2-fill text-primary"></i>
          </div>
          <h1 class="h2 fw-bold mb-0" style="background: linear-gradient(135deg, #1e40af, #3b82f6); -webkit-background-clip: text; background-clip: text; color: transparent;">Dashboard</h1>
        </div>
        <p class="text-muted mb-0">
          Welcome back, <span class="fw-semibold text-primary">{{ session('web_user.first_name') ?? 'Guest' }}</span>
        </p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary rounded-pill px-4">
          <i class="bi bi-briefcase me-2"></i> Browse Jobs
        </a>
        <button onclick="comingSoon()" class="btn btn-primary rounded-pill px-4 shadow-sm">
          <i class="bi bi-file-text me-2"></i> Post a Job
        </button>
      </div>
    </div>

    {{-- Enhanced Stats Cards with Blue Gradients --}}
    <div class="row g-3 g-lg-4 mb-5">
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="text-muted small text-uppercase fw-semibold">Applications</span>
              <div class="rounded-3 bg-primary p-2 shadow-sm">
                <i class="bi bi-send text-white"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold display-6 text-primary" id="stat-applications">0</span>
              <span class="text-muted small">total</span>
            </div>
            <div class="mt-2">
              <span class="badge bg-success bg-opacity-15 text-success px-2 py-1 rounded-pill">+12%</span>
              <span class="text-muted small ms-1">this month</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #ffffff 0%, #ecfdf5 100%);">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="text-muted small text-uppercase fw-semibold">Interviews</span>
              <div class="rounded-3 bg-success p-2 shadow-sm">
                <i class="bi bi-calendar-check text-white"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold display-6 text-success" id="stat-interviews">0</span>
              <span class="text-muted small">scheduled</span>
            </div>
            <div class="mt-2">
              <span class="badge bg-warning bg-opacity-15 text-warning px-2 py-1 rounded-pill">3 pending</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="text-muted small text-uppercase fw-semibold">Profile Views</span>
              <div class="rounded-3 bg-info p-2 shadow-sm">
                <i class="bi bi-eye text-white"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold display-6 text-info" id="stat-views">0</span>
              <span class="text-muted small">this week</span>
            </div>
            <div class="mt-2">
              <span class="badge bg-primary bg-opacity-15 text-primary px-2 py-1 rounded-pill">+28%</span>
              <span class="text-muted small ms-1">vs last week</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%);">
          <div class="card-body p-3 p-xl-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="text-muted small text-uppercase fw-semibold">Saved Jobs</span>
              <div class="rounded-3 bg-warning p-2 shadow-sm">
                <i class="bi bi-bookmark text-white"></i>
              </div>
            </div>
            <div class="d-flex align-items-baseline gap-1">
              <span class="fw-bold display-6 text-warning" id="stat-saved">0</span>
              <span class="text-muted small">jobs</span>
            </div>
            <div class="mt-2">
              <a href="#" class="text-primary small text-decoration-none fw-semibold">View all <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Main Content Row --}}
    <div class="row g-3 g-lg-4">
      
      {{-- LEFT COLUMN - Profile & CV Section --}}
      <div class="col-lg-4">
        
        {{-- Profile Card with Blue Border --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
          <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <div class="d-flex justify-content-between align-items-center">
              <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">Active Member</span>
              <button onclick="comingSoon()" class="btn btn-sm btn-outline-primary rounded-pill">
                <i class="bi bi-pencil-square me-1"></i> Edit
              </button>
            </div>
          </div>
          <div class="card-body p-4 text-center">
            <div class="position-relative d-inline-block mx-auto mb-3">
              <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mx-auto shadow-lg" 
                   style="width: 110px; height: 110px; background: linear-gradient(135deg, #3b82f6, #1e40af);">
                <span class="fw-bold fs-1 text-white">
                  {{ strtoupper(substr(session('web_user.first_name', 'U'), 0, 1)) }}{{ strtoupper(substr(session('web_user.last_name', ''), 0, 1)) }}
                </span>
              </div>
              <button onclick="comingSoon()" class="btn btn-sm btn-light rounded-circle position-absolute bottom-0 end-0 p-1 shadow-sm border-2 border-white" 
                      style="width: 32px; height: 32px; background: #3b82f6;">
                <i class="bi bi-camera-fill fs-6 text-white"></i>
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
                  <div class="text-start p-2 rounded-3" style="background: #f0f7ff;">
                    <div class="text-muted small">Member since</div>
                    <div class="fw-semibold text-primary">Nov 2024</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-start p-2 rounded-3" style="background: #f0f7ff;">
                    <div class="text-muted small">Last active</div>
                    <div class="fw-semibold text-primary">Today</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- CV Enhancement Campaign Card --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
        <div class="card-body p-4 text-center text-white">
            <div class="mb-3">
            <div class="rounded-3 bg-white bg-opacity-20 p-2 d-inline-block">
                <i class="bi bi-stars fs-1"></i>
            </div>
            </div>
            <h5 class="fw-bold mb-2">Land Your Dream Job Faster</h5>
            <p class="small opacity-90 mb-3">AI-powered CV enhancement + cover letter generator</p>
            <div class="row g-2 mb-3">
            <div class="col-6">
                <div class="bg-white bg-opacity-20 rounded-3 p-2">
                <i class="bi bi-check-circle-fill me-1 fs-6 text-white"></i>
                <span class="small fw-semibold text-white">ATS Score</span>
                </div>
            </div>
            <div class="col-6">
                <div class="bg-white bg-opacity-20 rounded-3 p-2">
                <i class="bi bi-pencil-square me-1 fs-6 text-white"></i>
                <span class="small fw-semibold text-white">Cover Letters</span>
                </div>
            </div>
            </div>
            <div class="d-flex justify-content-center gap-2 mb-3">
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Uganda</span>
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Kenya</span>
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Tanzania</span>
            </div>
            <div class="d-flex justify-content-center gap-2 mb-3">
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Rwanda</span>
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">Zambia</span>
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">DRC</span>
            </div>
            <div class="mb-3">
            <span class="display-6 fw-bold text-white">$5</span>
            <span class="small text-white opacity-75">/month</span>
            <span class="badge bg-warning text-dark ms-2 rounded-pill">Save 40%</span>
            </div>
            <p class="small text-white opacity-75 mb-3">~ UGX 18,500 | KES 650 | TZS 12,500 | RWF 6,500 | ZMW 135</p>
            <button onclick="subscribeAI()" class="btn btn-white text-primary fw-semibold rounded-pill px-4 py-2 w-100 shadow-sm" style="background: white; color: #1e40af !important;">
            <i class="bi bi-lightning-charge me-2"></i>Get Instant Access
            </button>
            <p class="small mt-3 mb-0 text-white opacity-75">Cancel anytime • No hidden fees</p>
        </div>
        </div>

        {{-- Profile Completion Card --}}
        <div class="card border-0 shadow-lg rounded-4">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold mb-0">Profile Strength</h6>
              <span class="badge bg-primary rounded-pill px-3 py-2">65%</span>
            </div>
            <div class="progress mb-3" style="height: 8px; background: #e2e8f0;">
              <div class="progress-bar bg-primary rounded-pill" style="width: 65%;" role="progressbar"></div>
            </div>
            <div class="space-y-2">
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span class="small text-muted">Basic info completed</span>
              </div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span class="small text-muted">Email verified</span>
              </div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-circle text-secondary"></i>
                <span class="small text-muted">CV not uploaded</span>
              </div>
              <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-circle text-secondary"></i>
                <span class="small text-muted">Work experience missing</span>
              </div>
            </div>
            <button onclick="comingSoon()" class="btn btn-outline-primary w-100 rounded-pill">
              <i class="bi bi-arrow-up-circle me-2"></i>Complete Profile
            </button>
          </div>
        </div>

      </div>

      {{-- RIGHT COLUMN - CV Enhancement Suite (First Tab) --}}
      <div class="col-lg-8">
        
        {{-- Tabs Navigation with Blue Underline --}}
        <ul class="nav nav-tabs border-0 gap-3 mb-4" id="dashboardTabs" role="tablist" style="border-bottom: 2px solid #e2e8f0;">
          <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 py-2 fw-semibold" id="cv-enhancement-tab" data-bs-toggle="tab" 
                    data-bs-target="#cv-enhancement" type="button" role="tab" style="border: none; background: transparent;">
              <i class="bi bi-magic me-2"></i>CV Enhancement Suite
              <span class="badge bg-danger ms-2 rounded-pill small">AI Pro</span>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2 fw-semibold" id="applications-tab" data-bs-toggle="tab" 
                    data-bs-target="#applications" type="button" role="tab" style="border: none; background: transparent;">
              <i class="bi bi-send me-2"></i>Applications
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2 fw-semibold" id="saved-tab" data-bs-toggle="tab" 
                    data-bs-target="#saved" type="button" role="tab" style="border: none; background: transparent;">
              <i class="bi bi-bookmark me-2"></i>Saved Jobs
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2 fw-semibold" id="activity-tab" data-bs-toggle="tab" 
                    data-bs-target="#activity" type="button" role="tab" style="border: none; background: transparent;">
              <i class="bi bi-activity me-2"></i>Activity
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2 fw-semibold" id="settings-tab" data-bs-toggle="tab" 
                    data-bs-target="#settings" type="button" role="tab" style="border: none; background: transparent;">
              <i class="bi bi-gear me-2"></i>Settings
            </button>
          </li>
        </ul>

        <div class="tab-content">
          
          {{-- CV ENHANCEMENT SUITE TAB (First Tab - Marketing Focus) --}}
          <div class="tab-pane fade show active" id="cv-enhancement" role="tabpanel">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
              {{-- Hero Section --}}
              <div class="bg-gradient-primary text-white p-4" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                <div class="d-flex align-items-center gap-3">
                  <div class="rounded-3 bg-white bg-opacity-20 p-3">
                    <i class="bi bi-rocket-takeoff fs-1"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold mb-1">Get Noticed by Top Employers</h5>
                    <p class="small opacity-90 mb-0">AI-powered CV optimization + custom cover letters = 3x more interviews</p>
                  </div>
                </div>
              </div>
              
              <div class="card-body p-4">
                {{-- Two Column Features --}}
                <div class="row g-4 mb-4">
                  <div class="col-md-6">
                    <div class="rounded-4 p-3 h-100" style="background: #f0f7ff;">
                      <div class="rounded-3 bg-primary bg-opacity-10 p-2 d-inline-block mb-2">
                        <i class="bi bi-file-earmark-text fs-4 text-primary"></i>
                      </div>
                      <h6 class="fw-bold mb-2">AI Resume Review</h6>
                      <p class="small text-muted mb-2">Get instant ATS score, keyword analysis, and professional formatting suggestions.</p>
                      <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">ATS Check</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Keyword Boost</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Format Fix</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="rounded-4 p-3 h-100" style="background: #f0f7ff;">
                      <div class="rounded-3 bg-primary bg-opacity-10 p-2 d-inline-block mb-2">
                        <i class="bi bi-envelope-paper fs-4 text-primary"></i>
                      </div>
                      <h6 class="fw-bold mb-2">AI Cover Letter Generator</h6>
                      <p class="small text-muted mb-2">Generate tailored cover letters for any job description in seconds.</p>
                      <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Job Matching</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Customizable</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Download PDF</span>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- Upload Area --}}
                <div class="mb-4">
                  <label class="fw-semibold mb-2">Upload Your CV (PDF, DOC, DOCX)</label>
                  <div id="cvUploadAreaEnhance" 
                       class="border border-2 border-primary border-dashed rounded-3 p-4 text-center cursor-pointer"
                       style="border-style: dashed !important; cursor: pointer; transition: all .2s; background: #f8faff;"
                       onclick="document.getElementById('cvFileInputEnhance').click()">
                    <i class="bi bi-cloud-upload fs-2 text-primary mb-2 d-block"></i>
                    <p class="mb-1 small fw-semibold text-primary">Click to upload or drag & drop</p>
                    <p class="text-muted small mb-0">Max 5MB • Secure & private</p>
                    <input type="file" id="cvFileInputEnhance" class="d-none" accept=".pdf,.doc,.docx">
                  </div>
                  <div id="cvFileInfoEnhance" class="d-none mt-3">
                    <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-3">
                      <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>
                      <span class="small flex-grow-1 fw-semibold" id="cvFileNameEnhance">resume.pdf</span>
                      <button onclick="removeCVEnhance()" class="btn btn-sm btn-outline-danger rounded-pill">
                        <i class="bi bi-trash me-1"></i> Remove
                      </button>
                    </div>
                  </div>
                </div>

                {{-- Job Description Input for Cover Letter --}}
                <div class="mb-4">
                  <label class="fw-semibold mb-2">Job Description (for custom cover letter)</label>
                  <textarea id="jobDescription" class="form-control rounded-3" rows="3" placeholder="Paste the job description here... We'll generate a tailored cover letter instantly!"></textarea>
                </div>

                {{-- Action Buttons --}}
                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <button class="btn btn-outline-primary w-100 rounded-pill py-2" onclick="analyzeCV()">
                      <i class="bi bi-graph-up me-2"></i>Analyze CV for Free
                    </button>
                  </div>
                  <div class="col-md-6">
                    <button class="btn btn-primary w-100 rounded-pill py-2" onclick="generateCoverLetter()">
                      <i class="bi bi-magic me-2"></i>Generate Cover Letter
                    </button>
                  </div>
                </div>

                {{-- Results Preview Area --}}
                <div id="aiResults" class="d-none">
                  <div class="border-top pt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <h6 class="fw-bold mb-0">AI Analysis Results</h6>
                      <button onclick="upgradeToView()" class="btn btn-sm btn-primary rounded-pill">
                        <i class="bi bi-lock me-1"></i> Upgrade to Unlock
                      </button>
                    </div>
                    <div class="bg-light rounded-3 p-3 text-center text-muted">
                      <i class="bi bi-star fs-4"></i>
                      <p class="small mb-0">Subscribe to see your ATS score, keyword analysis, and download your custom cover letter.</p>
                    </div>
                  </div>
                </div>

                {{-- Social Proof / Testimonials --}}
                <div class="mt-4 pt-3 border-top">
                  <div class="d-flex gap-3 align-items-center justify-content-center flex-wrap">
                    <div class="text-center">
                      <i class="bi bi-people-fill text-primary fs-4"></i>
                      <p class="small text-muted mb-0">1,000+ job seekers</p>
                    </div>
                    <div class="text-center">
                      <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                      <p class="small text-muted mb-0">3x more interviews</p>
                    </div>
                    <div class="text-center">
                      <i class="bi bi-clock-history text-warning fs-4"></i>
                      <p class="small text-muted mb-0">5-min optimization</p>
                    </div>
                  </div>
                </div>

                {{-- Pricing Card --}}
                <div class="mt-4 p-3 rounded-4 text-center" style="background: linear-gradient(135deg, #f0f7ff, #e0e7ff);">
                  <div class="d-flex justify-content-center gap-4 align-items-center flex-wrap">
                    <div>
                      <span class="text-muted small">Starting from</span>
                      <span class="display-6 fw-bold text-primary">$5</span>
                      <span class="text-muted small">/month</span>
                    </div>
                    <div class="vr d-none d-md-block"></div>
                    <div>
                      <i class="bi bi-check-circle-fill text-success me-1"></i>
                      <span class="small fw-semibold">Unlimited CV reviews</span>
                    </div>
                    <div>
                      <i class="bi bi-check-circle-fill text-success me-1"></i>
                      <span class="small fw-semibold">100+ cover letters/month</span>
                    </div>
                    <button onclick="subscribeAI()" class="btn btn-primary rounded-pill px-4">
                      <i class="bi bi-lightning-charge me-1"></i>Subscribe Now
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Applications Tab --}}
          <div class="tab-pane fade" id="applications" role="tabpanel">
            <div class="card border-0 shadow-lg rounded-4">
              <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="fw-bold mb-0">Recent Applications</h6>
                  <a href="#" class="text-primary small text-decoration-none fw-semibold">View all <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
              </div>
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
            <div class="card border-0 shadow-lg rounded-4">
              <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="fw-bold mb-0">Saved Jobs</h6>
                  <span class="badge bg-primary rounded-pill px-3 py-2" id="savedCount">0</span>
                </div>
              </div>
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
            <div class="card border-0 shadow-lg rounded-4">
              <div class="card-body p-4">
                <div class="timeline">
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
          </div>

          {{-- Settings Tab --}}
          <div class="tab-pane fade" id="settings" role="tabpanel">
            <div class="card border-0 shadow-lg rounded-4">
              <div class="card-body p-4">
                <form id="profileSettingsForm">
                  <h6 class="fw-bold mb-3">Personal Information</h6>
                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <label class="form-label small fw-semibold">First Name</label>
                      <input type="text" class="form-control rounded-3" value="{{ session('web_user.first_name') }}">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label small fw-semibold">Last Name</label>
                      <input type="text" class="form-control rounded-3" value="{{ session('web_user.last_name') }}">
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Email Address</label>
                      <input type="email" class="form-control rounded-3 bg-light" value="{{ session('web_user.email') }}" readonly disabled>
                      <small class="text-muted">Email cannot be changed</small>
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Phone Number</label>
                      <input type="tel" class="form-control rounded-3" value="{{ session('web_user.phone') ?? '' }}" placeholder="+256 XXX XXX XXX">
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

    {{-- AI Recommendation Section with Blue Header --}}
    <div class="mt-5">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white border-0 p-4" style="background: linear-gradient(135deg, #2563eb, #1e3a8a);">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-2 bg-white bg-opacity-20 p-2">
              <i class="bi bi-robot fs-3"></i>
            </div>
            <div>
              <h6 class="fw-bold mb-0">AI-Powered Job Recommendations</h6>
              <small class="opacity-75">Personalized matches based on your profile and preferences</small>
            </div>
            <span class="badge bg-white text-primary ms-auto rounded-pill px-3 py-2">Smart Match</span>
          </div>
        </div>
        <div class="card-body p-4" style="background: #f8faff;">
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
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-body text-center py-5 px-4">
        <div class="rounded-3 bg-primary bg-opacity-10 p-3 d-inline-block mb-3">
          <i class="bi bi-tools fs-1 text-primary"></i>
        </div>
        <h5 class="fw-bold mb-2">Coming Soon!</h5>
        <p class="text-muted mb-0">We're working hard to bring you this feature. Stay tuned for updates!</p>
        <button type="button" class="btn btn-primary rounded-pill mt-4 px-5" data-bs-dismiss="modal">Got it</button>
      </div>
    </div>
  </div>
</div>

{{-- Subscribe Modal --}}
<div class="modal fade" id="subscribeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-body text-center py-5 px-4">
        <div class="rounded-3 bg-success bg-opacity-10 p-3 d-inline-block mb-3">
          <i class="bi bi-lightning-charge fs-1 text-success"></i>
        </div>
        <h5 class="fw-bold mb-2">Unlock AI CV Suite</h5>
        <p class="text-muted mb-3">Get instant access to AI resume reviews and custom cover letters for just <strong class="text-primary">$5/month</strong></p>
        <div class="text-start bg-light rounded-3 p-3 mb-3">
          <p class="small fw-semibold mb-2">What's included:</p>
          <ul class="small text-muted mb-0">
            <li>Unlimited AI resume reviews & ATS scoring</li>
            <li>100+ custom cover letters per month</li>
            <li>Keyword optimization suggestions</li>
            <li>Priority support & weekly tips</li>
            <li>Cancel anytime, no questions asked</li>
          </ul>
        </div>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-primary rounded-pill flex-grow-1" onclick="processPayment()">
            <i class="bi bi-credit-card me-2"></i>Subscribe Now
          </button>
          <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Maybe later</button>
        </div>
        <p class="small text-muted mt-3 mb-0">Secure payment via Pesapal • Supports UGX, KES, TZS, RWF, ZMW</p>
      </div>
    </div>
  </div>
</div>

<style>
  /* Modern Dashboard Styles */
  .display-6 {
    font-size: 1.75rem;
    font-weight: 700;
  }
  
  .stat-card {
    transition: all 0.3s ease;
  }
  
  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 30px -15px rgba(59, 130, 246, 0.2) !important;
  }
  
  .nav-tabs .nav-link {
    color: #64748b;
    transition: all 0.2s;
    position: relative;
  }
  
  .nav-tabs .nav-link:hover {
    color: #3b82f6;
  }
  
  .nav-tabs .nav-link.active {
    color: #2563eb;
    background: transparent;
    border-bottom: 3px solid #2563eb !important;
  }
  
  .nav-tabs .nav-link.active i {
    color: #2563eb;
  }
  
  .border-dashed {
    border-style: dashed !important;
  }
  
  .bg-gradient-primary {
    background: linear-gradient(135deg, #2563eb, #1e3a8a);
  }
  
  .shadow-xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  }
  
  #cvUploadAreaEnhance:hover {
    background: #f0f4ff !important;
    border-color: #2563eb !important;
  }
  
  .timeline {
    position: relative;
    padding-left: 24px;
  }
  
  .timeline::before {
    content: '';
    position: absolute;
    left: 23px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, #3b82f6, #93c5fd);
  }
  
  .timeline > div {
    position: relative;
  }
  
  .timeline > div::before {
    content: '';
    position: absolute;
    left: -24px;
    top: 12px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #3b82f6;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #bfdbfe;
  }
  
  @media (max-width: 768px) {
    .display-6 {
      font-size: 1.25rem;
    }
    
    .nav-tabs {
      flex-wrap: nowrap;
      overflow-x: auto;
      scrollbar-width: thin;
    }
    
    .nav-tabs .nav-link {
      white-space: nowrap;
      padding: 8px 16px;
      font-size: 13px;
    }
    
    .card-body {
      padding: 1rem !important;
    }
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .card {
    animation: fadeInUp 0.5s ease-out;
  }
  
  /* Custom scrollbar */
  ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #3b82f6;
    border-radius: 10px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #2563eb;
  }
</style>

<script>
function comingSoon() {
  const modal = new bootstrap.Modal(document.getElementById('comingSoonModal'));
  modal.show();
}

function subscribeAI() {
  const modal = new bootstrap.Modal(document.getElementById('subscribeModal'));
  modal.show();
}

function processPayment() {
  // Redirect to Pesapal payment gateway
  showToast('Redirecting to secure payment gateway...', 'info');
  setTimeout(() => {
    window.location.href = '/payment/subscribe?plan=ai_cv_suite';
  }, 1000);
}

function logoutConfirm() {
  if (confirm('Are you sure you want to logout?')) {
    document.getElementById('logout-form')?.submit();
  }
}

// CV Upload Handling
document.getElementById('cvFileInputEnhance')?.addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (!validTypes.includes(file.type)) {
      showToast('Please upload PDF or DOC/DOCX files only', 'danger');
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      showToast('File size must be less than 5MB', 'danger');
      return;
    }
    
    document.getElementById('cvFileNameEnhance').textContent = file.name;
    document.getElementById('cvUploadAreaEnhance').classList.add('d-none');
    document.getElementById('cvFileInfoEnhance').classList.remove('d-none');
    showToast('CV uploaded successfully! Ready for AI analysis.', 'success');
  }
});

function removeCVEnhance() {
  document.getElementById('cvFileInputEnhance').value = '';
  document.getElementById('cvUploadAreaEnhance').classList.remove('d-none');
  document.getElementById('cvFileInfoEnhance').classList.add('d-none');
  showToast('CV removed', 'info');
}

function analyzeCV() {
  const fileInput = document.getElementById('cvFileInputEnhance');
  if (!fileInput.files.length) {
    showToast('Please upload your CV first', 'warning');
    return;
  }
  document.getElementById('aiResults').classList.remove('d-none');
  showToast('CV analysis ready! Upgrade to see full results.', 'info');
}

function generateCoverLetter() {
  const jobDesc = document.getElementById('jobDescription').value;
  if (!jobDesc.trim()) {
    showToast('Please paste a job description first', 'warning');
    return;
  }
  document.getElementById('aiResults').classList.remove('d-none');
  showToast('Cover letter generated! Upgrade to download.', 'info');
}

function upgradeToView() {
  subscribeAI();
}

// Animate stats counters
function animateCounter(element, target) {
  if (!element) return;
  let current = 0;
  const increment = target / 50;
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      element.textContent = target;
      clearInterval(timer);
    } else {
      element.textContent = Math.floor(current);
    }
  }, 20);
}

// Load recommended jobs
function loadRecommendedJobs() {
  const container = document.getElementById('recommendedJobs');
  if (!container) return;
  
  setTimeout(() => {
    container.innerHTML = `
      <div class="col-md-6 col-lg-4">
        <div class="job-card border-0 rounded-4 p-3 h-100 shadow-sm" style="background: white;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="rounded-2 bg-primary bg-opacity-10 p-2">
              <i class="bi bi-briefcase text-primary"></i>
            </div>
            <h6 class="fw-bold mb-0">Senior Software Engineer</h6>
          </div>
          <p class="text-muted small mb-2">TechCorp Uganda</p>
          <div class="d-flex gap-2 mb-3">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Full-time</span>
            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Remote</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-primary fw-semibold small">UGX 3M - 5M</span>
            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="comingSoon()">View</button>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="job-card border-0 rounded-4 p-3 h-100 shadow-sm" style="background: white;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="rounded-2 bg-primary bg-opacity-10 p-2">
              <i class="bi bi-briefcase text-primary"></i>
            </div>
            <h6 class="fw-bold mb-0">Product Manager</h6>
          </div>
          <p class="text-muted small mb-2">Innovate Ltd</p>
          <div class="d-flex gap-2 mb-3">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Full-time</span>
            <span class="badge bg-info bg-opacity-10 text-info rounded-pill">Hybrid</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-primary fw-semibold small">UGX 4M - 6M</span>
            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="comingSoon()">View</button>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="job-card border-0 rounded-4 p-3 h-100 shadow-sm" style="background: white;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="rounded-2 bg-primary bg-opacity-10 p-2">
              <i class="bi bi-brush text-primary"></i>
            </div>
            <h6 class="fw-bold mb-0">UI/UX Designer</h6>
          </div>
          <p class="text-muted small mb-2">Creative Studios</p>
          <div class="d-flex gap-2 mb-3">
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">Contract</span>
            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">On-site</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span class="text-primary fw-semibold small">UGX 2.5M - 3.5M</span>
            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="comingSoon()">View</button>
          </div>
        </div>
      </div>
    `;
  }, 800);
}

// Initialize stats with animation
document.addEventListener('DOMContentLoaded', function() {
  animateCounter(document.getElementById('stat-applications'), 12);
  animateCounter(document.getElementById('stat-interviews'), 3);
  animateCounter(document.getElementById('stat-views'), 128);
  animateCounter(document.getElementById('stat-saved'), 5);
  
  loadRecommendedJobs();
});
</script>

@endsection