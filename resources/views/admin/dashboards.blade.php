@extends('adminlayouts.app')
@section('title', 'ADMIN DASHBAORD')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview"
                                role="tab" aria-controls="overview" aria-selected="true">Our Business Overview</a>
                        </li>
                        <!-- <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Audiences</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab" aria-selected="false">Demographics</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">More</a>
                      </li> -->
                    </ul>

                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="statistics-details d-flex align-items-center justify-content-between">
                                    <!-- Bounce Rate -->
                                    <div>
                                        <p class="statistics-title">Merchant Wallet Balance</p>
                                        <h3 class="rate-percentage">{{$merchantWalletAmount}}</h3>
                                    </div>

                                    <!-- Page Views -->
                                    <div>
                                        <p class="statistics-title">Today Add Money</p>
                                        <h3 class="rate-percentage">12,450</h3>
                                        
                                    </div>

                                    <!-- New Sessions -->
                                    <div>
                                        <p class="statistics-title">Today Send Moey</p>
                                        <h3 class="rate-percentage">78.5%</h3>
                                       
                                    </div>

                                    <!-- Avg. Time on Site -->
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Applied Charges</p>
                                        <h3 class="rate-percentage">3m:12s</h3>
                                        
                                    </div>

                                    <!-- Conversion Rate -->
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Conversion Rate</p>
                                        <h3 class="rate-percentage">5.8%</h3>
                                        <p class="text-success d-flex">
                                            <i class="mdi mdi-menu-up"></i>
                                            <span>+0.4%</span>
                                        </p>
                                    </div>

                                    <!-- User Retention -->
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">User Retention</p>
                                        <h3 class="rate-percentage">62.3%</h3>
                                        <p class="text-danger d-flex">
                                            <i class="mdi mdi-menu-down"></i>
                                            <span>-1.1%</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Pending Requests</h4>
                                                        <p class="card-subtitle card-subtitle-dash">You have 5 new
                                                            requests</p>
                                                    </div>
                                                </div>

                                                <div class="table-responsive mt-3">
                                                    <table class="table select-table">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <input type="checkbox" id="check-all">
                                                                </th>
                                                                <th>Customer</th>
                                                                <th>Company</th>
                                                                <th>Progress</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <!-- Row 1 -->
                                                            <tr>
                                                                <td><input type="checkbox"></td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <!-- <img src="assets/images/faces/face1.jpg" alt=""> -->
                                                                        <div class="ms-2">
                                                                            <h6>Rahul Sharma</h6>
                                                                            <p class="text-muted">Manager</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h6>TechSoft Pvt Ltd</h6>
                                                                    <p class="text-muted">IT Services</p>
                                                                </td>
                                                                <td>
                                                                    <div class="progress progress-md">
                                                                        <div class="progress-bar bg-success"
                                                                            style="width: 80%"></div>
                                                                    </div>
                                                                    <small>80%</small>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-opacity-warning">In
                                                                        Progress</span>
                                                                </td>
                                                                <td>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-primary text-white">View
                                                                        Status</a>
                                                                </td>
                                                            </tr>

                                                            <!-- Row 2 -->
                                                            <tr>
                                                                <td><input type="checkbox"></td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <!-- <img src="assets/images/faces/face2.jpg" alt=""> -->
                                                                        <div class="ms-2">
                                                                            <h6>Anita Verma</h6>
                                                                            <p class="text-muted">HR</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h6>Global Corp</h6>
                                                                    <p class="text-muted">Consulting</p>
                                                                </td>
                                                                <td>
                                                                    <div class="progress progress-md">
                                                                        <div class="progress-bar bg-warning"
                                                                            style="width: 45%"></div>
                                                                    </div>
                                                                    <small>45%</small>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge badge-opacity-danger">Pending</span>
                                                                </td>
                                                                <td>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-primary text-white">View
                                                                        Status</a>
                                                                </td>
                                                            </tr>

                                                            <!-- Row 3 -->
                                                            <tr>
                                                                <td><input type="checkbox"></td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <!-- <img src="assets/images/faces/face3.jpg" alt=""> -->
                                                                        <div class="ms-2">
                                                                            <h6>Amit Patel</h6>
                                                                            <p class="text-muted">Admin</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h6>FinServe Ltd</h6>
                                                                    <p class="text-muted">Finance</p>
                                                                </td>
                                                                <td>
                                                                    <div class="progress progress-md">
                                                                        <div class="progress-bar bg-success"
                                                                            style="width: 100%"></div>
                                                                    </div>
                                                                    <small>100%</small>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge badge-opacity-success">Completed</span>
                                                                </td>
                                                                <td>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-primary text-white">View
                                                                        Status</a>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Market Overview</h4>
                                                        <p class="card-subtitle card-subtitle-dash">Lorem ipsum dolor
                                                            sit amet consectetur adipisicing elit</p>
                                                    </div>
                                                    <div>
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0"
                                                                type="button" id="dropdownMenuButton2"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"> This month </button>
                                                            <div class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton2">
                                                                <h6 class="dropdown-header">Settings</h6>
                                                                <a class="dropdown-item" href="#">Action</a>
                                                                <a class="dropdown-item" href="#">Another action</a>
                                                                <a class="dropdown-item" href="#">Something else
                                                                    here</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#">Separated link</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                    <div
                                                        class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                        <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                                        <h4 class="me-2">USD</h4>
                                                        <h4 class="text-success">(+1.37%)</h4>
                                                    </div>
                                                    <div class="me-3">
                                                        <div id="marketingOverview-legend"></div>
                                                    </div>
                                                </div>
                                                <div class="chartjs-bar-wrapper mt-3">
                                                    <canvas id="marketingOverview"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->

@endsection