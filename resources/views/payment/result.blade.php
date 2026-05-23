{{-- WEB APP: resources/views/payment/result.blade.php --}}
@extends('layouts.jobs')
@section('title', 'Payment Result | Stardena Works')

@section('job-content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background:#f8faff;">
  <div class="container" style="max-width:520px;">
    <div class="card border-0 shadow-lg rounded-4 text-center p-5" id="resultCard">

      {{-- Spinner while checking --}}
      <div id="checkingState">
        <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;" role="status"></div>
        <h5 class="fw-bold mb-1">Verifying Payment</h5>
        <p class="text-muted small">Please wait while we confirm your payment…</p>
      </div>

      {{-- Success --}}
      <div id="successState" class="d-none">
        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-4 mb-3">
          <i class="bi bi-check-circle-fill text-success" style="font-size:2.5rem;"></i>
        </div>
        <h4 class="fw-bold mb-1 text-success">Payment Successful!</h4>
        <p class="text-muted mb-3">Your <strong id="successPlan"></strong> plan is now active.</p>
        <div class="bg-light rounded-3 p-3 mb-4 text-start">
          <div class="d-flex justify-content-between small mb-1">
            <span class="text-muted">Reference</span>
            <span class="fw-semibold font-monospace">{{ $reference }}</span>
          </div>
          @if($amount)
          <div class="d-flex justify-content-between small mb-1">
            <span class="text-muted">Amount Paid</span>
            <span class="fw-semibold">{{ $amount }}</span>
          </div>
          @endif
          @if($confirmation_code)
          <div class="d-flex justify-content-between small">
            <span class="text-muted">Confirmation</span>
            <span class="fw-semibold">{{ $confirmation_code }}</span>
          </div>
          @endif
        </div>
        <a href="{{ route('seeker.dashboard') }}" class="btn btn-success rounded-pill px-5 py-2 fw-semibold">
          <i class="bi bi-house me-2"></i>Go to Dashboard
        </a>
      </div>

      {{-- Failed --}}
      <div id="failedState" class="d-none">
        <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex p-4 mb-3">
          <i class="bi bi-x-circle-fill text-danger" style="font-size:2.5rem;"></i>
        </div>
        <h4 class="fw-bold mb-1 text-danger">Payment Failed</h4>
        <p class="text-muted mb-4">We couldn't process your payment. No charges were made.</p>
        <div class="d-flex gap-2 justify-content-center flex-wrap">
          <a href="{{ url('/#cv-enhancement') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-arrow-repeat me-2"></i>Try Again
          </a>
          <a href="{{ route('seeker.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
            Dashboard
          </a>
        </div>
      </div>

      {{-- Pending --}}
      <div id="pendingState" class="d-none">
        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-4 mb-3">
          <i class="bi bi-hourglass-split text-warning" style="font-size:2.5rem;"></i>
        </div>
        <h4 class="fw-bold mb-1">Payment Processing</h4>
        <p class="text-muted mb-4">Your payment is being processed. We'll notify you by email once confirmed.</p>
        <div class="bg-light rounded-3 p-3 mb-4 text-start">
          <div class="d-flex justify-content-between small">
            <span class="text-muted">Reference</span>
            <span class="fw-semibold font-monospace">{{ $reference }}</span>
          </div>
        </div>
        <a href="{{ route('seeker.dashboard') }}" class="btn btn-outline-primary rounded-pill px-5">
          <i class="bi bi-house me-2"></i>Back to Dashboard
        </a>
      </div>

    </div>
  </div>
</div>

<script>
(function () {
    const REFERENCE = '{{ $reference }}';
    const INITIAL_STATUS = '{{ $status }}';
    const PLAN = '{{ $plan ?? "" }}';
    let pollCount = 0;

    function showState(state) {
        ['checking','success','failed','pending'].forEach(s => {
            document.getElementById(s + 'State').classList.toggle('d-none', s !== state);
        });
        if (state === 'success' && PLAN) {
            const el = document.getElementById('successPlan');
            if (el) el.textContent = PLAN.charAt(0).toUpperCase() + PLAN.slice(1);
        }
    }

    async function pollStatus() {
        if (pollCount >= 10) { showState('pending'); return; } // give up after 10 tries
        pollCount++;

        try {
            const res  = await fetch(`/payment/status/${REFERENCE}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            const status = data.status ?? 'pending';

            if (status === 'successful') { showState('success'); return; }
            if (status === 'failed')     { showState('failed');  return; }

            // Still pending/processing — poll again in 3s
            setTimeout(pollStatus, 3000);

        } catch (e) {
            setTimeout(pollStatus, 3000);
        }
    }

    // If Main already told us the status via callback, use it immediately
    if (INITIAL_STATUS === 'successful') { showState('success'); }
    else if (INITIAL_STATUS === 'failed') { showState('failed'); }
    else {
        // Poll until we get a definitive answer
        showState('checking');
        setTimeout(pollStatus, 1500);
    }
})();
</script>
@endsection