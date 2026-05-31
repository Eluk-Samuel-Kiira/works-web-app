@extends('layouts.jobs')

@section('title', 'Feature Your Job Posting | Boost Visibility | Stardena Works')
@section('meta_description', 'Feature your job listing on Stardena Works to get 3x more applicants. Choose from 7, 21, or 40-day featured packages starting at UGX 50,000. Top placement in search results, priority email alerts, and social media promotion included.')
@section('canonical', url('/post-featured-jobs'))
@section('robots', 'index, follow')

{{-- Override OG tags specifically for this page --}}
@section('og_title', 'Feature Your Job Posting - Get 3x More Applicants')
@section('og_description', 'Boost your job listing with featured placement. Attract qualified candidates faster with top visibility on Stardena Works.')
@section('og_url', url('/post-featured-jobs'))
@section('og_type', 'website')
@section('og_image', getFavicon())

{{-- Override Twitter Card --}}
@section('twitter_title', 'Feature Your Job Posting | Stardena Works')
@section('twitter_description', 'Get 3x more applicants with featured job listings. Starting at UGX 50,000.')
@section('twitter_image', getFavicon())

@section('job-content')
@section('job-content')

{{-- resources/views/partials/featured-job-addons.blade.php --}}
<section id="featured-addons" class="py-5 py-lg-6" style="background: linear-gradient(135deg, #fff5eb 0%, #ffffff 100%); scroll-margin-top: 80px;">
  <div class="container-xl px-3 px-md-4">
    
    {{-- Campaign Header --}}
    <div class="text-center mb-5">
      <div class="d-inline-flex align-items-center gap-2 bg-warning bg-opacity-20 rounded-pill px-4 py-2 mb-3">
        <i class="bi bi-star-fill text-warning"></i>
        <span class="small fw-semibold text-warning">Boost Visibility</span>
      </div>
      <h2 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">Feature Your <span style="color: #f59e0b;">Job Posting</span></h2>
      <p class="text-muted fs-5 mb-3">Get 3x more applicants with featured job listings</p>
      <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Top Search Results</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Featured Badge</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Email Alerts Priority</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Social Media Promotion</span></div>
      </div>
    </div>

    {{-- Currency Selector --}}
    <div class="d-flex justify-content-end mb-4">
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" id="currencyDropdownBtn">
          <i class="bi bi-currency-exchange me-1"></i> <span id="selectedCurrencyDisplay">USD ($)</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" id="currencyList" style="max-height: 300px; overflow-y: auto;"></ul>
      </div>
    </div>

    {{-- Loading State --}}
    <div id="addonsLoading" class="text-center py-5">
      <div class="spinner-border text-warning" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-muted mt-2">Loading featured packages...</p>
    </div>

    {{-- Featured Plans Container --}}
    <div id="featuredPlans" class="row g-4 mb-5" style="display: none;"></div>

  </div>
</section>

