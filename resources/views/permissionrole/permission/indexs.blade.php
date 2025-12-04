@extends('adminlayout.app')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Permissions</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                 
                <a href="{{ route('permissions.create') }}" class="btn btn-primary">Create Permission</a>



                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header"><h3 class="card-title">Bordered Table</h3></div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">id</th>
                          <th>Name</th>
                          <th>Action</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                      @if($permissions->isNotEmpty())
                      @foreach($permissions as $value)
                        <tr class="align-middle">
                          <td>{{$value->id}}</td>
                          <td>{{$value->name}}</td>
                          <td><a href="{{ route('permissions.edit', $value->id) }}" class="btn btn-bg btn-warning">Edit</a>
                          <a href="javascript:void(0);" onclick="deletepermission({{$value->id}})" class="btn btn-bg btn-danger">Delete</a>
                        </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                    
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <div class="d-flex justify-content-end">
                        {{ $permissions->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            
                </div>
                
              </div>
             
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
@endsection
@push('js')
<script type="text/javascript">
    function deletepermission(id){
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: '{{ route("permissions.destroy") }}',
                type: 'DELETE',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',  // Correct casing here
                success: function(response){
                    window.location.href = '{{ route("permissions.index") }}';
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        }
    }
    
</script>
@endpush