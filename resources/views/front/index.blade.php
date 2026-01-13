@extends('frontlayout.app')
@section('content')

<!-- ====== Header Hero Section ====== -->
<section id="hero-area" class="header-area header-eight">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 col-md-12">
                <div class="header-content">

                    <h1>Smart IT & Fintech Solutions for Modern Businesses</h1>
                    <p>
                        We build secure, scalable, and intelligent financial technology platforms
                        that empower businesses to streamline payments, automate workflows, and
                        grow with confidence. Our mission is to make finance simpler, faster, and
                        more accessible through innovation.
                    </p>

                    <div class="button">
                        <a href="javascript:void(0)" class="btn primary-btn">Get Started</a>

                        <a href="https://www.youtube.com/watch?v=r44RKWyfcFw" class="glightbox video-button">
                            <span class="btn icon-btn rounded-full">
                                <i class="lni lni-play"></i>
                            </span>
                            <span class="text">Watch Intro</span>
                        </a>
                    </div>

                </div>
            </div>

            <!-- <div class="col-lg-6 col-md-12">
                <div class="header-image">
                    <img src="{{ asset('front/images/header/hero2.png') }}" alt="Hero Image">
                </div>
            </div> -->

            {{-- ==========  OLD (single image)  ==========
<div class="col-lg-6 col-md-12">
    <div class="header-image">
        <img src="{{ asset('front/images/header/hero2.png') }}" alt="Hero Image">
        </div>
    </div>
    --}}

    {{-- ==========  NEW (3-image slider)  ========== --}}
    <div class="col-lg-6 col-md-12">
        <div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active"
                    aria-current="true"></button>
                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="2"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner rounded-4 shadow">
                @php
                    $slides = ['hero3.png','hero1.png','hero5.png'];
                @endphp

                @foreach($slides as $key => $img)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img src="{{ asset('front/images/header/'.$img) }}" class="d-block w-100" alt="Slide {{ $key+1 }}">
                </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    </div>
    </div>
</section>


<!--====== ABOUT FIVE PART START ======-->

<section class="about-area about-five">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12">
                <div class="about-image-five">
                    <svg class="shape" width="106" height="134" viewBox="0 0 106 134" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="1.66654" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="1.66654" cy="132" r="1.66667" fill="#DADADA" />
                        <circle cx="16.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="16.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="16.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="16.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="16.333" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="16.333" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="16.333" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="16.333" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="16.333" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="16.333" cy="132" r="1.66667" fill="#DADADA" />
                        <circle cx="30.9998" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="30.9998" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="30.9998" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="30.9998" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="31" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6668" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="31" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6668" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="31" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6668" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="31" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6668" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="31" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6668" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="31" cy="132" r="1.66667" fill="#DADADA" />
                        <circle cx="74.6668" cy="132" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="45.6665" cy="132" r="1.66667" fill="#DADADA" />
                        <circle cx="89.3333" cy="132" r="1.66667" fill="#DADADA" />
                        <circle cx="60.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="1.66679" r="1.66667" fill="#DADADA" />
                        <circle cx="60.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="16.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="60.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="31.0001" r="1.66667" fill="#DADADA" />
                        <circle cx="60.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="45.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="60.333" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="60.3335" r="1.66667" fill="#DADADA" />
                        <circle cx="60.333" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="88.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="60.333" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="117.667" r="1.66667" fill="#DADADA" />
                        <circle cx="60.333" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="74.6668" r="1.66667" fill="#DADADA" />
                        <circle cx="60.333" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="103" r="1.66667" fill="#DADADA" />
                        <circle cx="60.333" cy="132" r="1.66667" fill="#DADADA" />
                        <circle cx="104" cy="132" r="1.66667" fill="#DADADA" />
                    </svg>
                    <img src="{{ asset('front/images/about/about-img1.jpg') }} " alt="about" />
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="about-five-content">
                    <h6 class="small-title text-lg">OUR STORY</h6>
                    <h2 class="main-title fw-bold">Our team comes with the experience and knowledge</h2>
                    <div class="about-five-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-who-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-who" type="button" role="tab" aria-controls="nav-who"
                                    aria-selected="true">Who We Are</button>
                                <button class="nav-link" id="nav-vision-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-vision" type="button" role="tab" aria-controls="nav-vision"
                                    aria-selected="false">our Vision</button>
                                <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-history" type="button" role="tab" aria-controls="nav-history"
                                    aria-selected="false">our History</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-who" role="tabpanel"
                                aria-labelledby="nav-who-tab">
                                <p>It is a long established fact that a reader will be distracted by the readable
                                    content of a page
                                    when
                                    looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                                    normal
                                    distribution of letters, look like readable English.</p>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    in some
                                    form,
                                    by injected humour.</p>
                            </div>
                            <div class="tab-pane fade" id="nav-vision" role="tabpanel" aria-labelledby="nav-vision-tab">
                                <p>It is a long established fact that a reader will be distracted by the readable
                                    content of a page
                                    when
                                    looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                                    normal
                                    distribution of letters, look like readable English.</p>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    in some
                                    form,
                                    by injected humour.</p>
                            </div>
                            <div class="tab-pane fade" id="nav-history" role="tabpanel"
                                aria-labelledby="nav-history-tab">
                                <p>It is a long established fact that a reader will be distracted by the readable
                                    content of a page
                                    when
                                    looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                                    normal
                                    distribution of letters, look like readable English.</p>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    in some
                                    form,
                                    by injected humour.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>

