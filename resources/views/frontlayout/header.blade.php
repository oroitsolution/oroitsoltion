<section class="navbar-area navbar-nine">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('front/images/logo-og.png') }}" alt="Logo" height="40">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNine" aria-controls="navbarNine"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
            </button>

            <!-- Menu & Auth Items -->
            <div class="collapse navbar-collapse" id="navbarNine">
                <!-- Main Navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="#hero-area">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>

                <!-- Auth Buttons -->
                @if (Route::has('login'))
                    <div class="navbar-nav ms-auto align-items-center">
                        @auth
                            <!-- Dashboard Button -->
                            <a href="{{ url('user/dashboard') }}" class="btn btn-dashboard">
                                <i class="lni lni-dashboard me-1"></i>Dashboard
                            </a>
                        @else
                            <!-- Login & Register Buttons with separator -->
                            <div class="d-flex align-items-center">
                                <!-- Login Button -->
                                <a href="{{ route('login') }}" class="btn btn-login text-white">
                                    <i class="lni lni-enter me-1"></i>Log In
                                </a>
                                
                                <!-- Separator -->
                                <span class="auth-separator mx-2 text-white">||</span>
                                
                                <!-- Register Button -->
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-register text-white">
                                        <i class="lni lni-user me-1"></i>Register
                                    </a>
                                @endif
                            </div>
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Sidebar Toggle -->
            <div class="navbar-btn d-none d-lg-inline-block">
                <a class="menu-bar" href="#side-menu-left">
                    <i class="lni lni-menu"></i>
                </a>
            </div>

        </nav>
        
        <!-- Bottom HR Line -->
        <hr class="navbar-bottom-line mt-0">
    </div>
</section>