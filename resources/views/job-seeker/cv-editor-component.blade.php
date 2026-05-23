{{-- resources/views/seeker/cv-editor-component.blade.php --}}
<div class="card border-0 shadow-sm rounded-3" id="cvEditorRoot">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h6 class="fw-bold mb-0"><i class="bi bi-file-text-fill me-2 text-primary"></i>CV Manager</h6>
            <p class="small text-muted mb-0 mt-1">Create and manage your professional CV</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span id="cvSaveStatus" class="small text-muted d-none">
                <i class="bi bi-check-circle-fill text-success me-1"></i>Saved
            </span>
            <button onclick="downloadCVAsPDF()" class="btn btn-sm btn-primary rounded-pill px-3" id="downloadPdfBtn">
                <i class="bi bi-download me-1"></i>Download PDF
            </button>
            <button onclick="saveCVData()" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="saveCvBtn">
                <i class="bi bi-save me-1"></i>Save Changes
            </button>
        </div>
    </div>

    <div class="card-body p-0">

        {{-- Global error banner --}}
        <div id="cvGlobalError" class="alert alert-danger mx-3 mt-3 rounded-3 d-none py-2 px-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <span id="cvGlobalErrorMsg">Please fix the errors below before saving.</span>
        </div>

        {{-- Global success banner --}}
        <div id="cvGlobalSuccess" class="alert alert-success mx-3 mt-3 rounded-3 d-none py-2 px-3">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span id="cvGlobalSuccessMsg">CV saved successfully!</span>
        </div>

        {{-- Main Editor Layout --}}
        <div class="row g-0">

            {{-- Sidebar --}}
            <div class="col-md-3 border-end" style="background:#f8faff; min-height:520px;">
                <div class="p-3">
                    <nav class="nav flex-column nav-pills gap-1" id="cvEditorNav" role="tablist">
                        <button class="nav-link text-start active rounded-3" data-section="personal"       onclick="switchCVSection('personal')"><i class="bi bi-person me-2"></i>Personal Info</button>
                        <button class="nav-link text-start rounded-3"        data-section="experience"     onclick="switchCVSection('experience')"><i class="bi bi-briefcase me-2"></i>Experience &amp; Education</button>
                        <button class="nav-link text-start rounded-3"        data-section="skills"         onclick="switchCVSection('skills')"><i class="bi bi-code-square me-2"></i>Skills</button>
                        <button class="nav-link text-start rounded-3"        data-section="languages"      onclick="switchCVSection('languages')"><i class="bi bi-chat-dots me-2"></i>Languages</button>
                        <button class="nav-link text-start rounded-3"        data-section="certifications" onclick="switchCVSection('certifications')"><i class="bi bi-award me-2"></i>Certifications</button>
                        <button class="nav-link text-start rounded-3"        data-section="portfolio"      onclick="switchCVSection('portfolio')"><i class="bi bi-link-45deg me-2"></i>Portfolio &amp; CV</button>
                        <button class="nav-link text-start rounded-3"        data-section="projects"       onclick="switchCVSection('projects')"><i class="bi bi-folder2-open me-2"></i>Projects</button>
                        <button class="nav-link text-start rounded-3"        data-section="preferences"    onclick="switchCVSection('preferences')"><i class="bi bi-gear me-2"></i>Preferences</button>
                    </nav>
                </div>
            </div>

            {{-- Content Area --}}
            <div class="col-md-9">
                <div class="p-4">

                    {{-- ── PERSONAL INFO ── --}}
                    <div id="section-personal" class="cv-section">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person me-2 text-primary"></i>Personal Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm rounded-2" id="first_name" placeholder="John">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-first_name"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm rounded-2" id="last_name" placeholder="Doe">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-last_name"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm rounded-2" id="email">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-email"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Phone</label>
                                <input type="tel" class="form-control form-control-sm rounded-2" id="phone" placeholder="+256 XXX XXX XXX">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-phone"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Professional Title</label>
                                <input type="text" class="form-control form-control-sm rounded-2" id="professional_title" placeholder="e.g., Senior Software Engineer">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-professional_title"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">City</label>
                                <input type="text" class="form-control form-control-sm rounded-2" id="city" placeholder="Kampala">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-city"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Country</label>
                                <input type="text" class="form-control form-control-sm rounded-2" id="country" placeholder="Uganda">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-country"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Professional Summary</label>
                                <textarea class="form-control form-control-sm rounded-2" id="professional_summary" rows="4"
                                    placeholder="Write a compelling summary of your professional background..."></textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="cv-field-error text-danger small d-none" id="err-professional_summary"></div>
                                    <span class="text-muted small ms-auto" id="summary-count">0 / 5000</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">LinkedIn URL</label>
                                <input type="url" class="form-control form-control-sm rounded-2" id="linkedin_url" placeholder="https://linkedin.com/in/username">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-linkedin_url"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">GitHub URL</label>
                                <input type="url" class="form-control form-control-sm rounded-2" id="github_url" placeholder="https://github.com/username">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-github_url"></div>
                            </div>
                        </div>
                    </div>

                    {{-- ── EXPERIENCE & EDUCATION ── --}}
                    <div id="section-experience" class="cv-section d-none">

                        {{-- Work Experience --}}
                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0"><i class="bi bi-briefcase me-2 text-primary"></i>Work Experience</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="openWorkExpModal()">
                                    <i class="bi bi-plus me-1"></i>Add Experience
                                </button>
                            </div>
                            <div class="cv-field-error text-danger small mb-2 d-none" id="err-work_experience"></div>
                            <div id="workExperienceList">
                                <div class="text-center py-4 text-muted small" id="workExpEmpty">
                                    <i class="bi bi-briefcase fs-3 d-block mb-2 opacity-25"></i>No work experience added yet.
                                </div>
                            </div>
                        </div>

                        {{-- Education --}}
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0"><i class="bi bi-mortarboard me-2 text-primary"></i>Education</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="openEduModal()">
                                    <i class="bi bi-plus me-1"></i>Add Education
                                </button>
                            </div>
                            <div class="cv-field-error text-danger small mb-2 d-none" id="err-education"></div>
                            <div id="educationList">
                                <div class="text-center py-4 text-muted small" id="eduEmpty">
                                    <i class="bi bi-mortarboard fs-3 d-block mb-2 opacity-25"></i>No education added yet.
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── SKILLS ── --}}
                    <div id="section-skills" class="cv-section d-none">
                        <h6 class="fw-bold mb-3"><i class="bi bi-code-square me-2 text-primary"></i>Skills</h6>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Add a Skill</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control rounded-start-2" id="skillInput"
                                    placeholder="e.g., JavaScript, Python, Project Management"
                                    onkeydown="if(event.key==='Enter'){event.preventDefault();addSkillItem();}">
                                <button type="button" class="btn btn-outline-primary rounded-end-2" onclick="addSkillItem()">
                                    <i class="bi bi-plus me-1"></i>Add
                                </button>
                            </div>
                            <div class="cv-field-error text-danger small mt-1 d-none" id="err-skills"></div>
                        </div>
                        <div id="skillsTags" class="d-flex flex-wrap gap-2 mt-2"></div>
                        <p class="text-muted small mt-3 mb-0" id="skillsEmpty">No skills added yet. Type a skill above and press Add.</p>
                    </div>

                    {{-- ── LANGUAGES ── --}}
                    <div id="section-languages" class="cv-section d-none">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-chat-dots me-2 text-primary"></i>Languages</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="openLangModal()">
                                <i class="bi bi-plus me-1"></i>Add Language
                            </button>
                        </div>
                        <div class="cv-field-error text-danger small mb-2 d-none" id="err-languages"></div>
                        <div id="languagesList">
                            <div class="text-center py-4 text-muted small" id="langEmpty">
                                <i class="bi bi-chat-dots fs-3 d-block mb-2 opacity-25"></i>No languages added yet.
                            </div>
                        </div>
                    </div>

                    {{-- ── CERTIFICATIONS ── --}}
                    <div id="section-certifications" class="cv-section d-none">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-award me-2 text-primary"></i>Certifications &amp; Awards</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="openCertModal()">
                                <i class="bi bi-plus me-1"></i>Add Certification
                            </button>
                        </div>
                        <div class="cv-field-error text-danger small mb-2 d-none" id="err-certifications"></div>
                        <div id="certificationsList">
                            <div class="text-center py-4 text-muted small" id="certEmpty">
                                <i class="bi bi-award fs-3 d-block mb-2 opacity-25"></i>No certifications added yet.
                            </div>
                        </div>
                    </div>

                    {{-- ── PORTFOLIO & CV ── --}}
                    <div id="section-portfolio" class="cv-section d-none">
                        <h6 class="fw-bold mb-3"><i class="bi bi-link-45deg me-2 text-primary"></i>Portfolio &amp; CV</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Portfolio URL</label>
                                <input type="url" class="form-control form-control-sm rounded-2" id="portfolio_url" placeholder="https://yourportfolio.com">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-portfolio_url"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Upload CV <span class="text-muted fw-normal">(PDF / DOC / DOCX — max 5MB)</span></label>
                                <input type="file" class="form-control form-control-sm rounded-2" id="cv_file" accept=".pdf,.doc,.docx" onchange="onCVFileChange(this)">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-cv_file"></div>
                                <div id="currentCvInfo" class="mt-2 d-none">
                                    <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-2 border">
                                        <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                                        <span class="small flex-grow-1" id="currentCvName"></span>
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeCVFile()">
                                            <i class="bi bi-x-circle"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── PROJECTS ── --}}
                    <div id="section-projects" class="cv-section d-none">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-folder2-open me-2 text-primary"></i>Projects &amp; Portfolio</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="openProjectModal()">
                                <i class="bi bi-plus me-1"></i>Add Project
                            </button>
                        </div>
                        <p class="text-muted small mb-3">Add links to your projects, portfolios, or professional profiles.</p>
                        <div class="cv-field-error text-danger small mb-2 d-none" id="err-projects"></div>
                        <div id="projectsList">
                            <div class="text-center py-4 text-muted small" id="projectEmpty">
                                <i class="bi bi-folder2-open fs-3 d-block mb-2 opacity-25"></i>No projects added yet.
                            </div>
                        </div>
                    </div>

                    {{-- ── PREFERENCES ── --}}
                    <div id="section-preferences" class="cv-section d-none">
                        <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2 text-primary"></i>Job Preferences</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Preferred Job Types</label>
                                <div class="d-flex flex-wrap gap-3 mt-1">
                                    @foreach(['full-time' => 'Full-time', 'part-time' => 'Part-time', 'contract' => 'Contract', 'internship' => 'Internship', 'remote' => 'Remote'] as $val => $label)
                                    <div class="form-check">
                                        <input class="form-check-input job-type-checkbox" type="checkbox" value="{{ $val }}" id="job_type_{{ $val }}">
                                        <label class="form-check-label small" for="job_type_{{ $val }}">{{ $label }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-job_preferences.job_types"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Preferred Locations</label>
                                <input type="text" class="form-control form-control-sm rounded-2" id="preferred_locations"
                                    placeholder="e.g., Kampala, Remote, Nairobi (comma-separated)">
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-job_preferences.locations"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Min Salary (USD)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control rounded-end-2" id="salary_min" min="0" placeholder="0">
                                </div>
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-job_preferences.salary_min"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Max Salary (USD)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control rounded-end-2" id="salary_max" min="0" placeholder="0">
                                </div>
                                <div class="cv-field-error text-danger small mt-1 d-none" id="err-job_preferences.salary_max"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-top pt-3 mt-4 d-flex justify-content-between align-items-center gap-2">
                        <button onclick="cancelChanges()" class="btn btn-sm btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Discard
                        </button>
                        <button onclick="saveCVData()" class="btn btn-sm btn-primary rounded-pill px-4" id="saveCvBtnBottom">
                            <i class="bi bi-save me-1"></i>Save Changes
                        </button>
                    </div>

                </div>{{-- /p-4 --}}
            </div>{{-- /col-md-9 --}}
        </div>{{-- /row --}}
    </div>{{-- /card-body --}}
</div>{{-- /card --}}


{{-- ════════════════════════════════════════════════════════
     MODALS
════════════════════════════════════════════════════════ --}}

{{-- Work Experience Modal --}}
<div class="modal fade" id="workExpModal" tabindex="-1" aria-labelledby="workExpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="workExpModalLabel">
                    <i class="bi bi-briefcase me-2 text-primary"></i>Work Experience
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <input type="hidden" id="workExpEditIndex" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Job Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_job_title" placeholder="e.g., Software Engineer">
                        <div class="text-danger small mt-1 d-none" id="merr-job_title"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Company <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_company" placeholder="e.g., Google Uganda">
                        <div class="text-danger small mt-1 d-none" id="merr-company"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Location</label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_we_location" placeholder="e.g., Kampala, Uganda">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Employment Type</label>
                        <select class="form-select form-select-sm rounded-2" id="m_employment_type">
                            <option value="">Select type</option>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                            <option value="freelance">Freelance</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Start Date <span class="text-danger">*</span></label>
                        <input type="month" class="form-control form-control-sm rounded-2" id="m_we_start_date">
                        <div class="text-danger small mt-1 d-none" id="merr-we_start_date"></div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">End Date</label>
                        <input type="month" class="form-control form-control-sm rounded-2" id="m_we_end_date">
                        <div class="text-danger small mt-1 d-none" id="merr-we_end_date"></div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end pb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="m_we_current" onchange="toggleCurrentJob(this)">
                            <label class="form-check-label small" for="m_we_current">Current</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Description / Achievements</label>
                        <textarea class="form-control form-control-sm rounded-2" id="m_we_description" rows="4"
                            placeholder="Describe your responsibilities and key achievements..."></textarea>
                        <div class="text-muted small mt-1" id="we-desc-count">0 / 5000</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" onclick="saveWorkExp()">
                    <i class="bi bi-check-lg me-1"></i>Save Experience
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Education Modal --}}
<div class="modal fade" id="eduModal" tabindex="-1" aria-labelledby="eduModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="eduModalLabel">
                    <i class="bi bi-mortarboard me-2 text-primary"></i>Education
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <input type="hidden" id="eduEditIndex" value="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Degree / Certificate <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_degree" placeholder="e.g., Bachelor of Computer Science">
                        <div class="text-danger small mt-1 d-none" id="merr-degree"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Institution <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_institution" placeholder="e.g., Makerere University">
                        <div class="text-danger small mt-1 d-none" id="merr-institution"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Field of Study</label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_field_of_study" placeholder="e.g., Software Engineering">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Grade / GPA</label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_grade" placeholder="e.g., First Class Honours / 4.0">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Start Date <span class="text-danger">*</span></label>
                        <input type="month" class="form-control form-control-sm rounded-2" id="m_edu_start_date">
                        <div class="text-danger small mt-1 d-none" id="merr-edu_start_date"></div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">End Date</label>
                        <input type="month" class="form-control form-control-sm rounded-2" id="m_edu_end_date">
                        <div class="text-danger small mt-1 d-none" id="merr-edu_end_date"></div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end pb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="m_edu_current" onchange="toggleCurrentEdu(this)">
                            <label class="form-check-label small" for="m_edu_current">Current</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Description</label>
                        <textarea class="form-control form-control-sm rounded-2" id="m_edu_description" rows="3"
                            placeholder="Awards, activities, thesis topic..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" onclick="saveEdu()">
                    <i class="bi bi-check-lg me-1"></i>Save Education
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Language Modal --}}
<div class="modal fade" id="langModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold"><i class="bi bi-chat-dots me-2 text-primary"></i>Add Language</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <input type="hidden" id="langEditIndex" value="">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Language <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_lang_name" placeholder="e.g., English">
                        <div class="text-danger small mt-1 d-none" id="merr-lang_name"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Proficiency <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm rounded-2" id="m_lang_proficiency">
                            <option value="">Select proficiency</option>
                            <option value="basic">Basic</option>
                            <option value="conversational">Conversational</option>
                            <option value="professional">Professional</option>
                            <option value="native">Native / Bilingual</option>
                        </select>
                        <div class="text-danger small mt-1 d-none" id="merr-lang_proficiency"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" onclick="saveLang()">
                    <i class="bi bi-check-lg me-1"></i>Save Language
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Certification Modal --}}
<div class="modal fade" id="certModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold"><i class="bi bi-award me-2 text-primary"></i>Certification / Award</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <input type="hidden" id="certEditIndex" value="">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_cert_name" placeholder="e.g., AWS Certified Developer">
                        <div class="text-danger small mt-1 d-none" id="merr-cert_name"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Issuing Organisation</label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_cert_issuer" placeholder="e.g., Amazon Web Services">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Issue Date</label>
                        <input type="month" class="form-control form-control-sm rounded-2" id="m_cert_date">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Credential ID</label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_cert_credential_id" placeholder="Optional">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" onclick="saveCert()">
                    <i class="bi bi-check-lg me-1"></i>Save Certification
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Project Modal --}}
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold"><i class="bi bi-folder2-open me-2 text-primary"></i>Project</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <input type="hidden" id="projectEditIndex" value="">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Project Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm rounded-2" id="m_project_name" placeholder="e.g., E-commerce Platform">
                        <div class="text-danger small mt-1 d-none" id="merr-project_name"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Project URL</label>
                        <input type="url" class="form-control form-control-sm rounded-2" id="m_project_url" placeholder="https://github.com/...">
                        <div class="text-danger small mt-1 d-none" id="merr-project_url"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Description</label>
                        <textarea class="form-control form-control-sm rounded-2" id="m_project_description" rows="3"
                            placeholder="What did you build and what technologies did you use?"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" onclick="saveProject()">
                    <i class="bi bi-check-lg me-1"></i>Save Project
                </button>
            </div>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    // ─── Auth ───────────────────────────────────────────────────────────────
    const API_BASE  = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
    const API_TOKEN = '{{ session("api_token") }}';
    const WEB_USER  = @json(session('web_user'));
    const CSRF      = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // ─── State ──────────────────────────────────────────────────────────────
    let skillsArray          = [];
    let languagesArray       = [];
    let workExperienceArray  = [];
    let educationArray       = [];
    let certificationsArray  = [];
    let projectsArray        = [];
    let cvSnapshotJson       = ''; // for cancel/discard diff

    // ─── API helper ─────────────────────────────────────────────────────────
    async function apiCall(endpoint, options = {}) {
        const isFormData = options.body instanceof FormData;
        const headers = {
            'Accept': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`,
            'X-CSRF-TOKEN': CSRF,
            ...options.headers,
        };
        if (!isFormData && options.body && typeof options.body === 'object') {
            headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(options.body);
        }
        const res = await fetch(`${API_BASE}${endpoint}`, { ...options, headers, mode: 'cors' });
        if (res.status === 401) {
            cvToast('Your session has expired. Please refresh the page.', 'warning');
            throw new Error('Unauthorized');
        }
        return res;
    }

    // ─── Section switching ───────────────────────────────────────────────────
    window.switchCVSection = function (section) {
        document.querySelectorAll('.cv-section').forEach(el => el.classList.add('d-none'));
        document.getElementById(`section-${section}`)?.classList.remove('d-none');
        document.querySelectorAll('#cvEditorNav .nav-link').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-section="${section}"]`)?.classList.add('active');
    };

    // ─── Error helpers ───────────────────────────────────────────────────────
    function clearAllErrors() {
        document.querySelectorAll('.cv-field-error, [id^="merr-"]').forEach(el => {
            el.classList.add('d-none');
            el.textContent = '';
        });
        document.querySelectorAll('.form-control.is-invalid, .form-select.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.getElementById('cvGlobalError')?.classList.add('d-none');
        document.getElementById('cvGlobalSuccess')?.classList.add('d-none');
    }

    function showFieldError(fieldKey, message) {
        // fieldKey can be "first_name" or "work_experience.0.job_title" etc.
        // Map nested keys to flat error div IDs where possible
        const el = document.getElementById(`err-${fieldKey}`);
        if (el) {
            el.textContent = message;
            el.classList.remove('d-none');
            // Mark input invalid
            const inputId = fieldKey.replace(/\..+/, ''); // "work_experience"
            const input = document.getElementById(inputId);
            if (input) input.classList.add('is-invalid');
        }
    }

    function applyValidationErrors(errors) {
        // errors = { "first_name": ["The first name field is required."], ... }
        clearAllErrors();
        let firstErrSection = null;
        const sectionMap = {
            first_name: 'personal', last_name: 'personal', email: 'personal',
            phone: 'personal', professional_title: 'personal', city: 'personal',
            country: 'personal', professional_summary: 'personal',
            linkedin_url: 'personal', github_url: 'personal',
            work_experience: 'experience', education: 'experience',
            skills: 'skills', languages: 'languages',
            certifications: 'certifications',
            portfolio_url: 'portfolio', cv_file: 'portfolio',
            projects: 'projects',
            job_preferences: 'preferences',
        };

        Object.entries(errors).forEach(([key, messages]) => {
            const msg = Array.isArray(messages) ? messages[0] : messages;
            showFieldError(key, msg);
            // Determine section from root key
            const rootKey = key.split('.')[0];
            if (!firstErrSection && sectionMap[rootKey]) {
                firstErrSection = sectionMap[rootKey];
            }
        });

        if (firstErrSection) switchCVSection(firstErrSection);

        document.getElementById('cvGlobalError').classList.remove('d-none');
        document.getElementById('cvGlobalErrorMsg').textContent = 'Please fix the highlighted errors before saving.';
    }

    // ─── Load CV ─────────────────────────────────────────────────────────────
    async function loadCVData() {
        try {
            const res  = await apiCall('/seeker/cv', { method: 'GET' });
            const data = await res.json();
            if (data.data) {
                populateCVForm(data.data);
                snapshotState();
            }
        } catch (err) {
            if (err.message !== 'Unauthorized') {
                cvToast('Failed to load CV. Please refresh.', 'error');
            }
        }
    }

    function populateCVForm(cv) {
        setValue('first_name',           cv.first_name);
        setValue('last_name',            cv.last_name);
        setValue('email',                cv.email);
        setValue('phone',                cv.phone);
        setValue('professional_title',   cv.professional_title);
        setValue('city',                 cv.city);
        setValue('country',              cv.country);
        setValue('professional_summary', cv.professional_summary);
        setValue('linkedin_url',         cv.linkedin_url);
        setValue('github_url',           cv.github_url);
        setValue('portfolio_url',        cv.portfolio_url);

        skillsArray         = arr(cv.skills);
        languagesArray      = arr(cv.languages);
        workExperienceArray = arr(cv.work_experience);
        educationArray      = arr(cv.education);
        certificationsArray = arr(cv.certifications);
        projectsArray       = arr(cv.projects);

        renderAll();

        if (cv.job_preferences) {
            const p = cv.job_preferences;
            arr(p.job_types).forEach(t => {
                const cb = document.getElementById(`job_type_${t}`);
                if (cb) cb.checked = true;
            });
            setValue('preferred_locations', arr(p.locations).join(', '));
            setValue('salary_min', p.salary_min ?? '');
            setValue('salary_max', p.salary_max ?? '');
        }

        if (cv.cv_original_name) {
            document.getElementById('currentCvName').textContent = cv.cv_original_name;
            document.getElementById('currentCvInfo').classList.remove('d-none');
        }
    }

    function arr(v) { return Array.isArray(v) ? v : []; }
    function setValue(id, v) {
        const el = document.getElementById(id);
        if (el) el.value = v ?? '';
    }

    function snapshotState() {
        cvSnapshotJson = JSON.stringify(collectFormData());
    }

    // ─── Save CV ─────────────────────────────────────────────────────────────
    window.saveCVData = async function () {
        clearAllErrors();
        setSavingState(true);

        const formData = buildFormData();

        try {
            const res  = await apiCall('/seeker/cv', { method: 'POST', body: formData });
            const data = await res.json();

            if (res.ok) {
                snapshotState();
                document.getElementById('cvGlobalSuccess').classList.remove('d-none');
                document.getElementById('cvGlobalSuccessMsg').textContent = data.message || 'CV saved successfully!';
                document.getElementById('cvSaveStatus').classList.remove('d-none');

                if (data.data?.cv_original_name) {
                    document.getElementById('currentCvName').textContent = data.data.cv_original_name;
                    document.getElementById('currentCvInfo').classList.remove('d-none');
                }
                setTimeout(() => document.getElementById('cvSaveStatus')?.classList.add('d-none'), 4000);
            } else if (res.status === 422 && data.errors) {
                applyValidationErrors(data.errors);
            } else {
                cvToast(data.message || 'Error saving CV.', 'error');
            }
        } catch (err) {
            if (err.message !== 'Unauthorized') cvToast('Network error. Please try again.', 'error');
        } finally {
            setSavingState(false);
        }
    };

    function setSavingState(saving) {
        ['saveCvBtn', 'saveCvBtnBottom'].forEach(id => {
            const btn = document.getElementById(id);
            if (!btn) return;
            btn.disabled = saving;
            btn.innerHTML = saving
                ? '<span class="spinner-border spinner-border-sm me-1"></span>Saving...'
                : '<i class="bi bi-save me-1"></i>Save Changes';
        });
    }

    function collectFormData() {
        return {
            first_name:           document.getElementById('first_name')?.value,
            last_name:            document.getElementById('last_name')?.value,
            email:                document.getElementById('email')?.value,
            phone:                document.getElementById('phone')?.value,
            professional_title:   document.getElementById('professional_title')?.value,
            city:                 document.getElementById('city')?.value,
            country:              document.getElementById('country')?.value,
            professional_summary: document.getElementById('professional_summary')?.value,
            linkedin_url:         document.getElementById('linkedin_url')?.value,
            github_url:           document.getElementById('github_url')?.value,
            portfolio_url:        document.getElementById('portfolio_url')?.value,
            skills:               skillsArray,
            languages:            languagesArray,
            work_experience:      workExperienceArray,
            education:            educationArray,
            certifications:       certificationsArray,
            projects:             projectsArray,
            job_preferences: {
                job_types:  Array.from(document.querySelectorAll('.job-type-checkbox:checked')).map(c => c.value),
                locations:  (document.getElementById('preferred_locations')?.value || '').split(',').map(s => s.trim()).filter(Boolean),
                salary_min: parseInt(document.getElementById('salary_min')?.value) || null,
                salary_max: parseInt(document.getElementById('salary_max')?.value) || null,
            },
        };
    }

    function buildFormData() {
        const fd   = new FormData();
        const data = collectFormData();

        // Scalar fields
        const scalars = ['first_name','last_name','email','phone','professional_title',
                         'city','country','professional_summary','linkedin_url','github_url','portfolio_url'];
        scalars.forEach(k => fd.append(k, data[k] ?? ''));

        // JSON arrays — Laravel validation expects real arrays via JSON strings decoded server-side
        // We send them as JSON strings; the controller must decode them before validation
        fd.append('skills',          JSON.stringify(data.skills));
        fd.append('languages',       JSON.stringify(data.languages));
        fd.append('work_experience', JSON.stringify(data.work_experience));
        fd.append('education',       JSON.stringify(data.education));
        fd.append('certifications',  JSON.stringify(data.certifications));
        fd.append('projects',        JSON.stringify(data.projects));
        fd.append('job_preferences', JSON.stringify(data.job_preferences));

        // File
        const file = document.getElementById('cv_file')?.files[0];
        if (file) fd.append('cv_file', file);

        return fd;
    }

    // ─── Download PDF ────────────────────────────────────────────────────────
    window.downloadCVAsPDF = async function () {
        cvToast('Generating PDF…', 'info');
        try {
            const res = await apiCall('/seeker/cv/generate-pdf', {
                method: 'POST',
                body: { cv_data: collectFormData() },
            });
            if (res.ok) {
                const blob = await res.blob();
                const url  = URL.createObjectURL(blob);
                const a    = document.createElement('a');
                const fn   = (document.getElementById('first_name')?.value || 'CV') + '_' +
                             (document.getElementById('last_name')?.value  || 'Resume') + '.pdf';
                a.href = url; a.download = fn;
                document.body.appendChild(a); a.click(); a.remove();
                URL.revokeObjectURL(url);
                cvToast('PDF downloaded!', 'success');
            } else {
                const err = await res.json();
                cvToast(err.message || 'Error generating PDF.', 'error');
            }
        } catch (e) {
            if (e.message !== 'Unauthorized') cvToast('Network error.', 'error');
        }
    };

    // ─── Cancel / Discard ────────────────────────────────────────────────────
    window.cancelChanges = function () {
        if (JSON.stringify(collectFormData()) === cvSnapshotJson) return;
        if (!confirm('Discard all unsaved changes?')) return;
        loadCVData();
        clearAllErrors();
    };

    // ─── CV File helpers ─────────────────────────────────────────────────────
    window.onCVFileChange = function (input) {
        const file = input.files[0];
        const errEl = document.getElementById('err-cv_file');
        if (!file) return;
        const maxMB = 5;
        if (file.size > maxMB * 1024 * 1024) {
            errEl.textContent = `File size exceeds ${maxMB}MB.`;
            errEl.classList.remove('d-none');
            input.value = '';
            return;
        }
        errEl.classList.add('d-none');
        document.getElementById('currentCvName').textContent = file.name;
        document.getElementById('currentCvInfo').classList.remove('d-none');
    };

    window.removeCVFile = function () {
        if (!confirm('Remove the uploaded CV file?')) return;
        document.getElementById('cv_file').value = '';
        document.getElementById('currentCvInfo').classList.add('d-none');
    };

    // ─── Skills ──────────────────────────────────────────────────────────────
    window.addSkillItem = function () {
        const input = document.getElementById('skillInput');
        const skill = input.value.trim();
        const errEl = document.getElementById('err-skills');
        if (!skill) return;
        if (skillsArray.includes(skill)) {
            errEl.textContent = `"${skill}" is already added.`;
            errEl.classList.remove('d-none');
            return;
        }
        errEl.classList.add('d-none');
        skillsArray.push(skill);
        input.value = '';
        renderSkillsTags();
    };

    window.removeSkillItem = function (i) {
        skillsArray.splice(i, 1);
        renderSkillsTags();
    };

    function renderSkillsTags() {
        const c = document.getElementById('skillsTags');
        const empty = document.getElementById('skillsEmpty');
        if (!c) return;
        if (skillsArray.length === 0) {
            c.innerHTML = '';
            if (empty) empty.classList.remove('d-none');
            return;
        }
        if (empty) empty.classList.add('d-none');
        c.innerHTML = skillsArray.map((s, i) => `
            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary fw-semibold px-3 py-2 d-flex align-items-center gap-1">
                ${esc(s)}
                <button type="button" class="btn-close btn-close-sm ms-1" style="font-size:.55rem;filter:invert(29%) sepia(99%) saturate(400%) hue-rotate(200deg);"
                    aria-label="Remove ${esc(s)}" onclick="removeSkillItem(${i})"></button>
            </span>`).join('');
    }

    // ─── Work Experience ─────────────────────────────────────────────────────
    window.openWorkExpModal = function (index) {
        clearModalErrors(['merr-job_title','merr-company','merr-we_start_date','merr-we_end_date']);
        const modal = new bootstrap.Modal(document.getElementById('workExpModal'));
        document.getElementById('workExpEditIndex').value = index ?? '';

        if (index !== undefined) {
            const e = workExperienceArray[index];
            setValue('m_job_title',       e.job_title);
            setValue('m_company',         e.company);
            setValue('m_we_location',     e.location);
            setValue('m_employment_type', e.employment_type);
            setValue('m_we_start_date',   e.start_date?.substring(0, 7));
            setValue('m_we_end_date',     e.end_date?.substring(0, 7));
            setValue('m_we_description',  e.description);
            document.getElementById('m_we_current').checked = !!e.current;
            document.getElementById('m_we_end_date').disabled = !!e.current;
            document.getElementById('workExpModalLabel').innerHTML =
                '<i class="bi bi-briefcase me-2 text-primary"></i>Edit Work Experience';
        } else {
            ['m_job_title','m_company','m_we_location','m_we_start_date','m_we_end_date','m_we_description'].forEach(id => setValue(id, ''));
            setValue('m_employment_type', '');
            document.getElementById('m_we_current').checked = false;
            document.getElementById('m_we_end_date').disabled = false;
            document.getElementById('workExpModalLabel').innerHTML =
                '<i class="bi bi-briefcase me-2 text-primary"></i>Add Work Experience';
        }
        modal.show();
    };

    window.toggleCurrentJob = function (cb) {
        document.getElementById('m_we_end_date').disabled = cb.checked;
        if (cb.checked) setValue('m_we_end_date', '');
    };

    window.saveWorkExp = function () {
        clearModalErrors(['merr-job_title','merr-company','merr-we_start_date']);
        let valid = true;
        if (!document.getElementById('m_job_title').value.trim()) {
            showModalError('merr-job_title', 'Job title is required.'); valid = false;
        }
        if (!document.getElementById('m_company').value.trim()) {
            showModalError('merr-company', 'Company name is required.'); valid = false;
        }
        if (!document.getElementById('m_we_start_date').value) {
            showModalError('merr-we_start_date', 'Start date is required.'); valid = false;
        }
        if (!valid) return;

        const obj = {
            job_title:       document.getElementById('m_job_title').value.trim(),
            company:         document.getElementById('m_company').value.trim(),
            location:        document.getElementById('m_we_location').value.trim(),
            employment_type: document.getElementById('m_employment_type').value,
            start_date:      document.getElementById('m_we_start_date').value + '-01',
            end_date:        document.getElementById('m_we_current').checked ? null
                             : (document.getElementById('m_we_end_date').value
                                ? document.getElementById('m_we_end_date').value + '-01' : null),
            current:         document.getElementById('m_we_current').checked,
            description:     document.getElementById('m_we_description').value.trim(),
        };

        const idx = document.getElementById('workExpEditIndex').value;
        if (idx !== '') workExperienceArray[parseInt(idx)] = obj;
        else workExperienceArray.push(obj);

        bootstrap.Modal.getInstance(document.getElementById('workExpModal'))?.hide();
        renderWorkExperienceList();
    };

    window.removeWorkExp = function (i) {
        if (!confirm('Remove this work experience?')) return;
        workExperienceArray.splice(i, 1);
        renderWorkExperienceList();
    };

    function renderWorkExperienceList() {
        const c = document.getElementById('workExperienceList');
        const empty = document.getElementById('workExpEmpty');
        if (!c) return;
        if (workExperienceArray.length === 0) {
            c.innerHTML = '';
            if (empty) empty.classList.remove('d-none');
            return;
        }
        if (empty) empty.classList.add('d-none');
        c.innerHTML = workExperienceArray.map((e, i) => `
            <div class="card border rounded-3 mb-2">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">${esc(e.job_title)}</div>
                            <div class="text-muted small">${esc(e.company)}${e.location ? ' · ' + esc(e.location) : ''}</div>
                            <div class="text-muted small mt-1">
                                ${fmtMonth(e.start_date)} — ${e.current ? '<span class="text-success">Present</span>' : fmtMonth(e.end_date)}
                                ${e.employment_type ? ' · <span class="badge bg-light text-secondary border">' + esc(e.employment_type) + '</span>' : ''}
                            </div>
                            ${e.description ? `<p class="small text-muted mt-2 mb-0" style="white-space:pre-line;">${esc(e.description)}</p>` : ''}
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" onclick="openWorkExpModal(${i})">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="removeWorkExp(${i})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`).join('');
    }

    // ─── Education ───────────────────────────────────────────────────────────
    window.openEduModal = function (index) {
        clearModalErrors(['merr-degree','merr-institution','merr-edu_start_date']);
        const modal = new bootstrap.Modal(document.getElementById('eduModal'));
        document.getElementById('eduEditIndex').value = index ?? '';

        if (index !== undefined) {
            const e = educationArray[index];
            setValue('m_degree',           e.degree);
            setValue('m_institution',      e.institution);
            setValue('m_field_of_study',   e.field_of_study);
            setValue('m_grade',            e.grade);
            setValue('m_edu_start_date',   e.start_date?.substring(0, 7));
            setValue('m_edu_end_date',     e.end_date?.substring(0, 7));
            setValue('m_edu_description',  e.description);
            document.getElementById('m_edu_current').checked = !!e.current;
            document.getElementById('m_edu_end_date').disabled = !!e.current;
            document.getElementById('eduModalLabel').innerHTML =
                '<i class="bi bi-mortarboard me-2 text-primary"></i>Edit Education';
        } else {
            ['m_degree','m_institution','m_field_of_study','m_grade','m_edu_start_date','m_edu_end_date','m_edu_description'].forEach(id => setValue(id, ''));
            document.getElementById('m_edu_current').checked = false;
            document.getElementById('m_edu_end_date').disabled = false;
            document.getElementById('eduModalLabel').innerHTML =
                '<i class="bi bi-mortarboard me-2 text-primary"></i>Add Education';
        }
        modal.show();
    };

    window.toggleCurrentEdu = function (cb) {
        document.getElementById('m_edu_end_date').disabled = cb.checked;
        if (cb.checked) setValue('m_edu_end_date', '');
    };

    window.saveEdu = function () {
        clearModalErrors(['merr-degree','merr-institution','merr-edu_start_date']);
        let valid = true;
        if (!document.getElementById('m_degree').value.trim())      { showModalError('merr-degree','Degree is required.'); valid = false; }
        if (!document.getElementById('m_institution').value.trim()) { showModalError('merr-institution','Institution is required.'); valid = false; }
        if (!document.getElementById('m_edu_start_date').value)     { showModalError('merr-edu_start_date','Start date is required.'); valid = false; }
        if (!valid) return;

        const obj = {
            degree:        document.getElementById('m_degree').value.trim(),
            institution:   document.getElementById('m_institution').value.trim(),
            field_of_study:document.getElementById('m_field_of_study').value.trim(),
            grade:         document.getElementById('m_grade').value.trim(),
            start_date:    document.getElementById('m_edu_start_date').value + '-01',
            end_date:      document.getElementById('m_edu_current').checked ? null
                           : (document.getElementById('m_edu_end_date').value
                              ? document.getElementById('m_edu_end_date').value + '-01' : null),
            current:       document.getElementById('m_edu_current').checked,
            description:   document.getElementById('m_edu_description').value.trim(),
        };

        const idx = document.getElementById('eduEditIndex').value;
        if (idx !== '') educationArray[parseInt(idx)] = obj;
        else educationArray.push(obj);

        bootstrap.Modal.getInstance(document.getElementById('eduModal'))?.hide();
        renderEducationList();
    };

    window.removeEdu = function (i) {
        if (!confirm('Remove this education entry?')) return;
        educationArray.splice(i, 1);
        renderEducationList();
    };

    function renderEducationList() {
        const c = document.getElementById('educationList');
        const empty = document.getElementById('eduEmpty');
        if (!c) return;
        if (educationArray.length === 0) {
            c.innerHTML = '';
            if (empty) empty.classList.remove('d-none');
            return;
        }
        if (empty) empty.classList.add('d-none');
        c.innerHTML = educationArray.map((e, i) => `
            <div class="card border rounded-3 mb-2">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">${esc(e.degree)}</div>
                            <div class="text-muted small">${esc(e.institution)}${e.field_of_study ? ' · ' + esc(e.field_of_study) : ''}</div>
                            <div class="text-muted small mt-1">
                                ${fmtMonth(e.start_date)} — ${e.current ? '<span class="text-success">Present</span>' : fmtMonth(e.end_date)}
                                ${e.grade ? ' · <span class="badge bg-light text-secondary border">' + esc(e.grade) + '</span>' : ''}
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" onclick="openEduModal(${i})">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="removeEdu(${i})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`).join('');
    }

    // ─── Languages ───────────────────────────────────────────────────────────
    window.openLangModal = function (index) {
        clearModalErrors(['merr-lang_name','merr-lang_proficiency']);
        document.getElementById('langEditIndex').value = index ?? '';
        if (index !== undefined) {
            const l = languagesArray[index];
            setValue('m_lang_name',        l.name);
            setValue('m_lang_proficiency', l.proficiency);
        } else {
            setValue('m_lang_name', ''); setValue('m_lang_proficiency', '');
        }
        new bootstrap.Modal(document.getElementById('langModal')).show();
    };

    window.saveLang = function () {
        clearModalErrors(['merr-lang_name','merr-lang_proficiency']);
        let valid = true;
        if (!document.getElementById('m_lang_name').value.trim())       { showModalError('merr-lang_name','Language name is required.'); valid = false; }
        if (!document.getElementById('m_lang_proficiency').value)        { showModalError('merr-lang_proficiency','Proficiency level is required.'); valid = false; }
        if (!valid) return;

        const obj = {
            name:        document.getElementById('m_lang_name').value.trim(),
            proficiency: document.getElementById('m_lang_proficiency').value,
        };
        const idx = document.getElementById('langEditIndex').value;
        if (idx !== '') languagesArray[parseInt(idx)] = obj;
        else languagesArray.push(obj);

        bootstrap.Modal.getInstance(document.getElementById('langModal'))?.hide();
        renderLanguagesList();
    };

    window.removeLangItem = function (i) {
        if (!confirm('Remove this language?')) return;
        languagesArray.splice(i, 1);
        renderLanguagesList();
    };

    const PROFICIENCY_BADGE = { basic: 'secondary', conversational: 'info', professional: 'primary', native: 'success' };

    function renderLanguagesList() {
        const c = document.getElementById('languagesList');
        const empty = document.getElementById('langEmpty');
        if (!c) return;
        if (languagesArray.length === 0) {
            c.innerHTML = '';
            if (empty) empty.classList.remove('d-none');
            return;
        }
        if (empty) empty.classList.add('d-none');
        c.innerHTML = languagesArray.map((l, i) => `
            <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                <div>
                    <span class="fw-semibold">${esc(l.name)}</span>
                    <span class="badge bg-${PROFICIENCY_BADGE[l.proficiency] || 'secondary'} bg-opacity-10 text-${PROFICIENCY_BADGE[l.proficiency] || 'secondary'} ms-2 rounded-pill">
                        ${esc(l.proficiency)}
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" onclick="openLangModal(${i})"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="removeLangItem(${i})"><i class="bi bi-trash"></i></button>
                </div>
            </div>`).join('');
    }

    // ─── Certifications ──────────────────────────────────────────────────────
    window.openCertModal = function (index) {
        clearModalErrors(['merr-cert_name']);
        document.getElementById('certEditIndex').value = index ?? '';
        if (index !== undefined) {
            const c = certificationsArray[index];
            setValue('m_cert_name',          c.name);
            setValue('m_cert_issuer',        c.issuer);
            setValue('m_cert_date',          c.date?.substring(0, 7));
            setValue('m_cert_credential_id', c.credential_id);
        } else {
            ['m_cert_name','m_cert_issuer','m_cert_date','m_cert_credential_id'].forEach(id => setValue(id, ''));
        }
        new bootstrap.Modal(document.getElementById('certModal')).show();
    };

    window.saveCert = function () {
        clearModalErrors(['merr-cert_name']);
        if (!document.getElementById('m_cert_name').value.trim()) {
            showModalError('merr-cert_name','Certification name is required.'); return;
        }
        const obj = {
            name:          document.getElementById('m_cert_name').value.trim(),
            issuer:        document.getElementById('m_cert_issuer').value.trim(),
            date:          document.getElementById('m_cert_date').value ? document.getElementById('m_cert_date').value + '-01' : null,
            credential_id: document.getElementById('m_cert_credential_id').value.trim(),
        };
        const idx = document.getElementById('certEditIndex').value;
        if (idx !== '') certificationsArray[parseInt(idx)] = obj;
        else certificationsArray.push(obj);

        bootstrap.Modal.getInstance(document.getElementById('certModal'))?.hide();
        renderCertificationsList();
    };

    window.removeCertItem = function (i) {
        if (!confirm('Remove this certification?')) return;
        certificationsArray.splice(i, 1);
        renderCertificationsList();
    };

    function renderCertificationsList() {
        const c = document.getElementById('certificationsList');
        const empty = document.getElementById('certEmpty');
        if (!c) return;
        if (certificationsArray.length === 0) {
            c.innerHTML = '';
            if (empty) empty.classList.remove('d-none');
            return;
        }
        if (empty) empty.classList.add('d-none');
        c.innerHTML = certificationsArray.map((cert, i) => `
            <div class="d-flex justify-content-between align-items-center p-2 border-bottom gap-2">
                <div>
                    <div class="fw-semibold">${esc(cert.name)}</div>
                    <div class="text-muted small">
                        ${cert.issuer ? esc(cert.issuer) : ''}
                        ${cert.date   ? ' · ' + fmtMonth(cert.date) : ''}
                        ${cert.credential_id ? ' · ID: ' + esc(cert.credential_id) : ''}
                    </div>
                </div>
                <div class="d-flex gap-2 flex-shrink-0">
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" onclick="openCertModal(${i})"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="removeCertItem(${i})"><i class="bi bi-trash"></i></button>
                </div>
            </div>`).join('');
    }

    // ─── Projects ────────────────────────────────────────────────────────────
    window.openProjectModal = function (index) {
        clearModalErrors(['merr-project_name','merr-project_url']);
        document.getElementById('projectEditIndex').value = index ?? '';
        if (index !== undefined) {
            const p = projectsArray[index];
            setValue('m_project_name',        p.name);
            setValue('m_project_url',         p.url);
            setValue('m_project_description', p.description);
        } else {
            ['m_project_name','m_project_url','m_project_description'].forEach(id => setValue(id, ''));
        }
        new bootstrap.Modal(document.getElementById('projectModal')).show();
    };

    window.saveProject = function () {
        clearModalErrors(['merr-project_name','merr-project_url']);
        let valid = true;
        if (!document.getElementById('m_project_name').value.trim()) {
            showModalError('merr-project_name','Project name is required.'); valid = false;
        }
        const urlVal = document.getElementById('m_project_url').value.trim();
        if (urlVal && !isValidUrl(urlVal)) {
            showModalError('merr-project_url','Please enter a valid URL.'); valid = false;
        }
        if (!valid) return;

        const obj = {
            name:        document.getElementById('m_project_name').value.trim(),
            url:         urlVal,
            description: document.getElementById('m_project_description').value.trim(),
        };
        const idx = document.getElementById('projectEditIndex').value;
        if (idx !== '') projectsArray[parseInt(idx)] = obj;
        else projectsArray.push(obj);

        bootstrap.Modal.getInstance(document.getElementById('projectModal'))?.hide();
        renderProjectsList();
    };

    window.removeProjectItem = function (i) {
        if (!confirm('Remove this project?')) return;
        projectsArray.splice(i, 1);
        renderProjectsList();
    };

    function renderProjectsList() {
        const c = document.getElementById('projectsList');
        const empty = document.getElementById('projectEmpty');
        if (!c) return;
        if (projectsArray.length === 0) {
            c.innerHTML = '';
            if (empty) empty.classList.remove('d-none');
            return;
        }
        if (empty) empty.classList.add('d-none');
        c.innerHTML = projectsArray.map((p, i) => `
            <div class="d-flex justify-content-between align-items-center p-2 border-bottom gap-2">
                <div class="flex-grow-1">
                    <div class="fw-semibold">${esc(p.name)}</div>
                    ${p.url ? `<a href="${esc(p.url)}" target="_blank" rel="noopener" class="text-primary small"><i class="bi bi-link-45deg"></i> ${esc(p.url)}</a>` : ''}
                    ${p.description ? `<p class="text-muted small mb-0 mt-1">${esc(p.description)}</p>` : ''}
                </div>
                <div class="d-flex gap-2 flex-shrink-0">
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" onclick="openProjectModal(${i})"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="removeProjectItem(${i})"><i class="bi bi-trash"></i></button>
                </div>
            </div>`).join('');
    }

    // ─── Render all ──────────────────────────────────────────────────────────
    function renderAll() {
        renderSkillsTags();
        renderLanguagesList();
        renderWorkExperienceList();
        renderEducationList();
        renderCertificationsList();
        renderProjectsList();
    }

    // ─── Utilities ───────────────────────────────────────────────────────────
    function esc(text) {
        if (!text) return '';
        const d = document.createElement('div');
        d.textContent = String(text);
        return d.innerHTML;
    }

    function isValidUrl(s) {
        try { new URL(s); return true; } catch { return false; }
    }

    function fmtMonth(dateStr) {
        if (!dateStr) return '—';
        try {
            return new Date(dateStr).toLocaleDateString('en-GB', { month: 'short', year: 'numeric' });
        } catch { return dateStr; }
    }

    function showModalError(id, msg) {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = msg;
        el.classList.remove('d-none');
    }

    function clearModalErrors(ids) {
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.textContent = ''; el.classList.add('d-none'); }
        });
    }

    function cvToast(message, type) {
        let container = document.getElementById('cvToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'cvToastContainer';
            container.style.cssText = 'position:fixed;bottom:1.25rem;right:1.25rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;min-width:280px;';
            document.body.appendChild(container);
        }
        const colors = { success:'#198754', error:'#dc3545', warning:'#ffc107', info:'#0dcaf0' };
        const icons  = { success:'bi-check-circle-fill', error:'bi-x-circle-fill', warning:'bi-exclamation-triangle-fill', info:'bi-info-circle-fill' };
        const toast  = document.createElement('div');
        toast.style.cssText = `background:${colors[type]||colors.info};color:#fff;padding:.75rem 1rem;border-radius:.5rem;font-size:.875rem;box-shadow:0 4px 12px rgba(0,0,0,.15);display:flex;align-items:center;gap:.6rem;cursor:pointer;`;
        toast.innerHTML = `<i class="bi ${icons[type]||icons.info}"></i><span style="flex:1">${message}</span><i class="bi bi-x opacity-75"></i>`;
        toast.onclick = () => toast.remove();
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }

    // ─── Summary character counter ───────────────────────────────────────────
    document.getElementById('professional_summary')?.addEventListener('input', function () {
        document.getElementById('summary-count').textContent = `${this.value.length} / 5000`;
    });

    document.getElementById('m_we_description')?.addEventListener('input', function () {
        document.getElementById('we-desc-count').textContent = `${this.value.length} / 5000`;
    });

    // ─── Init ────────────────────────────────────────────────────────────────
    loadCVData();

})();
</script>

<style>
.cv-section { animation: cvFadeIn .25s ease; }
@keyframes cvFadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
.nav-pills .nav-link          { color:#4b5563; font-size:13px; padding:8px 12px; }
.nav-pills .nav-link.active   { background-color:var(--bs-primary); color:#fff; }
.nav-pills .nav-link:hover:not(.active) { background-color:rgba(var(--bs-primary-rgb),.06); }
.form-control.is-invalid      { border-color:#dc3545 !important; }
.form-control-sm, .btn-sm     { font-size:13px; }
.modal-content                { border-radius:1rem !important; }
</style>