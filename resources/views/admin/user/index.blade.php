@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row">  
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <!-- <a href="{{ route('superadmin.roles.create') }}" class="btn btn-primary">Create Roles</a> -->
            </p>
            <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                        <tr>
                          <th style="width: 10px">id</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Roles</th>
                          <th>Created</th>
                          <th>Action</th>
                        
                        </tr>
                      </thead>
                      <tbody>
                      @if($users->isNotEmpty())
                      @foreach($users as $user)
                        <tr class="align-middle">
                          <td>{{$user->id}}</td>
                          <td>{{$user->name}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{$user->roles->pluck('name')->implode(',')}}</td>
                          <td>{{\Carbon\Carbon::parse($user->created_at)->format('d M, Y')}}</td>
                          <td><a href="{{route('superadmin.users.edit',$user->id)}}" class="btn btn-bg btn-warning">Edit</a>
                          
                        </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
              </table>
            </div>
            <div class="card-footer clearfix">
            <div class="d-flex justify-content-end">
               {{ $users->links('pagination::bootstrap-5') }}
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