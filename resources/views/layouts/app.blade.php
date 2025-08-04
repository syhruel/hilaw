<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Hilaw - Solusi Hukum Terpercaya')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="@yield('keywords', '')" name="keywords">
    <meta content="@yield('description', '')" name="description">

    <!-- Favicon -->
    <link href="{{ asset('template/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;"></div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-dark-green text-light px-0 py-1">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-3 text-start">
                <div class="h-100 d-inline-flex align-items-center me-3">
                    <span class="fa fa-phone-alt me-2" style="font-size: 0.8rem;"></span>
                    <span style="font-size: 0.85rem;">+62 251 123 4567</span>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <span class="far fa-envelope me-2" style="font-size: 0.8rem;"></span>
                    <span style="font-size: 0.85rem;">info@hilaw.com</span>
                </div>
            </div>
            <div class="col-lg-5 px-3 text-end">
                <div class="h-100 d-inline-flex align-items-center mx-n2">
                    <span style="font-size: 0.85rem;">Follow Us:</span>
                    <a class="btn btn-link text-light py-1 px-2" href=""><i class="fab fa-facebook-f" style="font-size: 0.8rem;"></i></a>
                    <a class="btn btn-link text-light py-1 px-2" href=""><i class="fab fa-twitter" style="font-size: 0.8rem;"></i></a>
                    <a class="btn btn-link text-light py-1 px-2" href=""><i class="fab fa-linkedin-in" style="font-size: 0.8rem;"></i></a>
                    <a class="btn btn-link text-light py-1 px-2" href=""><i class="fab fa-instagram" style="font-size: 0.8rem;"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-3 px-lg-4">
            <div class="logo-container me-2">
                <img src="{{ asset('template/img/hilaw-logo.png') }}" alt="Hilaw Logo" class="logo-img">
            </div>
            <h2 class="m-0 text-dark-green" style="font-size: 1.5rem; font-weight: 600;">
                <span style="color: #f4a538;">Hi</span><span style="color: #4a5d4f;">law</span>
            </h2>
        </a>
        <button type="button" class="navbar-toggler me-3" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-3 p-lg-0">
                <a href="{{ url('/') }}" class="nav-item nav-link px-2 py-2 {{ Request::is('/') ? 'active' : '' }}" style="font-size: 0.9rem;">Beranda</a>
                <a href="{{ route('tentang') }}" class="nav-item nav-link px-2 py-2 {{ Request::is('tentang') ? 'active' : '' }}" style="font-size: 0.9rem;">Tentang</a>
                <a href="{{ route('layanan') }}" class="nav-item nav-link px-2 py-2 {{ Request::is('layanan') ? 'active' : '' }}" style="font-size: 0.9rem;">Layanan</a>
                <a href="{{ route('ahli-hukum') }}" class="nav-item nav-link px-2 py-2 {{ Request::is('ahli-hukum') ? 'active' : '' }}" style="font-size: 0.9rem;">Ahli Hukum</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle px-2 py-2 {{ Request::is('bantuan','syarat-ketentuan') ? 'active' : '' }}" data-bs-toggle="dropdown" data-bs-auto-close="true" style="font-size: 0.9rem;">Lainnya</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="{{ route('bantuan') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">Bantuan</a>
                        <a href="{{ route('syarat-ketentuan') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">Syarat & Ketentuan</a>
                    </div>
                </div>
                <a href="{{ route('kontak') }}" class="nav-item nav-link px-2 py-2 {{ Request::is('kontak') ? 'active' : '' }}" style="font-size: 0.9rem;">Kontak Kami</a>
                
                @guest
                    <a href="{{ route('login') }}" class="nav-item nav-link px-2 py-2 login-link btn-orange text-white rounded ms-2" style="font-size: 0.9rem; padding: 8px 16px !important;">Masuk<i class="fa fa-arrow-right ms-2" style="font-size: 0.8rem;"></i></a>
                    <a href="{{ route('register-choice') }}" class="nav-item nav-link px-2 py-2 btn-outline-orange text-orange rounded ms-1" style="font-size: 0.9rem; padding: 8px 16px !important; border: 1px solid #f4a538;">Daftar</a>
                @else
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle px-2 py-2 text-orange" data-bs-toggle="dropdown" data-bs-auto-close="true" style="font-size: 0.9rem;">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu bg-light m-0">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                                </a>
                            @elseif(Auth::user()->role === 'dokter')
                                <a href="{{ route('dokter.dashboard') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-stethoscope me-2"></i>Dashboard Pengacara
                                </a>
                            @else
                                <a href="{{ route('pengguna.dashboard') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-user me-2"></i>Dashboard
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">
                                <i class="fas fa-cog me-2"></i>Pengaturan
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger" style="font-size: 0.85rem; border: none; background: none;">
                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark-green text-light footer mt-4 py-4 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-3">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Kantor Kami</h5>
                    <p class="mb-2" style="font-size: 0.85rem;"><i class="fa fa-map-marker-alt me-2"></i>Jl. Raya Pajajaran No. 123, Bogor, Indonesia</p>
                    <p class="mb-2" style="font-size: 0.85rem;"><i class="fa fa-phone-alt me-2"></i>+62 251 123 4567</p>
                    <p class="mb-2" style="font-size: 0.85rem;"><i class="fa fa-envelope me-2"></i>info@hilaw.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter" style="font-size: 0.8rem;"></i></a>
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f" style="font-size: 0.8rem;"></i></a>
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-youtube" style="font-size: 0.8rem;"></i></a>
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-linkedin-in" style="font-size: 0.8rem;"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Layanan Hukum</h5>
                    <a class="btn btn-link p-1" href="{{ route('layanan') }}" style="font-size: 0.85rem;">Hukum Pidana</a>
                    <a class="btn btn-link p-1" href="{{ route('layanan') }}" style="font-size: 0.85rem;">Hukum Perdata</a>
                    <a class="btn btn-link p-1" href="{{ route('layanan') }}" style="font-size: 0.85rem;">Hukum Bisnis</a>
                    <a class="btn btn-link p-1" href="{{ route('layanan') }}" style="font-size: 0.85rem;">Hukum Keluarga</a>
                    <a class="btn btn-link p-1" href="{{ route('layanan') }}" style="font-size: 0.85rem;">Konsultasi Online</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Tautan Cepat</h5>
                    <a class="btn btn-link p-1" href="{{ route('tentang') }}" style="font-size: 0.85rem;">Tentang Kami</a>
                    <a class="btn btn-link p-1" href="{{ route('kontak') }}" style="font-size: 0.85rem;">Hubungi Kami</a>
                    <a class="btn btn-link p-1" href="{{ route('layanan') }}" style="font-size: 0.85rem;">Layanan Kami</a>
                    <a class="btn btn-link p-1" href="{{ route('syarat-ketentuan') }}" style="font-size: 0.85rem;">Syarat & Ketentuan</a>
                    <a class="btn btn-link p-1" href="{{ route('bantuan') }}" style="font-size: 0.85rem;">Bantuan</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Newsletter</h5>
                    <p style="font-size: 0.85rem;">Dapatkan informasi terbaru seputar hukum dan layanan kami.</p>
                    <div class="position-relative w-100">
                        <input class="form-control bg-light border-light w-100 py-2 ps-3 pe-4" type="email" placeholder="Email Anda" style="font-size: 0.85rem;">
                        <button type="button" class="btn btn-orange py-1 px-2 position-absolute top-0 end-0 mt-1 me-1" style="font-size: 0.8rem;">Berlangganan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright py-2" style="background-color: #3a4d3f;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <span style="font-size: 0.85rem; color: #fff;">&copy; <a class="border-bottom text-orange" href="#">Hilaw</a>, All Right Reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span style="font-size: 0.85rem; color: #fff;">Designed By <a class="border-bottom text-orange" href="https://htmlcodex.com">HTML Codex</a></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-orange btn-lg-square rounded-circle back-to-top" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-up" style="font-size: 1rem;"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('template/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('template/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('template/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('template/lib/parallax/parallax.min.js') }}"></script>
    <script src="{{ asset('template/lib/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('template/lib/lightbox/js/lightbox.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('template/js/main.js') }}"></script>

    <style>
        /* Color Variables */
        :root {
            --primary-green: #4a5d4f;
            --dark-green: #3a4d3f;
            --light-green: #5a6d5f;
            --orange: #f4a538;
            --dark-orange: #e6941f;
        }

        /* Prevent horizontal scroll */
        body {
            overflow-x: hidden;
            font-size: 0.9rem;
        }

        /* Primary color updates */
        .bg-primary, .btn-primary, .text-primary, .spinner-border {
            background-color: var(--primary-green) !important;
            border-color: var(--primary-green) !important;
            color: white !important;
        }

        .btn-primary:hover {
            background-color: var(--dark-green) !important;
            border-color: var(--dark-green) !important;
        }

        /* New color classes */
        .bg-dark-green {
            background-color: var(--dark-green) !important;
        }

        .text-dark-green {
            color: var(--primary-green) !important;
        }

        .btn-orange, .bg-orange {
            background-color: var(--orange) !important;
            border-color: var(--orange) !important;
            color: white !important;
        }

        .btn-orange:hover {
            background-color: var(--dark-orange) !important;
            border-color: var(--dark-orange) !important;
            color: white !important;
        }

        .text-orange {
            color: var(--orange) !important;
        }

        /* Logo styling */
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        /* Active nav link */
        .navbar-nav .nav-link.active {
            color: var(--orange) !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: var(--orange) !important;
        }

        /* Fix dropdown positioning */
        .navbar .dropdown {
            position: relative;
        }

        .navbar .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            left: auto !important;
            right: 0 !important;
            transform: none !important;
            min-width: 140px;
            margin-top: 0;
            border-radius: 0.25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Login button styling */
        .login-link {
            transition: all 0.3s ease;
        }

        .login-link:hover {
            background-color: var(--dark-orange) !important;
            transform: translateY(-1px);
        }

        .login-desktop {
            display: none;
        }

        /* Show mobile login in collapsed menu, hide desktop version */
        @media (max-width: 991px) {
            .navbar-nav .dropdown-menu {
                position: static !important;
                transform: none !important;
                box-shadow: none;
                border: 1px solid #dee2e6;
                margin-top: 0.25rem;
                right: auto !important;
                left: auto !important;
            }
            
            .login-desktop {
                display: none !important;
            }

            .login-link {
                margin: 0.5rem 0;
                text-align: center;
                border-radius: 0.375rem;
            }
        }

        /* Show desktop login button on large screens, hide mobile version */
        @media (min-width: 992px) {
            .login-desktop {
                display: block !important;
            }
        }

        /* Ensure dropdown items properly aligned */
        .dropdown-item {
            padding: 0.4rem 0.8rem;
            white-space: nowrap;
        }

        .dropdown-item:hover {
            background-color: var(--orange);
            color: white;
        }

        /* Fix navbar container */
        .navbar-nav {
            margin-right: 0 !important;
        }

        /* Smaller font sizes for various elements */
        .navbar-brand h2 {
            font-weight: 600;
        }

        .footer h5 {
            font-weight: 500;
        }

        /* Footer link styling */
        .footer .btn-link {
            padding: 0.25rem 0;
            text-align: left;
            color: #a0a0a0;
            transition: color 0.3s ease;
        }

        .footer .btn-link:hover {
            color: var(--orange) !important;
        }

        /* Social media buttons */
        .btn-outline-light:hover {
            background-color: var(--orange) !important;
            border-color: var(--orange) !important;
        }

        /* Back to top button */
        .back-to-top {
            transition: all 0.3s ease;
        }

        .back-to-top:hover {
            background-color: var(--dark-orange) !important;
            transform: translateY(-2px);
        }

        /* Newsletter button */
        .btn-orange {
            transition: all 0.3s ease;
        }

        /* Responsive font adjustments */
        @media (max-width: 768px) {
            body {
                font-size: 0.85rem;
            }
            
            .navbar-brand h2 {
                font-size: 1.3rem !important;
            }
            
            .nav-link {
                font-size: 0.85rem !important;
            }
            
            .footer h5 {
                font-size: 1rem !important;
            }

            .logo-img {
                width: 35px;
                height: 35px;
            }
        }

        /* Compact spacing */
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* Override template default large fonts for welcome page */
        .hero-header h1 {
            font-size: 2.5rem !important;
            color: var(--primary-green) !important;
        }

        .hero-header h5 {
            font-size: 1.1rem !important;
            color: var(--orange) !important;
        }

        .hero-header p {
            font-size: 0.95rem !important;
        }

        .service-item h5 {
            font-size: 1.1rem !important;
            color: var(--primary-green) !important;
        }

        .service-item p {
            font-size: 0.9rem !important;
        }

        .about-content h1 {
            font-size: 2rem !important;
            color: var(--primary-green) !important;
        }

        .about-content h5 {
            font-size: 1rem !important;
            color: var(--orange) !important;
        }

        .about-content p {
            font-size: 0.9rem !important;
        }

        .testimonial-item h5 {
            font-size: 1rem !important;
            color: var(--primary-green) !important;
        }

        .testimonial-item p {
            font-size: 0.85rem !important;
        }

        .team-item h5 {
            font-size: 1rem !important;
            color: var(--primary-green) !important;
        }

        .team-item small {
            font-size: 0.8rem !important;
            color: var(--orange) !important;
        }

        /* Section headings */
        .section-title h1 {
            font-size: 2rem !important;
            color: var(--primary-green) !important;
        }

        .section-title h5 {
            font-size: 1rem !important;
            color: var(--orange) !important;
        }

        .section-title p {
            font-size: 0.9rem !important;
        }

        /* Feature items */
        .feature-item h5 {
            font-size: 1rem !important;
            color: var(--primary-green) !important;
        }

        .feature-item p {
            font-size: 0.85rem !important;
        }

        /* Project items */
        .project-item h5 {
            font-size: 1rem !important;
            color: var(--primary-green) !important;
        }

        .project-item span {
            font-size: 0.8rem !important;
            color: var(--orange) !important;
        }

        /* Contact form */
        .contact-form .form-control {
            font-size: 0.85rem !important;
        }

        .contact-form .btn {
            font-size: 0.9rem !important;
        }

        /* Cards and boxes */
        .card, .bg-light {
            border: 1px solid rgba(74, 93, 79, 0.1);
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(74, 93, 79, 0.15);
            transition: all 0.3s ease;
        }

        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            .hero-header h1 {
                font-size: 2rem !important;
            }
            
            .hero-header h5 {
                font-size: 1rem !important;
            }
            
            .section-title h1 {
                font-size: 1.7rem !important;
            }
        }

        /* Custom animations */
        .navbar-brand:hover .logo-img {
            transform: scale(1.05);
        }

        /* Form focus states */
        .form-control:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 0.2rem rgba(244, 165, 56, 0.25);
        }
    </style>

    @stack('scripts')
</body>

</html>