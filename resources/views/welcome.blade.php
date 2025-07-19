<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HILAW - Hukum Indonesia Layanan Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M30 20h40v60h-40z" fill="rgba(255,255,255,0.05)"/><path d="M25 25h50v50h-50z" fill="rgba(255,255,255,0.03)"/></svg>');
            opacity: 0.1;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .role-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            cursor: pointer;
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .role-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        .role-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .role-description {
            color: #666;
            line-height: 1.6;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            margin-bottom: 2rem;
        }

        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .cta-section {
            padding: 3rem 0;
            background: #1e40af;
            color: white;
            text-align: center;
        }

        /* Lawyer Card Styles */
        .lawyer-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }

        .lawyer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .lawyer-photo {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }

        .lawyer-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .lawyer-specialty {
            color: #666;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .lawyer-university {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .lawyer-experience {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .lawyer-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 1.5rem;
        }

        .online-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .online-status.online {
            background: #d4edda;
            color: #155724;
        }

        .online-status.offline {
            background: #f8d7da;
            color: #721c24;
        }

        .btn-consult {
            background: #1e40af;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .btn-consult:hover {
            background: #1e3a8a;
            color: white;
            transform: translateY(-2px);
        }

        .btn-show {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-show:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-2px);
        }

        .navbar-brand {
            color: #1e40af !important;
        }

        .text-primary-custom {
            color: #1e40af !important;
        }

        .bg-primary-custom {
            background-color: #1e40af !important;
        }

        .btn-primary-custom {
            background-color: #1e40af;
            border-color: #1e40af;
        }

        .btn-primary-custom:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }

            .lawyer-card {
                padding: 1.5rem;
            }

            .lawyer-photo {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar Dashboard Style -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary-custom fs-4" href="/">
                <i class="fas fa-balance-scale me-2"></i>HILAW
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1" href="#beranda">
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1" href="#advokat">
                           Advokat Online
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1" href="#" onclick="redirectToLogin()">
                           Konsultasi Saya
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1" href="/login">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1" href="/register">
                            <i class="fas fa-user-plus me-1"></i>Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda" style="margin-top: 76px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="hero-title">
                        <i class="fas fa-balance-scale me-2"></i>HILAW
                    </h1>
                    <p class="hero-subtitle">
                        Sistem Konsultasi Hukum Online — Terhubung dengan Ahli Hukum Terpercaya di Seluruh Indonesia
                    </p>
                    <div class="mt-4">
                        <a href="/login" class="btn btn-primary-custom me-2">
                            <i class="fas fa-gavel me-2"></i>Mulai Konsultasi
                        </a>
                        <a href="/register" class="btn btn-outline-light">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lawyers Section -->
    <section class="lawyers-section py-5 bg-light" id="advokat">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="mb-4">Advokat & Konsultan Hukum Tersedia</h2>
                    <p class="text-muted">Konsultasi dengan para ahli hukum berpengalaman dan tersertifikasi</p>
                </div>
            </div>
            <div class="row">
                @forelse($doctors as $lawyer)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="lawyer-card text-center">
                            <div class="online-status {{ $lawyer->is_online ? 'online' : 'offline' }}">
                                <i class="fas fa-circle me-1"></i>
                                {{ $lawyer->is_online ? 'Online' : 'Offline' }}
                            </div>
                            
                            <img src="{{ $lawyer->foto ? asset('storage/' . $lawyer->foto) : 'https://via.placeholder.com/300x180/1e40af/ffffff?text=' . urlencode(substr($lawyer->name, 0, 2)) }}" 
                            alt="{{ $lawyer->name }}" 
                            class="lawyer-photo img-fluid">
                            
                            <h5 class="lawyer-name">{{ $lawyer->name }}</h5>
                            
                            <p class="lawyer-specialty">
                                <i class="fas fa-gavel me-1"></i>{{ $lawyer->keahlian }}
                            </p>
                            
                            @if($lawyer->lulusan_universitas)
                                <p class="lawyer-university">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ $lawyer->lulusan_universitas }}
                                </p>
                            @endif
                            
                            @if($lawyer->pengalaman)
                                <p class="lawyer-experience">{{ $lawyer->pengalaman }}</p>
                            @endif
                            
                            @if($lawyer->alamat)
                                <p class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $lawyer->alamat }}
                                </p>
                            @endif
                            
                            <div class="lawyer-price">
                                {{ $lawyer->tarif_konsultasi ? 'Rp ' . number_format($lawyer->tarif_konsultasi, 0, ',', '.') : 'Gratis' }}/sesi
                            </div>
                            
                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                <a href="{{ route('login') }}" class="btn-consult">
                                    <i class="fas fa-comments me-1"></i>Konsultasi
                                </a>
                                <a href="{{ route('login') }}" class="btn-show">
                                    <i class="fas fa-eye me-1"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-user-tie fa-5x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">Belum Ada Advokat Tersedia</h4>
                            <p class="text-muted">Saat ini belum ada advokat yang terdaftar di sistem. Silakan coba lagi nanti.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Role Section -->
    <section class="role-section py-5 bg-white" id="layanan">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="mb-4">Siapa Saja yang Dapat Menggunakan HILAW?</h2>
                    <p class="text-muted">Platform yang menghubungkan masyarakat dengan para ahli hukum terpercaya</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="role-card" onclick="redirectToLogin()">
                        <i class="fas fa-users role-icon text-primary"></i>
                        <h5 class="role-title">Masyarakat Umum</h5>
                        <p class="role-description">
                            Bertanya dan berkonsultasi seputar masalah hukum perdata, pidana, dan administrasi negara.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="role-card" onclick="redirectToLogin()">
                        <i class="fas fa-user-tie role-icon text-primary-custom"></i>
                        <h5 class="role-title">Advokat & Konsultan Hukum</h5>
                        <p class="role-description">
                            Memberikan konsultasi hukum profesional dan solusi terkait masalah hukum yang dihadapi klien.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="role-card" onclick="redirectToLogin()">
                        <i class="fas fa-user-shield role-icon text-danger"></i>
                        <h5 class="role-title">Administrator</h5>
                        <p class="role-description">
                            Mengelola sistem, memverifikasi kredensial advokat, dan memastikan kualitas layanan konsultasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5 bg-light" id="tentang">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="mb-4">Mengapa Memilih HILAW?</h2>
                    <p class="text-muted">Layanan konsultasi hukum terpercaya dengan teknologi modern</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-clock feature-icon"></i>
                        <h4 class="feature-title">Akses 24/7</h4>
                        <p class="text-muted">Konsultasi hukum kapan saja, di mana saja melalui platform online yang mudah digunakan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-certificate feature-icon"></i>
                        <h4 class="feature-title">Advokat Tersertifikasi</h4>
                        <p class="text-muted">Didukung oleh advokat dan konsultan hukum berpengalaman serta tersertifikasi resmi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h4 class="feature-title">Kerahasiaan Terjamin</h4>
                        <p class="text-muted">Platform yang aman dengan sistem keamanan tinggi untuk melindungi kerahasiaan klien.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8">
                    <h3 class="mb-4">Mulai Konsultasi Hukum Anda Hari Ini</h3>
                    <p class="mb-4">Bergabunglah dengan ribuan pengguna yang telah merasakan manfaat konsultasi hukum profesional.</p>
                    <a href="/register" class="btn btn-light btn-lg text-primary-custom fw-bold">
                        <i class="fas fa-rocket me-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Bootstrap -->
    <footer class="bg-white py-5 border-top">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="text-primary-custom fw-bold mb-3">
                        <i class="fas fa-balance-scale me-2"></i>HILAW
                    </h5>
                    <p class="text-muted mb-3">Platform konsultasi hukum online yang menghubungkan masyarakat dengan para advokat dan konsultan hukum tersertifikasi.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="text-muted fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="text-primary-custom fw-bold mb-3">Layanan</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="#advokat" class="text-muted text-decoration-none">Konsultasi Hukum Online</a>
                        <a href="#advokat" class="text-muted text-decoration-none">Advokat Terpercaya</a>
                        <a href="#" class="text-muted text-decoration-none">Bantuan Hukum</a>
                        <a href="#" class="text-muted text-decoration-none">Edukasi Hukum</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="text-primary-custom fw-bold mb-3">Kontak</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="mailto:info@hilaw.id" class="text-muted text-decoration-none">
                            <i class="fas fa-envelope me-2"></i>info@hilaw.id
                        </a>
                        <a href="tel:+628001234567" class="text-muted text-decoration-none">
                            <i class="fas fa-phone me-2"></i>+62 800 1234 567
                        </a>
                        <div class="text-muted">
                            <i class="fas fa-map-marker-alt me-2"></i>Jakarta, Indonesia
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="text-muted mb-2">&copy; 2024 HILAW. Semua hak dilindungi undang-undang.</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="#" class="text-muted text-decoration-none">Syarat & Ketentuan</a>
                    <a href="#" class="text-muted text-decoration-none">Kebijakan Privasi</a>
                    <a href="#" class="text-muted text-decoration-none">FAQ</a>
                    <a href="#" class="text-muted text-decoration-none">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to redirect to login
        function redirectToLogin() {
            window.location.href = '/login';
        }

        // Navbar active state management
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Allow normal navigation for actual links
                if (this.href && this.href !== window.location.href + '#' && !this.onclick) {
                    // Remove active class from all links
                    document.querySelectorAll('.navbar-nav .nav-link').forEach(l => {
                        l.classList.remove('bg-primary-custom', 'text-white');
                    });
                    // Add active class to clicked link
                    this.classList.add('bg-primary-custom', 'text-white');
                }
            });
            
            // Hover effect for non-active links
            link.addEventListener('mouseenter', function() {
                if (!this.classList.contains('bg-primary-custom')) {
                    this.classList.add('bg-light');
                }
            });
            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('bg-primary-custom')) {
                    this.classList.remove('bg-light');
                }
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>