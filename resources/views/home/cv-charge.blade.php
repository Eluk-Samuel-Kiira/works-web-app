<section id="cv-enhancement" class="py-5 py-lg-6" style="background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); scroll-margin-top: 80px;">
  <div class="container-xl px-3 px-md-4">
    
    {{-- Campaign Header --}}
    <div class="text-center mb-5">
      <div class="d-inline-flex align-items-center gap-2 bg-warning bg-opacity-20 rounded-pill px-4 py-2 mb-3">
        <i class="bi bi-gift-fill text-warning"></i>
        <span class="small fw-semibold text-warning">Limited Time Offer</span>
      </div>
      <h2 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">Land Your Dream Job <span style="color: #f59e0b;">Faster</span></h2>
      <p class="text-muted fs-5 mb-3">AI-powered CV enhancement + cover letter generator that gets you noticed</p>
      <div class="d-flex justify-content-center gap-3 flex-wrap mb-4" id="featureBadges">
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>ATS Score Optimization</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Keyword Matching</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Custom Cover Letters</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Instant Download</span></div>
      </div>
    </div>

    {{-- Loading State --}}
    <div id="plansLoading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="text-muted mt-2">Loading pricing plans...</p>
    </div>

    {{-- Pricing Packages Container --}}
    <div id="plansContainer" class="row g-4 mb-5" style="display: none;"></div>

    {{-- Currency Selector --}}
    <div class="d-flex justify-content-end mb-3">
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
          <i class="bi bi-currency-exchange me-1"></i> <span id="selectedCurrencyDisplay">USD ($)</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" id="currencyList" style="max-height: 300px; overflow-y: auto;"></ul>
      </div>
    </div>
  </div>
</section>


{{-- Payment Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-header border-0 p-4 pb-0">
        <h5 class="modal-title fw-bold" id="modalPlanName">Complete Your Subscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-4">
          {{-- Package Summary --}}
          <div class="col-md-5">
            <div class="bg-primary bg-opacity-10 rounded-4 p-4 text-center" id="modalPackageSummary">
              <div class="rounded-2 bg-primary bg-opacity-20 d-inline-flex p-2 mb-3" id="modalIcon">
                <i class="bi bi-stars fs-2 text-primary"></i>
              </div>
              <h4 class="fw-bold mb-1" id="modalPlanTitle">Pro Plan</h4>
              <p class="text-muted small mb-2" id="modalPlanDesc">For serious job seekers</p>
              <div class="mb-3">
                <span class="display-6 fw-bold text-primary" id="modalPrice">$12</span>
                <span class="text-muted" id="modalPeriod">/month</span>
              </div>
              <hr>
              <ul class="list-unstyled text-start small" id="modalFeatures">
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited CV reviews</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited cover letters</li>
                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Priority support</li>
              </ul>
            </div>
          </div>
          
          {{-- Payment Form --}}
          <div class="col-md-7">
            <h6 class="fw-bold mb-3">Payment Details</h6>
            <form id="paymentForm">
              <div class="mb-3">
                <label class="form-label small fw-semibold">Full Name</label>
                <input type="text" class="form-control rounded-3" id="payerName" placeholder="John Doe" required>
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Email Address</label>
                <input type="email" class="form-control rounded-3" id="payerEmail" placeholder="john@example.com" required>
              </div>
              <div class="mb-3">
                <label class="form-label small fw-semibold">Phone Number</label>
                <input type="tel" class="form-control rounded-3" id="payerPhone" placeholder="+256 XXX XXX XXX">
              </div>
              
              {{-- Currency Selector in Modal --}}
              <div class="mb-3">
                <label class="form-label small fw-semibold">Select Currency</label>
                <div class="dropdown w-100">
                  <button class="btn btn-outline-secondary rounded-pill w-100 text-start d-flex justify-content-between align-items-center" 
                          type="button" 
                          data-bs-toggle="dropdown" 
                          aria-expanded="false"
                          id="modalCurrencyButton">
                    <span id="modalSelectedCurrency">
                      <span id="modalCurrencyFlag">🇺🇸</span> 
                      <span id="modalCurrencyCode">USD</span> 
                      (<span id="modalCurrencySymbol">$</span>)
                    </span>
                    <i class="bi bi-chevron-down"></i>
                  </button>
                  <ul class="dropdown-menu w-100" id="modalCurrencyList" style="max-height: 250px; overflow-y: auto;">
                    <!-- Currencies will be populated here -->
                  </ul>
                </div>
              </div>
              
              <div class="alert alert-info small p-3 rounded-3" style="background: #e8f0fe; border: none;">
                <i class="bi bi-shield-check me-2"></i>
                Secured by <strong>Pesapal</strong> — Trusted payment gateway for East Africa
              </div>
              <button type="button" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold" onclick="processPayment()">
                <i class="bi bi-lock me-2"></i>Pay with Pesapal
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Login Required Modal --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-body text-center p-5">
        <div class="rounded-2 bg-warning bg-opacity-20 d-inline-flex p-3 mb-3">
          <i class="bi bi-box-arrow-in-right fs-1 text-warning"></i>
        </div>
        <h5 class="fw-bold mb-2">Login Required</h5>
        <p class="text-muted mb-4">Please sign in to continue with your subscription.</p>
        <div class="d-flex gap-2">
          <a href="{{ route('login.register') }}" class="btn btn-primary rounded-pill px-4 flex-grow-1">Sign In</a>
          <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
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
#plansContainer .card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
#plansContainer .card:hover { transform: translateY(-4px); }
</style>



<script>
const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
const API_TOKEN = '{{ session("api_token") }}';

let paymentPlans = [];
let supportedCurrencies = [];
let currentCurrency = null;
let selectedPackage = null;

// ============================================
// LOAD PAYMENT PLANS AND CURRENCIES FROM MAIN API
// ============================================
async function loadPaymentPlans() {
  const loadingEl = document.getElementById('plansLoading');
  const container = document.getElementById('plansContainer');
  
  loadingEl.style.display = 'block';
  container.style.display = 'none';
  
  try {
    const currencyCode = currentCurrency?.code || 'USD';
    const response = await fetch(`${API_BASE}/v1/payment-plans?currency=${currencyCode}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${API_TOKEN}`
      }
    });
    
    const data = await response.json();
    
    if (data.success && data.data.plans) {
      paymentPlans = data.data.plans;
      supportedCurrencies = data.data.supported_currencies;
      renderPlans();
      populateAllCurrencyLists();
      loadingEl.style.display = 'none';
      container.style.display = 'flex';
    } else {
      throw new Error('Failed to load plans');
    }
  } catch (error) {
    console.error('Error loading payment plans:', error);
    loadingEl.innerHTML = `
      <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Failed to load pricing plans. Please refresh the page.
      </div>
    `;
  }
}

