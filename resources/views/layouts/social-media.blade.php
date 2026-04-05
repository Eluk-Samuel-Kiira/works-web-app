{{-- ── SOCIAL MEDIA MODAL ── --}}
<div id="socialMediaModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.5);
            align-items:center;justify-content:center;padding:16px"
     onclick="if(event.target===this)this.style.display='none'">
  <div style="background:var(--bs-body-bg);border-radius:16px;width:100%;max-width:560px;
              max-height:88vh;display:flex;flex-direction:column;overflow:hidden">

    {{-- Modal header --}}
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
      <div>
        <h5 class="fw-semibold mb-0">Find Us Online</h5>
        <p class="text-muted mb-0" style="font-size:12px">Follow &amp; connect with us on social media</p>
      </div>
      <button type="button"
              onclick="document.getElementById('socialMediaModal').style.display='none'"
              class="btn btn-sm btn-outline-secondary rounded-circle p-1"
              style="width:32px;height:32px;line-height:1">
        <i class="bi bi-x fs-5"></i>
      </button>
    </div>

    {{-- Country filter tabs --}}
    <div class="px-4 pt-3 pb-0 border-bottom">
      <div id="socialCountryTabs"
           class="d-flex gap-2 overflow-auto pb-3"
           style="scrollbar-width:none;-ms-overflow-style:none">
        <button class="btn btn-sm btn-primary rounded-pill px-3 social-tab-btn active"
                data-country="all" onclick="filterSocialByCountry('all', this)">
          All
        </button>
      </div>
    </div>

    {{-- Scrollable list --}}
    <div class="overflow-auto p-3" style="flex:1" id="socialMediaList">
      <div class="text-center py-5">
        <div class="spinner-border text-primary" style="width:1.5rem;height:1.5rem;"></div>
        <p class="text-muted small mt-2 mb-0">Loading...</p>
      </div>
    </div>

    {{-- Modal footer --}}
    <div class="px-4 py-3 border-top text-center">
      <button type="button"
              onclick="document.getElementById('socialMediaModal').style.display='none'"
              class="btn btn-outline-secondary btn-sm px-4">
        Close
      </button>
    </div>

  </div>
</div>

<script>
// ── SOCIAL MEDIA MODAL ──────────────────────────────────────
let socialData      = null;   // cached after first load
let socialFiltered  = [];

async function openSocialModal() {
    document.getElementById('socialMediaModal').style.display = 'flex';
    if (socialData) return;   // already loaded
    await fetchSocialMedia();
}

async function fetchSocialMedia() {
    try {
        const mainAppUrl = '{{ config("api.main_app.api_base") }}';
        const res  = await fetch(mainAppUrl + '/v2/social-media?per_page=200&is_active=1', {
            headers: { 'Accept': 'application/json' }
        });
        const json = await res.json();
        socialData = json.data ?? [];
        buildCountryTabs(socialData);
        renderSocialList(socialData);
    } catch (e) {
        document.getElementById('socialMediaList').innerHTML = `
            <div class="text-center py-5 text-danger">
                <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
                <p class="small mb-0">Failed to load social media links.</p>
            </div>`;
    }
}

function buildCountryTabs(items) {
    // Collect unique countries
    const countries = [...new Map(
        items
            .filter(i => i.location?.country)
            .map(i => [i.location.country, i.location])
    ).entries()].map(([, loc]) => loc);

    const tabsEl = document.getElementById('socialCountryTabs');
    countries.forEach(loc => {
        const btn = document.createElement('button');
        btn.className        = 'btn btn-sm btn-outline-primary rounded-pill px-3 social-tab-btn';
        btn.dataset.country  = loc.country;
        btn.textContent      = loc.country;
        btn.onclick          = () => filterSocialByCountry(loc.country, btn);
        tabsEl.appendChild(btn);
    });
}

function filterSocialByCountry(country, btn) {
    // Update active tab
    document.querySelectorAll('.social-tab-btn').forEach(b => {
        b.classList.remove('active', 'btn-primary');
        b.classList.add('btn-outline-primary');
    });
    btn.classList.add('active', 'btn-primary');
    btn.classList.remove('btn-outline-primary');

    const filtered = country === 'all'
        ? socialData
        : socialData.filter(i => i.location?.country === country);

    renderSocialList(filtered);
}

