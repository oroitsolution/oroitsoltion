<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ORO IT SOLUTION</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.15);
            --radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 1rem;
            position: relative;
        }

        .auth-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.9) 100%),
                        url('{{ asset("front/images/header/ew.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            animation: fadeIn 1s ease-out;
        }

        .auth-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease-out;
        }

        /* Left Side - Brand Section */
        .auth-brand-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .brand-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.1));
        }

        .brand-content {
            position: relative;
            z-index: 2;
            height: 100%;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            max-width: 180px;
            height: auto;
            filter: brightness(0) invert(1);
            margin-bottom: 2rem;
            transition: var(--transition);
        }

        .brand-logo:hover {
            transform: scale(1.05);
        }

        .brand-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.2rem;
            line-height: 1.3;
            margin-bottom: 1rem;
            color: white;
        }

        .brand-highlight {
            color: #ffd166;
            text-shadow: 0 2px 10px rgba(255, 209, 102, 0.3);
        }

        .brand-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
        }

        .features-list {
            list-style: none;
            margin-bottom: 3rem;
        }

        .features-list li {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1rem;
            padding-left: 1.8rem;
            position: relative;
        }

        .features-list li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #ffd166;
            font-weight: bold;
        }

        .brand-stats {
            display: flex;
            gap: 2rem;
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-item {
            text-align: center;
            flex: 1;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Right Side - Form Section */
        .auth-form-section {
            padding: 3rem 2.5rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .form-header h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--gray);
            font-size: 1rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .required {
            color: var(--danger);
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            z-index: 2;
        }

        .form-control {
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--gray-light);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: var(--transition);
            background: white;
            color: var(--dark);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            z-index: 2;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0;
            border: 2px solid var(--gray-light);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            color: var(--dark);
            font-size: 0.95rem;
            cursor: pointer;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Terms Checkbox */
        .terms-check {
            margin: 2rem 0;
        }

        .form-check-label {
            color: var(--dark);
            font-size: 0.95rem;
        }

        .terms-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .terms-link:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .submit-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            color: white;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            width: 100%;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-spinner {
            display: none;
            width: 1.2rem;
            height: 1.2rem;
            border-width: 0.2em;
        }

        .submit-btn.loading .btn-text {
            display: none;
        }

        .submit-btn.loading .btn-spinner {
            display: inline-block;
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .divider:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: var(--gray-light);
        }

        .divider-text {
            display: inline-block;
            background: white;
            padding: 0 1rem;
            color: var(--gray);
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
        }

        /* Social Login */
        .social-login {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-light);
            border-radius: 10px;
            background: white;
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .social-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .social-btn-google {
            color: #db4437;
        }

        .social-btn-facebook {
            color: #4267B2;
        }

        .social-btn-twitter {
            color: #1DA1F2;
        }

        /* Login Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-light);
            color: var(--gray);
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        /* Error States */
        .is-invalid {
            border-color: var(--danger) !important;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .auth-card {
                margin: 1rem;
            }
            
            .auth-brand-section {
                padding: 2rem 1.5rem;
                text-align: center;
            }
            
            .brand-logo {
                max-width: 140px;
                margin: 0 auto 1.5rem;
            }
            
            .brand-title {
                font-size: 1.8rem;
            }
            
            .auth-form-section {
                padding: 2rem 1.5rem;
            }
            
            .social-login {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .auth-wrapper {
                padding: 1rem 0.5rem;
            }
            
            .brand-content,
            .auth-form-section {
                padding: 1.5rem 1rem;
            }
            
            .form-header h2 {
                font-size: 1.5rem;
            }
            
            .brand-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .stat-item {
                margin-bottom: 0.5rem;
            }
            
            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading Animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .loading {
            animation: pulse 1.5s infinite;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-background"></div>
        
        <div class="auth-container">
            <div class="auth-card">
                <div class="row g-0">
                    <!-- Left Side - Brand Section -->
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="auth-brand-section">
                            <div class="brand-overlay"></div>
                            <div class="brand-content">
                                <img src="{{ asset('front/images/logo-og.png') }}" alt="Logo" class="img-fluid">
                                
                                <h1 class="brand-title">
                                    Welcome to <span class="brand-highlight">ORO IT</span> Solution
                                </h1>
                                
                                <p class="brand-subtitle">
                                    Sign in to access your personalized dashboard and continue your digital journey with us.
                                </p>
                                
                                <ul class="features-list">
                                    <li>Secure & Encrypted Platform</li>
                                    <li>24/7 Professional Support</li>
                                    <li>Advanced Analytics Dashboard</li>
                                    <li>Multi-Device Synchronization</li>
                                    <li>Real-time Notifications</li>
                                </ul>
                                
                                <div class="brand-stats">
                                    <div class="stat-item">
                                        <span class="stat-number">50K+</span>
                                        <span class="stat-label">Happy Clients</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">99.9%</span>
                                        <span class="stat-label">Uptime</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">24/7</span>
                                        <span class="stat-label">Support</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Form Section -->
                    <div class="col-lg-7">
                        <div class="auth-form-section">
                            <!-- Mobile Logo -->
                            <div class="text-center d-lg-none mb-4">
                                <img src="{{ asset('front/images/logo-og.png') }}" alt="ORO IT SOLUTION" class="brand-logo" style="max-width: 120px; filter: none;">
                            </div>
                            
                            <div class="form-header">
                                <h2>Welcome Back</h2>
                                <p>Sign in to your ORO IT Solution account</p>
                            </div>
                            
                            <!-- Alerts -->
                            <div id="loginErrorAlert" class="alert alert-danger d-none">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span id="loginErrorText"></span>
                            </div>
                            
                            <div id="loginSuccessAlert" class="alert alert-success d-none">
                                <i class="fas fa-check-circle me-2"></i>
                                <span id="loginSuccessText"></span>
                            </div>
                            
                            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                                @csrf
                                
                                <!-- Email Field -->
                                <div class="form-group">
                                    <label class="form-label">Email Address <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" name="email" id="email" 
                                               value="{{ old('email') }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Enter your email address"
                                               required
                                               autofocus>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Password Field -->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label">Password <span class="required">*</span></label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="forgot-password">
                                                Forgot Password?
                                            </a>
                                        @endif
                                    </div>
                                    <div class="input-with-icon">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input type="password" name="password" id="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Enter your password"
                                               required>
                                        <button type="button" class="password-toggle" id="togglePassword">
                                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Remember Me & Options -->
                                <div class="form-options">
                                    <div class="remember-me">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                        <label class="form-check-label" for="remember_me">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <button type="submit" class="submit-btn" id="loginBtn">
                                    <div class="btn-content">
                                        <span class="btn-text">Sign In</span>
                                        <div class="spinner-border spinner-border-sm btn-spinner" role="status"></div>
                                    </div>
                                </button>
                                
                                <!-- Divider -->
                                <div class="divider">
                                    <span class="divider-text">Or continue with</span>
                                </div>
                                
                                <!-- Social Login -->
                                <div class="social-login">
                                    <a href="#" class="social-btn social-btn-google">
                                        <i class="fab fa-google"></i>
                                        <span>Google</span>
                                    </a>
                                    <a href="#" class="social-btn social-btn-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>Facebook</span>
                                    </a>
                                    <a href="#" class="social-btn social-btn-twitter">
                                        <i class="fab fa-twitter"></i>
                                        <span>Twitter</span>
                                    </a>
                                </div>
                                
                                <!-- Register Link -->
                                <div class="register-link">
                                    <p>Don't have an account? <a href="{{ route('register') }}">Create Account</a></p>
                                    <a href="{{ url('/') }}" class="text-decoration-none small text-muted mt-2 d-block">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Home
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('ORO IT Solution - Login Page Initialized');
            
            // Initialize all components
            initPasswordToggle();
            initFormValidation();
            
            // Auto-focus email field
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                setTimeout(() => emailField.focus(), 300);
            }
        });
        
        // Password Toggle
        function initPasswordToggle() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
            
            if (togglePassword && passwordInput && togglePasswordIcon) {
                togglePassword.addEventListener('click', function() {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    togglePasswordIcon.classList.toggle('fa-eye');
                    togglePasswordIcon.classList.toggle('fa-eye-slash');
                    togglePassword.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                });
            }
        }
        
        // Form Validation and AJAX Submission
        function initFormValidation() {
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('loginBtn');
            
            if (!form || !submitBtn) return;
            
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Reset previous errors and alerts
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
                const errorDiv = field.nextElementSibling?.classList?.contains('invalid-feedback') 
                    ? field.nextElementSibling 
                    : null;
                
                if (field) {
                    field.classList.add('is-invalid');
                }
                
                if (errorDiv) {
                    errorDiv.textContent = message;
                    errorDiv.style.display = 'block';
                } else {
                    // Create error div if it doesn't exist
                    const div = document.createElement('div');
                    div.className = 'invalid-feedback';
                    div.textContent = message;
                    field.parentNode.appendChild(div);
                }
            }
            
            // Show alert
            function showAlert(type, message) {
                const alertDiv = document.getElementById(`login${type}Alert`);
                const alertText = document.getElementById(`login${type}Text`);
                
                if (alertDiv && alertText) {
                    alertText.textContent = message;
                    alertDiv.classList.remove('d-none');
                    
                    // Hide after 5 seconds for error alerts
                    if (type === 'Error') {
                        setTimeout(() => {
                            alertDiv.classList.add('d-none');
                        }, 5000);
                    }
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
                    el.style.display = 'none';
                });
                
                // Hide alerts
                document.getElementById('loginErrorAlert')?.classList.add('d-none');
                document.getElementById('loginSuccessAlert')?.classList.add('d-none');
            }
            
            // Set loading state
            function setLoadingState(isLoading) {
                submitBtn.disabled = isLoading;
                submitBtn.classList.toggle('loading', isLoading);
            }
            
            // Handle successful login
            function handleLoginSuccess(data) {
                showAlert('Success', 'Login successful! Redirecting...');
                
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
                
                showAlert('Error', errorMessage);
            }
            
            // Handle network error
            function handleNetworkError(error) {
                console.error('Network error:', error);
                showAlert('Error', 'Network error. Please check your connection and try again.');
            }
        }
    </script>
</body>
</html>