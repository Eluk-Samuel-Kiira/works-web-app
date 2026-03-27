{{--
    ============================================================
    APPLY MODAL - Bootstrap Native Modal
    MaterialPro UI Design
    ============================================================
--}}

<!-- Apply Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            {{-- Modal Header --}}
            <div class="modal-header border-0 pt-4 px-4 pb-0">
                <div class="d-flex gap-3 align-items-center">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-2" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                        @if(!empty($job['company']['logo']))
                            <img src="{{ $job['company']['logo'] }}" alt="{{ $job['company']['name'] ?? '' }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                        @else
                            <i class="bi bi-building fs-4 text-primary"></i>
                        @endif
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">{{ Str::limit($job['job_title'] ?? 'Apply for Job', 45) }}</h5>
                        <p class="text-muted small mb-0">{{ $job['company']['name'] ?? 'Company' }} • {{ $job['job_location']['district'] ?? $job['job_location']['country'] ?? $job['duty_station'] ?? 'Location' }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            {{-- Modal Body --}}
            <div class="modal-body p-4" id="applyModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Loading application options...</p>
                </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Store job data for modal
    const modalJobData = @json($job);

    function openApplyModal() {
        
        incrementApplicationCount();
        const modalBody = document.getElementById('applyModalBody');
        
        // Build modal content
        modalBody.innerHTML = buildApplyModalContent(modalJobData);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('applyModal'));
        modal.show();
    }

    // Function to increment application count via API
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
            
            if (data.success) {
                console.log('Application count incremented:');
                // Optional: Update UI to show new count
                // updateApplicationCountDisplay(data.application_count);
            }
        } catch (error) {
            console.error('Failed to increment application count:', error);
            // Don't block the user - modal still opens even if API fails
        }
    }

    function buildApplyModalContent(job) {
        // Check contact methods properly
        const hasWhatsapp = (job.is_whatsapp_contact === true || job.is_whatsapp_contact === 1 || job.is_whatsapp_contact === '1') && !empty(job.telephone);
        const hasPhone = (job.is_telephone_call === true || job.is_telephone_call === 1 || job.is_telephone_call === '1') && !empty(job.telephone);
        const hasEmail = !empty(job.email);
        
        // Check for external link in application_procedure or description
        let externalUrl = null;
        let hasExternalLink = false;
        
        if (!empty(job.application_procedure)) {
            const urlMatch = job.application_procedure.match(/(https?:\/\/[^\s]+)/);
            if (urlMatch) {
                externalUrl = urlMatch[0];
                hasExternalLink = true;
            }
        }
        
        // If no external link in application_procedure, check job_description
        if (!hasExternalLink && !empty(job.job_description)) {
            const urlMatch = job.job_description.match(/(https?:\/\/[^\s]+)/);
            if (urlMatch) {
                externalUrl = urlMatch[0];
                hasExternalLink = true;
            }
        }
        
        let html = '<div class="px-2">';
        
        // Deadline Notice
        if (!empty(job.deadline)) {
            const daysLeft = Math.ceil((new Date(job.deadline) - new Date()) / (1000 * 60 * 60 * 24));
            if (daysLeft >= 0 && daysLeft <= 7) {
                html += `
                    <div class="alert alert-warning bg-warning bg-opacity-10 border-0 rounded-3 mb-4">
                        <div class="d-flex gap-2">
                            <i class="bi bi-clock-history text-warning"></i>
                            <span class="small">${daysLeft === 0 ? 'Last day to apply!' : `Only ${daysLeft} day${daysLeft !== 1 ? 's' : ''} left to apply`}</span>
                        </div>
                    </div>
                `;
            }
        }
        
        // Requirements Badges
        if (job.is_resume_required || job.is_cover_letter_required || job.is_academic_documents_required) {
            html += '<div class="d-flex flex-wrap gap-2 mb-4">';
            if (job.is_resume_required) {
                html += '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill"><i class="bi bi-file-text me-1"></i>CV Required</span>';
            }
            if (job.is_cover_letter_required) {
                html += '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-2 rounded-pill"><i class="bi bi-file-richtext me-1"></i>Cover Letter Required</span>';
            }
            if (job.is_academic_documents_required) {
                html += '<span class="badge bg-info bg-opacity-10 text-info border border-info px-3 py-2 rounded-pill"><i class="bi bi-mortarboard me-1"></i>Academic Docs Required</span>';
            }
            html += '</div>';
        }
        
        html += '<div class="d-flex flex-column gap-3">';
        
        // WhatsApp Option
        if (hasWhatsapp && !empty(job.telephone)) {
            const waNumber = job.telephone.replace(/[^0-9+]/g, '').replace(/^0+/, '');
            const cleanNumber = waNumber.startsWith('+') ? waNumber.substring(1) : waNumber;
            const waMsg = encodeURIComponent(`Hello, I'm interested in the ${job.job_title} position at ${job.company?.name || 'your company'}. I'd like to apply.`);
            
            html += `
                <div class="card border-0 shadow-sm rounded-4 hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3 align-self-center align-self-sm-start">
                                <i class="bi bi-whatsapp fs-2 text-success"></i>
                            </div>
                            <div class="flex-grow-1 w-100">
                                <h6 class="fw-bold mb-1">Apply via WhatsApp</h6>
                                <p class="text-muted small mb-2">Send your application directly on WhatsApp</p>
                                <div class="mb-2">
                                    <code class="small bg-light p-1 rounded d-inline-block text-break">${job.telephone}</code>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button class="btn btn-sm btn-outline-success" onclick="copyToClipboard('${job.telephone}')">
                                        <i class="bi bi-copy me-1"></i>Copy Number
                                    </button>
                                    <a href="https://wa.me/${cleanNumber}?text=${waMsg}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="bi bi-whatsapp me-1"></i>Open WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Phone Call Option
        if (hasPhone && !empty(job.telephone)) {
            const phoneNumber = job.telephone.replace(/[^0-9+]/g, '');
            html += `
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 align-self-center align-self-sm-start">
                                <i class="bi bi-telephone fs-2 text-primary"></i>
                            </div>
                            <div class="flex-grow-1 w-100">
                                <h6 class="fw-bold mb-1">Call to Apply</h6>
                                <p class="text-muted small mb-2">Speak directly to the hiring team</p>
                                <div class="mb-2">
                                    <code class="small bg-light p-1 rounded d-inline-block text-break">${job.telephone}</code>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('${job.telephone}')">
                                        <i class="bi bi-copy me-1"></i>Copy Number
                                    </button>
                                    <a href="tel:${phoneNumber}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-telephone me-1"></i>Call Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Email Option
        if (hasEmail) {
            html += `
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3 align-self-center align-self-sm-start">
                                <i class="bi bi-envelope fs-2 text-warning"></i>
                            </div>
                            <div class="flex-grow-1 w-100">
                                <h6 class="fw-bold mb-1">Apply via Email</h6>
                                <p class="text-muted small mb-2">Send your application to</p>
                                <div class="mb-2">
                                    <code class="small bg-light p-1 rounded d-inline-block text-break">${job.email}</code>
                                </div>
                                <button class="btn btn-sm btn-warning" onclick="openEmailForm('${job.email}', '${job.job_title}', '${job.company?.name || ''}')">
                                    <i class="bi bi-envelope me-1"></i>Compose Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // External Link Option - FIXED RESPONSIVE VERSION
        if (hasExternalLink && externalUrl) {
            // Truncate long URLs for display
            let displayUrl = externalUrl;
            if (displayUrl.length > 50) {
                displayUrl = displayUrl.substring(0, 47) + '...';
            }
            
            html += `
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                            <div class="bg-info bg-opacity-10 p-3 rounded-3 align-self-center align-self-sm-start">
                                <i class="bi bi-box-arrow-up-right fs-2 text-info"></i>
                            </div>
                            <div class="flex-grow-1 w-100">
                                <h6 class="fw-bold mb-1">Apply on External Site</h6>
                                <p class="text-muted small mb-2">You'll be redirected to the company's application page</p>
                                <div class="mb-2">
                                    <a href="${externalUrl}" target="_blank" class="text-decoration-none">
                                        <code class="small bg-light p-2 rounded d-inline-block text-break w-100 text-primary" style="word-break: break-all;">
                                            <i class="bi bi-link-45deg me-1"></i>${displayUrl}
                                        </code>
                                    </a>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <a href="${externalUrl}" target="_blank" class="btn btn-sm btn-info flex-grow-1">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Continue to Apply
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('${externalUrl}')">
                                        <i class="bi bi-copy me-1"></i>Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Application Instructions (if exists and not already shown as external link)
        if (!empty(job.application_procedure) && !hasExternalLink) {
            html += `
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-2"><i class="bi bi-list-check me-1"></i>How to Apply</h6>
                        <div class="text-muted small">${escapeHtml(job.application_procedure)}</div>
                    </div>
                </div>
            `;
        }
        
        // Fallback - Show contact options if no specific methods
        if (!hasWhatsapp && !hasPhone && !hasEmail && !hasExternalLink) {
            // Check if there's a telephone number without specific flags
            if (!empty(job.telephone)) {
                html += `
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                                <div class="bg-secondary bg-opacity-10 p-3 rounded-3 align-self-center align-self-sm-start">
                                    <i class="bi bi-telephone fs-2 text-secondary"></i>
                                </div>
                                <div class="flex-grow-1 w-100">
                                    <h6 class="fw-bold mb-1">Contact the Employer</h6>
                                    <p class="text-muted small mb-2">Call or message for application details</p>
                                    <div class="mb-2">
                                        <code class="small bg-light p-1 rounded d-inline-block text-break">${job.telephone}</code>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('${job.telephone}')">
                                            <i class="bi bi-copy me-1"></i>Copy Number
                                        </button>
                                        <a href="tel:${job.telephone.replace(/[^0-9+]/g, '')}" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-telephone me-1"></i>Call Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else if (!empty(job.company?.website)) {
                html += `
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-info-circle fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No application method provided. Please visit the company website.</p>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <a href="${job.company.website}" target="_blank" class="btn btn-primary">
                                <i class="bi bi-building me-1"></i>Visit Company Website
                            </a>
                            <button class="btn btn-outline-warning" onclick="reportMissingApplicationLink('${job.id}', '${job.job_title}', '${job.company?.name || ''}')">
                                <i class="bi bi-flag me-1"></i>Inform Admin of Missing Link
                            </button>
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-info-circle fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted">No application method available for this job.</p>
                        </div>
                        <button class="btn btn-outline-warning" onclick="reportMissingApplicationLink('${job.id}', '${job.job_title}', '${job.company?.name || ''}')">
                            <i class="bi bi-flag me-1"></i>Report Missing Application Link
                        </button>
                    </div>
                `;
            }
        }
        
        html += '</div></div>';
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
            // Fallback for older browsers
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showToast('Copied to clipboard!', 'success');
        });
    }

    function openEmailForm(email, jobTitle, companyName) {
        const subject = encodeURIComponent(`Application for ${jobTitle} position at ${companyName || 'your company'}`);
        const body = encodeURIComponent(`
        Dear Hiring Manager,

        I am writing to apply for the ${jobTitle} position at ${companyName || 'your company'}.

        [Your cover letter here]

        Best regards,
        [Your Name]
        `.trim());
        
        // Open mail client
        window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('applyModal'));
        if (modal) modal.hide();
    }

    function reportMissingApplicationLink(jobId, jobTitle, companyName) {
        // Create report data
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
        
        // Show confirmation dialog
        if (confirm(`Report missing application link for "${jobTitle}"?\n\nThis will help us fix the issue and notify the employer.`)) {
            // Show loading state
            const reportBtn = document.activeElement;
            const originalText = reportBtn.innerHTML;
            reportBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Submitting...';
            reportBtn.disabled = true;
            
            // Get API base URL from meta tag or config
            const apiBaseUrl = document.querySelector('meta[name="api-base-url"]')?.getAttribute('content') || '{{ config('api.main_app.api_base') }}';
            
            // Send report to main app API endpoint
            fetch(`${apiBaseUrl}/v2/report-missing-link`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                    // Note: Don't send CSRF token to external API as it's a different domain
                },
                body: JSON.stringify(reportData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Thank you! Admin has been notified. We will update the job posting soon.', 'success');
                    // Close modal after report
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
                showToast('Unable to submit report. Please contact support directly at support@stardenaworks.com', 'error');
                reportBtn.innerHTML = originalText;
                reportBtn.disabled = false;
            });
        }
    }


</script>

<style>
/* Hover effect for cards */
.hover-shadow {
    transition: all 0.2s ease;
}
.hover-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
}
/* Code styling */
code {
    font-family: monospace;
    word-break: break-all;
}
/* Responsive adjustments */
@media (max-width: 576px) {
    .modal-body {
        padding: 1rem !important;
    }
    .card-body {
        padding: 1rem !important;
    }
    .btn-sm {
        padding: 0.4rem 0.75rem;
        font-size: 0.75rem;
    }
}
</style>