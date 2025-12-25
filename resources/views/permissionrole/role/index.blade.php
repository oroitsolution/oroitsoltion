@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
            <div class="row">
             
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Roles</h4>
                   <a href="{{ route('superadmin.roles.create') }}" class="btn btn-primary">Create Roles</a>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped">
                         <thead>
                        <tr>
                          <th style="width: 10px">id</th>
                          <th>Name</th>
                          <th>Permissions</th>
                          <th>Created</th>
                          <th>Action</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                       <tbody>
                      @if($roles->isNotEmpty())
                      @foreach($roles as $value)
                        <tr class="align-middle">
                          <td>{{$value->id}}</td>
                          <td>{{$value->name}}</td>
                          <td>{{$value->permissions->pluck('name')->implode(',')}}</td>
                          <td>{{\Carbon\Carbon::parse($value->created_at)->format('d M, Y')}}</td>
                          <td><a href="{{ route('superadmin.roles.edit', $value->id) }}" class="btn btn-bg btn-warning">Edit</a>
                          <a href="javascript:void(0);" onclick="deleterole({{$value->id}})" class="btn btn-bg btn-danger">Delete</a>
                        </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                      </table>
                    </div>
                    <div class="card-footer clearfix">
                    <div class="d-flex justify-content-end">
                        {{ $roles->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                  </div>
                </div>
              </div>
            </div>
          </div>


@endsection
@push('js')
<script type="text/javascript">
    function deleterole(id){
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: '{{ route("superadmin.roles.destroy") }}',
                type: 'DELETE',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',  // Correct casing here
                success: function(response){
                    window.location.href = '{{ route("superadmin.roles.index") }}';
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        }
    }
    
</script>
@endpush