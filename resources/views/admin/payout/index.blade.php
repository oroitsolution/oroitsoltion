@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <form method="GET" action="{{ route('superadmin.payout.index') }}" >
          <div class="card-body">
            <div class="row align-items-end">

             <div class="col-md-3">
                <label for="statusToggle" class="form-label">Key</label>
                <select name="key" class="form-control" id="keySelect">
                  <option value="">Select</option>
                  <option value="trx_id" {{ request('key') == 'trx_id' ? 'selected' : '' }}>Trx Id</option>
                  <option value="utr" {{ request('key') == 'utr' ? 'selected' : '' }}>UTR</option>
                  <option value="account_number" {{ request('key') == 'account_number' ? 'selected' : '' }}>Account Number</option>
                </select>
              </div>

               <div class="col-md-3 serchdata {{ request('key') ? '' : 'd-none' }}">
                    <label class="form-label">Search</label>
                    <input type="text" name="search_data" value="{{ request('search_data') }}" class="form-control" placeholder="Search..." />
                </div>


              <div class="col-md-3">
                <label for="exampleInputstartdate" class="form-label">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', request('start_date')) }}" class="form-control" id="exampleInputstartdate" />
              </div>

              <div class="col-md-3">
                <label for="exampleInputenddate" class="form-label">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', request('end_date')) }}" class="form-control" id="exampleInputenddate" />
              </div>

              <div class="col-md-3">
                <label for="statusToggle" class="form-label">Status Filter</label>
                <select name="status" class="form-control" id="statusToggle" onchange="this.form.submit()">
                  <option value="">All</option>
                  <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                  <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="fail" {{ request('status') == 'fail' ? 'selected' : '' }}>Fail</option>
                </select>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="d-flex">
              <button type="submit" class="btn btn-primary me-2">Submit</button>
              <a href="{{url('superadmin/payout')}}" class="btn btn-danger me-2">Date Reset</a>
             
            </div>
          </div>
        </form>  

          <div class="card-body">
          
            <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                        <tr>
                          <th style="width: 10px">id</th>
                          <th>Name</th>
                          <th>Account Number</th>
                          <th>IFSC Code</th>
                          <th>UTR</th>
                          <th>Account Name</th>
                          <th>Status</th>
                          <th>date</th>
                          <th>View</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                      @if($data->isNotEmpty())
                      @foreach($data as $key=> $user)
                        <tr class="align-middle">
                          <td>{{$key+1}}</td>
                          <td>{{$user->merchantname}}</td>
                          <td>{{$user->account_number}}</td>
                          <td>{{$user->ifsc}}</td>
                          <td>{{$user->utr}}</td>
                          <td>{{$user->name}}</td>
                          <td>
                            <span class="badge 
                                @if($user->status == 'success') text-bg-success 
                                @elseif($user->status == 'fail') text-bg-danger 
                                @elseif($user->status == 'pending') text-bg-primary 
                                @endif">
                                {{ $user->status }}
                            </span>
                            </td>
                          
                          <td>{{\Carbon\Carbon::parse($user->txnRcvdTimeStamp)->format('d-m-y h:i:s')}}</td>
                         <td>
                            <button
                                class="btn btn-sm btn-info viewBtn"
                                data-name="{{ $user->merchantname }}"
                                data-utr="{{ $user->utr }}"
                                data-trxid="{{ $user->trx_id ?? '-' }}"
                                data-status="{{ $user->status }}"
                                data-account="{{ $user->account_number }}"
                                data-ifsc="{{ $user->ifsc }}"
                                data-date="{{ \Carbon\Carbon::parse($user->txnRcvdTimeStamp)->format('d M Y, h:i A') }}">
                                View
                            </button>
                        </td>

                          
                        </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
              </table>
            </div>
            <div class="card-footer clearfix">
            <div class="d-flex justify-content-end">
              
            </div>
        </div>
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered">
          <tr>
            <th>Name</th>
            <td id="m_name"></td>
          </tr>
          <tr>
            <th>UTR</th>
            <td id="m_utr"></td>
          </tr>
          <tr>
            <th>Txn ID</th>
            <td id="m_trxid"></td>
          </tr>
          <tr>
            <th>Status</th>
            <td id="m_status"></td>
          </tr>
          <tr>
            <th>Account No</th>
            <td id="m_account"></td>
          </tr>
          <tr>
            <th>IFSC</th>
            <td id="m_ifsc"></td>
          </tr>
          <tr>
            <th>Date</th>
            <td id="m_date"></td>
          </tr>
        </table>
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
    document.querySelectorAll('.viewBtn').forEach(btn => {
    btn.addEventListener('click', function () {

        document.getElementById('m_name').innerText    = this.dataset.name;
        document.getElementById('m_utr').innerText     = this.dataset.utr;
        document.getElementById('m_trxid').innerText   = this.dataset.trxid;
        document.getElementById('m_status').innerText  = this.dataset.status;
        document.getElementById('m_account').innerText = this.dataset.account;
        document.getElementById('m_ifsc').innerText    = this.dataset.ifsc;
        document.getElementById('m_date').innerText    = this.dataset.date;

        let modal = new bootstrap.Modal(document.getElementById('viewModal'));
        modal.show();
    });
});
document.getElementById('keySelect').addEventListener('change', function () {
    const searchBox = document.querySelector('.serchdata');
    const startDate = document.getElementById('exampleInputstartdate');
    const endDate   = document.getElementById('exampleInputenddate');

    if (this.value !== '') {
        // Key selected → show search, hide date
        searchBox.classList.remove('d-none');
        startDate.disabled = true;
        endDate.disabled = true;
    } else {
        // No key → hide search, show date
        searchBox.classList.add('d-none');
        startDate.disabled = false;
        endDate.disabled = false;
    }
});
</script>
@endpush
