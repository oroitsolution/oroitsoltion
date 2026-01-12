@extends('adminlayouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow">

                <!-- Header -->
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="mdi mdi-account-check-outline me-2"></i> KYC Management
                    </h4>
                </div>

                <!-- Body -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-dark border-bottom">
                                <tr class="text-center">
                                    <th width="60">#</th>
                                    <th>User</th>
                                    <th>Bank A/C</th>
                                    <th>Account Type</th>
                                    <th width="120">Status</th>
                                    <th width="180">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($kycdata as $kyc)
                                <tr>
                                    <!-- ID -->
                                    <td class="text-center fw-bold text-primary">
                                        {{ $kyc->id }}
                                    </td>

                                    <!-- User -->
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $kyc->user->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-muted small">
                                            <i class="mdi mdi-email-outline"></i> {{ $kyc->user->email ?? 'N/A' }} <br>
                                            <i class="mdi mdi-phone-outline"></i> {{ $kyc->user->mobile_number ?? 'N/A' }}
                                        </div>
                                        <span class="badge bg-light text-dark mt-1">
                                            User Name: {{ $kyc->user->username }}
                                        </span>
                                    </td>

                                    <!-- Account -->
                                    <td>
                                        <div class="fw-semibold">{{ $kyc->account_name }}</div>
                                        <div class="text-muted small">
                                            A/C: {{ $kyc->account_number }} <br> {{ $kyc->bank_name }} <br> {{ $kyc->ifsc_code }}
                                        </div>
                                    </td>

                                    <!-- Bank -->
                                    <td>
                                        <div class="fw-semibold">{{ $kyc->account_type }}</div>
                                        <div class="text-muted small">
                                            GST: {{ $kyc->gst }}  <br>
                                            CIN : {{ $kyc->cin_number }}
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="text-center">
                                        @switch($kyc->kyc_status)
                                            @case('PENDING')
                                                <span class="badge rounded-pill bg-warning text-dark px-3">
                                                    Pending
                                                </span>
                                                @break
                                            @case('APPROVED')
                                                <span class="badge rounded-pill bg-success px-3">
                                                    Approved
                                                </span>
                                                @break
                                            @case('REJECTED')
                                                <span class="badge rounded-pill bg-danger px-3">
                                                    Rejected
                                                </span>
                                                @break
                                            @default
                                                <span class="badge rounded-pill bg-info px-3">
                                                    Verified
                                                </span>
                                        @endswitch
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('superadmin.kyc.view', $kyc->id) }}"
                                               class="btn btn-outline-info"
                                               title="View">
                                                <i class="mdi mdi-eye"></i>
                                            </a>

                                            <a href="{{ route('superadmin.kyc.status', [$kyc->id, 'APPROVED']) }}"
                                               class="btn btn-outline-success"
                                               title="Approve">
                                                <i class="mdi mdi-check"></i>
                                            </a>

                                            <a href="{{ route('superadmin.kyc.status', [$kyc->id, 'REJECTED']) }}"
                                               class="btn btn-outline-danger"
                                               title="Reject">
                                                <i class="mdi mdi-close"></i>
                                            </a>

                                            <a href="{{ route('superadmin.kyc.status', [$kyc->id, 'VERIFIED']) }}"
                                               class="btn btn-outline-primary"
                                               title="Verify">
                                                <i class="mdi mdi-shield-check"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-file-document-outline fs-3"></i><br>
                                        No KYC records available
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">
                    {{ $kycdata->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
