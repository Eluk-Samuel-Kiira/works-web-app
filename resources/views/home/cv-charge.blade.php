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
      <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>ATS Score Optimization</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Keyword Matching</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Custom Cover Letters</span></div>
        <div class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success"></i><span>Instant Download</span></div>
      </div>
    </div>

    {{-- 3 Pricing Packages --}}
    <div class="row g-4 mb-5">
      {{-- Basic Plan --}}
      <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 h-100">
          <div class="card-body p-4 text-center">
            <div class="rounded-2 bg-primary bg-opacity-10 d-inline-flex p-2 mb-3"><i class="bi bi-file-text fs-3 text-primary"></i></div>
            <h5 class="fw-bold mb-1">Basic</h5>
            <p class="text-muted small mb-3">Perfect for job seekers starting out</p>
            <div class="mb-3">
              <span class="display-5 fw-bold text-primary" id="basicPrice">$5</span>
              <span class="text-muted" id="basicPeriod">/month</span>
              <span class="badge bg-warning text-dark ms-2 rounded-pill">Save 20%</span>
            </div>
            <div class="small text-muted mb-2" id="basicLocalPrice" style="font-size: 11px;"></div>
            <ul class="list-unstyled text-start mb-4">
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>5 CV reviews per month</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>Advanced ATS score check</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>10 cover letters/month</li>
              <li class="text-muted"><i class="bi bi-x me-2"></i>Priority support</li>
            </ul>
            <button onclick="showPaymentModal('basic', 5, 'monthly')" class="btn btn-outline-primary rounded-pill w-100 py-2">Get Started</button>
          </div>
        </div>
      </div>

      {{-- Pro Plan (Featured) --}}
      <div class="col-md-4">
        <div class="card border-0 shadow-xl rounded-4 h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
          <div class="position-absolute top-0 end-0 bg-warning text-dark fw-bold px-3 py-1 rounded-start-pill" style="font-size: 11px;">🔥 MOST POPULAR</div>
          <div class="card-body p-4 text-center text-white">
            <div class="rounded-2 bg-white bg-opacity-20 d-inline-flex p-2 mb-3"><i class="bi bi-stars fs-3 text-white"></i></div>
            <h5 class="fw-bold mb-1 text-white">Pro</h5>
            <p class="text-white-50 small mb-3">For serious job seekers</p>
            <div class="mb-3">
              <span class="display-5 fw-bold text-white" id="proPrice">$12</span>
              <span class="text-white-50" id="proPeriod">/month</span>
              <span class="badge bg-warning text-dark ms-2 rounded-pill">Save 40%</span>
            </div>
            <div class="small text-white-50 mb-2" id="proLocalPrice" style="font-size: 11px;"></div>
            <ul class="list-unstyled text-start mb-4 text-white-50">
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited CV reviews</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited CV rewriting + revamping</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Advanced ATS score + keywords</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited cover letters</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Priority support</li>
              <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>AI-Powered Job Recommendations</li>
              <li><i class="bi bi-check-circle-fill text-success me-2"></i>Interview preparation guide & tutorials</li>
            </ul>
            <button onclick="showPaymentModal('pro', 12, 'monthly')" class="btn btn-light text-primary fw-semibold rounded-pill w-100 py-2 shadow-sm">Start Pro Trial</button>
          </div>
        </div>
      </div>

      {{-- Elite Plan --}}
      <div class="col-md-4">
        <div class="card border-0 shadow-lg rounded-4 h-100">
          <div class="card-body p-4 text-center">
            <div class="rounded-2 bg-primary bg-opacity-10 d-inline-flex p-2 mb-3"><i class="bi bi-diamond fs-3 text-primary"></i></div>
            <h5 class="fw-bold mb-1">Elite</h5>
            <p class="text-muted small mb-3">For job seekers with purpose</p>
            <div class="mb-3">
              <span class="display-5 fw-bold text-primary" id="elitePrice">$49</span>
              <span class="text-muted" id="elitePeriod">/year</span>
            </div>
            <div class="small text-muted mb-2" id="eliteLocalPrice" style="font-size: 11px;"></div>
            <ul class="list-unstyled text-start mb-4">
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>Unlimited CV reviews</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>Unlimited CV rewriting + revamping</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>Advanced ATS score + keywords</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>Unlimited cover letters</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>Priority support</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>Interview preparation guide & tutorials</li>
              <li class="mb-2"><i class="bi bi-check text-primary me-2"></i>AI-Powered Job Recommendations</li>
              <li><i class="bi bi-check text-primary me-2"></i>Aptitude test preparation</li>
            </ul>
            <button onclick="showPaymentModal('elite', 49, 'yearly')" class="btn btn-outline-primary rounded-pill w-100 py-2">Get Elite</button>
          </div>
        </div>
      </div>
    </div>

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
            <div class="bg-primary bg-opacity-10 rounded-4 p-4 text-center">
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
              <div class="mb-3">
                <label class="form-label small fw-semibold">Payment Method</label>
                <div class="d-flex gap-3 flex-wrap">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="cardPay" value="card" checked>
                    <label class="form-check-label small" for="cardPay">💳 Credit/Debit Card</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="mobilePay" value="mobile">
                    <label class="form-check-label small" for="mobilePay">📱 Mobile Money</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="bankPay" value="bank">
                    <label class="form-check-label small" for="bankPay">🏦 Bank Transfer</label>
                  </div>
                </div>
              </div>
              <div class="alert alert-info small p-3 rounded-3" style="background: #e8f0fe; border: none;">
                <i class="bi bi-shield-check me-2"></i>
                Secured by <strong>Pesapal</strong> — Uganda's trusted payment gateway
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

