@extends('pengguna.layouts.app')

@section('title', 'Dashboard Pengguna')
@section('page-title', 'Dashboard')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Dashboard</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Welcome Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Welcome Card -->
            <div class="col-lg-8">
                <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex align-items-center mb-3">
                        <div class="btn-square rounded-circle bg-primary me-3" style="width: 45px; height: 45px;">
                            <i class="fas fa-user text-white" style="font-size: 1rem;"></i>
                        </div>
                        <div>
                            <h4 class="mb-1" style="font-size: 1.3rem;">Selamat Datang, {{ auth()->user()->name }}!</h4>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Platform Konsultasi Hukum Online</p>
                        </div>
                    </div>
                    <p class="mb-3" style="font-size: 0.9rem;">Akses layanan konsultasi hukum profesional kapan saja, di mana saja. Dapatkan solusi terbaik untuk permasalahan hukum Anda dari ahli hukum berpengalaman.</p>
                    
                    <!-- Quick Actions -->
                    <div class="d-flex gap-3">
                        <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-primary" style="font-size: 0.85rem; padding: 10px 20px;">
                            <i class="fas fa-search me-2" style="font-size: 0.8rem;"></i>Cari Ahli Hukum
                        </a>
                        <a href="{{ route('pengguna.consultations.index') }}" class="btn btn-outline-primary" style="font-size: 0.85rem; padding: 10px 20px;">
                            <i class="fas fa-history me-2" style="font-size: 0.8rem;"></i>Riwayat Konsultasi
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="col-lg-4">
                <div class="bg-primary rounded p-4 text-white wow fadeInUp" data-wow-delay="0.2s">
                    <div class="text-center">
                        <div class="btn-square rounded-circle bg-white mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-user text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="text-white mb-3" style="font-size: 1.1rem;">Informasi Akun</h5>
                        <div class="text-start">
                            <p class="mb-2" style="font-size: 0.85rem;"><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                            <p class="mb-2" style="font-size: 0.85rem;"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                            <p class="mb-0" style="font-size: 0.85rem;">
                                <strong>Status:</strong> 
                                <span class="badge bg-success ms-2" style="font-size: 0.7rem;">Aktif</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Welcome Section End -->

<!-- Stats Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="fs-6 fw-bold text-primary" style="font-size: 0.9rem;">Statistik Anda</p>
            <h2 class="mb-5" style="font-size: 1.8rem;">Ringkasan Aktivitas</h2>
        </div>
        
        <div class="row g-4">
            <!-- Total Konsultasi -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded d-flex h-100">
                    <div class="service-text rounded p-4 text-center w-100">
                        <div class="btn-square rounded-circle mx-auto mb-3 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fas fa-comments text-white" style="font-size: 1.2rem;"></i>
                        </div>
                        <h5 class="mb-2" style="font-size: 1rem;">Total Konsultasi</h5>
                        <h3 class="text-primary mb-2" style="font-size: 1.8rem;">{{ $totalConsultations }}</h3>
                        <p class="text-muted" style="font-size: 0.8rem;">Konsultasi yang telah dilakukan</p>
                    </div>
                </div>
            </div>

            <!-- Konsultasi Aktif -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-item rounded d-flex h-100">
                    <div class="service-text rounded p-4 text-center w-100">
                        <div class="btn-square rounded-circle mx-auto mb-3 bg-success" style="width: 50px; height: 50px;">
                            <i class="fas fa-clock text-white" style="font-size: 1.2rem;"></i>
                        </div>
                        <h5 class="mb-2" style="font-size: 1rem;">Konsultasi Aktif</h5>
                        <h3 class="text-success mb-2" style="font-size: 1.8rem;">{{ $activeConsultations }}</h3>
                        <p class="text-muted" style="font-size: 0.8rem;">Sedang berlangsung</p>
                    </div>
                </div>
            </div>

            <!-- Ahli Hukum Aktif -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item rounded d-flex h-100">
                    <div class="service-text rounded p-4 text-center w-100">
                        <div class="btn-square rounded-circle mx-auto mb-3 bg-warning" style="width: 50px; height: 50px;">
                            <i class="fas fa-balance-scale text-white" style="font-size: 1.2rem;"></i>
                        </div>
                        <h5 class="mb-2" style="font-size: 1rem;">Ahli Aktif</h5>
                        <h3 class="text-warning mb-2" style="font-size: 1.8rem;">{{ $activeLawyers }}</h3>
                        <p class="text-muted" style="font-size: 0.8rem;">Tersedia online</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Stats Section End -->

