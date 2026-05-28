{{-- Profile Completion Card --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Profile Strength</h6>
            <span class="badge bg-primary rounded-pill px-3 py-2" id="profileStrength">0%</span>
        </div>
        <div class="progress mb-3" style="height: 6px;">
            <div class="progress-bar bg-primary rounded-pill" id="profileProgress" style="width: 0%;"></div>
        </div>
        
        {{-- CV Upload Section --}}
        <div class="mb-3">
            <label class="form-label small fw-semibold">Upload CV (PDF/DOC/DOCX)</label>
            <div class="border rounded-3 p-3 text-center" id="cvUploadArea" style="cursor: pointer; transition: all 0.2s; background: #f8faff;" onclick="document.getElementById('cvUploadInput').click()">
                <i class="bi bi-cloud-upload fs-2 text-primary mb-2 d-block"></i>
                <p class="small text-muted mb-0">Click to upload or drag & drop</p>
                <p class="text-muted small mb-0">Max 5MB • AI will parse your CV</p>
                <input type="file" id="cvUploadInput" class="d-none" accept=".pdf,.doc,.docx">
            </div>
            <div id="cvUploadProgress" class="mt-2 d-none">
                <div class="d-flex align-items-center gap-2">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    <span class="small">AI is parsing your CV...</span>
                </div>
            </div>
            <div id="cvUploadResult" class="mt-2 d-none">
                <div class="alert alert-success small p-2 rounded-2">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    CV parsed successfully! Profile updated.
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <div class="d-flex align-items-center gap-2 mb-2" id="basicInfoCheck">
                <i class="bi bi-circle text-secondary fs-6"></i>
                <span class="small text-muted">Basic info completed</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2" id="emailCheck">
                <i class="bi bi-check-circle-fill text-success fs-6"></i>
                <span class="small text-muted">Email verified</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2" id="cvCheck">
                <i class="bi bi-circle text-secondary fs-6"></i>
                <span class="small text-muted">CV uploaded</span>
            </div>
            <div class="d-flex align-items-center gap-2" id="experienceCheck">
                <i class="bi bi-circle text-secondary fs-6"></i>
                <span class="small text-muted">Work experience</span>
            </div>
        </div>
        
        <button onclick="document.getElementById('cvUploadInput').click()" class="btn btn-outline-primary w-100 rounded-pill">
            <i class="bi bi-cloud-upload me-2"></i>Upload CV to Auto-Fill
        </button>
    </div>
</div>

<script>
// ============================================
// INDEPENDENT CV UPLOAD & AI PARSING
// This script works independently from the CV Editor
// ============================================

(function() {
    'use strict';

    // Configuration
    const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    // console.log(API_BASE);
    const API_TOKEN = '{{ session("api_token") }}';
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // DOM Elements
    const cvUploadInput = document.getElementById('cvUploadInput');
    const cvUploadArea = document.getElementById('cvUploadArea');
    const cvUploadProgress = document.getElementById('cvUploadProgress');
    const cvUploadResult = document.getElementById('cvUploadResult');
    const profileStrengthSpan = document.getElementById('profileStrength');
    const profileProgressBar = document.getElementById('profileProgress');

    // Helper: Show toast message
    function showToastMessage(message, type = 'info') {
        let container = document.getElementById('globalToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'globalToastContainer';
            container.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem;';
            document.body.appendChild(container);
        }
        const colors = { success: '#28a745', error: '#dc3545', warning: '#ffc107', info: '#17a2b8' };
        const icons = { success: '✓', error: '✕', warning: '⚠', info: 'ℹ' };
        const toast = document.createElement('div');
        toast.style.cssText = `background:${colors[type]};color:#fff;padding:0.75rem 1rem;border-radius:0.5rem;box-shadow:0 0.5rem 1rem rgba(0,0,0,.2);min-width:260px;font-size:0.875rem;cursor:pointer;animation:fadeInUp 0.2s ease;`;
        toast.innerHTML = `<div style="display:flex;align-items:center;gap:0.6rem;"><strong style="font-size:1.1rem;">${icons[type]}</strong><span style="flex:1;">${message}</span></div>`;
        toast.onclick = () => toast.remove();
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }

    // Helper: Update profile strength indicators
    function updateProfileStrengthUI(hasBasicInfo = false, hasCV = false, hasExperience = false) {
        const total = 4;
        let completed = 1; // Email is always verified
        
        if (hasBasicInfo) completed++;
        if (hasCV) completed++;
        if (hasExperience) completed++;
        
        const percentage = Math.round((completed / total) * 100);
        if (profileStrengthSpan) profileStrengthSpan.textContent = percentage + '%';
        if (profileProgressBar) profileProgressBar.style.width = percentage + '%';
        
        // Update checkmarks
        if (hasBasicInfo) {
            const basicCheck = document.getElementById('basicInfoCheck');
            if (basicCheck) basicCheck.innerHTML = '<i class="bi bi-check-circle-fill text-success fs-6"></i><span class="small text-muted">Basic info completed</span>';
        }
        if (hasCV) {
            const cvCheck = document.getElementById('cvCheck');
            if (cvCheck) cvCheck.innerHTML = '<i class="bi bi-check-circle-fill text-success fs-6"></i><span class="small text-muted">CV uploaded</span>';
        }
        if (hasExperience) {
            const expCheck = document.getElementById('experienceCheck');
            if (expCheck) expCheck.innerHTML = '<i class="bi bi-check-circle-fill text-success fs-6"></i><span class="small text-muted">Work experience</span>';
        }
    }

    // Check current profile status
    async function checkProfileStatus() {
        try {
            const response = await fetch(`${API_BASE}/seeker/cv`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${API_TOKEN}`,
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                if (data.data) {
                    const cv = data.data;
                    const hasBasicInfo = !!(cv.first_name && cv.last_name && cv.email);
                    const hasCV = !!cv.cv_file_path;
                    const hasExperience = !!(cv.work_experience && cv.work_experience.length > 0);
                    updateProfileStrengthUI(hasBasicInfo, hasCV, hasExperience);
                }
            }
        } catch (error) {
            console.error('Error checking profile status:', error);
        }
    }

    // Upload and parse CV
    async function uploadAndParseCV(file) {
        const formData = new FormData();
        formData.append('cv_file', file);
        
        try {
            const response = await fetch(`${API_BASE}/seeker/cv/parse`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${API_TOKEN}`,
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Show success message
                if (cvUploadResult) {
                    cvUploadResult.classList.remove('d-none');
                    setTimeout(() => cvUploadResult.classList.add('d-none'), 4000);
                }
                
                showToastMessage('CV parsed successfully! Your profile has been updated.', 'success');
                
                // Update profile strength
                updateProfileStrengthUI(true, true, !!(data.parsed_data?.work_experience?.length));
                
                // Reload the CV editor if it exists to reflect new data
                if (typeof loadCVData === 'function') {
                    setTimeout(() => loadCVData(), 1000);
                }
                
                // Optionally reload the page to refresh all data
                // setTimeout(() => window.location.reload(), 1500);
                
                return data;
            } else {
                showToastMessage(data.message || 'Failed to parse CV. Please try again.', 'error');
                return null;
            }
        } catch (error) {
            console.error('Upload error:', error);
            showToastMessage('Network error. Please check your connection and try again.', 'error');
            return null;
        }
    }

    // Handle file selection
    async function handleFileUpload(file) {
        if (!file) return;
        
        // Validate file type
        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!validTypes.includes(file.type)) {
            showToastMessage('Please upload PDF, DOC, or DOCX files only.', 'error');
            return false;
        }
        
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            showToastMessage('File size must be less than 5MB.', 'error');
            return false;
        }
        
        // Show progress
        if (cvUploadArea) cvUploadArea.style.opacity = '0.5';
        if (cvUploadProgress) cvUploadProgress.classList.remove('d-none');
        
        // Upload and parse
        const result = await uploadAndParseCV(file);
        
        // Hide progress
        if (cvUploadProgress) cvUploadProgress.classList.add('d-none');
        if (cvUploadArea) cvUploadArea.style.opacity = '1';
        
        return result;
    }

    // Event listener for file input change
    if (cvUploadInput) {
        cvUploadInput.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (file) {
                await handleFileUpload(file);
                // Clear input so same file can be uploaded again if needed
                cvUploadInput.value = '';
            }
        });
    }
    
    // Drag and drop support
    if (cvUploadArea) {
        cvUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            cvUploadArea.style.background = '#e8f0fe';
            cvUploadArea.style.borderColor = '#2563eb';
        });
        
        cvUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            cvUploadArea.style.background = '#f8faff';
            cvUploadArea.style.borderColor = '';
        });
        
        cvUploadArea.addEventListener('drop', async function(e) {
            e.preventDefault();
            cvUploadArea.style.background = '#f8faff';
            const file = e.dataTransfer.files[0];
            if (file && (file.type.includes('pdf') || file.type.includes('word') || file.type.includes('document'))) {
                await handleFileUpload(file);
            } else {
                showToastMessage('Please drop a PDF, DOC, or DOCX file.', 'warning');
            }
        });
    }
    
    // Initialize - check profile status on page load
    if (API_TOKEN && API_TOKEN !== '') {
        checkProfileStatus();
    }
    
})();
</script>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
#cvUploadArea {
    transition: all 0.2s ease;
}
#cvUploadArea:hover {
    background: #e8f0fe !important;
    border-color: #2563eb !important;
}
</style>
