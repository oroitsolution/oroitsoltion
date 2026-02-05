@extends('userlayout.app')
@section('title', 'FUND REQUEST || ORO IT SOLUTION')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <h5 class="fw-semibold mb-4">Transaction Details</h5>

                    <form method="POST" id="fundaddreq">
                       @csrf
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row g-4">

                            {{-- Deposit Amount --}}
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Deposit Amount</label>
                                <input type="amount" id ="pamount" name ="pamount" class="form-control form-control-lg"
                                       placeholder="Enter amount">
                            </div>

                            {{-- Payment Method --}}
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Payment Method</label>
                                <select id="paymntmode" name = "paymntmode" class="form-select form-select-lg">
                                    <option selected>IMPS</option>
                                    <option>NEFT</option>
                                    <option>RTGS</option>
                                    
                                </select>
                            </div>

                            {{-- Date of Payment --}}
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Date of Payment</label>
                                <input type="date" id="paymntdate" name = "paymntdate" class="form-control form-control-lg">
                            </div>

                            {{-- IFSC Code --}}
                            <div class="col-md-4">
                                <label class="form-label fw-medium">IFSC Code</label>
                                <input type="text" id = "ifsc"  name = "ifsc" value = "KKBK0003748" class="form-control form-control-lg"
                                       placeholder="Enter IFSC code" readonly>
                            </div>
                           
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Bank Name</label>
                                <select class="form-select form-select-lg" id="bankname" name = "bankname">
                                    <option value ="0" selected>Select Bank</option>
                                    <option value = "Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                                </select>
                            </div>

                            {{-- Account Number --}}
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Account Number</label>
                                <select class="form-select form-select-lg"  id="acnumber" name ="acnumber" >
                                    <option value ="0" selected>Select Account</option>
                                    <option value="6053299439">6053299439</option>
                                </select>
                            </div>

                            {{-- Bank Reference / UTR --}}
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Bank Reference / UTR</label>
                                <input type="text" id ="utr" name ="utr" class="form-control form-control-lg"
                                       placeholder="Enter UTR">
                            </div>

                            {{-- Remark --}}
                            <div class="col-md-8">
                                <label class="form-label fw-medium">Remark</label>
                                <textarea class="form-control form-control-lg" id="remark" name="remark"
                                          rows="2"
                                          placeholder="Optional remark"></textarea>
                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="mt-5">
                            <button type="submit" id ="fundaddbtn" 
                                class="btn btn-primary btn-lg px-5 rounded-pill">
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    {{-- Wallet Recharge Data --}}
    <div class="row justify-content-center mt-5">
        <div class="col-xl-10 col-lg-11">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-semibold mb-0">Wallet Recharge Data</h5>

                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0 fw-medium">Search:</label>
                            <input type="text"
                                class="form-control form-control-sm"
                                style="width:220px"
                                placeholder="Search">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                    <th>UTR</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($fundRequests->count())
                                    @foreach($fundRequests as $req)
                                        <tr>
                                            <td>#{{ $req->id }}</td>
                                            <td>₹{{ number_format($req->deposit_amount, 2) }}</td>
                                            <td>{{ $req->payment_method }}</td>
                                            <td>{{ \Carbon\Carbon::parse($req->payment_date)->format('d-m-Y') }}</td>
                                            <td>{{ $req->utr ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge 
                                                    {{ $req->status == 'pending' ? 'bg-warning' : 
                                                    ($req->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                                    {{ ucfirst($req->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No data available in table
                                        </td>
                                    </tr>
                                @endif
                                </tbody>

                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Showing {{ $fundRequests->firstItem() ?? 0 }}
                            to {{ $fundRequests->lastItem() ?? 0 }}
                            of {{ $fundRequests->total() }} entries
                        </div>

                        <div>
                            {{ $fundRequests->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toast" class="toast align-items-center border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>


@push('css')
<style>

</style>
@endpush

@push('js')
<script>


$('#fundaddreq').on('submit', function(e) {
    e.preventDefault();

    let btn = $('#fundaddbtn');
    btn.prop('disabled', true).text('Please wait...');

    if ($('#bankname').val() === '0') {
        showToast('Please select bank name', 'warning');
        btn.prop('disabled', false).text('Submit');
        return;
    }

    if ($('#acnumber').val() === '0') {
        showToast('Please select account number', 'warning');
        btn.prop('disabled', false).text('Submit');
        return;
    }

    $.ajax({
        url: "{{ route('user.fund.request.send') }}",
        type: "POST",
        data: $(this).serialize(),

        success: function(res) {
            showToast(res.message, 'success');

            setTimeout(function () {
                location.reload();
            }, 1500); // 1.5 sec so toast dikh jaye
        },

        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            for (let key in errors) {
                showToast(errors[key][0], 'error');
                break;
            }
            btn.prop('disabled', false).text('Submit');
        }
    });
});


</script>
@endpush


@endsection