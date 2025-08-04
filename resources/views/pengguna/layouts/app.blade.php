<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'HILAW - Hukum Indonesia Layanan Warga')</title>
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
    <div class="container-fluid bg-dark text-light px-0 py-1">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-3 text-start">
                <div class="h-100 d-inline-flex align-items-center me-3">
                    <span class="fa fa-phone-alt me-2" style="font-size: 0.8rem;"></span>
                    <span style="font-size: 0.85rem;">+62 800 1234 567</span>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <span class="far fa-envelope me-2" style="font-size: 0.8rem;"></span>
                    <span style="font-size: 0.85rem;">info@hilaw.id</span>
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
        <a href="{{ route('pengguna.dashboard') }}" class="navbar-brand d-flex align-items-center px-3 px-lg-4">
            <h2 class="m-0" style="font-size: 1.5rem;">HILAW</h2>
        </a>
        <button type="button" class="navbar-toggler me-3" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-3 p-lg-0">
                <a href="{{ route('pengguna.dashboard') }}" class="nav-item nav-link px-2 py-2 {{ request()->routeIs('pengguna.dashboard') ? 'active' : '' }}" style="font-size: 0.9rem;">Dashboard</a>
                <a href="{{ route('pengguna.dokters.index') }}" class="nav-item nav-link px-2 py-2 {{ request()->routeIs('pengguna.dokters.*') ? 'active' : '' }}" style="font-size: 0.9rem;">Advokat</a>
                <a href="{{ route('pengguna.consultations.index') }}" class="nav-item nav-link px-2 py-2 {{ request()->routeIs('pengguna.consultations.*') ? 'active' : '' }}" style="font-size: 0.9rem;">Konsultasi</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle px-2 py-2" data-bs-toggle="dropdown" data-bs-auto-close="true" style="font-size: 0.9rem;">Layanan</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="#" class="dropdown-item py-2" style="font-size: 0.85rem;">Hukum Pidana</a>
                        <a href="#" class="dropdown-item py-2" style="font-size: 0.85rem;">Hukum Perdata</a>
                        <a href="#" class="dropdown-item py-2" style="font-size: 0.85rem;">Hukum Bisnis</a>
                        <a href="#" class="dropdown-item py-2" style="font-size: 0.85rem;">Hukum Keluarga</a>
                        <a href="{{ route('pengguna.syarat') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">Syarat & Ketentuan</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle px-2 py-2" data-bs-toggle="dropdown" data-bs-auto-close="true" style="font-size: 0.9rem;">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item py-2" style="font-size: 0.85rem;">Profile</a>
                        <a href="#" class="dropdown-item py-2" style="font-size: 0.85rem;">Riwayat</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start py-2" onclick="return confirm('Yakin ingin logout?')" style="font-size: 0.85rem;">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Flash Messages Container -->
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-2 my-1 py-2" role="alert">
                <i class="fas fa-check-circle me-2" style="font-size: 0.9rem;"></i>
                <span style="font-size: 0.9rem;">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.8rem;"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-2 my-1 py-2" role="alert">
                <i class="fas fa-exclamation-circle me-2" style="font-size: 0.9rem;"></i>
                <span style="font-size: 0.9rem;">{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.8rem;"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mx-2 my-1 py-2" role="alert">
                <i class="fas fa-exclamation-circle me-2" style="font-size: 0.9rem;"></i>
                <div style="font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}@if (!$loop->last)<br>@endif
                    @endforeach
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.8rem;"></button>
            </div>
        @endif
    </div>

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-4 py-4 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-3">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Our Office</h5>
                    <p class="mb-2" style="font-size: 0.85rem;"><i class="fa fa-map-marker-alt me-2"></i>Jl. Sudirman No. 123, Jakarta, Indonesia</p>
                    <p class="mb-2" style="font-size: 0.85rem;"><i class="fa fa-phone-alt me-2"></i>+62 800 1234 567</p>
                    <p class="mb-2" style="font-size: 0.85rem;"><i class="fa fa-envelope me-2"></i>info@hilaw.id</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter" style="font-size: 0.8rem;"></i></a>
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f" style="font-size: 0.8rem;"></i></a>
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-youtube" style="font-size: 0.8rem;"></i></a>
                        <a class="btn btn-sm btn-outline-light rounded-circle me-2" href="" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-linkedin-in" style="font-size: 0.8rem;"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Layanan Hukum</h5>
                    <a class="btn btn-link p-1" href="" style="font-size: 0.85rem;">Hukum Pidana</a>
                    <a class="btn btn-link p-1" href="" style="font-size: 0.85rem;">Hukum Perdata</a>
                    <a class="btn btn-link p-1" href="" style="font-size: 0.85rem;">Hukum Bisnis</a>
                    <a class="btn btn-link p-1" href="" style="font-size: 0.85rem;">Hukum Keluarga</a>
                    <a class="btn btn-link p-1" href="" style="font-size: 0.85rem;">Konsultasi Online</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Quick Links</h5>
                    <a class="btn btn-link p-1" href="{{ route('pengguna.dashboard') }}" style="font-size: 0.85rem;">Dashboard</a>
                    <a class="btn btn-link p-1" href="{{ route('pengguna.dokters.index') }}" style="font-size: 0.85rem;">Cari Advokat</a>
                    <a class="btn btn-link p-1" href="{{ route('pengguna.consultations.index') }}" style="font-size: 0.85rem;">Konsultasi Saya</a>
                    <a class="btn btn-link p-1" href="{{ route('pengguna.syarat') }}" style="font-size: 0.85rem;">Syarat & Ketentuan</a>
                    <a class="btn btn-link p-1" href="" style="font-size: 0.85rem;">Bantuan</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3" style="font-size: 1.1rem;">Newsletter</h5>
                    <p style="font-size: 0.85rem;">Dapatkan informasi terbaru seputar hukum dan layanan kami.</p>
                    <div class="position-relative w-100">
                        <input class="form-control bg-light border-light w-100 py-2 ps-3 pe-4" type="email" placeholder="Email Anda" style="font-size: 0.85rem;">
                        <button type="button" class="btn btn-primary py-1 px-2 position-absolute top-0 end-0 mt-1 me-1" style="font-size: 0.8rem;">Berlangganan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <span style="font-size: 0.85rem;">&copy; <a class="border-bottom" href="#">HILAW</a>, All Right Reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span style="font-size: 0.85rem;">Platform Konsultasi Hukum Online</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-up" style="font-size: 1rem;"></i></a>

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
        /* Prevent horizontal scroll */
        body {
            overflow-x: hidden;
            font-size: 0.9rem;
        }

        /* Fix dropdown positioning - PERBAIKAN UTAMA */
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

        /* Khusus untuk dropdown user agar tetap dekat dengan nama */
        .navbar .nav-item.dropdown:last-child .dropdown-menu {
            right: 0 !important;
            left: auto !important;
        }

        /* Responsive navbar untuk mobile */
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
        }

        /* Memberikan margin untuk nav item terakhir agar tidak mentok */
        .navbar .nav-item:last-child {
            margin-right: 10px;
        }

        /* Ensure dropdown items properly aligned */
        .dropdown-item {
            padding: 0.4rem 0.8rem;
            white-space: nowrap;
        }

        /* Fix navbar container */
        .navbar-nav {
            margin-right: 0 !important;
        }

        /* Compact alert styling */
        .alert {
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.5rem;
        }

        /* Smaller font sizes for various elements */
        .navbar-brand h2 {
            font-weight: 600;
        }

        .footer h5 {
            font-weight: 500;
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
        }

        /* Compact spacing */
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* Smaller button sizes in footer */
        .footer .btn-link {
            padding: 0.25rem 0;
            text-align: left;
            color: #6c757d;
        }

        .footer .btn-link:hover {
            color: #fff;
        }
    </style>

    <script>
        // Auto-hide flash messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[data-bs-dismiss="alert"]');
            alerts.forEach(function(alert) {
                alert.click();
            });
        }, 5000);

        // Ensure dropdown closes when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.dropdown-menu.show');
            dropdowns.forEach(function(dropdown) {
                if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>