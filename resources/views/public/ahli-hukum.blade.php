@extends('layouts.app')

@section('title', 'Ahli Hukum Profesional - Hilaw')
@section('keywords', 'pengacara, ahli hukum, konsultasi hukum, lawyer indonesia')
@section('description', 'Temui para ahli hukum profesional dan berpengalaman di Hilaw. Konsultasikan masalah hukum Anda dengan pengacara terbaik.')

@push('styles')
<style>
.page-header {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('template/img/carousel-1.jpg') }}');
    background-size: cover;
    background-position: center;
    min-height: 300px;
    display: flex;
    align-items: center;
}

.lawyer-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.lawyer-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.lawyer-photo {
    width: 100%;
    height: 250px;
    object-fit: cover;
    object-position: center top;
}

.lawyer-info {
    padding: 1.5rem;
}

.lawyer-name {
    color: var(--primary-green);
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.lawyer-specialty {
    color: var(--orange);
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.lawyer-details {
    margin-bottom: 1.5rem;
}

.lawyer-details .detail-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    color: #666;
}

.lawyer-details .detail-item i {
    width: 16px;
    color: var(--orange);
    margin-right: 0.5rem;
}

.status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: bold;
    color: white;
}

.status-online {
    background: #28a745;
}

.status-offline {
    background: #6c757d;
}

.price-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.price-amount {
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--primary-green);
}

.price-label {
    font-size: 0.8rem;
    color: #666;
}

.rating-stars {
    color: #ffc107;
    margin-right: 0.5rem;
}

