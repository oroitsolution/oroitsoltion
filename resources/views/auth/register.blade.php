<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ORO IT SOLUTION</title>
    
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
                        url('{{ asset("front/images/header/register.jpg") }}');
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

        /* Account Type Selection */
        .account-type-selector {
            margin-bottom: 2rem;
        }

        .account-type-options {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .account-type-card {
            flex: 1;
            border: 2px solid var(--gray-light);
            border-radius: 12px;
            padding: 1.5rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: white;
            position: relative;
        }

        .account-type-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .account-type-card.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .account-type-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .account-type-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.8rem;
            transition: var(--transition);
        }

        .account-type-card.active .account-type-icon {
            color: var(--primary-dark);
        }

        .account-type-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.3rem;
            font-size: 1.1rem;
        }

        .account-type-desc {
            font-size: 0.85rem;
            color: var(--gray);
        }

        /* Business Fields */
        .business-fields {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-light);
            animation: fadeIn 0.4s ease-out;
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

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-meter {
            height: 6px;
            background: var(--gray-light);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 0.3rem;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 3px;
            transition: var(--transition);
            background: var(--danger);
        }

        .strength-text {
            font-size: 0.8rem;
            color: var(--gray);
        }

        /* Password Match Feedback */
        .password-match {
            font-size: 0.85rem;
            margin-top: 0.3rem;
            min-height: 1.2rem;
        }

        .match-success {
            color: var(--success);
        }

        .match-error {
            color: var(--danger);
        }

        /* Terms Checkbox */
        .terms-check {
            margin: 2rem 0;
        }

        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.2em;
            border: 2px solid var(--gray-light);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
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

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-light);
            color: var(--gray);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .login-link a:hover {
            text-decoration: underline;
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
            
            .account-type-options {
                flex-direction: column;
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
                               <img src="{{ asset('front/images/logo-og.png') }}" alt="Logo" class="img-fluid"
                                       >
                                
                                <h1 class="brand-title">
                                    Join <span class="brand-highlight">ORO IT</span> Solution
                                </h1>
                                
                                <p class="brand-subtitle">
                                    Create your account to access premium services and transform your digital experience.
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
                                <h2>Create Your Account</h2>
                                <p>Join ORO IT Solution and start your digital journey</p>
                            </div>
                            
                            <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                                @csrf
                                
                                <!-- Account Type Selection -->
                                <div class="account-type-selector">
                                    <label class="form-label">Account Type <span class="required">*</span></label>
                                    <div class="account-type-options">
                                        <div class="account-type-card" id="personalCard">
                                            <input type="radio" name="account_type" id="personal" value="personal" 
                                                   {{ old('account_type', 'personal') == 'personal' ? 'checked' : '' }}>
                                            <div class="account-type-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="account-type-name">Personal</div>
                                            <div class="account-type-desc">For individual users</div>
                                        </div>
                                        
                                        <div class="account-type-card" id="businessCard">
                                            <input type="radio" name="account_type" id="business" value="business"
                                                   {{ old('account_type') == 'business' ? 'checked' : '' }}>
                                            <div class="account-type-icon">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <div class="account-type-name">Business</div>
                                            <div class="account-type-desc">For companies & organizations</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Business Fields -->
                                <div id="businessFields" class="business-fields d-none">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Business Type <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-list input-icon"></i>
                                                    <select name="business_type" id="business_type" class="form-control @error('business_type') is-invalid @enderror">
                                                        <option value="">Select Business Type</option>
                                                        <option value="proprietor" {{ old('business_type') == 'proprietor' ? 'selected' : '' }}>Proprietor</option>
                                                        <option value="partnership" {{ old('business_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                                        <option value="private_limited" {{ old('business_type') == 'private_limited' ? 'selected' : '' }}>Private Limited</option>
                                                        <option value="llp" {{ old('business_type') == 'llp' ? 'selected' : '' }}>LLP</option>
                                                        <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                    @error('business_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Company Name <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-building input-icon"></i>
                                                    <input type="text" name="company_name" 
                                                           value="{{ old('company_name') }}"
                                                           class="form-control @error('company_name') is-invalid @enderror"
                                                           placeholder="Enter company name">
                                                    @error('company_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Personal Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Full Name <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-user input-icon"></i>
                                                <input type="text" name="name" 
                                                       value="{{ old('name') }}"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="Enter your full name"
                                                       required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email Address <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-envelope input-icon"></i>
                                                <input type="email" name="email" 
                                                       value="{{ old('email') }}"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       placeholder="Enter your email"
                                                       required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Contact Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Mobile Number <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-phone input-icon"></i>
                                                <input type="tel" name="mobile" 
                                                       value="{{ old('mobile') }}"
                                                       class="form-control @error('mobile') is-invalid @enderror"
                                                       placeholder="Enter mobile number"
                                                       required>
                                                @error('mobile')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-home input-icon"></i>
                                                <input type="text" name="address" 
                                                       value="{{ old('address') }}"
                                                       class="form-control"
                                                       placeholder="Enter your address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Location Information -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">State</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-map-marker-alt input-icon"></i>
                                                <input type="text" name="state" 
                                                       value="{{ old('state') }}"
                                                       class="form-control"
                                                       placeholder="State">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">City</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-city input-icon"></i>
                                                <input type="text" name="city" 
                                                       value="{{ old('city') }}"
                                                       class="form-control"
                                                       placeholder="City">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Pincode</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-map-pin input-icon"></i>
                                                <input type="text" name="pincode" 
                                                       value="{{ old('pincode') }}"
                                                       class="form-control"
                                                       placeholder="Pincode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Password Fields -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Password <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-lock input-icon"></i>
                                                <input type="password" name="password" 
                                                       id="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       placeholder="Create a strong password"
                                                       required>
                                                <button type="button" class="password-toggle" id="togglePassword">
                                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                                </button>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="password-strength">
                                                <div class="strength-meter">
                                                    <div class="strength-bar" id="strengthBar"></div>
                                                </div>
                                                <div class="strength-text" id="strengthText">Password strength</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-lock input-icon"></i>
                                                <input type="password" name="password_confirmation" 
                                                       id="confirmPassword"
                                                       class="form-control"
                                                       placeholder="Confirm your password"
                                                       required>
                                                <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                                    <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                                                </button>
                                            </div>
                                            <div class="password-match" id="passwordMatch"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Terms Agreement -->
                                <div class="terms-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" class="terms-link">Terms & Conditions</a> 
                                            and <a href="#" class="terms-link">Privacy Policy</a>
                                        </label>
                                        <div class="invalid-feedback mt-1">
                                            You must agree to the terms before registering
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <button type="submit" class="submit-btn" id="submitBtn">
                                    <div class="btn-content">
                                        <span class="btn-text">Create Account</span>
                                        <div class="spinner-border spinner-border-sm btn-spinner" role="status"></div>
                                    </div>
                                </button>
                                
                                <!-- Login Link -->
                                <div class="login-link">
                                    <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
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
            console.log('ORO IT Solution - Registration Page Initialized');
            
            // Initialize all components
            initAccountTypeToggle();
            initPasswordToggles();
            initPasswordStrength();
            initPasswordMatch();
            initFormValidation();
            
            // Test: Log all important elements
            console.log('Elements loaded:', {
                businessRadio: document.getElementById('business'),
                personalRadio: document.getElementById('personal'),
                businessFields: document.getElementById('businessFields'),
                personalCard: document.getElementById('personalCard'),
                businessCard: document.getElementById('businessCard')
            });
        });
        
        // Account Type Toggle
        function initAccountTypeToggle() {
            const businessRadio = document.getElementById('business');
            const personalRadio = document.getElementById('personal');
            const businessFields = document.getElementById('businessFields');
            const personalCard = document.getElementById('personalCard');
            const businessCard = document.getElementById('businessCard');
            
            if (!businessRadio || !personalRadio || !businessFields) {
                console.error('Required elements not found for account type toggle');
                return;
            }
            
            // Function to update UI based on selected account type
            function updateAccountTypeUI() {
                const isBusiness = businessRadio.checked;
                
                // Show/hide business fields with animation
                if (isBusiness) {
                    businessFields.classList.remove('d-none');
                    setTimeout(() => {
                        businessFields.style.opacity = '1';
                        businessFields.style.transform = 'translateY(0)';
                    }, 10);
                    
                    // Make business fields required
                    document.getElementById('business_type')?.setAttribute('required', 'required');
                    document.querySelector('[name="company_name"]')?.setAttribute('required', 'required');
                } else {
                    businessFields.style.opacity = '0';
                    businessFields.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        businessFields.classList.add('d-none');
                    }, 300);
                    
                    // Remove required from business fields
                    document.getElementById('business_type')?.removeAttribute('required');
                    document.querySelector('[name="company_name"]')?.removeAttribute('required');
                }
                
                // Update card styles
                if (personalCard) {
                    personalCard.classList.toggle('active', !isBusiness);
                }
                if (businessCard) {
                    businessCard.classList.toggle('active', isBusiness);
                }
                
                console.log('Account type updated:', isBusiness ? 'Business' : 'Personal');
            }
            
            // Add event listeners to radio buttons
            businessRadio.addEventListener('change', updateAccountTypeUI);
            personalRadio.addEventListener('change', updateAccountTypeUI);
            
            // Add event listeners to cards
            if (personalCard) {
                personalCard.addEventListener('click', function(e) {
                    if (e.target.type !== 'radio') {
                        personalRadio.checked = true;
                        updateAccountTypeUI();
                    }
                });
            }
            
            if (businessCard) {
                businessCard.addEventListener('click', function(e) {
                    if (e.target.type !== 'radio') {
                        businessRadio.checked = true;
                        updateAccountTypeUI();
                    }
                });
            }
            
            // Initial update
            updateAccountTypeUI();
        }
        
        // Password Toggles
        function initPasswordToggles() {
            // Password toggle
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
            
            // Confirm password toggle
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPasswordIcon');
            
            if (toggleConfirmPassword && confirmPasswordInput && toggleConfirmPasswordIcon) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const isPassword = confirmPasswordInput.type === 'password';
                    confirmPasswordInput.type = isPassword ? 'text' : 'password';
                    toggleConfirmPasswordIcon.classList.toggle('fa-eye');
                    toggleConfirmPasswordIcon.classList.toggle('fa-eye-slash');
                    toggleConfirmPassword.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                });
            }
        }
        
        // Password Strength Indicator
        function initPasswordStrength() {
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            if (!passwordInput || !strengthBar || !strengthText) return;
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let score = 0;
                let message = 'Weak';
                let color = '#ef4444';
                
                // Calculate score
                if (password.length >= 8) score += 25;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score += 25;
                if (/\d/.test(password)) score += 25;
                if (/[^A-Za-z0-9]/.test(password)) score += 25;
                
                // Update message and color
                if (score >= 75) {
                    message = 'Strong';
                    color = '#10b981';
                } else if (score >= 50) {
                    message = 'Good';
                    color = '#f59e0b';
                } else if (score >= 25) {
                    message = 'Fair';
                    color = '#f97316';
                } else {
                    message = 'Weak';
                    color = '#ef4444';
                }
                
                // Update UI
                strengthBar.style.width = score + '%';
                strengthBar.style.backgroundColor = color;
                strengthText.textContent = password.length > 0 ? `Password strength: ${message}` : 'Password strength';
                strengthText.style.color = color;
            });
        }
        
        // Password Match Validation
        function initPasswordMatch() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirmPassword');
            const matchDiv = document.getElementById('passwordMatch');
            
            if (!passwordInput || !confirmInput || !matchDiv) return;
            
            function checkMatch() {
                const password = passwordInput.value;
                const confirm = confirmInput.value;
                
                if (!confirm) {
                    matchDiv.textContent = '';
                    matchDiv.className = 'password-match';
                    return;
                }
                
                if (password === confirm) {
                    matchDiv.textContent = '✓ Passwords match';
                    matchDiv.className = 'password-match match-success';
                } else {
                    matchDiv.textContent = '✗ Passwords do not match';
                    matchDiv.className = 'password-match match-error';
                }
            }
            
            passwordInput.addEventListener('input', checkMatch);
            confirmInput.addEventListener('input', checkMatch);
        }
        
        // Form Validation
        function initFormValidation() {
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            
            if (!form || !submitBtn) return;
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Remove previous invalid classes
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                
                let isValid = true;
                
                // Validate required fields
                form.querySelectorAll('[required]').forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    }
                });
                
                // Validate email format
                const emailField = form.querySelector('input[type="email"]');
                if (emailField && emailField.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailField.value)) {
                        emailField.classList.add('is-invalid');
                        isValid = false;
                    }
                }
                
                // Validate password match
                const password = document.getElementById('password')?.value;
                const confirmPassword = document.getElementById('confirmPassword')?.value;
                if (password !== confirmPassword) {
                    document.getElementById('confirmPassword').classList.add('is-invalid');
                    isValid = false;
                }
                
                // Validate terms
                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    termsCheckbox.classList.add('is-invalid');
                    isValid = false;
                }
                
                // If valid, submit the form
                if (isValid) {
                    // Show loading state
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                    
                    // Submit form after a short delay
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                } else {
                    // Scroll to first error
                    const firstError = form.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
            });
        }
    </script>
</body>
</html>