@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Permissions</h4>
        
                   <form action="{{route('permissions.store')}}" method="post">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" name="name" value="" class="form-control" id="exampleInputName1" placeholder="Name">
                      </div>
                      @error('name')
                        <div id="emailHelp" class="form-text" style="color:red">{{$message}}</div>
                            @enderror
                      
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>



@endsection
