@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
        <div class="col-sm-6">
               <h2 class="page-title">Pending Payment list</h2>
            </div>
            <div class="col-sm-6 text-end">
               <button id="refundBtn" class="btn btn-danger m-2">Refund</button>
            </div>
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
          
            <div class="table-responsive">
              <table id="refundTable" class="table table-striped">
                   <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Account Number</th>
                            <th>Api Reference Number</th>
                            <th>trx id</th>
                            <th>ftx id</th>
                            <th>Amount</th>
                            <th>User Charges</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>View</th>
                        </tr>
                   </thead>
                   <tbody id="postTable">
                        @foreach($data as $key=>$value)
                        <tr>
                            <td>
                                <input type="checkbox" class="rowCheckbox" value="{{ $value->id }}">
                            </td>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->merchantname }}</td>
                            <td>{{ $value->account_number }}</td>
                            <td>{{ $value->api_ref_id }}</td>
                            <td>{{ $value->trx_id }}</td>
                            <td>{{ $value->ftxID }}</td>
                            <td>{{ $value->amount }}</td>
                            <td>{{ $value->usercharges }}</td>
                            <td><span class="badge text-bg-danger">{{ strtoupper($value->status) }}</span></td>
                            <td>{{ date('d-M-Y h:i A', strtotime($value->txnRcvdTimeStamp)) }}</td>
                            <td>
                                <button
                                    class="btn btn-sm btn-info checkStatus"
                                    data-name="{{ $user->merchantname }}"
                                    data-trxid="{{ $user->trx_id ?? '-' }}"
                                    data-status="{{ $user->status }}"
                                    data-account="{{ $user->account_number }}"
                                    data-ifsc="{{ $user->ifsc }}">
                                    Check Status
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                      
              </table>
            </div>
            <div class="card-footer clearfix">
            <div class="d-flex justify-content-end">
              
            </div>
        </div>


          </div>
        </div>
      </div>
    </div>
</div>



@endsection
@push('js')
<script>
$(document).ready(function() {
   // DataTable init
   $('#refundTable').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      responsive: true
   });

   
});

// ✅ Select all checkbox click event
   $('#selectAll').on('click', function() {
      
       $('.rowCheckbox').prop('checked', this.checked);
   });

   // ✅ Row checkbox change — update select all state
   $(document).on('change', '.rowCheckbox', function() {
       $('#selectAll').prop('checked', $('.rowCheckbox:checked').length === $('.rowCheckbox').length);
   });

   // Refund button click
   $('#refundBtn').on('click', function() {
      let selectedIds = $('.rowCheckbox:checked').map(function() {
         return $(this).val();
      }).get();

      if(selectedIds.length === 0) {
         alert("Please select at least one record to refund.");
         return;
      }

      if(confirm("Are you sure you want to refund selected payments?")) {
         $.ajax({
            url: "", // Create this route in web.php
            method: "POST",
            data: {
               _token: "{{ csrf_token() }}",
               ids: selectedIds
            },
            success: function(res) {
               alert(res.message);
               location.reload();
            },
            error: function(err) {
               alert("Error processing refund");
            }
         });
      }
   });


document.addEventListener('DOMContentLoaded', function () {

    // SweetAlert Toast Config
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    document.querySelectorAll('.checkStatus').forEach(button => {

        button.addEventListener('click', function () {

            const btn = this;

            const data = {
                name: btn.dataset.name,
                trxid: btn.dataset.trxid,
                status: btn.dataset.status,
                account: btn.dataset.account,
                ifsc: btn.dataset.ifsc,
                _token: "{{ csrf_token() }}"
            };

            // Confirmation Alert
            Swal.fire({
                title: 'Check Status?',
                text: 'Do you want to check this transaction status?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Check',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (!result.isConfirmed) return;

                // Loading
                Swal.fire({
                    title: 'Checking...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch("{{ route('superadmin.check.status') }}", {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(response => {

                    Swal.close();

                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message || 'Status updated'
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1500);

                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message || 'Something went wrong'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    Toast.fire({
                        icon: 'error',
                        title: 'Server error, try again'
                    });
                });

            });
        });

    });

});


</script>
@endpush