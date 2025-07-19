<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Ahli Kehutanan - HILAW</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            min-height: 100vh;
            padding: 20px 0;
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
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }
        
        .register-box {
            width: 650px;
            max-width: 95%;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .register-logo {
            background: white;
            color: #1e40af;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .register-logo b {
            font-size: 32px;
            font-weight: 700;
        }
        
        .register-logo .subtitle {
            font-size: 16px;
            color: #1e40af;
            margin-top: 5px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            background: white;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .login-box-msg {
            color: #1e40af;
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
            font-size: 18px;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            height: 48px;
            transition: border-color 0.3s ease;
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
            padding: 12px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
        }
        
        .input-group-text i {
            font-size: 16px;
        }
        
        .btn-primary {
            background: #1e40af;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            height: 48px;
            font-size: 16px;
        }
        
        .btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
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
            font-size: 28px;
        }
        
        .input-group {
            margin-bottom: 15px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .custom-file {
            position: relative;
            display: inline-block;
            width: 100%;
            height: 48px;
        }
        
        .custom-file-input {
            position: absolute;
            left: 0;
            z-index: 2;
            width: 100%;
            height: 48px;
            opacity: 0;
            cursor: pointer;
        }
        
        .custom-file-label {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1;
            height: 48px;
            padding: 12px;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 8px 0 0 8px;
            transition: border-color 0.3s ease;
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        
        .custom-file-label::after {
            position: absolute;
            top: -2px;
            right: -2px;
            bottom: -2px;
            z-index: 3;
            display: block;
            height: 48px;
            padding: 12px;
            line-height: 1.5;
            color: #1e40af;
            content: "Browse";
            background-color: #f8fafc;
            border-left: 2px solid #e2e8f0;
            border-radius: 0 8px 8px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 80px;
        }
        
        .custom-file-input:focus ~ .custom-file-label {
            border-color: #1e40af;
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.1);
        }
        
        .file-input-group {
            display: flex;
            align-items: stretch;
        }
        
        .file-input-group .custom-file {
            flex: 1;
        }
        
        .file-input-group .input-group-append {
            margin-left: -2px;
        }
        
        .file-input-group .input-group-text {
            height: 48px;
            border-left: 2px solid #e2e8f0;
            border-radius: 0 8px 8px 0;
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 90px;
            height: auto;
            padding: 12px;
        }
        
        .textarea-input-group {
            position: relative;
            display: flex;
            align-items: stretch;
            width: 100%;
        }
        
        .textarea-input-group textarea.form-control {
            border-radius: 8px 0 0 8px;
            flex: 1;
            resize: vertical;
            min-height: 90px;
            height: auto;
            padding: 12px;
            border-right: none;
        }
        
        .textarea-input-group .input-group-append {
            display: flex;
            align-items: flex-start;
        }
        
        .textarea-input-group .input-group-text {
            border-radius: 0 8px 8px 0;
            border-left: none;
            padding: 12px;
            min-width: 48px;
            height: auto;
            min-height: 90px;
            display: flex;
            align-items: flex-start;
            padding-top: 18px;
        }
        
        .text-sm {
            font-size: 13px;
            color: #666;
        }
        
        label {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            display: block;
        }
        
        .compact-row {
            margin-bottom: 12px;
        }
        
        .compact-col {
            padding-right: 10px;
            padding-left: 10px;
        }
        
        .compact-col:first-child {
            padding-left: 0;
        }
        
        .compact-col:last-child {
            padding-right: 0;
        }
        
        .form-section {
            margin-bottom: 20px;
        }
        
        .photo-preview {
            margin-top: 15px;
            text-align: center;
        }
        
        .photo-preview img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .photo-preview .remove-photo {
            display: inline-block;
            margin-top: 8px;
            color: #dc3545;
            cursor: pointer;
            font-size: 12px;
            text-decoration: underline;
        }
        
        .photo-preview .remove-photo:hover {
            color: #c82333;
        }
        
        .submit-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .links-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            font-size: 14px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .alert-info {
            background-color: #cce7ff;
            border-color: #b8daff;
            color: #0c5460;
        }
        
        .btn-loading {
            position: relative;
            color: transparent;
        }
        
        .btn-loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .register-box {
                width: 100%;
                margin: 10px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .compact-col {
                padding-left: 0;
                padding-right: 0;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <i class="fas fa-balance-scale balance-icon"></i>
            <b>HILAW</b>
            <div class="subtitle">Sistem Informasi Ahli Kehutanan</div>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Daftar sebagai ahli kehutanan</p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Terdapat kesalahan pada form:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('register.dokter.submit') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                    @csrf
                    
                    <div class="row compact-row">
                        <div class="col-md-6 compact-col">
                            <div class="input-group">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Nama lengkap" value="{{ old('name') }}" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 compact-col">
                            <div class="input-group">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="Email" value="{{ old('email') }}" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-6 compact-col">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 compact-col">
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-control" 
                                       placeholder="Konfirmasi password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-6 compact-col">
                            <div class="input-group">
                                <input type="text" name="keahlian" class="form-control @error('keahlian') is-invalid @enderror" 
                                       placeholder="Keahlian/Spesialisasi" value="{{ old('keahlian') }}" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-tree"></i>
                                    </div>
                                </div>
                                @error('keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 compact-col">
                            <div class="input-group">
                                <input type="text" name="lulusan_universitas" class="form-control @error('lulusan_universitas') is-invalid @enderror" 
                                       placeholder="Lulusan universitas" value="{{ old('lulusan_universitas') }}" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                </div>
                                @error('lulusan_universitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-section">
                        <label for="foto">Foto Profil (Maksimal 10MB)</label>
                        <div class="file-input-group">
                            <div class="custom-file">
                                <input type="file" name="foto" class="custom-file-input @error('foto') is-invalid @enderror" 
                                       id="foto" accept="image/*" required>
                                <label class="custom-file-label" for="foto">Pilih foto...</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-camera"></i>
                                </span>
                            </div>
                        </div>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <div class="photo-preview" id="photoPreview" style="display: none;">
                            <img id="previewImage" src="" alt="Preview">
                            <br>
                            <span class="remove-photo" onclick="removePhoto()">
                                <i class="fas fa-times"></i> Hapus foto
                            </span>
                        </div>
                    </div>

                    <div class="row compact-row">
                        <div class="col-md-6 compact-col">
                            <div class="form-group">
                                <label for="pengalaman">Pengalaman Kerja</label>
                                <div class="textarea-input-group">
                                    <textarea name="pengalaman" class="form-control @error('pengalaman') is-invalid @enderror" 
                                              placeholder="Pengalaman kerja/praktik" rows="3" required>{{ old('pengalaman') }}</textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('pengalaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 compact-col">
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap</label>
                                <div class="textarea-input-group">
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                              placeholder="Alamat lengkap" rows="3" required>{{ old('alamat') }}</textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row submit-section">
                        <div class="col-8">
                            <p class="text-sm">
                                <i class="fas fa-info-circle"></i> Akun akan diverifikasi oleh admin sebelum dapat digunakan
                            </p>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                                <i class="fas fa-user-plus"></i> Daftar
                            </button>
                        </div>
                    </div>
                </form>

                <div class="links-section">
                    <p class="mb-2 text-center">
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Sudah punya akun? Login
                        </a>
                    </p>
                    <p class="mb-0 text-center">
                        <a href="{{ route('register') }}">
                            <i class="fas fa-user"></i> Daftar sebagai pengguna
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            // Setup CSRF Token untuk Ajax requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Update label file input dan preview foto
            $('#foto').on('change', function(e) {
                const file = e.target.files[0];
                const label = $('label[for="foto"]');
                const preview = $('#photoPreview');
                const previewImage = $('#previewImage');
                
                if (file) {
                    // Validasi ukuran file (10MB = 10 * 1024 * 1024 bytes)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 10MB.');
                        this.value = '';
                        label.text('Pilih foto...');
                        preview.hide();
                        return;
                    }
                    
                    // Validasi tipe file
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Tipe file tidak didukung! Gunakan JPG, PNG, atau GIF.');
                        this.value = '';
                        label.text('Pilih foto...');
                        preview.hide();
                        return;
                    }
                    
                    // Update label dengan nama file
                    label.text(file.name);
                    
                    // Tampilkan preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.attr('src', e.target.result);
                        preview.show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    label.text('Pilih foto...');
                    preview.hide();
                }
            });

            // Validasi form sebelum submit
            $('#registrationForm').on('submit', function(e) {
                const password = $('input[name="password"]').val();
                const confirmPassword = $('input[name="password_confirmation"]').val();
                const submitBtn = $('#submitBtn');
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak cocok!');
                    return false;
                }
                
                // Validasi panjang password
                if (password.length < 8) {
                    e.preventDefault();
                    alert('Password minimal 8 karakter!');
                    return false;
                }
                
                // Tampilkan loading state
                submitBtn.addClass('btn-loading');
                submitBtn.prop('disabled', true);
                
                // Jika validasi berhasil, form akan di-submit
                return true;
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
        
        // Function untuk menghapus foto
        function removePhoto() {
            const fileInput = $('#foto');
            const label = $('label[for="foto"]');
            const preview = $('#photoPreview');
            
            // Reset input file
            fileInput.val('');
            label.text('Pilih foto...');
            preview.hide();
        }
    </script>
</body>
</html>