// ============================================
// RENDER PRICING CARDS FROM API DATA
// ============================================
function renderPlans() {
  const container = document.getElementById('plansContainer');
  if (!container) return;
  
  container.innerHTML = paymentPlans.map(plan => {
    const priceDisplay = formatPrice(plan.local_price);
    const periodText = plan.billing_period === 'monthly' ? '/month' : '/year';
    const monthlyEquivalent = plan.billing_period === 'yearly' ? `<div class="small text-muted mb-2">≈ ${formatPrice(plan.local_price / 12)}/month</div>` : '';
    const popularBadge = plan.is_popular ? `<div class="position-absolute top-0 end-0 bg-warning text-dark fw-bold px-3 py-1 rounded-start-pill" style="font-size: 11px;">${plan.badge_text || '🔥 MOST POPULAR'}</div>` : '';
    const cardStyle = plan.is_popular ? 'background: linear-gradient(135deg, #1e3a8a, #2563eb);' : '';
    const textColor = plan.is_popular ? 'text-white' : '';
    const mutedColor = plan.is_popular ? 'text-white-50' : 'text-muted';
    const btnClass = plan.is_popular ? 'btn-light text-primary' : 'btn-outline-primary';
    const icon = plan.name === 'basic' ? 'file-text' : (plan.name === 'pro' ? 'stars' : 'diamond');
    const iconColor = plan.is_popular ? 'text-white' : 'text-primary';
    const bgClass = plan.is_popular ? 'white bg-opacity-20' : 'primary bg-opacity-10';
    
    return `
      <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 h-100 position-relative overflow-hidden" style="${cardStyle}">
          ${popularBadge}
          <div class="card-body p-4 text-center">
            <div class="rounded-2 bg-${bgClass} d-inline-flex p-2 mb-3">
              <i class="bi bi-${icon} fs-3 ${iconColor}"></i>
            </div>
            <h5 class="fw-bold mb-1 ${textColor}">${plan.display_name}</h5>
            <p class="${mutedColor} small mb-3">${plan.description}</p>
            <div class="mb-3">
              <span class="display-5 fw-bold ${textColor}">${priceDisplay}</span>
              <span class="${mutedColor}">${periodText}</span>
            </div>
            ${monthlyEquivalent}
            <ul class="list-unstyled text-start mb-4 ${textColor}" style="font-size: 13px;">
              ${plan.features.map(f => `<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`).join('')}
            </ul>
            <button onclick="openPaymentModal('${plan.name}', ${plan.price_usd}, '${plan.billing_period}')" class="btn ${btnClass} rounded-pill w-100 py-2 fw-semibold">
              ${plan.is_popular ? 'Start Pro Trial' : 'Get Started'}
            </button>
          </div>
        </div>
      </div>
    `;
  }).join('');
}

