@extends('frontlayout.app')

@section('content')
    <div class="auth-page">
        <div class="auth-bg"
            style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('front/images/header/register.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
            <div class="auth-overlay"></div>

            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-lg-10 col-xl-9">
                        <div class="auth-card shadow-lg">
                            <div class="row g-0">
                                <!-- Left Side - Brand/Info Section -->
                                <div class="col-lg-5 d-none d-lg-block">
                                    <div class="auth-sidebar h-100">
                                        <div class="sidebar-overlay"></div>
                                        <div class="auth-sidebar-content p-4 p-lg-5">
                                            <!-- Logo -->
                                            <div class="mb-4 logo-container">
                                                <img src="{{ asset('front/images/logo-og.png') }}" alt="Logo"
                                                    class="sidebar-logo">
                                            </div>

                                            <!-- Brand Info -->
                                            <h2 class="fw-bold text-white mb-3">Join <span
                                                    class="text-brand-light">Kortyapay</span> Today</h2>
                                            <p class="text-white mb-4">
                                                Create your account to access all features and start managing your finances
                                                with ease.
                                            </p>

                                            <!-- Features List -->
                                            <ul class="list-unstyled text-white-75">
                                                <li class="text-white mb-3">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Secure & Encrypted Transactions
                                                </li>
                                                <li class="text-white mb-3">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Instant Payment Processing
                                                </li>
                                                <li class="text-white mb-3">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    24/7 Customer Support
                                                </li>
                                                <li class="text-white mb-3">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Multi-Device Access
                                                </li>
                                                <li class="text-white mb-3">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    Real-time Notifications
                                                </li>
                                            </ul>

                                            <!-- Stats -->
                                            <div class="mt-auto pt-4 border-top border-white-25">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h3 class="text-white fw-bold mb-1">100K+</h3>
                                                            <p class="text-white small mb-0">Users</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h3 class="text-white fw-bold mb-1">24/7</h3>
                                                            <p class="text-white small mb-0">Support</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side - Registration Form -->
                                <div class="col-lg-7">

                                    <div class="auth-form-container p-4 p-lg-5">
                                        <!-- Mobile Logo -->
                                        <div class="text-center d-lg-none mb-4">
                                            <img src="{{ asset('front/images/logo-og.png') }}" alt="Logo"
                                                class="mobile-logo">
                                        </div>

                                        <!-- Heading -->
                                        <div class="text-center">
                                            <h4 class="fw-bold mb-2 text-white">Create Account</h4>
                                            <p class="text-white mb-0">Register to access your Kortyapay account</p>
                                        </div>

                                        <!-- Registration Form -->
                                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                                            @csrf

                                            <!-- Account Type -->
                                            <div class="mb-4">
                                                <label class="form-label fw-medium">Account Type <span
                                                        class="text-danger">*</span></label>
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <div class="form-check card form-check-account-type h-100">
                                                            <input class="form-check-input" type="radio" name="account_type"
                                                                id="personal" value="personal" checked>
                                                            <label class="form-check-label text-center p-3" for="personal">
                                                                <i class="fas fa-user fa-lg mb-2 d-block"></i>
                                                                <span class="d-block fw-medium">Personal</span>
                                                                <small class="text-muted d-block">For individual use</small>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-check card form-check-account-type h-100">
                                                            <input class="form-check-input" type="radio" name="account_type"
                                                                id="business" value="business">
                                                            <label class="form-check-label text-center p-3" for="business">
                                                                <i class="fas fa-briefcase fa-lg mb-2 d-block"></i>
                                                                <span class="d-block fw-medium">Business</span>
                                                                <small class="text-muted d-block">For companies</small>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <!-- Name -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">Full Name <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-user text-muted"></i>
                                                        </span>
                                                        <input type="text" name="name" value="{{ old('name') }}"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            placeholder="Enter full name" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Email -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">Email Address <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-envelope text-muted"></i>
                                                        </span>
                                                        <input type="email" name="email" value="{{ old('email') }}"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            placeholder="Enter email" required>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Mobile -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">Mobile Number <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-phone text-muted"></i>
                                                        </span>
                                                        <input type="tel" name="mobile" class="form-control"
                                                            placeholder="Enter mobile number" required>
                                                    </div>
                                                </div>

                                                <!-- Address -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">Address</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-home text-muted"></i>
                                                        </span>
                                                        <input type="text" name="address" class="form-control"
                                                            placeholder="Enter address">
                                                    </div>
                                                </div>

                                                <!-- State & City -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">State</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                                        </span>
                                                        <input type="text" name="state" class="form-control"
                                                            placeholder="Enter state">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">City</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-city text-muted"></i>
                                                        </span>
                                                        <input type="text" name="city" class="form-control"
                                                            placeholder="Enter city">
                                                    </div>
                                                </div>

                                                <!-- Pincode -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">Pincode</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-map-pin text-muted"></i>
                                                        </span>
                                                        <input type="text" name="pincode" class="form-control"
                                                            placeholder="Enter pincode">
                                                    </div>
                                                </div>

                                                <!-- Passwords -->
                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">Password <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-lock text-muted"></i>
                                                        </span>
                                                        <input type="password" name="password" id="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            placeholder="Create password" required>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            id="togglePassword">
                                                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                                        </button>
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="password-strength mt-2">
                                                        <div class="strength-bar"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">Confirm Password <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-lock text-muted"></i>
                                                        </span>
                                                        <input type="password" name="password_confirmation"
                                                            id="confirmPassword" class="form-control"
                                                            placeholder="Confirm password" required>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            id="toggleConfirmPassword">
                                                            <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                                                        </button>
                                                    </div>
                                                    <div class="password-match-feedback mt-2 small"></div>
                                                </div>
                                            </div>

                                            <!-- Terms Agreement -->
                                            <div class="form-check mt-4 mb-4">
                                                <input class="form-check-input" type="checkbox" id="terms" required>
                                                <label class="form-check-label text-white" for="terms">
                                                    I agree to the <a href="#" class="text-brand fw-medium">Terms &
                                                        Conditions</a>
                                                    and <a href="#" class="text-brand fw-medium">Privacy Policy</a>
                                                </label>
                                                <div class="invalid-feedback mt-1">
                                                    You must agree to the terms before registering
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-brand btn-lg w-100 py-3 mb-3" style="background: linear-gradient(135deg, #667eea, #764ba2); 
                           color: white; 
                           border: none; 
                           border-radius: 12px;
                           font-weight: 600;
                           transition: all 0.3s ease;">
                                                    <span id="submitText" style="color: white;">Create Account</span>
                                                    <span id="submitSpinner"
                                                        class="spinner-border spinner-border-sm ms-2 d-none"
                                                        style="color: white;"></span>
                                                </button>
                                            </div>

                                            <!-- Login Link -->
                                            <div class="text-center pt-3 border-top border-white-25">
                                                <p class="text-white mb-0">
                                                    Already have an account?
                                                    <a href="{{ route('login') }}"
                                                        class="fw-bold text-white text-decoration-none ms-1"
                                                        style="text-shadow: 0 0 10px rgba(255,255,255,0.5);">
                                                        Sign In
                                                    </a>
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #e2e8f0;
            --text-light: #f1f5f9;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --danger-color: #ef4444;
            --success-color: #10b981;
            --warning-color: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        .auth-page {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .auth-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 1;
        }

        .auth-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(15, 23, 42, 0.75),
                    rgba(15, 23, 42, 0.85));
            backdrop-filter: blur(6px);
            z-index: 2;
        }

        .auth-card {
            position: relative;
            z-index: 3;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow:
                0 30px 60px rgba(0, 0, 0, .25),
                inset 0 1px 0 rgba(255, 255, 255, .6);
            overflow: hidden;
            margin: 1rem;
        }

        .auth-sidebar {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            position: relative;
            background-size: cover;
            background-position: center;
            min-height: 100%;
        }

        .sidebar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0, 0, 0, .15),
                    rgba(0, 0, 0, .45));
            z-index: 1;
        }

        .auth-sidebar-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Logo Styles - FIXED */
        .logo-container {
            position: relative;
            z-index: 3;
        }

        .sidebar-logo {
            max-height: 50px;
            height: auto;
            width: auto;
            display: block;
            filter: brightness(0) invert(1);
        }

        .mobile-logo {
            height: 45px;
            width: auto;
            display: block;
            margin: 0 auto;
        }

        .text-brand-light {
            color: #ffffff !important;
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.3);
        }

        .auth-form-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .auth-form-container h4 {
            font-size: 1.6rem;
            color: #ffffff;
            font-weight: 700;
        }

        .form-label {
            font-size: 13px;
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .auth-form-container p {
            font-size: 14px;
            color: var(--text-light);
        }

        /* Account Type Selection */
        .form-check-account-type {
            padding: 1.5rem;
            border: 2px solid var(--secondary-color);
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
            margin: 0;
            background: rgba(255, 255, 255, 0.1);
        }

        .form-check-account-type:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, .15);
        }

        .form-check-account-type .form-check-input {
            position: absolute;
            opacity: 0;
        }

        .form-check-account-type .form-check-label {
            cursor: pointer;
            width: 100%;
            color: var(--text-light);
        }

        .form-check-account-type .form-check-input:checked+.form-check-label {
            color: var(--primary-color);
        }

        .form-check-account-type.active {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.1);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .15);
        }

        /* Form Styles */
        .form-control {
            border-radius: 12px;
            padding: 0.8rem 1rem;
            border: 1.5px solid var(--secondary-color);
            font-size: 14px;
            background: var(--bg-light);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, .15);
        }

        .input-group-text {
            background: var(--bg-light);
            border: 1.5px solid var(--secondary-color);
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--text-muted);
            min-width: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .input-group .btn-outline-secondary {
            border: 1.5px solid var(--secondary-color);
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: var(--text-muted);
            background: var(--bg-light);
            transition: all 0.3s ease;
        }

        .input-group .btn-outline-secondary:hover {
            background: #e2e8f0;
            color: #475569;
        }

        /* Brand Button */
        .btn-brand {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: white;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            padding: 0.9rem 1.5rem;
        }

        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, .45);
            color: white;
        }

        .btn-brand:disabled {
            opacity: 0.7;
            transform: none;
            box-shadow: none;
        }

        .text-brand {
            color: var(--primary-color) !important;
        }

        /* Password Strength */
        .password-strength {
            height: 6px;
            background: var(--secondary-color);
            border-radius: 999px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 999px;
            transition: all 0.3s ease;
            background: var(--danger-color);
        }

        .password-match-feedback {
            min-height: 20px;
            font-size: 12px;
            margin-top: 0.25rem;
        }

        /* Form Check */
        .form-check-input {
            border-radius: 6px;
            border: 2px solid var(--secondary-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .auth-sidebar {
                display: none;
            }

            .auth-card {
                margin: 1rem;
                border-radius: 20px;
            }

            .auth-form-container {
                padding: 2rem !important;
            }
        }

        @media (max-width: 768px) {
            .auth-page {
                padding: 1rem 0;
            }

            .auth-card {
                margin: 0.5rem;
                border-radius: 18px;
            }

            .auth-form-container {
                padding: 1.5rem !important;
            }

            .btn-lg {
                padding: 0.8rem 1.25rem;
                font-size: 15px;
            }

            .form-check-account-type {
                padding: 1rem;
            }

            .form-check-account-type .form-check-label {
                font-size: 13px;
            }

            .form-control {
                padding: 0.7rem 0.9rem;
                font-size: 13px;
            }
        }

        @media (max-width: 576px) {
            .auth-form-container {
                padding: 1.25rem !important;
            }

            .row.g-3 {
                --bs-gutter-y: 1rem;
            }

            .col-md-6 {
                margin-bottom: 0.5rem;
            }

            .btn-brand {
                font-size: 14px;
                padding: 0.75rem 1rem;
            }

            .auth-form-container h4 {
                font-size: 1.4rem;
            }

            .form-check-account-type {
                padding: 0.8rem;
            }

            .form-check-account-type .fa-lg {
                font-size: 1.2em;
            }
        }

        @media (max-width: 400px) {
            .auth-form-container {
                padding: 1rem !important;
            }

            .form-check-account-type {
                padding: 0.6rem;
            }

            .form-control {
                padding: 0.6rem 0.8rem;
                font-size: 12px;
            }

            .input-group-text {
                min-width: 40px;
                padding: 0.6rem 0.8rem;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {

            .sidebar-logo,
            .mobile-logo {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }
        }

        /* Landscape orientation on mobile */
        @media (max-height: 600px) and (orientation: landscape) {
            .auth-page {
                min-height: auto;
                padding: 2rem 0;
            }

            .auth-card {
                margin: 1rem auto;
                max-width: 95%;
            }
        }

        /* Reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setupPasswordToggle('togglePassword', 'password', 'togglePasswordIcon');
            setupPasswordToggle('toggleConfirmPassword', 'confirmPassword', 'toggleConfirmPasswordIcon');
            setupAccountTypeSelection();
            setupFormValidation();
            setupPasswordStrength();
            setupPasswordMatch();
            setupResponsiveHelpers();
        });

        function setupPasswordToggle(toggleBtnId, inputId, iconId) {
            const toggleBtn = document.getElementById(toggleBtnId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (!toggleBtn || !input || !icon) return;

            toggleBtn.addEventListener('click', function () {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
                toggleBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                input.focus();
            });
        }

        function setupAccountTypeSelection() {
            const accountTypeCards = document.querySelectorAll('.form-check-account-type');

            accountTypeCards.forEach(card => {
                const radio = card.querySelector('.form-check-input');

                card.addEventListener('click', function () {
                    accountTypeCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    radio.checked = true;
                });

                if (radio.checked) {
                    card.classList.add('active');
                }
            });
        }

        function setupFormValidation() {
            const form = document.getElementById('registerForm');
            if (!form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                let isValid = true;

                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });

                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                const emailField = form.querySelector('input[type="email"]');
                if (emailField && emailField.value && !validateEmail(emailField.value)) {
                    emailField.classList.add('is-invalid');
                    isValid = false;
                }

                const password = document.getElementById('password')?.value;
                const confirmPassword = document.getElementById('confirmPassword')?.value;
                if (password !== confirmPassword) {
                    document.getElementById('confirmPassword').classList.add('is-invalid');
                    isValid = false;
                }

                const terms = document.getElementById('terms');
                if (!terms.checked) {
                    terms.classList.add('is-invalid');
                    isValid = false;
                }

                if (isValid) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const submitText = document.getElementById('submitText');
                    const submitSpinner = document.getElementById('submitSpinner');

                    if (submitBtn) submitBtn.disabled = true;
                    if (submitText) submitText.textContent = 'Creating Account...';
                    if (submitSpinner) submitSpinner.classList.remove('d-none');

                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                }
            });
        }

        function setupPasswordStrength() {
            const passwordInput = document.getElementById('password');
            if (!passwordInput) return;

            passwordInput.addEventListener('input', function () {
                const password = this.value;
                let strength = 0;
                let color = '#ef4444';

                if (password.length >= 8) strength += 25;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
                if (/\d/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;

                if (strength >= 75) color = '#10b981';
                else if (strength >= 50) color = '#f59e0b';
                else if (strength >= 25) color = '#f97316';

                const strengthBar = document.querySelector('.strength-bar');
                if (strengthBar) {
                    strengthBar.style.width = `${strength}%`;
                    strengthBar.style.backgroundColor = color;
                }
            });
        }

        function setupPasswordMatch() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirmPassword');
            const feedbackDiv = document.querySelector('.password-match-feedback');

            if (!passwordInput || !confirmInput || !feedbackDiv) return;

            function checkMatch() {
                const password = passwordInput.value;
                const confirm = confirmInput.value;

                if (!confirm) {
                    feedbackDiv.textContent = '';
                    return;
                }

                if (password === confirm) {
                    feedbackDiv.textContent = '✓ Passwords match';
                    feedbackDiv.style.color = '#10b981';
                } else {
                    feedbackDiv.textContent = '✗ Passwords do not match';
                    feedbackDiv.style.color = '#ef4444';
                }
            }

            passwordInput.addEventListener('input', checkMatch);
            confirmInput.addEventListener('input', checkMatch);
        }

        function setupResponsiveHelpers() {
            // Add touch device detection
            if ('ontouchstart' in window) {
                document.body.classList.add('touch-device');
            }

            // Handle keyboard appearance on mobile
            const inputs = document.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function () {
                    if (window.innerWidth <= 768) {
                        document.body.classList.add('keyboard-open');
                    }
                });

                input.addEventListener('blur', function () {
                    document.body.classList.remove('keyboard-open');
                });
            });
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
@endpush