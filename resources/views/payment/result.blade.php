{{-- WEB APP: resources/views/payment/result.blade.php --}}
@extends('layouts.jobs')
@section('title', 'Payment Result | Stardena Works')

@section('job-content')

@php
    // Get reference from URL (works for both callback and direct)
    $reference = request()->get('reference', '');
    $orderTrackingId = request()->get('OrderTrackingId', '');
    
    // Use the reference from URL
    $actualReference = !empty($reference) ? $reference : $orderTrackingId;
    
    $isLoggedIn = session()->has('web_user');
    $dashUrl = $isLoggedIn ? route('seeker.dashboard') : url('/');
    $retryUrl = url('/post-featured-jobs');
@endphp

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background:#f8faff;">
  <div class="container" style="max-width:540px;">
    <div class="card border-0 shadow-lg rounded-4 text-center p-5" id="resultCard">

      {{-- ── Checking ─────────────────────────────────────────────── --}}
      <div id="checkingState">
        <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;" role="status">
          <span class="visually-hidden">Loading…</span>
        </div>
        <h5 class="fw-bold mb-1">Verifying Payment</h5>
        <p class="text-muted small mb-0">Please wait while we confirm your payment with Pesapal…</p>
      </div>

      {{-- ── Success ──────────────────────────────────────────────── --}}
      <div id="successState" class="d-none">
        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-4 mb-3 mx-auto">
          <i class="bi bi-check-circle-fill text-success" style="font-size:2.5rem;"></i>
        </div>

        <h4 class="fw-bold mb-1 text-success">Payment Successful!</h4>

        <div id="successDynamicContent"></div>
        <div id="successCTA"></div>
      </div>

      {{-- ── Failed ───────────────────────────────────────────────── --}}
      <div id="failedState" class="d-none">
        <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex p-4 mb-3 mx-auto">
          <i class="bi bi-x-circle-fill text-danger" style="font-size:2.5rem;"></i>
        </div>

        <h4 class="fw-bold mb-1 text-danger">Payment Failed</h4>
        <p class="text-muted mb-3">We couldn't process your payment. <strong>No charges were made.</strong></p>

        <div class="bg-light rounded-3 p-3 mb-4 text-start" id="failedDetails"></div>

        <p class="text-muted small mb-4">
          Common reasons: insufficient funds, wrong PIN, or session timeout.
          Your details are saved — just try again.
        </p>

        <div id="failedCTA"></div>
      </div>

      {{-- ── Pending ──────────────────────────────────────────────── --}}
      <div id="pendingState" class="d-none">
        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex p-4 mb-3 mx-auto">
          <i class="bi bi-hourglass-split text-warning" style="font-size:2.5rem;"></i>
        </div>

        <h4 class="fw-bold mb-1">Payment Processing</h4>

        <div class="bg-light rounded-3 p-3 mb-4 text-start" id="pendingDetails"></div>

        <div class="alert alert-info small py-2 px-3 rounded-3 mb-4" style="background:#e8f0fe;border:none;">
          <i class="bi bi-info-circle me-2"></i>
          Keep this page open — we're still checking.
          If you leave, check your email for confirmation.
        </div>

        <div id="pendingCTA"></div>
      </div>

    </div>

    {{-- Support footer --}}
    <p class="text-center small text-muted mt-3 mb-0">
      <i class="bi bi-lock-fill me-1"></i>
      Secured by Pesapal &nbsp;·&nbsp;
      <a href="{{ url('/contact') }}" class="text-primary">Need help?</a>
      &nbsp;·&nbsp;
      Reference: <span class="font-monospace" id="footerReference">{{ Str::limit($actualReference, 20) }}</span>
    </p>
  </div>
</div>

