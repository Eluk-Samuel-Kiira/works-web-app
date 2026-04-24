@extends('layouts.jobs')

@section('title', 'Blog — Career Tips, Job Search Advice & Industry Insights | Stardena Works')
@section('meta_description', 'Expert career advice, job search tips, resume writing guides, and industry insights to help you advance your career in Uganda and beyond.')
@section('canonical', url('/blog'))
@section('og_title', 'Blog | Stardena Works')
@section('og_description', 'Expert career advice and job search tips to help you land your dream job.')

@section('job-content')

<div class="main-wrapper">

  {{-- ─────────────────────────────────────────────────────
       HERO — SEARCH & FILTERS (Like Jobs Page)
  ───────────────────────────────────────────────────── --}}
  <section class="bg-primary py-5 py-lg-6">
    <div class="container-xl px-3 px-md-4">
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 text-center">
          <p class="text-white-50 text-uppercase small mb-2" style="letter-spacing:.1em">Stardena Works Blog</p>
          <h1 class="text-white fw-bold mb-3" style="font-size:clamp(1.6rem,4vw,2.5rem)">
            Career <span style="color:#fdd835">insights</span> & expert advice
          </h1>
          <p class="text-white-50 mb-4" style="font-size:.9375rem">
            Practical tips, industry trends, and strategies to help you grow your career
          </p>

          {{-- Search & Filter Bar (Like Jobs) --}}
          <div class="bg-white rounded-3 shadow p-2 d-flex flex-column flex-sm-row gap-2 align-items-stretch">
            <div class="d-flex align-items-center flex-grow-1 px-2">
              <i class="bi bi-search text-muted me-2 flex-shrink-0"></i>
              <input type="text" id="searchBlogs" class="form-control border-0 p-0 shadow-none"
                     placeholder="Search articles..." aria-label="Search">
            </div>
            <div class="d-flex align-items-center flex-grow-1 px-2 border-top border-sm-top-0 border-sm-start pt-2 pt-sm-0">
              <i class="bi bi-tag text-muted me-2 flex-shrink-0"></i>
              <select id="filterCategory" class="form-select border-0 p-0 shadow-none bg-transparent" style="width:auto">
                <option value="">All Categories</option>
              </select>
            </div>
            <div class="d-flex align-items-center flex-grow-1 px-2 border-top border-sm-top-0 border-sm-start pt-2 pt-sm-0">
              <i class="bi bi-tag text-muted me-2 flex-shrink-0"></i>
              <select id="filterSort" class="form-select border-0 p-0 shadow-none bg-transparent" style="width:auto">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="popular">Most Popular</option>
              </select>
            </div>
            <button type="button" class="btn btn-primary fw-semibold px-4 flex-shrink-0" onclick="resetFilters()">
              <i class="bi bi-arrow-repeat me-2"></i>Reset
            </button>
          </div>

          {{-- Popular topics --}}
          <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3" id="popularTopics">
            <span class="text-white-50 small">Popular:</span>
            <span class="badge rounded-pill fw-normal text-white border border-white border-opacity-25 text-decoration-none" style="background:rgba(255,255,255,.12);font-size:12px">Career Tips</span>
            <span class="badge rounded-pill fw-normal text-white border border-white border-opacity-25 text-decoration-none" style="background:rgba(255,255,255,.12);font-size:12px">Job Search</span>
            <span class="badge rounded-pill fw-normal text-white border border-white border-opacity-25 text-decoration-none" style="background:rgba(255,255,255,.12);font-size:12px">Interview Prep</span>
            <span class="badge rounded-pill fw-normal text-white border border-white border-opacity-25 text-decoration-none" style="background:rgba(255,255,255,.12);font-size:12px">Resume Writing</span>
            <span class="badge rounded-pill fw-normal text-white border border-white border-opacity-25 text-decoration-none" style="background:rgba(255,255,255,.12);font-size:12px">Workplace</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- AD SLOT 1 — Top Leaderboard --}}
  <div class="bg-body border-bottom py-1 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-3587587638253109"
        data-ad-slot="1832373916"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- Featured Post --}}
  <div id="featuredPostContainer" class="py-4 py-lg-5 bg-body-tertiary border-bottom d-none">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted small fw-semibold mb-3" style="letter-spacing:.08em;font-size:11px">
        <i class="bi bi-star-fill text-warning me-1"></i>Featured Article
      </p>
      <div class="row g-4 align-items-center" id="featuredPost"></div>
    </div>
  </div>

  {{-- AD SLOT 2 — After Featured --}}
  <div class="bg-body border-bottom py-1 text-center d-none" id="adAfterFeatured">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-3587587638253109"
        data-ad-slot="5328765795"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- Blog Grid --}}
  <section class="py-4 py-lg-5">
    <div class="container-xl px-3 px-md-4">

      {{-- Results bar --}}
      <div class="d-flex align-items-center justify-content-between mb-4 gap-2 flex-wrap">
        <p class="mb-0 text-muted small" id="resultsCount"></p>
        <div class="d-flex gap-2 align-items-center">
          <span class="text-muted small d-none d-sm-inline">View:</span>
          <button class="btn btn-sm btn-primary grid-toggle active" data-cols="3" title="Grid view">
            <i class="bi bi-grid-3x3-gap"></i>
          </button>
          <button class="btn btn-sm btn-outline-secondary grid-toggle" data-cols="1" title="List view">
            <i class="bi bi-list-ul"></i>
          </button>
        </div>
      </div>

      {{-- Loading Spinner --}}
      <div id="blogLoading" class="text-center py-5 d-none">
        <div class="spinner-border text-primary" role="status" style="width:2.5rem;height:2.5rem">
          <span class="visually-hidden">Loading…</span>
        </div>
        <p class="text-muted mt-3 small">Loading articles…</p>
      </div>

      {{-- Blog Grid Container --}}
      <div class="row g-4" id="blogGrid"></div>

      {{-- No Results --}}
      <div id="noResults" class="text-center py-5 d-none">
        <div class="mb-3" style="font-size:3rem">📭</div>
        <h3 class="h5 fw-semibold mb-2">No articles found</h3>
        <p class="text-muted mb-3">Try adjusting your search or filters.</p>
        <button class="btn btn-outline-primary btn-sm rounded-pill px-4" onclick="resetFilters()">
          <i class="bi bi-arrow-repeat me-1"></i>Clear filters
        </button>
      </div>

      {{-- Pagination --}}
      <div id="paginationContainer" class="d-flex justify-content-center mt-5"></div>

    </div>
  </section>

  {{-- AD SLOT 3 — Pre-CTA --}}
  <div class="bg-body border-top border-bottom py-2 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-3587587638253109"
        data-ad-slot="5963190616"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

  {{-- Newsletter Section --}}
  <section class="bg-primary py-5">
    <div class="container-xl px-3 px-md-4">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
          <p class="text-white-50 small text-uppercase mb-2" style="letter-spacing:.1em">Never miss an update</p>
          <h2 class="text-white fw-semibold fs-4 mb-2">Subscribe to our newsletter</h2>
          <p class="text-white-50 small mb-4">Get the latest career tips and job alerts delivered to your inbox.</p>
          <form id="newsletterForm" class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
            <input type="email" class="form-control" style="max-width:280px" placeholder="Your email address" required>
            <button type="submit" class="btn btn-light fw-semibold px-4">Subscribe</button>
          </form>
          <small class="text-white-50 d-block mt-2">No spam, unsubscribe anytime.</small>
        </div>
      </div>
    </div>
  </section>

  {{-- AD SLOT 4 — Footer Banner --}}
  <div class="bg-body border-top py-2 text-center">
    <div class="container-xl px-3 px-md-4">
      <p class="text-uppercase text-muted mb-1" style="font-size:9px;letter-spacing:.08em">Advertisement</p>
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-3587587638253109"
        data-ad-slot="9710863933"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  </div>

