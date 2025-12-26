@extends('userlayout.app')
@section('title', 'Profile || ORO IT SOLUTION')
@section('content')



    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="bg-warning-subtle p-3 rounded">
                    <h4 class="mb-0">Profile</h4>
                    <small class="text-muted">Home / Profile</small>
                </div>
            </div>
        </div>

        <!-- Company Setting -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header fw-bold">Company Setting</div>
            <div class="card-body text-center">
                <img src="{{ asset('front/images/logo-og.png') }}" alt="Company Banner" class="img-fluid rounded"
                    style="max-height:140px;">
            </div>
        </div>

        <!-- User Profile -->
        <div class="card shadow-sm">
            <div class="card-header fw-bold">User Profile</div>

            <div class="card-body">
                <!-- Avatar & Info -->
                <div class="d-flex align-items-center mb-4">
                    <div class="position-relative">
                        <img src="{{ asset('admin/layout/assets/images/favicon.png') }}" class="rounded-circle border" width="70" height="70">
                        <span class="position-absolute bottom-0 end-0 bg-danger rounded-circle p-1">
                            <i class="bi bi-geo-alt-fill text-white small"></i>
                        </span>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-danger">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                </div>

                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" value="{{ $user->mobile_number }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" value="India" readonly>
                    </div>

                     <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="2" >{{ $user->address }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" value="{{ $user->state }}" >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" value="{{ $user->city }}" >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pin Code</label>
                        <input type="text" class="form-control" value="{{ $user->code }}" >
                    </div>

                   
                </div>

            </div>
        </div>

    </div>


@endsection

@push('js')
    <script>
    </script>
@endpush