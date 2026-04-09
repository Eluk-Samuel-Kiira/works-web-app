{{--
    ============================================================
    APPLY MODAL - Bootstrap Native Modal
    MaterialPro UI Design
    ============================================================
--}}

<!-- Apply Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg modal-fullscreen-sm-down">
        <div class="modal-content border-0 shadow-lg rounded-4">

            {{-- Modal Header --}}
            <div class="modal-header border-0 pt-3 px-3 pb-0">
                <div class="d-flex gap-2 align-items-center flex-grow-1 min-w-0">
                    <div class="rounded-3 bg-primary bg-opacity-10 flex-shrink-0"
                         style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                        @php $logoUrl = companyLogo($job['company'] ?? null); @endphp
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}"
                                alt="{{ $job['company']['name'] ?? 'Company' }}"
                                width="32" height="32"
                                style="width:32px;height:32px;object-fit:contain;border-radius:6px;background:#fff;padding:2px;"
                                loading="lazy"
                                onerror="this.src='{{ asset('default-logo.png') }}';">
                        @else
                            <i class="bi bi-building text-primary" style="font-size:1.1rem"></i>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h6 class="modal-title fw-bold mb-0 text-truncate" style="font-size:.9rem">
                            {{ Str::limit($job['job_title'] ?? 'Apply for Job', 45) }}
                        </h6>
                        <p class="text-muted mb-0" style="font-size:11px">
                            {{ $job['company']['name'] ?? 'Company' }} &bull;
                            {{ $job['job_location']['district'] ?? $job['job_location']['country'] ?? $job['duty_station'] ?? 'Location' }}
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close flex-shrink-0 ms-2" data-bs-dismiss="modal"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body p-3" id="applyModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted small">Loading application options...</p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer border-0 pt-0 pb-3 px-3">
                <button type="button" class="btn btn-light border w-100" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const modalJobData = @json($job);

    function openApplyModal() {
        incrementApplicationCount();
        const modalBody = document.getElementById('applyModalBody');
        modalBody.innerHTML = buildApplyModalContent(modalJobData);
        const modal = new bootstrap.Modal(document.getElementById('applyModal'));
        modal.show();
    }

    async function incrementApplicationCount() {
        if (!shareData.id) return;
        try {
            const apiBaseUrl = document.querySelector('meta[name="api-base-url"]')?.getAttribute('content') || '{{ config('api.main_app.api_base') }}';
            const response = await fetch(`${apiBaseUrl}/v2/jobs/${shareData.id}/increment-application`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    job_id: shareData.id,
                    job_title: shareData.title,
                    company: shareData.company
                })
            });
            const data = await response.json();
            if (data.success) console.log('Application count incremented');
        } catch (error) {
            console.error('Failed to increment application count:', error);
        }
    }

    function buildApplyModalContent(job) {
        const hasWhatsapp = (job.is_whatsapp_contact === true || job.is_whatsapp_contact === 1 || job.is_whatsapp_contact === '1') && !empty(job.telephone);
        const hasPhone    = (job.is_telephone_call  === true || job.is_telephone_call  === 1 || job.is_telephone_call  === '1') && !empty(job.telephone);
        const hasEmail    = !empty(job.email);

        let externalUrl = null, hasExternalLink = false;

        // Better URL extraction
        if (!empty(job.application_procedure)) {
            // Match URLs without capturing HTML attributes
            const urlMatches = job.application_procedure.match(/https?:\/\/[^\s<>"']+/g);
            if (urlMatches && urlMatches.length > 0) {
                externalUrl = urlMatches[0];
                hasExternalLink = true;
            }
        }
        if (!hasExternalLink && !empty(job.job_description)) {
            const urlMatches = job.job_description.match(/https?:\/\/[^\s<>"']+/g);
            if (urlMatches && urlMatches.length > 0) {
                externalUrl = urlMatches[0];
                hasExternalLink = true;
            }
        }

        let html = '';

        // ── Deadline Notice ──────────────────────────────────
        if (!empty(job.deadline)) {
            const daysLeft = Math.ceil((new Date(job.deadline) - new Date()) / (1000 * 60 * 60 * 24));
            if (daysLeft >= 0 && daysLeft <= 7) {
                html += `
                <div class="alert alert-warning bg-warning bg-opacity-10 border-0 rounded-3 py-2 px-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-warning flex-shrink-0"></i>
                    <span class="small">${daysLeft === 0 ? 'Last day to apply!' : `Only ${daysLeft} day${daysLeft !== 1 ? 's' : ''} left`}</span>
                </div>`;
            }
        }

        // ── Requirement Badges ───────────────────────────────
        if (job.is_resume_required || job.is_cover_letter_required || job.is_academic_documents_required) {
            html += '<div class="d-flex flex-wrap gap-2 mb-3">';
            if (job.is_resume_required)
                html += '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-2 py-1" style="font-size:11px"><i class="bi bi-file-text me-1"></i>CV Required</span>';
            if (job.is_cover_letter_required)
                html += '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-2 py-1" style="font-size:11px"><i class="bi bi-file-richtext me-1"></i>Cover Letter</span>';
            if (job.is_academic_documents_required)
                html += '<span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-2 py-1" style="font-size:11px"><i class="bi bi-mortarboard me-1"></i>Academic Docs</span>';
            html += '</div>';
        }

        html += '<div class="d-flex flex-column gap-3">';

        // ── Stardena Works Attribution Banner (for non-external link methods) ──
        let hasApplicationMethod = false;
        
        // ── WhatsApp ─────────────────────────────────────────
        if (hasWhatsapp && !empty(job.telephone)) {
            hasApplicationMethod = true;
            const clean = job.telephone.replace(/[^0-9+]/g, '').replace(/^\+?0*/, '');
            const waMsg = encodeURIComponent(`Hello, I'm interested in the ${job.job_title} position at ${job.company?.name || 'your company'}. I'd like to apply.`);
            html += `
            <div class="card border-0 bg-body-secondary rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="bg-success bg-opacity-10 rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width:44px;height:44px">
                            <i class="bi bi-whatsapp text-success" style="font-size:1.25rem"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1" style="font-size:.875rem">Apply via WhatsApp</h6>
                            <p class="text-muted mb-2" style="font-size:12px">Send your application directly on WhatsApp</p>
                            <code class="small bg-white rounded px-2 py-1 d-block mb-2 text-break border">${job.telephone}</code>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-sm btn-outline-success" onclick="copyToClipboard('${job.telephone}')">
                                    <i class="bi bi-copy me-1"></i>Copy
                                </button>
                                <a href="https://wa.me/${clean}?text=${waMsg}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="bi bi-whatsapp me-1"></i>Open WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        // ── Phone ─────────────────────────────────────────────
        if (hasPhone && !empty(job.telephone)) {
            hasApplicationMethod = true;
            const phone = job.telephone.replace(/[^0-9+]/g, '');
            html += `
            <div class="card border-0 bg-body-secondary rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="bg-primary bg-opacity-10 rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width:44px;height:44px">
                            <i class="bi bi-telephone text-primary" style="font-size:1.25rem"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1" style="font-size:.875rem">Call to Apply</h6>
                            <p class="text-muted mb-2" style="font-size:12px">Speak directly to the hiring team</p>
                            <code class="small bg-white rounded px-2 py-1 d-block mb-2 text-break border">${job.telephone}</code>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('${job.telephone}')">
                                    <i class="bi bi-copy me-1"></i>Copy
                                </button>
                                <a href="tel:${phone}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-telephone me-1"></i>Call Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        // ── Email ─────────────────────────────────────────────
        if (hasEmail) {
            hasApplicationMethod = true;
            html += `
            <div class="card border-0 bg-body-secondary rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="bg-warning bg-opacity-10 rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width:44px;height:44px">
                            <i class="bi bi-envelope text-warning" style="font-size:1.25rem"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1" style="font-size:.875rem">Apply via Email</h6>
                            <p class="text-muted mb-2" style="font-size:12px">Send your application to</p>
                            <code class="small bg-white rounded px-2 py-1 d-block mb-2 text-break border">${job.email}</code>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-sm btn-outline-warning" onclick="copyToClipboard('${job.email}')">
                                    <i class="bi bi-copy me-1"></i>Copy
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="openEmailForm('${job.email}', '${job.job_title}', '${job.company?.name || ''}')">
                                    <i class="bi bi-envelope me-1"></i>Compose Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        // ── External Link ─────────────────────────────────────
        if (hasExternalLink && externalUrl) {
            hasApplicationMethod = true;
            // Clean the URL to remove any HTML artifacts
            let cleanUrl = externalUrl;
            // Remove any trailing HTML tags or quotes
            cleanUrl = cleanUrl.replace(/['">]+$/, '').replace(/^['"]+/, '');
            
            const displayUrl = cleanUrl.length > 45 ? cleanUrl.substring(0, 42) + '...' : cleanUrl;
            html += `
            <div class="card border-0 bg-body-secondary rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="bg-info bg-opacity-10 rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width:44px;height:44px">
                            <i class="bi bi-box-arrow-up-right text-info" style="font-size:1.25rem"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1" style="font-size:.875rem">Apply on External Site</h6>
                            <p class="text-muted mb-2" style="font-size:12px">You'll be redirected to the company's application page</p>
                            <div class="bg-white rounded p-2 mb-2 border text-break" style="word-break:break-all; font-size:12px">
                                <i class="bi bi-link-45deg me-1 text-primary"></i>
                                <a href="${cleanUrl}" target="_blank" rel="noopener noreferrer" class="text-primary text-decoration-none">
                                    ${escapeHtml(displayUrl)}
                                </a>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="${cleanUrl}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-info">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>Continue to Apply
                                </a>
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('${cleanUrl}')">
                                    <i class="bi bi-copy me-1"></i>Copy Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        // ── Stardena Works Attribution Banner ─────────────────
        // Show attribution for all non-external-link methods
        if (hasApplicationMethod && !hasExternalLink) {
            html += `
            <div class="alert alert-primary bg-primary bg-opacity-10 border-0 rounded-3 py-2 px-3 d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                <i class="bi bi-check-circle-fill text-primary flex-shrink-0"></i>
                <span class="small">This application is being sent through <strong>Stardena Works</strong> — mention that you found this opportunity on Stardena Works to increase your chances!</span>
            </div>`;
        }

        // ── Instructions (no external link) ───────────────────
        if (!empty(job.application_procedure) && !hasExternalLink) {
            html += `
            <div class="card border-0 bg-body-secondary rounded-3">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-2" style="font-size:.875rem"><i class="bi bi-list-check me-1"></i>How to Apply</h6>
                    <p class="text-muted small mb-0">${escapeHtml(job.application_procedure)}</p>
                </div>
            </div>`;
        }

        // ── Fallback ──────────────────────────────────────────
        if (!hasWhatsapp && !hasPhone && !hasEmail && !hasExternalLink) {
            if (!empty(job.telephone)) {
                hasApplicationMethod = true;
                html += `
                <div class="card border-0 bg-body-secondary rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="bg-secondary bg-opacity-10 rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center" style="width:44px;height:44px">
                                <i class="bi bi-telephone text-secondary" style="font-size:1.25rem"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="fw-bold mb-1" style="font-size:.875rem">Contact the Employer</h6>
                                <p class="text-muted mb-2" style="font-size:12px">Call or message for application details</p>
                                <code class="small bg-white rounded px-2 py-1 d-block mb-2 text-break border">${job.telephone}</code>
                                <div class="d-flex gap-2 flex-wrap">
                                    <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('${job.telephone}')">
                                        <i class="bi bi-copy me-1"></i>Copy
                                    </button>
                                    <a href="tel:${job.telephone.replace(/[^0-9+]/g, '')}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-telephone me-1"></i>Call Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                
                // Add attribution for fallback phone method
                html += `
                <div class="alert alert-primary bg-primary bg-opacity-10 border-0 rounded-3 py-2 px-3 d-flex align-items-center gap-2" style="font-size: 0.75rem;">
                    <i class="bi bi-check-circle-fill text-primary flex-shrink-0"></i>
                    <span class="small">This application is being sent through <strong>Stardena Works</strong> — mention that you found this opportunity on Stardena Works to increase your chances!</span>
                </div>`;
                
            } else if (!empty(job.company?.website)) {
                html += `
                <div class="text-center py-4">
                    <i class="bi bi-info-circle fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted small mb-3">No application method provided. Please visit the company website.</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="${job.company.website}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="bi bi-building me-1"></i>Visit Company Website
                        </a>
                        <button class="btn btn-outline-warning btn-sm" onclick="reportMissingApplicationLink('${job.id}', '${job.job_title}', '${job.company?.name || ''}')">
                            <i class="bi bi-flag me-1"></i>Report Missing Link
                        </button>
                    </div>
                </div>`;
            } else {
                html += `
                <div class="text-center py-4">
                    <i class="bi bi-info-circle fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted small mb-3">No application method available for this job.</p>
                    <button class="btn btn-outline-warning btn-sm" onclick="reportMissingApplicationLink('${job.id}', '${job.job_title}', '${job.company?.name || ''}')">
                        <i class="bi bi-flag me-1"></i>Report Missing Application Link
                    </button>
                </div>`;
            }
        }

        html += '</div>';
        return html;
    }

    function empty(value) {
        return value === null || value === undefined || value === '' || (typeof value === 'string' && value.trim() === '');
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Copied to clipboard!', 'success');
        }).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = text;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            showToast('Copied to clipboard!', 'success');
        });
    }

    function openEmailForm(email, jobTitle, companyName) {
        const subject = encodeURIComponent(`Application for ${jobTitle} position at ${companyName || 'your company'}`);
        const body = encodeURIComponent(`Dear Hiring Manager,\n\nI am writing to apply for the ${jobTitle} position at ${companyName || 'your company'}.\n\n[Your cover letter here]\n\nBest regards,\n[Your Name]\n\n---\nFound via Stardena Works`);
        window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
        const modal = bootstrap.Modal.getInstance(document.getElementById('applyModal'));
        if (modal) modal.hide();
    }

    function reportMissingApplicationLink(jobId, jobTitle, companyName) {
        const reportData = {
            job_id: jobId,
            job_title: jobTitle,
            company_name: companyName,
            url: window.location.href,
            reported_at: new Date().toISOString(),
            user_agent: navigator.userAgent,
            reported_by_email: {{ Auth::check() ? json_encode(Auth::user()->email) : 'null' }},
            reported_by_name: {{ Auth::check() ? json_encode(Auth::user()->full_name) : 'null' }}
        };

        if (confirm(`Report missing application link for "${jobTitle}"?\n\nThis will help us fix the issue and notify the employer.`)) {
            const reportBtn = document.activeElement;
            const originalText = reportBtn.innerHTML;
            reportBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Submitting...';
            reportBtn.disabled = true;

            const apiBaseUrl = document.querySelector('meta[name="api-base-url"]')?.getAttribute('content') || '{{ config('api.main_app.api_base') }}';

            fetch(`${apiBaseUrl}/v2/report-missing-link`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(reportData)
            })
            .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
            .then(data => {
                if (data.success) {
                    showToast('Thank you! Admin has been notified.', 'success');
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('applyModal'));
                        if (modal) modal.hide();
                    }, 2000);
                } else {
                    showToast(data.message || 'Failed to submit report. Please try again.', 'error');
                    reportBtn.innerHTML = originalText;
                    reportBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error reporting missing link:', error);
                showToast('Unable to submit report. Please contact support@stardenaworks.com', 'error');
                reportBtn.innerHTML = originalText;
                reportBtn.disabled = false;
            });
        }
    }
</script>

<style>
    /* ── Apply Modal — Fully Responsive ─────────── */

    /* Base modal styles */
    #applyModal .modal-content {
        border: none;
        overflow: hidden;
    }

    /* Phones: slide up from bottom as a sheet */
    @media (max-width: 575.98px) {
        #applyModal .modal-dialog {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            display: flex;
            align-items: flex-end;
            min-height: 100%;
        }
        #applyModal .modal-content {
            border-radius: 1.25rem 1.25rem 0 0 !important;
            max-height: 85dvh;
            max-height: 85vh;
        }
        #applyModal .modal-body {
            padding: 1rem !important;
            overflow-y: auto;
        }
        #applyModal .modal-footer {
            padding: 0.75rem 1rem 1rem !important;
        }
        #applyModal .card-body {
            padding: 0.875rem !important;
        }
        #applyModal .btn-sm {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        #applyModal h6 {
            font-size: 0.875rem !important;
        }
        #applyModal .text-muted {
            font-size: 0.75rem !important;
        }
    }

    /* Tablets: comfortable centred dialog */
    @media (min-width: 576px) and (max-width: 991.98px) {
        #applyModal .modal-dialog {
            max-width: 540px;
            margin: 1.75rem auto;
        }
        #applyModal .modal-content {
            border-radius: 1rem !important;
        }
        #applyModal .modal-body {
            padding: 1.25rem !important;
        }
    }

    /* Desktop */
    @media (min-width: 992px) {
        #applyModal .modal-dialog {
            max-width: 680px;
        }
        #applyModal .modal-content {
            border-radius: 1rem !important;
        }
        #applyModal .modal-body {
            padding: 1.5rem !important;
        }
    }

    /* Code blocks and long text handling */
    #applyModal code,
    #applyModal .bg-white.rounded.p-2 {
        font-family: monospace;
        word-break: break-all;
        overflow-wrap: break-word;
        white-space: normal;
        display: block;
    }

    #applyModal .text-break {
        word-break: break-word;
        overflow-wrap: break-word;
    }

    #applyModal a {
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /* Card spacing and alignment */
    #applyModal .card {
        transition: all 0.2s ease;
    }

    #applyModal .card:hover {
        transform: translateY(-1px);
    }

    /* Alert styling */
    #applyModal .alert {
        font-size: 0.8125rem;
    }

    /* Button group wrapping */
    #applyModal .d-flex.gap-2 {
        flex-wrap: wrap;
    }

    /* Very small phones (< 360px) */
    @media (max-width: 359.98px) {
        #applyModal .modal-body {
            padding: 0.75rem !important;
        }
        
        #applyModal .btn-sm {
            font-size: 0.7rem;
            padding: 0.3rem 0.6rem;
        }
        
        #applyModal h6 {
            font-size: 0.8125rem !important;
        }
        
        #applyModal .card-body {
            padding: 0.75rem !important;
        }
        
        #applyModal .bg-white.rounded.p-2 {
            font-size: 0.7rem;
        }
    }

    /* Landscape mode on phones */
    @media (max-width: 896px) and (orientation: landscape) {
        #applyModal .modal-content {
            max-height: 90vh;
        }
        
        #applyModal .modal-body {
            max-height: calc(90vh - 120px);
            overflow-y: auto;
        }
        
        #applyModal .card {
            margin-bottom: 0.75rem;
        }
    }

    /* Fix for iOS Safari */
    @supports (-webkit-touch-callout: none) {
        #applyModal .modal-content {
            max-height: 85vh;
        }
    }

    /* Ensure proper scrolling */
    #applyModal .modal-body {
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>