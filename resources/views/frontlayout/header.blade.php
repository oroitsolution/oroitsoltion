<section class="navbar-area navbar-nine">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <nav class="navbar navbar-expand-lg">
                    
                    <!-- Brand Logo -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('front/images/logo.png') }}" alt="Logo">
                    </a>

                    <!-- Mobile Toggle -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNine" aria-controls="navbarNine"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <!-- Menu Items -->
                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarNine">
                        <ul class="navbar-nav me-auto">

                            <li class="nav-item">
                                <a class="page-scroll active" href="#hero-area">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="page-scroll" href="#services">Services</a>
                            </li>

                            <li class="nav-item">
                                <a class="page-scroll" href="#pricing">Pricing</a>
                            </li>

                            <li class="nav-item">
                                <a class="page-scroll" href="#contact">Contact</a>
                            </li>

                        </ul>

                        <!-- AUTH BUTTONS ADDED HERE -->
                        @if (Route::has('login'))
                            <ul class="navbar-nav ms-auto align-items-center">

                                @auth
                                    <!-- Dashboard Button -->
                                    <li class="nav-item">
                                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark btn-sm mx-1">
                                            Dashboard
                                        </a>
                                    </li>
                                @else
                                    <!-- Login Button -->
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm mx-1">
                                            Log in
                                        </a>
                                    </li>

                                    <!-- Register Button -->
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a href="{{ route('register') }}" class="btn btn-dark btn-sm mx-1">
                                                Register
                                            </a>
                                        </li>
                                    @endif
                                @endauth

                            </ul>
                        @endif
                        <!-- AUTH BUTTONS END -->

                    </div>

                    <!-- Sidebar Menu Button -->
                    <div class="navbar-btn d-none d-lg-inline-block">
                        <a class="menu-bar" href="#side-menu-left">
                            <i class="lni lni-menu"></i>
                        </a>
                    </div>

                </nav>
                <!-- End Navbar -->

            </div>
        </div>
    </div>
</section>


<!-- ====== Header Hero Section ====== -->
<section id="hero-area" class="header-area header-eight">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 col-md-12">
                <div class="header-content">

                    <h1>Corporate & Business Site Template by Ayro UI.</h1>
                    <p>
                        We are a digital agency that helps brands to achieve their
                        business outcomes. We see technology as a tool to create
                        amazing things.
                    </p>

                    <div class="button">
                        <a href="javascript:void(0)" class="btn primary-btn">Get Started</a>

                        <a href="https://www.youtube.com/watch?v=r44RKWyfcFw"
                           class="glightbox video-button">
                            <span class="btn icon-btn rounded-full">
                                <i class="lni lni-play"></i>
                            </span>
                            <span class="text">Watch Intro</span>
                        </a>
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="header-image">
                    <img src="{{ asset('front/images/header/hero-image.jpg') }}" alt="Hero Image">
                </div>
            </div>

        </div>
    </div>
</section>
