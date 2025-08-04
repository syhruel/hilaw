@extends('pengguna.layouts.app')

@section('title', 'Semua Ahli Hukum')
@section('page-title', 'Semua Ahli Hukum Online')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Semua Ahli Hukum</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dokters.index') }}">Ahli Hukum</a></li>
                <li class="breadcrumb-item active" aria-current="page">Semua Ahli Hukum</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Filter Section Start -->
<div class="container-xxl py-4">
    <div class="container">
        <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-3">
                <!-- Search by Name -->
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold">Cari Nama Ahli</label>
                    <div class="input-group">
                        <input type="text" id="searchName" class="form-control" placeholder="Masukkan nama ahli hukum...">
                        <span class="input-group-text">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                </div>
                
                <!-- Filter by Specialty -->
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold">Spesialis Ahli</label>
                    <select id="filterSpecialty" class="form-select">
                        <option value="">Semua Spesialis</option>
                        @foreach($specialties as $specialty)
                        <option value="{{ strtolower($specialty) }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filter by Working Days -->
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold">Hari Kerja</label>
                    <select id="filterWorkingDay" class="form-select">
                        <option value="">Semua Hari</option>
                        <option value="senin">Senin</option>
                        <option value="selasa">Selasa</option>
                        <option value="rabu">Rabu</option>
                        <option value="kamis">Kamis</option>
                        <option value="jumat">Jumat</option>
                        <option value="sabtu">Sabtu</option>
                        <option value="minggu">Minggu</option>
                    </select>
                </div>
                
                <!-- Clear Filters -->
                <div class="col-12 text-center">
                    <button id="clearFilters" class="btn btn-outline-secondary">
                        <i class="fa fa-refresh me-2"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Filter Section End -->

<!-- Results Info -->
<div class="container-xxl py-2">
    <div class="container">
        <div class="text-center">
            <p class="text-muted" id="resultsInfo">Menampilkan <span id="totalResults">{{ $dokters->count() }}</span> ahli hukum online</p>
        </div>
    </div>
</div>