<!--====== ABOUT FIVE PART ENDS ======-->

<!-- ===== service-area start ===== -->

<section id="services" class="services-area services-eight">
    <div class="section-title-five">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content">
                        <h6>Services</h6>
                        <h2 class="fw-bold">Our Software Development Services</h2>
                        <p>
                            We build scalable, secure, and high-performance web and mobile
                            applications using modern technologies to help businesses
                            innovate, grow, and succeed in the digital world.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======  End Section Title Five ======-->

    <div class="container">
        <div class="row">

            <!-- Web Application Development -->
            <div class="col-lg-4 col-md-6">
                <div class="single-services">
                    <div class="service-icon">
                        <i class="lni lni-code"></i>
                    </div>
                    <div class="service-content">
                        <h4>Web Application Development</h4>
                        <p>
                            Robust, scalable, and secure web applications built using modern
                            frameworks to deliver seamless user experiences and high performance.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mobile App Development -->
            <div class="col-lg-4 col-md-6">
                <div class="single-services">
                    <div class="service-icon">
                        <i class="lni lni-mobile"></i>
                    </div>
                    <div class="service-content">
                        <h4>Mobile App Development</h4>
                        <p>
                            Cross-platform mobile applications developed using Flutter and
                            React Native for fast performance, native UI, and reduced time-to-market.
                        </p>
                    </div>
                </div>
            </div>

            <!-- UI/UX Design -->
            <div class="col-lg-4 col-md-6">
                <div class="single-services">
                    <div class="service-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div class="service-content">
                        <h4>UI / UX Design</h4>
                        <p>
                            Intuitive, user-centric designs focused on usability, accessibility,
                            and engaging experiences across web and mobile platforms.
                        </p>
                    </div>
                </div>
            </div>

            <!-- API & Backend Development -->
            <div class="col-lg-4 col-md-6">
                <div class="single-services">
                    <div class="service-icon">
                        <i class="lni lni-network"></i>
                    </div>
                    <div class="service-content">
                        <h4>API & Backend Development</h4>
                        <p>
                            Secure and scalable REST & GraphQL APIs with powerful backend
                            architectures to support modern applications and integrations.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cloud & DevOps -->
            <div class="col-lg-4 col-md-6">
                <div class="single-services">
                    <div class="service-icon">
                        <i class="lni lni-cloud"></i>
                    </div>
                    <div class="service-content">
                        <h4>Cloud & DevOps Solutions</h4>
                        <p>
                            Cloud-native deployments, CI/CD pipelines, and infrastructure
                            optimization for reliable, scalable, and cost-effective systems.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Maintenance & Support -->
            <div class="col-lg-4 col-md-6">
                <div class="single-services">
                    <div class="service-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="service-content">
                        <h4>Collection & Payment API</h4>
                        <p>
                            Secure and scalable payment APIs for seamless fund collection,
                            instant settlements, and real-time transaction tracking across
                            multiple payment modes.
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>


