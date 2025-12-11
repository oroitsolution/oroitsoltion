<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ====== Meta Tags ====== -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ====== Title ====== -->
    <title>Oro IT Solution</title>

    <!-- ====== Favicon ====== -->
    <link rel="shortcut icon" href="{{ asset('front/images/favicon.png') }}" type="image/svg">

    <!-- ====== CSS Files ====== -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/lineicons.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body id="bg-oro">

    <!-- ====== HEADER START ====== -->
    @include('frontlayout.header')

    <!-- ====== SIDEBAR START ====== -->
    @include('frontlayout.sidebar')
    <!-- ====== HEADER & SIDEBAR END ====== -->


    <!-- ====== PAGE CONTENT ====== -->
    @yield('content')
    <!-- ====== PAGE CONTENT END ====== -->


    <!-- ====== FOOTER ====== -->
    @include('frontlayout.footer')


    <!-- ====== SCROLL TOP BUTTON ====== -->
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ====== JS FILES ====== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('front/js/tiny-slider.js') }}"></script>
    <!-- Your main JS -->
    <script src="{{ asset('front/js/main.js') }}"></script>

    <!-- ====== Custom Scripts ====== -->
    <script>
        // Navbar toggler
        let navbarTogglerNine = document.querySelector(".navbar-nine .navbar-toggler");
        navbarTogglerNine.addEventListener("click", function () {
            navbarTogglerNine.classList.toggle("active");
        });

        // Sidebar
        let sidebarLeft = document.querySelector(".sidebar-left");
        let overlayLeft = document.querySelector(".overlay-left");
        let sidebarClose = document.querySelector(".sidebar-close .close");

        overlayLeft.addEventListener("click", function () {
            sidebarLeft.classList.remove("open");
            overlayLeft.classList.remove("open");
        });

        sidebarClose.addEventListener("click", function () {
            sidebarLeft.classList.remove("open");
            overlayLeft.classList.remove("open");
        });

        let sideMenuLeftNine = document.querySelector(".navbar-nine .menu-bar");
        sideMenuLeftNine.addEventListener("click", function () {
            sidebarLeft.classList.add("open");
            overlayLeft.classList.add("open");
        });

        // Lightbox
        GLightbox({
            href: 'https://www.youtube.com/watch?v=r44RKWyfcFw',
            type: 'video',
            source: 'youtube',
            width: 900,
            autoplayVideos: true,
        });
    </script>

</body>

</html>