</div>

<script>
// ─── State ──────────────────────────────────────────────────────────────────
let currentPage     = 1;
let currentSort     = 'newest';
let currentCategory = '';
let currentSearch   = '';
let debounceTimer   = null;
let totalPages      = 1;
let colMode         = 3;   // 3 = grid, 1 = list

const API_BASE          = '/api/v2/blogs';
const DEFAULT_BLOG_IMG  = "{{ asset('blog-img1.jpg') }}";
const DEFAULT_AVATAR    = "{{ asset('user-2.jpg') }}";

// ─── Image helpers ───────────────────────────────────────────────────────────
const getBlogImage   = b  => (b.cover_image  && b.cover_image  !== '') ? b.cover_image  : DEFAULT_BLOG_IMG;
const getAuthorAvatar = a => (a?.avatar      && a.avatar       !== '') ? a.avatar       : DEFAULT_AVATAR;

// ─── Utility ─────────────────────────────────────────────────────────────────
function escapeHtml(str) {
  if (!str) return '';
  return String(str).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

function formatDate(dateStr) {
  if (!dateStr) return 'Recently';
  const diff = Math.floor((Date.now() - new Date(dateStr)) / 86400000);
  if (diff === 0) return 'Today';
  if (diff === 1) return 'Yesterday';
  if (diff < 7)  return `${diff} days ago`;
  if (diff < 30) return `${Math.floor(diff / 7)} wk ago`;
  if (diff < 365) return `${Math.floor(diff / 30)} mo ago`;
  return `${Math.floor(diff / 365)} yr ago`;
}

function formatReadTime(rt) {
  if (!rt) return '3 min';
  return (typeof rt === 'string') ? rt : `${rt} min`;
}

// ─── Search / Filter wiring ───────────────────────────────────────────────────
document.getElementById('searchBlogs').addEventListener('input', function () {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => { currentSearch = this.value.trim(); loadBlogs(1); }, 400);
});

