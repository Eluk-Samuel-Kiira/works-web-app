@extends('layouts.jobs')
@section('title', 'Privacy Policy | Stardena Works')
@section('meta_description', 'Read the Stardena Works privacy policy to understand how we collect, use and protect your personal information.')
@section('canonical', url('/privacy-policy'))
@section('robots', 'index, follow')

@section('job-content')
<div class="main-wrapper">

  <div class="py-2 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Home</a></li>
          <li class="breadcrumb-item active">Privacy Policy</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container-xl px-3 px-md-4 py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8">

        <h1 class="h3 fw-semibold mb-1">Privacy Policy</h1>
        <p class="text-muted small mb-5">Last updated: {{ date('F j, Y') }}</p>

        <p class="text-body-secondary">Stardena Works ("we", "our", or "us") operates <strong>works.stardena.org</strong> — a job listing platform connecting job seekers with employers across Uganda and Africa. This policy explains how we collect, use, and protect your information.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">1. Information We Collect</h2>
        <p class="text-body-secondary">We may collect the following information:</p>
        <ul class="text-body-secondary">
          <li class="mb-2">Name, email address, and phone number when you apply for a job or contact us</li>
          <li class="mb-2">Resume and cover letter documents submitted through our platform</li>
          <li class="mb-2">Search queries, job categories browsed, and pages visited</li>
          <li class="mb-2">Device type, browser, IP address, and operating system (collected automatically)</li>
          <li class="mb-2">Cookies and similar tracking technologies</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">2. How We Use Your Information</h2>
        <ul class="text-body-secondary">
          <li class="mb-2">To connect job seekers with relevant job opportunities</li>
          <li class="mb-2">To forward job applications to the relevant employer</li>
          <li class="mb-2">To improve and personalise your experience on our platform</li>
          <li class="mb-2">To send job alerts and platform updates (only if you opt in)</li>
          <li class="mb-2">To analyse platform usage and improve our services</li>
          <li class="mb-2">To comply with legal obligations</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">3. Sharing Your Information</h2>
        <p class="text-body-secondary">We do not sell your personal information. We may share your information with:</p>
        <ul class="text-body-secondary">
          <li class="mb-2"><strong>Employers</strong> — when you apply for a job, your application details are shared with the hiring organisation</li>
          <li class="mb-2"><strong>Service providers</strong> — trusted third parties who help operate our platform (hosting, analytics)</li>
          <li class="mb-2"><strong>Legal authorities</strong> — when required by law</li>
        </ul>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">4. Cookies</h2>
        <p class="text-body-secondary">We use cookies to maintain your session, remember your preferences, and improve platform performance. By continuing to use Stardena Works, you consent to our use of cookies.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">5. Google AdSense & Advertising</h2>
        <p class="text-body-secondary">We display advertisements through Google AdSense. Google and its partners may use cookies to serve ads based on your prior visits to our site or other websites. These cookies allow Google to serve relevant ads to you.</p>
        <p class="text-body-secondary">You can opt out of personalised advertising by visiting <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener">google.com/settings/ads</a> or <a href="https://www.aboutads.info" target="_blank" rel="noopener">aboutads.info</a>.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">6. Data Retention</h2>
        <p class="text-body-secondary">We retain your personal information only as long as necessary to provide our services. Job applications are retained for a maximum of 6 months after submission unless you request earlier deletion.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">7. Your Rights</h2>
        <p class="text-body-secondary">You have the right to:</p>
        <ul class="text-body-secondary">
          <li class="mb-2">Access the personal information we hold about you</li>
          <li class="mb-2">Request correction of inaccurate information</li>
          <li class="mb-2">Request deletion of your personal data</li>
          <li class="mb-2">Withdraw consent at any time</li>
        </ul>
        <p class="text-body-secondary">To exercise any of these rights, contact us at <a href="mailto:privacy@stardena.org">privacy@stardena.org</a>.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">8. Security</h2>
        <p class="text-body-secondary">We implement appropriate technical and organisational measures to protect your information against unauthorised access, alteration, disclosure, or destruction. However, no internet transmission is 100% secure.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">9. Children's Privacy</h2>
        <p class="text-body-secondary">Stardena Works is not intended for users under the age of 18. We do not knowingly collect personal information from children.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">10. Changes to This Policy</h2>
        <p class="text-body-secondary">We may update this policy from time to time. We will notify you of significant changes by updating the date at the top of this page. Continued use of Stardena Works after changes constitutes acceptance of the updated policy.</p>

        <h2 class="h5 fw-semibold mt-5 mb-3 pb-2 border-bottom">11. Contact Us</h2>
        <p class="text-body-secondary">For any privacy-related questions or requests:</p>
        <div class="bg-body-secondary rounded-3 p-4 mt-3">
          <p class="mb-1"><strong>Stardena Works</strong></p>
          <p class="mb-1 text-body-secondary">Email: <a href="mailto:privacy@stardena.org">privacy@stardena.org</a></p>
          <p class="mb-0 text-body-secondary">Website: <a href="https://stardena.org" target="_blank">stardena.org</a></p>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection