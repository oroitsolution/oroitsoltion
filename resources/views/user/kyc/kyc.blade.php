@extends('userlayout.app')
@section('title', 'KYC Verification || ORO IT SOLUTION')
@section('content')

@push('css')
<style>
.section-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.form-section {
    padding: 1.5rem 0;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
}

.image-preview {
    min-height: 100px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    transition: all 0.3s;
}

.image-preview:hover {
    border-color: #0d6efd;
    background: #f0f7ff;
}

.image-preview img {
    max-width: 100%;
    max-height: 90px;
    border-radius: 6px;
    object-fit: contain;
}

.card {
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
}

.card-header {
    background: #fff;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0 !important;
}

.form-control:read-only {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}
</style>
@endpush

<div class="container-fluid">
    <section class="section dashboard">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card mb-3">

                    {{-- ================= KYC STATUS HEADER ================= --}}
                    @php
                    $kycStatus = Auth::user()->user_kyc;
                    $user = Auth::user();
                    @endphp

                    <div class="card-header">
                        <h5 class="card-title mb-0">KYC Verification</h5>
                        
                        <div class="d-flex align-items-center gap-2 mt-2">
                            @if($kycStatus == 0)
                            <span class="badge bg-warning">Unverified</span>
                            @elseif($kycStatus == 1)
                            <span class="badge bg-primary">Verified</span>
                            @elseif($kycStatus == 2)
                            <span class="badge bg-success">Rejected</span>
                            @endif
                            
                            <span class="text-muted">|</span>
                            <span>Account Type: 
                                <b class="text-success">{{ strtoupper($user->account_type) }}</b> || 

                                <b class="{{ !empty($user->business_type) ? 'text-success' : 'text-info' }}">
                                    {{ !empty($user->business_type) ? strtoupper($user->business_type) : 'PERSONAL ACCOUNT' }}
                                </b>
                            </span>
                        </div>

                        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Important:</strong> Maximum file size allowed is <strong>2MB</strong> per file.
                            Supported formats: <strong>JPG, JPEG, PNG, PDF</strong>.
                            <br>
                            <strong>Note:</strong> Please verify Aadhaar number first.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>

                    {{-- ================= SHOW FORM ONLY IF UNVERIFIED / REJECTED ================= --}}
                    @if(in_array($kycStatus, [0, 3]))
                    <div class="card-body">
                        <form id="kycForm" method="POST" class="kyc-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="account_type" id="account_type" value="{{ strtoupper($user->account_type) }}">

                            {{-- ================= BASIC DETAILS ================= --}}
                            <div class="form-section mb-4">
                                <h6 class="section-title text-primary mb-3 pb-2 border-bottom">
                                    <i class="bi bi-person-circle me-2"></i>Basic Details
                                </h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control" value="{{ $user->mobile_number }}" readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= BANK DETAILS ================= --}}
                            <div class="form-section mb-4">
                                <h6 class="section-title text-primary mb-3 pb-2 border-bottom">
                                    <i class="bi bi-bank me-2"></i>Bank Details
                                </h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" required>
                                        <small id="ifsc_error" class="text-danger"></small>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" name="account_number" id="account_number" class="form-control" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Account Holder Name</label>
                                        <input type="text" name="account_name" id="account_name" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= AADHAAR DETAILS ================= --}}
                            <div class="form-section mb-4">
                                <h6 class="section-title text-primary mb-3 pb-2 border-bottom">
                                    <i class="bi bi-card-text me-2"></i>Aadhaar Details
                                </h6>
                               <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Aadhaar Front</label>
                                        <input type="file" name="adhar_front" id="adhar_front" class="form-control" accept=".jpg,.jpeg,.png" required>
                                        <div class="image-preview mt-2" id="adhar_front_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Aadhaar Back</label>
                                        <input type="file" name="adhar_back" id="adhar_back" class="form-control" accept=".jpg,.jpeg,.png" required>
                                        <div class="image-preview mt-2" id="adhar_back_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Aadhaar Number</label>
                                        <div class="input-group">
                                            <input type="text" name="adhar_number" id="adhar_number" class="form-control" 
                                                   placeholder="Enter 12 digit Aadhaar" maxlength="12"
                                                   value="{{ $kycdata->adhar_number ?? '' }}"
                                                   {{ !empty($kycdata->adhar_number) ? 'readonly' : '' }}>
                                            
                                            @if(empty($kycdata->adhar_number))
                                            <button type="button" id="sendOtpBtn" class="btn btn-outline-primary">
                                                Send OTP
                                            </button>
                                            @endif
                                        </div>
                                        <small id="aadhaar_error" class="text-danger"></small>
                                    </div>
                                </div>

                                <!-- OTP Section - Yeh Aadhaar section ke baad alag row me hona chahiye -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="otp-section mt-2 d-none" id="otpSection">
                                            <div class="input-group" style="max-width: 300px;">
                                                <input type="text" name="otp" id="otpInput" class="form-control" 
                                                       placeholder="Enter OTP" maxlength="6">
                                                <button type="button" id="verifyOtpBtn" class="btn btn-success">
                                                    Verify
                                                </button>
                                            </div>
                                            <input type="hidden" name="request_id" id="request_id">
                                            <input type="hidden" name="aadharno" id="aadharno">
                                            <small id="otp_error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= PAN DETAILS ================= --}}
                            <div class="form-section mb-4">
                                <h6 class="section-title text-primary mb-3 pb-2 border-bottom">
                                    <i class="bi bi-credit-card me-2"></i>PAN Details
                                </h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">PAN Number</label>
                                        <input type="text" name="pan_number" id="pan_number" class="form-control" required value="{{ $kycdata->pan_number ?? '' }}" {{ !empty($kycdata->pan_number) ? 'readonly' : '' }}>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">PAN Card</label>
                                        <input type="file" name="pan_card" id="pan_card" class="form-control" accept=".jpg,.jpeg,.png" required>
                                        <div class="image-preview mt-2" id="pan_card_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Cancelled Cheque</label>
                                        <input type="file" name="chaque" id="chaque" class="form-control" accept=".jpg,.jpeg,.png" required>
                                        <div class="image-preview mt-2" id="chaque_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= BUSINESS DETAILS ================= --}}
                            @if($user->account_type == 'business' || $user->account_type == 'personal')
                            <div class="form-section mb-4">
                                <h6 class="section-title text-primary mb-3 pb-2 border-bottom">
                                    <i class="bi bi-building me-2"></i>Business Details
                                </h6>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">GST Number</label>
                                        <input type="text" name="gst" id="gst" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">CIN Number</label>
                                        <input type="text" name="cin_number" id="cin_number" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">GST Certificate (PDF)</label>
                                        <input type="file" id="gst_img" name="gst_img" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        <div class="file-preview mt-2" id="gst_img_preview">
                                            <small class="text-muted">No file selected</small>
                                        </div>
                                    </div>
                                    @if($user->business_type != 'soleproprietorship')
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company PAN</label>
                                        <input type="file" name="company_pan_card" id="company_pan_card" class="form-control" accept=".jpg,.jpeg,.png, .pdf">
                                        <div class="image-preview mt-2" id="company_pan_card_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Address Proof</label>
                                        <input type="file" name="address_proof" id="address_proof" class="form-control" accept=".jpg,.jpeg,.png, .pdf" required>
                                        <div class="image-preview mt-2" id="address_proof_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- ================= SHOP & ELECTRICITY ================= --}}
                            <div class="form-section mb-4">
                                <h6 class="section-title text-primary mb-3 pb-2 border-bottom">
                                    <i class="bi bi-shop me-2"></i>Shop & Address Proof
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Shop Photo</label>
                                        <input type="file" name="shopphoto" id="shopphoto" class="form-control" accept=".jpg,.jpeg,.png, .pdf" required>
                                        <div class="image-preview mt-2" id="shopphoto_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Electricity Bill</label>
                                        <input type="file" name="electricbill" id="electricbill" class="form-control" accept=".jpg,.jpeg,.png, .pdf" required>
                                        <div class="image-preview mt-2" id="electricbill_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= TERMS & SUBMIT ================= --}}
                            <div class="form-section mt-5">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I declare that all information provided is true and correct to the best of my knowledge
                                            </label>
                                            <div class="invalid-feedback">
                                                You must accept the declaration
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-end">
                                            <button type="submit" id="submitBtn" class="btn btn-primary btn-lg px-5">
                                                <span id="btnText">Submit KYC</span>
                                                <div id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status"></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Accept Modal -->
