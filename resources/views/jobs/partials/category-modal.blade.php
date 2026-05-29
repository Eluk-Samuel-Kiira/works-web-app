

<section class="py-4 py-lg-5 border-bottom" id="job-category">
  <div class="container-xl px-3 px-md-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
      <h2 class="h6 fw-semibold mb-0">Browse by category</h2>
      @if($visibleCats->count() > 6)
      <button type="button"
              class="btn btn-link text-primary small text-decoration-none p-0"
              onclick="document.getElementById('allCategoriesModal').style.display='flex'">
        View all {{ $visibleCats->count() }} <i class="bi bi-arrow-right ms-1"></i>
      </button>
      @endif
    </div>

    {{-- Categories Grid --}}
    <div class="row g-2 g-md-3">
      @php
        // Show first 5 categories on mobile, 6 on desktop
        $mobileLimit = 5;
        $desktopLimit = 6;
      @endphp
      
      @foreach($visibleCats->take($desktopLimit) as $i => $cat)
        {{-- Show first 5 on mobile, all 6 on desktop --}}
        <div class="col-4 col-lg-2 {{ $i >= $mobileLimit ? 'd-none d-lg-block' : '' }}">
          <a href="{{ route('jobs.category', ['slug' => $cat['slug'] ?? $cat['id']]) }}"
             class="card border rounded-3 text-center p-3 text-decoration-none h-100 category-card">
            <div class="mx-auto mb-2 rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                 style="width:40px;height:40px">
              <i class="{{ $cat['icon'] ?? 'bi bi-folder2' }} text-primary"></i>
            </div>
            <div class="fw-semibold text-body text-truncate" style="font-size:12px;line-height:1.3">
              {{ $cat['name'] }}
            </div>
            <div class="text-muted mt-1" style="font-size:11px">
              {{ number_format($cat['jobs_count']) }} jobs
            </div>
          </a>
        </div>
      @endforeach

      {{-- Mobile "View all" button as 6th item (only if more than 5 categories) --}}
      @if($visibleCats->count() > $mobileLimit)
      <div class="col-4 d-lg-none">
        <button type="button"
                onclick="document.getElementById('allCategoriesModal').style.display='flex'"
                class="card border rounded-3 text-center p-3 text-decoration-none h-100 category-card w-100 bg-transparent"
                style="cursor:pointer">
          <div class="mx-auto mb-2 rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
               style="width:40px;height:40px">
            <i class="bi bi-grid text-primary"></i>
          </div>
          <div class="fw-semibold text-primary" style="font-size:12px;line-height:1.3">View all</div>
          <div class="text-muted mt-1" style="font-size:11px">{{ $visibleCats->count() }} total</div>
        </button>
      </div>
      @endif
    </div>

    {{-- Fill remaining empty space on mobile row (ensures no whitespace gap) --}}
    @if($visibleCats->count() < $mobileLimit)
    @php $emptySlots = $mobileLimit - $visibleCats->count(); @endphp
    <div class="row g-2 g-md-3 d-lg-none">
      @for($i = 0; $i < $emptySlots; $i++)
      <div class="col-4"></div>
      @endfor
    </div>
    @endif

  </div>
</section>

{{-- ── ALL CATEGORIES MODAL ── --}}
<div id="allCategoriesModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.5);
            align-items:center;justify-content:center;padding:16px"
     onclick="if(event.target===this)this.style.display='none'">
  <div style="background:var(--bs-body-bg);border-radius:16px;width:100%;max-width:680px;
              max-height:85vh;display:flex;flex-direction:column;overflow:hidden">

    {{-- Modal header --}}
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
      <div>
        <h5 class="fw-semibold mb-0">All Categories</h5>
        <p class="text-muted mb-0" style="font-size:12px">
          {{ $visibleCats->count() }} categories with active jobs
        </p>
      </div>
      <button type="button"
              onclick="document.getElementById('allCategoriesModal').style.display='none'"
              class="btn btn-sm btn-outline-secondary rounded-circle p-1"
              style="width:32px;height:32px;line-height:1">
        <i class="bi bi-x fs-5"></i>
      </button>
    </div>

    {{-- Search inside modal --}}
    <div class="px-4 py-3 border-bottom">
      <div class="input-group input-group-sm">
        <span class="input-group-text bg-body border-end-0">
          <i class="bi bi-search text-muted"></i>
        </span>
        <input type="text"
               id="catModalSearch"
               class="form-control border-start-0 shadow-none"
               placeholder="Search categories..."
               oninput="filterModalCats(this.value)">
      </div>
    </div>

    {{-- Scrollable grid --}}
    <div class="overflow-auto p-3" style="flex:1">
      <div class="row g-2" id="catModalGrid">
        @foreach($visibleCats as $cat)
        <div class="col-6 col-sm-4 cat-modal-item"
             data-name="{{ strtolower($cat['name']) }}">
          <a href="{{ route('jobs.category', ['slug' => $cat['slug'] ?? $cat['id']]) }}"
             class="card border rounded-3 text-center p-3 text-decoration-none h-100 category-card">
            <div class="mx-auto mb-2 rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px">
              <i class="{{ $cat['icon'] ?? 'bi bi-folder2' }} text-primary" style="font-size:1rem"></i>
            </div>
            <div class="fw-semibold text-body text-truncate" style="font-size:12px;line-height:1.3">
              {{ $cat['name'] }}
            </div>
            <div class="text-muted mt-1" style="font-size:11px">
              {{ number_format($cat['jobs_count']) }} jobs
            </div>
          </a>
        </div>
        @endforeach
        <div id="catNoResults" class="col-12 text-center py-4 text-muted d-none">
          <i class="bi bi-search d-block fs-2 mb-2 opacity-50"></i>
          No categories found
        </div>
      </div>
    </div>

    {{-- Modal footer --}}
    <div class="px-4 py-3 border-top text-center">
      <button type="button"
              onclick="document.getElementById('allCategoriesModal').style.display='none'"
              class="btn btn-outline-secondary btn-sm px-4">
        Close
      </button>
    </div>

  </div>
</div>

<script>
  function filterModalCats(val) {
      const term  = val.toLowerCase().trim();
      const items = document.querySelectorAll('.cat-modal-item');
      let   shown = 0;
      items.forEach(el => {
          const match = !term || el.dataset.name.includes(term);
          el.style.display = match ? '' : 'none';
          if (match) shown++;
      });
      document.getElementById('catNoResults').classList.toggle('d-none', shown > 0);
  }

  // Close modal on Escape key
  document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
          document.getElementById('allCategoriesModal').style.display = 'none';
      }
  });
</script>