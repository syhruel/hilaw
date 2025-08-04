@extends('pengguna.layouts.app')

@section('title', 'Konsultasi Baru - ' . $dokter->name)
@section('page-title', 'Konsultasi Baru')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Konsultasi Baru</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dokters.index') }}">Ahli Hukum</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dokters.show', $dokter->id) }}">{{ $dokter->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Konsultasi</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Consultation Form Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Form Section -->
            <div class="col-lg-8">
                <div class="bg-light rounded p-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h4 class="mb-4">
                        <i class="fas fa-comments text-primary me-2"></i>Form Konsultasi
                    </h4>
                    
                    <form action="{{ route('pengguna.consultations.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="keluhan" class="form-label fw-bold">Keluhan / Masalah Hukum <span class="text-danger">*</span></label>
                            <textarea name="keluhan" id="keluhan" class="form-control" rows="5" 
                                      placeholder="Jelaskan secara detail masalah hukum yang ingin Anda konsultasikan..." 
                                      required>{{ old('keluhan') }}</textarea>
                            <small class="text-muted">Semakin detail penjelasan Anda, semakin tepat saran yang akan diberikan.</small>
                        </div>

                        <div class="mb-4">
                            <label for="durasi" class="form-label fw-bold">Durasi Konsultasi (Jam) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="durasi" id="durasi" class="form-control" 
                                       min="1" max="8" step="0.5" 
                                       placeholder="Masukkan durasi dalam jam (contoh: 1, 1.5, 2)" 
                                       value="{{ old('durasi') }}" required>
                                <span class="input-group-text">Jam</span>
                            </div>
                            <small class="text-muted">
                                Biaya per jam: Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }} 
                                | Minimum 1 jam, maksimum 8 jam (dapat menggunakan 0.5 jam untuk setengah jam)
                            </small>
                            <div id="total-biaya" class="mt-2"></div>
                        </div>

                        <input type="hidden" name="dokter_id" value="{{ $dokter->id }}">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <button type="submit" class="btn btn-primary btn-lg me-md-2">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Konsultasi
                            </button>
                            <a href="{{ route('pengguna.dokters.show', $dokter->id) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Doctor Info Section -->
            <div class="col-lg-4">
                <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.2s">
                    <h4 class="mb-4">
                        <i class="fas fa-user-tie text-primary me-2"></i>Ahli Hukum
                    </h4>
                    
                    <div class="text-center mb-4">
                        @if($dokter->foto)
                            <img class="img-fluid rounded" src="{{ asset('storage/' . $dokter->foto) }}" alt="{{ $dokter->name }}" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded mx-auto" style="background: linear-gradient(135deg, #6f42c1, #007bff); width: 150px; height: 150px;">
                                <i class="fas fa-balance-scale text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="text-center mb-4">
                        <h5 class="mb-2">{{ $dokter->name }}</h5>
                        <p class="text-primary fw-bold mb-2">{{ $dokter->keahlian }}</p>
                        @if($dokter->lulusan_universitas)
                            <small class="text-muted d-block mb-2">{{ $dokter->lulusan_universitas }}</small>
                        @endif
                        @if($dokter->pengalaman_tahun)
                            <small class="text-muted d-block">{{ $dokter->pengalaman_tahun }} tahun pengalaman</small>
                        @endif
                        
                        <div class="mt-3">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                Online
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-3 bg-primary text-white rounded text-center mb-4">
                        <h5 class="text-white mb-0">Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</h5>
                        <small>Per Jam Konsultasi</small>
                    </div>
                    
                    @if($dokter->jadwal_kerja)
                    <div class="mb-3">
                        <h6 class="text-primary">
                            <i class="fas fa-clock me-2"></i>Jadwal Kerja
                        </h6>
                        <p class="mb-0 text-muted">{{ $dokter->jadwal_kerja }}</p>
                    </div>
                    @endif
                </div>
                
                <!-- Consultation Info -->
                <div class="bg-light rounded p-4 mt-4 wow fadeInUp" data-wow-delay="0.3s">
                    <h5 class="mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>Informasi Konsultasi
                    </h5>
                    
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small class="text-muted">Konsultasi dilakukan melalui chat online</small>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small class="text-muted">Pembayaran dilakukan setelah konsultasi disetujui</small>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small class="text-muted">Respons rata-rata dalam 5 menit</small>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                        <small class="text-muted">Konsultasi dapat diperpanjang jika diperlukan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Consultation Form Section End -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tarifPerJam = {{ $dokter->tarif_konsultasi }};
    const inputDurasi = document.getElementById('durasi');
    const totalBiaya = document.getElementById('total-biaya');

    // Function to calculate and display total cost
    function calculateTotal() {
        const jam = parseFloat(inputDurasi.value);
        if (!isNaN(jam) && jam > 0) {
            const total = tarifPerJam * jam;
            totalBiaya.innerHTML = `<div class="alert alert-info p-2 mb-0"><strong>Total Biaya: Rp ${total.toLocaleString('id-ID')}</strong></div>`;
        } else {
            totalBiaya.innerHTML = '';
        }
    }

    // Event listeners for real-time calculation
    inputDurasi.addEventListener('input', calculateTotal);
    inputDurasi.addEventListener('change', calculateTotal);

    // Validation to ensure minimum and maximum values
    inputDurasi.addEventListener('blur', function() {
        const value = parseFloat(this.value);
        if (value < 1) {
            this.value = 1;
            calculateTotal();
        } else if (value > 8) {
            this.value = 8;
            calculateTotal();
        }
    });

    // Initial calculation if there's a pre-filled value
    if (inputDurasi.value) {
        calculateTotal();
    }
});
</script>

@endsection