document.getElementById('filterCategory').addEventListener('change', function () {
  currentCategory = this.value; loadBlogs(1);
});

document.getElementById('filterSort').addEventListener('change', function () {
  currentSort = this.value; loadBlogs(1);
});

// Grid / List toggle
document.querySelectorAll('.grid-toggle').forEach(btn => {
  btn.addEventListener('click', function () {
    document.querySelectorAll('.grid-toggle').forEach(b => b.classList.remove('active','btn-primary'));
    document.querySelectorAll('.grid-toggle').forEach(b => b.classList.add('btn-outline-secondary'));
    this.classList.remove('btn-outline-secondary');
    this.classList.add('active', 'btn-primary');
    colMode = parseInt(this.dataset.cols);
    renderGridLayout();
  });
});

function renderGridLayout() {
  document.querySelectorAll('#blogGrid > div').forEach(card => {
    card.className = colMode === 1
      ? 'col-12 blog-col'
      : 'col-12 col-sm-6 col-lg-4 blog-col';
  });
}

// Popular topic pills → set search
function filterByTopic(topic) {
  document.getElementById('searchBlogs').value = topic;
  currentSearch = topic;
  loadBlogs(1);
}

// ─── Load Categories ─────────────────────────────────────────────────────────
async function loadCategories() {
  try {
    const res  = await fetch(`${API_BASE}/categories`);
    const data = await res.json();
    const sel  = document.getElementById('filterCategory');
    (data.data || []).forEach(cat => {
      const opt = document.createElement('option');
      opt.value       = cat.category;
      opt.textContent = `${cat.category} (${cat.posts_count || 0})`;
      sel.appendChild(opt);
    });
  } catch (e) { console.error('Categories:', e); }
}

