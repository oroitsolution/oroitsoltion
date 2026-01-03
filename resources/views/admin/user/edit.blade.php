@extends('adminlayouts.app')
@section('content')
<div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   <a href="{{ route('superadmin.users.index') }}" class="btn btn-primary" style="margin-left:20px">Back</a>
                    </p>
        
                  <form action="{{route('superadmin.users.update',$user->id)}}" method="post">
                @csrf
                <!--begin::Body-->
                <div class="card-body">
                <div class="mb-3">
                    <label for="exampleInputname" class="form-label">Name</label>
                    <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control" id="exampleInputname" aria-describedby="emailHelp" />

                    @error('name')
                    <div id="emailHelp" class="form-text" style="color:red">{{ $message }}</div>
                    @enderror

                    <label for="exampleInputemail" class="form-label">Email</label>
                    <input type="email" name="email" value="{{old('email',$user->email)}}" class="form-control" id="exampleInputemail" aria-describedby="emailHelp" />

                    @error('email')
                    <div id="emailHelp" class="form-text" style="color:red">{{ $message }}</div>
                    @enderror

                    @if($roles->isNotEmpty())
                        <div class="d-grid mt-4" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;"> 
                        @foreach($roles as $role)
                                <div class="form-check">
                                    <input {{ ($hasrols->contains($role->id)) ? 'checked' : ''}} id="role-{{$role->id}}" type="checkbox" name="role[]" class="form-check-input" value="{{ $role->name }}" />
                                    <label class="form-check-label" for="role-{{$role->id}}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

               
            </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection
