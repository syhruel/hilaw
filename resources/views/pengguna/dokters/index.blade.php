@extends('pengguna.layouts.app')

@section('title', 'Daftar Ahli Hukum')
@section('page-title', 'Ahli Hukum Online')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Ahli Hukum Online</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ahli Hukum</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Legal Experts Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="fs-6 fw-bold text-primary">Legal Professionals</p>
            <h1 class="display-6 mb-4">Ahli Hukum Profesional Yang Siap Membantu Anda</h1>
        </div>
        
        <!-- Search Section Start -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7">
                <div class="bg-light rounded p-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" 
                               placeholder="Cari ahli atau spesialis hukum..." 
                               style="border-right: none;">
                        <span class="input-group-text bg-primary border-primary">
                            <i class="fa fa-search text-white"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Section End -->
        
        @if($dokters->isNotEmpty())
        <div class="row g-3" id="expertsContainer">
            @foreach($dokters as $index => $dokter)
            <div class="col-lg-4 col-md-6 col-sm-12 wow fadeInUp expert-card" data-wow-delay="{{ 0.1 + ($index % 3) * 0.1 }}s"
                 data-name="{{ strtolower($dokter->name) }}" 
                 data-specialty="{{ strtolower($dokter->keahlian ?? '') }}"
                 data-university="{{ strtolower($dokter->lulusan_universitas ?? '') }}">
                
                <!-- Clean layout without card background - tetap horizontal seperti aslinya -->
                <div class="expert-item p-3 {{ ($index + 1) % 3 != 0 ? 'border-end' : '' }}">
                    <div class="row align-items-center">
                        <!-- Photo Section - Left Side -->
                        <div class="col-auto">
                            <div class="doctor-photo-container position-relative">
                                @if($dokter->foto)
                                    <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                         alt="{{ $dokter->name }}"
                                         class="rounded doctor-photo"
                                         style="width: 85px; height: 120px; object-fit: cover; object-position: center top;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded doctor-photo" 
                                         style="background: linear-gradient(135deg, #6f42c1, #007bff); width: 85px; height: 120px;">
                                        <i class="fas fa-balance-scale text-white doctor-icon" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                                
                                <!-- Online Status Badge -->
                                <span class="position-absolute top-0 end-0 badge bg-success" 
                                      style="padding: 2px 6px; transform: translate(30%, -30%); font-size: 0.6rem;">
                                    Online
                                </span>
                            </div>
                        </div>
                        
                        <!-- Doctor Info - Right Side -->
                        <div class="col">
                            <div class="ps-2">
                                <!-- Name and Specialty -->
                                <div class="mb-1">
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">{{ $dokter->name }}</h6>
                                    <p class="text-primary fw-semibold mb-1 small" style="font-size: 0.75rem;">{{ $dokter->keahlian }}</p>
                                </div>
                                
                                <!-- Experience and University -->
                                <div class="mb-2">
                                    @if($dokter->pengalaman_tahun)
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-briefcase text-muted me-2" style="width: 10px; font-size: 0.6rem;"></i>
                                            <small class="text-muted" style="font-size: 0.65rem;">{{ $dokter->pengalaman_tahun }} tahun</small>
                                        </div>
                                    @endif
                                    @if($dokter->lulusan_universitas)
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-graduation-cap text-muted me-2" style="width: 10px; font-size: 0.6rem;"></i>
                                            <small class="text-muted" style="font-size: 0.65rem;">{{ Str::limit($dokter->lulusan_universitas, 20) }}</small>
                                        </div>
                                    @endif
                                    @if($dokter->jadwal_kerja)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-muted me-2" style="width: 10px; font-size: 0.6rem;"></i>
                                            <small class="text-muted" style="font-size: 0.65rem;">{{ $dokter->jadwal_kerja }}</small>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Price and Actions -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-success mb-0 fw-bold" style="font-size: 0.8rem;">Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</h6>
                                        <small class="text-muted" style="font-size: 0.6rem;">Per Konsultasi</small>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-1 flex-column">
                                        <a href="{{ route('pengguna.dokters.show', $dokter->id) }}" 
                                           class="btn btn-outline-success btn-sm px-2 py-1" style="font-size: 0.65rem;">
                                            Detail
                                        </a>

                                        {{-- Menggunakan method baru yang sederhana --}}
                                        <a href="{{ $dokter->getUrlTombol(auth()->id()) }}" 
                                           class="{{ $dokter->getClassTombol(auth()->id()) }}" 
                                           style="font-size: 0.65rem; padding: 4px 8px;">
                                            <i class="{{ $dokter->getIconTombol(auth()->id()) }} me-1" style="font-size: 0.55rem;"></i>
                                            {{ $dokter->getTeksTombol(auth()->id()) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Button - Moved to Bottom -->
        <div class="text-center mt-4 wow fadeInUp" data-wow-delay="0.3s">
            <a href="{{ route('pengguna.dokters.all') }}" class="btn btn-primary px-4 py-2">
                <i class="fa fa-users me-2"></i>Lihat Semua Ahli Hukum ({{ $dokters->count() }})
            </a>
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="text-center py-5" style="display: none;">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
                </div>
                <h3 class="mb-2">Tidak Ditemukan</h3>
                <p class="text-muted mb-3">Maaf, tidak ada ahli hukum yang sesuai dengan pencarian Anda. Coba gunakan kata kunci yang berbeda.</p>
            </div>
        </div>

        @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="fas fa-balance-scale text-muted" style="font-size: 3rem;"></i>
                </div>
                <h3 class="mb-2">Tidak Ada Ahli Hukum Online</h3>
                <p class="text-muted mb-3">Maaf, saat ini tidak ada ahli hukum yang sedang online. Silakan coba lagi nanti atau hubungi layanan pelanggan kami.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('pengguna.dashboard') }}" class="btn btn-primary">
                        <i class="fa fa-home me-2"></i>Kembali ke Dashboard
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fa fa-phone me-2"></i>Hubungi CS
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Legal Experts Section End -->

