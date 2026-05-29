{{-- Settings Tab --}}
<div class="card border-0 shadow-sm rounded-3">
<div class="card-body p-4">
    <div id="settingsAlert"></div>
    
    <form id="profileSettingsForm" onsubmit="updateProfile(event)">
    <h6 class="fw-bold mb-3">Personal Information</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
        <label class="form-label small fw-semibold">First Name</label>
        <input type="text" class="form-control rounded-2" id="settingsFirstName" value="{{ session('web_user.first_name') }}">
        </div>
        <div class="col-md-6">
        <label class="form-label small fw-semibold">Last Name</label>
        <input type="text" class="form-control rounded-2" id="settingsLastName" value="{{ session('web_user.last_name') }}">
        </div>
        <div class="col-12">
        <label class="form-label small fw-semibold">Email Address</label>
        <div class="input-group">
            <input type="email" class="form-control rounded-2 bg-light" id="settingsEmail" value="{{ session('web_user.email') }}" readonly disabled>
            <button type="button" class="btn btn-outline-primary rounded-2" onclick="requestEmailChange()" id="changeEmailBtn">
            <i class="bi bi-pencil me-1"></i>Change
            </button>
        </div>
        <small class="text-muted">Email change requires verification. A magic link will be sent to your new address.</small>
        </div>
        <div class="col-12">
        <label class="form-label small fw-semibold">Phone Number</label>
        <div class="input-group">
            <span class="input-group-text bg-light" id="settingsPhoneCode">+256</span>
            <input type="tel" class="form-control rounded-2" id="settingsPhone" placeholder="XXX XXX XXX" value="{{ session('web_user.phone') ? substr(session('web_user.phone'), -9) : '' }}">
        </div>
        </div>
    </div>
    
    <h6 class="fw-bold mb-3">Notification Preferences</h6>
    <div class="mb-3">
        <div class="form-check form-switch mb-2">
        <input class="form-check-input" type="checkbox" id="emailNotif" value="job_recommendations">
        <label class="form-check-label" for="emailNotif">Email job recommendations</label>
        </div>
        <div class="form-check form-switch mb-2">
        <input class="form-check-input" type="checkbox" id="appNotif" value="application_updates">
        <label class="form-check-label" for="appNotif">Application status updates</label>
        </div>
        <div class="form-check form-switch mb-2">
        <input class="form-check-input" type="checkbox" id="cvNotif" value="cv_enhancement">
        <label class="form-check-label" for="cvNotif">CV enhancement results</label>
        </div>
        <div class="form-check form-switch mb-2">
        <input class="form-check-input" type="checkbox" id="paymentNotif" value="payment_updates">
        <label class="form-check-label" for="paymentNotif">Payment and subscription updates</label>
        </div>
        <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="newsNotif" value="news_announcements">
        <label class="form-check-label" for="newsNotif">News and announcements</label>
        </div>
    </div>

    <hr>
    
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary rounded-pill px-4" id="saveSettingsBtn">
        <i class="bi bi-check-lg me-2"></i>Save Changes
        </button>
        <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="logoutConfirm()">
        <i class="bi bi-box-arrow-right me-2"></i>Logout
        </button>
    </div>
    </form>
    
    {{-- Email Change Modal --}}
    <div class="modal fade" id="emailChangeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
        <div class="modal-header border-0 pb-0">
            <h6 class="fw-bold mb-0">Change Email Address</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body pt-2">
            <div id="emailChangeAlert"></div>
            <div class="mb-3">
            <label class="form-label small fw-semibold">Current Email</label>
            <input type="email" class="form-control bg-light" value="{{ session('web_user.email') }}" readonly disabled>
            </div>
            <div class="mb-3">
            <label class="form-label small fw-semibold">New Email Address</label>
            <input type="email" class="form-control" id="newEmail" placeholder="newemail@example.com">
            </div>
            <div class="mb-3">
            <label class="form-label small fw-semibold">Confirm New Email</label>
            <input type="email" class="form-control" id="confirmNewEmail" placeholder="Confirm new email">
            </div>
        </div>
        <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" onclick="sendEmailChangeLink()">Send Verification Link</button>
        </div>
        </div>
    </div>
    </div>
</div>
</div>

<script>
const API_BASE = '{{ rtrim(config("api.main_app.api_base"), "/") }}';
const API_TOKEN = '{{ session("api_token") }}';

// Load user notification preferences on page load
async function loadNotificationPreferences() {
  try {
    const response = await fetch(`${API_BASE}/v1/user/preferences`, {
      headers: {
        'Authorization': `Bearer ${API_TOKEN}`,
        'Accept': 'application/json'
      }
    });
    
    if (response.ok) {
      const data = await response.json();
      if (data.data && data.data.notifications) {
        const prefs = data.data.notifications;
        document.getElementById('emailNotif').checked = prefs.job_recommendations ?? true;
        document.getElementById('appNotif').checked = prefs.application_updates ?? true;
        document.getElementById('cvNotif').checked = prefs.cv_enhancement ?? true;
        document.getElementById('paymentNotif').checked = prefs.payment_updates ?? true;
        document.getElementById('newsNotif').checked = prefs.news_announcements ?? false;
      }
    }
  } catch (error) {
    console.error('Error loading preferences:', error);
  }
}

