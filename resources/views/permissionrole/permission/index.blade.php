@extends('adminlayouts.app')
@section('content')

          <div class="content-wrapper">
            <div class="row">
             
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Permissions</h4>
                   <a href="{{ route('superadmin.permissions.create') }}" class="btn btn-primary">Create Permission</a>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                        <tr>
                          <th style="width: 10px">id</th>
                          <th>Name</th>
                          <th>Action</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                       <tbody>
                      @if($permissions->isNotEmpty())
                      @foreach($permissions as $value)
                        <tr class="align-middle">
                          <td>{{$value->id}}</td>
                          <td>{{$value->name}}</td>
                          <td><a href="{{ route('superadmin.permissions.edit', $value->id) }}" class="btn btn-bg btn-warning">Edit</a>
                          <a href="javascript:void(0);" onclick="deletepermission({{$value->id}})" class="btn btn-bg btn-danger">Delete</a>
                        </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
@endsection
@push('js')
<script type="text/javascript">
    function deletepermission(id){
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: '{{ route("superadmin.permissions.destroy") }}',
                type: 'DELETE',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',  // Correct casing here
                success: function(response){
                    window.location.href = '{{ route("superadmin.permissions.index") }}';
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        }
    }
    
</script>
@endpush