<div class="modal fade acceptModal-box" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="acceptModalLabel">Verification Successfully</h5>
            </div>
            <div class="modal-body">
                <div class="modal-back-icon">
                    <img src="{{asset('admin/layout/assets/images/logo.svg')}}" alt="">
                </div>
                <div class="modal-tick-icon">
                    <svg viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg">
                        <g stroke="currentColor" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path class="circle"
                                d="M13 1C6.372583 1 1 6.372583 1 13s5.372583 12 12 12 12-5.372583 12-12S19.627417 1 13 1z" />
                            <path class="tick" d="M6.5 13.5L10 17 l8.808621-8.308621" />
                        </g>
                    </svg>
                </div>
                <p id="acceptDesc">Your KYC has been successfully .<strong>verified</strong></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--processing  Modal -->
<div class="modal fade" id="kycPendingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content kyc-modal text-center position-relative overflow-hidden">

            <!-- Background Logo -->
            <div class="kyc-bg-logo">
                <img src="{{ asset('admin/layout/assets/images/logo.svg') }}" alt="Logo">
            </div>

            <div class="modal-header border-0 justify-content-center">
                <h5 class="modal-title fw-semibold">
                    🔍 KYC Under Review
                </h5>
            </div>

            <div class="modal-body px-4 pb-4">
                <div class="spinner-border text-warning mb-3" role="status"></div>

                <p class="mb-1 fw-medium">
                    Your KYC is currently under verification.
                </p>
                <p class="text-muted small mb-0">
                    Please wait up to <strong>24 hours</strong>.
                    You will be notified once verification is complete.
                </p>
            </div>

            <div class="modal-footer border-0 justify-content-center">
                <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="kycRejectedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="kyc-bg-logo">
                <img src="{{ asset('admin/layout/assets/images/logo.svg') }}" alt="Logo">
            </div>

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">KYC Rejected</h5>
            </div>
            <div class="modal-body">
                <p>Your KYC was rejected.</p>
                <p>Please re-submit correct documents.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">Re-submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kycVerifiedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="kyc-bg-logo">
                <img src="{{ asset('admin/layout/assets/images/logo.svg') }}" alt="Logo">
            </div>

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">KYC Verified</h5>
            </div>
            <div class="modal-body">
                <p>🎉 Your KYC has been successfully verified.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" data-bs-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toast" class="toast align-items-center text-white border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>