<!-- Recent Consultations Section Start -->
@if(isset($recentConsultations) && $recentConsultations->isNotEmpty())
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="fs-6 fw-bold text-primary" style="font-size: 0.9rem;">Aktivitas Terbaru</p>
            <h2 class="mb-5" style="font-size: 1.8rem;">Konsultasi Terbaru</h2>
        </div>
        
        <div class="row g-3">
            @foreach($recentConsultations->take(3) as $index => $consultation)
            <div class="col-lg-4 col-md-6 wow fadeInUp consultation-card" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s">
                <div class="consultation-item p-3 border-bottom">
                    <div class="row align-items-center">
                        <!-- Status Badge - Left Side -->
                        <div class="col-auto">
                            <div class="status-container position-relative">
                                <div class="d-flex align-items-center justify-content-center rounded status-badge" 
                                     style="background: {{ $consultation->status == 'completed' ? 'linear-gradient(135deg, #28a745, #20c997)' : ($consultation->status == 'approved' ? 'linear-gradient(135deg, #007bff, #6610f2)' : 'linear-gradient(135deg, #ffc107, #fd7e14)') }}; width: 50px; height: 65px;">
                                    <span class="text-white fw-bold" style="font-size: 0.7rem; text-align: center;">
                                        {{ $consultation->status == 'completed' ? 'DONE' : ($consultation->status == 'approved' ? 'CHAT' : 'WAIT') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Consultation Info - Right Side -->
                        <div class="col">
                            <div class="ps-3">
                                <!-- Lawyer Name and Specialty -->
                                <div class="mb-2">
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">{{ $consultation->dokter->name }}</h6>
                                    <p class="text-primary fw-semibold mb-1" style="font-size: 0.8rem;">{{ $consultation->dokter->keahlian }}</p>
                                </div>
                                
                                <!-- Complaint Preview -->
                                <div class="mb-2">
                                    <p class="text-muted mb-1" style="font-size: 0.75rem; line-height: 1.4;">{{ Str::limit($consultation->keluhan, 60) }}</p>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $consultation->created_at->diffForHumans() }}</small>
                                </div>
                                
                                <!-- Actions -->
                                <div class="d-flex gap-2 mt-2">
                                    <a href="{{ route('pengguna.consultations.show', $consultation->id) }}" 
                                       class="btn btn-outline-primary btn-sm" style="font-size: 0.7rem; padding: 4px 12px;">
                                        <i class="fa fa-eye me-1" style="font-size: 0.6rem;"></i>Detail
                                    </a>
                                    
                                    @if(in_array($consultation->status, ['approved', 'completed']) && is_null($consultation->chat_ended_at))
                                        <a href="{{ route('pengguna.consultations.chat', $consultation->id) }}" 
                                           class="btn btn-success btn-sm" style="font-size: 0.7rem; padding: 4px 12px;">
                                            <i class="fa fa-comments me-1" style="font-size: 0.6rem;"></i>Chat
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4 wow fadeInUp" data-wow-delay="0.3s">
            <a href="{{ route('pengguna.consultations.index') }}" class="btn btn-primary" style="font-size: 0.85rem; padding: 10px 20px;">
                <i class="fas fa-list me-2" style="font-size: 0.8rem;"></i>Lihat Semua Konsultasi
            </a>
        </div>
    </div>
</div>
@endif
<!-- Recent Consultations Section End -->

