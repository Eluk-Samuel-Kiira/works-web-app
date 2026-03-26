@extends('layouts.jobs')

@section('title', __('Job Details - Stardena Works'))
@section('new-badge', __("We're hiring! 50+ tech positions available"))

@section('job-content')

  <div class="main-wrapper overflow-hidden">
    <!-- ------------------------------------- -->
    <!-- Breadcrumb Banner Start -->
    <!-- ------------------------------------- -->
    <section class="py-4 py-lg-6 bg-primary-subtle">
      <div class="container-fluid">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
          <div class="d-flex flex-nowrap align-items-center gap-2 overflow-auto pb-1 w-100" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="{{ route('jobs.index') }}" class="text-muted fw-medium link-primary text-nowrap fs-3">Jobs</a>
            <i class="bi bi-chevron-right fs-3 text-muted flex-shrink-0"></i>
            
            {{-- Job Category --}}
            @if(isset($job['job_category']) && $job['job_category'])
            <a href="{{ route('jobs.index', ['category' => $job['job_category']['slug'] ?? $job['job_category']['id']]) }}" class="text-muted fw-medium link-primary text-nowrap fs-3">
              {{ $job['job_category']['name'] }}
            </a>
            <i class="bi bi-chevron-right fs-3 text-muted flex-shrink-0"></i>
            @endif
            
            {{-- Job Location --}}
            @if(isset($job['job_location']) && ($job['job_location']['district'] ?? $job['job_location']['country']))
            <a href="{{ route('jobs.index', ['location' => $job['job_location']['district'] ?? $job['job_location']['country']]) }}" class="text-muted fw-medium link-primary text-nowrap fs-3">
              {{ $job['job_location']['district'] ?? $job['job_location']['country'] }}
            </a>
            <i class="bi bi-chevron-right fs-3 text-muted flex-shrink-0"></i>
            @endif
            
            {{-- Job Title (Current Page) --}}
            <span class="text-primary fw-medium text-nowrap fs-3">{{ Str::limit($job['job_title'] ?? 'Job Details', 40) }}</span>
          </div>
          
          {{-- Action Buttons --}}
          <div class="d-flex flex-nowrap gap-2 flex-shrink-0 w-100 w-lg-auto justify-content-start justify-content-lg-end">
            <button class="btn btn-outline-primary btn-sm py-1 px-3 text-nowrap" onclick="saveJob({{ $job['id'] }})">
              <i class="bi bi-bookmark me-1"></i>Save
            </button>
            <button class="btn btn-outline-primary btn-sm py-1 px-3 text-nowrap" onclick="shareJob({{ $job['id'] }})">
              <i class="bi bi-share me-1"></i>Share
            </button>
          </div>
        </div>
      </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- Breadcrumb Banner End -->
    <!-- ------------------------------------- -->
    @push('scripts')
      <script>
      function saveJob(jobId) {
          // Implement save functionality
          alert('Job saved to your bookmarks!');
      }

      function shareJob(jobId) {
          // Implement share functionality
          if (navigator.share) {
              navigator.share({
                  title: '{{ $job['job_title'] }}',
                  text: 'Check out this job at {{ $job['company']['name'] ?? 'company' }}',
                  url: window.location.href,
              });
          } else {
              // Fallback
              prompt('Copy this link to share:', window.location.href);
          }
      }
      </script>
    @endpush
    
    <!-- ------------------------------------- -->
    <!-- Job Details Start -->
    <!-- ------------------------------------- -->
    <section class="py-5 py-lg-8">
      <div class="container-fluid">
        <div class="row g-4">
          <!-- Main Content - Left Side -->
          <div class="col-lg-8">
            <!-- Job Header Card - Compact -->
            <div class="card job-card border-0 shadow-sm card-compact mb-4">
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3">
                  <div class="company-icon-large">
                    @if(isset($job['company']['logo']) && $job['company']['logo'])
                      <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] }}" class="rounded-circle" width="64" height="64">
                    @else
                      <i class="bi bi-building fs-2 text-primary"></i>
                    @endif
                  </div>
                  <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                      <h1 class="fs-5 fw-semibold mb-0">{{ $job['job_title'] }} at {{ $job['company']['name'] ?? 'Company' }}</h1>
                      @if($job['is_featured'] ?? false)
                      <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 fs-2">Featured</span>
                      @endif
                      @if($job['is_urgent'] ?? false)
                      <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 fs-2">Urgent</span>
                      @endif
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                      <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-building text-muted fs-6"></i>
                        <span class="fs-3 text-muted">{{ $job['company']['name'] ?? 'Unknown Company' }}</span>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-geo-alt text-muted fs-6"></i>
                        <span class="fs-3 text-muted">{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</span>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-clock text-muted fs-6"></i>
                        <span class="fs-3 text-muted">{{ \Carbon\Carbon::parse($job['created_at'])->diffForHumans() }}</span>
                      </div>
                      @if(isset($job['view_count']))
                      <div class="d-flex align-items-center gap-1">
                        <i class="bi bi-eye text-muted fs-6"></i>
                        <span class="fs-3 text-muted">{{ number_format($job['view_count']) }} views</span>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="text-start text-md-end">
                  <h4 class="text-primary fw-bold mb-0 fs-5">{{ $job['formatted_salary'] ?? 'Negotiable' }}</h4>
                  @if(isset($job['salary_range']['name']))
                  <span class="text-muted fs-2">{{ $job['salary_range']['name'] }}</span>
                  @endif
                </div>
              </div>

              <!-- Quick Action Buttons - Compact -->
              <div class="d-flex gap-3 mt-4 pt-3 border-top">
                <button class="btn btn-primary py-2 px-4 flex-grow-1" style="font-size:13px;" onclick="openApplyModal()">
                  <i class="bi bi-send me-2" style="font-size:12px;"></i>Apply Now
                </button>
                <a href="#" class="btn btn-outline-primary py-2 px-4">
                  <i class="bi bi-envelope me-2"></i>Contact
                </a>
              </div>
            </div>

            <!-- Job Description - Compact -->
            <div class="card job-card border-0 shadow-sm card-compact mb-4">
              <h3 class="fs-5 fw-semibold mb-3">Job Description</h3>
              <div class="text-muted small mb-3">
                {!! nl2br($job['job_description'] ?? 'No description provided') !!}
              </div>

              @if(!empty($job['responsibilities']))
              <h4 class="fs-6 fw-semibold mb-2 mt-4">Key Responsibilities</h4>
              <div class="text-muted small mb-4">
                {!! nl2br($job['responsibilities']) !!}
              </div>
              @endif

              @if(!empty($job['qualifications']))
              <h4 class="fs-6 fw-semibold mb-2">Qualifications</h4>
              <div class="text-muted small mb-4">
                {!! nl2br($job['qualifications']) !!}
              </div>
              @endif
            </div>

            <!-- Skills & Technologies - Compact -->
            @if(!empty($job['skills']))
            <div class="card job-card border-0 shadow-sm card-compact mb-4">
              <h3 class="fs-5 fw-semibold mb-3">Required Skills</h3>
              <div class="d-flex flex-wrap gap-1">
                @foreach(explode(',', $job['skills']) as $skill)
                  @if(trim($skill))
                  <span class="job-type-badge">{{ trim($skill) }}</span>
                  @endif
                @endforeach
              </div>
            </div>
            @endif

            <!-- Application Details -->
            @if(!empty($job['application_procedure']) || !empty($job['email']) || !empty($job['telephone']) || !empty($job['deadline']))
            <div class="card job-card border-0 shadow-sm card-compact">
              <h3 class="fs-5 fw-semibold mb-3">Application Details</h3>
              <div class="row g-3">
                @if(!empty($job['application_procedure']))
                <div class="col-12">
                  <div class="bg-light p-3 rounded-3">
                    <h6 class="fw-semibold mb-2">How to Apply</h6>
                    <p class="text-muted small mb-0">{{ $job['application_procedure'] }}</p>
                  </div>
                </div>
                @endif
                
                @if(!empty($job['email']) || !empty($job['telephone']))
                <div class="col-md-6">
                  <div class="bg-light p-3 rounded-3">
                    <h6 class="fw-semibold mb-2">Contact Information</h6>
                    @if(!empty($job['email']))
                    <div class="d-flex align-items-center gap-2 mb-2">
                      <i class="bi bi-envelope text-primary small"></i>
                      <a href="mailto:{{ $job['email'] }}" class="text-muted small">{{ $job['email'] }}</a>
                    </div>
                    @endif
                    @if(!empty($job['telephone']))
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-telephone text-primary small"></i>
                      <a href="tel:{{ $job['telephone'] }}" class="text-muted small">{{ $job['telephone'] }}</a>
                    </div>
                    @endif
                  </div>
                </div>
                @endif
                
                @if(!empty($job['deadline']))
                <div class="col-md-6">
                  <div class="bg-light p-3 rounded-3">
                    <h6 class="fw-semibold mb-2">Application Deadline</h6>
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-calendar text-primary small"></i>
                      <span class="text-muted small">{{ \Carbon\Carbon::parse($job['deadline'])->format('F j, Y') }}</span>
                      @php
                        $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($job['deadline']), false);
                      @endphp
                      @if($daysLeft > 0)
                      <span class="badge bg-warning bg-opacity-10 text-warning ms-2">{{ round($daysLeft) }} days left</span>
                      @elseif($daysLeft == 0)
                      <span class="badge bg-danger bg-opacity-10 text-danger ms-2">Last day</span>
                      @else
                      <span class="badge bg-secondary bg-opacity-10 text-secondary ms-2">Expired</span>
                      @endif
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>
            @endif
          </div>

          <!-- Sidebar - Right Side -->
          <div class="col-lg-4">
            <!-- Company Info - Compact -->
            @if(isset($job['company']))
            <div class="card job-card border-0 shadow-sm card-compact-sm mb-4">
              <h3 class="fs-5 fw-semibold mb-3">About Company</h3>
              <div class="text-center mb-3">
                <div class="company-icon-large mx-auto mb-2">
                  @if(isset($job['company']['logo']))
                    <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] }}" class="rounded-circle" width="64" height="64">
                  @else
                    <i class="bi bi-building fs-2 text-primary"></i>
                  @endif
                </div>
                <h5 class="fw-semibold mb-1">{{ $job['company']['name'] ?? 'Company Name' }}</h5>
                @if(isset($job['company']['industry']))
                <p class="text-muted small mb-2">{{ $job['company']['industry']['name'] ?? '' }}</p>
                @endif
                <div class="d-flex justify-content-center gap-1">
                  @if($job['is_verified'] ?? false)
                  <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 fs-2">Verified</span>
                  @endif
                </div>
              </div>
              @if(!empty($job['company']['description']))
              <p class="text-muted small mb-3">{{ Str::limit($job['company']['description'], 100) }}</p>
              @endif
              @if(isset($job['company']['website']))
              <a href="{{ $job['company']['website'] }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 py-2">Visit Website</a>
              @endif
            </div>
            @endif

            <!-- Job Overview - Compact -->
            <div class="card job-card border-0 shadow-sm card-compact-sm mb-4">
              <h3 class="fs-5 fw-semibold mb-3">Quick Overview</h3>
              <div class="d-flex flex-column gap-2">
                @if(isset($job['job_category']['name']))
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Category:</span>
                  <span class="fw-semibold small">{{ $job['job_category']['name'] }}</span>
                </div>
                @endif
                
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Type:</span>
                  <span class="fw-semibold small">{{ $job['job_type']['name'] ?? $job['employment_type'] ?? 'Full Time' }}</span>
                </div>
                
                @if(isset($job['experience_level']['name']))
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Level:</span>
                  <span class="fw-semibold small">{{ $job['experience_level']['name'] }}</span>
                </div>
                @endif
                
                @if(isset($job['education_level']['name']))
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Education:</span>
                  <span class="fw-semibold small">{{ $job['education_level']['name'] }}</span>
                </div>
                @endif
                
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Location:</span>
                  <span class="fw-semibold small">{{ $job['duty_station'] ?? $job['job_location']['district'] ?? $job['job_location']['country'] ?? 'Remote' }}</span>
                </div>
                
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Work Type:</span>
                  <span class="fw-semibold small">{{ $job['location_type'] ?? 'On-site' }}</span>
                </div>
                
                <div class="d-flex justify-content-between">
                  <span class="text-muted small">Posted:</span>
                  <span class="fw-semibold small">{{ \Carbon\Carbon::parse($job['created_at'])->format('M d, Y') }}</span>
                </div>
              </div>
            </div>

            <!-- Quick Stats - Compact -->
            <div class="row g-3 mb-4">
              <div class="col-3">
                <div class="info-item-compact">
                  <i class="bi bi-people text-primary"></i>
                  <h5 class="fw-semibold">{{ number_format($job['application_count'] ?? 0) }}</h5>
                  <p class="text-muted mb-0">Applied</p>
                </div>
              </div>
              <div class="col-3">
                <div class="info-item-compact">
                  <i class="bi bi-eye text-primary"></i>
                  <h5 class="fw-semibold">{{ number_format($job['view_count'] ?? 0) }}</h5>
                  <p class="text-muted mb-0">Views</p>
                </div>
              </div>
              <div class="col-3">
                <div class="info-item-compact">
                  <i class="bi bi-bookmark text-primary"></i>
                  <h5 class="fw-semibold">{{ number_format($job['application_count'] ?? 0) }}</h5>
                  <p class="text-muted mb-0">Saved</p>
                </div>
              </div>
              <div class="col-3">
                <div class="info-item-compact">
                  <i class="bi bi-share text-primary"></i>
                  <h5 class="fw-semibold">{{ number_format($job['social_shares'] ?? 0) }}</h5>
                  <p class="text-muted mb-0">Shared</p>
                </div>
              </div>
            </div>

            <!-- Similar Jobs - Compact -->
            @if(isset($similarJobs) && count($similarJobs) > 0)
            <div class="card job-card border-0 shadow-sm card-compact-sm">
              <h3 class="fs-5 fw-semibold mb-3">Similar Jobs</h3>
              <div class="d-flex flex-column gap-2">
                @foreach($similarJobs as $similarJob)
                <a href="{{ route('jobs.show', $similarJob['slug'] ?? $similarJob['id']) }}" class="similar-job-card-compact card">
                  <div class="d-flex gap-2">
                    <div class="company-icon">
                      @if(isset($similarJob['company']['logo']))
                        <img src="{{ $similarJob['company']['logo'] }}" alt="{{ $similarJob['company']['name'] }}" class="rounded-circle" width="40" height="40">
                      @else
                        <i class="bi bi-building fs-5 text-primary"></i>
                      @endif
                    </div>
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start">
                        <h6 class="fw-semibold">{{ Str::limit($similarJob['job_title'], 25) }}</h6>
                        <span class="text-primary small fw-semibold">{{ $similarJob['formatted_salary'] ?? 'N/A' }}</span>
                      </div>
                      <p class="text-muted small mb-1">{{ $similarJob['company']['name'] ?? 'Unknown' }}</p>
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-dark">{{ $similarJob['job_type']['name'] ?? 'Full Time' }}</span>
                        <span class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $similarJob['duty_station'] ?? 'Remote' }}</span>
                      </div>
                    </div>
                  </div>
                </a>
                @endforeach
              </div>
              <a href="{{ route('jobs.index', ['category' => $job['job_category']['slug'] ?? null]) }}" class="btn btn-link text-primary p-0 mt-3 small">View all similar <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- Job Details End -->
    <!-- ------------------------------------- -->

    <!-- ------------------------------------- -->
    <!-- CTA Start - Compact -->
    <!-- ------------------------------------- -->
    <section class="bg-primary py-6 position-relative">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h3 class="fs-5 my-3 fw-semibold text-white">Ready to join {{ $job['company']['name'] ?? 'the team' }}?</h3>
            <p class="text-white small mb-4 opacity-75">Don't miss this opportunity to work as a {{ $job['job_title'] }}</p>
            <div class="d-flex gap-3 justify-content-center">
              <button class="btn btn-primary py-2 px-4 flex-grow-1" style="font-size:13px;" onclick="openApplyModal()">
                <i class="bi bi-send me-2" style="font-size:12px;"></i>Apply Now
              </button>
              <a href="#" class="btn btn-outline-light btn-xs px-3 py-1" style="font-size: 13px;">
                <i class="bi bi-bookmark me-1" style="font-size: 12px;"></i>Save Job
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ------------------------------------- -->
    <!-- CTA End -->
    <!-- ------------------------------------- -->
  </div>

  <!-- Apply Modal - Using Bootstrap structure (working version) -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-send me-2"></i>
                    <span id="applyModalTitle">Apply for Job</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="applyModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Loading application options...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