<script>
(function () {
    'use strict';

    const REFERENCE = @json($actualReference);
    
    if (!REFERENCE) {
        console.error('No reference provided');
        document.getElementById('checkingState').classList.add('d-none');
        document.getElementById('failedState').classList.remove('d-none');
        document.getElementById('failedDetails').innerHTML = '<p class="text-danger">No payment reference found.</p>';
        return;
    }
    
    // Get API base URL
    const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    const cleanApiBase = API_BASE.replace(/\/api$/, '');
    
    // Use the PUBLIC transaction status endpoint
    const STATUS_URL = `${cleanApiBase}/api/v1/public/transaction/status/${encodeURIComponent(REFERENCE)}`;
    
    // console.log('Payment Result Page:', {
    //     reference: REFERENCE,
    //     statusUrl: STATUS_URL
    // });
    
    let pollCount = 0;
    const MAX_POLLS = 20;
    const POLL_INTERVAL = 3000;
    const RETRY_DELAY = 4000;
    
    let transactionData = null;

    function showState(state) {
        const states = ['checking', 'success', 'failed', 'pending'];
        states.forEach(s => {
            const el = document.getElementById(s + 'State');
            if (el) el.classList.toggle('d-none', s !== state);
        });
    }

    function formatAmount(amount, currency) {
        const symbols = { 'UGX': 'UGX', 'KES': 'KSh', 'TZS': 'TSh', 'USD': '$', 'GBP': '£', 'EUR': '€' };
        const symbol = symbols[currency] || currency;
        return `${symbol} ${parseFloat(amount).toLocaleString()}`;
    }

    function updateUI(data) {
        const isSuccessful = data.status === 'successful';
        const isFailed = data.status === 'failed' || data.status === 'error' || data.status === 'reversed';
        const isPending = data.status === 'pending' || data.status === 'processing';
        const isFeatured = data.transaction_type === 'featured_job';
        
        const packageName = data.package_display_name || (isFeatured ? '⭐ FEATURED JOB POSTING' : '📋 SUBSCRIPTION PLAN');
        const amountDisplay = formatAmount(data.amount, data.currency);
        const jobSummary = data.job_summary || '';
        const companyName = data.company_name || '';
        const customerEmail = data.customer_email || '';
        
        // Update footer reference
        const footerRef = document.getElementById('footerReference');
        if (footerRef) {
            footerRef.textContent = data.reference.substring(0, 20);
        }
        
        if (isSuccessful) {
            // Build success content
            const successContent = document.getElementById('successDynamicContent');
            if (successContent) {
                let successHtml = `
                    <div class="mb-3 p-3 bg-light rounded-3 text-start">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Package:</span>
                            <span class="fw-bold text-warning">${escapeHtml(packageName)}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Amount Paid:</span>
                            <span class="fw-bold text-success">${escapeHtml(amountDisplay)}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Reference:</span>
                            <span class="fw-semibold font-monospace small">${escapeHtml(data.reference)}</span>
                        </div>
                        ${data.confirmation_code ? `
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Confirmation:</span>
                            <span class="fw-semibold font-monospace small">${escapeHtml(data.confirmation_code)}</span>
                        </div>
                        ` : ''}
                `;
                
                if (jobSummary && isFeatured) {
                    successHtml += `
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-muted">Job Preview:</small>
                            <p class="small mb-0 mt-1 text-muted" style="word-break:break-word;">${escapeHtml(jobSummary.substring(0, 200))}${jobSummary.length > 200 ? '…' : ''}</p>
                        </div>
                    `;
                }
                
                if (companyName && isFeatured) {
                    successHtml += `
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-muted">Company:</small>
                            <p class="small mb-0 mt-1 text-muted">${escapeHtml(companyName)}</p>
                        </div>
                    `;
                }
                
                successHtml += `</div>`;
                
                if (isFeatured) {
                    successHtml += `
                        <div class="alert alert-success rounded-3">
                            <i class="bi bi-star-fill me-2"></i>
                            <strong>Your job will be featured within 2 hours!</strong>
                            <p class="small mt-2 mb-0">We've sent confirmation to ${escapeHtml(customerEmail)}. Your job posting will appear at the top of search results with a featured badge.</p>
                        </div>
                    `;
                } else {
                    successHtml += `
                        <div class="alert alert-success rounded-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Your subscription is now active!</strong>
                            <p class="small mt-2 mb-0">You can now access all premium features including AI CV reviews, cover letters, and more.</p>
                        </div>
                    `;
                }
                
                successContent.innerHTML = successHtml;
            }
            
            // CTA buttons
            const successCTA = document.getElementById('successCTA');
            if (successCTA) {
                if (isFeatured) {
                    successCTA.innerHTML = `
                        <div class="d-flex gap-2 justify-content-center flex-wrap mt-3">
                            <a href="/post-featured-jobs" class="btn btn-success rounded-pill px-4 py-2 fw-semibold">
                                <i class="bi bi-star-fill me-2"></i>Feature Another Job
                            </a>
                            <a href="/jobs" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                <i class="bi bi-search me-2"></i>Browse Jobs
                            </a>
                        </div>
                    `;
                } else {
                    successCTA.innerHTML = `
                        <a href="/dashboard" class="btn btn-success rounded-pill px-5 py-2 fw-semibold">
                            <i class="bi bi-house me-2"></i>Go to Dashboard
                        </a>
                    `;
                }
            }
            
            showState('success');
            
        } else if (isFailed) {
            // Build failed details
            const failedDetails = document.getElementById('failedDetails');
            if (failedDetails) {
                failedDetails.innerHTML = `
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Reference</span>
                        <span class="fw-semibold font-monospace">${escapeHtml(data.reference)}</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Package</span>
                        <span class="fw-semibold">${escapeHtml(packageName)}</span>
                    </div>
                `;
            }
            
            // CTA buttons
            const failedCTA = document.getElementById('failedCTA');
            if (failedCTA) {
                failedCTA.innerHTML = `
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="/post-featured-jobs" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                            <i class="bi bi-arrow-repeat me-2"></i>Try Again
                        </a>
                        <a href="/contact" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                            <i class="bi bi-headset me-2"></i>Get Help
                        </a>
                    </div>
                `;
            }
            
            showState('failed');
            
        } else if (isPending) {
            // Build pending details
            const pendingDetails = document.getElementById('pendingDetails');
            if (pendingDetails) {
                let pendingHtml = `
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Reference</span>
                        <span class="fw-semibold font-monospace">${escapeHtml(data.reference)}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Package</span>
                        <span class="fw-semibold text-warning">${escapeHtml(packageName)}</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Amount</span>
                        <span class="fw-semibold">${escapeHtml(amountDisplay)}</span>
                    </div>
                `;
                
                if (jobSummary && isFeatured) {
                    pendingHtml += `
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-muted">Job Preview:</small>
                            <p class="small mb-0 mt-1 text-muted">${escapeHtml(jobSummary.substring(0, 150))}${jobSummary.length > 150 ? '…' : ''}</p>
                        </div>
                    `;
                }
                pendingDetails.innerHTML = pendingHtml;
            }
            
            showState('pending');
        }
    }

    async function fetchTransactionStatus() {
        try {
            const response = await fetch(STATUS_URL, {
                headers: { 'Accept': 'application/json' },
                cache: 'no-store'
            });

            if (!response.ok) {
                // console.log(`Status fetch failed: ${response.status}`);
                if (response.status === 404) {
                    // Transaction not found yet - keep polling
                    return null;
                }
                return null;
            }

            const result = await response.json();
            // console.log('Transaction data:', result);
            
            if (!result.success || !result.data) {
                return null;
            }
            
            return result.data;
        } catch (error) {
            console.error('Fetch error:', error);
            return null;
        }
    }

    async function pollTransactionStatus() {
        if (pollCount >= MAX_POLLS) {
            // console.log('Max polls reached, showing pending');
            showState('pending');
            return;
        }
        
        pollCount++;
        
        const data = await fetchTransactionStatus();
        
        if (!data) {
            setTimeout(pollTransactionStatus, RETRY_DELAY);
            return;
        }
        
        transactionData = data;
        const status = (data.status || '').toLowerCase();
        
        // console.log(`Poll ${pollCount}: status = ${status}, type = ${data.transaction_type}`);
        
        if (status === 'successful') {
            updateUI(data);
            return;
        } else if (status === 'failed' || status === 'error' || status === 'reversed') {
            updateUI(data);
            return;
        } else if (status === 'pending' || status === 'processing') {
            updateUI(data);
            setTimeout(pollTransactionStatus, POLL_INTERVAL);
            return;
        } else {
            setTimeout(pollTransactionStatus, POLL_INTERVAL);
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Start polling
    showState('checking');
    setTimeout(pollTransactionStatus, 1500);

})();
</script>

@endsection