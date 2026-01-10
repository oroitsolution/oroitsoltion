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
                    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profile
                    </button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Company Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="company-banner position-relative"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
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
                                        class="rounded-circle border border-3 border-primary" width="80" height="80">
                                    <span
                                        class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white">
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
                                            <p class="mb-0 fw-semibold">{{ $user->address ?? 'No address provided' }}
                                            </p>
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
                                                <span
                                                    class="text-muted">XXXXXX</span>{{ substr($kycdata->account_number, -4) }}
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
                                Bank details are not yet configured. Please update your bank information for
                                transactions.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($additionbank->count())
                <div class="col-12 mt-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4 d-flex justify-content-between">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-bank text-success me-2"></i>Additional Bank Accounts
                            </h5>
                        </div>

                        <div class="card-body p-4">
                            @foreach($additionbank as $bank)
                            <div class="row g-3 mb-3 position-relative">

                                <!-- Status + Delete -->
                                <div class="col-12 text-end">
                                    {{-- Status --}}
                                    @if($bank->status == 1)
                                    <span class="badge bg-success">Active</span>
                                    @elseif($bank->status == 2)
                                    <span class="badge bg-danger">Rejected</span>
                                    @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="#" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this bank account?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger ms-2" title="Delete Bank Account">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">Bank Name</label>
                                            <p class="mb-0 fw-semibold">{{ $bank->bank_name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">IFSC Code</label>
                                            <p class="mb-0 fw-semibold">{{ $bank->ifsc_code }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">Account Holder Name</label>
                                            <p class="mb-0 fw-semibold">{{ $bank->account_holder_name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body">
                                            <label class="form-label text-muted small mb-2">Account Number</label>
                                            <p class="mb-0 fw-semibold">
                                                <span
                                                    class="text-muted">XXXXXX</span>{{ substr($bank->account_number, -4) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!$loop->last)
                            <hr class="my-3">
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif




                <!-- Addition Data -->
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-bank text-primary me-2"></i>Additional Bank Account Details
                        </h5>

                        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse"
                            data-bs-target="#addMoreBankForm">
                            <i class="bi bi-plus-lg me-1"></i> Add More
                        </button>
                    </div>
                </div>

                <!-- Add More Bank Account Form -->
                <div class="collapse mt-4" id="addMoreBankForm">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <strong>Add New Bank Account</strong>
                        </div>

                        <div class="card-body">
                            <form id="addMoreBankAccountForm" enctype="multipart/form-data">
                                @csrf

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">IFSC Code</label>
                                        <input type="text" name="ifsc_code" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account Holder Name</label>
                                        <input type="text" name="account_name" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" name="account_number" class="form-control" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Aadhar Front</label>
                                        <input type="file" name="aadhar_front" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Aadhar Back</label>
                                        <input type="file" name="aadhar_back" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">PAN Card</label>
                                        <input type="file" name="pan_card" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">GST</label>
                                        <input type="file" name="gst" class="form-control">
                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-save me-1"></i> Save Bank Account
                                        </button>
                                    </div>

                                </div>
                            </form>
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
                                <input type="text" class="form-control" id="ipaddress" name="ipaddress"
                                    value="{{ $clintdata->ipaddress ?? 'Not configured' }}"
                                    placeholder="Enter IP address">
                                <button class="btn btn-outline-info" id="ipupdate" type="button"
                                    data-uid="{{ $user->id }}">
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
                                    <input type="text" class="form-control" id="payin_url" name="payin_url"
                                        value="{{ $clintdata->payin_url ?? 'Not configured' }}">
                                    <button class="btn btn-outline-success" id="payinupdate" type="button"
                                        data-uid="{{ $user->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Payout Callback</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="payout_url" name="payout_url"
                                        value="{{ $clintdata->payout_url ?? 'Not configured' }}">
                                    <button class="btn btn-outline-warning" id="payoutupdate" type="button"
                                        data-uid="{{ $user->id }}">
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
                                                data-bs-toggle="tooltip" title="Copy Client ID">
                                                <i class="bi bi-copy small"></i>
                                            </button>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <code
                                                class="small me-2">{{ $clintdata->client_id ?? 'ASD998776**897' }}</code>
                                        </div>
                                    </div>

                                    <!-- Secret Key -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <span class="small text-muted">Secret Key</span>
                                            <button class="btn btn-link btn-sm text-decoration-none ms-2 copy-btn"
                                                data-text="{{ $clintdata->secret_id ?? 'OROIT-76***997' }}"
                                                data-bs-toggle="tooltip" title="Copy Secret Key">
                                                <i class="bi bi-copy small"></i>
                                            </button>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <code
                                                class="small me-2">{{ $clintdata->secret_id ?? 'OROIT-76***997' }} </code>
                                        </div>
                                        <button id="regenSecretBtn"
                                            class="btn btn-outline-primary btn-sm p-1 rounded-circle"
                                            data-user-id="{{ $user->id }}">
                                            <i class="bi bi-arrow-clockwise" style="font-size: 12px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <div>
                                <span
                                    class="badge {{ $kycdata ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
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
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Member Since</span>
                                <span class="fw-semibold">{{ date('M d, Y', strtotime($user->created_at)) }}</span>
                            </div>
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Last Login</span>
                                <span class="fw-semibold">{{ date('M d, Y H:i') }}</span>
                            </div>
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Account Status</span>
                                <span class="badge bg-success">Active</span>
                            </div>
                            <div
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span class="text-muted">Verification</span>
                                <span class="badge bg-success">Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Change Password -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lock text-danger me-2"></i>Change Password
                    </h5>
                    <p class="text-muted small mb-0 mt-2">
                        Update your account password regularly for security
                    </p>
                </div>

                <div class="card-body p-4">
                    <form id="changePasswordForm">

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label class="form-label small text-muted">Current Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="password" class="form-control" id="current_password"
                                    placeholder="Enter current password">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label class="form-label small text-muted">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="new_password"
                                    placeholder="Enter new password">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">
                                Password must be at least 8 characters with uppercase, lowercase, number and special
                                character.
                            </small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label small text-muted">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-check-circle"></i>
                                </span>
                                <input type="password" class="form-control" id="confirm_password"
                                    placeholder="Re-enter new password">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <button type="button" data-userid="{{ $user->id }}" id="updatePasswordBtn"
                            class="btn btn-danger w-100">
                            <i class="bi bi-arrow-repeat me-2"></i>Update Password
                        </button>
                    </form>
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

<div id="printArea" class="d-none">
    <h3 style="text-align:center;">User Profile</h3>
    <hr>

    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->mobile_number }}</p>

    <p><strong>Address:</strong> {{ $user->address }}</p>
    <p><strong>State:</strong> {{ $user->state }}</p>
    <p><strong>City:</strong> {{ $user->city }}</p>
    <p><strong>Pincode:</strong> {{ $user->pincode }}</p>

    <hr>

    <p>
        <strong>Bank Account No:</strong>
        XXXXXX{{ substr($kycdata->account_number ?? '', -4) }}

        <strong>IFSC code :</strong>
        {{ $kycdata->ifsc_code }} - {{$kycdata->bank_name}}
        <strong>Bank name :</strong>
        {{ $kycdata->account_name }}
    </p>
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
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
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

    // Password Start  
    $(document).on('click', '.toggle-password', function() {
        let input = $(this).closest('.input-group').find('input');
        let icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });

    // password End

    document.getElementById('printProfile').addEventListener('click', function() {

        const printContents = document.getElementById('printArea').innerHTML;
        const printWindow = window.open('', '', 'height=600,width=800');

        printWindow.document.write(`
        <html>
            <head>
                <title>Print Profile</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h3 { margin-bottom: 10px; }
                    p { margin: 6px 0; font-size: 14px; }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `);

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    });


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
                    tooltipInstance.setContent({
                        '.tooltip-inner': 'Copied!'
                    });
                    tooltipInstance.show();
                }

                // Revert after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    if (tooltipInstance) {
                        const originalTitle = this.getAttribute('title') || this
                            .getAttribute('data-original-title');
                        tooltipInstance.setContent({
                            '.tooltip-inner': originalTitle
                        });
                    }
                }, 2000);

            } catch (err) {
                console.error('Failed to copy:', err);

                // Show error feedback
                this.innerHTML = '<i class="bi bi-x text-danger small"></i>';

                if (tooltipInstance) {
                    tooltipInstance.setContent({
                        '.tooltip-inner': 'Failed to copy'
                    });
                    tooltipInstance.show();
                }

                // Revert after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    if (tooltipInstance) {
                        const originalTitle = this.getAttribute('title') || this
                            .getAttribute('data-original-title');
                        tooltipInstance.setContent({
                            '.tooltip-inner': originalTitle
                        });
                    }
                }, 2000);
            }
        });
    });
});