// ─── Load Blogs ───────────────────────────────────────────────────────────────
async function loadBlogs(page = 1) {
  currentPage = page;

  const params = new URLSearchParams({ page, per_page: 12, sort: currentSort });
  if (currentCategory) params.set('category', currentCategory);
  if (currentSearch)   params.set('search',   currentSearch);

  const grid      = document.getElementById('blogGrid');
  const loading   = document.getElementById('blogLoading');
  const noResults = document.getElementById('noResults');
  const resCount  = document.getElementById('resultsCount');

  loading.classList.remove('d-none');
  grid.innerHTML  = '';
  noResults.classList.add('d-none');
  resCount.textContent = '';

  try {
    const res  = await fetch(`${API_BASE}?${params}`);
    const data = await res.json();

    loading.classList.add('d-none');

    const blogs = data.data || [];
    const meta  = data.meta || { current_page: page, last_page: 1, total: 0 };

    if (blogs.length) {
      resCount.textContent = `${meta.total || blogs.length} article${meta.total !== 1 ? 's' : ''} found`;
      renderBlogs(blogs);
      renderPagination(meta);

      const isDefault = page === 1 && !currentCategory && !currentSearch && currentSort === 'newest';
      if (isDefault) {
        loadFeaturedPost();
      } else {
        document.getElementById('featuredPostContainer').classList.add('d-none');
        document.getElementById('adAfterFeatured').classList.add('d-none');
      }
    } else {
      resCount.textContent = '';
      noResults.classList.remove('d-none');
      document.getElementById('featuredPostContainer').classList.add('d-none');
      document.getElementById('adAfterFeatured').classList.add('d-none');
      document.getElementById('paginationContainer').innerHTML = '';
    }
  } catch (e) {
    loading.classList.add('d-none');
    grid.innerHTML = `
      <div class="col-12 text-center py-5">
        <div class="mb-3" style="font-size:2.5rem">⚠️</div>
        <p class="text-danger fw-semibold">Failed to load articles.</p>
        <button class="btn btn-outline-primary btn-sm rounded-pill px-4 mt-2" onclick="loadBlogs(1)">
          <i class="bi bi-arrow-repeat me-1"></i>Retry
        </button>
      </div>`;
    console.error('loadBlogs:', e);
  }
}

// ─── Render Blog Cards ────────────────────────────────────────────────────────
function renderBlogs(blogs) {
  const grid = document.getElementById('blogGrid');

  grid.innerHTML = blogs.map(blog => {
    const img        = escapeHtml(getBlogImage(blog));
    const avatar     = escapeHtml(getAuthorAvatar(blog.author));
    const category   = escapeHtml(blog.category || 'General');
    const title      = escapeHtml(blog.title || 'Untitled');
    const slug       = escapeHtml(blog.slug || '#');
    const excerpt    = escapeHtml((blog.excerpt || '').substring(0, 115));
    const author     = escapeHtml(blog.author?.name || 'Stardena Works');
    const date       = formatDate(blog.published_at);
    const views      = (blog.view_count || 0).toLocaleString();
    const rt         = formatReadTime(blog.reading_time);
    const isFeatured = blog.is_featured;

    const colClass   = colMode === 1 ? 'col-12' : 'col-12 col-sm-6 col-lg-4';

    return `
    <div class="${colClass} blog-col">
      <div class="card border-0 shadow-sm rounded-4 h-100 blog-card ${isFeatured ? 'blog-card--featured' : ''}">
        <div class="position-relative overflow-hidden rounded-top-4">
          <img src="${img}"
               class="card-img-top blog-card__img"
               alt="${title}"
               loading="lazy"
               onerror="this.src='${DEFAULT_BLOG_IMG}'"
               style="height:${colMode === 1 ? '200px' : '195px'};object-fit:cover;width:100%;display:block;transition:transform .35s ease">
          ${isFeatured ? '<span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark" style="font-size:10px"><i class="bi bi-star-fill me-1"></i>Featured</span>' : ''}
        </div>
        <div class="card-body p-4 d-flex flex-column">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge fw-normal" style="background:rgba(var(--bs-primary-rgb),.1);color:var(--bs-primary);font-size:10px">
              ${category}
            </span>
            <span class="text-muted" style="font-size:11px">
              <i class="bi bi-clock me-1"></i>${rt}
            </span>
          </div>

          <h3 class="fw-semibold mb-2 blog-card__title" style="font-size:.9625rem;line-height:1.45">
            <a href="/blog/${slug}" class="text-body text-decoration-none stretched-link">${title}</a>
          </h3>

          <p class="text-muted mb-3 flex-grow-1" style="font-size:.8125rem;line-height:1.55">
            ${excerpt ? excerpt + '…' : ''}
          </p>

          <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
            <div class="d-flex align-items-center gap-2">
              <img src="${avatar}"
                   class="rounded-circle border"
                   width="28" height="28"
                   style="object-fit:cover"
                   loading="lazy"
                   onerror="this.src='${DEFAULT_AVATAR}'">
              <div>
                <div class="fw-medium text-body" style="font-size:.75rem">${author}</div>
                <div class="text-muted" style="font-size:10px">${date}</div>
              </div>
            </div>
            <div class="text-muted d-flex align-items-center gap-1" style="font-size:11px">
              <i class="bi bi-eye"></i>${views}
            </div>
          </div>
        </div>
      </div>
    </div>
    `;
  }).join('');
}

