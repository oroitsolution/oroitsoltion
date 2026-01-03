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
</script>
@endpush