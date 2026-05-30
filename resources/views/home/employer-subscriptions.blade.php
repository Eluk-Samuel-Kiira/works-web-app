{{-- resources/views/partials/employer-subscriptions.blade.php --}}
<section id="employer-subscriptions" class="py-5 py-lg-6" style="background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); scroll-margin-top: 80px;">
  <div class="container-xl px-3 px-md-4">
    
    {{-- Campaign Header --}}
    <div class="text-center mb-5">
      <div class="d-inline-flex align-items-center gap-2 bg-primary bg-opacity-10 rounded-pill px-4 py-2 mb-3">
        <i class="bi bi-building fs-5 text-primary"></i>
        <span class="small fw-semibold text-primary">Employer Plans</span>
      </div>
      <h2 class="display-5 fw-bold mb-3" style="color: #1e3a8a;">Hire Smarter, <span style="color: #f59e0b;">Faster</span></h2>
      <p class="text-muted fs-5 mb-3">Subscription plans for growing companies and enterprises</p>
      <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Job Postings</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Applicant Management</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>AI CV Matching</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Analytics Dashboard</span></div>
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
    <div id="plansLoading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-muted mt-2">Loading employer plans...</p>
    </div>

    {{-- Subscription Plans Container --}}
    <div id="subscriptionPlans" class="row g-4 mb-5" style="display: none;"></div>

  </div>
</section>

{{-- Payment Modal --}}
<div class="modal fade" id="subscriptionPaymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-xl">
      <div class="modal-header border-0 p-4 pb-0">
        <h5 class="modal-title fw-bold">Complete Your Subscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-4">
          <div class="col-md-5">
            <div class="bg-primary bg-opacity-10 rounded-4 p-4 text-center">
              <div class="rounded-2 bg-primary bg-opacity-20 d-inline-flex p-2 mb-3" id="modalIcon">
                <i class="bi bi-briefcase fs-2 text-primary"></i>
              </div>
              <h4 class="fw-bold mb-1" id="modalPlanTitle">Pro Plan</h4>
              <p class="text-muted small mb-2" id="modalPlanDesc">For growing companies</p>
              <div class="mb-3">
                <span class="display-6 fw-bold text-primary" id="modalPrice">$35</span>
                <span class="text-muted" id="modalPeriod">/month</span>
              </div>
              <hr>
              <ul class="list-unstyled text-start small" id="modalFeatures"></ul>
            </div>
          </div>
          <div class="col-md-7">
            <h6 class="fw-bold mb-3">Your Details</h6>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Full Name</label>
              <input type="text" class="form-control rounded-3" id="payerName" placeholder="John Doe">
              <div class="text-danger small mt-1 d-none" id="payerNameErr"></div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Email Address</label>
              <input type="email" class="form-control rounded-3" id="payerEmail" placeholder="john@example.com">
              <div class="text-danger small mt-1 d-none" id="payerEmailErr"></div>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Phone Number</label>
              <input type="tel" class="form-control rounded-3" id="payerPhone" placeholder="+256 XXX XXX XXX">
            </div>
            <div class="alert alert-info small p-3 rounded-3" style="background: #e8f0fe; border: none;">
              <i class="bi bi-shield-check me-2"></i>
              Secured by <strong>Pesapal</strong> — Trusted payment gateway for East Africa
            </div>
            <button type="button" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold" id="payNowBtn" onclick="processSubscriptionPayment()">
              <i class="bi bi-lock me-2"></i>Subscribe Now
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Login Required Modal --}}
<div class="modal fade" id="subscriptionLoginRequiredModal" tabindex="-1" aria-hidden="true">
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
#subscriptionPlans .card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
#subscriptionPlans .card:hover { transform: translateY(-4px); }
</style>