<!-- Legal Experts Section Start -->
<div class="container-xxl py-3">
    <div class="container">
        <div class="row g-4" id="expertsContainer">
            @foreach($dokters as $index => $dokter)
            <div class="col-lg-4 col-md-6 wow fadeInUp expert-card" data-wow-delay="{{ 0.1 + ($index % 3) * 0.1 }}s"
                 data-name="{{ strtolower($dokter->name) }}" 
                 data-specialty="{{ strtolower($dokter->keahlian) }}"
                 data-university="{{ strtolower($dokter->lulusan_universitas ?? '') }}"
                 data-working-days="{{ strtolower($dokter->jadwal_kerja ?? '') }}">
                <div class="service-item rounded d-flex h-100">
                    <div class="service-img rounded">
                        @if($dokter->foto)
                            <img class="img-fluid" src="{{ asset('storage/' . $dokter->foto) }}" alt="{{ $dokter->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, #6f42c1, #007bff); min-height: 250px;">
                                <i class="fas fa-balance-scale text-white" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="service-text rounded p-5">
                        <div class="btn-square rounded-circle mx-auto mb-3">
                            <i class="fas fa-gavel text-white"></i>
                        </div>
                        <h4 class="mb-3">{{ $dokter->name }}</h4>
                        <p class="mb-4">
                            <strong class="text-primary">{{ $dokter->keahlian }}</strong><br>
                            @if($dokter->lulusan_universitas)
                                <small class="text-muted">{{ $dokter->lulusan_universitas }}</small><br>
                            @endif
                            @if($dokter->pengalaman_tahun)
                                <small class="text-muted">{{ $dokter->pengalaman_tahun }} tahun pengalaman</small>
                            @endif
                        </p>
                        
                        <div class="mb-3">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                Online
                            </span>
                        </div>
                        
                        @if($dokter->jadwal_kerja)
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $dokter->jadwal_kerja }}
                            </small>
                        </div>
                        @endif
                        
                        <div class="mb-4 p-3 bg-light rounded text-center">
                            <h5 class="text-success mb-0">Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</h5>
                            <small class="text-muted">Per Konsultasi</small>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('pengguna.dokters.show', $dokter->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-eye me-1"></i>Profil
                            </a>

                            @php
                                $konsul = $dokter->konsultasi_aktif;
                            @endphp

                            @if ($konsul && is_null($konsul->chat_ended_at))
                                <a href="{{ route('pengguna.consultations.chat', $konsul->id) }}" class="btn btn-success btn-sm flex-fill">
                                    <i class="fa fa-comments me-1"></i>Lanjutkan Chat
                                </a>
                            @else
                                <a href="{{ route('pengguna.consultations.create', $dokter->id) }}" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fa fa-comments me-1"></i>Konsultasi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="text-center py-5" style="display: none;">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
                </div>
                <h3 class="mb-3">Tidak Ditemukan</h3>
                <p class="text-muted mb-4">Maaf, tidak ada ahli hukum yang sesuai dengan filter pencarian Anda. Coba ubah kriteria pencarian.</p>
                <button id="resetFromNoResults" class="btn btn-primary">
                    <i class="fa fa-refresh me-2"></i>Reset Semua Filter
                </button>
            </div>
        </div>

        <!-- Empty State -->
        @if($dokters->isEmpty())
        <div class="text-center py-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="fas fa-balance-scale text-muted" style="font-size: 3rem;"></i>
                </div>
                <h3 class="mb-3">Tidak Ada Ahli Hukum Online</h3>
                <p class="text-muted mb-4">Maaf, saat ini tidak ada ahli hukum yang sedang online. Silakan coba lagi nanti atau hubungi layanan pelanggan kami.</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchName = document.getElementById('searchName');
    const filterSpecialty = document.getElementById('filterSpecialty');
    const filterWorkingDay = document.getElementById('filterWorkingDay');
    const clearFilters = document.getElementById('clearFilters');
    const resetFromNoResults = document.getElementById('resetFromNoResults');
    const expertCards = document.querySelectorAll('.expert-card');
    const noResults = document.getElementById('noResults');
    const expertsContainer = document.getElementById('expertsContainer');
    const totalResults = document.getElementById('totalResults');
    const resultsInfo = document.getElementById('resultsInfo');

    function filterExperts() {
        const nameSearch = searchName.value.toLowerCase().trim();
        const specialtyFilter = filterSpecialty.value.toLowerCase();
        const workingDayFilter = filterWorkingDay.value.toLowerCase();
        let visibleCount = 0;

        expertCards.forEach(function(card) {
            const name = card.getAttribute('data-name');
            const specialty = card.getAttribute('data-specialty');
            const university = card.getAttribute('data-university');
            const workingDays = card.getAttribute('data-working-days');
            
            // Check name match
            const nameMatch = nameSearch === '' || name.includes(nameSearch) || university.includes(nameSearch);
            
            // Check specialty match
            const specialtyMatch = specialtyFilter === '' || specialty.includes(specialtyFilter);
            
            // Check working day match
            const workingDayMatch = workingDayFilter === '' || workingDays.includes(workingDayFilter);

            if (nameMatch && specialtyMatch && workingDayMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update results info
        totalResults.textContent = visibleCount;
        
        if (visibleCount === 0) {
            resultsInfo.textContent = 'Tidak ditemukan ahli hukum yang sesuai';
        } else {
            resultsInfo.textContent = `Menampilkan ${visibleCount} ahli hukum online`;
        }

        // Show/hide no results message
        if (visibleCount === 0 && (nameSearch !== '' || specialtyFilter !== '' || workingDayFilter !== '')) {
            noResults.style.display = 'block';
            expertsContainer.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            expertsContainer.style.display = 'flex';
        }
    }

    // Event listeners
    searchName.addEventListener('input', filterExperts);
    filterSpecialty.addEventListener('change', filterExperts);
    filterWorkingDay.addEventListener('change', filterExperts);

    // Clear all filters
    function clearAllFilters() {
        searchName.value = '';
        filterSpecialty.value = '';
        filterWorkingDay.value = '';
        filterExperts();
    }

    clearFilters.addEventListener('click', clearAllFilters);
    if (resetFromNoResults) {
        resetFromNoResults.addEventListener('click', clearAllFilters);
    }

    // Escape key to clear name search
    searchName.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            filterExperts();
        }
    });
});
</script>

@endsection