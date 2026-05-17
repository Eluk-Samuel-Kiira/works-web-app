{{-- ============================================================
     resources/views/components/auth-modal.blade.php
     Include once in your main layout: @include('components.auth-modal')
     Trigger from anywhere:  onclick="openAuthModal('login')"
                             onclick="openAuthModal('register')"
     ============================================================ --}}

{{-- ── Backdrop + Modal shell ──────────────────────────────────── --}}
<div id="sw-backdrop"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);
            align-items:center;justify-content:center;padding:1rem;"
     onclick="swBackdropClick(event)">

  <div id="sw-modal"
       role="dialog" aria-modal="true" aria-labelledby="sw-modal-title"
       style="background:var(--bs-body-bg,#fff);border-radius:20px;
              border:1px solid rgba(0,0,0,.08);width:100%;max-width:440px;
              overflow:hidden;position:relative;">

    {{-- ── Modal header (logo + close) ──────────────────────────── --}}
    <div style="padding:20px 20px 0;display:flex;align-items:center;justify-content:space-between;">
      <a href="/" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
        <img src="{{ getFavicon() }}" alt="" style="width:22px;height:auto;">
        <span style="font-size:15px;font-weight:700;color:#2a3547;">
          {{ __('Stardena') }} <span style="color:var(--bs-primary);">{{ __('Works') }}</span>
        </span>
      </a>
      <button onclick="swClose()" aria-label="Close"
              style="width:30px;height:30px;border:none;border-radius:50%;
                     background:var(--bs-secondary-bg,#f5f5f5);
                     cursor:pointer;font-size:16px;line-height:1;
                     color:var(--bs-secondary-color,#666);display:flex;
                     align-items:center;justify-content:center;padding:0;">
        &times;
      </button>
    </div>

    {{-- ── Modal body ─────────────────────────────────────────────── --}}
    <div style="padding:16px 20px 24px;">

      {{-- Alert bar --}}
      <div id="sw-alert" style="display:none;padding:10px 14px;border-radius:10px;
           font-size:13px;margin-bottom:14px;"></div>

      {{-- ── MAIN VIEW (login / register) ──────────────────────── --}}
      <div id="sw-main">

        {{-- Tab switcher --}}
        <div style="display:flex;border:1px solid var(--bs-border-color,#dee2e6);
                    border-radius:10px;overflow:hidden;margin-bottom:18px;">
          <button id="sw-tab-login" onclick="swTab('login')"
                  style="flex:1;padding:8px 0;font-size:13px;font-weight:500;
                         border:none;cursor:pointer;transition:all .15s;
                         font-family:inherit;">
            Log in
          </button>
          <button id="sw-tab-register" onclick="swTab('register')"
                  style="flex:1;padding:8px 0;font-size:13px;font-weight:500;
                         border:none;cursor:pointer;transition:all .15s;
                         font-family:inherit;">
            Sign up
          </button>
        </div>

        {{-- ════════════════════════════════════════════════
             LOGIN PANEL
             ════════════════════════════════════════════════ --}}
        <div id="sw-login">
          <span style="display:inline-flex;align-items:center;gap:5px;
                       background:#EEEDFE;color:#3C3489;font-size:11px;
                       font-weight:600;padding:3px 10px;border-radius:20px;
                       margin-bottom:14px;">
            ✦ No password needed
          </span>
          <p style="font-size:18px;font-weight:700;color:#2a3547;margin:0 0 4px;" id="sw-modal-title">
            Welcome back
          </p>
          <p style="font-size:13px;color:var(--bs-secondary-color,#666);margin:0 0 18px;">
            Enter your email — we'll send a magic link to sign you in instantly.
          </p>

          <div style="margin-bottom:12px;">
            <label for="sw-login-email"
                   style="font-size:11px;font-weight:600;color:var(--bs-secondary-color,#888);
                          display:block;margin-bottom:5px;letter-spacing:.03em;">
              EMAIL ADDRESS
            </label>
            <input id="sw-login-email" type="email" placeholder="you@example.com"
                   autocomplete="email"
                   style="width:100%;box-sizing:border-box;padding:10px 14px;font-size:14px;
                          background:var(--bs-secondary-bg,#f8f9fa);
                          border:1px solid var(--bs-border-color,#dee2e6);
                          border-radius:10px;color:var(--bs-body-color,#212529);
                          outline:none;font-family:inherit;"
                   onfocus="this.style.borderColor='var(--bs-primary)';this.style.background='var(--bs-body-bg,#fff)'"
                   onblur="this.style.borderColor='var(--bs-border-color,#dee2e6)';this.style.background='var(--bs-secondary-bg,#f8f9fa)'"
                   onkeydown="if(event.key==='Enter')swSendLink()">
          </div>

          <button id="sw-login-btn" onclick="swSendLink()"
                  style="width:100%;padding:11px 0;font-size:14px;font-weight:600;
                         background:var(--bs-primary);color:#fff;border:none;
                         border-radius:11px;cursor:pointer;font-family:inherit;
                         display:flex;align-items:center;justify-content:center;gap:7px;
                         transition:opacity .15s;">
            <span id="sw-login-spinner"
                  style="display:none;width:14px;height:14px;border:2px solid rgba(255,255,255,.3);
                         border-top-color:#fff;border-radius:50%;
                         animation:swSpin .7s linear infinite;"></span>
            Send magic link ✉
          </button>

          <p style="text-align:center;font-size:13px;color:var(--bs-secondary-color,#666);margin-top:16px;">
            No account?
            <a href="javascript:void(0)" onclick="swTab('register')"
               style="color:var(--bs-primary);font-weight:600;text-decoration:none;">
              Create one free
            </a>
          </p>
        </div>

        {{-- ════════════════════════════════════════════════
             REGISTER PANEL
             ════════════════════════════════════════════════ --}}
        <div id="sw-register" style="display:none;">
          <p style="font-size:18px;font-weight:700;color:#2a3547;margin:0 0 4px;">
            Create your account
          </p>
          <p style="font-size:13px;color:var(--bs-secondary-color,#666);margin:0 0 18px;">
            Join thousands finding great work — no password, ever.
          </p>

          {{-- Name row --}}
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;">
            <div>
              <label for="sw-first"
                     style="font-size:11px;font-weight:600;color:var(--bs-secondary-color,#888);
                            display:block;margin-bottom:5px;letter-spacing:.03em;">
                FIRST NAME
              </label>
              <input id="sw-first" type="text" placeholder="Jane" autocomplete="given-name"
                     style="width:100%;box-sizing:border-box;padding:10px 14px;font-size:14px;
                            background:var(--bs-secondary-bg,#f8f9fa);
                            border:1px solid var(--bs-border-color,#dee2e6);
                            border-radius:10px;color:var(--bs-body-color,#212529);
                            outline:none;font-family:inherit;"
                     onfocus="this.style.borderColor='var(--bs-primary)';this.style.background='var(--bs-body-bg,#fff)'"
                     onblur="this.style.borderColor='var(--bs-border-color,#dee2e6)';this.style.background='var(--bs-secondary-bg,#f8f9fa)'">
            </div>
            <div>
              <label for="sw-last"
                     style="font-size:11px;font-weight:600;color:var(--bs-secondary-color,#888);
                            display:block;margin-bottom:5px;letter-spacing:.03em;">
                LAST NAME
              </label>
              <input id="sw-last" type="text" placeholder="Doe" autocomplete="family-name"
                     style="width:100%;box-sizing:border-box;padding:10px 14px;font-size:14px;
                            background:var(--bs-secondary-bg,#f8f9fa);
                            border:1px solid var(--bs-border-color,#dee2e6);
                            border-radius:10px;color:var(--bs-body-color,#212529);
                            outline:none;font-family:inherit;"
                     onfocus="this.style.borderColor='var(--bs-primary)';this.style.background='var(--bs-body-bg,#fff)'"
                     onblur="this.style.borderColor='var(--bs-border-color,#dee2e6)';this.style.background='var(--bs-secondary-bg,#f8f9fa)'">
            </div>
          </div>

          {{-- Email --}}
          <div style="margin-bottom:12px;">
            <label for="sw-email"
                   style="font-size:11px;font-weight:600;color:var(--bs-secondary-color,#888);
                          display:block;margin-bottom:5px;letter-spacing:.03em;">
              EMAIL ADDRESS
            </label>
            <input id="sw-email" type="email" placeholder="you@example.com"
                   autocomplete="email"
                   style="width:100%;box-sizing:border-box;padding:10px 14px;font-size:14px;
                          background:var(--bs-secondary-bg,#f8f9fa);
                          border:1px solid var(--bs-border-color,#dee2e6);
                          border-radius:10px;color:var(--bs-body-color,#212529);
                          outline:none;font-family:inherit;"
                   onfocus="this.style.borderColor='var(--bs-primary)';this.style.background='var(--bs-body-bg,#fff)'"
                   onblur="this.style.borderColor='var(--bs-border-color,#dee2e6)';this.style.background='var(--bs-secondary-bg,#f8f9fa)'">
          </div>

          {{-- Role picker --}}
          <div style="margin-bottom:12px;">
            <label style="font-size:11px;font-weight:600;color:var(--bs-secondary-color,#888);
                          display:block;margin-bottom:7px;letter-spacing:.03em;">
              I AM A
            </label>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
              <button id="sw-role-job_seeker" onclick="swRole('job_seeker')"
                      style="padding:10px 12px;border-radius:10px;text-align:left;cursor:pointer;
                             border:1.5px solid var(--bs-primary);
                             background:#EEEDFE;font-family:inherit;transition:all .15s;">
                <span style="font-size:18px;display:block;margin-bottom:4px;color:var(--bs-primary);">
                  &#128269;
                </span>
                <span style="font-size:13px;font-weight:600;color:#2a3547;display:block;">Job seeker</span>
                <span style="font-size:11px;color:var(--bs-secondary-color,#888);display:block;">Looking for work</span>
              </button>
              <button id="sw-role-employer" onclick="swRole('employer')"
                      style="padding:10px 12px;border-radius:10px;text-align:left;cursor:pointer;
                             border:1px solid var(--bs-border-color,#dee2e6);
                             background:var(--bs-secondary-bg,#f8f9fa);font-family:inherit;transition:all .15s;">
                <span style="font-size:18px;display:block;margin-bottom:4px;color:var(--bs-secondary-color,#888);">
                  &#127970;
                </span>
                <span style="font-size:13px;font-weight:600;color:#2a3547;display:block;">Employer</span>
                <span style="font-size:11px;color:var(--bs-secondary-color,#888);display:block;">Hiring talent</span>
              </button>
            </div>
          </div>

          {{-- Country + Phone --}}
          <div style="margin-bottom:12px;">
            <label style="font-size:11px;font-weight:600;color:var(--bs-secondary-color,#888);
                          display:block;margin-bottom:7px;letter-spacing:.03em;">
              COUNTRY &amp; PHONE
              <span style="font-weight:400;text-transform:none;letter-spacing:0;"> — optional</span>
            </label>
            <div style="display:grid;grid-template-columns:105px 1fr;gap:8px;">
              {{-- Country selector --}}
              <div style="position:relative;" id="sw-country-wrap">
                <div id="sw-country-display"
                     onclick="swToggleCountry()"
                     style="padding:10px 10px;font-size:13px;
                            background:var(--bs-secondary-bg,#f8f9fa);
                            border:1px solid var(--bs-border-color,#dee2e6);
                            border-radius:10px;cursor:pointer;
                            display:flex;align-items:center;gap:6px;
                            color:var(--bs-body-color,#212529);user-select:none;">
                  <span id="sw-cflag" style="font-size:16px;">🇺🇬</span>
                  <span id="sw-ccode" style="font-weight:500;">UG</span>
                  <span style="margin-left:auto;font-size:10px;color:var(--bs-secondary-color,#888);">▾</span>
                </div>
                <div id="sw-country-dd"
                     style="display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;
                            z-index:500;background:var(--bs-body-bg,#fff);
                            border:1px solid var(--bs-border-color,#dee2e6);
                            border-radius:10px;overflow:hidden;max-height:200px;overflow-y:auto;
                            box-shadow:0 8px 24px rgba(0,0,0,.1);">
                  <div style="padding:8px 10px;border-bottom:1px solid var(--bs-border-color,#dee2e6);">
                    <input id="sw-csearch" type="text" placeholder="Search…"
                           oninput="swFilterCountries(this.value)"
                           style="width:100%;box-sizing:border-box;border:none;
                                  background:none;outline:none;font-size:13px;
                                  color:var(--bs-body-color,#212529);font-family:inherit;">
                  </div>
                  <div id="sw-clist"></div>
                </div>
              </div>
              {{-- Phone --}}
              <div style="position:relative;">
                <span id="sw-pdial"
                      style="position:absolute;left:12px;top:50%;transform:translateY(-50%);
                             font-size:13px;color:var(--bs-secondary-color,#888);pointer-events:none;">
                  +256
                </span>
                <input id="sw-phone" type="tel" placeholder="700 000 000"
                       style="width:100%;box-sizing:border-box;padding:10px 14px 10px 50px;
                              font-size:14px;background:var(--bs-secondary-bg,#f8f9fa);
                              border:1px solid var(--bs-border-color,#dee2e6);
                              border-radius:10px;color:var(--bs-body-color,#212529);
                              outline:none;font-family:inherit;"
                       onfocus="this.style.borderColor='var(--bs-primary)';this.style.background='var(--bs-body-bg,#fff)'"
                       onblur="this.style.borderColor='var(--bs-border-color,#dee2e6)';this.style.background='var(--bs-secondary-bg,#f8f9fa)'">
              </div>
            </div>
          </div>

          {{-- Terms --}}
          <div style="display:flex;gap:8px;align-items:flex-start;margin-bottom:14px;">
            <input id="sw-terms" type="checkbox"
                   style="margin-top:2px;accent-color:var(--bs-primary);cursor:pointer;
                          width:14px;height:14px;flex-shrink:0;">
            <label for="sw-terms"
                   style="font-size:12px;color:var(--bs-secondary-color,#666);line-height:1.5;cursor:pointer;">
              I agree to the
              <a href="#" style="color:var(--bs-primary);font-weight:600;text-decoration:none;">Terms of Service</a>
              and
              <a href="#" style="color:var(--bs-primary);font-weight:600;text-decoration:none;">Privacy Policy</a>
              of Stardena Works.
            </label>
          </div>

          <button id="sw-reg-btn" onclick="swRegister()"
                  style="width:100%;padding:11px 0;font-size:14px;font-weight:600;
                         background:var(--bs-primary);color:#fff;border:none;
                         border-radius:11px;cursor:pointer;font-family:inherit;
                         display:flex;align-items:center;justify-content:center;gap:7px;
                         transition:opacity .15s;">
            <span id="sw-reg-spinner"
                  style="display:none;width:14px;height:14px;border:2px solid rgba(255,255,255,.3);
                         border-top-color:#fff;border-radius:50%;
                         animation:swSpin .7s linear infinite;"></span>
            Create account &amp; get magic link ✉
          </button>

          <p style="text-align:center;font-size:13px;color:var(--bs-secondary-color,#666);margin-top:14px;">
            Already have an account?
            <a href="javascript:void(0)" onclick="swTab('login')"
               style="color:var(--bs-primary);font-weight:600;text-decoration:none;">
              Log in
            </a>
          </p>
        </div>

      </div>{{-- /#sw-main --}}

      {{-- ── SUCCESS VIEW ─────────────────────────────────────────── --}}
      <div id="sw-success" style="display:none;text-align:center;padding:1.5rem 0;">
        <div style="width:64px;height:64px;margin:0 auto 16px;border-radius:50%;
                    background:#EEEDFE;display:flex;align-items:center;justify-content:center;
                    font-size:28px;">
          ✉
        </div>
        <p style="font-size:18px;font-weight:700;color:#2a3547;margin:0 0 8px;">Check your inbox</p>
        <p id="sw-success-msg"
           style="font-size:13px;color:var(--bs-secondary-color,#666);margin:0 0 20px;line-height:1.6;">
        </p>
        <p style="font-size:13px;color:var(--bs-secondary-color,#666);">
          Didn't receive it?
          <a href="javascript:void(0)" onclick="swResend()"
             style="color:var(--bs-primary);font-weight:600;text-decoration:none;">
            Resend link
          </a>
        </p>
        <button onclick="swClose()"
                style="margin-top:20px;padding:9px 24px;font-size:13px;font-weight:500;
                       background:var(--bs-secondary-bg,#f5f5f5);color:var(--bs-body-color,#212529);
                       border:1px solid var(--bs-border-color,#dee2e6);border-radius:10px;
                       cursor:pointer;font-family:inherit;">
          Close
        </button>
      </div>

    </div>{{-- /.modal body --}}
  </div>{{-- /#sw-modal --}}
</div>{{-- /#sw-backdrop --}}

{{-- ── Styles ──────────────────────────────────────────────────── --}}
<style>
  @keyframes swSpin { to { transform: rotate(360deg); } }
  #sw-backdrop { display: none; }
  #sw-tab-login, #sw-tab-register {
    background: transparent;
    color: var(--bs-secondary-color, #666);
  }
  #sw-tab-login.sw-active, #sw-tab-register.sw-active {
    background: var(--bs-primary);
    color: #fff;
  }
  #sw-login-btn:hover, #sw-reg-btn:hover { opacity: .88; }
  #sw-login-btn:disabled, #sw-reg-btn:disabled { opacity: .5; cursor: not-allowed; }
  .sw-country-item {
    padding: 9px 12px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: var(--bs-body-color, #212529);
  }
  .sw-country-item:hover { background: var(--bs-secondary-bg, #f8f9fa); }
  #sw-alert.sw-error {
    background: #fff5f5; color: #c53030;
    border: 1px solid #fed7d7;
  }
  #sw-alert.sw-success {
    background: #f0fff4; color: #276749;
    border: 1px solid #c6f6d5;
  }
</style>

{{-- ── Script ──────────────────────────────────────────────────── --}}
<script>
(function () {

  const API = '{{ config("api.main_app.api_base") }}';

  const COUNTRIES = [
    {code:'UG',name:'Uganda',     flag:'🇺🇬',dial:'256'},
    {code:'KE',name:'Kenya',      flag:'🇰🇪',dial:'254'},
    {code:'TZ',name:'Tanzania',   flag:'🇹🇿',dial:'255'},
    {code:'RW',name:'Rwanda',     flag:'🇷🇼',dial:'250'},
    {code:'ET',name:'Ethiopia',   flag:'🇪🇹',dial:'251'},
    {code:'NG',name:'Nigeria',    flag:'🇳🇬',dial:'234'},
    {code:'GH',name:'Ghana',      flag:'🇬🇭',dial:'233'},
    {code:'ZA',name:'South Africa',flag:'🇿🇦',dial:'27'},
    {code:'EG',name:'Egypt',      flag:'🇪🇬',dial:'20'},
    {code:'SD',name:'Sudan',      flag:'🇸🇩',dial:'249'},
    {code:'CD',name:'DR Congo',   flag:'🇨🇩',dial:'243'},
    {code:'TG',name:'Togo',       flag:'🇹🇬',dial:'228'},
    {code:'SN',name:'Senegal',    flag:'🇸🇳',dial:'221'},
    {code:'CM',name:'Cameroon',   flag:'🇨🇲',dial:'237'},
    {code:'ZM',name:'Zambia',     flag:'🇿🇲',dial:'260'},
    {code:'ZW',name:'Zimbabwe',   flag:'🇿🇼',dial:'263'},
    {code:'US',name:'United States',flag:'🇺🇸',dial:'1'},
    {code:'GB',name:'United Kingdom',flag:'🇬🇧',dial:'44'},
    {code:'DE',name:'Germany',    flag:'🇩🇪',dial:'49'},
    {code:'FR',name:'France',     flag:'🇫🇷',dial:'33'},
    {code:'IN',name:'India',      flag:'🇮🇳',dial:'91'},
    {code:'AE',name:'UAE',        flag:'🇦🇪',dial:'971'},
    {code:'SA',name:'Saudi Arabia',flag:'🇸🇦',dial:'966'},
    {code:'CA',name:'Canada',     flag:'🇨🇦',dial:'1'},
    {code:'AU',name:'Australia',  flag:'🇦🇺',dial:'61'},
    {code:'JP',name:'Japan',      flag:'🇯🇵',dial:'81'},
    {code:'CN',name:'China',      flag:'🇨🇳',dial:'86'},
  ];

  let selCountry = COUNTRIES[0];
  let selRole    = 'job_seeker';
  let lastEmail  = '';

  // ── Public API ────────────────────────────────────────────
  window.openAuthModal = function (tab) {
    document.getElementById('sw-backdrop').style.display = 'flex';
    document.getElementById('sw-main').style.display    = 'block';
    document.getElementById('sw-success').style.display = 'none';
    swAlert('', '');
    swTab(tab || 'login');
    swRenderCountries('');
  };

  window.swClose = function () {
    document.getElementById('sw-backdrop').style.display = 'none';
  };

  window.swBackdropClick = function (e) {
    if (e.target === document.getElementById('sw-backdrop')) swClose();
  };

  // ── Tab toggle ────────────────────────────────────────────
  window.swTab = function (tab) {
    document.getElementById('sw-login').style.display    = tab === 'login'    ? 'block' : 'none';
    document.getElementById('sw-register').style.display = tab === 'register' ? 'block' : 'none';
    document.getElementById('sw-tab-login').classList.toggle('sw-active', tab === 'login');
    document.getElementById('sw-tab-register').classList.toggle('sw-active', tab === 'register');
    swAlert('', '');
  };

  // ── Role picker ───────────────────────────────────────────
  window.swRole = function (role) {
    selRole = role;
    const active   = { border: '1.5px solid var(--bs-primary)', background: '#EEEDFE' };
    const inactive = { border: '1px solid var(--bs-border-color,#dee2e6)', background: 'var(--bs-secondary-bg,#f8f9fa)' };
    ['job_seeker','employer'].forEach(r => {
      const btn = document.getElementById('sw-role-' + r);
      const s   = r === role ? active : inactive;
      btn.style.border     = s.border;
      btn.style.background = s.background;
      btn.querySelector('span:first-child').style.color = r === role
        ? 'var(--bs-primary)' : 'var(--bs-secondary-color,#888)';
    });
  };

  // ── Alert ─────────────────────────────────────────────────
  function swAlert(type, msg) {
    const el = document.getElementById('sw-alert');
    el.className  = type ? 'sw-' + type : '';
    el.textContent = msg;
    el.style.display = msg ? 'block' : 'none';
  }

  // ── Spinner helpers ───────────────────────────────────────
  function swLoad(btnId, spId, on) {
    document.getElementById(btnId).disabled        = on;
    document.getElementById(spId).style.display    = on ? 'inline-block' : 'none';
  }

  // ── Send login link ───────────────────────────────────────
  window.swSendLink = async function () {
    const email = document.getElementById('sw-login-email').value.trim();
    if (!email || !swValidEmail(email)) { swAlert('error', 'Please enter a valid email address.'); return; }
    swLoad('sw-login-btn', 'sw-login-spinner', true);
    swAlert('', '');
    try {
      const res  = await fetch(API + '/auth/send-login-link', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body:    JSON.stringify({ email }),
      });
      const data = await res.json();
      if (res.ok && data.success) {
        lastEmail = email;
        swShowSuccess(email, false);
      } else {
        swAlert('error', data.message || 'No account found. Please register first.');
      }
    } catch {
      swAlert('error', 'Connection error. Please try again.');
    }
    swLoad('sw-login-btn', 'sw-login-spinner', false);
  };

  // ── Register ──────────────────────────────────────────────
  window.swRegister = async function () {
    const first  = document.getElementById('sw-first').value.trim();
    const last   = document.getElementById('sw-last').value.trim();
    const email  = document.getElementById('sw-email').value.trim();
    const phone  = document.getElementById('sw-phone').value.trim();
    const terms  = document.getElementById('sw-terms').checked;

    if (!first)                      { swAlert('error', 'First name is required.'); return; }
    if (!last)                       { swAlert('error', 'Last name is required.'); return; }
    if (!email || !swValidEmail(email)) { swAlert('error', 'A valid email address is required.'); return; }
    if (!terms)                      { swAlert('error', 'Please accept the Terms of Service to continue.'); return; }

    swLoad('sw-reg-btn', 'sw-reg-spinner', true);
    swAlert('', '');

    try {
      const res  = await fetch(API + '/auth/register', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body:    JSON.stringify({
          first_name:   first,
          last_name:    last,
          email:        email,
          phone:        phone ? '+' + selCountry.dial + phone.replace(/\D/g, '') : null,
          country_code: selCountry.code,
          role:         selRole,
          terms:        true,
        }),
      });
      const data = await res.json();
      if (res.ok && data.success) {
        lastEmail = email;
        swShowSuccess(email, true);
      } else if (res.status === 422 && data.errors) {
        swAlert('error', Object.values(data.errors).flat()[0]);
      } else {
        swAlert('error', data.message || 'Unable to create account. Please try again.');
      }
    } catch {
      swAlert('error', 'Connection error. Please try again.');
    }
    swLoad('sw-reg-btn', 'sw-reg-spinner', false);
  };

  // ── Resend ────────────────────────────────────────────────
  window.swResend = async function () {
    if (!lastEmail) return;
    try {
      const res = await fetch(API + '/auth/send-login-link', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body:    JSON.stringify({ email: lastEmail }),
      });
      if (res.ok) swAlert('success', 'Link resent — check your inbox again.');
    } catch { /* silent */ }
  };

  // ── Success screen ────────────────────────────────────────
  function swShowSuccess(email, isNew) {
    document.getElementById('sw-main').style.display    = 'none';
    document.getElementById('sw-success').style.display = 'block';
    document.getElementById('sw-success-msg').innerHTML = isNew
      ? 'Your account is ready. We sent a magic link to <strong>' + swEsc(email) + '</strong> — click it to sign in instantly.'
      : 'We sent a magic link to <strong>' + swEsc(email) + '</strong> — click it to sign in. No password needed.';
  }

  // ── Country dropdown ──────────────────────────────────────
  window.swToggleCountry = function () {
    const dd = document.getElementById('sw-country-dd');
    const open = dd.style.display === 'block';
    dd.style.display = open ? 'none' : 'block';
    if (!open) {
      document.getElementById('sw-csearch').value = '';
      swRenderCountries('');
      setTimeout(() => document.getElementById('sw-csearch').focus(), 50);
    }
  };

  window.swFilterCountries = function (q) { swRenderCountries(q); };

  function swRenderCountries(q) {
    const list = document.getElementById('sw-clist');
    const rows = q
      ? COUNTRIES.filter(c =>
          c.name.toLowerCase().includes(q.toLowerCase()) ||
          c.code.toLowerCase().includes(q.toLowerCase()))
      : COUNTRIES;
    list.innerHTML = rows.map(c =>
      '<div class="sw-country-item" onclick="swPickCountry(\'' + c.code + '\')">' +
        '<span style="font-size:16px;">' + c.flag + '</span>' +
        '<span>' + swEsc(c.name) + '</span>' +
        '<span style="margin-left:auto;font-size:11px;color:var(--bs-secondary-color,#888);">+' + c.dial + '</span>' +
      '</div>'
    ).join('');
  }

  window.swPickCountry = function (code) {
    const c = COUNTRIES.find(x => x.code === code);
    if (!c) return;
    selCountry = c;
    document.getElementById('sw-cflag').textContent  = c.flag;
    document.getElementById('sw-ccode').textContent  = c.code;
    document.getElementById('sw-pdial').textContent  = '+' + c.dial;
    document.getElementById('sw-country-dd').style.display = 'none';
  };

  document.addEventListener('click', function (e) {
    const wrap = document.getElementById('sw-country-wrap');
    if (wrap && !wrap.contains(e.target)) {
      document.getElementById('sw-country-dd').style.display = 'none';
    }
  });

  // ── Helpers ───────────────────────────────────────────────
  function swValidEmail(e) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e); }
  function swEsc(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  // ── ESC key to close ──────────────────────────────────────
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') swClose();
  });

})();
</script>