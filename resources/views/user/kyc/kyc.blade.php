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
                        <b class="text-success">{{ $user->account_type }}</b>
                    </p>
                </div>

                {{-- ================= SHOW FORM ONLY IF UNVERIFIED / REJECTED ================= --}}
                @if(in_array($kycStatus, [0, 3]))

                    <div class="card-body">
                        <form id="kycForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="account_type" value="{{ $user->account_type }}">

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
                                    <input type="text" name="account_number" class="form-control" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Account Holder Name</label>
                                    <input type="text" name="account_name" class="form-control" required>
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
                                            placeholder="Enter 12 digit Aadhaar" maxlength="12" required>
                                        <button type="button" id="sendOtpBtn" class="btn btn-sm btn-outline-primary">
                                            Send OTP
                                        </button>
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
                                    <input type="text" name="pan_number" id="pan_number" class="form-control" required>
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
                                    <div class="col-md-6 mb-3">
                                        <label>GST Number</label>
                                        <input type="text" name="gst" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>GST Certificate (PDF)</label>
                                        <input type="file" name="gst_img" class="form-control" accept=".pdf" required>
                                        <div class="file-preview mt-2" id="gst_img_preview">
                                            <small class="text-muted">No file selected</small>
                                        </div>
                                    </div>

                                    @if($user->business_type != 'soleproprietorship')
                                        <div class="col-md-6 mb-3">
                                            <label>Company PAN</label>
                                            <input type="file" name="company_pan_card" class="form-control" accept=".jpg,.jpeg,.png">
                                            <div class="image-preview mt-2" id="company_pan_card_preview">
                                                <small class="text-muted">No image selected</small>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 mb-3">
                                        <label>Address Proof</label>
                                        <input type="file" name="address_proof" class="form-control" accept=".jpg,.jpeg,.png"
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
                                        accept=".jpg,.jpeg,.png" required>
                                    <div class="image-preview mt-2" id="shopphoto_preview">
                                        <small class="text-muted">No image selected</small>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Electricity Bill</label>
                                    <input type="file" name="electricbill" id="electricbill" class="form-control"
                                        accept=".jpg,.jpeg,.png" required>
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

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="toast" class="toast align-items-center text-white border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const PDF_ICON = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQq1aZw8V35IO876xr_qje7N-8QqCxXRdWOSw&s";
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize toast
            const toastEl = document.getElementById('toast');
            const toast = new bootstrap.Toast(toastEl, { delay: 3000 });

            // Show toast function
            function showToast(message, type = 'success') {
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

            // IFSC Code validation
            $('#ifsc_code').on('input', function () {
                const ifsc = $(this).val().trim().toUpperCase();
                $(this).val(ifsc);

                if (ifsc.length === 11) {
                    $('#bank_name').val('Fetching...');
                    $.ajax({
                        url: 'https://ifsc.razorpay.com/' + ifsc,
                        type: 'GET',
                        success: function (res) {
                            if (res.BANK) {
                                $('#bank_name').val(res.BANK);
                                $('#ifsc_error').text('');
                            } else {
                                $('#bank_name').val('');
                                $('#ifsc_error').text('Invalid IFSC Code');
                            }
                        },
                        error: function () {
                            $('#bank_name').val('');
                            $('#ifsc_error').text('Invalid IFSC Code');
                        }
                    });
                } else {
                    $('#bank_name').val('');
                    $('#ifsc_error').text('');
                }
            });

            // Aadhaar OTP functionality
            $('#sendOtpBtn').on('click', function () {
                const aadhaar = $('#adhar_number').val().trim();

                if (!/^\d{12}$/.test(aadhaar)) {
                    $('#aadhaar_error').text('Please enter a valid 12-digit Aadhaar number');
                    return;
                }

                $('#sendOtpBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Sending...');
                $('#aadhaar_error').text('');

                $.ajax({
                    url: "{{ route('user.kyc.sendOtp') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        adhar_number: aadhaar
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#request_id').val(response.data.request_id);
                            $('#otpSection').removeClass('d-none');
                            $('#adhar_number').prop('readonly', true);
                            showToast('OTP sent successfully to your registered mobile number', 'success');
                        } else {
                            $('#aadhaar_error').text(response.message || 'Failed to send OTP');
                            showToast('Failed to send OTP', 'error');
                        }
                    },
                    error: function (xhr) {
                        $('#aadhaar_error').text('Error sending OTP. Please try again.');
                        showToast('Network error. Please try again.', 'error');
                    },
                    complete: function () {
                        $('#sendOtpBtn').prop('disabled', false).html('Send OTP');
                    }
                });
            });

            // Verify OTP
            $('#verifyOtpBtn').on('click', function () {
                const otp = $('#otpInput').val().trim();

                if (!/^\d{6}$/.test(otp)) {
                    $('#otp_error').text('Please enter a valid 6-digit OTP');
                    return;
                }

                $('#verifyOtpBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Verifying...');
                $('#otp_error').text('');

                $.ajax({
                    url: "{{ route('user.kyc.verifyOtp') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        otp: otp,
                        requestid: $('#request_id').val()
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#otpSection').addClass('d-none');
                            $('#adhar_number').prop('readonly', true);
                            $('#sendOtpBtn').prop('disabled', true);
                            showToast('Aadhaar verified successfully!', 'success');
                        } else {
                            $('#otp_error').text(response.message || 'Invalid OTP');
                            showToast('Invalid OTP. Please try again.', 'error');
                        }
                    },
                    error: function (xhr) {
                        $('#otp_error').text('Error verifying OTP. Please try again.');
                        showToast('Network error. Please try again.', 'error');
                    },
                    complete: function () {
                        $('#verifyOtpBtn').prop('disabled', false).html('Verify');
                    }
                });
            });

            // Form submission
            $('#kycForm').on('submit', async function (e) {
                e.preventDefault();

                clearErrors();

                // Validate terms
                if (!document.getElementById('terms').checked) {
                    document.getElementById('terms').classList.add('is-invalid');
                    showToast('Please accept the declaration', 'error');
                    return;
                }

                // Show loading
                const submitBtn = $('#submitBtn');
                const btnText = $('#btnText');
                const btnSpinner = $('#btnSpinner');

                submitBtn.prop('disabled', true);
                btnText.text('Submitting...');
                btnSpinner.removeClass('d-none');

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
                    submitBtn.prop('disabled', false);
                    btnText.text('Submit KYC');
                    btnSpinner.addClass('d-none');
                }
            });

            // Real-time validation
            $('input, select, textarea').on('input change', function () {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('').hide();
            });

            // Terms checkbox validation
            $('#terms').on('change', function () {
                $(this).removeClass('is-invalid');
            });
        });
    </script>
@endpush