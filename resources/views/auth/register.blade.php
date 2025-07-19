<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Pengguna - HILAW</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M30 20h40v60h-40z" fill="rgba(255,255,255,0.05)"/><path d="M25 25h50v50h-50z" fill="rgba(255,255,255,0.03)"/></svg>');
            opacity: 0.1;
        }
        
        .register-page {
            background: none;
        }
        
        .register-box {
            width: 480px;
            position: relative;
            z-index: 1;
        }
        
        .register-logo {
            background: white;
            color: #1e40af;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .register-logo b {
            font-size: 28px;
            font-weight: 700;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .card-body {
            padding: 30px;
        }
        
        .login-box-msg {
            color: #1e40af;
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
        }
        
        .form-control:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.1);
        }
        
        .input-group-text {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 8px 8px 0;
            color: #1e40af;
        }
        
        .btn-primary {
            background: #1e40af;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 14px;
        }
        
        a {
            color: #1e40af;
            text-decoration: none;
        }
        
        a:hover {
            color: #1e3a8a;
            text-decoration: underline;
        }
        
        .balance-icon {
            color: #1e40af;
            margin-right: 8px;
        }
        
        .input-group {
            margin-bottom: 15px;
        }
        
        .row {
            margin-top: 20px;
        }
    </style>
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <i class="fas fa-balance-scale balance-icon"></i>
            <b>HILAW</b> - Registrasi Pengguna
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Silakan daftar untuk konsultasi kehutanan</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Nama lengkap" value="{{ old('name') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('name') 
                            <span class="invalid-feedback d-block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Email aktif" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email') 
                            <span class="invalid-feedback d-block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password') 
                            <span class="invalid-feedback d-block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control" 
                               placeholder="Konfirmasi password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mt-3">
                        <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                            <a href="{{ route('login') }}">Sudah punya akun?</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <a href="{{ route('register.dokter') }}" class="d-inline">Daftar sebagai ahli kehutanan</a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block w-100">Daftar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>