<script>
  // Exchange rates and pricing data
  const EXCHANGE_RATES = {
      'UG': { code: 'UGX', symbol: 'USh', rate: 3750, name: 'Uganda Shilling', flag: '🇺🇬' },
      'KE': { code: 'KES', symbol: 'KSh', rate: 130, name: 'Kenyan Shilling', flag: '🇰🇪' },
      'TZ': { code: 'TZS', symbol: 'TSh', rate: 2600, name: 'Tanzanian Shilling', flag: '🇹🇿' },
      'RW': { code: 'RWF', symbol: 'FRw', rate: 1300, name: 'Rwandan Franc', flag: '🇷🇼' },
      'US': { code: 'USD', symbol: '$', rate: 1, name: 'US Dollar', flag: '🇺🇸' },
      'NG': { code: 'NGN', symbol: '₦', rate: 1500, name: 'Nigerian Naira', flag: '🇳🇬' },
      'ZA': { code: 'ZAR', symbol: 'R', rate: 19, name: 'South African Rand', flag: '🇿🇦' }
  };

  const PRICES = { basic: { monthly: 5, yearly: 48 }, pro: { monthly: 12, yearly: 108 }, elite: { yearly: 49 } };
  
  const PLAN_FEATURES = {
      basic: ['5 CV reviews per month', 'Advanced ATS score check', '10 cover letters/month', 'Email support'],
      pro: ['Unlimited CV reviews', 'Unlimited CV rewriting + revamping', 'Advanced ATS score + keywords', 'Unlimited cover letters', 'Priority support', 'AI-Powered Job Recommendations', 'Interview preparation guide & tutorials'],
      elite: ['Unlimited CV reviews', 'Unlimited CV rewriting + revamping', 'Advanced ATS score + keywords', 'Unlimited cover letters', 'Priority support', 'Interview preparation guide & tutorials', 'AI-Powered Job Recommendations', 'Aptitude test preparation']
  };

  let currentCurrency = null;
  let selectedPackage = null;

  function convertPrice(usdAmount) { return currentCurrency ? Math.round(usdAmount * currentCurrency.rate) : usdAmount; }
  function formatPrice(amount) { return currentCurrency ? `${currentCurrency.symbol} ${amount.toLocaleString()}` : `$${amount}`; }

  function updatePrices() {
      if (!currentCurrency) return;
      const basicMonthly = convertPrice(PRICES.basic.monthly);
      const basicYearly = convertPrice(PRICES.basic.yearly);
      document.getElementById('basicPrice').innerHTML = formatPrice(basicMonthly);
      document.getElementById('basicLocalPrice').innerHTML = `or ${formatPrice(basicYearly)}/year (save ${Math.round((1 - (basicYearly/(basicMonthly*12)))*100)}%)`;
      
      const proMonthly = convertPrice(PRICES.pro.monthly);
      const proYearly = convertPrice(PRICES.pro.yearly);
      document.getElementById('proPrice').innerHTML = formatPrice(proMonthly);
      document.getElementById('proLocalPrice').innerHTML = `or ${formatPrice(proYearly)}/year (save ${Math.round((1 - (proYearly/(proMonthly*12)))*100)}%)`;
      
      const eliteYearly = convertPrice(PRICES.elite.yearly);
      document.getElementById('elitePrice').innerHTML = formatPrice(eliteYearly);
      document.getElementById('eliteLocalPrice').innerHTML = `≈ ${formatPrice(convertPrice(PRICES.elite.yearly / 12))}/month`;
      
      document.getElementById('selectedCurrencyDisplay').innerHTML = `${currentCurrency.flag || ''} ${currentCurrency.code} (${currentCurrency.symbol})`;
  }

  async function detectAndSetCurrency() {
      try {
          const geoRes = await fetch('https://ipinfo.io/json?token=55a04398826b35');
          const geoData = await geoRes.json();
          const countryCode = geoData.country;
          const rateRes = await fetch('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.json');
          const rateData = await rateRes.json();
          const countryToCurrency = { 'UG': 'UGX', 'KE': 'KES', 'TZ': 'TZS', 'RW': 'RWF', 'NG': 'NGN', 'ZA': 'ZAR', 'US': 'USD' };
          const currencyCode = countryToCurrency[countryCode] || 'USD';
          const rate = rateData.usd[currencyCode.toLowerCase()];
          
          if (rate && EXCHANGE_RATES[countryCode]) {
              currentCurrency = { ...EXCHANGE_RATES[countryCode], rate: rate };
          } else throw new Error('Rate not found');
          
          updatePrices();
          populateCurrencyList();
      } catch (error) {
          currentCurrency = EXCHANGE_RATES['US'];
          updatePrices();
      }
  }

  function populateCurrencyList() {
      const list = document.getElementById('currencyList');
      if (!list) return;
      list.innerHTML = Object.values(EXCHANGE_RATES).map(c => `<li><a class="dropdown-item ${currentCurrency?.code === c.code ? 'active' : ''}" href="#" onclick="changeCurrency('${c.code}'); return false;"><span class="me-2">${c.flag || '🏦'}</span>${c.name} (${c.code})<span class="float-end text-muted small">${c.symbol}</span></a></li>`).join('');
  }

  function changeCurrency(currencyCode) {
      const currency = Object.values(EXCHANGE_RATES).find(c => c.code === currencyCode);
      if (currency) { currentCurrency = currency; updatePrices(); populateCurrencyList(); showToast(`Currency changed to ${currency.name}`, 'info'); }
  }

  function showPaymentModal(plan, priceUsd, period) {
      selectedPackage = { plan, priceUsd, period };
      const isLoggedIn = {{ session()->has('web_user') ? 'true' : 'false' }};
      
      if (!isLoggedIn) {
          new bootstrap.Modal(document.getElementById('loginRequiredModal')).show();
          return;
      }
      
      // Populate modal with package details
      const convertedPrice = convertPrice(priceUsd);
      document.getElementById('modalPlanTitle').innerHTML = plan.charAt(0).toUpperCase() + plan.slice(1) + ' Plan';
      document.getElementById('modalPlanDesc').innerHTML = plan === 'basic' ? 'Perfect for job seekers starting out' : (plan === 'pro' ? 'For serious job seekers' : 'For job seekers with purpose');
      document.getElementById('modalPrice').innerHTML = formatPrice(convertedPrice);
      document.getElementById('modalPeriod').innerHTML = period === 'monthly' ? '/month' : '/year';
      document.getElementById('modalIcon').innerHTML = plan === 'basic' ? '<i class="bi bi-file-text fs-2 text-primary"></i>' : (plan === 'pro' ? '<i class="bi bi-stars fs-2 text-primary"></i>' : '<i class="bi bi-diamond fs-2 text-primary"></i>');
      
      const featuresList = document.getElementById('modalFeatures');
      featuresList.innerHTML = PLAN_FEATURES[plan].map(f => `<li><i class="bi bi-check-circle-fill text-success me-2"></i>${f}</li>`).join('');
      
      // Pre-fill user data if available
      @if(session()->has('web_user'))
      document.getElementById('payerName').value = '{{ session('web_user.first_name') }} {{ session('web_user.last_name') }}';
      document.getElementById('payerEmail').value = '{{ session('web_user.email') }}';
      document.getElementById('payerPhone').value = '{{ session('web_user.phone') ?? '' }}';
      @endif
      
      new bootstrap.Modal(document.getElementById('paymentModal')).show();
  }

  function processPayment() {
      const name = document.getElementById('payerName').value;
      const email = document.getElementById('payerEmail').value;
      const phone = document.getElementById('payerPhone').value;
      const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
      
      if (!name || !email) {
          showToast('Please enter your name and email address', 'warning');
          return;
      }
      
      // Close modal and show processing
      bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
      showToast(`Processing ${selectedPackage.plan} plan payment via ${paymentMethod}...`, 'info');
      
      // Simulate payment redirect (replace with actual Pesapal integration)
      setTimeout(() => {
          window.location.href = `/payment/pesapal?plan=${selectedPackage.plan}&amount=${selectedPackage.priceUsd}&period=${selectedPackage.period}`;
      }, 1500);
  }

  function showToast(message, type) {
      let container = document.getElementById('toastContainer');
      if (!container) {
          container = document.createElement('div');
          container.id = 'toastContainer';
          container.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem;';
          document.body.appendChild(container);
      }
      const colors = { success: '#28a745', danger: '#dc3545', warning: '#ffc107', info: '#17a2b8' };
      const toast = document.createElement('div');
      toast.style.cssText = `background:${colors[type] || colors.success};color:#fff;padding:0.75rem 1rem;border-radius:0.5rem;box-shadow:0 0.5rem 1rem rgba(0,0,0,.2);min-width:260px;font-size:0.875rem;cursor:pointer;animation:fadeInUp .2s ease;`;
      toast.innerHTML = `<div style="display:flex;align-items:center;gap:0.6rem;"><strong>${type === 'success' ? '✓' : (type === 'warning' ? '⚠' : 'ℹ')}</strong><span>${message}</span></div>`;
      toast.onclick = () => toast.remove();
      container.appendChild(toast);
      setTimeout(() => toast.remove(), 5000);
  }

  document.addEventListener('DOMContentLoaded', () => detectAndSetCurrency());
</script>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
.dropdown-item.active { background-color: rgba(var(--bs-primary-rgb), 0.1) !important; color: var(--bs-primary) !important; }
.shadow-xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
</style>