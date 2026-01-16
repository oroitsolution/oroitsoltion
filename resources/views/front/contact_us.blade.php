@extends('frontlayout.app')
@section('content')

<!-- ====== HERO BANNER ====== -->
<section class="contact-hero d-flex align-items-center justify-content-center text-white position-relative">
    <div class="hero-overlay"></div>
    <div class="container text-center position-relative">
        <h1 class="display-4 fw-bold animate-fade text-white">Contact</h1>
        <p class="lead animate-fade-delay text-white ">Let's build something extraordinary together.</p>
    </div>
</section>

<!-- ====== CONTACT AREA ====== -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- LEFT: FORM -->
            <div class="col-lg-7">
                <div class="glass-card p-4 p-lg-5">
                    <h3 class="fw-bold mb-4 text-primary">Send Us a Message</h3>

                    <form method="POST" action="{{ route('contact.store') }}" id="contactForm" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                                <div class="invalid-feedback">Valid email required.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" required>
                                <div class="invalid-feedback">Subject is required.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea name="message" rows="4" class="form-control" required></textarea>
                                <div class="invalid-feedback">Please type your message.</div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="mdi mdi-send me-2"></i>Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RIGHT: INFO -->
            <div class="col-lg-5">
                <div class="glass-card p-4 p-lg-5 h-100">
                    <h3 class="fw-bold mb-4 text-primary">Get in Touch</h3>

                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <div class="icon-box"><i class="lni lni-map-marker"></i></div>
                            <div>
                                <strong>Registered Office</strong><br>
                                ORO IT SOLUTION PVT. LTD.<br>
                                404, Silicon Tower, Ahmedabad – 380015<br>
                                Gujarat, India
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="icon-box"><i class="lni lni-envelope"></i></div>
                            <div>
                                <strong>Email</strong><br>
                                <a href="mailto:support@oroitsolution.com">support@oroitsolution.com</a>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="icon-box"><i class="lni lni-phone"></i></div>
                            <div>
                                <strong>Phone</strong><br>
                                <a href="tel:+919825566644">+91 98255 66644</a>
                            </div>
                        </li>
                    </ul>

                    <hr class="my-4">
                    <p class="small text-muted mb-0">Business hours: Mon – Sat, 09:30 – 7:00 PM</p>

                    <!-- Social -->
                    <div class="mt-4">
                        <a href="#" class="social-link"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== INLINE STYLES & ANIMATIONS ====== -->
<style>
/* HERO BANNER */
.contact-hero {
    background: url("{{ asset('front/images/header/hero5.png') }}") center/cover no-repeat;
    min-height: 60vh;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .55);
}

.animate-fade {
    animation: fadeDown 1s ease;
}

.animate-fade-delay {
    animation: fadeDown 1s ease .3s both;
}

@keyframes fadeDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* GLASS CARD */
.glass-card {
    background: rgba(255, 255, 255, .85);
    backdrop-filter: blur(10px);
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, .1);
    border: 1px solid rgba(255, 255, 255, .3);
}

/* ICON BOX */
.icon-box {
    float: left;
    width: 48px;
    height: 48px;
    background: var(--bs-primary);
    color: #fff;
    border-radius: 50%;
    display: grid;
    place-items: center;
    margin-right: 1rem;
    font-size: 1.2rem;
}

/* SOCIAL LINKS */
.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: #e9ecef;
    border-radius: 50%;
    margin-right: .5rem;
    color: #495057;
    transition: background .3s, color .3s;
}

.social-link:hover {
    background: var(--bs-primary);
    color: #fff;
}

/* FORM VALIDATION */
.was-validated .form-control:invalid {
    border-color: #dc3545;
}
</style>

<!-- ====== JS: BOOTSTRAP VALIDATION ====== -->
<script>
(() => {
    'use strict';
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', e => {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
})();
</script>
@endsection