<style>
.doctor-photo-container {
    position: relative;
}

.expert-item {
    transition: background-color 0.3s ease;
    border-bottom: 1px solid #eee !important;
}

.expert-item.border-end {
    border-right: 1px solid #ddd !important;
}

.expert-item:hover {
    background-color: #f8f9fa;
}

.expert-item:last-child {
    border-bottom: none !important;
}

.expert-card img {
    transition: transform 0.3s ease;
}

.expert-card:hover img {
    transform: scale(1.05);
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Button specific styles */
.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

.btn-warning:hover {
    background-color: #ffca2c;
    border-color: #ffc720;
    color: #000;
}

/* Responsive adjustments for 3 columns */
@media (max-width: 992px) {
    .col-lg-4 {
        flex: 0 0 auto;
        width: 50%;
    }
    
    .doctor-photo {
        width: 90px !important;
        height: 125px !important;
    }
    
    .doctor-icon {
        font-size: 2.1rem !important;
    }
}

@media (max-width: 768px) {
    .col-lg-4 {
        flex: 0 0 auto;
        width: 100%;
    }
    
    .expert-item {
        padding: 1.5rem !important;
    }
    
    .doctor-photo {
        width: 100px !important;
        height: 140px !important;
    }
    
    .doctor-icon {
        font-size: 2.5rem !important;
    }
    
    .ps-2 {
        padding-left: 1rem !important;
    }
    
    /* Perbesar font untuk mobile */
    .expert-item h6 {
        font-size: 1.1rem !important;
    }
    
    .expert-item .text-primary {
        font-size: 0.9rem !important;
    }
    
    .expert-item .text-muted {
        font-size: 0.8rem !important;
    }
    
    .expert-item .text-success {
        font-size: 1rem !important;
    }
    
    .expert-item .btn {
        font-size: 0.8rem !important;
        padding: 8px 16px !important;
        min-width: 120px;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between > div:last-child {
        align-self: flex-end;
        width: 100%;
    }
    
    .d-flex.gap-1.flex-column {
        width: 100%;
    }
    
    .d-flex.gap-1.flex-column .btn {
        width: 100%;
        margin-bottom: 8px;
    }
}

@media (max-width: 576px) {
    .expert-item {
        padding: 1.25rem !important;
    }
    
    .doctor-photo {
        width: 95px !important;
        height: 130px !important;
    }
    
    .doctor-icon {
        font-size: 2.2rem !important;
    }
    
    /* Font untuk small mobile tetap readable */
    .expert-item h6 {
        font-size: 1rem !important;
    }
    
    .expert-item .text-primary {
        font-size: 0.85rem !important;
    }
    
    .expert-item .text-muted {
        font-size: 0.75rem !important;
    }
    
    .expert-item .btn {
        font-size: 0.75rem !important;
        padding: 6px 12px !important;
    }
}

@media (max-width: 480px) {
    .expert-item {
        padding: 1rem !important;
    }
    
    .doctor-photo {
        width: 90px !important;
        height: 125px !important;
    }
    
    .doctor-icon {
        font-size: 2rem !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const expertCards = document.querySelectorAll('.expert-card');
    const noResults = document.getElementById('noResults');
    const expertsContainer = document.getElementById('expertsContainer');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;

        expertCards.forEach(function(card) {
            const name = card.getAttribute('data-name') || '';
            const specialty = card.getAttribute('data-specialty') || '';
            const university = card.getAttribute('data-university') || '';
            
            const isMatch = name.includes(searchTerm) || 
                           specialty.includes(searchTerm) || 
                           university.includes(searchTerm);

            if (searchTerm === '' || isMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0 && searchTerm !== '') {
            noResults.style.display = 'block';
            expertsContainer.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            expertsContainer.style.display = 'flex';
        }
    });

    // Clear search functionality
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            this.dispatchEvent(new Event('input'));
        }
    });
});
</script>

@endsection