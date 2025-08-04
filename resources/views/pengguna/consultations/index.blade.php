@extends('pengguna.layouts.app')

@section('title', 'Konsultasi Saya')
@section('page-title', 'Konsultasi Aktif')

@push('styles')
<style>
.consultation-item {
    transition: background-color 0.3s ease;
    border-bottom: 1px solid #eee !important;
}

.consultation-item:hover {
    background-color: #f8f9fa;
}

.consultation-item:last-child {
    border-bottom: none !important;
}

.consultation-item.border-end {
    border-right: 1px solid #ddd !important;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.4em 0.8em;
    border-radius: 20px;
}

.rejection-card {
    border-left: 4px solid #dc3545;
    background: linear-gradient(135deg, #fff5f5 0%, #ffe6e6 100%);
    margin: 10px 0;
    padding: 15px;
    border-radius: 8px;
}

.rejection-details {
    display: none;
}

.btn-action {
    font-size: 0.75rem;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
}

.alert-info-custom {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: none;
    border-left: 4px solid #2196f3;
    color: #1565c0;
}

@media (max-width: 768px) {
    .consultation-item {
        padding: 1rem !important;
    }
    
    .doctor-photo {
        width: 60px !important;
        height: 80px !important;
    }
    
    .ps-3 {
        padding-left: 0.75rem !important;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.5rem;
    }
    
    .d-flex.justify-content-between > div:last-child {
        align-self: flex-end;
    }
}
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Konsultasi Saya</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Konsultasi</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Consultations Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- Header with Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Konsultasi Aktif</h2>
                <p class="text-muted mb-0">Kelola konsultasi hukum yang sedang berlangsung</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pengguna.consultations.history') }}" class="btn btn-outline-primary">
                    <i class="fas fa-history me-1"></i> Riwayat
                </a>
                <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Konsultasi Baru
                </a>
            </div>
        </div>

        <!-- Info Alert -->
        @if($consultations->isNotEmpty())
        <div class="alert alert-info-custom d-flex align-items-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
            <i class="fas fa-info-circle me-3" style="font-size: 1.2rem;"></i>
            <div>
                <strong>Informasi:</strong> Konsultasi yang sudah selesai atau dibatalkan akan otomatis dipindahkan ke halaman 
                <a href="{{ route('pengguna.consultations.history') }}" class="text-decoration-none fw-bold">Riwayat</a>.
            </div>
        </div>
        @endif

        @if($consultations->isNotEmpty())
        <div class="row g-3">
            @foreach($consultations as $index => $consultation)
            @php
                $isRejected = $consultation->status == 'payment_rejected' || 
                             ($consultation->payment && $consultation->payment->status == 'rejected');
            @endphp
            
            <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index % 2) * 0.2 }}s">
                <!-- Consultation Card -->
                <div class="consultation-item p-3 {{ $index % 2 == 0 ? 'border-end' : '' }}">
                    <div class="row align-items-center">
                        <!-- Doctor Photo -->
                        <div class="col-auto">
                            <div class="position-relative">
                                @if($consultation->dokter->foto)
                                    <img src="{{ asset('storage/' . $consultation->dokter->foto) }}" 
                                         alt="{{ $consultation->dokter->name }}"
                                         class="rounded doctor-photo"
                                         style="width: 90px; height: 130px; object-fit: cover; object-position: center top;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded doctor-photo" 
                                         style="background: linear-gradient(135deg, #6f42c1, #007bff); width: 90px; height: 130px;">
                                        <i class="fas fa-balance-scale text-white" style="font-size: 2.2rem;"></i>
                                    </div>
                                @endif
                                
                                <!-- Status Badge on Photo -->
                                @if($consultation->status == 'approved')
                                    <span class="position-absolute top-0 end-0 badge bg-success" 
                                          style="padding: 2px 6px; transform: translate(30%, -30%); font-size: 0.6rem;">
                                        Aktif
                                    </span>
                                @elseif($consultation->status == 'paid')
                                    <span class="position-absolute top-0 end-0 badge bg-info" 
                                          style="padding: 2px 6px; transform: translate(30%, -30%); font-size: 0.6rem;">
                                        Dibayar
                                    </span>
                                @elseif($consultation->status == 'pending')
                                    <span class="position-absolute top-0 end-0 badge bg-warning" 
                                          style="padding: 2px 6px; transform: translate(30%, -30%); font-size: 0.6rem;">
                                        Pending
                                    </span>
                                @elseif($isRejected)
                                    <span class="position-absolute top-0 end-0 badge bg-danger" 
                                          style="padding: 2px 6px; transform: translate(30%, -30%); font-size: 0.6rem;">
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Consultation Info -->
                        <div class="col">
                            <div class="ps-3">
                                <!-- Doctor Name and Specialty -->
                                <div class="mb-1">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $consultation->dokter->name }}</h6>
                                    <p class="text-primary fw-semibold mb-1 small">{{ $consultation->dokter->keahlian }}</p>
                                </div>
                                
                                <!-- Consultation Details -->
                                <div class="mb-2">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-calendar text-muted me-2" style="width: 12px; font-size: 0.75rem;"></i>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $consultation->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-clock text-muted me-2" style="width: 12px; font-size: 0.75rem;"></i>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $consultation->duration_hours }} jam</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-comment-medical text-muted me-2" style="width: 12px; font-size: 0.75rem;"></i>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($consultation->keluhan, 30) }}</small>
                                    </div>
                                </div>
                                
                                <!-- Status and Price -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($consultation->status == 'pending')
                                            <span class="status-badge badge bg-warning">
                                                <i class="fas fa-clock"></i> Menunggu Pembayaran
                                            </span>
                                        @elseif($consultation->status == 'paid')
                                            <span class="status-badge badge bg-info">
                                                <i class="fas fa-credit-card"></i> Dibayar
                                            </span>
                                        @elseif($consultation->status == 'approved')
                                            <span class="status-badge badge bg-success">
                                                <i class="fas fa-check-circle"></i> Disetujui
                                            </span>
                                        @elseif($isRejected)
                                            <span class="status-badge badge bg-danger">
                                                <i class="fas fa-times-circle"></i> Ditolak
                                            </span>
                                        @endif
                                        <div class="mt-1">
                                            <small class="text-success fw-bold">Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('pengguna.consultations.show', $consultation->id) }}" 
                                           class="btn btn-outline-info btn-sm btn-action">
                                            Detail
                                        </a>

                                        @if($consultation->status == 'pending')
                                            <a href="{{ route('pengguna.consultations.payment', $consultation->id) }}" 
                                               class="btn btn-warning btn-sm btn-action">
                                                Bayar
                                            </a>
                                        @elseif($isRejected)
                                            <button class="btn btn-outline-danger btn-sm btn-action" 
                                                    onclick="toggleRejectionDetails({{ $consultation->id }})">
                                                Alasan
                                            </button>
                                            <a href="{{ route('pengguna.consultations.payment', $consultation->id) }}" 
                                               class="btn btn-warning btn-sm btn-action">
                                                Bayar Ulang
                                            </a>
                                        @elseif($consultation->status == 'approved')
                                            <a href="{{ route('pengguna.consultations.chat', $consultation->id) }}" 
                                               class="btn btn-success btn-sm btn-action">
                                                Chat
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- REJECTION DETAILS --}}
                @if($isRejected && $consultation->payment && $consultation->payment->rejection_reason)
                <div id="rejection-details-{{ $consultation->id }}" class="rejection-details mt-2">
                    <div class="rejection-card">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-times text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-danger mb-2">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Pembayaran Ditolak
                                </h6>
                                <div class="bg-white p-3 rounded border-start border-danger border-3">
                                    <strong>Alasan:</strong>
                                    <p class="mb-2 text-dark">{{ $consultation->payment->rejection_reason }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-times"></i>
                                        {{ $consultation->payment->rejected_at ? $consultation->payment->rejected_at->format('d F Y, H:i') : 'Tanggal tidak tersedia' }} WIB
                                    </small>
                                </div>
                                <div class="mt-3 text-end">
                                    <a href="{{ route('pengguna.consultations.payment', $consultation->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-upload"></i> Upload Bukti Baru
                                    </a>
                                    <button class="btn btn-sm btn-secondary" 
                                            onclick="toggleRejectionDetails({{ $consultation->id }})">
                                        <i class="fas fa-times"></i> Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $consultations->links() }}
        </div>

        @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="fas fa-comments text-muted" style="font-size: 3rem;"></i>
                </div>
                <h3 class="mb-3">Belum Ada Konsultasi Aktif</h3>
                <p class="text-muted mb-4">
                    Anda belum memiliki konsultasi yang aktif saat ini. 
                    <br>Konsultasi yang sudah selesai dapat dilihat di halaman riwayat.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Mulai Konsultasi
                    </a>
                    <a href="{{ route('pengguna.consultations.history') }}" class="btn btn-outline-primary">
                        <i class="fas fa-history me-2"></i>Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Consultations Section End -->

<script>
function toggleRejectionDetails(consultationId) {
    const detailsRow = document.getElementById('rejection-details-' + consultationId);
    if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
        detailsRow.style.display = 'block';
        detailsRow.scrollIntoView({behavior: 'smooth', block: 'center'});
    } else {
        detailsRow.style.display = 'none';
    }
}

// Auto show rejection details jika ada URL parameter
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const showRejection = urlParams.get('show_rejection');
    if (showRejection) {
        toggleRejectionDetails(showRejection);
    }
});
</script>

@endsection