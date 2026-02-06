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
                                    <div id="merchant-balance">
                                        <p class="statistics-title">Merchant Wallet Balance</p>
                                        <h3 class="rate-percentage" >{{$merchantWalletAmount}}</h3>
                                    </div>

                                    <!-- Page Views -->
                                    <div id="today-add-money">
                                        <p class="statistics-title">Today Add Money</p>
                                        <h3 class="rate-percentage" >12,450</h3>
                                        
                                    </div>

                                    <!-- New Sessions -->
                                    <div id="today-send-money">
                                        <p class="statistics-title">Today Send Moey</p>
                                        <h3 class="rate-percentage" >78.5%</h3>
                                       
                                    </div>

                                    <!-- Avg. Time on Site -->
                                    <div class="d-md-block" id="appliedcharges">
                                        <p class="statistics-title">Applied Charges</p>
                                        <h3 class="rate-percentage" >3m:12s</h3>
                                        
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

                                                <div class="table-responsive mt-3" id="payoutdata">
                                                    <table class="table select-table">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Trx id</th>
                                                                <th>Account Number</th>
                                                                <th>IFSC Code</th>
                                                                <th>UTR</th>
                                                                <th>Account Name</th>
                                                                <th>Amount</th>
                                                                <th>Status</th>
                                                                <th>date</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            
                                                              @if($data->isNotEmpty())
                                                                @foreach($data as $key=> $user)
                                                                    <tr class="align-middle">
                                                                    <td>{{$key+1}}</td>
                                                                    <td>{{$user->merchantname}}</td>
                                                                    <td>{{$user->trx_id}}</td>
                                                                    <td>{{$user->account_number}}</td>
                                                                    <td>{{$user->ifsc}}</td>
                                                                    <td>{{$user->utr}}</td>
                                                                    <td>{{$user->name}}</td>
                                                                    <td>{{$user->amount}}</td>
                                                                    <td>
                                                                        <span class="badge 
                                                                        @if($user->status == 'success') text-bg-success
                                                                        @elseif($user->status == 'failed') text-bg-danger
                                                                        @elseif($user->status == 'pending') text-bg-primary
                                                                        @elseif($user->status == 'Refunded') text-bg-info
                                                                        @else text-bg-secondary
                                                                        @endif">{{ $user->status }}
                                                                    
                                                                    </span>
                                                                 </td>
                                                                <td>{{\Carbon\Carbon::parse($user->txnRcvdTimeStamp)->format('d-m-y h:i:s')}}</td>
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

@push('js')
<script>
    setInterval(function() {
        $('#today-add-money').load(location.href + ' #today-add-money > *');
        $('#today-send-money').load(location.href + ' #today-send-money > *');
        $('#appliedcharges').load(location.href + ' #appliedcharges > *');
        $('#merchant-balance').load(location.href + ' #merchant-balance > *');
        $('#payoutdata').load(location.href + ' #payoutdata > *');  
    }, 4000);
</script>
@endpush