@push('css')
<style>
.kyc-modal {
    border-radius: 14px;
    min-height: 280px;
}


.kyc-bg-logo img {
    max-width: 220px;
}

/* Ensure content stays above logo */
.kyc-modal>* {
    position: relative;
    z-index: 2;
}


.image-preview {
    min-height: 120px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.image-preview img {
    max-width: 100%;
    max-height: 100px;
    border-radius: 4px;
}

.file-preview {
    min-height: 60px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 10px;
    background: #f8f9fa;
}

.file-preview i {
    font-size: 24px;
    color: #dc3545;
}

.invalid-feedback {
    display: block;
}

.is-invalid {
    border-color: #dc3545 !important;
}
</style>
@endpush

@push('js')
<script>


const userKycStatus = {{ auth()->user()->user_kyc ?? 'null' }};
const hasKycRecord = {{ isset($kycdata) ? 'true' : 'false' }};

   document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Loaded - Aadhaar OTP Script');

    // Elements select karein
    const aadhaarInput = document.getElementById('adhar_number');
    const aadhaarError = document.getElementById('aadhaar_error');
    const otpInput = document.getElementById('otpInput');
    const otpError = document.getElementById('otp_error');
    const otpSection = document.getElementById('otpSection');
    const verifyOtpBtn = document.getElementById('verifyOtpBtn');
    const requestIdInput = document.getElementById('request_id');
    const hiddenAadhaar = document.getElementById('aadharno');

    // Debug: Check all elements
    console.log('Elements:', {
        aadhaarInput,
        aadhaarError,
        otpSection,
        verifyOtpBtn,
        requestIdInput,
        hiddenAadhaar
    });

    /* ================= EVENT DELEGATION FOR SEND OTP ================= */
    // Document pe event listener lagayein
    document.addEventListener('click', function(event) {
        // Check if clicked element is sendOtpBtn or its child
        const sendOtpBtn = event.target.closest('#sendOtpBtn');
        
        if (sendOtpBtn) {
            event.preventDefault();
            console.log('Send OTP button clicked via delegation');
            handleSendOtp();
        }
    });

    /* ================= CLEAR ERRORS ON INPUT ================= */
    if (aadhaarInput) {
        aadhaarInput.addEventListener('input', () => {
            if (aadhaarError) aadhaarError.textContent = '';
        });
    }

    if (otpInput) {
        otpInput.addEventListener('input', () => {
            if (otpError) otpError.textContent = '';
        });
    }

    /* ================= SEND OTP FUNCTION ================= */
    function handleSendOtp() {
        console.log('handleSendOtp called');
        
        if (!aadhaarInput) {
            console.error('Aadhaar input not found');
            return;
        }

        const aadhaar = aadhaarInput.value.trim();
        console.log('Aadhaar:', aadhaar);
        
        // Remove alert in production
        // alert(aadhaar);
        
        // ✅ DO NOTHING IF EMPTY
        if (aadhaar === '') {
            if (aadhaarError) aadhaarError.textContent = 'Please enter Aadhaar number';
            return;
        }

        // ✅ INVALID FORMAT
        if (!/^\d{12}$/.test(aadhaar)) {
            if (aadhaarError) aadhaarError.textContent = 'Please enter a valid 12-digit Aadhaar number';
            return;
        }

        // Find the button again for UI updates
        const sendOtpBtn = document.getElementById('sendOtpBtn');
        if (!sendOtpBtn) {
            console.error('Send OTP button not found');
            return;
        }

        // UI loading
        const originalText = sendOtpBtn.innerHTML;
        sendOtpBtn.disabled = true;
        sendOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
        
        if (aadhaarError) aadhaarError.textContent = '';

        fetch("{{ route('user.kyc.sendOtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                adhar_number: aadhaar
            })
        })
        .then(res => {
            console.log('Response status:', res.status);
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success === true) {
                if (otpSection) {
                    otpSection.classList.remove('d-none');
                    console.log('OTP section shown');
                }
                
                if (requestIdInput) {
                    requestIdInput.value = data.data?.request_id || '';
                    console.log('Request ID:', requestIdInput.value);
                }
                
                if (hiddenAadhaar) {
                    hiddenAadhaar.value = data.aadharno || aadhaar;
                    console.log('Hidden Aadhaar:', hiddenAadhaar.value);
                }
                
                if (aadhaarInput) {
                    aadhaarInput.readOnly = true;
                }
                
                // Success message
                if (aadhaarError) {
                    aadhaarError.innerHTML = '<span class="text-success">✓ OTP sent to your registered mobile</span>';
                    showToast( 'OTP sent to your registered mobile!', 'success');
                }
                
            } else {
                console.error('API error response:', data);
                if (aadhaarError) {
                    aadhaarError.textContent = data.message || 'Failed to send OTP. Please try again.';
                }
            }
        })
        .catch((error) => {
            console.error('Fetch error:', error);
            if (aadhaarError) {
                aadhaarError.textContent = 'Network error. Please check your connection.';
            }
        })
        .finally(() => {
            if (sendOtpBtn) {
                sendOtpBtn.disabled = false;
                sendOtpBtn.innerHTML = originalText;
            }
        });
    }

    /* ================= VERIFY OTP ================= */
    if (verifyOtpBtn) {
        verifyOtpBtn.addEventListener('click', function() {
            console.log('Verify OTP button clicked');
            
            if (!otpInput) {
                console.error('OTP input not found');
                return;
            }

            const otp = otpInput.value.trim();
            console.log('OTP:', otp);
            
            // ✅ DO NOTHING IF EMPTY
            if (otp === '') {
                if (otpError) otpError.textContent = 'Please enter OTP';
                return;
            }

            // ✅ INVALID FORMAT
            if (!/^\d{6}$/.test(otp)) {
                if (otpError) otpError.textContent = 'Please enter valid 6-digit OTP';
                return;
            }

            // UI loading
            const originalText = verifyOtpBtn.innerHTML;
            verifyOtpBtn.disabled = true;
            verifyOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verifying...';
            
            if (otpError) otpError.textContent = '';

            fetch("{{ route('user.kyc.verifyOtp') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    otp: otp,
                    requestid: requestIdInput ? requestIdInput.value : '',
                    aadharno: hiddenAadhaar ? hiddenAadhaar.value : ''
                })
            })
            .then(res => {
                console.log('Verify response status:', res.status);
                return res.json();
            })
            .then(data => {
                console.log('Verify response:', data);
                
                if (data.status === 'success') {
                    if (otpSection) {
                        otpSection.classList.add('d-none');
                    }
                    
                    if (aadhaarInput) {
                        aadhaarInput.readOnly = true;
                    }
                    
                    // Disable send OTP button
                    const sendOtpBtn = document.getElementById('sendOtpBtn');
                    if (sendOtpBtn) {
                        sendOtpBtn.disabled = true;
                    }
                    
                    // Remove existing badge
                    const existingBadge = document.querySelector('.aadhaar-verified-badge');
                    if (existingBadge) {
                        existingBadge.remove();
                    }
                    
                    // Add verification badge
                    if (aadhaarInput && aadhaarInput.parentElement) {
                        aadhaarInput.parentElement.insertAdjacentHTML('afterend', `
                            <div class="aadhaar-verified-badge mt-2">
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill me-1"></i> Aadhaar Verified
                                </span>
                            </div>
                        `);
                    }
                    
                    // Clear errors
                    if (aadhaarError) aadhaarError.textContent = '';
                    // if (otpError) otpError.innerHTML = '<span class="text-success">✓ Aadhaar verified successfully!</span>';
                    showToast('✓ Aadhaar verified successfully!', 'success');
                    
                } else {
                    if (otpError) {
                        otpError.textContent = data.message || 'Invalid OTP';
                    }
                }
            })
            .catch((error) => {
                console.error('Verify error:', error);
                if (otpError) {
                    otpError.textContent = 'Network error. Please try again.';
                }
            })
            .finally(() => {
                verifyOtpBtn.disabled = false;
                verifyOtpBtn.innerHTML = originalText;
            });
        });
    } else {
        console.log('Verify OTP button not found (will be available after OTP sent)');
    }

    // Alternative: Mutation Observer for dynamically added buttons
    if (!document.getElementById('sendOtpBtn')) {
        console.log('Send OTP button not found initially, setting up mutation observer');
        
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes && mutation.addedNodes.length > 0) {
                    const sendOtpBtn = document.getElementById('sendOtpBtn');
                    if (sendOtpBtn) {
                        console.log('Send OTP button dynamically added');
                        sendOtpBtn.addEventListener('click', handleSendOtp);
                        observer.disconnect(); // Stop observing once found
                    }
                }
            });
        });
        
        // Start observing the document body
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
});