<script>
(function() {
    const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    const API_TOKEN = '{{ session("api_token") }}';
    const IS_LOGGED_IN = {{ session()->has('web_user') ? 'true' : 'false' }};
    const CSRF_TOKEN = '{{ csrf_token() }}';
    
    let subscriptionPlans = [];
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
            
            try {
                const res = await fetch('https://ipapi.co/json/', { signal: AbortSignal.timeout(3000) });
                if (res.ok) {
                    const data = await res.json();
                    countryCode = data.country_code;
                }
            } catch(e) { console.log('ipapi.co failed:', e); }
            
            if (!countryCode) {
                try {
                    const res = await fetch('http://ip-api.com/json/', { signal: AbortSignal.timeout(3000) });
                    if (res.ok) {
                        const data = await res.json();
                        countryCode = data.countryCode;
                    }
                } catch(e) { console.log('ip-api.com failed:', e); }
            }
            
            await loadPlans(countryCode);
            
        } catch(error) {
            console.error('Detection failed:', error);
            await loadPlans(null);
        }
    }

    async function loadPlans(countryCode = null) {
        const loadingEl = document.getElementById('plansLoading');
        const container = document.getElementById('subscriptionPlans');
        
        loadingEl.style.display = 'block';
        container.style.display = 'none';
        
        try {
            let url = `${API_BASE}/v1/payment-plans?audience=employer`;
            if (countryCode) {
                url += `&country=${countryCode}`;
            }
            
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
                currentCurrency = data.data.detected_currency || { code: 'USD', symbol: '$', name: 'US Dollar', flag: '🇺🇸' };
                
                // Filter only subscription plans (not featured add-ons)
                subscriptionPlans = allPlans.filter(p => 
                    !p.name.includes('featured') && p.billing_period !== 'one_time'
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
                    Failed to load pricing plans. <a href="javascript:location.reload()">Refresh</a> to try again.
                </div>
            `;
        }
    }

    function renderPlans() {
        const container = document.getElementById('subscriptionPlans');
        if (!container || !subscriptionPlans.length) return;
        
        container.innerHTML = subscriptionPlans.map(plan => {
            const price = formatPrice(plan.local_price);
            const period = plan.billing_period === 'monthly' ? '/month' : '/year';
            const popularBadge = plan.is_popular ? `<div class="position-absolute top-0 end-0 bg-warning text-dark fw-bold px-3 py-1 rounded-start-pill" style="font-size: 11px; z-index: 1;">${plan.badge_text || '🔥 MOST POPULAR'}</div>` : '';
            const cardStyle = plan.is_popular ? 'background: linear-gradient(135deg, #1e3a8a, #2563eb);' : '';
            const textColor = plan.is_popular ? 'text-white' : '';
            const mutedColor = plan.is_popular ? 'text-white-50' : 'text-muted';
            const btnClass = plan.is_popular ? 'btn-light text-primary' : 'btn-outline-primary';
            
            const iconMap = {
                'employer_starter': 'building',
                'employer_pro': 'briefcase',
                'employer_elite': 'award'
            };
            const icon = iconMap[plan.name] || 'briefcase';
            const bgIcon = plan.is_popular ? 'bg-white bg-opacity-20' : 'bg-primary bg-opacity-10';
            
            return `
                <div class="col-md-4" style="animation: fadeInUp 0.3s ease both;">
                    <div class="card border-0 shadow-lg rounded-4 h-100 position-relative overflow-hidden" style="${cardStyle}">
                        ${popularBadge}
                        <div class="card-body p-4 text-center">
                            <div class="rounded-2 ${bgIcon} d-inline-flex p-2 mb-3">
                                <i class="bi bi-${icon} fs-3 ${textColor}"></i>
                            </div>
                            <h5 class="fw-bold mb-1 ${textColor}">${escapeHtml(plan.display_name)}</h5>
                            <p class="${mutedColor} small mb-3">${escapeHtml(plan.description)}</p>
                            <div class="mb-3">
                                <span class="display-5 fw-bold ${textColor}">${price}</span>
                                <span class="${mutedColor} small">${period}</span>
                            </div>
                            <ul class="list-unstyled text-start mb-4 ${textColor}" style="font-size: 13px;">
                                ${plan.features.map(f => `<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`).join('')}
                            </ul>
                            <button onclick="window.openSubscriptionPaymentModal('${plan.name}', ${plan.price_usd}, '${plan.billing_period}')" class="btn ${btnClass} rounded-pill w-100 py-2 fw-semibold">
                                Subscribe Now
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
                   href="#" onclick="window.changeSubscriptionCurrency('${c.code}'); return false;">
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
        return `${symbol} ${Math.round(amount).toLocaleString()}`;
    }

    function updateCurrencyDisplay() {
        const display = document.getElementById('selectedCurrencyDisplay');
        if (display && currentCurrency) {
            display.innerHTML = `${currentCurrency.flag || ''} ${currentCurrency.code} (${currentCurrency.symbol})`;
        }
    }

    window.changeSubscriptionCurrency = function(code) {
        const currency = supportedCurrencies.find(c => c.code === code);
        if (currency) {
            currentCurrency = currency;
            renderPlans();
            populateCurrencyList();
            updateCurrencyDisplay();
            showToast(`Currency changed to ${currency.name}`, 'info');
        }
    };

    window.openSubscriptionPaymentModal = function(planName, priceUsd, period) {
        if (!IS_LOGGED_IN) {
            new bootstrap.Modal(document.getElementById('subscriptionLoginRequiredModal')).show();
            return;
        }
        
        const plan = subscriptionPlans.find(p => p.name === planName);
        if (!plan) return;
        
        selectedPackage = { plan: planName, priceUsd: priceUsd, period: period };
        
        document.getElementById('modalPlanTitle').textContent = plan.display_name;
        document.getElementById('modalPlanDesc').textContent = plan.description;
        document.getElementById('modalPrice').textContent = formatPrice(plan.local_price);
        document.getElementById('modalPeriod').textContent = period === 'monthly' ? '/month' : '/year';
        
        const iconMap = {
            'employer_starter': 'building',
            'employer_pro': 'briefcase',
            'employer_elite': 'award'
        };
        const icon = iconMap[planName] || 'briefcase';
        document.getElementById('modalIcon').innerHTML = `<i class="bi bi-${icon} fs-2 text-primary"></i>`;
        
        const featuresList = document.getElementById('modalFeatures');
        featuresList.innerHTML = plan.features.map(f => `<li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>${escapeHtml(f)}</li>`).join('');
        
        // Pre-fill user data
        @if(session()->has('web_user'))
        document.getElementById('payerName').value = '{{ session('web_user.first_name') }} {{ session('web_user.last_name') }}';
        document.getElementById('payerEmail').value = '{{ session('web_user.email') }}';
        document.getElementById('payerPhone').value = '{{ session('web_user.phone') ?? '' }}';
        @endif
        
        new bootstrap.Modal(document.getElementById('subscriptionPaymentModal')).show();
    };

    window.processSubscriptionPayment = function() {
        const name = document.getElementById('payerName')?.value?.trim();
        const email = document.getElementById('payerEmail')?.value?.trim();
        const phone = document.getElementById('payerPhone')?.value?.trim();
        
        document.getElementById('payerNameErr')?.classList.add('d-none');
        document.getElementById('payerEmailErr')?.classList.add('d-none');
        
        let valid = true;
        if (!name) {
            const err = document.getElementById('payerNameErr');
            if (err) { err.textContent = 'Full name is required'; err.classList.remove('d-none'); }
            valid = false;
        }
        if (!email || !email.includes('@')) {
            const err = document.getElementById('payerEmailErr');
            if (err) { err.textContent = 'Valid email is required'; err.classList.remove('d-none'); }
            valid = false;
        }
        if (!valid) return;
        
        const nameParts = name.split(' ');
        const firstName = nameParts[0];
        const lastName = nameParts.slice(1).join(' ') || firstName;
        
        const plan = subscriptionPlans.find(p => p.name === selectedPackage.plan);
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/payment/initiate';
        
        const fields = {
            '_token': CSRF_TOKEN,
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
        
        bootstrap.Modal.getInstance(document.getElementById('subscriptionPaymentModal'))?.hide();
        document.body.appendChild(form);
        form.submit();
    };

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