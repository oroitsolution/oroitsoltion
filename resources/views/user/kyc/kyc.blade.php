@extends('userlayout.app')
@section('title', 'KYC Verification || ORO IT SOLUTION')
@section('content')

    <div class="container-fluid">
        <section class="section dashboard">
            <div class="card mb-3">

                {{-- ================= KYC STATUS HEADER ================= --}}
                @php
                    $kycStatus = Auth::user()->user_kyc;
                    $user = Auth::user();
                @endphp

                <div class="card-header">
                    <h5>KYC Verification</h5>

                    @if($kycStatus == 0)
                        <span class="badge bg-warning">Unverified</span>
                    @elseif($kycStatus == 1)
                        <span class="badge bg-primary">Pending</span>
                    @elseif($kycStatus == 2)
                        <span class="badge bg-success">Verified</span>
                    @elseif($kycStatus == 3)
                        <span class="badge bg-danger">Rejected</span>
                    @endif

                    <p class="mt-2">
                        Account Type:
                        <b class="text-success">{{ strtoupper($user->account_type) }}</b>
                    </p>
                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Important:</strong> Maximum file size allowed is <strong>2MB</strong> per file.
                        Supported formats: <strong>JPG, JPEG, PNG, PDF</strong>.
                        <br>
                        <strong>Note:</strong> Please verify Aadhaar number first.
                        
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                        </button>
                    </div>

                </div>



                {{-- ================= SHOW FORM ONLY IF UNVERIFIED / REJECTED ================= --}}
                @if(in_array($kycStatus, [0, 3]))

                    <div class="card-body">
                        <form id="kycForm" method="POST" class = "kyc-form d-none" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="account_type" id = "account_type" value="{{ strtoupper($user->account_type) }}">

                            {{-- ================= BASIC DETAILS ================= --}}
                            <h6 class="mb-3 text-primary">Basic Details</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control" value="{{ $user->mobile_number }}" readonly>
                                </div>
                            </div>

                            <hr>

                            {{-- ================= BANK DETAILS ================= --}}
                            <h6 class="mb-3 text-primary">Bank Details</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>IFSC Code</label>
                                    <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" required>
                                    <small id="ifsc_error" class="text-danger"></small>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Bank Name</label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Account Number</label>
                                    <input type="text" name="account_number" id  ="account_number" class="form-control" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Account Holder Name</label>
                                    <input type="text" name="account_name" id  ="account_name" class="form-control" required>
                                </div>
                            </div>

                            <hr>

                            {{-- ================= AADHAAR DETAILS ================= --}}
                            <h6 class="mb-3 text-primary">Aadhaar Details</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Aadhaar Front</label>
                                    <input type="file" name="adhar_front" id="adhar_front" class="form-control"
                                        accept=".jpg,.jpeg,.png" required>
                                    <div class="image-preview mt-2" id="adhar_front_preview">
                                        <small class="text-muted">No image selected</small>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Aadhaar Back</label>
                                    <input type="file" name="adhar_back" id="adhar_back" class="form-control"
                                        accept=".jpg,.jpeg,.png" required>
                                    <div class="image-preview mt-2" id="adhar_back_preview">
                                        <small class="text-muted">No image selected</small>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="adhar_number">Aadhaar Number</label>
                                    <div class="input-group">
                                        <input type="text" name="adhar_number" id="adhar_number" class="form-control"
                                            placeholder="Enter 12 digit Aadhaar" maxlength="12"  required value="{{ $kycdata->adhar_number ?? '' }}"
       {{ !empty($kycdata->adhar_number) ? 'readonly' : '' }}>
                                        @if(!$kycdata->adhar_number)
                                            <button type="button" id="sendOtpBtn" class="btn btn-sm btn-outline-primary">
                                                Send OTP
                                            </button>
                                        @endif


                                    </div>
                                    <small id="aadhaar_error" class="text-danger"></small>

                                    <!-- OTP Section -->
                                    <div class="otp-section mt-2 d-none" id="otpSection">
                                      
                                        <div class="input-group">
                                            <input type="text" name="otp" id="otpInput" class="form-control"
                                                placeholder="Enter OTP" maxlength="6">
                                            <button type="button" id="verifyOtpBtn" class="btn btn-sm btn-success">
                                                Verify
                                            </button>
                                        </div>
                                        <input type="hidden" name="request_id" id="request_id">
                                        <input type="hidden"  name="aadharno" id="aadharno">
                                        <small id="otp_error" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- ================= PAN DETAILS ================= --}}
                            <h6 class="mb-3 text-primary">PAN Details</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>PAN Number</label>
                                    <input type="text" name="pan_number" id="pan_number" class="form-control" required value="{{ $kycdata->pan_number ?? '' }}"
       {{ !empty($kycdata->pan_number) ? 'readonly' : '' }} >
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>PAN Card</label>
                                    <input type="file" name="pan_card" id="pan_card" class="form-control"
                                        accept=".jpg,.jpeg,.png" required>
                                    <div class="image-preview mt-2" id="pan_card_preview">
                                        <small class="text-muted">No image selected</small>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Cancelled Cheque</label>
                                    <input type="file" name="chaque" id="chaque" class="form-control" accept=".jpg,.jpeg,.png"
                                        required>
                                    <div class="image-preview mt-2" id="chaque_preview">
                                        <small class="text-muted">No image selected</small>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- ================= BUSINESS DETAILS ================= --}}
                            @if($user->account_type == 'business')
                                <h6 class="mb-3 text-primary">Business Details</h6>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label>GST Number</label>
                                        <input type="text" name="gst" id = "gst" class="form-control" required>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>CIN Number</label>
                                        <input type="text" name="cin_number" id = "cin_number" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>GST Certificate (PDF)</label>
                                        <input type="file" id= "gst_img" name="gst_img" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        <div class="file-preview mt-2" id="gst_img_preview">
                                            <small class="text-muted">No file selected</small>
                                        </div>
                                    </div>

                                    @if($user->business_type != 'soleproprietorship')
                                        <div class="col-md-6 mb-3">
                                            <label>Company PAN</label>
                                            <input type="file" name="company_pan_card" id= "company_pan_card" class="form-control" accept=".jpg,.jpeg,.png, .pdf">
                                            <div class="image-preview mt-2" id="company_pan_card_preview">
                                                <small class="text-muted">No image selected</small>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 mb-3">
                                        <label>Company Address Proof</label>
                                        <input type="file" name="address_proof" id = "address_proof" class="form-control" accept=".jpg,.jpeg,.png, .pdf"
                                            required>
                                        <div class="image-preview mt-2" id="address_proof_preview">
                                            <small class="text-muted">No image selected</small>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr>

                            {{-- ================= SHOP & ELECTRICITY ================= --}}
                            <h6 class="mb-3 text-primary">Shop & Address Proof</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Shop Photo</label>
                                    <input type="file" name="shopphoto" id="shopphoto" class="form-control"
                                        accept=".jpg,.jpeg,.png, .pdf" required>
                                    <div class="image-preview mt-2" id="shopphoto_preview">
                                        <small class="text-muted">No image selected</small>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Electricity Bill</label>
                                    <input type="file" name="electricbill" id="electricbill" class="form-control"
                                       accept=".jpg,.jpeg,.png, .pdf" required>
                                    <div class="image-preview mt-2" id="electricbill_preview">
                                        <small class="text-muted">No image selected</small>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= TERMS & SUBMIT ================= --}}
                            <div class="row mt-4">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I declare that all information provided is true and correct to the best of my
                                            knowledge
                                        </label>
                                        <div class="invalid-feedback">
                                            You must accept the declaration
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="text-end">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-lg">
                                            <span id="btnText">Submit KYC</span>
                                            <div id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- Accept Modal -->
    <div class="modal fade acceptModal-box" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
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
    <div class="modal fade" id="kycPendingModal" tabindex="-1"
        data-bs-backdrop="static" data-bs-keyboard="false">
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
        .kyc-modal > * {
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
        const hasKycRecord = {{ $kycdata ? 'true' : 'false' }};

        const PDF_ICON = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQq1aZw8V35IO876xr_qje7N-8QqCxXRdWOSw&s";
        
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize toast
            const toastEl = document.getElementById('toast');
            const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 3000 }) : null;

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

                input.addEventListener('change', function (e) {
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
                        reader.onload = function (e) {
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
                ifscInput.addEventListener('input', function () {
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

            // Aadhaar OTP functionality (using vanilla JS)
            const sendOtpBtn = document.getElementById('sendOtpBtn');
            if (sendOtpBtn) {
                sendOtpBtn.addEventListener('click', function () {
                    const aadhaarInput = document.getElementById('adhar_number');
                    const aadhaar = aadhaarInput ? aadhaarInput.value.trim() : '';
                    const aadhaarError = document.getElementById('aadhaar_error');
                    
                    if (!/^\d{12}$/.test(aadhaar)) {
                        if (aadhaarError) aadhaarError.textContent = 'Please enter a valid 12-digit Aadhaar number';
                        return;
                    }

                    this.disabled = true;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Sending...';
                    if (aadhaarError) aadhaarError.textContent = '';

                    // Using fetch API
                    fetch("{{ route('user.kyc.sendOtp') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            adhar_number: aadhaar
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success === true && data.status === 'SUCCESS') {
                            if (data.otpbox === 'SHW990') {
                                // Show OTP Section
                                const otpSection = document.getElementById('otpSection');
                                if (otpSection) {
                                    otpSection.classList.remove('d-none');
                                }
                                
                                // Store request id
                                const requestIdInput = document.getElementById('request_id');
                                if (requestIdInput && data.data?.request_id) {
                                    requestIdInput.value = data.data.request_id;
                                }

                                    const aadharNoInput = document.getElementById('aadharno'); // Hidden input
                                    if (data.aadharno) {
                                        // Store in hidden input
                                        if (aadharNoInput) {
                                            aadharNoInput.value = data.aadharno;
                                            console.log('Aadhaar stored in hidden field:', data.aadharno);
                                        }
                                        
                                        // Also update the visible input
                                        if (aadhaarInput) {
                                            aadhaarInput.value = data.aadharno;
                                            aadhaarInput.readOnly = true; // Make read-only
                                        }
                                        
                                        // Show success message with masked Aadhaar
                                        const maskedAadhaar = data.aadharno.replace(/(\d{4})(\d{4})(\d{4})/, 'XXXX-XXXX-$3');
                                        showToast(`OTP sent to Aadhaar: ${maskedAadhaar}`, 'success');
                                    }
                                    
                               
                                } else {
                                    showToast('OTP not required for this request', 'info');
                                }
                        } else {
                            if (aadhaarError) {
                                aadhaarError.textContent = data.message || 'Failed to send OTP';
                            }
                            showToast('Failed to send OTP', 'error');
                        }
                    })
                    .catch(error => {
                        if (aadhaarError) {
                            aadhaarError.textContent = 'Error sending OTP. Please try again.';
                        }
                        showToast('Network error. Please try again.', 'error');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = 'Send OTP';
                    });
                });
            }

            // Verify OTP (using vanilla JS)
           const verifyOtpBtn = document.getElementById('verifyOtpBtn');
            if (verifyOtpBtn) {
                verifyOtpBtn.addEventListener('click', function () {
                    const otpInput = document.getElementById('otpInput');
                    const otp = otpInput ? otpInput.value.trim() : '';
                    const otpError = document.getElementById('otp_error');
                    const requestIdInput = document.getElementById('request_id');
                    const aadhaarInput = document.getElementById('aadharno'); // Hidden field
                    
                    if (!/^\d{6}$/.test(otp)) {
                        if (otpError) otpError.textContent = 'Please enter a valid 6-digit OTP';
                        return;
                    }

                    this.disabled = true;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Verifying...';
                    if (otpError) otpError.textContent = '';

                    // Prepare request data
                    const requestData = {
                        otp: otp,
                        requestid: requestIdInput ? requestIdInput.value : ''
                    };

                    // Add aadharno for test cases (981900)
                    const aadhaarValue = aadhaarInput ? aadhaarInput.value : '';
                    if (aadhaarValue) {
                        requestData.aadharno = aadhaarValue;
                    }

                    fetch("{{ route('user.kyc.verifyOtp') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(requestData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Hide OTP section
                            const otpSection = document.getElementById('otpSection');
                            const adharNumberInput = document.getElementById('adhar_number');
                            const sendOtpBtn = document.getElementById('sendOtpBtn');
                            
                            if (otpSection) otpSection.classList.add('d-none');
                            if (adharNumberInput) {
                                adharNumberInput.readOnly = true;
                                // Update with verified Aadhaar if returned
                                if (data.data?.aadhaar_number) {
                                    adharNumberInput.value = data.data.aadhaar_number;
                                }
                            }
                            if (sendOtpBtn) sendOtpBtn.disabled = true;
                            
                            // Show success message with masked Aadhaar
                            const aadhaarNum = data.data?.aadhaar_number || aadhaarValue;
                            if (aadhaarNum) {
                                const masked = aadhaarNum.replace(/(\d{4})(\d{4})(\d{4})/, 'XXXX-XXXX-$3');
                                showToast(`Aadhaar ${masked} verified and saved successfully!`, 'success');
                            } else {
                                showToast('OTP verified successfully!', 'success');
                            }
                            
                            // Optional: Show verified badge
                            const parentDiv = document.getElementById('adhar_number').parentNode;
                            parentDiv.innerHTML += `
                                <div class="mt-1">
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle-fill"></i> Aadhaar Verified
                                    </span>
                                    <small class="text-muted d-block">${data.data?.full_name || ''}</small>
                                </div>
                            `;
                            
                            // Log KYC ID for reference
                            if (data.data?.kyc_id) {
                                console.log('KYC Record ID:', data.data.kyc_id);
                            }
                            
                        } else {
                            if (otpError) {
                                otpError.textContent = data.message || 'Invalid OTP';
                            }
                            showToast(data.message || 'OTP verification failed', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('OTP Verification Error:', error);
                        if (otpError) {
                            otpError.textContent = 'Error verifying OTP. Please try again.';
                        }
                        showToast('Network error. Please try again.', 'error');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = 'Verify';
                    });
                });
            }

            // Form submission (using vanilla JS)
            const kycForm = document.getElementById('kycForm');
            if (kycForm) {
                kycForm.addEventListener('submit', async function (e) {
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
                element.addEventListener('input', function () {
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
                termsCheckbox.addEventListener('change', function () {
                    this.classList.remove('is-invalid');
                });
            }
        });

        
        // KYC STATUS MODEL
        document.addEventListener('DOMContentLoaded', function () {

            const kycForm = document.getElementById('kycForm');
            if (!hasKycRecord) {
                  kycForm.classList.remove('d-none');
                return; // Show normal KYC form
            }
            let dnon = 'd-none';
            let modalId = null;

            if (userKycStatus === 0) {
                modalId = 'kycPendingModal';
            } 
            else if (userKycStatus === 1) {
                modalId = 'kycVerifiedModal';
            } 
            else if (userKycStatus === 2) {
                modalId = 'kycRejectedModal';
            }

              if ([0, 1, 2].includes(userKycStatus)) {
                    kycForm.classList.add('d-none');
                } else {
                    kycForm.classList.remove('d-none');
                }

            if (modalId) {
                const modal = new bootstrap.Modal(document.getElementById(modalId));
                modal.show();
            }
        });

    </script>
@endpush


@endsection