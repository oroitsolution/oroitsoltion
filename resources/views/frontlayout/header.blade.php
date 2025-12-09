<section class="navbar-area navbar-nine shadow-sm py-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <nav class="navbar navbar-expand-lg">

                    <!-- Brand Logo -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="logo-img" src="{{ asset('front/images/logo-og.png') }}" 
                             alt="Logo" style="height: 55px; width: auto;">
                    </a>

                    <!-- Mobile Toggle -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNine">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <!-- Menu Items -->
                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarNine">

                        <ul class="navbar-nav mx-auto gap-lg-4 align-items-center">

                            <li class="nav-item">
                                <a class="nav-link page-scroll active" href="#hero-area">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#services">Services</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#contact">Contact</a>
                            </li>

                        </ul>

                        <!-- AUTH BUTTONS -->
                        @if (Route::has('login'))
                            <ul class="navbar-nav ms-auto align-items-center">

                                @auth
                                    <!-- Dashboard Button -->
                                    <li class="nav-item">
                                        <a href="{{ url('/dashboard') }}" class="btn btn-dashboard px-3">
                                            Dashboard
                                        </a>
                                    </li>

                                @else

                                    <!-- Login Button -->
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="btn btn-login px-3">
                                            Login
                                        </a>
                                    </li>

                                    <!-- Register Button -->
                                    @if (Route::has('register'))
                                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                            <a href="{{ route('register') }}" class="btn btn-register px-3">
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
                    <div class="navbar-btn d-none d-lg-inline-block ms-3">
                        <a class="menu-bar" href="#side-menu-left">
                            <i class="lni lni-menu fs-3"></i>
                        </a>
                    </div>

                </nav>

            </div>
        </div>
    </div>
</section>