function renderSocialList(items) {
    const el = document.getElementById('socialMediaList');

    if (!items || items.length === 0) {
        el.innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="bi bi-globe2 fs-3 d-block mb-2 opacity-50"></i>
                <p class="small mb-0">No social media links found.</p>
            </div>`;
        return;
    }

    // Group by country
    const grouped = {};
    items.forEach(item => {
        const country = item.location?.country ?? 'General';
        if (!grouped[country]) grouped[country] = [];
        grouped[country].push(item);
    });

    el.innerHTML = Object.entries(grouped).map(([country, links]) => `
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-2 px-1">
                <i class="bi bi-geo-alt-fill text-primary" style="font-size:.8rem"></i>
                <span class="fw-semibold text-muted" style="font-size:11px;text-transform:uppercase;letter-spacing:.08em">
                    ${escHtml(country)}
                </span>
                <hr class="flex-grow-1 my-0">
            </div>
            <div class="d-flex flex-column gap-2">
                ${links.map(item => renderSocialItem(item)).join('')}
            </div>
        </div>
    `).join('');
}

function renderSocialItem(item) {
    const color     = item.platform_color    ?? '#6c757d';
    const icon      = item.platform_icon     ?? 'bi bi-globe';
    const label     = item.platform_label    ?? item.platform ?? '—';
    const followers = item.followers_formatted ?? null;
    const uid       = 'sc-' + (item.id ?? Math.random().toString(36).slice(2));

    return `
    <a href="${escHtml(item.url)}" target="_blank" rel="noopener"
       style="text-decoration:none;border:1px solid var(--bs-border-color);border-radius:12px;
              padding:12px 14px;display:flex;align-items:center;gap:12px;
              transition:all .2s ease;background:var(--bs-body-bg);"
       onmouseover="this.style.borderColor='${color}';this.style.background='${color}11'"
       onmouseout="this.style.borderColor='var(--bs-border-color)';this.style.background='var(--bs-body-bg)'">

        {{-- Platform icon circle --}}
        <span style="width:40px;height:40px;background:${escHtml(color)};border-radius:50%;
                     display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="${escHtml(icon)}" style="color:#fff;font-size:1.1rem;"></i>
        </span>

        {{-- Name + platform --}}
        <div style="flex:1;min-width:0">
            <div class="fw-semibold text-body" style="font-size:.9rem;line-height:1.3">
                ${escHtml(item.name)}
            </div>
            <div class="text-muted" style="font-size:.75rem">
                ${label}${item.handle ? ' · @' + escHtml(item.handle) : ''}
            </div>
        </div>

        {{-- Followers + copy + arrow --}}
        <div class="d-flex flex-column align-items-end gap-1" style="flex-shrink:0">
            ${followers ? `<span class="badge rounded-pill" style="background:${escHtml(color)}22;color:${escHtml(color)};font-size:10px">${escHtml(followers)}</span>` : ''}
            ${item.is_verified ? `<i class="bi bi-patch-check-fill text-info" title="Verified" style="font-size:.85rem"></i>` : ''}

            {{-- Copy button --}}
            <button id="${uid}"
                    onclick="event.preventDefault();event.stopPropagation();copySocialLink('${escHtml(item.url)}','${uid}')"
                    title="Copy link"
                    style="background:none;border:1px solid var(--bs-border-color);border-radius:6px;
                           padding:2px 6px;cursor:pointer;display:flex;align-items:center;gap:3px;
                           font-size:10px;color:var(--bs-secondary-color);transition:all .15s ease;"
                    onmouseover="this.style.borderColor='${color}';this.style.color='${color}'"
                    onmouseout="this.style.borderColor='var(--bs-border-color)';this.style.color='var(--bs-secondary-color)'">
                <i class="bi bi-copy" style="font-size:.7rem"></i>
                <span>Copy</span>
            </button>

            <i class="bi bi-arrow-up-right text-muted" style="font-size:.75rem"></i>
        </div>
    </a>`;
}

function copySocialLink(url, btnId) {
    navigator.clipboard.writeText(url).then(() => {
        const btn  = document.getElementById(btnId);
        if (!btn) return;
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2" style="font-size:.7rem"></i><span>Copied!</span>';
        btn.style.color       = '#22c55e';
        btn.style.borderColor = '#22c55e';
        setTimeout(() => {
            btn.innerHTML         = orig;
            btn.style.color       = '';
            btn.style.borderColor = '';
        }, 2000);
    }).catch(() => {
        // Fallback for older browsers
        const ta = document.createElement('textarea');
        ta.value = url;
        ta.style.cssText = 'position:fixed;opacity:0';
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        ta.remove();
        const btn = document.getElementById(btnId);
        if (btn) {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2" style="font-size:.7rem"></i><span>Copied!</span>';
            btn.style.color = '#22c55e';
            setTimeout(() => { btn.innerHTML = orig; btn.style.color = ''; }, 2000);
        }
    });
}

function escHtml(str) {
    if (str == null) return '';
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>