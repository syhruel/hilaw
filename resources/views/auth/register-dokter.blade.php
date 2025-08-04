<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Ahli Hukum - HILAW</title>
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
        
        .register-container {
            max-width: 450px;
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
        
        .register-card {
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
            margin-bottom: 15px;
        }
        
        .form-subtitle {
            color: #6b7280;
            font-size: 11px;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .process-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .process-info i {
            color: #f4a538;
            margin-right: 6px;
        }
        
        .process-info ol {
            margin: 8px 0 0 0;
            padding-left: 15px;
        }
        
        .process-info li {
            margin-bottom: 3px;
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
        
        .btn-register {
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
        
        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(244, 165, 56, 0.4);
            color: white;
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
        
        .invalid-feedback {
            color: #dc2626;
            font-size: 11px;
            display: block;
            margin-top: 4px;
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
            
            .register-container {
                max-width: 100%;
            }
            
            .register-card {
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
        }
        
        @media (max-width: 400px) {
            .register-card {
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
    <div class="register-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-section">
                <img src="{{ asset('template/img/hilaw-logo.png') }}" alt="HiLAW Logo" class="logo-img">
                <h1 class="logo-text">
                    <span class="logo-hi">Hi</span><span class="logo-law">LAW</span>
                </h1>
            </div>
            <h2 class="page-title">Registrasi Ahli Hukum</h2>
            <p class="page-subtitle">Bergabung sebagai ahli hukum profesional di platform kami</p>
        </div>

        <!-- Registration Card -->
        <div class="register-card">
            <h3 class="form-title">Daftar Sebagai Ahli Hukum</h3>
            <p class="form-subtitle">Setelah registrasi, Anda akan diminta melengkapi data profil</p>

            <!-- Process Info -->
            <div class="process-info">
                <i class="fas fa-clipboard-list"></i>
                <strong>Proses Registrasi:</strong>
                <ol>
                    <li>Isi form registrasi</li>
                    <li>Verifikasi email Anda</li>
                    <li>Lengkapi profil ahli hukum</li>
                    <li>Tunggu persetujuan admin</li>
                </ol>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register.dokter.submit') }}" id="lawyerRegisterForm">
                @csrf

                <!-- Nama Lengkap -->
                <div class="input-group">
                    <input type="text" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Nama Lengkap" 
                           value="{{ old('name') }}"
                           required
                           maxlength="255">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group">
                    <input type="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Alamat Email" 
                           value="{{ old('email') }}"
                           required
                           maxlength="255">
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
                           placeholder="Password (minimal 8 karakter)" 
                           required
                           minlength="8">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="input-group">
                    <input type="password" 
                           name="password_confirmation" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           placeholder="Konfirmasi Password" 
                           required
                           minlength="8">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-register">
                    <i class="fas fa-gavel"></i> Daftar Sebagai Ahli Hukum
                </button>
            </form>

            <!-- Links Section -->
            <div class="links-section">
                <p>
                    <a href="{{ route('register') }}">
                        <i class="fas fa-user"></i>
                        Daftar sebagai pengguna biasa
                    </a>
                </p>
                <p>
                    <a href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i>
                        Sudah punya akun? Login di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Back Link -->
        <div class="back-link">
            <a href="{{ route('register-choice') }}">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Pilihan Registrasi
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('lawyerRegisterForm');
            const nameField = document.querySelector('input[name="name"]');
            const emailField = document.querySelector('input[name="email"]');
            const passwordField = document.querySelector('input[name="password"]');
            const passwordConfirmField = document.querySelector('input[name="password_confirmation"]');

            // Auto-focus pada field nama
            if (nameField) {
                nameField.focus();
            }

            // Email format validation
            if (emailField) {
                emailField.addEventListener('input', function() {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    const errorDiv = document.getElementById('email-error');
                    
                    if (!emailPattern.test(emailField.value) && emailField.value !== '') {
                        emailField.classList.add('is-invalid');
                        errorDiv.textContent = 'Format email tidak valid';
                        errorDiv.style.display = 'block';
                    } else {
                        emailField.classList.remove('is-invalid');
                        errorDiv.style.display = 'none';
                    }
                });
            }

            // Password confirmation validation
            if (passwordField && passwordConfirmField) {
                function validatePasswordMatch() {
                    const errorDiv = document.getElementById('password-confirmation-error');
                    
                    if (passwordField.value !== passwordConfirmField.value && passwordConfirmField.value !== '') {
                        passwordConfirmField.classList.add('is-invalid');
                        errorDiv.textContent = 'Password tidak cocok';
                        errorDiv.style.display = 'block';
                        return false;
                    } else {
                        passwordConfirmField.classList.remove('is-invalid');
                        errorDiv.style.display = 'none';
                        return true;
                    }
                }

                passwordConfirmField.addEventListener('input', validatePasswordMatch);
                passwordField.addEventListener('input', validatePasswordMatch);
            }

            // Form submission with validation
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate email
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value)) {
                    e.preventDefault();
                    isValid = false;
                    emailField.classList.add('is-invalid');
                    document.getElementById('email-error').textContent = 'Format email tidak valid';
                    document.getElementById('email-error').style.display = 'block';
                }

                // Validate password match
                if (passwordField.value !== passwordConfirmField.value) {
                    e.preventDefault();
                    isValid = false;
                    passwordConfirmField.classList.add('is-invalid');
                    document.getElementById('password-confirmation-error').textContent = 'Password tidak cocok';
                    document.getElementById('password-confirmation-error').style.display = 'block';
                }

                // Show loading state if valid
                if (isValid) {
                    const submitBtn = form.querySelector('.btn-register');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendaftar...';
                    submitBtn.disabled = true;
                }
            });

            // Animation on load
            const card = document.querySelector('.register-card');
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