//--------------------Update Secret KEY---------------------------//

$(document).on('click', '#regenSecretBtn', function() {

    let userId = $(this).data('user-id');
    let btn = $(this);

    btn.prop('disabled', true);
    btn.find('i').addClass('spinner-border spinner-border-sm');

    $.ajax({
        url: "{{ route('user.regenerate.secret') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            user_id: userId
        },
        success: function(res) {
            if (res.success) {
                toastr.success(res.message || 'Updated successfully');
            } else {
                toastr.error(res.message || 'Something went wrong');
            }
        },
        error: function() {
            toastr.error('Something went wrong!');
        },
        complete: function() {
            btn.prop('disabled', false);
            btn.find('i').removeClass('spinner-border spinner-border-sm');
        }
    });
});


// update password Start 

$('#updatePasswordBtn').on('click', function() {

    let btn = $(this);
    let currentPassword = $('#current_password').val();
    let newPassword = $('#new_password').val();
    let confirmPassword = $('#confirm_password').val();
    let userId = $(this).data('userid');
    // 🔴 Password match check
    if (newPassword !== confirmPassword) {
        toastr.error('Your New password and confirm password do not match');
        return; // stop ajax
    }

    btn.prop('disabled', true).text('Updating...');

    $.ajax({
        url: "{{ route('user.change.password') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            userid: userId,
            current_password: currentPassword,
            new_password: newPassword,
            new_password_confirmation: confirmPassword
        },
        success: function(res) {
            btn.prop('disabled', false)
                .html('<i class="bi bi-arrow-repeat me-2"></i>Update Password');

            toastr.success(res.message || 'Password updated successfully');

            $('#changePasswordForm')[0].reset();
        },
        error: function(xhr) {
            btn.prop('disabled', false)
                .html('<i class="bi bi-arrow-repeat me-2"></i>Update Password');

            if (xhr.responseJSON?.errors) {
                Object.values(xhr.responseJSON.errors).forEach(err => {
                    toastr.error(err[0]);
                });
            } else {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong');
            }
        }
    });
});