<!-- ===== service-area end ===== -->






<!-- Start Cta Area -->
<section id="call-action" class="call-action">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-9">
                <div class="inner-content">
                    <h2>
                        Empowering Businesses with <br />Smart Fintech Solutions
                    </h2>
                    <p>
                        From digital payments to API banking and financial automation,
                        we deliver secure and scalable fintech solutions designed to
                        streamline operations, reduce costs, and accelerate business growth.
                        Build smarter, faster, and more confidently with our technology.
                    </p>
                    <div class="light-rounded-buttons">
                        <a href="javascript:void(0)" class="btn primary-btn-outline">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Cta Area -->



<!-- Start Latest News Area -->
<div id="blog" class="latest-news-area section">
    <!--======  Start Section Title Five ======-->
    <div class="section-title-five">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content">
                        <h6>Latest Insights</h6>
                        <h2 class="fw-bold">Fintech News & Updates</h2>
                        <p>
                            Stay updated with the latest trends, innovations, and insights
                            shaping the future of financial technology across the globe.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======  End Section Title Five ======-->

    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6 col-12">
                <!-- Single News -->
                <div class="single-news">
                    <div class="image">
                        <a href="javascript:void(0)">
                            <img class="thumb" src="{{ asset('front/images/blog/1.jpg') }}" alt="Fintech Blog" />
                        </a>
                        <div class="meta-details">
                            <img class="thumb" src="{{ asset('front/images/blog/b6.jpg') }}" alt="Author" />
                            <span>BY FINTECH EXPERTS</span>
                        </div>
                    </div>
                    <div class="content-body">
                        <h4 class="title">
                            <a href="javascript:void(0)">
                                How Digital Payments Are Transforming Modern Businesses
                            </a>
                        </h4>
                        <p>
                            Digital transactions are reshaping the financial landscape. Learn how
                            UPI, wallets, and API banking are helping companies scale faster.
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Single News -->

            <div class="col-lg-4 col-md-6 col-12">
                <!-- Single News -->
                <div class="single-news">
                    <div class="image">
                        <a href="javascript:void(0)">
                            <img class="thumb" src="{{ asset('front/images/blog/2.jpg') }}" alt="Fintech Blog" />
                        </a>
                        <div class="meta-details">
                            <img class="thumb" src="{{ asset('front/images/blog/b6.jpg') }}" alt="Author" />
                            <span>BY FINTECH ANALYST</span>
                        </div>
                    </div>
                    <div class="content-body">
                        <h4 class="title">
                            <a href="javascript:void(0)">
                                The Rise of API Banking: What Every Business Should Know
                            </a>
                        </h4>
                        <p>
                            API banking enables automated payouts, collections, KYC checks,
                            and more. Here’s why it’s becoming essential for digital businesses.
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Single News -->

            <div class="col-lg-4 col-md-6 col-12">
                <!-- Single News -->
                <div class="single-news">
                    <div class="image">
                        <a href="javascript:void(0)">
                            <img class="thumb" src="{{ asset('front/images/blog/3.jpg') }}" alt="Fintech Blog" />
                        </a>
                        <div class="meta-details">
                            <img class="thumb" src="{{ asset('front/images/blog/b6.jpg') }}" alt="Author" />
                            <span>BY INDUSTRY LEADERS</span>
                        </div>
                    </div>
                    <div class="content-body">
                        <h4 class="title">
                            <a href="javascript:void(0)">
                                Future of Fintech: Automation, AI, and Secure Transactions
                            </a>
                        </h4>
                        <p>
                            Explore how artificial intelligence, automation, and advanced
                            security standards are redefining the future of financial systems.
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Single News -->

        </div>
    </div>
