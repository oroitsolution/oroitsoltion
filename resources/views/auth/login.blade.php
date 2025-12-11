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
                                    <img src="{{ asset('front/images/logo-og.png') }}" alt="Logo" class="img-fluid"
                                        style="max-height: 50px;">
                                </a>
                            </div>

                            <!-- Welcome Text -->
                            <div class="text-center mb-5">
                                <h2 class="fw-bold text-dark mb-2">Welcome Back</h2>
                                <p class="text-muted mb-4">Sign in to your account to continue</p>
                            </div>

                            <!-- Login Form -->
                            <form method="POST" id="loginForm">
                                @csrf

                                <!-- Error Alert Container -->
                                <div id="loginErrorAlert" class="alert alert-danger d-none">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <span id="loginErrorText"></span>
                                </div>

                                <!-- Success Alert Container -->
                                <div id="loginSuccessAlert" class="alert alert-success d-none">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span id="loginSuccessText"></span>
                                </div>

                                <!-- Email Input -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-envelope me-1"></i> Email Address
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    <div class="invalid-feedback d-none mt-2" id="emailError">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                    </div>
                                </div>

                                <!-- Password Input -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="password" class="form-label fw-semibold text-dark">
                                            <i class="fas fa-lock me-1"></i> Password
                                        </label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}"
                                                class="text-decoration-none small text-primary">
                                                Forgot Password?
                                            </a>
                                        @endif
                                    </div>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Enter your password" required>
                                        <button type="button" class="input-group-text bg-white border-start-0"
                                            id="togglePassword">
                                            <i class="fas fa-eye text-muted" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback d-none mt-2" id="passwordError">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <span id="passwordErrorMessage"></span>
                                    </div>
                                </div>

                                <!-- Remember Me -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                        <label class="form-check-label text-muted" for="remember_me">
                                            Remember me
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-semibold mb-4"
                                    id="loginBtn">
                                    <span id="loginBtnText">Sign In</span>
                                    <span id="loginSpinner" class="spinner-border spinner-border-sm d-none ms-2"
                                        role="status"></span>
                                </button>

                                <!-- Sign Up Link -->
                                <div class="text-center mt-4 pt-3 border-top">
                                    <p class="text-muted mb-2">
                                        Don't have an account?
                                        <a href="{{ route('register') }}"
                                            class="text-decoration-none fw-semibold text-primary">
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
                    style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('front/images/header/ew.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
                </div>

                <!-- Overlay Content -->
                <div class="position-relative h-100 d-flex align-items-center justify-content-center text-white p-5">
                    <div class="text-center" style="max-width: 700px;">
                        <h1 class="display-4 fw-bold mb-4 text-white">ORO IT Solutions</h1>
                        <p class="lead fs-4 mb-4 text-white">
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

        .form-control.is-invalid {
            border-color: #ef4444;
            background-image: none;
            padding-right: 1rem;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
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

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
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
        }
    </style>
@endpush

@push('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // AJAX Login Form Submission
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');

            if (loginForm) {
                loginForm.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    // Reset previous errors
                    resetErrors();

                    // Validate form
                    if (!validateForm()) {
                        return;
                    }

                    // Show loading state
                    setLoadingState(true);

                    try {
                        const formData = new FormData(this);

                        const response = await fetch('{{ route("login") }}', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (response.ok) {
                            // Login successful
                            handleLoginSuccess(data);
                        } else {
                            // Login failed
                            handleLoginError(data, response.status);
                        }
                    } catch (error) {
                        // Network error
                        handleNetworkError(error);
                    } finally {
                        setLoadingState(false);
                    }
                });
            }

            // Form validation
            function validateForm() {
                let isValid = true;
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value.trim();

                // Email validation
                if (!email) {
                    showFieldError('email', 'Email address is required');
                    isValid = false;
                } else if (!validateEmail(email)) {
                    showFieldError('email', 'Please enter a valid email address');
                    isValid = false;
                }

                // Password validation
                if (!password) {
                    showFieldError('password', 'Password is required');
                    isValid = false;
                }

                return isValid;
            }

            // Email validation regex
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Show field error
            function showFieldError(fieldId, message) {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(fieldId + 'Error');

                if (field) {
                    field.classList.add('is-invalid');
                }

                if (errorDiv) {
                    errorDiv.classList.remove('d-none');
                    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i>${message}`;
                }
            }

            // Show general error alert
            function showErrorAlert(message) {
                const errorAlert = document.getElementById('loginErrorAlert');
                const errorText = document.getElementById('loginErrorText');

                if (errorAlert && errorText) {
                    errorText.textContent = message;
                    errorAlert.classList.remove('d-none');

                    // Hide after 5 seconds
                    setTimeout(() => {
                        errorAlert.classList.add('d-none');
                    }, 5000);
                }
            }

            // Show success alert
            function showSuccessAlert(message) {
                const successAlert = document.getElementById('loginSuccessAlert');
                const successText = document.getElementById('loginSuccessText');

                if (successAlert && successText) {
                    successText.textContent = message;
                    successAlert.classList.remove('d-none');
                }
            }

            // Reset all errors
            function resetErrors() {
                // Remove invalid classes
                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });

                // Hide error messages
                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.classList.add('d-none');
                });

                // Hide alerts
                document.getElementById('loginErrorAlert')?.classList.add('d-none');
                document.getElementById('loginSuccessAlert')?.classList.add('d-none');
            }

            // Set loading state
            function setLoadingState(isLoading) {
                const loginBtn = document.getElementById('loginBtn');
                const loginBtnText = document.getElementById('loginBtnText');
                const loginSpinner = document.getElementById('loginSpinner');

                if (loginBtn) {
                    loginBtn.disabled = isLoading;
                }

                if (loginBtnText) {
                    loginBtnText.textContent = isLoading ? 'Signing In...' : 'Sign In';
                }

                if (loginSpinner) {
                    loginSpinner.classList.toggle('d-none', !isLoading);
                }
            }

            // Handle successful login
            function handleLoginSuccess(data) {
                showSuccessAlert('Login successful! Redirecting...');

                // Store tokens if using API
                if (data.access_token) {
                    localStorage.setItem('access_token', data.access_token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                }

                // Redirect to intended page or dashboard
                setTimeout(() => {
                    window.location.href = data.redirect_to || '{{ url("/dashboard") }}';
                }, 1500);
            }

            // Handle login error
            function handleLoginError(data, statusCode) {
                let errorMessage = 'Login failed. Please try again.';

                if (statusCode === 422) {
                    // Validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const message = data.errors[field][0];
                            showFieldError(field, message);
                        });
                        errorMessage = 'Please fix the errors above.';
                    }
                } else if (statusCode === 401) {
                    errorMessage = data.message || 'Invalid email or password.';
                } else if (statusCode === 403) {
                    errorMessage = data.message || 'Your account has been suspended.';
                } else if (statusCode === 429) {
                    errorMessage = 'Too many login attempts. Please try again later.';
                }

                showErrorAlert(errorMessage);
            }

            // Handle network error
            function handleNetworkError(error) {
                console.error('Network error:', error);
                showErrorAlert('Network error. Please check your connection and try again.');
            }

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
        });

        // Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');
    
    console.log('Toggle Password Button:', togglePassword); // Debug log
    console.log('Password Input:', passwordInput); // Debug log
    console.log('Toggle Password Icon:', togglePasswordIcon); // Debug log
    
    // Function to toggle password visibility
    function togglePasswordVisibility() {
        if (!passwordInput || !togglePasswordIcon) return;
        
        // Toggle password field type
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
            togglePassword.setAttribute('aria-label', 'Hide password');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
            togglePassword.setAttribute('aria-label', 'Show password');
        }
        
        // Focus back on password field
        passwordInput.focus();
    }
    
    // Add click event listener
    if (togglePassword) {
        togglePassword.addEventListener('click', togglePasswordVisibility);
        
        // Also allow Enter key on the button
        togglePassword.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePasswordVisibility();
            }
        });
    }
    
    // Test button click (for debugging)
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            console.log('Toggle button clicked!');
            console.log('Current input type:', passwordInput.type);
        });
    }
});
    </script>
@endpush