// Update profile
async function updateProfile(event) {
  event.preventDefault();
  
  const btn = document.getElementById('saveSettingsBtn');
  const alertContainer = document.getElementById('settingsAlert');
  
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
  alertContainer.innerHTML = '';
  
  const firstName = document.getElementById('settingsFirstName').value.trim();
  const lastName = document.getElementById('settingsLastName').value.trim();
  const phoneRaw = document.getElementById('settingsPhone').value.trim();
  const phoneCode = document.getElementById('settingsPhoneCode').textContent;
  
  // Format phone number
  let phone = null;
  if (phoneRaw) {
    let cleanPhone = phoneRaw.replace(/\D/g, '');
    if (cleanPhone.startsWith('0')) cleanPhone = cleanPhone.substring(1);
    phone = phoneCode + cleanPhone;
  }
  
  // Get notification preferences
  const notifications = {
    job_recommendations: document.getElementById('emailNotif').checked,
    application_updates: document.getElementById('appNotif').checked,
    cv_enhancement: document.getElementById('cvNotif').checked,
    payment_updates: document.getElementById('paymentNotif').checked,
    news_announcements: document.getElementById('newsNotif').checked
  };
  
  try {
    // Update user profile
    const profileResponse = await fetch(`${API_BASE}/v1/user/profile`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${API_TOKEN}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        first_name: firstName,
        last_name: lastName,
        phone: phone
      })
    });
    
    if (!profileResponse.ok) {
      const error = await profileResponse.json();
      throw new Error(error.message || 'Failed to update profile');
    }
    
    // Update notification preferences
    const prefsResponse = await fetch(`${API_BASE}/v1/user/preferences`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${API_TOKEN}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ notifications })
    });
    
    if (!prefsResponse.ok) {
      const error = await prefsResponse.json();
      throw new Error(error.message || 'Failed to update preferences');
    }
    
    // Update session data (for UI)
    const webUser = {{ Js::from(session('web_user')) }};
    webUser.first_name = firstName;
    webUser.last_name = lastName;
    webUser.phone = phone;
    
    // Show success message
    alertContainer.innerHTML = `
      <div class="alert alert-success alert-dismissible fade show small py-2 px-3 rounded-2 mb-3">
        <i class="bi bi-check-circle-fill me-2"></i>
        Profile updated successfully!
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
      </div>
    `;
    
    showToast('Profile updated successfully!', 'success');
    
  } catch (error) {
    alertContainer.innerHTML = `
      <div class="alert alert-danger alert-dismissible fade show small py-2 px-3 rounded-2 mb-3">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        ${error.message}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
      </div>
    `;
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Save Changes';
  }
}

// Request email change
function requestEmailChange() {
  document.getElementById('newEmail').value = '';
  document.getElementById('confirmNewEmail').value = '';
  document.getElementById('emailChangeAlert').innerHTML = '';
  new bootstrap.Modal(document.getElementById('emailChangeModal')).show();
}

// Send email change verification link
async function sendEmailChangeLink() {
  const newEmail = document.getElementById('newEmail').value.trim();
  const confirmEmail = document.getElementById('confirmNewEmail').value.trim();
  const alertContainer = document.getElementById('emailChangeAlert');
  
  alertContainer.innerHTML = '';
  
  if (!newEmail || !confirmEmail) {
    alertContainer.innerHTML = '<div class="alert alert-danger small py-2 px-3 rounded-2 mb-3">Please enter both email fields.</div>';
    return;
  }
  
  if (newEmail !== confirmEmail) {
    alertContainer.innerHTML = '<div class="alert alert-danger small py-2 px-3 rounded-2 mb-3">Emails do not match.</div>';
    return;
  }
  
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(newEmail)) {
    alertContainer.innerHTML = '<div class="alert alert-danger small py-2 px-3 rounded-2 mb-3">Please enter a valid email address.</div>';
    return;
  }
  
  const btn = event.target;
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
  
  try {
    const response = await fetch(`${API_BASE}/v1/user/request-email-change`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${API_TOKEN}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ new_email: newEmail })
    });
    
    const data = await response.json();
    
    if (response.ok) {
      alertContainer.innerHTML = `
        <div class="alert alert-success small py-2 px-3 rounded-2 mb-3">
          <i class="bi bi-envelope-check-fill me-2"></i>
          A verification link has been sent to your new email address. Click it to confirm the change.
        </div>
      `;
      setTimeout(() => {
        bootstrap.Modal.getInstance(document.getElementById('emailChangeModal')).hide();
      }, 3000);
    } else {
      alertContainer.innerHTML = `<div class="alert alert-danger small py-2 px-3 rounded-2 mb-3">${data.message || 'Failed to send verification link.'}</div>`;
    }
  } catch (error) {
    alertContainer.innerHTML = '<div class="alert alert-danger small py-2 px-3 rounded-2 mb-3">Network error. Please try again.</div>';
  } finally {
    btn.disabled = false;
    btn.innerHTML = 'Send Verification Link';
  }
}

// Load preferences on page load
document.addEventListener('DOMContentLoaded', () => {
  loadNotificationPreferences();
});
</script>