<!-- Quick Services Section Start -->
<div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="fs-6 fw-bold text-primary" style="font-size: 0.9rem;">Layanan Cepat</p>
            <h2 class="mb-5" style="font-size: 1.8rem;">Akses Mudah Ke Layanan Kami</h2>
        </div>
        
        <div class="row g-4">
            <!-- Konsultasi Online -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded h-100">
                    <div class="service-text rounded p-4 text-center d-flex flex-column h-100">
                        <div class="btn-square rounded-circle mx-auto mb-3 bg-primary" style="width: 55px; height: 55px;">
                            <i class="fas fa-comments text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <h5 class="mb-3" style="font-size: 1rem;">Konsultasi Online</h5>
                        <p class="mb-3 flex-grow-1" style="font-size: 0.85rem;">Chat dengan ahli hukum</p>
                        <div class="mt-auto">
                            <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-primary" style="font-size: 0.8rem; padding: 8px 16px;">
                                <i class="fas fa-arrow-right me-1" style="font-size: 0.7rem;"></i>Mulai Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Konsultasi -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-item rounded h-100">
                    <div class="service-text rounded p-4 text-center d-flex flex-column h-100">
                        <div class="btn-square rounded-circle mx-auto mb-3 bg-success" style="width: 55px; height: 55px;">
                            <i class="fas fa-history text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <h5 class="mb-3" style="font-size: 1rem;">Riwayat Konsultasi</h5>
                        <p class="mb-3 flex-grow-1" style="font-size: 0.85rem;">Kelola riwayat konsultasi</p>
                        <div class="mt-auto">
                            <a href="{{ route('pengguna.consultations.index') }}" class="btn btn-success" style="font-size: 0.8rem; padding: 8px 16px;">
                                <i class="fas fa-arrow-right me-1" style="font-size: 0.7rem;"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profil Saya -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item rounded h-100">
                    <div class="service-text rounded p-4 text-center d-flex flex-column h-100">
                        <div class="btn-square rounded-circle mx-auto mb-3 bg-info" style="width: 55px; height: 55px;">
                            <i class="fas fa-user-cog text-white" style="font-size: 1.3rem;"></i>
                        </div>
                        <h5 class="mb-3" style="font-size: 1rem;">Kelola Profil</h5>
                        <p class="mb-3 flex-grow-1" style="font-size: 0.85rem;">Update data pribadi</p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-info" style="font-size: 0.8rem; padding: 8px 16px;">
                                <i class="fas fa-arrow-right me-1" style="font-size: 0.7rem;"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick Services Section End -->

<style>
.consultation-item {
    transition: background-color 0.3s ease;
    border-bottom: 1px solid #eee !important;
}

.consultation-item:hover {
    background-color: #f8f9fa;
}

.consultation-card:last-child .consultation-item {
    border-bottom: none !important;
}

.status-container {
    position: relative;
}

.status-badge {
    transition: transform 0.3s ease;
}

.consultation-card:hover .status-badge {
    transform: scale(1.05);
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .col-lg-4 {
        flex: 0 0 auto;
        width: 100%;
    }
    
    .consultation-item {
        padding: 1.5rem !important;
    }
    
    .status-badge {
        width: 55px !important;
        height: 70px !important;
    }
    
    .ps-3 {
        padding-left: 1rem !important;
    }
    
    /* Perbesar font untuk mobile */
    .consultation-item h6 {
        font-size: 1.1rem !important;
    }
    
    .consultation-item .text-primary {
        font-size: 0.9rem !important;
    }
    
    .consultation-item .text-muted {
        font-size: 0.85rem !important;
    }
    
    .consultation-item .btn {
        font-size: 0.8rem !important;
        padding: 8px 16px !important;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.75rem !important;
    }
    
    .d-flex.gap-2 .btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .consultation-item {
        padding: 1.25rem !important;
    }
    
    .status-badge {
        width: 50px !important;
        height: 65px !important;
    }
    
    .consultation-item h6 {
        font-size: 1rem !important;
    }
    
    .consultation-item .text-primary {
        font-size: 0.85rem !important;
    }
    
    .consultation-item .btn {
        font-size: 0.75rem !important;
        padding: 6px 12px !important;
    }
}
</style>

@endsection