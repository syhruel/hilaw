<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - HILAW</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #4a5d4f 0%, #3a4d3f 100%);
            min-height: 100vh;
            margin: 0;
            padding: 15px 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-section {
            background: white;
            border-radius: 12px;
            padding: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 10px;
        }
        
        .logo-img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
        }
        
        .logo-hi { color: #f4a538; }
        .logo-law { color: #4a5d4f; }
        
        .page-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .page-subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 12px;
            margin: 0;
        }
        
        .login-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border: none;
        }
        
        .form-title {
            color: #4a5d4f;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .input-group {
            margin-bottom: 15px;
        }
        
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            height: auto;
        }
        
        .form-control:focus {
            border-color: #f4a538;
            box-shadow: 0 0 0 0.2rem rgba(244, 165, 56, 0.1);
        }
        
        .input-group-text {
            background: #fef3e2;
            border: 2px solid #e5e7eb;
            border-left: none;
            border-radius: 0 8px 8px 0;
            color: #f4a538;
            padding: 10px 12px;
        }
        
        .input-group .form-control {
            border-right: none;
            border-radius: 8px 0 0 8px;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #f4a538, #e6941f);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 13px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(244, 165, 56, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(244, 165, 56, 0.4);
            color: white;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 11px;
            border-radius: 6px;
        }
        
        .alert {
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 15px;
            font-size: 12px;
        }
        
        .alert-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .alert i {
            margin-right: 6px;
        }
        
        .invalid-feedback {
            color: #dc2626;
            font-size: 11px;
            display: block;
            margin-top: 4px;
        }
        
        .remember-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .icheck-primary {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .icheck-primary input[type="checkbox"] {
            margin: 0;
        }
        
        .icheck-primary label {
            font-size: 11px;
            color: #6b7280;
            margin: 0;
            cursor: pointer;
        }
        
        .links-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }
        
        .links-section a {
            color: #4a5d4f;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s ease;
        }
        
        .links-section a:hover {
            color: #f4a538;
            text-decoration: underline;
        }
        
        .links-section p {
            margin: 8px 0;
        }
        
        .verification-alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            border-radius: 8px;
            padding: 12px;
            margin-top: 15px;
            font-size: 11px;
        }
        
        .verification-alert i {
            color: #f4a538;
            margin-right: 6px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .back-link a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 11px;
            transition: color 0.3s ease;
        }
        
        .back-link a:hover {
            color: white;
        }
        
        .back-link i {
            margin-right: 5px;
        }
        
        @media (max-width: 576px) {
            body {
                padding: 10px 5px;
            }
            
            .login-container {
                max-width: 100%;
            }
            
            .login-card {
                padding: 20px;
            }
            
            .logo-img {
                width: 28px;
                height: 28px;
            }
            
            .logo-text {
                font-size: 18px;
            }
            
            .page-title {
                font-size: 16px;
            }
            
            .remember-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
        
        @media (max-width: 400px) {
            .login-card {
                padding: 15px;
            }
            
            .form-control, .input-group-text {
                font-size: 12px;
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-section">
                <img src="{{ asset('template/img/hilaw-logo.png') }}" alt="HiLAW Logo" class="logo-img">
                <h1 class="logo-text">
                    <span class="logo-hi">Hi</span><span class="logo-law">LAW</span>
                </h1>
            </div>
            <h2 class="page-title">Selamat Datang</h2>
            <p class="page-subtitle">Masuk ke akun HILAW Anda</p>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <h3 class="form-title">Masuk ke Akun Anda</h3>

            <!-- Alerts -->
            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>{{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    @if(str_contains(session('error'), 'verifikasi') || str_contains(session('error'), 'verification'))
                        <br><br>
                        <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-envelope"></i> Buka Halaman Verifikasi
                        </a>
                    @endif
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <input type="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Alamat Email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group">
                    <input type="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password" 
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Submit -->
                <div class="remember-section">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <!-- Links Section -->
            <div class="links-section">
                <p>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            <i class="fas fa-key"></i>
                            Lupa password?
                        </a>
                    @endif
                </p>
                <hr style="margin: 15px 0; border-color: #e5e7eb;">
                <p>
                    <a href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                        Daftar sebagai pengguna
                    </a> | 
                    <a href="{{ route('register.dokter') }}">
                        <i class="fas fa-gavel"></i>
                        Daftar sebagai ahli hukum
                    </a>
                </p>
            </div>
            
            <!-- Verification Info -->
            <div class="verification-alert">
                <i class="fas fa-info-circle"></i>
                <strong>Catatan:</strong> Setelah registrasi, Anda harus memverifikasi email terlebih dahulu sebelum dapat login.
            </div>
        </div>

        <!-- Back Link -->
        <div class="back-link">
            <a href="{{ route('register-choice') }}">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailField = document.querySelector('input[name="email"]');
            const passwordField = document.querySelector('input[name="password"]');

            // Auto-focus pada field email
            if (emailField) {
                emailField.focus();
            }

            // Email format validation
            if (emailField) {
                emailField.addEventListener('input', function() {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    
                    if (!emailPattern.test(emailField.value) && emailField.value !== '') {
                        emailField.classList.add('is-invalid');
                    } else {
                        emailField.classList.remove('is-invalid');
                    }
                });
            }

            // Form submission with validation and loading state
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate email format
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value)) {
                    e.preventDefault();
                    isValid = false;
                    emailField.classList.add('is-invalid');
                }

                // Show loading state if valid
                if (isValid) {
                    const submitBtn = form.querySelector('.btn-login');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Masuk...';
                    submitBtn.disabled = true;
                }
            });

            // Animation on load
            const card = document.querySelector('.login-card');
            const header = document.querySelector('.header-section');
            
            header.style.opacity = '0';
            header.style.transform = 'translateY(-20px)';
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                header.style.transition = 'all 0.5s ease';
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 200);
            }, 100);
        });
    </script>
</body>
</html>