// Update password End 

// Update Clint ID 
    document.addEventListener('click', function (e) {

        const btn = e.target.closest('button[id$="update"]');
        if (!btn) return;

        const userId = btn.dataset.uid;

        let field = '';
        let value = '';

        if (btn.id === 'ipupdate') {
            field = 'ipaddress';
            value = document.getElementById('ipaddress').value;
        }

        if (btn.id === 'payinupdate') {
            field = 'payin_url';
            value = document.getElementById('payin_url').value;
        }

        if (btn.id === 'payoutupdate') {
            field = 'payout_url';
            value = document.getElementById('payout_url').value;
        }

        fetch("{{ route('user.client.settings.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                user_id: userId,
                field: field,
                value: value
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('HTTP error');
            return response.json();
        })
        .then(resp => {
            if (resp.success) {
                toastr.success(resp.message || 'Updated successfully');
                setTimeout(() => location.reload(), 800);
            } else {
                toastr.error(resp.message || 'Update failed');
            }
        })
        .catch(error => {
            console.error(error);
            toastr.error('Server error');
        });
    });
// Update IP And Web Hook 

// Add Addition data Ajax 

$('#addMoreBankAccountForm').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('user.additional.bank.store') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            toastr.success(res.message || 'Bank account added successfully');
            location.reload();
        },
        error: function(xhr) {
            if (xhr.responseJSON?.errors) {
                Object.values(xhr.responseJSON.errors).forEach(err => {
                    toastr.error(err[0]);
                });
            } else {
                toastr.error('Something went wrong');
            }
        }
    });
});

// Addition Data 
</script>
@endpush