function openApplyModal() {
  const myModal = new bootstrap.Modal(document.getElementById('applyModal'));
  myModal.show();
}

</script>
  
@include('jobs.partials.apply-modal', ['job' => $job])
@endsection


@push('styles')
<style>
  .company-icon-large {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 16px;
    overflow: hidden;
  }
  .company-icon-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .company-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 12px;
    overflow: hidden;
  }
  .company-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .job-type-badge {
    background: rgba(var(--bs-primary-rgb), 0.05);
    color: var(--bs-primary);
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 12px;
    display: inline-block;
  }
  .info-item-compact {
    padding: 12px 8px;
    background: #f8f9fa;
    border-radius: 10px;
    text-align: center;
  }
  .info-item-compact i {
    font-size: 1.2rem;
  }
  .info-item-compact h5 {
    font-size: 0.95rem;
    margin: 4px 0 0 0;
  }
  .info-item-compact p {
    font-size: 0.65rem;
    margin: 0;
  }
  .benefit-item-compact {
    padding: 12px;
    background: #f8f9fa;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .similar-job-card-compact {
    transition: all 0.2s ease;
    border: 1px solid #eef0f2;
    text-decoration: none;
    display: block;
    padding: 12px !important;
  }
  .similar-job-card-compact:hover {
    border-color: var(--bs-primary);
    transform: translateY(-2px);
  }
  .card-compact {
    padding: 1.25rem !important;
  }
  .card-compact-sm {
    padding: 1rem !important;
  }
</style>
@endpush
