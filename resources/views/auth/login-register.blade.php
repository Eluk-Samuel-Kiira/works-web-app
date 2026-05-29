<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Login or Sign Up - Stardena Works</title>
    <meta name="description" content="Login to your Stardena Works account or create a new account to find jobs in Uganda.">
    
    <link rel="shortcut icon" type="image/png" href="{{ getFavicon() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ web_asset('front/css/styles.css') }}" />
    
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            background: #f8f9fc;
        }
        
        .auth-card {
            max-width: 480px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            padding: 40px 32px;
        }
        
        .auth-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
            background: #f1f5f9;
            padding: 6px;
            border-radius: 60px;
        }
        
        .auth-tab {
            flex: 1;
            background: transparent;
            border: none;
            padding: 12px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            color: #64748b;
            cursor: pointer;
        }
        
        .auth-tab.active {
            background: var(--bs-primary);
            color: #fff;
        }
        
        .form-group { margin-bottom: 20px; }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #334155;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #1e293b;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 3px rgba(93,135,255,.1);
        }
        
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--bs-primary);
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            margin-top: 12px;
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .alert-message {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }
        
        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255,255,255,.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin-right: 8px;
        }
        
        @keyframes spin { to { transform: rotate(360deg); } }
        
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .role-btn {
            padding: 14px 12px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            border: 1px solid #e2e8f0;
            background: #fff;
        }
        
        .role-btn.active {
            border-color: var(--bs-primary);
            background: rgba(93,135,255,.05);
        }
        
        .role-btn span:first-child { font-size: 24px; display: block; margin-bottom: 6px; }
        .role-btn span:nth-child(2) { font-size: 13px; font-weight: 600; color: #1e293b; }
        .role-btn span:last-child { font-size: 11px; color: #64748b; }
        
        .logo-link {
            position: fixed;
            top: 24px;
            left: 24px;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            padding: 10px 20px;
            border-radius: 100px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        .country-item { transition: background 0.15s; }
        .country-item:hover { background: #f8fafc; }
        
        @media (max-width: 768px) {
            .auth-card { padding: 28px 20px; }
            .auth-wrapper { padding: 60px 16px; }
        }
    </style>
</head>

<body style="background: #f8f9fc;">
    
    <a href="/" class="logo-link">
        <img src="{{ getFavicon() }}" alt="Stardena" style="width: 22px;">
        <span style="font-weight: 600; color: #1e293b;">Stardena Works</span>
    </a>
    
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-tabs">
                <button class="auth-tab" id="loginTab" onclick="switchTab('login')">Log In</button>
                <button class="auth-tab" id="registerTab" onclick="switchTab('register')">Sign Up</button>
            </div>
            
            <div id="alertContainer"></div>
            
            <!-- Login Form -->
            <div id="loginForm">
                <div style="margin-bottom: 20px;">
                    <span style="display:inline-flex;align-items:center;gap:5px;background:#eef2ff;color:#4f46e5;font-size:11px;font-weight:600;padding:4px 12px;border-radius:20px;margin-bottom:14px;">✦ No password needed</span>
                    <p style="font-size:22px;font-weight:700;color:#0f172a;margin:0 0 4px;">Welcome back</p>
                    <p style="font-size:13px;color:#64748b;margin:0 0 18px;">Enter your email — we'll send a magic link to sign you in instantly.</p>
                </div>
                
                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" id="loginEmail" class="form-control" placeholder="you@example.com">
                </div>
                
                <button id="loginBtn" onclick="sendMagicLink()" class="btn-submit">Send magic link ✉</button>
                
                <p style="text-align:center;font-size:13px;color:#64748b;margin-top:16px;">
                    No account? <a href="javascript:void(0)" onclick="switchTab('register')" style="color:var(--bs-primary);font-weight:600;">Create one free</a>
                </p>
            </div>
            
            <!-- Register Form -->
            <div id="registerForm" style="display: none;">
                <div style="margin-bottom: 20px;">
                    <p style="font-size:22px;font-weight:700;color:#0f172a;margin:0 0 4px;">Create your account</p>
                    <p style="font-size:13px;color:#64748b;margin:0 0 18px;">Join thousands finding great work — no password, ever.</p>
                </div>
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label>FIRST NAME</label>
                        <input type="text" id="firstName" class="form-control" placeholder="Jane">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label>LAST NAME</label>
                        <input type="text" id="lastName" class="form-control" placeholder="Doe">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" id="registerEmail" class="form-control" placeholder="you@example.com">
                </div>
                
                <!-- Country & Phone -->
                <div class="form-group">
                    <label>COUNTRY & PHONE NUMBER</label>
                    <div style="display:grid;grid-template-columns:130px 1fr;gap:12px;">
                        <div style="position:relative;">
                            <div id="countryDisplay" onclick="toggleCountryDropdown()" style="display:flex;align-items:center;gap:8px;padding:12px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;cursor:pointer;">
                                <span id="selectedFlag">🇺🇬</span>
                                <span id="selectedCode" style="font-weight:500;">UG</span>
                                <span style="margin-left:auto;">▼</span>
                            </div>
                            <div id="countryDropdown" style="display:none;position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #e2e8f0;border-radius:12px;margin-top:5px;z-index:1000;max-height:250px;overflow-y:auto;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                                <div style="padding:8px 12px;border-bottom:1px solid #e2e8f0;">
                                    <input type="text" id="countrySearch" placeholder="Search country..." onkeyup="filterCountries()" style="width:100%;padding:8px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;">
                                </div>
                                <div id="countryList"></div>
                            </div>
                        </div>
                        <div style="position:relative;">
                            <span id="phoneDialCode" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748b;">+256</span>
                            <input type="tel" id="phoneNumber" class="form-control" placeholder="774 536 343" style="padding-left:55px;">
                        </div>
                    </div>
                    <small style="font-size:11px;color:#64748b;display:block;margin-top:5px;">Optional but recommended for employers to reach you</small>
                </div>
                
                <div class="form-group">
                    <label>I AM A</label>
                    <div class="role-selector">
                        <div id="roleJobSeeker" class="role-btn active" onclick="selectRole('job_seeker')">
                            <span>🔍</span><span>Job Seeker</span><br><span>Looking for work</span>
                        </div>
                        <div id="roleEmployer" class="role-btn" onclick="selectRole('employer')">
                            <span>🏢</span><span>Employer</span><br><span>Hiring talent</span>
                        </div>
                    </div>
                    <input type="hidden" id="selectedRole" value="job_seeker">
                </div>
                
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                        <input type="checkbox" id="termsCheckbox" style="width:16px;height:16px;">
                        <span style="font-size:12px;color:#64748b;">I agree to the <a href="{{ route('terms-of-service') }}" target="_blank" style="color:var(--bs-primary);">Terms of Service</a> and <a href="{{ route('privacy-policy') }}" target="_blank" style="color:var(--bs-primary);">Privacy Policy</a></span>
                    </label>
                </div>
                
                <button id="registerBtn" onclick="registerUser()" class="btn-submit">Create account & get magic link ✉</button>
                
                <p style="text-align:center;font-size:13px;color:#64748b;margin-top:16px;">
                    Already have an account? <a href="javascript:void(0)" onclick="switchTab('login')" style="color:var(--bs-primary);font-weight:600;">Log in</a>
                </p>
            </div>
            
            <!-- Success View -->
            <div id="successView" style="display:none;text-align:center;padding:1.5rem 0;">
                <div style="width:64px;height:64px;margin:0 auto 16px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;font-size:28px;">✉</div>
                <p style="font-size:20px;font-weight:700;color:#0f172a;margin:0 0 8px;">Check Your E/Gmail Inbox</p>
                <p id="successMessage" style="font-size:13px;color:#64748b;margin:0 0 20px;"></p>
                <p style="font-size:13px;color:#64748b;">Didn't receive it? <a href="javascript:void(0)" onclick="resendLink()" style="color:var(--bs-primary);font-weight:600;">Resend link</a></p>
                <a href="/" class="btn-submit" style="display:inline-block;width:auto;padding:10px 24px;margin-top:20px;text-decoration:none;">Back to Home</a>
            </div>
        </div>
    </div>
    
    <script>
        const API = '{{ config("api.main_app.api_base") }}';
        const COUNTRIES = @json(config('countries.countries'));
        
        let selectedCountry = null;
        let lastEmail = '';
        let selectedRole = 'job_seeker';
        
        // Detect user's country from IP
        async function detectCountry() {
            try {
                const response = await fetch('https://ipapi.co/json/');
                const data = await response.json();
                const countryCode = data.country_code;
                const found = COUNTRIES.find(c => c.code === countryCode);
                if (found) {
                    selectedCountry = found;
                    updateCountryDisplay(found);
                } else {
                    selectedCountry = COUNTRIES.find(c => c.code === 'UG') || COUNTRIES[0];
                    updateCountryDisplay(selectedCountry);
                }
            } catch (error) {
                console.log('Country detection failed, using default');
                selectedCountry = COUNTRIES.find(c => c.code === 'UG') || COUNTRIES[0];
                updateCountryDisplay(selectedCountry);
            }
        }
        
        function updateCountryDisplay(country) {
            document.getElementById('selectedFlag').textContent = country.flag;
            document.getElementById('selectedCode').textContent = country.code;
            document.getElementById('phoneDialCode').textContent = '+' + country.phone;
        }
        
        function renderCountries(countries) {
            const list = document.getElementById('countryList');
            if (!list) return;
            list.innerHTML = countries.map(c => `
                <div class="country-item" onclick="selectCountry('${c.code}')" style="padding:10px 12px;display:flex;align-items:center;gap:10px;cursor:pointer;border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:18px;">${c.flag}</span>
                    <span style="flex:1;">${c.name}</span>
                    <span style="color:#64748b;font-size:12px;">+${c.phone}</span>
                </div>
            `).join('');
        }
        
        function filterCountries() {
            const search = document.getElementById('countrySearch')?.value.toLowerCase() || '';
            const filtered = COUNTRIES.filter(c => 
                c.name.toLowerCase().includes(search) || 
                c.code.toLowerCase().includes(search) ||
                c.phone.includes(search)
            );
            renderCountries(filtered);
        }
        
        function toggleCountryDropdown() {
            const dropdown = document.getElementById('countryDropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
                renderCountries(COUNTRIES);
                document.getElementById('countrySearch').value = '';
                setTimeout(() => document.getElementById('countrySearch')?.focus(), 100);
            }
        }
        
        function selectCountry(code) {
            const country = COUNTRIES.find(c => c.code === code);
            if (country) {
                selectedCountry = country;
                updateCountryDisplay(country);
                document.getElementById('countryDropdown').style.display = 'none';
            }
        }
        
        function switchTab(tab) {
            document.getElementById('loginForm').style.display = tab === 'login' ? 'block' : 'none';
            document.getElementById('registerForm').style.display = tab === 'register' ? 'block' : 'none';
            document.getElementById('successView').style.display = 'none';
            document.getElementById('loginTab').classList.toggle('active', tab === 'login');
            document.getElementById('registerTab').classList.toggle('active', tab === 'register');
            clearAlert();
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }
        
        function selectRole(role) {
            selectedRole = role;
            const jobSeeker = document.getElementById('roleJobSeeker');
            const employer = document.getElementById('roleEmployer');
            if (role === 'job_seeker') {
                jobSeeker.classList.add('active');
                employer.classList.remove('active');
            } else {
                employer.classList.add('active');
                jobSeeker.classList.remove('active');
            }
            document.getElementById('selectedRole').value = role;
        }
        
        function showAlert(message, type = 'error') {
            const container = document.getElementById('alertContainer');
            container.innerHTML = `<div class="alert-message alert-${type}">${message}</div>`;
            setTimeout(() => { if(container.firstChild) container.firstChild.remove(); }, 5000);
        }
        
        function clearAlert() { document.getElementById('alertContainer').innerHTML = ''; }
        
        function showLoading(btnId, isLoading) {
            const btn = document.getElementById(btnId);
            if (isLoading) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner"></span> Sending...';
            } else {
                btn.disabled = false;
                btn.innerHTML = btnId === 'loginBtn' ? 'Send magic link ✉' : 'Create account & get magic link ✉';
            }
        }
        
        function showSuccess(email, isNew) {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('successView').style.display = 'block';
            document.getElementById('successMessage').innerHTML = isNew
                ? `Your account is ready. We sent a magic link to <strong>${escapeHtml(email)}</strong> — click it to sign in instantly.`
                : `We sent a magic link to <strong>${escapeHtml(email)}</strong> — click it to sign in. No password needed.`;
            lastEmail = email;
        }
        
        function isValidEmail(email) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email); }
        function escapeHtml(str) { return str.replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[m])); }
        
        async function sendMagicLink() {
            const email = document.getElementById('loginEmail').value.trim();
            if (!email || !isValidEmail(email)) { showAlert('Please enter a valid email address.', 'error'); return; }
            showLoading('loginBtn', true);
            clearAlert();
            try {
                const response = await fetch(API + '/auth/send-login-link', {
                    method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();
                if (response.ok && data.success) { showSuccess(email, false); }
                else { showAlert(data.message || 'No account found. Please register first.', 'error'); showLoading('loginBtn', false); }
            } catch (error) { showAlert('Connection error. Please try again.', 'error'); showLoading('loginBtn', false); }
        }
        
        async function registerUser() {
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('registerEmail').value.trim();
            let phone = document.getElementById('phoneNumber').value.trim();
            const terms = document.getElementById('termsCheckbox').checked;
            const role = document.getElementById('selectedRole').value;
            
            if (!firstName) { showAlert('First name is required.', 'error'); return; }
            if (!lastName) { showAlert('Last name is required.', 'error'); return; }
            if (!email || !isValidEmail(email)) { showAlert('A valid email address is required.', 'error'); return; }
            if (!terms) { showAlert('Please accept the Terms of Service to continue.', 'error'); return; }
            
            showLoading('registerBtn', true);
            clearAlert();
            
            let formattedPhone = null;
            if (phone) {
                let cleanPhone = phone.replace(/\D/g, '');
                if (cleanPhone.startsWith(selectedCountry.phone)) cleanPhone = cleanPhone.substring(selectedCountry.phone.length);
                if (cleanPhone.startsWith('0')) cleanPhone = cleanPhone.substring(1);
                formattedPhone = '+' + selectedCountry.phone + cleanPhone;
            }
            
            try {
                const response = await fetch(API + '/auth/register', {
                    method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        first_name: firstName, last_name: lastName, email: email,
                        phone: formattedPhone, country_code: selectedCountry.code,
                        role: role, terms: true
                    })
                });
                const data = await response.json();
                if (response.ok && data.success) { showSuccess(email, true); }
                else if (response.status === 422 && data.errors) { showAlert(Object.values(data.errors).flat()[0], 'error'); showLoading('registerBtn', false); }
                else { showAlert(data.message || 'Unable to create account. Please try again.', 'error'); showLoading('registerBtn', false); }
            } catch (error) { showAlert('Connection error. Please try again.', 'error'); showLoading('registerBtn', false); }
        }
        
        async function resendLink() {
            if (!lastEmail) return;
            try {
                const response = await fetch(API + '/auth/send-login-link', {
                    method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email: lastEmail })
                });
                if (response.ok) showAlert('Link resent — check your inbox again.', 'success');
                else showAlert('Failed to resend link. Please try again.', 'error');
            } catch (error) { showAlert('Connection error. Please try again.', 'error'); }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const countryDisplay = document.getElementById('countryDisplay');
            const dropdown = document.getElementById('countryDropdown');
            if (countryDisplay && dropdown && !countryDisplay.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
        
        document.getElementById('loginEmail')?.addEventListener('keypress', function(e) { if (e.key === 'Enter') sendMagicLink(); });
        document.getElementById('countrySearch')?.addEventListener('keyup', filterCountries);
        
        const urlParams = new URLSearchParams(window.location.search);
        switchTab(urlParams.get('tab') === 'register' ? 'register' : 'login');
        
        // Initialize
        detectCountry();
        selectRole('job_seeker');
    </script>
</body>
</html>