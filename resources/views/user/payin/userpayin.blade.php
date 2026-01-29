@extends('userlayout.app')
@section('title', 'User Payin')
@section('content')
<div class="content-wrapper">
   <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
         <div class="card">
            <form method="GET" action="{{ route('user.payin.data') }}" >
               <div class="card-body">
                  <div class="row align-items-end">
                     <div class="col-md-3">
                        <label for="statusToggle" class="form-label">Key</label>
                        <select name="key" class="form-control" id="keySelect">
                           <option value="">Select</option>
                           <option value="systemgenerateid" {{ request('key') == 'systemgenerateid' ? 'selected' : '' }}>Systemid</option>
                           <option value="utr" {{ request('key') == 'utr' ? 'selected' : '' }}>UTR</option>
                           <option value="order_id" {{ request('key') == 'account_number' ? 'selected' : '' }}>Order Id</option>
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
                           <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                           <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="card-footer">
                  <div class="d-flex">
                     <button type="submit" class="btn btn-primary me-2">Submit</button>
                     <a href="{{url('user/payin/data')}}" class="btn btn-danger me-2">Date Reset</a>
                  </div>
               </div>
            </form>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="payinTable">
                     <thead>
                        <tr>
                           <th>ID</th>
                            <th>Name</th>
                            <th>System Generate Id</th>
                            <th>Order Id</th>
                            <th>UTR</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>View</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($data as $value)
                        <?php
                           $datarow = json_decode($value->data_request);   
                        ?>

                        <tr>
                              <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                              <td>{{$datarow->name}}</td>
                              <td>{{$value->systemgenerateid }}</td>
                              <td>{{$value->order_id}}</td>
                               <td>{{$value->utr}}</td>
                              <td>{{$value->amount}}</td>
                              <td><span class="badge 
                                     @if($value->status == 'rejected') text-bg-warning 
                                     @elseif(in_array($value->status, ['success', 'SUCCESS']))text-bg-success                        
                                     @elseif(in_array($value->status, ['failed', 'FAILED']))text-bg-danger
                                     @elseif(in_array($value->status, ['pending', 'PENDING']))text-bg-primary 
                                     @endif">
                                     {{ $value->status }}
                                 </span>
                              </td>
                    
                              <td>{{ date('d-M-Y h:i A', strtotime($value->created_at)) }}</td>
                              <td>
                                <button class="btn btn-sm btn-info view-btn"
                                      data-account-name="{{ $datarow->name }}"
                                      data-amount="{{ $value->amount }}"
                                      data-orderid="{{ $value->order_id }}"
                                      data-date="{{ $value->created_at }}"
                                      data-status="{{ $value->status }}"
                                      data-utr="{{ $value->utr }}"
                                      data-transaction="{{ $value->systemgenerateid }}"
                                      data-type="{{ $value->type }}">
                                   <i class="bi bi-eye"></i> View
                                </button>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="mt-3">
                  {{ $data->withQueryString()->links('pagination::bootstrap-5') }}
               </div>
               <div class="card-footer clearfix">
                  <div class="d-flex justify-content-end">
                  </div>
               </div>
               <div class="modal fade" id="viewModal"  tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false">
                  <div class="modal-dialog modal-md">
                     <div class="modal-content" id="printableArea">
                       
                        <div class="modal-header">
                           <h5 class="modal-title">Payment Details</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                         <div style="text-align: center;">
                           <img src="{{ asset('admin/layout/assets/images/logo.svg') }}" alt="Logo" style="max-width: 100px;">
                        </div>
                        <div class="modal-body">
                           <table class="table table-bordered mb-0">
                              <tr>
                                 <th>Merchant Name</th>
                                 <td id="modalmerchantName">{{Auth::user()->name}}</td>
                              </tr>
                              <tr>
                                 <th>Name</th>
                                 <td id="modalAccountName"></td>
                              </tr>
                              <tr>
                                 <th>Amount</th>
                                 <td id="modalAmount"></td>
                              </tr>
                              <tr>
                                 <th>Order Id</th>
                                 <td id="modaltransactionid"></td>
                              </tr>
                              <tr>
                                 <th>UTR</th>
                                 <td id="modalUtr"></td>
                              </tr>
                              <tr>
                                 <th>Date</th>
                                 <td id="modalDate"></td>
                              </tr>
                              <tr>
                                 <th>Status</th>
                                 <td id="modalstatus"></td>
                              </tr>
                           </table>
                        </div>
                        <div class="modal-footer">
                           <button class="btn btn-primary" onclick="printModalContent()">Print</button>
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload()">
                           Close
                           </button>
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
   $(document).ready(function() {
              $('#payinTable').DataTable({
                 dom: 'Bfrtip', // B = buttons, f = filter, r = processing, t = table, i = info, p = pagination
                 buttons: [
                    {
                       extend: 'copyHtml5',
                       text: 'Copy',
                       className: 'btn btn-secondary'
                    },
                    {
                       extend: 'excelHtml5',
                       text: 'Export to Excel',
                       className: 'btn btn-success'
                    }
                 ],
                 paging: false,
                 searching: true,
                 ordering: true,
                 responsive: true
              });
   
            $('.view-btn').on('click', function () {
                 let orderId = $(this).data('orderid');
                 let transactionid = $(this).data('transaction');
                 let type = $(this).data('type');
                 
                 $('#modalmerchantName').text($(this).data('merchant-name'));
                 $('#modalAccountName').text($(this).data('account-name'));
                 $('#modaltransactionid').text($(this).data('orderid'));
                 $('#modalAmount').text($(this).data('amount'));
                 $('#modalDate').text($(this).data('date'));
                 $('#modalstatus').text($(this).data('status'));
                 $('#modalUtr').text($(this).data('utr'));
                 
   
                 new bootstrap.Modal(document.getElementById('viewModal')).show();
           
     
              $.ajax({
                 url: "{{ route('payin.status') }}",
                type: "POST",
                data: {
                   orderId: orderId,
                   transactionid: transactionid,
                   type: type,
                   _token: "{{ csrf_token() }}"
                },
                success: function (response) {
   
                   if(response.success) {
                      $('#modalstatus').text(response.txnStatus);
                      $('#modalUtr').text(response.utr);
          
                   } else {
                       
                      console.error('Status update failed');
                   }
                },
                error: function (xhr) {
                  let res = xhr.responseJSON;
                  if (res) {
                      $('#modalstatus').text(res.data.resultStatus); // <-- yaha status print hoga
                  } else {
                      $('#modalstatus').text('PENDING');
                  }
                   
                }
              });
           });
        });
    
    function printModalContent() {

        const printContents = document.getElementById('printableArea').innerHTML;

        const printWindow = window.open('', '', 'height=800,width=800');

        printWindow.document.write(`
            <html>
            <head>
                <title>Payment Details</title>

                <!-- Bootstrap CSS -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

                <!-- Your Admin Theme CSS (IMPORTANT) -->
                <link href="{{ asset('admin/layout/assets/style.css') }}" rel="stylesheet">

                <style>
                    body {
                        padding: 20px;
                    }

                    table {
                        width: 100%;
                    }

                    th {
                        background-color: #f8f9fa !important;
                    }

                    /* Hide modal buttons in print */
                    .modal-footer,
                    .btn-close {
                        display: none !important;
                    }
                </style>
            </head>

            <body onload="window.print(); window.close();">
                <div class="modal-content">
                    ${printContents}
                </div>
            </body>
            </html>
        `);

        printWindow.document.close();
    }


   
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