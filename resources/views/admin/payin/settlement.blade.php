@extends('adminlayouts.app')
@section('content')
<div class="content-wrapper">
   <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
         <div class="card">
             @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                <form method="post" action="{{ route('superadmin.settle.withdraw') }}">
                    @csrf
               <div class="card-body">
                  <div class="row align-items-end">
                     <div class="col-md-3">
                        <label for="statusToggle" class="form-label">User</label>
                        <select name="user_id" id="userSelect" class="form-control">
                            <option value="">Select User</option>
                        </select>
                     </div>
                     <div class="col-md-2 serchdata">
                        <label class="form-label">Settlement Amount</label>
                        <input type="text" type="text" name="settleoldamount" id="settlementamount" class="form-control bg-light" readonly />
                     </div>
                     <div class="col-md-2">
                        <label for="exampleInputstartdate" class="form-label">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" />
                     </div>
                     <div class="col-md-2">
                        <label for="exampleInputenddate" class="form-label">Charges</label>
                        <input type="text"  name="charges" id="charges" class="form-control bg-light" readonly />
                     </div>
                     <div class="col-md-2">
                        <label for="statusToggle" class="form-label">Status Filter</label>
                        <select name="settletype"  id="settle" class="form-control">
                            <option value="wallet">Wallet</option>
                            <option value="account">Account</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="card-footer">
                  <div class="d-flex">
                      <button type="submit" class="btn btn-primary me-2">Settle</button>
                  </div>
               </div>
              
            </form>

               <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="settlementTable">
                     <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Old Payin Amount</th>
                            <th>Settle Amount</th>
                            <th>Charges</th>
                            <th>Final Amount</th>
                            <th>user wallet balance</th>
                            <th>Date</th>
                            <th>status</th>
                            <th>Type</th>
                        </tr>
                     </thead>
                     <tbody id="postTable">
                          @foreach($data as $value)
                          
                           <tr>
                              <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                              <td>{{$value->merchantname}}</td>
                              <td>{{$value->oldamount}}</td>
                              <td>{{$value->amount}}</td>
                              <td>{{$value->charges}}</td>
                              <td>{{$value->final_amount}}</td>
                              
                              <td>{{$value->wallet_balance}}</td>
                              <td>{{ date('d-M-Y h:i A', strtotime($value->created_at)) }}</td>
                              <td><span class="badge 
                                     @if($value->status == 'success') text-bg-primary 
                                     @endif">
                                     {{ $value->status }}
                                 </span>
                              </td>
                               <td><span class="badge 
                                     @if($value->type == 'wallet') text-bg-success 
                                     @elseif($value->type == 'account') text-bg-warning
                                     @endif">
                                     {{ $value->type }}
                                 </span>
                              </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                  </table>
               </div>
               <div class="mt-3">
                   {{ $data->links('pagination::bootstrap-5') }}
               </div>
               {{-- <div class="card-footer clearfix">
                  <div class="d-flex justify-content-end">
                  </div>
               </div> --}}
               
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('js')
<script>
  
      $(document).ready(function() {
      $('#settlementTable').DataTable({
         dom: 'Bfrtip',
         buttons: [
            'copyHtml5',
            'excelHtml5'
         ],
         paging: true,
         searching: true,
         ordering: true,
         responsive: true
      });
   });


</script>

<script>
document.getElementById('amount').addEventListener('input', function () {
    let amount = parseFloat(this.value) || 0;
    let settlement = parseFloat(document.getElementById('settlementamount').value) || 0;

    if (amount > settlement) {
        alert('Amount cannot be greater than settlement amount');
        this.value = '';
    }
});



        let usersData = [];
        
        fetch('/superadmin/get-settlement-users')
        .then(res => res.json())
        .then(data => {
            usersData = data;
            let options = '<option value="">Select User</option>';
        
            data.forEach(user => {
                options += `<option value="${user.user_id}">${user.merchantname}</option>`;
            });
        
            document.getElementById('userSelect').innerHTML = options;
        });
        
        document.getElementById('userSelect').addEventListener('change', function () {
            let userId = this.value;
            let user = usersData.find(u => u.user_id == userId);
        
            if (user) {
                document.getElementById('settlementamount').value = user.settlementamount;
                document.getElementById('amount').value = '';
                document.getElementById('charges').value = '';
            }
        });
        
        document.getElementById('amount').addEventListener('input', function () {
        
            let amount = parseFloat(this.value);
            let userId = document.getElementById('userSelect').value;
            let user = usersData.find(u => u.user_id == userId);
        
            if (!user || !user.charges || isNaN(amount)) return;
        
            let charge = user.charges;
        
            let calculatedCharge = 0;
        
            if (charge.charge_type === 'percent') {
                calculatedCharge = (amount * charge.charges) / 100;
            } else {
                calculatedCharge = charge.charges;
            }
        
            document.getElementById('charges').value = calculatedCharge.toFixed(2);
        });
</script>

@endpush