{{-- Payment Modal --}}
<div class="modal fade" id="featuredPaymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-header border-0 p-4 pb-0">
        <div>
          <h5 class="modal-title fw-bold">Feature Your Job</h5>
          <p class="text-muted small mb-0">Step <span id="modalStepIndicator">1</span> of 2</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      {{-- Step progress --}}
      <div class="px-4 pt-3">
        <div class="progress" style="height:4px;">
          <div class="progress-bar bg-warning" id="modalProgressBar" style="width:50%;transition:width .3s ease;"></div>
        </div>
      </div>

      <div class="modal-body p-4">

        {{-- ── STEP 1: Job Details ─────────────────────────────── --}}
        <div id="modalStep1">
          <div class="row g-4">

            {{-- Left: Package Summary --}}
            <div class="col-md-4">
              <div class="bg-warning bg-opacity-10 rounded-4 p-4 text-center h-100">
                <div class="rounded-2 bg-warning bg-opacity-20 d-inline-flex p-2 mb-3" id="modalIcon">
                  <i class="bi bi-star-fill fs-2 text-warning"></i>
                </div>
                <h5 class="fw-bold mb-1" id="modalPlanTitle">Featured - 7 Days</h5>
                <p class="text-muted small mb-2" id="modalPlanDesc"></p>
                <div class="mb-3">
                  <span class="display-6 fw-bold text-warning" id="modalPrice"></span>
                  <span class="text-muted small"> one-time</span>
                </div>
                <hr>
                <ul class="list-unstyled text-start small" id="modalFeatures"></ul>
              </div>
            </div>

            {{-- Right: Job Details Form --}}
            <div class="col-md-8">
              <h6 class="fw-bold mb-3"><i class="bi bi-briefcase me-2 text-warning"></i>Job Details</h6>
              <p class="text-muted small mb-3">Paste your job posting or upload a file. We'll handle the rest.</p>

              {{-- Tab toggle --}}
              <div class="d-flex gap-2 mb-3">
                <button class="btn btn-sm btn-warning rounded-pill px-3 fw-semibold" id="pasteTabBtn" onclick="switchJobTab('paste')">
                  <i class="bi bi-clipboard me-1"></i>Paste Text
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="uploadTabBtn" onclick="switchJobTab('upload')">
                  <i class="bi bi-upload me-1"></i>Upload File
                </button>
              </div>

              {{-- Paste tab --}}
              <div id="pasteTab">
                <textarea class="form-control rounded-3" id="jobDetailsText" rows="8"
                  placeholder="Paste your full job posting here...&#10;&#10;Example:&#10;Job Title: Senior Accountant&#10;Company: ABC Ltd&#10;Location: Kampala, Uganda&#10;&#10;Job Description:&#10;We are looking for...&#10;&#10;Requirements:&#10;• Bachelor's degree...&#10;• 5+ years experience...&#10;&#10;How to Apply:&#10;Send CV to hr@abc.com"></textarea>
                <div class="d-flex justify-content-between mt-1">
                  <small class="text-muted">Minimum 100 characters</small>
                  <small class="text-muted" id="jobTextCount">0 chars</small>
                </div>
                <div class="text-danger small mt-1 d-none" id="jobTextErr"></div>
              </div>

              {{-- Upload tab --}}
              <div id="uploadTab" class="d-none">
                <div class="border border-2 border-dashed rounded-3 text-center p-4"
                     style="border-color:#f59e0b!important;background:#fffbeb;cursor:pointer;"
                     id="jobFileDropZone"
                     onclick="document.getElementById('jobFileInput').click()"
                     ondragover="event.preventDefault();this.style.background='#fef3c7'"
                     ondragleave="this.style.background='#fffbeb'"
                     ondrop="handleJobFileDrop(event)">
                  <input type="file" id="jobFileInput" class="d-none"
                         accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png"
                         onchange="handleJobFileSelect(this)">
                  <i class="bi bi-cloud-arrow-up fs-2 text-warning opacity-75 mb-1 d-block"></i>
                  <p class="small fw-semibold text-warning mb-0">Click or drag & drop your job file</p>
                  <p class="small text-muted mb-0">PDF, DOC, DOCX, TXT, JPG, PNG — max 10MB</p>
                </div>
                <div id="jobFilePreview" class="d-none mt-2">
                  <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-2 border">
                    <i class="bi bi-file-earmark text-warning fs-5"></i>
                    <span class="small fw-semibold flex-grow-1 text-truncate" id="jobFileName"></span>
                    <span class="small text-muted" id="jobFileSize"></span>
                    <button class="btn btn-sm btn-link text-danger p-0" onclick="clearJobFile()">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </div>
                </div>
                <div class="text-danger small mt-1 d-none" id="jobFileErr"></div>
              </div>

            </div>
          </div>

          <div class="d-flex justify-content-end mt-4">
            <button class="btn btn-warning rounded-pill px-5 py-2 fw-semibold" onclick="goToStep2()">
              Continue to Payment <i class="bi bi-arrow-right ms-2"></i>
            </button>
          </div>
        </div>

        {{-- ── STEP 2: Payer Details ────────────────────────────── --}}
        <div id="modalStep2" class="d-none">
          <div class="row g-4">

            {{-- Left: Package + Job Summary --}}
            <div class="col-md-4">
              <div class="bg-warning bg-opacity-10 rounded-4 p-4 h-100">
                <h6 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning me-2"></i><span id="step2PlanTitle"></span></h6>
                <div class="mb-3">
                  <span class="fs-4 fw-bold text-warning" id="step2Price"></span>
                  <span class="text-muted small"> one-time</span>
                </div>
                <hr>
                <div class="small">
                  <div class="fw-semibold text-muted mb-1">Job Summary</div>
                  <div id="step2JobSummary" class="text-muted" style="font-size:11px;line-height:1.5;max-height:120px;overflow:hidden;"></div>
                </div>
                <hr>
                <div class="small text-muted">
                  <i class="bi bi-shield-check text-success me-1"></i>
                  Secured by <strong>Pesapal</strong>
                </div>
              </div>
            </div>

            {{-- Right: Contact Details --}}
            <div class="col-md-8">
              <h6 class="fw-bold mb-3"><i class="bi bi-person me-2 text-warning"></i>Your Contact Details</h6>
              <p class="text-muted small mb-3">Where should we send the confirmation and feature activation?</p>

              <div class="mb-3">
                <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded-3" id="payerName" placeholder="John Doe">
                <div class="text-danger small mt-1 d-none" id="payerNameErr"></div>
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control rounded-3" id="payerEmail" placeholder="john@company.com">
                <div class="text-muted small mt-1">Confirmation + receipt sent here</div>
                <div class="text-danger small mt-1 d-none" id="payerEmailErr"></div>
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Phone Number <span class="text-muted fw-normal">(for mobile money)</span></label>
                <input type="tel" class="form-control rounded-3" id="payerPhone" placeholder="+256 XXX XXX XXX">
              </div>
              <div class="mb-4">
                <label class="form-label small fw-semibold">Company / Organisation Name</label>
                <input type="text" class="form-control rounded-3" id="payerCompany" placeholder="ABC Ltd">
              </div>

              <div class="alert alert-warning small p-3 rounded-3 mb-3" style="background:#fffbeb;border:1px solid #f59e0b20;">
                <i class="bi bi-info-circle me-2"></i>
                Your job will be reviewed and featured within <strong>An hour</strong> of payment confirmation.
              </div>

              <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary rounded-pill px-4" onclick="goToStep1()">
                  <i class="bi bi-arrow-left me-1"></i>Back
                </button>
                <button class="btn btn-warning rounded-pill flex-grow-1 py-2 fw-semibold" id="payNowBtn" onclick="processFeaturedPayment()">
                  <i class="bi bi-lock me-2"></i>Pay with Pesapal
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
.dropdown-item.active { background-color: rgba(var(--bs-primary-rgb), 0.1) !important; color: var(--bs-primary) !important; }
.shadow-xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
#featuredPlans .card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
#featuredPlans .card:hover { transform: translateY(-4px); }
</style>

