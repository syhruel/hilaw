<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - HILAW</title>
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
        
        .verification-container {
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
        
        .verification-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border: none;
        }
        
        .verification-icon {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .verification-icon i {
            font-size: 48px;
            color: #f4a538;
            background: #fef3e2;
            padding: 20px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(244, 165, 56, 0.2);
        }
        
        .form-title {
            color: #4a5d4f;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .verification-message {
            text-align: center;
            color: #6b7280;
            margin-bottom: 25px;
            line-height: 1.6;
            font-size: 13px;
        }
        
        .user-info {
            background: #f0fdf4;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #f4a538;
        }
        
        .user-info .d-flex {
            display: flex;
            align-items: center;
        }
        
        .user-info i {
            color: #f4a538;
            margin-right: 10px;
            font-size: 16px;
        }
        
        .user-info strong {
            color: #4a5d4f;
            font-size: 14px;
        }
        
        .user-info small {
            color: #6b7280;
            font-size: 11px;
        }
        
        .badge {
            background: #f4a538;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            margin-top: 2px;
            display: inline-block;
        }
        
        .btn-primary {
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
            margin-bottom: 10px;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(244, 165, 56, 0.4);
            color: white;
        }
        
        .btn-outline-secondary {
            border: 2px solid #6b7280;
            color: #6b7280;
            background: transparent;
            border-radius: 8px;
            padding: 12px;
            font-size: 13px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background: #6b7280;
            color: white;
            transform: translateY(-1px);
        }
        
        .alert {
            border-radius: 8px;
            padding: 12px;
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
        
        .alert-info {
            background: #e0f2fe;
            border: 1px solid #81d4fa;
            color: #0277bd;
        }
        
        .alert i {
            margin-right: 6px;
        }
        
        .security-note {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }
        
        .security-note small {
            color: #6b7280;
            font-size: 11px;
        }
        
        .security-note i {
            color: #f4a538;
            margin-right: 4px;
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
            
            .verification-container {
                max-width: 100%;
            }
            
            .verification-card {
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
            
            .verification-icon i {
                font-size: 40px;
                padding: 16px;
            }
        }
        
        @media (max-width: 400px) {
            .verification-card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-section">
                <img src="{{ asset('template/img/hilaw-logo.png') }}" alt="HiLAW Logo" class="logo-img">
                <h1 class="logo-text">
                    <span class="logo-hi">Hi</span><span class="logo-law">LAW</span>
                </h1>
            </div>
            <h2 class="page-title">Verifikasi Email</h2>
            <p class="page-subtitle">Langkah penting untuk keamanan akun Anda</p>
        </div>

        <!-- Verification Card -->
        <div class="verification-card">
            <div class="verification-icon">
                <i class="fas fa-envelope-circle-check"></i>
            </div>
            
            <h3 class="form-title">Verifikasi Email Anda</h3>
            
            <!-- User Info -->
            @auth
            <div class="user-info">
                <div class="d-flex">
                    <i class="fas fa-user"></i>
                    <div>
                        <strong>{{ auth()->user()->name }}</strong><br>
                        <small class="text-muted">{{ auth()->user()->email }}</small><br>
                        <span class="badge">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>
            </div>
            @endauth
            
            <div class="verification-message">
                <p>Terima kasih telah mendaftar di HILAW System! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan.</p>
                
                <p>Jika Anda tidak menerima email, kami dengan senang hati akan mengirimkan yang lain.</p>
            </div>

            <!-- Alerts -->
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat registrasi.
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    {{ session('info') }}
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-12 mb-2">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>
                </div>
                
                <div class="col-12">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="security-note">
                <small>
                    <i class="fas fa-shield-alt"></i>
                    Verifikasi email diperlukan untuk keamanan akun Anda
                </small>
            </div>
        </div>

        <!-- Back Link -->
        <div class="back-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Login
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation on load
            const card = document.querySelector('.verification-card');
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

            // Auto-refresh after successful verification send
            const successAlert = document.querySelector('.alert-success');
            if (successAlert && successAlert.textContent.includes('dikirim')) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease';
                    successAlert.style.opacity = '0.7';
                }, 5000);
            }

            // Form submission loading state
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                    submitBtn.disabled = true;
                    
                    // Re-enable after 10 seconds as fallback
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 10000);
                });
            });
        });
    </script>
</body>
</html>