@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
        <div class="col-sm-6">
               <h2 class="page-title">Pending Payment list</h2>
            </div>
            <div class="col-sm-6 text-end">
               <button id="refundBtn" class="btn btn-danger m-2">Refund<span id="totalInfo" class="badge bg-light text-dark">₹0</span></button>
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
                            <th>Cus trxid</th>
                            <th>trx id</th>
                            <th>System id</th>
                            <th>Amount</th>
                            <th>User Charges</th>
                            <th>Status</th>
                            <th>Time</th>
                            
                        </tr>
                   </thead>
                   <tbody id="postTable">
                        @foreach($data as $key=>$value)
                        <tr>
                            <td>
                                <input type="checkbox" class="rowCheckbox" value="{{ $value->id }}"  data-amount="{{ $value->amount }}" data-charges="{{ $value->usercharges }}">
                            </td>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $value->merchantname }}</td>
                            <td>{{ $value->account_number }}</td>
                            <td>{{ $value->cus_trx_id }}</td>
                            <td>{{ $value->trx_id }}</td>
                            <td>{{ $value->systemid }}</td>
                            <td>{{ $value->amount }}</td>
                            <td>{{ $value->usercharges }}</td>
                            <td><span class="badge text-bg-danger">{{ strtoupper($value->status) }}</span></td>
                            <td>{{ date('d-M-Y h:i A', strtotime($value->txnRcvdTimeStamp)) }}</td>
                            
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

    function updateTotal() {
        let totalAmount = 0;
        let totalCharges = 0;

        $('.rowCheckbox:checked').each(function () {
            totalAmount += parseFloat($(this).data('amount')) || 0;
            totalCharges += parseFloat($(this).data('charges')) || 0;
        });

        let grandTotal = totalAmount + totalCharges;
       $('#totalInfo').text('₹' + grandTotal.toFixed(2));

    }

// ✅ Select all checkbox click event
   $('#selectAll').on('click', function() {
      
       $('.rowCheckbox').prop('checked', this.checked);
        updateTotal();
   });

   // ✅ Row checkbox change — update select all state
   $(document).on('change', '.rowCheckbox', function() {
       $('#selectAll').prop('checked', $('.rowCheckbox:checked').length === $('.rowCheckbox').length);
        updateTotal();
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
            url: "{{ url('superadmin/payment/refund') }}",
            method: "POST",
            data: {
               _token: "{{ csrf_token() }}",
               ids: selectedIds
            },
             success: function (res) {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: res.message ?? 'Refund processed successfully'
                });

                setTimeout(() => {
                    location.reload();
                }, 2000);
            },
            error: function(err) {
               alert("Error processing refund");
            }
         });
      }
   });


document.addEventListener('DOMContentLoaded', function () {

    // SweetAlert Toast Config
    

});


</script>
@endpush