<!--====== SIDEBAR PART START ======-->

<div class="sidebar-left">
    <div class="sidebar-close">
        <a class="close" href="#close"><i class="lni lni-close"></i></a>
    </div>

    <div class="sidebar-content">
        
        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('/') }}">
                <img src="{{ asset('front/images/logo-og.png') }}" alt="Kortya Pay" />
            </a>
        </div>

        <!-- Short Fintech Intro -->
        <p class="text">
            Secure, seamless, and scalable fintech solutions — enabling businesses 
            to manage payments, automate finances, and grow with confidence.
        </p>

        <!-- Menu -->
        <div class="sidebar-menu">
            <h5 class="menu-title">Quick Links</h5>
            <ul>
                <li><a href="{{ url('/about') }}">About Us</a></li>
                <li><a href="{{ url('/services') }}">Our Services</a></li>
                <li><a href="{{ url('/blog') }}">Latest Updates</a></li>
                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
            </ul>
        </div>

        <!-- Social Media -->
        <div class="sidebar-social align-items-center justify-content-center">
            <h5 class="social-title">Follow Us</h5>
            <ul>
                <li>
                    <a href="https://www.facebook.com/profile.php?id=61572982887190">
                        <i class="lni lni-facebook-filled"></i>
                    </a>
                </li>
                <li>
                    <a href="https://x.com/kortyapay">
                        <i class="lni lni-twitter-original"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/company/106350576/admin/dashboard/">
                        <i class="lni lni-linkedin-original"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/">
                        <i class="lni lni-youtube"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>

<div class="overlay-left"></div>

<!--====== SIDEBAR PART ENDS ======-->
