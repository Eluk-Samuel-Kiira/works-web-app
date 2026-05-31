{{-- WEB APP: resources/views/payment/cancelled.blade.php --}}
@extends('layouts.jobs')
@section('title', 'Payment Cancelled | Stardena Works')

@section('job-content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background:#f8faff;">
  <div class="container" style="max-width:520px;">
    <div class="card border-0 shadow-lg rounded-4 text-center p-5">
      
      <div class="rounded-circle bg-secondary bg-opacity-10 d-inline-flex p-4 mb-3">
        <i class="bi bi-x-octagon-fill text-secondary" style="font-size:2.5rem;"></i>
      </div>
      
      <h4 class="fw-bold mb-1">Payment Cancelled</h4>
      <p class="text-muted mb-3">You cancelled the payment process. No charges were made.</p>
      
      <div class="bg-light rounded-3 p-3 mb-4 text-start">
        <div class="d-flex justify-content-between small">
          <span class="text-muted">Transaction</span>
          <span class="fw-semibold font-monospace">{{ $reference ?? 'N/A' }}</span>
        </div>
        @if(isset($plan))
        <div class="d-flex justify-content-between small mt-1">
          <span class="text-muted">Plan</span>
          <span class="fw-semibold">{{ ucfirst($plan) }}</span>
        </div>
        @endif
      </div>
      
      <div class="d-flex gap-2 justify-content-center flex-wrap">
        <a href="{{ url('\') }}" class="btn btn-primary rounded-pill px-4">
          <i class="bi bi-arrow-repeat me-2"></i>Try Again
        </a>
        <a href="{{ route('seeker.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
          <i class="bi bi-house me-2"></i>Go to Dashboard
        </a>
      </div>
      
      <p class="small text-muted mt-4 mb-0">
        <i class="bi bi-lock me-1"></i> Need help? <a href="{{ url('/contact') }}" class="text-primary">Contact Support</a>
      </p>
    </div>
  </div>
</div>
@endsection