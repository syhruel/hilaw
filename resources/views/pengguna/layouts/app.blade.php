<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HILAW - Hukum Indonesia Layanan Warga')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('pengguna.dashboard') }}" style="color: #1e40af !important;">
                <i class="fas fa-balance-scale me-2"></i>HILAW
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1 {{ request()->routeIs('pengguna.dashboard') ? 'bg-primary text-white' : '' }}" 
                           href="{{ route('pengguna.dashboard') }}" 
                           style="{{ request()->routeIs('pengguna.dashboard') ? 'background-color: #1e40af !important;' : '' }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1 {{ request()->routeIs('pengguna.dokters.*') ? 'bg-primary text-white' : '' }}" 
                           href="{{ route('pengguna.dokters.index') }}"
                           style="{{ request()->routeIs('pengguna.dokters.*') ? 'background-color: #1e40af !important;' : '' }}">
                           Advokat Online
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded mx-1 {{ request()->routeIs('pengguna.consultations.*') ? 'bg-primary text-white' : '' }}" 
                           href="{{ route('pengguna.consultations.index') }}"
                           style="{{ request()->routeIs('pengguna.consultations.*') ? 'background-color: #1e40af !important;' : '' }}">
                           Konsultasi Saya
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 py-2 rounded mx-1" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger border-0 bg-transparent w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Area untuk Dashboard -->
    <div class="container" style="margin-top: 100px; min-height: 60vh;">
        <!-- Flash Messages Laravel -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}@if (!$loop->last)<br>@endif
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer Bootstrap -->
    <footer class="bg-white py-5 border-top">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3" style="color: #1e40af;">
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
                    <h5 class="fw-bold mb-3" style="color: #1e40af;">Layanan</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('pengguna.consultations.index') }}" class="text-muted text-decoration-none">Konsultasi Hukum Online</a>
                        <a href="{{ route('pengguna.dokters.index') }}" class="text-muted text-decoration-none">Advokat Terpercaya</a>
                        <a href="#" class="text-muted text-decoration-none">Bantuan Hukum</a>
                        <a href="#" class="text-muted text-decoration-none">Edukasi Hukum</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3" style="color: #1e40af;">Kontak</h5>
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
                    <a href="{{ route('pengguna.syarat') }}" class="text-muted text-decoration-none">Syarat & Ketentuan</a>
                    <a href="#" class="text-muted text-decoration-none">Kebijakan Privasi</a>
                    <a href="#" class="text-muted text-decoration-none">FAQ</a>
                    <a href="#" class="text-muted text-decoration-none">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar active state management dengan tema biru
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Allow normal navigation for actual links
                if (this.href && this.href !== window.location.href + '#') {
                    // Remove active class from all links
                    document.querySelectorAll('.navbar-nav .nav-link').forEach(l => {
                        l.classList.remove('bg-primary', 'text-white');
                        l.style.backgroundColor = '';
                    });
                    // Add active class to clicked link
                    if (!this.classList.contains('dropdown-toggle')) {
                        this.classList.add('bg-primary', 'text-white');
                        this.style.backgroundColor = '#1e40af';
                    }
                }
            });
            
            // Hover effect for non-active links
            link.addEventListener('mouseenter', function() {
                if (!this.classList.contains('bg-primary') && !this.classList.contains('dropdown-toggle')) {
                    this.classList.add('bg-light');
                }
            });
            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('bg-primary') && !this.classList.contains('dropdown-toggle')) {
                    this.classList.remove('bg-light');
                }
            });
        });

        // Dropdown hover effect
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        if (dropdownToggle) {
            dropdownToggle.addEventListener('mouseenter', function() {
                this.classList.add('bg-light');
            });
            dropdownToggle.addEventListener('mouseleave', function() {
                this.classList.remove('bg-light');
            });
        }

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // Set active menu based on current page dengan tema biru
        function setActiveMenu() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href) && !link.classList.contains('dropdown-toggle')) {
                    link.classList.add('bg-primary', 'text-white');
                    link.style.backgroundColor = '#1e40af';
                } else if (!link.classList.contains('dropdown-toggle')) {
                    link.classList.remove('bg-primary', 'text-white');
                    link.style.backgroundColor = '';
                }
            });
        }

        // Call setActiveMenu when page loads
        document.addEventListener('DOMContentLoaded', setActiveMenu);
    </script>
    @yield('scripts')
</body>
</html>