.rating-count {
    color: #666;
    font-size: 0.85rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-consult {
    flex: 1;
    font-size: 0.9rem;
    padding: 0.6rem 1rem;
}

.btn-view {
    padding: 0.6rem 1rem;
    font-size: 0.9rem;
}

.filter-section {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.filter-title {
    color: var(--primary-green);
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.search-box {
    margin-bottom: 1.5rem;
}

.filter-group {
    margin-bottom: 1rem;
}

.filter-group label {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.5rem;
    display: block;
}

.stats-section {
    background: var(--primary-green);
    color: white;
    padding: 3rem 0;
    margin: 3rem 0;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--orange);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1rem;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #666;
}

.empty-state i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}

@media (max-width: 768px) {
    .filter-section {
        margin-bottom: 1rem;
    }
    
    .lawyer-photo {
        height: 200px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .price-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Ahli Hukum Profesional</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item text-orange active" aria-current="page">Ahli Hukum</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Stats Section Start -->
<div class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="stat-item">
                    <div class="stat-number">{{ $pengacara->count() > 0 ? $pengacara->total() ?? $pengacara->count() : 50 }}+</div>
                    <div class="stat-label">Pengacara Ahli</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0.3s">
                <div class="stat-item">
                    <div class="stat-number">{{ $pengacara->where('is_online', true)->count() }}+</div>
                    <div class="stat-label">Online Sekarang</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0.5s">
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Bidang Keahlian</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center wow fadeInUp" data-wow-delay="0.7s">
                <div class="stat-item">
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Klien Dilayani</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Stats Section End -->

<!-- Lawyers Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Tim Pengacara Kami</h3>
            <h2 class="mb-5">Profesional Berpengalaman Siap Membantu Anda</h2>
        </div>

        <!-- Filter Section -->
        <div class="filter-section wow fadeInUp" data-wow-delay="0.1s">
            <div class="filter-title">
                <i class="fas fa-filter me-2"></i>Filter Pengacara
            </div>
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau keahlian...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <select class="form-select">
                            <option value="">Semua Keahlian</option>
                            <option value="hukum-pidana">Hukum Pidana</option>
                            <option value="hukum-perdata">Hukum Perdata</option>
                            <option value="hukum-bisnis">Hukum Bisnis</option>
                            <option value="hukum-keluarga">Hukum Keluarga</option>
                            <option value="hukum-ketenagakerjaan">Hukum Ketenagakerjaan</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <select class="form-select">
                            <option value="">Status</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button class="btn btn-orange w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </div>
        </div>

        @if($pengacara->count() > 0)
            <!-- Lawyers Grid -->
            <div class="row g-4">
                @foreach($pengacara as $index => $lawyer)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index % 3) * 0.2 }}s">
                    <div class="lawyer-card position-relative">
                        <!-- Status Badge -->
                        @if($lawyer->is_online)
                            <span class="status-badge status-online">Online</span>
                        @else
                            <span class="status-badge status-offline">Offline</span>
                        @endif

                        <!-- Photo -->
                        @if($lawyer->foto)
                            <img src="{{ asset('storage/' . $lawyer->foto) }}" 
                                 alt="{{ $lawyer->name }}" 
                                 class="lawyer-photo">
                        @else
                            <div class="lawyer-photo d-flex align-items-center justify-content-center" 
                                 style="background: linear-gradient(135deg, var(--primary-green), var(--orange));">
                                <i class="fas fa-balance-scale text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <!-- Info -->
                        <div class="lawyer-info">
                            <h4 class="lawyer-name">{{ $lawyer->name }}</h4>
                            <div class="lawyer-specialty">{{ $lawyer->keahlian ?? 'Konsultan Hukum' }}</div>

                            <!-- Rating -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count">4.9 ({{ rand(25, 150) }} ulasan)</span>
                            </div>

                            <!-- Details -->
                            <div class="lawyer-details">
                                @if($lawyer->pengalaman_tahun)
                                <div class="detail-item">
                                    <i class="fas fa-briefcase"></i>
                                    <span>{{ $lawyer->pengalaman_tahun }} tahun pengalaman</span>
                                </div>
                                @endif
                                
                                @if($lawyer->lulusan_universitas)
                                <div class="detail-item">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span>{{ Str::limit($lawyer->lulusan_universitas, 30) }}</span>
                                </div>
                                @endif
                                
                                @if($lawyer->alamat)
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ Str::limit($lawyer->alamat, 25) }}</span>
                                </div>
                                @endif
                                
                                <div class="detail-item">
                                    <i class="fas fa-language"></i>
                                    <span>Bahasa Indonesia, Inggris</span>
                                </div>
                            </div>

                            <!-- Price Info -->
                            @if($lawyer->tarif_konsultasi)
                            <div class="price-info">
                                <div>
                                    <div class="price-amount">Rp {{ number_format($lawyer->tarif_konsultasi, 0, ',', '.') }}</div>
                                    <div class="price-label">per konsultasi</div>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">Mulai dari</small>
                                </div>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                @if($lawyer->is_online)
                                    <a href="{{ route('login') }}" class="btn btn-orange btn-consult">
                                        <i class="fas fa-comments me-2"></i>Konsultasi
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-consult" disabled>
                                        <i class="fas fa-clock me-2"></i>Offline
                                    </button>
                                @endif
                                <a href="{{ route('login') }}" class="btn btn-outline-orange btn-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($pengacara, 'links'))
                <div class="pagination-wrapper">
                    {{ $pengacara->links() }}
                </div>
            @endif

            <!-- Load More Button (if not using pagination) -->
            @if(!method_exists($pengacara, 'links') && $pengacara->count() >= 9)
                <div class="text-center mt-4">
                    <button class="btn btn-outline-orange btn-lg rounded-pill px-4" onclick="loadMoreLawyers()">
                        <i class="fas fa-plus me-2"></i>Lihat Lebih Banyak
                    </button>
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="empty-state wow fadeInUp" data-wow-delay="0.1s">
                <i class="fas fa-users"></i>
                <h4>Belum Ada Pengacara Tersedia</h4>
                <p>Saat ini belum ada pengacara yang terdaftar dan disetujui dalam sistem.</p>
                <a href="{{ route('kontak') }}" class="btn btn-orange rounded-pill px-4">
                    <i class="fas fa-envelope me-2"></i>Hubungi Admin
                </a>
            </div>
        @endif
    </div>
</div>
<!-- Lawyers Section End -->

<!-- Why Choose Our Lawyers Start -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Mengapa Memilih Pengacara Kami?</h3>
            <h2 class="mb-5">Kualitas dan Profesionalisme Terjamin</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-certificate fa-3x text-orange"></i>
                    </div>
                    <h5 class="text-primary-green">Bersertifikat Resmi</h5>
                    <p class="text-muted">Semua pengacara memiliki izin praktik resmi dan terdaftar di Perhimpunan Advokat Indonesia.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-star fa-3x text-orange"></i>
                    </div>
                    <h5 class="text-primary-green">Rating Tinggi</h5>
                    <p class="text-muted">Pengacara dengan rating minimal 4.5 bintang dari review klien yang telah dilayani.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-handshake fa-3x text-orange"></i>
                    </div>
                    <h5 class="text-primary-green">Pengalaman Terbukti</h5>
                    <p class="text-muted">Minimal 5 tahun pengalaman menangani berbagai kasus hukum dengan tingkat keberhasilan tinggi.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-clock fa-3x text-orange"></i>
                    </div>
                    <h5 class="text-primary-green">Respon Cepat</h5>
                    <p class="text-muted">Komitmen memberikan respon dalam waktu maksimal 30 menit untuk konsultasi urgent.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Why Choose Our Lawyers End -->

