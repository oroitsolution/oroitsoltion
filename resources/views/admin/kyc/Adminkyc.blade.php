@extends('adminlayouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow">

                {{-- Header --}}
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0">
                        <i class="mdi mdi-account-check-outline me-2"></i> KYC Management
                    </h4>
                </div>

                {{-- Body --}}
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light border-bottom">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>User Details</th>
                                    <th>Bank A/C</th>
                                    <th>Account Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($kycdata as $kyc)
                                <tr>
                                    {{-- ID --}}
                                    <td class="text-center fw-bold">
                                        {{ isset($kyc->id) ? $kyc->id : 'N/A' }}
                                    </td>

                                    {{-- User --}}
                                    <td>
                                        <strong>{{ isset($kyc->user->name) ? $kyc->user->name : 'N/A' }}</strong><br>
                                        <small class="text-muted">
                                            {{ isset($kyc->user->email) ? $kyc->user->email : 'N/A' }}<br>
                                            {{ isset($kyc->user->mobile_number) ? $kyc->user->mobile_number : 'N/A' }}<br>
                                            {{ isset($kyc->user->username) ? $kyc->user->username : 'N/A' }}
                                        </small>
                                    </td>

                                    {{-- Bank --}}
                                    <td>
                                        <strong>{{ isset($kyc->account_name) ? $kyc->account_name : 'N/A' }}</strong><br>
                                        <small>
                                            A/C: {{ isset($kyc->account_number) ? $kyc->account_number : 'N/A' }}<br>
                                            {{ isset($kyc->bank_name) ? $kyc->bank_name : 'N/A' }}<br>
                                            IFSC: {{ isset($kyc->ifsc_code) ? $kyc->ifsc_code : 'N/A' }}
                                        </small>
                                    </td>

                                    {{-- Account Type --}}
                                    <td>
                                        {{ isset($kyc->account_type) ? $kyc->account_type : 'N/A' }}<br>
                                        <small>
                                            GST: {{ isset($kyc->gst) ? $kyc->gst : 'N/A' }}<br>
                                            CIN: {{ isset($kyc->cin_number) ? $kyc->cin_number : 'N/A' }}
                                        </small>
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        @if(isset($kyc->kyc_status) && $kyc->kyc_status === 0)
                                        <span class="badge bg-warning">PENDING</span>
                                        @elseif(isset($kyc->kyc_status) && $kyc->kyc_status === 1)
                                        <span class="badge bg-success">APPROVED</span>
                                        @elseif(isset($kyc->kyc_status) && $kyc->kyc_status === 2)
                                        <span class="badge bg-danger">REJECTED</span>
                                        @else
                                        <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        @if(isset($kyc->id))
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#kycModal{{ $kyc->id }}">
                                            <i class="mdi mdi-eye"></i>
                                        </button>

                                           @if(isset($kyc) && $kyc->kyc_status == '1')                                               
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-success"
                                                        data-kyc-id="{{ $kyc->id }}"          {{-- required for JS --}}
                                                        data-kyc-uid="{{ $kyc->user_id }}">
                                                    <i class="mdi mdi-verified me-1"></i>Verified
                                                </button>

                                            @elseif(isset($kyc))
                                                {{-- Action Buttons for Pending/Rejected KYC --}}
                                                <div class="btn-group" role="group">
                                                    
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-success kyc-approve-btn"
                                                            data-kyc-id="{{ $kyc->id }}" 
                                                            data-kyc-uid="{{ $kyc->userid }}" 
                                                            id="kyc_approve_{{ $kyc->id }}" 
                                                            data-status="APPROVED"
                                                            data-bs-toggle="tooltip" 
                                                            title="Approve KYC">
                                                        <i class="mdi mdi-check"></i>
                                                    </button>

                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger kyc-reject-btn"
                                                            data-kyc-id="{{ $kyc->id }}" 
                                                            data-kyc-uid="{{ $kyc->userid }}" 
                                                            id="kyc_reject_{{ $kyc->id }}" 
                                                            data-status="REJECTED"
                                                            data-bs-toggle="tooltip" 
                                                            title="Reject KYC">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                    
                                                </div>
                                            @endif

                                        @endif
                                    </td>
                                </tr>

                                {{-- MODAL --}}
                                @if(isset($kyc->id))
                                <div class="modal fade" id="kycModal{{ $kyc->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">

                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">KYC Details</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            @php
                                            $documents = isset($kyc->documents)
                                            ? json_decode($kyc->documents, true) ?? []
                                            : [];
                                            @endphp

                                            <div class="modal-body">
                                                <div class="row">
                                                    {{-- User Info --}}
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold">User Information</h6>
                                                        <p><strong>Name:</strong> {{ $kyc->user->name ?? 'N/A' }}</p>
                                                        <p><strong>Email:</strong> {{ $kyc->user->email ?? 'N/A' }}</p>
                                                        <p><strong>Phone:</strong>
                                                            {{ $kyc->user->mobile_number ?? 'N/A' }}</p>
                                                        <p><strong>Username:</strong>
                                                            {{ $kyc->user->username ?? 'N/A' }}</p>
                                                    </div>

                                                    {{-- Bank Info --}}
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold">Bank Information</h6>
                                                        <p><strong>Account Name:</strong>
                                                            {{ $kyc->account_name ?? 'N/A' }}</p>
                                                        <p><strong>Account No:</strong>
                                                            {{ $kyc->account_number ?? 'N/A' }}</p>
                                                        <p><strong>Bank:</strong> {{ $kyc->bank_name ?? 'N/A' }}</p>
                                                        <p><strong>IFSC:</strong> {{ $kyc->ifsc_code ?? 'N/A' }}</p>
                                                    </div>
                                                </div>

                                                <hr>

                                                {{-- Documents --}}
                                                <h6 class="fw-bold mb-3">KYC Documents</h6>
                                                <div class="row g-4">

                                                    @foreach([
                                                    'adhar_front' => 'Aadhaar Front',
                                                    'adhar_back' => 'Aadhaar Back',
                                                    'pan_card' => 'PAN Card',
                                                    'chaque' => 'Cancelled Cheque',
                                                    'company_pan_card' => 'Company PAN',
                                                    'address_proof' => 'Address Proof',
                                                    'shopphoto' => 'Shop Photo',
                                                    'electricbill' => 'Electric Bill'
                                                    ] as $key => $label)

                                                    @if(isset($documents[$key]))
                                                    <div class="col-md-4 text-center">
                                                        <p class="fw-semibold">{{ $label }}</p>
                                                        <img src="{{ asset('storage/kyc/'.$documents[$key]) }}"
                                                            class="img-fluid rounded border" style="max-height:200px">
                                                    </div>
                                                    @endif
                                                    @endforeach

                                                    @if(isset($documents['gst_img']))
                                                    <div class="col-md-8">
                                                        <p class="fw-semibold">GST Certificate</p>
                                                        <iframe src="{{ asset('storage/kyc/'.$documents['gst_img']) }}"
                                                            class="w-100 border rounded" height="300"></iframe>
                                                    </div>
                                                    @endif

                                                    @if(empty($documents))
                                                    <div class="col-12 text-center text-muted">
                                                        No documents uploaded
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endif

                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-file-document-outline fs-2"></i><br>
                                        No data present
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="card-footer d-flex justify-content-end">
                    {{ $kycdata->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function () {

    $(document).on('click', '.kyc-approve-btn, .kyc-reject-btn', async function () {

        let button = $(this);
        let kycId  = button.data('kyc-id');
        let userId = button.data('kyc-uid');
        let status = button.data('status');

        let url = "{{ route('superadmin.kyc.status', ':id') }}".replace(':id', kycId);

        const result = await Swal.fire({
            title: `Are you sure you want to ${status} this KYC?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        });

        if (!result.isConfirmed) return;

        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: status,
                user_id: userId,
                kyc_id: kycId
            },
            beforeSend: function () {
                // Disable both buttons in the same row
                button.closest('tr').find('button').prop('disabled', true);
            },
            success: function (response) {

                if (response.success === true) {
                    toastr.success(response.message || 'KYC updated successfully');

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.message || 'KYC update failed');
                    setTimeout(() => location.reload(), 1500);
                    button.closest('tr').find('button').prop('disabled', false);
                }
            },
            error: function (xhr) {

                let message = 'Something went wrong';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                toastr.error(message);
                button.closest('tr').find('button').prop('disabled', false);
            }
        });
    });

});
</script>


@endpush