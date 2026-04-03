@extends('layouts.jobs')

@section('title', 'Terms of Service | Stardena Works')
@section('meta_description', 'Read the Stardena Works terms of service. Learn about our policies, user obligations, and platform guidelines.')
@section('canonical', url('/terms-of-service'))
@section('robots', 'index, follow')

@section('job-content')
<div class="main-wrapper">

  <div class="py-2 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Home</a></li>
          <li class="breadcrumb-item active">Terms of Service</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container-xl px-3 px-md-4 py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8">

        <h1 class="h3 fw-semibold mb-1">Terms of Service</h1>
        <p class="text-muted small mb-5">Last updated: {{ date('F j, Y') }}</p>

        <div class="alert alert-info small">
          <i class="bi bi-info-circle me-1"></i> By accessing or using Stardena Works, you agree to be bound by these Terms of Service.
        </div>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">1. Introduction</h2>
        <p class="text-body-secondary">Welcome to Stardena Works ("we", "our", or "us"). Stardena Works is a job listing platform connecting job seekers with employers across Uganda and Africa. These Terms govern your use of our website at <strong>works.stardena.org</strong>.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">2. Eligibility</h2>
        <p class="text-body-secondary">You must be at least 18 years old to use our platform. By using Stardena Works, you represent that you meet this age requirement.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">3. User Accounts</h2>
        <ul class="text-body-secondary">
          <li class="mb-2">You are responsible for maintaining the confidentiality of your account</li>
          <li class="mb-2">You are responsible for all activities that occur under your account</li>
          <li class="mb-2">You agree to provide accurate and complete information</li>
          <li class="mb-2">We reserve the right to suspend or terminate accounts that violate these Terms</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">4. Job Seekers</h2>
        <p class="text-body-secondary">As a job seeker, you agree to:</p>
        <ul class="text-body-secondary">
          <li class="mb-2">Provide truthful and accurate information in your applications</li>
          <li class="mb-2">Not submit fraudulent or misleading applications</li>
          <li class="mb-2">Not use our platform to spam or harass employers</li>
          <li class="mb-2">Not misrepresent your qualifications or experience</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">5. Employers</h2>
        <p class="text-body-secondary">As an employer posting jobs on Stardena Works, you agree to:</p>
        <ul class="text-body-secondary">
          <li class="mb-2">Post accurate, truthful, and lawful job listings</li>
          <li class="mb-2">Not post fraudulent, misleading, or prohibited jobs</li>
          <li class="mb-2">Respond to applications in a timely and professional manner</li>
          <li class="mb-2">Comply with all applicable labour laws and regulations</li>
          <li class="mb-2">Not use our platform to collect personal data for unauthorised purposes</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">6. Prohibited Activities</h2>
        <p class="text-body-secondary">You may not:</p>
        <ul class="text-body-secondary">
          <li class="mb-2">Post illegal, fraudulent, or discriminatory job listings</li>
          <li class="mb-2">Upload viruses, malware, or harmful code</li>
          <li class="mb-2">Attempt to gain unauthorised access to our systems</li>
          <li class="mb-2">Scrape, copy, or reproduce our content without permission</li>
          <li class="mb-2">Use our platform for any unlawful purpose</li>
          <li class="mb-2">Harass, abuse, or harm other users</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">7. Job Applications</h2>
        <p class="text-body-secondary">When you apply for a job through Stardena Works:</p>
        <ul class="text-body-secondary">
          <li class="mb-2">Your application is forwarded directly to the employer</li>
          <li class="mb-2">We do not guarantee that employers will respond or consider your application</li>
          <li class="mb-2">We are not responsible for hiring decisions made by employers</li>
          <li class="mb-2">Employers may retain your application data according to their own privacy policies</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">8. Content Ownership</h2>
        <ul class="text-body-secondary">
          <li class="mb-2">You retain ownership of the content you submit (e.g., resume, cover letter)</li>
          <li class="mb-2">By submitting content, you grant us permission to store and transmit it to employers</li>
          <li class="mb-2">We own the platform design, code, and original content</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">9. Disclaimer of Warranties</h2>
        <p class="text-body-secondary">Stardena Works is provided "as is" without warranties of any kind. We do not guarantee:</p>
        <ul class="text-body-secondary">
          <li class="mb-2">That you will find a job through our platform</li>
          <li class="mb-2">That employers will respond to your applications</li>
          <li class="mb-2">That our service will be uninterrupted or error-free</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">10. Limitation of Liability</h2>
        <p class="text-body-secondary">To the maximum extent permitted by law, Stardena Works shall not be liable for any indirect, incidental, or consequential damages arising from your use of our platform, including but not limited to loss of employment opportunities, data, or profits.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">11. Termination</h2>
        <p class="text-body-secondary">We may suspend or terminate your access to Stardena Works at any time, with or without cause, and without prior notice, for violations of these Terms or for any other reason.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">12. Governing Law</h2>
        <p class="text-body-secondary">These Terms shall be governed by and construed in accordance with the laws of the Republic of Uganda.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">13. Changes to Terms</h2>
        <p class="text-body-secondary">We may modify these Terms at any time. Your continued use of Stardena Works after changes are posted constitutes your acceptance of the revised Terms.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">14. Contact Us</h2>
        <p class="text-body-secondary">If you have any questions about these Terms, please contact us:</p>
        <div class="bg-body-secondary rounded-3 p-4 mt-3">
          <p class="mb-1"><strong>Stardena Works</strong></p>
          <p class="mb-1 text-body-secondary">Email: <a href="mailto:legal@stardena.org">legal@stardena.org</a></p>
          <p class="mb-0 text-body-secondary">Website: <a href="https://stardena.org" target="_blank">stardena.org</a></p>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection