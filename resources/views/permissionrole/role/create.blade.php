@extends('adminlayouts.app')
@section('content')

<div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Roles</h4>
        
                   <form action="{{route('superadmin.roles.store')}}" method="post">
                						@csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter Your Name">
												@error('name')
												<div id="nameHelp" class="form-text" style="color:red">{{ $message }}</div>
												@enderror
											</div>
                                            <?php
                                                $groupedPermissions = $permissions->groupBy(function($permission) {
                                                    $parts = explode(' ', $permission->name);
                                                    return strtolower(end($parts)); // e.g. 'user' from 'edit user'
                                                });
                                            ?>

											 @foreach($groupedPermissions as $group => $groupPermissions)
                                                <div class="col-12 mb-2">
                                                    <h5 class="fw-bold text-danger">{{ ucfirst($group) }}</h5>
                                                </div>

                                                @foreach($groupPermissions as $permission)
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-check form-check-inline mb-3">
                                                            <label class="form-check-label">
                                                                <input name="permission[]" id="permission-{{ $permission->id }}" type="checkbox"
                                                                    class="form-check-input"
                                                                    value="{{ $permission->name }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                        <hr>
                                                    </div>
                                        
                                                @endforeach
                                            @endforeach
											
										</div>
                                            
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>


@endsection
