@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
      @if(Session::has('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert" id="success-alert">
    {{ Session::get('success') }}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

      @endif
      <div class="col-lg-12 grid-margin stretch-card">
       
        <div class="card">
       <form method="post" action="{{route('superadmin.freeze.store')}}">
         @csrf
          <div class="card-body">
            <div class="row align-items-end">

             <div class="col-md-3">
                <label for="statusToggle" class="form-label">User</label>
               
                <select name="user_id" id="exampleuser" class="me-sm-2  form-control wide inlineFormCustomSelect" required>
                  <option value="">--Select--</option>
                    @foreach($user as $key => $data)
                        <option value="{{ $data->id }}" data-wallet="{{ $data->wallet_amount }}">{{ $data->name }}</option>
                    @endforeach
                </select>
                 
                </select>
              </div>

               <div class="col-md-3 d-none currentbalance" >
                    <label class="form-label">Current Amount</label>
                    <input style="background-color: #a86662; color: black; font-weight: bold;" type="number" name="old_amount" value="" class="form-control" placeholder="Enter Current Amount" id="exampleInputcurrentamount" />
                </div>


              <div class="col-md-3">
                <label for="exampleInputstartdate" class="form-label">Freeze Amount</label>
                <input type="number" name="freeze_amount" value="{{ old('freeze_amount') }}" id="freezeAmount" class="form-control" />
              </div>

              <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
              </div>
            </div>
          </div>

        </form>

          <div class="card-body">
           
            <div class="table-responsive">
              <table class="table table-striped" id="freezeamountTable">
                 <thead>
                  <tr>
                    <th> S.N. </th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                     <tbody>
                    @foreach($freezeamount as $key => $value)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value->user_name }}</td>
                            <td>{{ $value->amount }}</td>
                            
                            <td>
                            
                              <button class="btn btn-sm btn-primary editBtn" data-id="{{ $value->id }}" data-username="{{ $value->user_name }}"
                                data-amount="{{ $value->amount }}"> Edit</button>
                        
                           
                              <form action="{{ route('superadmin.freezeamount.destroy', $value->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                              </form>
                           
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
               {{ $freezeamount->links('pagination::bootstrap-5') }}
            </div>
            <div class="card-footer clearfix">
            <div class="d-flex justify-content-end">
              
            </div>
        </div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                      <h6>Edit Freeze Amount</h6>
                      <hr>
                       <form id="editForm" method="POST" action="">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="id" id="edit_id">
                          <div class="mb-3 col-lg-12 col-md-12">
                            <label class="form-label">User Name</label>
                            <input style="background-color: #db6140; color:white" type="text" class="form-control" id="edit_username" name="user_name" readonly>
                          </div>

                          <div class="mb-3 col-lg-12 col-md-12">
                            <label class="form-label">Freeze Amount</label>
                            <input type="number" class="form-control" id="edit_amount" name="amount" required>
                          </div>

                          <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Update</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </form>
                    </div>
                </div>
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
    setTimeout(function(){
    $('#success-alert').fadeOut('slow');
}, 3000);
    $(document).ready(function () {
        
        $('#freezeamountTable').DataTable({
        dom: 'f',
        paging: false,
        info: false,
        ordering: true,
        responsive: true
        });

        $('.dataTables_filter input') .addClass('form-control').attr('placeholder', 'Search')
            .css({display: 'inline-block', width: 'auto', marginLeft: '10px'});


        $('#exampleuser').on('change', function () {
            let selectedOption = $(this).find(':selected');
            let walletAmount = parseFloat(selectedOption.data('wallet')) || 0;
            $('#exampleInputcurrentamount').attr('readonly', true);
            $('#exampleInputcurrentamount').val(walletAmount);
            $('.currentbalance').removeClass('d-none');
        });


        $('.editBtn').click(function() {
          var id = $(this).data('id');
          var username = $(this).data('username');
          var amount = $(this).data('amount');

          $('#edit_id').val(id);
          $('#edit_username').val(username);
          $('#edit_amount').val(amount);

          // Update form action to match resource route: freezeamount/{id}
          var updateUrl = "{{ url('superadmin/freeze-update') }}/" + id;
          $('#editForm').attr('action', updateUrl);

          $('#editModal').modal('show');
      });


    });
</script>
@endpush