</div>

<!-- End Latest News Area -->

<!-- Start Brand Area -->
<div id="clients" class="brand-area section">
    <!--======  Start Section Title Five ======-->
    <div class="section-title-five">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content">
                        <h6>Meet our Clients</h6>
                        <h2 class="fw-bold">Our Awesome Clients</h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!--======  End Section Title Five ======-->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div class="clients-logos">
                    <div class="single-image">
                        <img src="{{ asset('front/images/client-logo/pb.png') }} " alt="Brand Logo Images" />
                    </div>
                    <div class="single-image">
                        <img src="{{ asset('front/images/client-logo/uideck.svg') }} " alt="Brand Logo Images" />
                    </div>
                    <div class="single-image">
                        <img src="{{ asset('front/images/client-logo/ayroui.svg') }} " alt="Brand Logo Images" />
                    </div>
                    <div class="single-image">
                        <img src="{{ asset('front/images/client-logo/mobiq.png') }}" alt="Brand Logo Images" />
                    </div>
                    <div class="single-image">
                        <img src="{{ asset('front/images/client-logo/equits.png') }} " alt="Brand Logo Images" />
                    </div>
                    <div class="single-image">
                        <img src="{{ asset('front/images/client-logo/cred.png') }} " alt="Brand Logo Images" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Brand Area -->

<!-- ========================= contact-section start ========================= -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-4">
                <div class="contact-item-wrapper">
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="lni lni-phone"></i>
                                </div>
                                <div class="contact-content">
                                    <h4>Contact</h4>
                                    <p>6377404459</p>
                                    <p>oroitsolution@gmail.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="lni lni-map-marker"></i>
                                </div>
                                <div class="contact-content">
                                    <h4>Address</h4>
                                    <p>Near Railway Station Kota</p>
                                    <p>Kota</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-12">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="lni lni-alarm-clock"></i>
                                </div>
                                <div class="contact-content">
                                    <h4>Schedule</h4>
                                    <p>24 Hours / 7 Days Open</p>
                                    <p>Office time: 10 AM - 6:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="contact-form-wrapper">
                    <div class="row">
                        <div class="col-xl-10 col-lg-8 mx-auto">
                            <div class="section-title text-center">
                                <span> Get in Touch </span>
                                <h2>
                                    Ready to Get Started
                                </h2>
                                <p>
                                    At vero eos et accusamus et iusto odio dignissimos ducimus
                                    quiblanditiis praesentium
                                </p>
                            </div>
                        </div>
                    </div>
                    @if (session('success'))
                    <div id="contact-success" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{route('contact.store')}}" method="post" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" id="name" placeholder="Name" required />
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" id="email" placeholder="Email" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="phone" id="phone" placeholder="Phone" required />
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="subject" id="email" placeholder="Subject" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <textarea name="message" id="message" placeholder="Type Message" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="button text-center rounded-buttons">
                                    <button type="submit" class="btn primary-btn rounded-full">
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ========================= contact-section end ========================= -->

<!-- ========================= map-section end ========================= -->
<section class="map-section map-style-9">
    <div class="map-container">
        <object style="border:0; height: 500px; width: 100%;"
            data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3102.7887109309127!2d-77.44196278417968!3d38.95165507956235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzjCsDU3JzA2LjAiTiA3N8KwMjYnMjMuMiJX!5e0!3m2!1sen!2sbd!4v1545420879707"></object>
    </div>
    </div>
</section>
<!-- ========================= map-section end ========================= -->


@endsection