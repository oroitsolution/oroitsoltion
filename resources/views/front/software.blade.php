@extends('frontlayout.app')

@section('content')
@push('styles')
<style>
    /* HERO */
.software-hero {
    background: linear-gradient(135deg, #155bd5, #155bd5);
    color: #fff;
    padding: 100px 0;
}

.software-hero h1 {
    font-size: 48px;
    font-weight: 700;
    color: #fff;
    
}

.software-hero p {
    font-size: 18px;
    opacity: 0.9;
    color: #fff;
}

.hero-img {
    max-height: 380px;
}

/* SERVICES */
.software-services {
    padding: 80px 0;
}

.section-title h2 {
    font-weight: 700;
    margin-bottom: 10px;
}

.section-title p {

    margin-bottom: 50px;
}

.software-card {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    transition: all .3s ease;
    height: 100%;
}

.software-card:hover {
    transform: translateY(-8px);
}

.software-card .icon {
    width: 60px;
    height: 60px;
    background: #1a5bd7;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin-bottom: 20px;
}

.software-card h4 {
    font-weight: 600;
    margin-bottom: 10px;
}

.software-card p {
    color: #6c757d;
    font-size: 15px;
}

.read-more {
    color: #1a5bd7;
    font-weight: 500;
    text-decoration: none;
}

/* CTA */
.software-cta {
    background: linear-gradient(135deg, #155bd5, #155bd5);
    padding: 70px 0;
    color: #fff;
}

.software-cta h2 {
    font-weight: 700;
    color: #fff;
}

.software-cta p {
   
    color: #fff;
}


</style>
@endpush

<!-- ======= Hero Section ======= -->
<section class="software-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1>Powerful Software Solutions<br>For Modern Businesses</h1>
                <p>
                    We design scalable, secure, and user-friendly software solutions
                    that help businesses automate operations and grow faster.
                </p>
                <a href="{{ route('/') }}" class="btn btn-light btn-lg mt-3">
                    Get Started
                </a>
            </div>

            <div class="col-lg-5 text-center">
                <img src="{{ asset('front/images/header/hero3.png') }}"
                     class="img-fluid hero-img" alt="Software Solutions">
            </div>
        </div>
    </div>
</section>

<!-- ======= Software Services ======= -->
<section class="software-services">
    <div class="container">
        <div class="section-title text-center">
            <h2>Our Software Products</h2>
            <p>Smart, scalable, and industry-ready solutions</p>
        </div>

        <div class="row g-4">
            @php
                $services = [
                    ['icon'=>'lni-users','title'=>'CRM Software','desc'=>'Manage leads, customers, and sales pipelines efficiently.'],
                    ['icon'=>'lni-briefcase','title'=>'HRM Software','desc'=>'Automate payroll, attendance, and employee management.'],
                    ['icon'=>'lni-graduation','title'=>'School Management','desc'=>'Complete digital solution for schools & institutes.'],
                    ['icon'=>'lni-write','title'=>'Online Examination','desc'=>'Secure online exams with auto evaluation.'],
                    ['icon'=>'lni-coffee-cup','title'=>'Cafe Billing','desc'=>'Fast POS billing with inventory tracking.'],
                    ['icon'=>'lni-cog','title'=>'Custom Software','desc'=>'Tailor-made software solutions for your business.'],
                ];
            @endphp

            @foreach($services as $service)
            <div class="col-lg-4 col-md-6">
                <div class="software-card">
                    <div class="icon">
                        <i class="lni {{ $service['icon'] }}"></i>
                    </div>
                    <h4>{{ $service['title'] }}</h4>
                    <p>{{ $service['desc'] }}</p>
                    <a href="#" class="read-more">Learn More →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ======= CTA ======= -->
<section class="software-cta">
    <div class="container text-center">
        <h2>Need a Custom Software?</h2>
        <p>Let’s build something powerful together.</p>
        <a href="{{ route('/') }}" id = "cs-btn" class="btn btn-outline-light btn-lg">
            Contact Us
        </a>
    </div>
</section>

@endsection