const PDF_ICON = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQq1aZw8V35IO876xr_qje7N-8QqCxXRdWOSw&s";

document.addEventListener('DOMContentLoaded', function() {
        // Initialize toast
    const toastEl = document.getElementById('toast');
    const toast = toastEl ? new bootstrap.Toast(toastEl, {
        delay: 3000
    }) : null;

    // Show toast function
    function showToast(message, type = 'success') {
        if (!toastEl) return;

        const toastMessage = document.getElementById('toastMessage');
        toastEl.className = 'toast align-items-center text-white border-0';

        if (type === 'success') {
            toastEl.classList.add('bg-success');
        } else if (type === 'error') {
            toastEl.classList.add('bg-danger');
        } else if (type === 'warning') {
            toastEl.classList.add('bg-warning');
        }

        toastMessage.textContent = message;
        toast.show();
    }

    // Clear all errors
    function clearErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.style.display = 'none';
        });
    }

    // Show field error
    function showError(field, message) {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const errorDiv = input.nextElementSibling || input.parentElement.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            }
        }
    }

    // Image preview function
    function initImagePreview(inputId, previewId, isPdf = false) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (!input || !preview) return;

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            preview.innerHTML = '';

            if (!file) {
                preview.innerHTML = '<small class="text-muted">No file selected</small>';
                return;
            }

            if (isPdf || file.type === 'application/pdf') {
                preview.innerHTML = `
                            <div class="text-center">
                                <img src="${PDF_ICON}" class="img-thumbnail" style="max-height:120px;">
                                <div class="small text-muted mt-1">${file.name}</div>
                            </div>
                        `;
            } else if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                                <div class="text-center">
                                    <img src="${e.target.result}" class="img-thumbnail" style="max-height:120px;">
                                    <div class="small text-muted mt-1">${file.name}</div>
                                </div>
                            `;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<small class="text-danger">Invalid file type</small>';
            }
        });
    }

    // Initialize all image previews
    initImagePreview('adhar_front', 'adhar_front_preview');
    initImagePreview('adhar_back', 'adhar_back_preview');
    initImagePreview('pan_card', 'pan_card_preview');
    initImagePreview('chaque', 'chaque_preview');
    initImagePreview('shopphoto', 'shopphoto_preview');
    initImagePreview('electricbill', 'electricbill_preview');

    @if($user->account_type == 'business')
        initImagePreview('gst_img', 'gst_img_preview', true);
        initImagePreview('address_proof', 'address_proof_preview');
        @if($user->business_type != 'soleproprietorship')
        initImagePreview('company_pan_card', 'company_pan_card_preview');
        @endif
    @endif

    // IFSC Code validation (using vanilla JS)
    const ifscInput = document.getElementById('ifsc_code');
    if (ifscInput) {
        ifscInput.addEventListener('input', function() {
            const ifsc = this.value.trim().toUpperCase();
            this.value = ifsc;
            const bankNameInput = document.getElementById('bank_name');
            const ifscError = document.getElementById('ifsc_error');

            if (ifsc.length === 11) {
                if (bankNameInput) bankNameInput.value = 'Fetching...';
                if (ifscError) ifscError.textContent = '';

                // Using fetch API instead of jQuery
                fetch('https://ifsc.razorpay.com/' + ifsc)
                    .then(response => response.json())
                    .then(data => {
                        if (data.BANK && bankNameInput) {
                            bankNameInput.value = data.BANK;
                        } else {
                            if (bankNameInput) bankNameInput.value = '';
                            if (ifscError) ifscError.textContent = 'Invalid IFSC Code';
                        }
                    })
                    .catch(error => {
                        if (bankNameInput) bankNameInput.value = '';
                        if (ifscError) ifscError.textContent = 'Invalid IFSC Code';
                    });
            } else {
                if (bankNameInput) bankNameInput.value = '';
                if (ifscError) ifscError.textContent = '';
            }
        });
    }

    // Form submission (using vanilla JS)
    const kycForm = document.getElementById('kycForm');
    if (kycForm) {
        kycForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            clearErrors();

            // Validate terms
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                termsCheckbox.classList.add('is-invalid');
                showToast('Please accept the declaration', 'error');
                return;
            }

            // Show loading
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');

            if (submitBtn) submitBtn.disabled = true;
            if (btnText) btnText.textContent = 'Submitting...';
            if (btnSpinner) btnSpinner.classList.remove('d-none');

            try {
                const formData = new FormData(this);

                const response = await fetch("{{ route('user.kyc.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    showToast(data.message || 'KYC submitted successfully!', 'success');

                    // Redirect after delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Handle validation errors
                    if (response.status === 422 && data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showError(field, data.errors[field][0]);
                        });
                        showToast('Please fix the errors in the form', 'error');
                    } else {
                        showToast(data.message || 'Submission failed. Please try again.', 'error');
                    }
                }
            } catch (error) {
                console.error('Submission error:', error);
                showToast('Network error. Please check your connection and try again.', 'error');
            } finally {
                // Reset button
                if (submitBtn) submitBtn.disabled = false;
                if (btnText) btnText.textContent = 'Submit KYC';
                if (btnSpinner) btnSpinner.classList.add('d-none');
            }
        });
    }

    // Real-time validation
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = this.nextElementSibling || this.parentElement.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.textContent = '';
                errorDiv.style.display = 'none';
            }
        });
    });

    // Terms checkbox validation
    const termsCheckbox = document.getElementById('terms');
    if (termsCheckbox) {
        termsCheckbox.addEventListener('change', function() {
            this.classList.remove('is-invalid');
        });
    }
});


// KYC STATUS MODEL
document.addEventListener('DOMContentLoaded', function () {

    const kycForm = document.getElementById('kycForm');
    if (!kycForm) return;

    let modalId = null;

    if (!hasKycRecord) {
        kycForm.classList.remove('d-none');
        return;
    }

    if (userKycStatus === 0) {
        modalId = 'kycPendingModal';
    } else if (userKycStatus === 1) {
        modalId = 'kycVerifiedModal';
    } else if (userKycStatus === 2) {
        modalId = 'kycRejectedModal';
    }

    if (modalId) {
        kycForm.classList.add('d-none');
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    } else {
        kycForm.classList.remove('d-none');
    }
});

</script>
@endpush


@endsection