// ─── Featured Post ────────────────────────────────────────────────────────────
async function loadFeaturedPost() {
  try {
    const res  = await fetch(`${API_BASE}/featured`);
    const data = await res.json();

    if (!data.data?.length) return;

    const f     = data.data[0];
    const img   = escapeHtml(getBlogImage(f));
    const av    = escapeHtml(getAuthorAvatar(f.author));
    const title = escapeHtml(f.title || '');
    const slug  = escapeHtml(f.slug || '#');
    const exc   = escapeHtml((f.excerpt || '').substring(0, 200));
    const auth  = escapeHtml(f.author?.name || 'Stardena Works');
    const date  = formatDate(f.published_at);
    const rt    = formatReadTime(f.reading_time);

    document.getElementById('featuredPost').innerHTML = `
      <div class="col-12 col-md-6">
        <a href="/blog/${slug}" class="d-block rounded-4 overflow-hidden">
          <img src="${img}"
               class="img-fluid w-100 featured-img"
               alt="${title}"
               style="height:280px;object-fit:cover;transition:transform .4s ease"
               onerror="this.src='${DEFAULT_BLOG_IMG}'">
        </a>
      </div>
      <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
        <span class="badge bg-warning text-dark mb-3 align-self-start" style="font-size:11px">
          <i class="bi bi-star-fill me-1"></i>Editor's Pick
        </span>
        <h2 class="fw-bold mb-3" style="font-size:clamp(1.2rem,2.5vw,1.65rem);line-height:1.3">
          <a href="/blog/${slug}" class="text-body text-decoration-none">${title}</a>
        </h2>
        <p class="text-muted mb-4" style="font-size:.9375rem;line-height:1.65">${exc}…</p>
        <div class="d-flex align-items-center gap-3 flex-wrap">
          <div class="d-flex align-items-center gap-2">
            <img src="${av}" class="rounded-circle border" width="36" height="36"
                 style="object-fit:cover" onerror="this.src='${DEFAULT_AVATAR}'">
            <div>
              <div class="fw-semibold small">${auth}</div>
              <div class="text-muted" style="font-size:11px">${date}</div>
            </div>
          </div>
          <span class="text-muted small"><i class="bi bi-clock me-1"></i>${rt}</span>
          <a href="/blog/${slug}" class="btn btn-primary btn-sm rounded-pill px-4 ms-auto">
            Read Article <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
    `;

    document.getElementById('featuredPostContainer').classList.remove('d-none');
    document.getElementById('adAfterFeatured').classList.remove('d-none');
  } catch (e) { console.error('Featured post:', e); }
}

// ─── Pagination ───────────────────────────────────────────────────────────────
function renderPagination(meta) {
  const container = document.getElementById('paginationContainer');
  totalPages = meta.last_page || 1;
  const cur  = meta.current_page || currentPage;

  if (totalPages <= 1) { container.innerHTML = ''; return; }

  const pages = [];
  for (let i = Math.max(1, cur - 2); i <= Math.min(totalPages, cur + 2); i++) pages.push(i);

  let html = '<ul class="pagination gap-1 flex-wrap justify-content-center mb-0">';

  html += `<li class="page-item ${cur <= 1 ? 'disabled' : ''}">
    <a class="page-link rounded-2" href="#" onclick="changePage(${cur - 1});return false">
      <i class="bi bi-chevron-left" style="font-size:11px"></i>
    </a></li>`;

  if (pages[0] > 1) {
    html += `<li class="page-item"><a class="page-link rounded-2" href="#" onclick="changePage(1);return false">1</a></li>`;
    if (pages[0] > 2) html += `<li class="page-item disabled"><span class="page-link border-0 bg-transparent">…</span></li>`;
  }

  pages.forEach(p => {
    html += `<li class="page-item ${p === cur ? 'active' : ''}">
      ${p === cur
        ? `<span class="page-link rounded-2">${p}</span>`
        : `<a class="page-link rounded-2" href="#" onclick="changePage(${p});return false">${p}</a>`
      }</li>`;
  });

  if (pages.at(-1) < totalPages) {
    if (pages.at(-1) < totalPages - 1) html += `<li class="page-item disabled"><span class="page-link border-0 bg-transparent">…</span></li>`;
    html += `<li class="page-item"><a class="page-link rounded-2" href="#" onclick="changePage(${totalPages});return false">${totalPages}</a></li>`;
  }

  html += `<li class="page-item ${cur >= totalPages ? 'disabled' : ''}">
    <a class="page-link rounded-2" href="#" onclick="changePage(${cur + 1});return false">
      <i class="bi bi-chevron-right" style="font-size:11px"></i>
    </a></li>`;

  html += '</ul>';
  container.innerHTML = html;
}

