<footer style="background:#07080f;border-top:1px solid rgba(255,255,255,.07);">
  <div class="container py-5">
    <div class="row g-4">

      {{-- Brand col --}}
      <div class="col-lg-4">
        <a href="/" class="d-flex align-items-center gap-2 text-decoration-none mb-3">
          <img src="{{ getFavicon() }}" alt="logo" width="24" height="24">
          <span style="font-size:17px;font-weight:700;color:#fff;letter-spacing:-.3px;">
            Stardena <span style="background:linear-gradient(135deg,#818cf8,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Works</span>
          </span>
        </a>
        <p style="color:rgba(255,255,255,.38);font-size:13px;line-height:1.7;max-width:280px;margin-bottom:20px;">
          Connecting talent with opportunity across Uganda and Africa. Powered by AI, built for people.
        </p>
        <div class="d-flex gap-2">
          @foreach([
            ['bi-facebook',  'comingSoon()'],
            ['bi-twitter-x', 'comingSoon()'],
            ['bi-linkedin',  'comingSoon()'],
            ['bi-instagram', 'comingSoon()'],
          ] as [$icon, $fn])
          <a href="/coming-soon" onclick="{{ $fn }}"
             class="footer-social-btn"
             style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.5);text-decoration:none;transition:background .15s,color .15s,border-color .15s;">
            <i class="bi {{ $icon }}" style="font-size:14px;"></i>
          </a>
          @endforeach
          <a href="/coming-soon" onclick="comingSoon()"
             style="width:34px;height:34px;border-radius:8px;background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.3);display:flex;align-items:center;justify-content:center;color:#4ade80;text-decoration:none;transition:background .15s;">
            <i class="bi bi-whatsapp" style="font-size:14px;"></i>
          </a>
        </div>
      </div>

      {{-- For Workers --}}
      <div class="col-6 col-lg-2">
        <h6 style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:14px;">For Workers</h6>
        <ul class="list-unstyled mb-0">
          @foreach([
            ['Browse Jobs', "window.location='".route('jobs.index')."'"],
            ['Quick Gigs',    'comingSoon()'],
            ['AI CV Builder', 'comingSoon()'],
            ['Job Alerts',    'comingSoon()'],
          ] as [$label, $fn])
          <li class="mb-2">
            <a href="/coming-soon" onclick="{{ $fn }}" class="footer-link" style="font-size:13px;color:rgba(255,255,255,.42);text-decoration:none;transition:color .15s;">{{ $label }}</a>
          </li>
          @endforeach
        </ul>
      </div>

      {{-- For Employers --}}
      <div class="col-6 col-lg-2">
        <h6 style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:14px;">For Employers</h6>
        <ul class="list-unstyled mb-0">
          @foreach([
            ['Post a Job',    'comingSoon()'],
            ['Search Talent', 'comingSoon()'],
            ['Pricing',       'comingSoon()'],
            ['AI CV Scanner', 'comingSoon()'],
          ] as [$label, $fn])
          <li class="mb-2">
            <a href="/coming-soon" onclick="{{ $fn }}" class="footer-link" style="font-size:13px;color:rgba(255,255,255,.42);text-decoration:none;transition:color .15s;">{{ $label }}</a>
          </li>
          @endforeach
        </ul>
      </div>

      {{-- Newsletter --}}
      <div class="col-lg-4">
        <h6 style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:14px;">Stay Updated</h6>
        <p style="font-size:13px;color:rgba(255,255,255,.4);margin-bottom:14px;">Get job alerts and platform news in your inbox.</p>
        <div class="d-flex gap-2 mb-3">
          <input type="email" placeholder="your@email.com"
                 style="flex:1;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:8px;padding:9px 14px;color:#fff;font-size:13px;outline:none;min-width:0;"
                 onfocus="this.style.borderColor='rgba(79,110,247,.5)'"
                 onblur="this.style.borderColor='rgba(255,255,255,.1)'">
          <button onclick="comingSoon()"
                  style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;border-radius:8px;padding:9px 18px;font-size:13px;font-weight:600;white-space:nowrap;flex-shrink:0;">
            Subscribe
          </button>
        </div>
        <div style="background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:8px;padding:10px 14px;display:flex;align-items:center;gap:8px;">
          <i class="bi bi-whatsapp" style="color:#4ade80;font-size:15px;flex-shrink:0;"></i>
          <span style="font-size:12px;color:rgba(255,255,255,.45);">Join our WhatsApp channel for instant job alerts</span>
        </div>
      </div>

    </div>

    {{-- Divider --}}
    <div style="height:1px;background:rgba(255,255,255,.07);margin:36px 0 24px;"></div>

    {{-- Bottom bar --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
      <span style="font-size:12px;color:rgba(255,255,255,.25);">
        · By - <a href="https://stardena.org/" target="_blank" style="font-size:12px;color:rgba(255,255,255,.28);text-decoration:none;transition:color .15s;">  Stardena</a> 
      </span>
      <div class="d-flex gap-3">
          <a href="{{ route('about') }}" class="footer-link" style="font-size:12px;color:rgba(255,255,255,.28);text-decoration:none;transition:color .15s;">About Us</a>
          <a href="{{ route('contact') }}" class="footer-link" style="font-size:12px;color:rgba(255,255,255,.28);text-decoration:none;transition:color .15s;">Contact</a>
          <a href="{{ route('privacy-policy') }}" class="footer-link" style="font-size:12px;color:rgba(255,255,255,.28);text-decoration:none;transition:color .15s;">Privacy Policy</a>
      </div>
    </div>
  </div>
</footer>

<!-- WhatsApp Float -->
<a href="/coming-soon" onclick="comingSoon()"
   style="position:fixed;bottom:24px;right:24px;width:52px;height:52px;border-radius:50%;background:#22c55e;display:flex;align-items:center;justify-content:center;z-index:1000;text-decoration:none;box-shadow:0 4px 20px rgba(34,197,94,.4);animation:wa-pulse 2.5s infinite;">
  <i class="bi bi-whatsapp text-white" style="font-size:1.35rem;"></i>
</a>

<!-- Scroll to Top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"
        style="position:fixed;bottom:24px;left:24px;width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#4f6ef7,#7c3aed);border:none;color:#fff;display:none;align-items:center;justify-content:center;z-index:1000;box-shadow:0 4px 16px rgba(79,110,247,.4);cursor:pointer;transition:transform .2s;">
  <i class="bi bi-arrow-up" style="font-size:1rem;"></i>
</button>

<style>
.footer-link:hover { color: #818cf8 !important; }
.footer-social-btn:hover {
  background: rgba(79,110,247,.15) !important;
  border-color: rgba(79,110,247,.4) !important;
  color: #818cf8 !important;
}
#scrollTop:hover { transform: translateY(-3px); }
@keyframes wa-pulse {
  0%   { box-shadow: 0 0 0 0 rgba(34,197,94,.45); }
  70%  { box-shadow: 0 0 0 14px rgba(34,197,94,0); }
  100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
}
</style>

<script>
  window.addEventListener('scroll', function () {
    var btn = document.getElementById('scrollTop');
    if (!btn) return;
    btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
  });
</script>