// ============================================
// CURRENCY FUNCTIONS
// ============================================
function formatPrice(amount) {
  if (!currentCurrency) return `$${Math.round(amount)}`;
  const symbol = currentCurrency.symbol;
  const formatted = Math.round(amount).toLocaleString();
  return `${symbol} ${formatted}`;
}

function updateAllPrices() {
  if (!currentCurrency) return;
  
  // Reload plans with new currency
  loadPaymentPlans();
  
  // Update modal price if open
  if (selectedPackage) {
    updateModalPrice();
  }
}

function populateAllCurrencyLists() {
  populateMainCurrencyList();
  populateModalCurrencyList();
}

function populateMainCurrencyList() {
  const list = document.getElementById('currencyList');
  if (!list) return;
  
  list.innerHTML = supportedCurrencies.map(c => `
    <li>
      <a class="dropdown-item ${currentCurrency?.code === c.code ? 'active' : ''}" 
         href="#" onclick="changeCurrency('${c.code}'); return false;">
        <span class="me-2">${c.flag || '🏦'}</span>
        ${c.name} (${c.code})
        <span class="float-end text-muted small">${c.symbol}</span>
      </a>
    </li>
  `).join('');
}

function populateModalCurrencyList() {
  const list = document.getElementById('modalCurrencyList');
  if (!list) return;
  
  list.innerHTML = supportedCurrencies.map(c => `
    <li>
      <a class="dropdown-item ${currentCurrency?.code === c.code ? 'active' : ''}" 
         href="#" onclick="changeModalCurrency('${c.code}'); return false;">
        <span class="me-2">${c.flag || '🏦'}</span>
        ${c.name} (${c.code})
        <span class="float-end text-muted small">${c.symbol}</span>
      </a>
    </li>
  `).join('');
}

function changeCurrency(currencyCode) {
  const currency = supportedCurrencies.find(c => c.code === currencyCode);
  if (currency) {
    currentCurrency = currency;
    updateCurrencyDisplay();
    populateAllCurrencyLists();
    updateModalCurrencyDisplay();
    updateAllPrices();
    showToast(`Currency changed to ${currency.name}`, 'info');
  }
}

function changeModalCurrency(currencyCode) {
  changeCurrency(currencyCode);
}

function updateCurrencyDisplay() {
  const display = document.getElementById('selectedCurrencyDisplay');
  if (display && currentCurrency) {
    display.innerHTML = `${currentCurrency.flag || '🏦'} ${currentCurrency.code} (${currentCurrency.symbol})`;
  }
}

function updateModalCurrencyDisplay() {
  if (!currentCurrency) return;
  const flagSpan = document.getElementById('modalCurrencyFlag');
  const codeSpan = document.getElementById('modalCurrencyCode');
  const symbolSpan = document.getElementById('modalCurrencySymbol');
  if (flagSpan) flagSpan.textContent = currentCurrency.flag || '🏦';
  if (codeSpan) codeSpan.textContent = currentCurrency.code;
  if (symbolSpan) symbolSpan.textContent = currentCurrency.symbol;
}

function updateModalPrice() {
  if (!selectedPackage) return;
  const plan = paymentPlans.find(p => p.name === selectedPackage.plan);
  if (!plan) return;
  const priceElement = document.getElementById('modalPrice');
  if (priceElement) {
    priceElement.innerHTML = formatPrice(plan.local_price);
  }
}

