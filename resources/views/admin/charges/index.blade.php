@extends('adminlayouts.app')
@section('title', 'Charges')

@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">User Charges</h4>

            <form id="chargeForm" method="POST">
            @csrf
                
                <div class="row">
                    <div class="form-group col-lg-6 mb-3">
                        <label class="form-label">User</label>
                        <select name="user_id" id="exampleuser" class="form-control wide">
                        <option value="">--Select--</option>
                        @foreach($user as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6 mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-control wide">
                        <option value="payout">Payout</option>
                        <option value="payin">Payin</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-6 mb-3">
                        <label class="form-label">Start Range</label>
                        <input type="number" name="start_range" class="form-control">
                    </div>

                    <div class="form-group col-lg-6 mb-3">
                        <label class="form-label">End Range</label>
                        <input type="number" name="end_range" class="form-control">
                    </div>

                    <div class="form-group col-lg-6 mb-3">
                        <label class="form-label">Charges Type</label>
                        <select name="charge_type" class="form-control wide">
                        <option value="percent">Percent</option>
                        <option value="fixed">Fixed</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-6 mb-3">
                        <label class="form-label">Charge</label>
                        <input name="charges" type="text" class="form-control">
                    </div>

                    <div class="form-group col-lg-6 mb-3">
                        <label class="form-label text-danger">Reserve Charge (%)</label>
                        <input name="reserve_charges" type="text" class="form-control">
                    </div>
                    </div>
                
                <button type="submit" class="btn btn-primary me-2">Submit</button>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">User Charges Table</h4>
            <table  id="userchargesdata" class="table table-bordered">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Start Range</th>
                            <th>End Range</th>
                            <th>Charges Type</th>
                            <th>Charges</th>
                            <th>Reserve Amount</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="chargesTableBody"></tbody>
                    </table>
            </div>
        </div>
        </div>
    </div>
</div>

          


@endsection

@push('js')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
function alertdata() {
  const alertBoxes = document.querySelectorAll("#formAlert, #deleteAlert");

  alertBoxes.forEach(alertBox => {
    if (!alertBox.classList.contains('d-none')) {
      alertBox.classList.add("fade", "show");
      setTimeout(() => {
        alertBox.classList.add("d-none");
        alertBox.classList.remove("fade", "show", "alert-success", "alert-danger");
      }, 3000);
    }
  });
}

$(document).ready(function () {
  // Initialize DataTable and store instance
  const chargesTable = $('#userchargesdata').DataTable({
    dom: 'f',
    paging: false,
    info: false,
    ordering: true,
    responsive: true
  });

  $('.dataTables_filter input')
    .addClass('form-control')
    .attr('placeholder', 'Search')
    .css({ display: 'inline-block', width: 'auto', marginLeft: '10px' });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function loadUserCharges(userId) {
    $.get(`/superadmin/charges/list/${userId}`, function (response) {
      chargesTable.clear(); // clear existing rows

      if (response.data.length > 0) {
        $.each(response.data, function (index, item) {
          chargesTable.row.add([
            index + 1,
            item.type,
            item.start_range,
            item.end_range,
            item.charge_type,
            item.charges,
            item.reserve_charges,
            `
              <button class="btn btn-sm btn-primary edit-btn" data-id="${item.id}" data-item='${JSON.stringify(item)}'>Edit</button>
              <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}">Delete</button>
            `
          ]);
        });
      }

      chargesTable.draw(); // redraw DataTable with new data
    });
  }

  $('#exampleuser').on('change', function () {
    let userId = $(this).val();
    let userName = $(this).find("option:selected").text();
    $('#chargesTitle').text(userName + ' Fees & Charges');
    userId ? loadUserCharges(userId) : chargesTable.clear().draw();
  });

  $('#userchargesdata').on('click', '.edit-btn', function () {
    let item = $(this).data('item');
    $('select[name="user_id"]').val(item.user_id);
    $('select[name="type"]').val(item.type);
    $('input[name="start_range"]').val(item.start_range);
    $('input[name="end_range"]').val(item.end_range);
    $('select[name="charge_type"]').val(item.charge_type);
    $('input[name="charges"]').val(item.charges);
    $('input[name="reserve_charges"]').val(item.reserve_charges);

    if (!$('#charge_id').length) {
      $('#chargeForm').append(`<input type="hidden" name="charge_id" id="charge_id" value="${item.id}">`);
    } else {
      $('#charge_id').val(item.id);
    }

    let btn = $('#chargeForm button[type="submit"]');
    btn.text('Update').removeClass('btn-primary').addClass('btn-success');
  });

  $('#chargeForm').on('submit', function (e) {
    e.preventDefault();
    let form = $(this);
    let formData = form.serialize();
    let chargeId = $('#charge_id').val();

    let ajaxUrl = chargeId ? `/admin/charges/${chargeId}` : `{{ route('superadmin.charges.store') }}`;
    let ajaxType = chargeId ? "PUT" : "POST";

    $('.text-danger').remove();

    $.ajax({
      url: ajaxUrl,
      type: ajaxType,
      data: formData,
      success: function () {
        $('#formAlertMessage').text(chargeId ? 'Updated successfully!' : 'Created successfully!');
        $('#formAlert').removeClass('d-none').removeClass('alert-danger').addClass('alert-success');
        alertdata();

        let userId = $('#exampleuser').val();
        loadUserCharges(userId);
        form.trigger('reset');
        $('#charge_id').remove();

        let btn = $('#chargeForm button[type="submit"]');
        btn.text('Submit').removeClass('btn-success').addClass('btn-primary');
      },
      error: function (xhr) {
        $('#formAlert').addClass('d-none');
        $('#formAlertMessage').text('');

        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          if (errors.charges) {
            $('#formAlertMessage').text(errors.charges[0]);
            $('#formAlert').removeClass('d-none').addClass('alert-danger');
          } else {
            $.each(errors, function (key, value) {
              $(`[name="${key}"]`).after(`<small class="text-danger">${value[0]}</small>`);
            });
          }
        } else {
          alert('Something went wrong!');
        }
      }
    });
  });

  $('#userchargesdata').on('click', '.delete-btn', function () {
    let id = $(this).data('id');
    let userId = $('#exampleuser').val();

    if (confirm('Are you sure you want to delete this charge?')) {
      $.ajax({
        url: `/admin/charges/${id}`,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function () {
          $('#deleteAlertMessage').text('Deleted successfully!');
          $('#deleteAlert').removeClass('d-none');
          alertdata();
          loadUserCharges(userId);
        },
        error: function () {
          alert('Error deleting the charge.');
        }
      });
    }
  });
});
</script>

@endpush

