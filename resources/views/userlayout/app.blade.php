<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <title>@yield('title', '')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- endinject -->
    
    <link rel="stylesheet" href="{{asset('admin/layout/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/layout/assets/js/select.dataTables.min.css')}}">
    
    <link rel="stylesheet" href="{{asset('admin/layout/assets/css/style.css')}}">
   
    <link rel="shortcut icon" href="{{asset('admin/layout/assets/images/favicon.png')}}" />
     @stack('css')
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
        @include('userlayout.header')
        <div class="container-fluid page-body-wrapper">
            @include('userlayout.sidebar')
            <div class="main-panel">
                @yield('content')
                @include('userlayout.footer')
            </div>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('admin/layout/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('admin/layout/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
   
    <script src="{{asset('admin/layout/assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('admin/layout/assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
   
    <script src="{{asset('admin/layout/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/layout/assets/js/template.js')}}"></script>
    <script src="{{asset('admin/layout/assets/js/settings.js')}}"></script>
    <script src="{{asset('admin/layout/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/layout/assets/js/todolist.js')}}"></script>
  
    <script src="{{asset('admin/layout/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin/layout/assets/js/dashboard.js')}}"></script>
<!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> 



    
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
     @stack('js')

    <!-- End custom js for this page-->
  </body>
</html>