{{-- WEB APP: resources/views/seeker/partials/cover-letter-tab.blade.php --}}
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-block mb-2">
                <i class="bi bi-envelope-paper fs-2 text-primary"></i>
            </div>
            <h5 class="fw-bold mb-1">AI-Powered Cover Letter Generator</h5>
            <p class="text-muted small mb-2">Generate a tailored cover letter that matches your CV to any job description</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1"><i class="bi bi-check-circle-fill me-1" style="font-size: 8px;"></i>Job-specific tailoring</span>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1"><i class="bi bi-check-circle-fill me-1" style="font-size: 8px;"></i>HR-approved format</span>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1"><i class="bi bi-check-circle-fill me-1" style="font-size: 8px;"></i>PDF download</span>
            </div>
        </div>

        {{-- Job Details Form --}}
        <div class="mb-3">
            <label class="form-label small fw-semibold">Job Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm rounded-2" id="cl_job_title" 
                   placeholder="e.g., Senior Software Engineer, Credit Risk Manager">
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Company Name</label>
            <input type="text" class="form-control form-control-sm rounded-2" id="cl_company_name" 
                   placeholder="e.g., Stanbic Bank, MTN Uganda">
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Hiring Manager (Optional)</label>
            <input type="text" class="form-control form-control-sm rounded-2" id="cl_hiring_manager" 
                   placeholder="e.g., Mr. John Doe, HR Manager">
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Job Description <span class="text-danger">*</span></label>
            <textarea class="form-control form-control-sm rounded-2" id="cl_job_description" rows="6"
                      placeholder="Paste the complete job description here..."></textarea>
            <div class="text-muted small mt-1" id="jdCharCount">0 characters</div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Key Responsibilities (Optional)</label>
            <textarea class="form-control form-control-sm rounded-2" id="cl_responsibilities" rows="3"
                      placeholder="List key responsibilities from the job posting..."></textarea>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-semibold">Required Skills (Optional)</label>
            <textarea class="form-control form-control-sm rounded-2" id="cl_required_skills" rows="2"
                      placeholder="e.g., Python, Project Management, Risk Analysis..."></textarea>
        </div>

        <button id="generateLetterBtn" onclick="generateCoverLetter()" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold w-100">
            <i class="bi bi-magic me-2"></i>Generate Cover Letter
        </button>

        <div id="coverLetterResult" class="mt-4 d-none"></div>
    </div>
</div>

<script>
async function generateCoverLetter() {
    const jobTitle = document.getElementById('cl_job_title').value.trim();
    const jobDesc = document.getElementById('cl_job_description').value.trim();
    
    if (!jobTitle || !jobDesc) {
        showEnhToast('Please provide both Job Title and Job Description', 'error');
        return;
    }
    
    const btn = document.getElementById('generateLetterBtn');
    const resultArea = document.getElementById('coverLetterResult');
    
    setBtnLoading(btn, 'Generating your cover letter...');
    resultArea.classList.add('d-none');
    
    const formData = new FormData();
    formData.append('job_title', jobTitle);
    formData.append('job_description', jobDesc);
    formData.append('company_name', document.getElementById('cl_company_name').value.trim());
    formData.append('hiring_manager', document.getElementById('cl_hiring_manager').value.trim());
    formData.append('responsibilities', document.getElementById('cl_responsibilities').value.trim());
    formData.append('required_skills', document.getElementById('cl_required_skills').value.trim());
    
    try {
        const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
        const API_TOKEN = '{{ session("api_token") }}';
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
        
        const response = await fetch(`${API_BASE}/v1/cv-enhancement/cover-letter`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${API_TOKEN}`,
                'X-CSRF-TOKEN': CSRF
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            resultArea.innerHTML = renderErrorHtml(data.message || 'Failed to generate cover letter.');
            resultArea.classList.remove('d-none');
            return;
        }
        
        resultArea.innerHTML = renderCoverLetterResult(data.data);
        resultArea.classList.remove('d-none');
        resultArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
    } catch (error) {
        resultArea.innerHTML = renderErrorHtml('Network error. Please try again.');
        resultArea.classList.remove('d-none');
    } finally {
        resetBtn(btn, '<i class="bi bi-magic me-2"></i>Generate Cover Letter');
    }
}

function renderCoverLetterResult(data) {
    const matchScore = data.match_score || 0;
    const scoreColor = matchScore >= 70 ? 'success' : matchScore >= 50 ? 'warning' : 'danger';
    const matchedSkills = data.matched_skills || [];
    const missingSkills = data.missing_skills || [];
    
    return `
    <div class="border rounded-3 overflow-hidden mt-3">
        <div class="bg-${scoreColor} bg-opacity-10 p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-${scoreColor} bg-opacity-20 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                    <span class="fw-bold text-${scoreColor} fs-5">${matchScore}%</span>
                </div>
                <div>
                    <div class="fw-semibold small">CV to Job Match Score</div>
                    <div class="text-muted" style="font-size: 10px;">Based on skills and experience alignment</div>
                </div>
            </div>
            <button class="btn btn-sm btn-success rounded-pill px-3" onclick="downloadCoverLetterPDF()">
                <i class="bi bi-download me-1"></i>Download PDF
            </button>
        </div>
        
        <div class="p-4">
            ${matchedSkills.length > 0 ? `
            <div class="mb-3">
                <h6 class="fw-bold small mb-2 text-success"><i class="bi bi-check-circle-fill me-1"></i>Matched Skills</h6>
                <div class="d-flex flex-wrap gap-1">
                    ${matchedSkills.map(s => `<span class="badge bg-success bg-opacity-10 text-success rounded-pill" style="font-size: 10px;">${escapeHtml(s)}</span>`).join('')}
                </div>
            </div>
            ` : ''}
            
            ${missingSkills.length > 0 ? `
            <div class="mb-3">
                <h6 class="fw-bold small mb-2 text-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i>Skills to Highlight</h6>
                <div class="d-flex flex-wrap gap-1">
                    ${missingSkills.map(s => `<span class="badge bg-warning bg-opacity-10 text-warning rounded-pill" style="font-size: 10px;">${escapeHtml(s)}</span>`).join('')}
                </div>
                <p class="small text-muted mt-1 mb-0">Consider highlighting these skills if you have relevant experience.</p>
            </div>
            ` : ''}
            
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold small mb-0">Your Cover Letter</h6>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill" onclick="copyCoverLetter()">
                        <i class="bi bi-clipboard me-1"></i>Copy
                    </button>
                </div>
                <div id="coverLetterText" class="bg-white border rounded-2 p-3"
                     style="white-space: pre-wrap; font-family: 'Times New Roman', serif; font-size: 12px; line-height: 1.5; max-height: 500px; overflow-y: auto;">
${escapeHtml(data.generated_letter || '')}
                </div>
            </div>
            
            <div class="mt-3 d-flex align-items-center gap-2 text-muted small">
                <i class="bi bi-envelope"></i>
                <span>A copy has been sent to your email address.</span>
            </div>
        </div>
    </div>`;
}

function copyCoverLetter() {
    const text = document.getElementById('coverLetterText')?.textContent || '';
    navigator.clipboard.writeText(text).then(() => {
        showEnhToast('Cover letter copied to clipboard!', 'success');
    });
}

function downloadCoverLetterPDF() {
    showEnhToast('Preparing PDF download...', 'info');
    // Add PDF download logic here
}

// Character counter for job description
document.getElementById('cl_job_description')?.addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('jdCharCount').textContent = count.toLocaleString() + ' characters';
});
</script>