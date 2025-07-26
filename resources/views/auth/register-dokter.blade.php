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
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            min-height: 100vh;
        }
        
        .register-page {
            background: none;
        }
        
        .register-box {
            width: 400px;
            margin: 7% auto;
        }
        
        .register-logo {
            background: white;
            color: #16a34a;
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
        
        .register-box-msg {
            color: #16a34a;
            font-weight: 600;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
        }
        
        .form-control:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.1);
        }
        
        .input-group-text {
            background: #f0fdf4;
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 8px 8px 0;
            color: #16a34a;
        }
        
        .btn-primary {
            background: #16a34a;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: #15803d;
        }
        
        .alert-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-radius: 8px;
        }
        
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 8px;
        }
        
        .invalid-feedback {
            color: #dc2626;
            display: block;
        }
        
        a {
            color: #16a34a;
            text-decoration: none;
        }
        
        a:hover {
            color: #15803d;
            text-decoration: underline;
        }
        
        .balance-icon {
            color: #16a34a;
            margin-right: 8px;
        }

        .register-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .register-note {
            color: #3b82f6;
            font-size: 12px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <i class="fas fa-balance-scale balance-icon"></i>
            <b>HILAW</b> System
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <h3 class="register-box-msg">Registrasi Ahli Hukum</h3>
                <p class="register-subtitle text-center">Daftar sebagai ahli hukum untuk bergabung dengan platform kami</p>
                <p class="register-note text-center">Setelah registrasi, Anda akan diminta melengkapi data profil</p>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('register.dokter.submit') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Email" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
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
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                               placeholder="Konfirmasi Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Daftar Sebagai Ahli Hukum</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1 text-center mt-3">
                    <a href="{{ route('register') }}">Daftar sebagai pengguna biasa?</a>
                </p>
                <hr>
                <p class="mb-0 text-center">
                    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>