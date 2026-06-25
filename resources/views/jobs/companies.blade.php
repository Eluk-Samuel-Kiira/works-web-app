@extends('layouts.jobs')

@section('title',            'Companies Hiring in Africa | Stardena Works')
@section('meta_description', 'Browse top companies hiring in Africa. Find company profiles, open positions and apply directly on Stardena Works.')
@section('canonical',        url('/companies'))
@section('robots',           'index, follow')

@section('job-content')
<div class="main-wrapper">

  {{-- AD SLOT 1 --}}
  

  {{-- Hero --}}
  <div class="bg-primary py-4">
    <div class="container-fluid px-4">
      <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item">
            <a href="{{ route('jobs.index') }}" class="text-white-50">Jobs</a>
          </li>
          <li class="breadcrumb-item text-white active">Companies</li>
        </ol>
      </nav>
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
        <div>
          <h1 class="text-white fw-bold mb-1" style="font-size:clamp(1.3rem,3vw,1.9rem)">
            Companies <span style="color:#fdd835">Hiring</span> in Africa
          </h1>
          <p class="text-white-50 mb-0 small">
            {{ number_format($pagination['total']) }} organisations actively recruiting
          </p>
        </div>
        {{-- Search --}}
        <form method="GET" action="{{ route('companies') }}"
              class="d-flex gap-2" style="min-width:280px;max-width:400px">
          <div class="input-group">
            <span class="input-group-text bg-white border-0">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="search"
                   class="form-control border-0 shadow-none"
                   placeholder="Search companies..."
                   value="{{ $search ?? '' }}">
            @if(!empty($search))
            <a href="{{ route('companies') }}" class="btn btn-light border-0" title="Clear">
              <i class="bi bi-x"></i>
            </a>
            @endif
            <button type="submit" class="btn btn-light border-0 fw-semibold">
              Search
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container-fluid px-4 py-4">

    {{-- AD SLOT 2 --}}
    

    @if(!empty($search))
    <p class="text-muted small mb-3">
      Showing results for <strong>"{{ $search }}"</strong> —
      <a href="{{ route('companies') }}" class="text-primary">clear search</a>
    </p>
    @endif

    @if(count($companies) > 0)
    <div class="row g-3">
      @foreach($companies as $index => $company)

        {{-- AD every 12 companies --}}
        @if($index > 0 && $index % 12 === 0)
        
        @endif

        {{-- 3 per row on desktop, 2 on tablet, 1 on mobile --}}
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
          <div class="card border rounded-3 shadow-sm h-100 company-card">
            <div class="card-body p-3 p-md-4 d-flex flex-column gap-3">

              {{-- Logo + name (LEFT ALIGNED) --}}
              <div class="d-flex align-items-start gap-3">
                  @php $logoUrl = companyLogo($company); @endphp
                  
                  <div class="rounded-2 border flex-shrink-0 overflow-hidden d-flex align-items-center justify-content-center"
                      style="width:52px;height:52px;background:#fff">
                      @if($logoUrl)
                          <img src="{{ $logoUrl }}"
                              alt="{{ $company['name'] ?? 'Company' }}"
                              width="52" height="52"
                              loading="lazy"
                              style="width:100%;height:100%;object-fit:contain;padding:4px"
                              onerror="this.src='{{ asset('default-logo.png') }}';">
                      @else
                          <img src="{{ asset('default-logo.png') }}"
                              alt="Default logo"
                              width="52" height="52"
                              style="width:100%;height:100%;object-fit:contain;padding:4px">
                      @endif
                  </div>

                  <div class="min-w-0 flex-grow-1 text-start">
                      <div class="fw-semibold text-body text-start" style="font-size:clamp(0.75rem, 3vw, 0.875rem); line-height:1.35;">
                          {{ $company['name'] ?? 'Unknown' }}
                      </div>
                      @if(!empty($company['industry']['name']))
                      <div class="text-muted text-start" style="font-size:clamp(10px, 2.5vw, 12px);">
                          {{ $company['industry']['name'] }}
                      </div>
                      @endif
                      
                      {{-- Location with district and country --}}
                      @php
                          $locationParts = [];
                          if (!empty($company['location']['district'])) {
                              $locationParts[] = $company['location']['district'];
                          }
                          if (!empty($company['location']['country'])) {
                              $locationParts[] = $company['location']['country'];
                          }
                          $locationText = implode(', ', $locationParts);
                      @endphp
                      @if(!empty($locationText))
                      <div class="text-muted text-start mt-1" style="font-size:clamp(10px, 2.5vw, 11px);">
                          <i class="bi bi-geo-alt me-1"></i>
                          {{ $locationText }}
                      </div>
                      @endif
                      
                      @if($company['is_verified'] ?? false)
                      <span class="badge text-bg-success fw-normal mt-1" style="font-size:9px">
                          <i class="bi bi-patch-check me-1"></i>Verified
                      </span>
                      @endif
                  </div>
              </div>

              {{-- Description with clickable modal --}}
              @if(!empty($company['description']))
              <div class="description-wrapper">
                  <p class="text-body-secondary mb-0 description-preview"
                    style="font-size:clamp(11px, 2.5vw, 12px);line-height:1.55;
                            display:-webkit-box;-webkit-line-clamp:2;
                            -webkit-box-orient:vertical;overflow:hidden; cursor:pointer;"
                    onclick="openCompanyDescriptionModal('{{ addslashes($company['name'] ?? 'Company') }}', '{{ addslashes(strip_tags($company['description'])) }}')">
                      {{ Str::limit(strip_tags($company['description']), 100) }}
                  </p>
                  <button class="btn btn-link btn-sm text-primary p-0 mt-1" style="font-size:10px"
                          onclick="openCompanyDescriptionModal('{{ addslashes($company['name'] ?? 'Company') }}', '{{ addslashes(strip_tags($company['description'])) }}')">
                      Read more <i class="bi bi-arrow-right-short"></i>
                  </button>
              </div>
              @endif

              {{-- Meta badges (LEFT ALIGNED) --}}
              <div class="d-flex flex-wrap gap-2 mt-auto">
                @if(!empty($company['company_size']))
                <span class="badge rounded-pill text-bg-light border fw-normal text-body-secondary"
                      style="font-size:clamp(9px, 2vw, 11px); padding:4px 8px;">
                  <i class="bi bi-people me-1"></i>{{ $company['company_size'] }}
                </span>
                @endif
                @if(($company['jobs_count'] ?? 0) > 0)
                <span class="badge rounded-pill fw-normal text-primary"
                      style="font-size:clamp(9px, 2vw, 11px); padding:4px 8px; background:rgba(var(--bs-primary-rgb),.1)">
                  <i class="bi bi-briefcase me-1"></i>
                  {{ number_format($company['jobs_count']) }} open {{ Str::plural('job', $company['jobs_count']) }}
                </span>
                @endif
              </div>

              {{-- Actions (LEFT ALIGNED) --}}
              <div class="d-flex gap-2 pt-2 border-top">
                <a href="{{ route('jobs.index', ['company' => $company['slug'] ?? $company['id']]) }}"
                  class="btn btn-primary btn-sm fw-semibold flex-grow-1" style="font-size:clamp(11px, 2.5vw, 13px); padding:6px 10px;">
                    <i class="bi bi-briefcase me-1"></i>
                    View Jobs
                </a>
                @if(!empty($company['website']))
                <a href="{{ $company['website'] }}" target="_blank" rel="noopener noreferrer"
                  class="btn btn-outline-secondary btn-sm px-2" style="padding:6px 10px;"
                  title="Visit website">
                    <i class="bi bi-globe"></i>
                </a>
                @endif
              </div>

            </div>
          </div>
        </div>

        {{-- Company Description Modal --}}
        <div id="companyDescriptionModal" class="modal fade" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="companyModalTitle">Company Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="companyModalBody" style="max-height: 60vh; overflow-y: auto;">
                Loading...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <script>
          function openCompanyDescriptionModal(companyName, description) {
              // Escape description to prevent XSS
              const escapedDescription = description
                  .replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;')
                  .replace(/"/g, '&quot;')
                  .replace(/'/g, '&#39;')
                  .replace(/\n/g, '<br>');
              
              document.getElementById('companyModalTitle').innerHTML = companyName;
              document.getElementById('companyModalBody').innerHTML = '<p class="mb-0" style="line-height:1.6; white-space:normal;">' + escapedDescription + '</p>';
              
              var modal = new bootstrap.Modal(document.getElementById('companyDescriptionModal'));
              modal.show();
          }
        </script>

      @endforeach
    </div>

    {{-- Pagination --}}
    @if($pagination['last_page'] > 1)
    @php
      $cur  = $pagination['current_page'];
      $last = $pagination['last_page'];
      $q    = array_filter(request()->only(['search']));
    @endphp
    <nav class="d-flex justify-content-center mt-4" aria-label="Companies pagination">
      <ul class="pagination gap-1 flex-wrap justify-content-center mb-0">

        <li class="page-item {{ $cur <= 1 ? 'disabled' : '' }}">
          <a class="page-link rounded-2" style="padding:6px 12px"
             href="{{ $cur > 1 ? route('companies', array_merge($q, ['page' => $cur - 1])) : '#' }}"
             aria-label="Previous">
            <i class="bi bi-chevron-left" style="font-size:11px"></i>
          </a>
        </li>

        @if(max(1, $cur - 2) > 1)
          <li class="page-item">
            <a class="page-link rounded-2" style="padding:6px 12px"
               href="{{ route('companies', array_merge($q, ['page' => 1])) }}">1</a>
          </li>
          @if(max(1, $cur - 2) > 2)
            <li class="page-item disabled">
              <span class="page-link border-0 bg-transparent">…</span>
            </li>
          @endif
        @endif

        @for($i = max(1, $cur - 2); $i <= min($last, $cur + 2); $i++)
          <li class="page-item {{ $i == $cur ? 'active' : '' }}">
            @if($i == $cur)
              <span class="page-link rounded-2" style="padding:6px 12px">{{ $i }}</span>
            @else
              <a class="page-link rounded-2" style="padding:6px 12px"
                 href="{{ route('companies', array_merge($q, ['page' => $i])) }}">{{ $i }}</a>
            @endif
          </li>
        @endfor

        @if(min($last, $cur + 2) < $last)
          @if(min($last, $cur + 2) < $last - 1)
            <li class="page-item disabled">
              <span class="page-link border-0 bg-transparent">…</span>
            </li>
          @endif
          <li class="page-item">
            <a class="page-link rounded-2" style="padding:6px 12px"
               href="{{ route('companies', array_merge($q, ['page' => $last])) }}">{{ $last }}</a>
          </li>
        @endif

        <li class="page-item {{ $cur >= $last ? 'disabled' : '' }}">
          <a class="page-link rounded-2" style="padding:6px 12px"
             href="{{ $cur < $last ? route('companies', array_merge($q, ['page' => $cur + 1])) : '#' }}"
             aria-label="Next">
            <i class="bi bi-chevron-right" style="font-size:11px"></i>
          </a>
        </li>

      </ul>
    </nav>
    @endif

    @else
    <div class="text-center py-5">
      <i class="bi bi-building fs-1 text-muted opacity-50 d-block mb-3"></i>
      @if(!empty($search))
        <p class="text-muted">No companies found for "{{ $search }}".</p>
        <a href="{{ route('companies') }}" class="btn btn-outline-primary btn-sm">
          View all companies
        </a>
      @else
        <p class="text-muted">No companies found.</p>
      @endif
    </div>
    @endif

    {{-- AD SLOT 4 --}}
    

  </div>
</div>
@endsection

@push('styles')
<style>
.company-card {
  transition: border-color .15s, box-shadow .15s, transform .15s;
}
.company-card:hover {
  border-color: var(--bs-primary) !important;
  box-shadow: 0 4px 16px rgba(var(--bs-primary-rgb),.12) !important;
  transform: translateY(-2px);
}
</style>
@endpush