// ============================================
// DETECT COUNTRY AND SET CURRENCY
// ============================================
async function detectAndSetCurrency() {
  try {
    // First load supported currencies from API
    const response = await fetch(`${API_BASE}/v1/payment-plans?currency=USD`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${API_TOKEN}`
      }
    });
    const data = await response.json();
    
    if (data.success && data.data.supported_currencies) {
      supportedCurrencies = data.data.supported_currencies;
      
      // Detect country using ip-api.com (reliable and free)
      const geoRes = await fetch('https://ip-api.com/json/');
      if (geoRes.ok) {
        const geoData = await geoRes.json();
        const countryCode = geoData.countryCode;
        
        // Find currency by country code
        const matchedCurrency = supportedCurrencies.find(c => c.country_code === countryCode);
        if (matchedCurrency) {
          currentCurrency = matchedCurrency;
        } else {
          currentCurrency = supportedCurrencies.find(c => c.code === 'USD');
        }
      } else {
        currentCurrency = supportedCurrencies.find(c => c.code === 'USD');
      }
    } else {
      throw new Error('Failed to load currencies');
    }
  } catch (error) {
    console.log('Currency detection failed, using USD');
    currentCurrency = { code: 'USD', symbol: '$', name: 'US Dollar', flag: '🇺🇸' };
  }
  
  updateCurrencyDisplay();
  populateAllCurrencyLists();
  await loadPaymentPlans();
  
  if (currentCurrency && currentCurrency.code !== 'USD') {
    showToast(`💱 Prices shown in ${currentCurrency.name} based on your location`, 'info');
  }
}

// ============================================
// MODAL FUNCTIONS
// ============================================
function openPaymentModal(planName, priceUsd, period) {
  const isLoggedIn = {{ session()->has('web_user') ? 'true' : 'false' }};
  
  if (!isLoggedIn) {
    new bootstrap.Modal(document.getElementById('loginRequiredModal')).show();
    return;
  }
  
  const plan = paymentPlans.find(p => p.name === planName);
  if (!plan) return;
  
  selectedPackage = { plan: planName, priceUsd: priceUsd, period: period };
  
  document.getElementById('modalPlanTitle').innerHTML = plan.display_name + ' Plan';
  document.getElementById('modalPlanDesc').innerHTML = plan.description;
  document.getElementById('modalPrice').innerHTML = formatPrice(plan.local_price);
  document.getElementById('modalPeriod').innerHTML = period === 'monthly' ? '/month' : '/year';
  
  const iconMap = { basic: 'file-text', pro: 'stars', elite: 'diamond' };
  document.getElementById('modalIcon').innerHTML = `<i class="bi bi-${iconMap[planName]} fs-2 text-primary"></i>`;
  
  const featuresList = document.getElementById('modalFeatures');
  featuresList.innerHTML = plan.features.map(f => `<li><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`).join('');
  
  updateModalCurrencyDisplay();
  populateModalCurrencyList();
  
  @if(session()->has('web_user'))
  document.getElementById('payerName').value = '{{ session('web_user.first_name') }} {{ session('web_user.last_name') }}';
  document.getElementById('payerEmail').value = '{{ session('web_user.email') }}';
  document.getElementById('payerPhone').value = '{{ session('web_user.phone') ?? '' }}';
  @endif
  
  new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

function processPayment() {
  const name = document.getElementById('payerName')?.value?.trim();
  const email = document.getElementById('payerEmail')?.value?.trim();
  const phone = document.getElementById('payerPhone')?.value?.trim();

  if (!name || !email) {
    showToast('Please enter your name and email address.', 'warning');
    return;
  }
  if (!selectedPackage) {
    showToast('No plan selected.', 'warning');
    return;
  }

  const nameParts = name.split(' ');
  const firstName = nameParts[0];
  const lastName = nameParts.slice(1).join(' ') || firstName;

  const plan = paymentPlans.find(p => p.name === selectedPackage.plan);
  
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '/payment/initiate';

  const fields = {
    '_token': document.querySelector('meta[name="csrf-token"]')?.content || '',
    'plan': selectedPackage.plan,
    'period': selectedPackage.period,
    'amount_usd': selectedPackage.priceUsd,
    'currency': currentCurrency?.code || 'USD',
    'amount_local': plan?.local_price || selectedPackage.priceUsd,
    'first_name': firstName,
    'last_name': lastName,
    'email': email,
    'phone': phone || '',
    'country_code': currentCurrency?.country_code || 'UG',
  };

  Object.entries(fields).forEach(([key, value]) => {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = value;
    form.appendChild(input);
  });

  bootstrap.Modal.getInstance(document.getElementById('paymentModal'))?.hide();
  document.body.appendChild(form);
  form.submit();
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

// Initialize
document.addEventListener('DOMContentLoaded', () => {
  detectAndSetCurrency();
});
</script>