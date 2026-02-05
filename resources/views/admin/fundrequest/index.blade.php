@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
        <div class="col-sm-6">
               <h2 class="page-title">Fund Request list</h2>
            </div>
           
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
          
            <div class="table-responsive">
              <table id="fundTable" class="table table-striped">
                   <thead>
                        <tr>
                           <th scope="col">ID</th>
                           <th scope="col">User Name	</th>
                           <th scope="col">Amount</th>
                           <th scope="col">Payment Method</th>
                           <th scope="col">Date</th>
                           <th scope="col">Utr</th>
                           <th scope="col">status</th>
                           <th scope="col">Pay</th>
                           <th scope="col">Reject</th>
                        </tr>
                   </thead>
                   <tbody>
                        @foreach($data as $key=>$value)
                        <tr>
                           <td>{{ $key+1 }}</td>
                           <td>{{ $value->name }}</td>
                           <td>{{ $value->deposit_amount }}</td>
                           <td>{{ $value->payment_method }}</td>
                           <td>{{ $value->paymentdate }}</td>
                           <td>{{ $value->utr }}</td>
                           <td>
                              <span class="badge 
                                 @if($value->status == 'pending') text-bg-primary 
                                 @elseif($value->status == 'success') text-bg-success
                                 @elseif($value->status == 'Rejected') text-bg-danger
                                 @endif">
                              {{ $value->status }}
                              </span>
                           </td>
                           <!-- Approve Button -->
                           <td>
                             
                              @if($value->status == 'pending')
                              <button class="btn btn-sm btn-primary withdraw-btn"
                                 data-value="success"
                                 data-id="{{ $value->id }}"
                                 data-userid="{{ $value->user_id }}"
                                 data-amount="{{ $value->deposit_amount }}">
                              Approve
                              </button>
                              @elseif($value->status == 'success')
                              <button class="btn btn-sm btn-primary" disabled>
                              Approved
                              </button>
                              @endif
                              
                           </td>
                           <!-- Reject Button -->
                           <td>
                              @can('verify fund')
                              @if($value->status == 'pending')
                              <button class="btn btn-sm btn-danger withdraw-btn"
                                 data-value="Rejected"
                                 data-id="{{ $value->id }}"
                                 data-userid="{{ $value->user_id }}"
                                 data-amount="{{ $value->deposit_amount }}">
                              Reject
                              </button>
                              @elseif($value->status == 'Rejected')
                              <button class="btn btn-sm btn-danger" disabled>
                              Rejected
                              </button>
                              @endif
                              @endcan
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
 $('#fundTable').DataTable({
      paging: true,
      searching: true,
      ordering: true,
      responsive: true
   });
   
   $('.withdraw-btn').on('click', function () {
   let id = $(this).data('id');
   let userid = $(this).data('userid');
   let amount = $(this).data('amount');
   let value = $(this).data('value');
   
   $.ajax({
     url: "{{ route('superadmin.fund.upload') }}",
     type: "POST",
     data: {
       id: id,
       userid: userid,
       amount: amount,
       value: value,
       _token: "{{ csrf_token() }}"
     },
     success: function (response) {
       location.reload();
     },
     error: function (xhr) {
       console.error(xhr.responseText);
       $('.refunderror')
         .removeClass('d-none alert-success')
         .addClass('alert-danger')
         .text('Something went wrong. Please try again.');
     }
   });
   });
   });
</script>
@endpush