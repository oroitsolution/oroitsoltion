@extends('userlayout.app')
@section('title', 'Profile Settings || ORO IT SOLUTION')
@section('content')

<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 mb-1 text-dark">Profile Settings</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" id="printProfile">
                        <i class="bi bi-printer me-2"></i>Print
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="company-banner position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="p-4 text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('front/images/logo-og.png') }}" alt="ORO IT SOLUTION" 
                                         class="rounded-circle border border-3 border-white" width="80" height="80">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-1">ORO IT SOLUTION</h3>
                                    <p class="mb-0 opacity-75">Your Trusted Technology Partner</p>
                                </div>
                                <div class="badge bg-white text-primary px-3 py-2 rounded-pill">
                                    <i class="bi bi-shield-check me-2"></i>Verified Account
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Left Column - Personal Information -->
        <div class="col-lg-8">
            <div class="row g-4">
                <!-- Personal Information Card -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-person-badge text-primary me-2"></i>Personal Information
                                </h5>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-patch-check-fill text-success me-1"></i>Verified
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- User Profile Summary -->
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                <div class="position-relative me-3">
                                    <img src="{{ asset('admin/layout/assets/images/favicon.png') }}" 
                                         class="rounded-circle border border-3 border-primary" 
                                         width="80" height="80">
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white">
                                        <i class="bi bi-check-lg text-white fs-6"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="mb-1 text-dark">{{ auth()->user()->name }}</h4>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-envelope me-2"></i>{{ auth()->user()->email }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-telephone me-2"></i>{{ $user->mobile_number ?? 'Not provided' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Information Grid -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-light h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">
                                                <i class="bi bi-person me-1"></i>Full Name
                                            </label>
                                            <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-light h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">
                                                <i class="bi bi-envelope me-1"></i>Email Address
                                            </label>
                                            <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-light h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">
                                                <i class="bi bi-phone me-1"></i>Mobile Number
                                            </label>
                                            <p class="mb-0 fw-semibold">{{ $user->mobile_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-light h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">
                                                <i class="bi bi-globe me-1"></i>Country
                                            </label>
                                            <div class="d-flex align-items-center">
                                                <span class="fi fi-in fis me-2"></span>
                                                <span class="fw-semibold">India</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card border-light">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">
                                                <i class="bi bi-geo-alt me-1"></i>Complete Address
                                            </label>
                                            <p class="mb-0 fw-semibold">{{ $user->address ?? 'No address provided' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-light h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">State</label>
                                            <p class="mb-0 fw-semibold">{{ $user->state ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-light h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">City</label>
                                            <p class="mb-0 fw-semibold">{{ $user->city ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-light h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">Pin Code</label>
                                            <p class="mb-0 fw-semibold">{{ $user->code ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Details Card -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-bank text-primary me-2"></i>Bank Account Details
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">Bank Name</label>
                                            <p class="mb-0 fw-semibold">{{ $kycdata->bank_name ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">IFSC Code</label>
                                            <p class="mb-0 fw-semibold">{{ $kycdata->ifsc_code ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">Account Holder Name</label>
                                            <p class="mb-0 fw-semibold">{{ $kycdata->account_name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">Account Number</label>
                                            <p class="mb-0 fw-semibold">
                                                @if($kycdata && $kycdata->account_number)
                                                    <span class="text-muted">XXXXXX</span>{{ substr($kycdata->account_number, -4) }}
                                                @else
                                                    Not provided
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!$kycdata)
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Bank details are not yet configured. Please update your bank information for transactions.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - API & Webhook Settings -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px;">
                <!-- API & Webhook Configuration -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-shield-lock text-primary me-2"></i>API & Security Settings
                        </h5>
                        <p class="text-muted small mb-0 mt-2">Configure API access and webhook notifications</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- IP Whitelist -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="bi bi-ip me-2 text-info"></i>IP Whitelisting
                            </h6>
                            <div class="input-group mb-2">
                                <input type="text" 
                                       class="form-control"
                                       id = "ipaddress" 
                                       name = "ipaddress"
                                       value="{{ $clintdata->ipaddress ?? 'Not configured' }}"
                                       placeholder="Enter IP address"
                                       >
                                <button class="btn btn-outline-info"  id = "ipupdate" type="button" data-uid = "{{ $user->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                            <small class="text-muted">Your server IP address for API access</small>
                        </div>

                        <hr class="my-4">

                        <!-- Webhook URLs -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="bi bi-link-45deg me-2 text-success"></i>Webhook URLs
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Pay-In Callback</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" 
                                           class="form-control"   id = "payin_url" 
                                       name = "payin_url"
                                           value="{{ $clintdata->payin_url ?? 'Not configured' }}"
                                           >
                                    <button class="btn btn-outline-success" id="payinupdate" type="button" data-uid="{{ $user->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Payout Callback</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" 
                                           class="form-control"  id = "payout_url" 
                                       name = "payout_url" 
                                           value="{{ $clintdata->payout_url ?? 'Not configured' }}"
                                           >
                                    <button class="btn btn-outline-warning" id = "payoutupdate" type="button" data-uid = "{{ $user->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- API Credentials -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="bi bi-key me-2 text-primary"></i>API Credentials
                            </h6>
                            <div class="card  border-0">
                              <div class="card-body">
                        <!-- Client ID -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <span class="small text-muted">Client ID</span>
                                <button class="btn btn-link btn-sm text-decoration-none ms-2 copy-btn" 
                                        data-text="{{ $clintdata->client_id ?? 'ASD998776**897' }}"
                                        data-bs-toggle="tooltip" 
                                        title="Copy Client ID">
                                    <i class="bi bi-copy small"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center">
                                <code class="small me-2">{{ $clintdata->client_id ?? 'ASD998776**897' }}</code>
                            </div>
                        </div>
                        
                        <!-- Secret Key -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <span class="small text-muted">Secret Key</span>
                                <button class="btn btn-link btn-sm text-decoration-none ms-2 copy-btn" 
                                        data-text="{{ $clintdata->secret_id ?? 'OROIT-76***997' }}"
                                        data-bs-toggle="tooltip" 
                                        title="Copy Secret Key">
                                    <i class="bi bi-copy small"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center">
                                <code class="small me-2">{{ $clintdata->secret_id ?? 'OROIT-76***997' }} </code>
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <div>
                                <span class="badge {{ $kycdata ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                    <i class="bi bi-circle-fill me-1"></i>
                                    {{ $kycdata ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Live
                                </button>

                               
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3">Account Summary</h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Member Since</span>
                                <span class="fw-semibold">{{ date('M d, Y', strtotime($user->created_at)) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Last Login</span>
                                <span class="fw-semibold">{{ date('M d, Y H:i') }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Account Status</span>
                                <span class="badge bg-success">Active</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Verification</span>
                                <span class="badge bg-success">Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit form would go here -->
                <p class="text-muted">Edit functionality would be implemented here.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
.company-banner {
    border-radius: 12px;
    overflow: hidden;
}
.card {
    border-radius: 12px;
}
.sticky-top {
    z-index: 1020;
}
.badge.bg-primary-subtle {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}
.card-title {
    color: #2c3e50;
}
.list-group-item {
    background: transparent;
}
.input-group .btn {
    border-color: #dee2e6;
}
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Copy to clipboard function
    function copyToClipboard(text) {
        // Method 1: Modern Clipboard API (Recommended)
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        } else {
            // Method 2: Fallback for older browsers
            return new Promise((resolve, reject) => {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                
                // Make the textarea out of viewport
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                
                textArea.focus();
                textArea.select();
                
                try {
                    const successful = document.execCommand('copy');
                    if (successful) {
                        resolve();
                    } else {
                        reject(new Error('Copy command failed'));
                    }
                } catch (err) {
                    reject(err);
                } finally {
                    textArea.remove();
                }
            });
        }
    }

    // Add click event to all copy buttons
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const textToCopy = this.getAttribute('data-text');
            const originalContent = this.innerHTML;
            const tooltipInstance = bootstrap.Tooltip.getInstance(this);
            
            try {
                await copyToClipboard(textToCopy);
                
                // Show success feedback
                this.innerHTML = '<i class="bi bi-check text-success small"></i>';
                
                // Update tooltip to show success message
                if (tooltipInstance) {
                    tooltipInstance.setContent({ '.tooltip-inner': 'Copied!' });
                    tooltipInstance.show();
                }
                
                // Revert after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    if (tooltipInstance) {
                        const originalTitle = this.getAttribute('title') || this.getAttribute('data-original-title');
                        tooltipInstance.setContent({ '.tooltip-inner': originalTitle });
                    }
                }, 2000);
                
            } catch (err) {
                console.error('Failed to copy:', err);
                
                // Show error feedback
                this.innerHTML = '<i class="bi bi-x text-danger small"></i>';
                
                if (tooltipInstance) {
                    tooltipInstance.setContent({ '.tooltip-inner': 'Failed to copy' });
                    tooltipInstance.show();
                }
                
                // Revert after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    if (tooltipInstance) {
                        const originalTitle = this.getAttribute('title') || this.getAttribute('data-original-title');
                        tooltipInstance.setContent({ '.tooltip-inner': originalTitle });
                    }
                }, 2000);
            }
        });
    });
});




</script>
@endpush