<!-- Specialization Areas Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Bidang Keahlian</h3>
            <h2 class="mb-5">Berbagai Spesialisasi Hukum Tersedia</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-white rounded p-4 text-center shadow-sm h-100">
                    <div class="mb-3">
                        <i class="fas fa-gavel fa-3x text-orange"></i>
                    </div>
                    <h5 class="mb-3 text-primary-green">Hukum Pidana</h5>
                    <p class="text-muted mb-3">Penanganan kasus pidana umum, korupsi, narkoba, dan tindak pidana lainnya.</p>
                    <span class="badge bg-orange text-white">{{ $pengacara->where('keahlian', 'like', '%pidana%')->count() }} Pengacara</span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-white rounded p-4 text-center shadow-sm h-100">
                    <div class="mb-3">
                        <i class="fas fa-handshake fa-3x text-orange"></i>
                    </div>
                    <h5 class="mb-3 text-primary-green">Hukum Perdata</h5>
                    <p class="text-muted mb-3">Sengketa kontrak, wanprestasi, ganti rugi, dan perselisihan perdata lainnya.</p>
                    <span class="badge bg-orange text-white">{{ $pengacara->where('keahlian', 'like', '%perdata%')->count() }} Pengacara</span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-white rounded p-4 text-center shadow-sm h-100">
                    <div class="mb-3">
                        <i class="fas fa-building fa-3x text-orange"></i>
                    </div>
                    <h5 class="mb-3 text-primary-green">Hukum Bisnis</h5>
                    <p class="text-muted mb-3">Pendirian PT, kontrak bisnis, merger akuisisi, dan compliance perusahaan.</p>
                    <span class="badge bg-orange text-white">{{ $pengacara->where('keahlian', 'like', '%bisnis%')->count() }} Pengacara</span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="bg-white rounded p-4 text-center shadow-sm h-100">
                    <div class="mb-3">
                        <i class="fas fa-home fa-3x text-orange"></i>
                    </div>
                    <h5 class="mb-3 text-primary-green">Hukum Keluarga</h5>
                    <p class="text-muted mb-3">Perceraian, hak asuh anak, pembagian harta, waris, dan adopsi.</p>
                    <span class="badge bg-orange text-white">{{ $pengacara->where('keahlian', 'like', '%keluarga%')->count() }} Pengacara</span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.9s">
                <div class="bg-white rounded p-4 text-center shadow-sm h-100">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-orange"></i>
                    </div>
                    <h5 class="mb-3 text-primary-green">Hukum Ketenagakerjaan</h5>
                    <p class="text-muted mb-3">PHK, sengketa gaji, kontrak kerja, dan hubungan industrial.</p>
                    <span class="badge bg-orange text-white">{{ $pengacara->where('keahlian', 'like', '%kerja%')->count() }} Pengacara</span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="1.1s">
                <div class="bg-white rounded p-4 text-center shadow-sm h-100">
                    <div class="mb-3">
                        <i class="fas fa-landmark fa-3x text-orange"></i>
                    </div>
                    <h5 class="mb-3 text-primary-green">Hukum Properti</h5>
                    <p class="text-muted mb-3">Jual beli properti, sengketa tanah, sertifikat, dan investasi properti.</p>
                    <span class="badge bg-orange text-white">{{ rand(5, 15) }} Pengacara</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Specialization Areas End -->

<!-- CTA Section Start -->
<div class="container-fluid bg-dark-green text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <h3 class="mb-2">Siap Berkonsultasi dengan Pengacara Ahli?</h3>
                <p class="mb-0">Pilih pengacara yang sesuai dengan kebutuhan Anda dan mulai konsultasi sekarang juga!</p>
            </div>
            <div class="col-lg-4 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('login') }}" class="btn btn-orange btn-lg rounded-pill px-4">
                    <i class="fas fa-search me-2"></i>Pilih Pengacara
                </a>
            </div>
        </div>
    </div>
</div>
<!-- CTA Section End -->

<script>
function loadMoreLawyers() {
    // Implementasi load more lawyers jika diperlukan
    // Bisa menggunakan AJAX untuk load data tambahan
    alert('Fitur load more akan segera tersedia!');
}

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('input[placeholder*="Cari"]');
    const specialtySelect = document.querySelector('select option[value="hukum-pidana"]').parentElement;
    const statusSelect = document.querySelectorAll('select')[1];
    const searchButton = document.querySelector('.btn-orange');

    if (searchButton) {
        searchButton.addEventListener('click', function() {
            // Implementasi filter/search
            // Untuk sementara redirect ke login
            window.location.href = '{{ route("login") }}';
        });
    }
});
</script>
@endsection