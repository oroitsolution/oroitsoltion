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
                                    <th>User Details</th>
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
                                                    PENDING
                                                </span>
                                                @break
                                            @case('APPROVED')
                                                <span class="badge rounded-pill bg-success px-3">
                                                    APPROVED
                                                </span>
                                                @break
                                            @case('REJECTED')
                                                <span class="badge rounded-pill bg-danger px-3">
                                                    REJECTED
                                                </span>
                                                @break
                                            @default
                                                <span class="badge rounded-pill bg-info px-3">
                                                    VERIFIED
                                                </span>
                                        @endswitch
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button"
                                                class="btn btn-outline-info btn-sm"
                                                data-bs-toggle="modal"
                                                id = "kycmodel_box"
                                                data-bs-target="#kycModal{{ $kyc->id }}"
                                                    title="View KYC">
                                                <i class="mdi mdi-eye"></i>
                                            </button>

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
                                                
                                            @if(isset($kyc->account_type) && $kyc->account_type === 'APPROVED')
                                                <button type="button"
                                                        class="btn btn-outline-primary btn-sm"
                                                        title="Verify">
                                                    <i class="mdi mdi-shield-check"></i>
                                                </button>
                                            @endif

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

<div class="modal fade" id="kycModal{{ isset($kyc->id) ? $kyc->id : 'N/A' }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">KYC Details  {{ isset($kyc->account_type) ? $kyc->account_type : 'N/A' }} </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            @php
                $documents = json_decode($kyc->documents, true);
            @endphp

            <!-- Body -->
            <div class="modal-body">

                <!-- USER DETAILS -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold">User Information</h6>

                        <p><strong>Name:</strong>
                            {{ isset($kyc->user->name) ? $kyc->user->name : 'N/A' }}
                        </p>

                         <p><strong>UserName:</strong>
                            {{ isset($kyc->user->username) ? $kyc->user->username : 'N/A' }}
                        </p>

                        <p><strong>Email:</strong>
                            {{ isset($kyc->user->email) ? $kyc->user->email : 'N/A' }}
                        </p>

                        <p><strong>Phone:</strong>
                            {{ isset($kyc->user->mobile_number) ? $kyc->user->mobile_number : 'N/A' }}
                        </p>

                       
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold">Bank Information</h6>

                        <p><strong>Account Name:</strong>
                            {{ isset($kyc->account_name) ? $kyc->account_name : 'N/A' }}
                        </p>

                        <p><strong>Account No:</strong>
                            {{ isset($kyc->account_number) ? $kyc->account_number : 'N/A' }}
                        </p>

                        <p><strong>Bank:</strong>
                            {{ isset($kyc->bank_name) ? $kyc->bank_name : 'N/A' }}
                        </p>

                        <p><strong>IFSC:</strong>
                            {{ isset($kyc->ifsc_code) ? $kyc->ifsc_code : 'N/A' }}
                        </p>
                    </div>
                </div>

                <hr>

                <!-- DOCUMENTS -->
                <h6 class="fw-bold mb-3">KYC Documents</h6>

                <div class="row g-4">

                    {{-- Aadhaar Front --}}
                    @if(isset($documents['adhar_front']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">Aadhaar Front</p>
                            <img src="{{ asset('storage/kyc/'.$documents['adhar_front']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- Aadhaar Back --}}
                    @if(isset($documents['adhar_back']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">Aadhaar Back</p>
                            <img src="{{ asset('storage/kyc/'.$documents['adhar_back']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- PAN Card --}}
                    @if(isset($documents['pan_card']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">PAN Card</p>
                            <img src="{{ asset('storage/kyc/'.$documents['pan_card']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- Cheque --}}
                    @if(isset($documents['chaque']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">Cancelled Cheque</p>
                            <img src="{{ asset('storage/kyc/'.$documents['chaque']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- GST PDF --}}
                    @if(isset($documents['gst_img']))
                        <div class="col-md-8">
                            <p class="fw-semibold">GST Certificate (PDF)</p>
                            <iframe src="{{ asset('storage/kyc/'.$documents['gst_img']) }}"
                                    width="100%"
                                    height="300"
                                    class="border rounded">
                            </iframe>
                        </div>
                    @endif

                    {{-- Company PAN --}}
                    @if(isset($documents['company_pan_card']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">Company PAN</p>
                            <img src="{{ asset('storage/kyc/'.$documents['company_pan_card']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- Address Proof --}}
                    @if(isset($documents['address_proof']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">Address Proof</p>
                            <img src="{{ asset('storage/kyc/'.$documents['address_proof']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- Shop Photo --}}
                    @if(isset($documents['shopphoto']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">Shop Photo</p>
                            <img src="{{ asset('storage/kyc/'.$documents['shopphoto']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- Electric Bill --}}
                    @if(isset($documents['electricbill']))
                        <div class="col-md-4 text-center">
                            <p class="fw-semibold">Electric Bill</p>
                            <img src="{{ asset('storage/kyc/'.$documents['electricbill']) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:200px">
                        </div>
                    @endif

                    {{-- No documents --}}
                    @if(empty($documents))
                        <div class="col-12 text-center text-muted">
                            No documents uploaded
                        </div>
                    @endif

                </div>


            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <a href="{{ route('superadmin.kyc.status', [$kyc->id, 'APPROVED']) }}"
                   class="btn btn-success">
                    Approve
                </a>

                <a href="{{ route('superadmin.kyc.status', [$kyc->id, 'REJECTED']) }}"
                   class="btn btn-danger">
                    Reject
                </a>
            </div>

        </div>
    </div>
</div>


@endsection
@push('js')


@endpush