function changePage(page) {
  if (page < 1 || page > totalPages) return;
  loadBlogs(page);
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetFilters() {
  document.getElementById('filterCategory').value = '';
  document.getElementById('filterSort').value     = 'newest';
  document.getElementById('searchBlogs').value    = '';
  currentCategory = ''; currentSort = 'newest'; currentSearch = '';
  loadBlogs(1);
}

// ─── Newsletter ───────────────────────────────────────────────────────────────
document.getElementById('newsletterForm')?.addEventListener('submit', async e => {
  e.preventDefault();
  const btn = e.target.querySelector('button');
  const orig = btn.textContent;
  btn.disabled = true; btn.textContent = 'Subscribing…';
  await new Promise(r => setTimeout(r, 900));
  if (typeof showToast === 'function') showToast('success', 'Subscribed! Check your inbox.');
  else alert('Subscribed successfully!');
  e.target.reset(); btn.disabled = false; btn.textContent = orig;
});

// ─── Init ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  loadCategories();
  loadBlogs(1);
});
</script>

@endsection

@push('styles')
<style>
.container-xl { max-width: 1280px; }

/* ── Hero ──────────────────────────────────────────────────────────────── */
.blog-hero {
  background: linear-gradient(135deg, var(--bs-primary) 0%, #1565c0 60%, #0d47a1 100%);
  position: relative;
  overflow: hidden;
}
.blog-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse at 70% 50%, rgba(255,255,255,.06) 0%, transparent 70%);
  pointer-events: none;
}
.hero-accent { color: #fdd835; }

/* ── Search bar ────────────────────────────────────────────────────────── */
.blog-search-bar { border: 1px solid rgba(0,0,0,.06); }
.search-divider {
  width: 1px; background: #e9ecef; align-self: stretch; margin: 6px 0;
}

/* ── Topic pills ───────────────────────────────────────────────────────── */
.topic-pill { transition: background .15s ease; border: 1px solid rgba(255,255,255,.2); }
.topic-pill:hover { background: rgba(255,255,255,.25) !important; }

/* ── Blog card ─────────────────────────────────────────────────────────── */
.blog-card {
  transition: transform .2s ease, box-shadow .2s ease;
}
.blog-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 32px rgba(0,0,0,.12) !important;
}
.blog-card:hover .blog-card__img { transform: scale(1.04); }
.blog-card__title { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.blog-card--featured { border: 2px solid rgba(var(--bs-warning-rgb), .4) !important; }

/* ── Featured post ─────────────────────────────────────────────────────── */
.featured-img { object-fit: cover; }
#featuredPostContainer a:hover .featured-img { transform: scale(1.03); }

/* ── Pagination ────────────────────────────────────────────────────────── */
.pagination .page-item.active .page-link {
  background-color: var(--bs-primary);
  border-color: var(--bs-primary);
  color: #fff;
}
.pagination .page-link { color: var(--bs-primary); font-size: 13px; font-weight: 500; }
.pagination .page-item.disabled .page-link { color: var(--bs-secondary-color); }

/* ── Grid toggle ────────────────────────────────────────────────────────── */
.grid-toggle { width: 36px; height: 32px; display:inline-flex;align-items:center;justify-content:center; }

/* ── Responsive ─────────────────────────────────────────────────────────── */
@media (max-width: 575.98px) {
  .blog-search-bar { gap: .5rem; }
}
</style>
@endpush