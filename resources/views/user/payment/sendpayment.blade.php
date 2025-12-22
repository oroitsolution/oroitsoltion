@extends('userlayout.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body text-end">
            <a href="#" class="btn btn-primary"  data-bs-toggle="modal" id="addBeneficiaryBtn">Add Beneficiary</a>
            </p>
            <div class="table-responsive">
              <table class="table table-striped" >
                  <thead>
                        <tr>
                        <th>id</th>
                        <th><strong>Name</strong></th>
                        <th><strong>IFSC Code</strong></th>
                        <th><strong>Bank Name</strong></th>
                        <th><strong>Account Number</strong></th>
                        <th><strong>Actions</strong></th>
                        
                        </tr>
                      </thead>
                      <tbody id="postTable">
                     
                      </tbody>
              </table>
            </div>
          </div>
          
        </div>
      </div>
    </div>
</div>

  <div class="modal fade" id="payoutModal" tabindex="-1" aria-labelledby="payoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="payoutForm">
               @csrf
               <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="payAgainModalLabel">Add Beneficiary</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>

               <div class="modal-body">
                  <div class="mb-3">
                     <label for="ifsc" class="form-label">IFSC</label>
                     <input type="text" name="ifsc_code" value="{{ old('ifsc_code') }}" class="form-control" id="exampleInputIfsc" placeholder="Enter your Ifsc number"/>
                     <input type="hidden" name="id" id="payout">
                     <div id="ifscHelp" class="form-text text-danger"></div>
                  </div>

                  <div class="mb-3">
                     <label for="bankName" class="form-label">Bank Name</label>
                     <input type="text" name="bank_name" value="{{ old('bank_name') }}" class=" bankdata form-control" id="exampleInputbankname" placeholder="Enter Bank Name" readonly />
                     <div id="bankHelp" class="form-text text-danger"></div>
                  </div>

                  <div class="mb-3">
                     <label for="accountNumber" class="form-label">Account Number</label>
                     <input type="text" name="account_number" value="{{ old('account_number') }}" class="form-control" id="exampleInputaccountnumber" placeholder="Enter your account number">
                     <div id="accountnumberHelp" class="form-text text-danger"></div>
                  </div>

                  <div class="mb-3">
                     <label for="accountName" class="form-label">Account Name</label>
                        <input type="text" name="account_name" value="{{ old('account_name') }}" class="form-control" id="exampleInputaccountname" placeholder="Enter account holder name">
                        <div id="accountnameHelp" class="form-text text-danger"></div>
                  </div>

                  <div class="mb-3">
                     <label for="amount" class="form-label">Amount</label>
                     <input type="text" name="amount" value="{{ old('amount') }}" class="form-control" id="exampleInputamount" placeholder="Enter amount" />
                     <div id="amountHelp" class="form-text text-danger"></div>
                  </div>

               </div>

               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Send</button>
               </div>
            </form>
         </div>
      </div>


@endsection
@push('js')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    
   $(document).ready(function() {

       $('#payoutModal').modal({
            backdrop: 'static',
            keyboard: false
        });
      
      $('#exampleInputIfsc').on('keyup', function() {
         var ifscCode = $(this).val().trim();
         if (ifscCode.length === 11) {
            $.ajax({
                url: '/user/get-bank-details', 
               method: 'GET',
               data: { ifsc: ifscCode },
               success: function(response) {
                  $('#exampleInputbankname').val(response.BANK);
                  $('.bankdata').addClass('bg-light');
                  $('.bankdata').css('color', 'red');
                  $('#ifscHelp').text('');
               },
               error: function() {
                  $('#exampleInputbankname').val('');
                  $('#ifscHelp').text('Invalid IFSC Code');
               }
            });
         } else {
            $('#exampleInputbankname').val('');
            $('#ifscHelp').text('');
         }
      });
   });

      // CSRF setup
      $.ajaxSetup({
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });

      // Show modal
      $('#addBeneficiaryBtn').on('click', function() {
         $('#payoutForm')[0].reset();
         $('#payout').val('');
         $('#payoutForm').find('input').prop('disabled', false);
         $('#payoutModal').modal('show');

      });


      function fetchPosts() {
         $.get('/user/payment-show', function(data) {
            let rows = '';
            $.each(data.data, function(i, payout) {
               rows += `
                  <tr>
                     <td>${i + 1}</td>
                     <td>${payout.account_name}</td>
                     <td>${(payout.ifsc_code || '').toUpperCase()}</td>
                     <td>${payout.bank_name}</td>
                     <td>${payout.account_number}</td>
                     <td> <button class="btn btn-success" onclick="editPost(${payout.id}, '${payout.bank_name}', '${payout.ifsc_code}', '${payout.account_number}', '${payout.account_name}')">Edit</button></td>
                     <td><button class="btn btn-danger" onclick="deletePost(${payout.id})">Delete</button></td>
                  </tr>`;
            });
            $('#postTable').html(rows);
         });
      }

    $('#payoutForm').submit(function(e) {
         e.preventDefault();
         var formData = $(this).serialize();
         $('.form-text.text-danger').text('');

         $.ajax({
             url: '/user/payment-request-send',
            method: 'POST',
            data: formData,
          success: function(response) {
               if (response.status == 'false') {
                 
                  $('.resmsg').text(response.message);
                  $('.resmsg').removeClass('d-none');
                  $('#payoutForm')[0].reset();
                  $('#payoutModal').modal('hide');
                  setTimeout(function() {
                    location.reload();
                }, 2000);
               } else {
                  $('.resmsg').text(response.message);
                  $('.resmsg').removeClass('d-none');
                  $('.resmsg').removeClass('alert-danger');
                  $('.resmsg').addClass('alert-success');
                  $('#payoutForm')[0].reset();
                  fetchPosts();
                  $('#payoutModal').modal('hide');
               }
            },
            error: function(xhr) {
              
               if (xhr.status === 422) {
                  let errors = xhr.responseJSON.errors;
                  $('#ifscHelp').text(errors.ifsc_code?.[0] || '');
                  $('#bankHelp').text(errors.bank_name?.[0] || '');
                  $('#accountnumberHelp').text(errors.account_number?.[0] || '');
                  $('#accountnameHelp').text(errors.account_name?.[0] || '');
                  $('#amountHelp').text(errors.amount?.[0] || '');
               } else if (xhr.status === 409) {
                 if(xhr.responseJSON.message){
                  $('#accountnumberHelp').text(xhr.responseJSON.message || '');
                 }else{
                    $('#amountHelp').text(xhr.responseJSON.walletmessage || '');
                 }
               } else {
                  alert(xhr.responseJSON.message || 'Something went wrong');
               }
            }
         });
      });

     
       $(document).ready(fetchPosts);

      function editPost(id, bankname, ifsc, accountnumber, accountname) {
         $('#payout').val(id);
         $('#exampleInputbankname').val(bankname).prop('readonly', true);
         $('#exampleInputIfsc').val(ifsc).prop('readonly', true);
         $('#exampleInputaccountnumber').val(accountnumber).prop('readonly', true);
         $('#exampleInputaccountname').val(accountname).prop('readonly', true);
         $('#payoutModal').modal('show');
      }

    

   
   function deletePost(id) {
       
        if (confirm("Delete this post?")) {
            $.ajax({
                url: `/payoutamount/${id}`,
                method: 'DELETE',
                success: function() {
                    fetchPosts();
                }
            });
        }
    }
    
</script>
@endpush