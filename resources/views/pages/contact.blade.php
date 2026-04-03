@extends('layouts.jobs')
@section('title', 'Contact Us | Stardena Works')
@section('meta_description', 'Get in touch with the Stardena Works team. We are here to help job seekers and employers across Uganda.')
@section('canonical', url('/contact'))
@section('robots', 'index, follow')

@section('job-content')
<div class="main-wrapper">

  <div class="py-2 bg-body-tertiary border-bottom">
    <div class="container-xl px-3 px-md-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
          <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Home</a></li>
          <li class="breadcrumb-item active">Contact</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="container-xl px-3 px-md-4 py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">

        <div class="text-center mb-5">
          <h1 class="h3 fw-semibold mb-2">Get in touch</h1>
          <p class="text-muted">Have a question, want to post a job, or need support? We'd love to hear from you.</p>
        </div>

        <div class="row g-4">

          {{-- Contact info --}}
          <div class="col-12 col-md-4">
            <div class="d-flex flex-column gap-3">

              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-envelope text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">Email</div>
                  <a href="mailto:info@stardena.org" class="text-body-secondary small text-decoration-none">info@stardena.org</a>
                </div>
              </div>

              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-briefcase text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">Post a Job</div>
                  <a href="mailto:jobs@stardena.org" class="text-body-secondary small text-decoration-none">jobs@stardena.org</a>
                </div>
              </div>

              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-geo-alt text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">Location</div>
                  <p class="text-body-secondary small mb-0">Kampala, Uganda</p>
                </div>
              </div>

              <div class="d-flex gap-3 p-3 bg-body-secondary rounded-3">
                <div class="flex-shrink-0">
                  <div class="rounded-2 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                    <i class="bi bi-clock text-primary"></i>
                  </div>
                </div>
                <div>
                  <div class="fw-semibold small mb-1">Response time</div>
                  <p class="text-body-secondary small mb-0">Within 24 hours</p>
                </div>
              </div>

            </div>
          </div>

          {{-- Contact form --}}
          <div class="col-12 col-md-8">
            <div class="card border rounded-3 shadow-sm">
              <div class="card-body p-4">
                <h2 class="h6 fw-semibold mb-4">Send us a message</h2>

                @if(session('success'))
                <div class="alert alert-success rounded-3 mb-4" role="alert">
                  <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                  @csrf
                  <div class="row g-3">
                    <div class="col-12 col-sm-6">
                      <label class="form-label small fw-semibold">Full Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                             placeholder="Your name" value="{{ old('name') }}" required>
                      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-sm-6">
                      <label class="form-label small fw-semibold">Email Address</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                             placeholder="your@email.com" value="{{ old('email') }}" required>
                      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Subject</label>
                      <select name="subject" class="form-select @error('subject') is-invalid @enderror">
                        <option value="">Select a topic</option>
                        <option value="job-posting"   {{ old('subject')=='job-posting'   ? 'selected':'' }}>I want to post a job</option>
                        <option value="job-seeker"    {{ old('subject')=='job-seeker'    ? 'selected':'' }}>Job seeker support</option>
                        <option value="report"        {{ old('subject')=='report'        ? 'selected':'' }}>Report a listing</option>
                        <option value="partnership"   {{ old('subject')=='partnership'   ? 'selected':'' }}>Partnership enquiry</option>
                        <option value="other"         {{ old('subject')=='other'         ? 'selected':'' }}>Other</option>
                      </select>
                      @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                      <label class="form-label small fw-semibold">Message</label>
                      <textarea name="message" rows="5"
                                class="form-control @error('message') is-invalid @enderror"
                                placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                      @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary fw-semibold px-4">
                        <i class="bi bi-send me-2"></i>Send Message
                      </button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>
@endsection