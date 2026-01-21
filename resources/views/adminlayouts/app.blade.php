<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'ORO IT SOLUTON')</title>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/layout/assets/js/select.dataTables.min.css') }}">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/7.4.47/css/materialdesignicons.min.css">


    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('admin/layout/assets/css/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('admin/layout/assets/images/favicon.png') }}"/>

    {{-- ✅ CSS STACK (CORRECT) --}}
    @stack('styles')

    <style>
    /* Success */
    .toast-success {
        background-color: #28a745 !important;
        color: #ffffff !important;
    }

    /* Error */
    .toast-error {
        background-color: #dc3545 !important;
        color: #ffffff !important;
    }

    /* Warning */
    .toast-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    /* Info */
    .toast-info {
        background-color: #17a2b8 !important;
        color: #ffffff !important;
    }

    /* Toast body text */
    #toast-container > .toast {
        opacity: 1 !important;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        border-radius: 6px;
    }
</style>


</head>

<body class="with-welcome-text">
<div class="container-scroller">

    @include('adminlayouts.header')

    <div class="container-fluid page-body-wrapper">
        @include('adminlayouts.sidebar')

        <div class="main-panel">
            @yield('content')
            @include('adminlayouts.footer')
        </div>
    </div>

</div>

<!-- Core JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('admin/layout/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('admin/layout/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('admin/layout/assets/vendors/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('admin/layout/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>

<script src="{{ asset('admin/layout/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('admin/layout/assets/js/template.js') }}"></script>
<script src="{{ asset('admin/layout/assets/js/settings.js') }}"></script>
<script src="{{ asset('admin/layout/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('admin/layout/assets/js/todolist.js') }}"></script>

<script src="{{ asset('admin/layout/assets/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('admin/layout/assets/js/dashboard.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- ✅ JS STACK (CORRECT) --}}
@stack('js')

      <script>
       

        toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 3000,
        preventDuplicates: true,
    };

        </script>
</body>
</html>
