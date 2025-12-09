@extends('frontlayout.app')

@section('content')
<div class="container-fluid p-0" style="min-height: 100vh;">
    <div class="row g-0 min-vh-100">
        <!-- Left Column: Login Form -->
        <div class="col-lg-5 col-md-6 d-flex align-items-center">
            <div class="w-100 p-4 p-lg-5">
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <a href="{{ url('/') }}" class="text-decoration-none">
                                <img src="{{ asset('front/images/logo-og.png') }}" alt="Logo" 
                                     class="img-fluid" style="max-height: 50px;">
                            </a>
                        </div>

                        <!-- Welcome Text -->
                        <div class="text-center mb-5">
                            <h2 class="fw-bold text-dark mb-2">Welcome Back</h2>
                            <p class="text-muted mb-4">Sign in to your account to continue</p>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-envelope me-1"></i> Email Address
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Enter your email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-lock me-1"></i> Password
                                    </label>
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none small text-primary">
                                        Forgot Password?
                                    </a>
                                    @endif
                                </div>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Enter your password" 
                                           required>
                                    <button type="button" class="input-group-text bg-white border-start-0" id="togglePassword">
                                        <i class="fas fa-eye text-muted"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="remember_me" 
                                           name="remember">
                                    <label class="form-check-label text-muted" for="remember_me">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold mb-4">
                                <span id="loginBtnText">Sign In</span>
                                <span id="loginSpinner" class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                            </button>

                            <!-- Sign Up Link -->
                            <div class="text-center mt-4 pt-3 border-top">
                                <p class="text-muted mb-2">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">
                                        Sign up
                                    </a>
                                </p>
                                <a href="{{ url('/') }}" class="text-decoration-none small text-muted">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Footer Note -->
                    <div class="card-footer bg-transparent border-top text-center py-3">
                        <p class="small text-muted mb-0">
                            By signing in, you agree to our 
                            <a href="#" class="text-decoration-none text-primary">Terms</a> and 
                            <a href="#" class="text-decoration-none text-primary">Privacy Policy</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Hero Image -->
        <div class="col-lg-7 col-md-6 d-none d-md-block position-relative">
            <!-- Hero Image Background -->
            <div class="position-absolute top-0 start-0 w-100 h-100" 
                 style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('front/images/header/hero-image.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
            </div>
            
            <!-- Overlay Content -->
            <div class="position-relative h-100 d-flex align-items-center justify-content-center text-white p-5">
                <div class="text-center" style="max-width: 700px;">
                    <h1 class="display-4 fw-bold mb-4">Gro IT Solutions</h1>
                    <p class="lead fs-4 mb-4">
                        We are a digital agency that helps brands to achieve their business outcomes. 
                        We see technology as a tool to create amazing things.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center mt-5">
                        <a href="#" class="btn btn-light btn-lg px-4 py-3 fw-semibold">
                            <i class="fas fa-rocket me-2"></i> Get Started
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold">
                            <i class="fas fa-play-circle me-2"></i> Watch Intro
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary-color: #667eea;
        --secondary-color: #764ba2;
        --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        --border-radius: 20px;
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #f8fafc;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .min-vh-100 {
        min-height: 100vh;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    /* Form Styling */
    .form-control {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: var(--transition);
        background-color: white;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        background-color: white;
    }

    .input-group-lg .form-control,
    .input-group-lg .input-group-text {
        padding: 0.875rem 1rem;
        font-size: 1rem;
    }

    .input-group-text {
        background-color: white;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: var(--transition);
    }

    .input-group-text:first-child {
        border-right: none;
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .input-group-text:last-child {
        border-left: none;
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Button Styling */
    .btn-primary {
        background: var(--gradient);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        padding: 0.875rem 1.5rem;
        transition: var(--transition);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-light, .btn-outline-light {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.875rem 1.5rem;
        transition: var(--transition);
    }

    .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
    }

    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    /* Right Column Hero Image */
    .col-lg-7.col-md-6 {
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* Form Labels */
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    /* Error Messages */
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Checkbox Styling */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
    }

    /* Links */
    a.text-primary:hover {
        color: #764ba2 !important;
        text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 991.98px) {
        .col-lg-5 {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .col-lg-7 {
            display: none;
        }
        
        .w-100.p-4.p-lg-5 {
            padding: 2rem !important;
        }
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .display-4 {
            font-size: 2.5rem;
        }
        
        .lead.fs-4 {
            font-size: 1.25rem !important;
        }
        
        .btn-lg {
            padding: 0.75rem 1.25rem !important;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .w-100.p-4.p-lg-5 {
            padding: 1rem !important;
        }
        
        h2 {
            font-size: 1.75rem;
        }
        
        .btn-lg {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* Loading Spinner */
    #loginSpinner {
        vertical-align: middle;
    }

    /* Password Toggle Button Fix */
    #togglePassword {
        cursor: pointer;
        transition: var(--transition);
        background-color: white !important;
        border-color: #e2e8f0 !important;
    }

    #togglePassword:hover {
        background-color: #f8fafc !important;
        color: var(--primary-color) !important;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password visibility toggle - FIXED
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type');
                const icon = this.querySelector('i');
                
                if (type === 'password') {
                    passwordInput.setAttribute('type', 'text');
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    this.setAttribute('title', 'Hide password');
                } else {
                    passwordInput.setAttribute('type', 'password');
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    this.setAttribute('title', 'Show password');
                }
            });
        }

        // Form submission with loading state
        const loginForm = document.getElementById('loginForm');
        
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                // Simple client-side validation
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const loginBtn = this.querySelector('button[type="submit"]');
                const loginBtnText = document.getElementById('loginBtnText');
                const loginSpinner = document.getElementById('loginSpinner');
                
                if (!email || !password) {
                    e.preventDefault();
                    showToast('Please fill in all required fields', 'error');
                    return;
                }
                
                if (!validateEmail(email)) {
                    e.preventDefault();
                    showToast('Please enter a valid email address', 'error');
                    return;
                }
                
                // Show loading state
                loginBtn.disabled = true;
                loginBtnText.textContent = 'Signing In...';
                loginSpinner.classList.remove('d-none');
            });
        }

        // Email validation function
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            // Remove existing toast
            const existingToast = document.querySelector('.toast-container');
            if (existingToast) {
                existingToast.remove();
            }

            // Create toast container
            const toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';

            // Create toast element
            const toastEl = document.createElement('div');
            toastEl.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} border-0`;
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');

            // Toast content
            toastEl.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            toastContainer.appendChild(toastEl);
            document.body.appendChild(toastContainer);

            // Initialize and show toast
            const toast = new bootstrap.Toast(toastEl, {
                animation: true,
                autohide: true,
                delay: 3000
            });
            toast.show();
        }

        // Add input focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('input-focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('input-focused');
            });
        });

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-focus email field
        const emailField = document.getElementById('email');
        if (emailField && !emailField.value) {
            setTimeout(() => {
                emailField.focus();
            }, 300);
        }

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Add animation to form elements
        const formGroups = document.querySelectorAll('.mb-4');
        formGroups.forEach((group, index) => {
            group.style.opacity = '0';
            group.style.transform = 'translateY(20px)';
            group.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                group.style.opacity = '1';
                group.style.transform = 'translateY(0)';
            }, 100 * (index + 1));
        });
    });
</script>
@endpush