<script>
(function() {
    const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    const API_TOKEN = '{{ session("api_token") }}';
    const IS_LOGGED_IN = {{ session()->has('web_user') ? 'true' : 'false' }};
    const CSRF_TOKEN = '{{ csrf_token() }}';
    
    let featuredPlans = [];
    let supportedCurrencies = [];
    let currentCurrency = null;
    let selectedPackage = null;

    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        detectAndSetCurrency();
    });

    async function detectAndSetCurrency() {
        try {
            let countryCode = null;
            
            // Try multiple geo APIs with fallbacks
            try {
                // Use ip-api.com first (no CORS issues, HTTP only)
                const res = await fetch('http://ip-api.com/json/', { 
                    signal: AbortSignal.timeout(5000),
                    mode: 'cors'
                });
                if (res.ok) {
                    const data = await res.json();
                    countryCode = data.countryCode;
                    console.log('Geo detected via ip-api.com:', countryCode);
                }
            } catch(e) { 
                console.log('ip-api.com failed:', e); 
            }
            
            // Fallback to freegeoip.app
            if (!countryCode) {
                try {
                    const res = await fetch('https://freegeoip.app/json/', { 
                        signal: AbortSignal.timeout(5000)
                    });
                    if (res.ok) {
                        const data = await res.json();
                        countryCode = data.country_code;
                        console.log('Geo detected via freegeoip.app:', countryCode);
                    }
                } catch(e) { 
                    console.log('freegeoip.app failed:', e); 
                }
            }
            
            // Load plans with detected country (pass to API for server-side detection)
            await loadPlans(countryCode);
            
        } catch(error) {
            console.error('Detection failed:', error);
            await loadPlans(null);
        }
    }

    async function loadPlans(countryCode = null) {
        const loadingEl = document.getElementById('addonsLoading');
        const container = document.getElementById('featuredPlans');
        
        loadingEl.style.display = 'block';
        container.style.display = 'none';
        
        try {
            // Build URL with current currency or country
            let url = `${API_BASE}/v1/payment-plans?audience=employer`;
            
            // If we have a current currency, use it
            if (currentCurrency && currentCurrency.code) {
                url += `&currency=${currentCurrency.code}`;
            } 
            // Otherwise pass country for detection
            else if (countryCode) {
                url += `&country=${countryCode}`;
            }
            
            console.log('Loading plans from:', url);
            
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${API_TOKEN}`
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.data) {
                const allPlans = data.data.plans || [];
                supportedCurrencies = data.data.supported_currencies || [];
                
                // Set current currency from detected or default
                if (!currentCurrency) {
                    currentCurrency = data.data.detected_currency || { code: 'USD', symbol: '$', name: 'US Dollar', flag: '🇺🇸' };
                }
                
                // Filter only featured add-on plans
                featuredPlans = allPlans.filter(p => 
                    p.name.includes('featured') || p.billing_period === 'one_time'
                );
                
                renderPlans();
                populateCurrencyList();
                updateCurrencyDisplay();
                
                loadingEl.style.display = 'none';
                container.style.display = 'flex';
                
                if (currentCurrency.code !== 'USD') {
                    showToast(`💱 Prices shown in ${currentCurrency.name} based on your location`, 'info');
                }
            } else {
                throw new Error('Invalid response');
            }
        } catch(error) {
            console.error('Error loading plans:', error);
            loadingEl.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Failed to load featured packages. <a href="javascript:location.reload()">Refresh</a> to try again.
                </div>
            `;
        }
    }

    // Reload plans with new currency
    async function reloadPlansWithCurrency(currencyCode) {
        const loadingEl = document.getElementById('addonsLoading');
        const container = document.getElementById('featuredPlans');
        
        loadingEl.style.display = 'block';
        container.style.display = 'none';
        
        try {
            const url = `${API_BASE}/v1/payment-plans?audience=employer&currency=${currencyCode}`;
            
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${API_TOKEN}`
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.data) {
                const allPlans = data.data.plans || [];
                supportedCurrencies = data.data.supported_currencies || [];
                
                // Update featured plans with new prices
                featuredPlans = allPlans.filter(p => 
                    p.name.includes('featured') || p.billing_period === 'one_time'
                );
                
                renderPlans();
                populateCurrencyList();
                updateCurrencyDisplay();
                
                loadingEl.style.display = 'none';
                container.style.display = 'flex';
                
                showToast(`Currency changed to ${currentCurrency.name}`, 'success');
            } else {
                throw new Error('Invalid response');
            }
        } catch(error) {
            console.error('Error reloading plans:', error);
            loadingEl.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Failed to load packages. Please refresh.
                </div>
            `;
        }
    }

    function renderPlans() {
        const container = document.getElementById('featuredPlans');
        if (!container || !featuredPlans.length) return;
        
        container.innerHTML = featuredPlans.map(plan => {
            const price = formatPrice(plan.local_price);
            const cardStyle = plan.is_popular ? 'border: 2px solid #f59e0b;' : '';
            
            const badgeMap = {
                'featured_week': '⭐ 7 DAYS',
                'featured_21days': '🔥 21 DAYS',
                'featured_40days': '🚀 40 DAYS'
            };
            const badge = plan.badge_text || badgeMap[plan.name] || '';
            const days = plan.name.includes('week') ? '7' : plan.name.includes('21') ? '21' : '40';
            
            return `
                <div class="col-md-4" style="animation: fadeInUp 0.3s ease both;">
                    <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden" style="${cardStyle}">
                        ${badge ? `<div class="position-absolute top-0 end-0 bg-primary text-white fw-bold px-3 py-1 rounded-start-pill" style="font-size: 11px; z-index: 1;">${badge}</div>` : ''}
                        <div class="card-body p-4 text-center">
                            <div class="rounded-2 bg-warning bg-opacity-10 d-inline-flex p-2 mb-3">
                                <i class="bi bi-star-fill fs-3 text-warning"></i>
                            </div>
                            <h5 class="fw-bold mb-1">${escapeHtml(plan.display_name)}</h5>
                            <p class="text-muted small mb-3">${escapeHtml(plan.description)}</p>
                            <div class="mb-3">
                                <span class="display-6 fw-bold text-warning">${price}</span>
                                <span class="text-muted small">one-time</span>
                            </div>
                            <div class="mb-3">
                                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-clock me-1"></i> ${days} days featured
                                </div>
                            </div>
                            <ul class="list-unstyled text-start mb-4" style="font-size: 13px;">
                                ${plan.features.map(f => `<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`).join('')}
                            </ul>
                            <button onclick="window.openFeaturedPaymentModal('${plan.name}', ${plan.price_usd}, '${plan.billing_period}')" class="btn btn-warning rounded-pill w-100 py-2 fw-semibold">
                                <i class="bi bi-star-fill me-2"></i>Feature My Job
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function populateCurrencyList() {
        const list = document.getElementById('currencyList');
        if (!list || !supportedCurrencies.length) return;
        
        list.innerHTML = supportedCurrencies.map(c => `
            <li>
                <a class="dropdown-item ${currentCurrency?.code === c.code ? 'active' : ''}" 
                   href="#" onclick="window.changeFeaturedCurrency('${c.code}'); return false;">
                    <span class="me-2">${c.flag || '🏦'}</span>
                    ${c.name} (${c.code})
                    <span class="float-end text-muted small">${c.symbol}</span>
                </a>
            </li>
        `).join('');
    }

    function formatPrice(amount) {
        if (!currentCurrency) return `$${Math.round(amount)}`;
        const symbol = currentCurrency.symbol;
        // Format with proper thousands separators
        const formatted = Math.round(amount).toLocaleString();
        return `${symbol} ${formatted}`;
    }

    function updateCurrencyDisplay() {
        const display = document.getElementById('selectedCurrencyDisplay');
        if (display && currentCurrency) {
            display.innerHTML = `${currentCurrency.flag || ''} ${currentCurrency.code} (${currentCurrency.symbol})`;
        }
    }

    // Currency change handler - reloads plans from API
    window.changeFeaturedCurrency = async function(code) {
        const currency = supportedCurrencies.find(c => c.code === code);
        if (currency) {
            // Update current currency
            currentCurrency = currency;
            
            // Reload plans with new currency
            await reloadPlansWithCurrency(code);
            
            // Update UI
            updateCurrencyDisplay();
            populateCurrencyList();
        }
    };



    // ── State ──────────────────────────────────────────────────────────
    let jobFile = null;
    let activeJobTab = 'paste';

    // ── Job tab switcher ───────────────────────────────────────────────
    window.switchJobTab = function(tab) {
        activeJobTab = tab;
        document.getElementById('pasteTab').classList.toggle('d-none', tab !== 'paste');
        document.getElementById('uploadTab').classList.toggle('d-none', tab !== 'upload');
        document.getElementById('pasteTabBtn').className = tab === 'paste'
            ? 'btn btn-sm btn-warning rounded-pill px-3 fw-semibold'
            : 'btn btn-sm btn-outline-secondary rounded-pill px-3';
        document.getElementById('uploadTabBtn').className = tab === 'upload'
            ? 'btn btn-sm btn-warning rounded-pill px-3 fw-semibold'
            : 'btn btn-sm btn-outline-secondary rounded-pill px-3';
    };

    // ── File handlers ──────────────────────────────────────────────────
    window.handleJobFileDrop = function(e) {
        e.preventDefault();
        document.getElementById('jobFileDropZone').style.background = '#fffbeb';
        applyJobFile(e.dataTransfer.files[0]);
    };

    window.handleJobFileSelect = function(inp) {
        if (inp.files[0]) applyJobFile(inp.files[0]);
    };

    function applyJobFile(file) {
        if (!file) return;
        const maxSize = 10 * 1024 * 1024;
        const allowed = ['pdf','doc','docx','txt','jpg','jpeg','png'];
        const ext = file.name.split('.').pop().toLowerCase();

        if (file.size > maxSize) {
            showFileErr('jobFileErr', 'File must be under 10MB.');
            return;
        }
        if (!allowed.includes(ext)) {
            showFileErr('jobFileErr', 'Only PDF, DOC, DOCX, TXT, JPG, PNG accepted.');
            return;
        }

        jobFile = file;
        document.getElementById('jobFileName').textContent = file.name;
        document.getElementById('jobFileSize').textContent = formatBytes(file.size);
        document.getElementById('jobFilePreview').classList.remove('d-none');
        document.getElementById('jobFileErr').classList.add('d-none');
    }

    window.clearJobFile = function() {
        jobFile = null;
        document.getElementById('jobFileInput').value = '';
        document.getElementById('jobFilePreview').classList.add('d-none');
    };

    function formatBytes(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function showFileErr(id, msg) {
        const el = document.getElementById(id);
        if (el) { el.textContent = msg; el.classList.remove('d-none'); }
    }

    // ── Character counter ──────────────────────────────────────────────
    document.getElementById('jobDetailsText')?.addEventListener('input', function() {
        document.getElementById('jobTextCount').textContent = this.value.length + ' chars';
    });

    // ── Step navigation ────────────────────────────────────────────────
    window.goToStep2 = function() {
        // Validate step 1
        let valid = true;

        if (activeJobTab === 'paste') {
            const text = document.getElementById('jobDetailsText')?.value?.trim();
            if (!text || text.length < 100) {
                document.getElementById('jobTextErr').textContent = 'Please paste at least 100 characters of your job posting.';
                document.getElementById('jobTextErr').classList.remove('d-none');
                valid = false;
            } else {
                document.getElementById('jobTextErr').classList.add('d-none');
            }
        } else {
            if (!jobFile) {
                showFileErr('jobFileErr', 'Please upload your job posting file.');
                valid = false;
            }
        }

        if (!valid) return;

        // Populate step 2 summary
        document.getElementById('step2PlanTitle').textContent = document.getElementById('modalPlanTitle').textContent;
        document.getElementById('step2Price').textContent = document.getElementById('modalPrice').textContent;

        const preview = activeJobTab === 'paste'
            ? (document.getElementById('jobDetailsText')?.value?.substring(0, 200) + '…')
            : `📎 ${jobFile.name}`;
        document.getElementById('step2JobSummary').textContent = preview;

        // Pre-fill if logged in
        @if(session()->has('web_user'))
        if (!document.getElementById('payerName').value) {
            document.getElementById('payerName').value = '{{ session('web_user.first_name') }} {{ session('web_user.last_name') }}';
            document.getElementById('payerEmail').value = '{{ session('web_user.email') }}';
            document.getElementById('payerPhone').value = '{{ session('web_user.phone') ?? '' }}';
        }
        @endif

        document.getElementById('modalStep1').classList.add('d-none');
        document.getElementById('modalStep2').classList.remove('d-none');
        document.getElementById('modalStepIndicator').textContent = '2';
        document.getElementById('modalProgressBar').style.width = '100%';
    };

    window.goToStep1 = function() {
        document.getElementById('modalStep2').classList.add('d-none');
        document.getElementById('modalStep1').classList.remove('d-none');
        document.getElementById('modalStepIndicator').textContent = '1';
        document.getElementById('modalProgressBar').style.width = '50%';
    };

    // ── Reset modal on open ────────────────────────────────────────────
    window.openFeaturedPaymentModal = function(planName, priceUsd, period) {
        const plan = featuredPlans.find(p => p.name === planName);
        if (!plan) return;

        selectedPackage = { plan: planName, priceUsd: priceUsd, period: period };

        // Reset to step 1
        goToStep1();
        document.getElementById('jobDetailsText').value = '';
        document.getElementById('jobTextCount').textContent = '0 chars';
        document.getElementById('jobTextErr').classList.add('d-none');
        document.getElementById('jobFileErr').classList.add('d-none');
        clearJobFile();
        switchJobTab('paste');

        // Populate plan info
        document.getElementById('modalPlanTitle').textContent = plan.display_name;
        document.getElementById('modalPlanDesc').textContent = plan.description;
        document.getElementById('modalPrice').textContent = formatPrice(plan.local_price);
        document.getElementById('modalFeatures').innerHTML = plan.features
            .map(f => `<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`)
            .join('');

        new bootstrap.Modal(document.getElementById('featuredPaymentModal')).show();
    };

    // ── Payment submission ─────────────────────────────────────────────
    window.processFeaturedPayment = async function() {
        const name    = document.getElementById('payerName')?.value?.trim();
        const email   = document.getElementById('payerEmail')?.value?.trim();
        const phone   = document.getElementById('payerPhone')?.value?.trim();
        const company = document.getElementById('payerCompany')?.value?.trim();

        document.getElementById('payerNameErr')?.classList.add('d-none');
        document.getElementById('payerEmailErr')?.classList.add('d-none');

        let valid = true;
        if (!name)               { showFieldErr('payerNameErr',  'Full name is required');    valid = false; }
        if (!email || !email.includes('@')) { showFieldErr('payerEmailErr', 'Valid email is required'); valid = false; }
        if (!valid) return;

        const btn = document.getElementById('payNowBtn');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing…';

        const nameParts = name.split(' ');
        const firstName = nameParts[0];
        const lastName  = nameParts.slice(1).join(' ') || firstName;
        const plan      = featuredPlans.find(p => p.name === selectedPackage.plan);

        // Build FormData so we can attach the file if present
        const fd = new FormData();
        fd.append('plan',         selectedPackage.plan);
        fd.append('period',       selectedPackage.period || 'one_time');
        fd.append('amount_usd',   selectedPackage.priceUsd);
        fd.append('currency',     currentCurrency?.code || 'USD');
        fd.append('amount_local', plan?.local_price || selectedPackage.priceUsd);
        fd.append('first_name',   firstName);
        fd.append('last_name',    lastName);
        fd.append('email',        email);
        fd.append('phone',        phone || '');
        fd.append('country_code', currentCurrency?.country_code || 'UG');
        fd.append('company_name', company || '');
        fd.append('is_featured_boost', 'true');
        fd.append('package_display_name', plan?.display_name || selectedPackage.plan);
        fd.append('package_features',    JSON.stringify(plan?.features || []));

        // Job content
        if (activeJobTab === 'paste') {
            fd.append('job_details_text', document.getElementById('jobDetailsText')?.value || '');
        } else if (jobFile) {
            fd.append('job_file', jobFile);
        }

        try {
            const res = await fetch(`${API_BASE}/v1/featured-jobs/initiate`, {
                method: 'POST',
                headers: {
                    'Accept':       'application/json',
                    'X-App-Key':    '{{ config("api.main_app.service_token") }}',
                },
                body: fd,
            });

            const data = await res.json();

            if (!res.ok) {
                if (data.errors) {
                    const first = Object.values(data.errors).flat()[0];
                    showToast(first, 'error');
                } else {
                    showToast(data.message || 'Payment initiation failed. Please try again.', 'error');
                }
                return;
            }

            if (data.success && data.redirect_url) {
                bootstrap.Modal.getInstance(document.getElementById('featuredPaymentModal'))?.hide();
                showToast('Redirecting to payment gateway…', 'info');
                setTimeout(() => { window.location.href = data.redirect_url; }, 700);
            } else {
                showToast(data.message || 'Unexpected error. Please try again.', 'error');
            }

        } catch (err) {
            console.error('Payment error:', err);
            showToast('Network error. Please check your connection and try again.', 'error');
        } finally {
            btn.disabled  = false;
            btn.innerHTML = originalHtml;
        }
    };

    function showFieldErr(id, msg) {
        const el = document.getElementById(id);
        if (el) { el.textContent = msg; el.classList.remove('d-none'); }
    }

    function showToast(message, type) {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem;';
            document.body.appendChild(container);
        }
        const colors = { success: '#28a745', error: '#dc3545', warning: '#ffc107', info: '#17a2b8' };
        const toast = document.createElement('div');
        toast.style.cssText = `background:${colors[type] || colors.info};color:#fff;padding:0.75rem 1rem;border-radius:0.5rem;min-width:260px;font-size:0.875rem;cursor:pointer;animation:fadeInUp .2s ease;`;
        toast.textContent = message;
        toast.onclick = () => toast.remove();
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
})();
</script>



@endsection