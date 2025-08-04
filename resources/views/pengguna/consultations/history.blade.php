@extends('pengguna.layouts.app')

@section('title', 'Riwayat Konsultasi')
@section('page-title', 'Riwayat Konsultasi')

@push('styles')
<style>
.history-item {
    transition: background-color 0.3s ease;
    border-bottom: 1px solid #eee !important;
}

.history-item:hover {
    background-color: #f8f9fa;
}

.history-item:last-child {
    border-bottom: none !important;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.4em 0.8em;
    border-radius: 20px;
}

.btn-action {
    font-size: 0.75rem;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
}

.filter-tabs {
    border-bottom: 2px solid #f8f9fa;
}

.filter-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 1rem 1.5rem;
    position: relative;
}

.filter-tabs .nav-link.active {
    background: none;
    color: #007bff;
}

.filter-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background-color: #007bff;
}

.search-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
}

@media (max-width: 768px) {
    .history-item {
        padding: 1rem !important;
    }
    
    .doctor-photo {
        width: 60px !important;
        height: 80px !important;
    }
    
    .ps-3 {
        padding-left: 0.75rem !important;
    }
}
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Riwayat Konsultasi</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.consultations.index') }}">Konsultasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- History Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- Header with Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Riwayat Konsultasi</h2>
                <p class="text-muted mb-0">Semua riwayat konsultasi hukum Anda</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pengguna.consultations.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Konsultasi Baru
                </a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <h5 class="mb-3"><i class="fas fa-search me-2"></i>Cari Riwayat Konsultasi</h5>
            <form method="GET" action="{{ route('pengguna.consultations.history') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Nama ahli, keahlian, atau keluhan..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_from" class="form-control" 
                               placeholder="Dari tanggal" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_to" class="form-control" 
                               placeholder="Sampai tanggal" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('pengguna.consultations.history') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Search Results Info -->
        @if(request()->hasAny(['search', 'date_from', 'date_to']))
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Filter Aktif:</strong>
            @if(request('search'))
                Pencarian: "{{ request('search') }}"
            @endif
            @if(request('date_from') || request('date_to'))
                @if(request('search')) | @endif
                Tanggal: 
                {{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d M Y') : 'Awal' }}
                - 
                {{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d M Y') : 'Sekarang' }}
            @endif
        </div>
        @endif

        <!-- Filter Tabs -->
        <div class="mb-4">
            <ul class="nav nav-tabs filter-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#all-history" role="tab">
                        <i class="fas fa-list me-1"></i> Semua ({{ $allConsultations->total() }})
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#completed-history" role="tab">
                        <i class="fas fa-check-circle me-1"></i> Selesai ({{ $completedConsultations->total() }})
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#cancelled-history" role="tab">
                        <i class="fas fa-times-circle me-1"></i> Dibatalkan ({{ $cancelledConsultations->total() }})
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- All History Tab -->
            <div class="tab-pane fade show active" id="all-history" role="tabpanel">
                @if($allConsultations->count() > 0)
                <div class="row g-3">
                    @foreach($allConsultations as $consultation)
                    <div class="col-12">
                        <div class="history-item p-3">
                            <div class="row align-items-center">
                                <!-- Doctor Photo -->
                                <div class="col-auto">
                                    <div class="position-relative">
                                        @if($consultation->dokter->foto)
                                            <img src="{{ asset('storage/' . $consultation->dokter->foto) }}" 
                                                 alt="{{ $consultation->dokter->name }}"
                                                 class="rounded doctor-photo"
                                                 style="width: 70px; height: 90px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center rounded doctor-photo" 
                                                 style="background: linear-gradient(135deg, #6f42c1, #007bff); width: 70px; height: 90px;">
                                                <i class="fas fa-balance-scale text-white" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Consultation Info -->
                                <div class="col">
                                    <div class="ps-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 class="fw-bold mb-1">{{ $consultation->dokter->name }}</h6>
                                                <p class="text-primary mb-1 small">{{ $consultation->dokter->keahlian }}</p>
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ $consultation->created_at->format('d M Y, H:i') }}
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-comment-medical me-1"></i>
                                                        {{ Str::limit($consultation->keluhan, 50) }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <!-- Status -->
                                                @if($consultation->status == 'completed')
                                                    <span class="status-badge badge bg-success mb-2">
                                                        <i class="fas fa-check-double"></i> Selesai
                                                    </span>
                                                @elseif($consultation->status == 'cancelled')
                                                    <span class="status-badge badge bg-secondary mb-2">
                                                        <i class="fas fa-ban"></i> Dibatalkan
                                                    </span>
                                                @elseif($consultation->status == 'approved')
                                                    <span class="status-badge badge bg-primary mb-2">
                                                        <i class="fas fa-check-circle"></i> Disetujui
                                                    </span>
                                                @elseif($consultation->status == 'payment_rejected')
                                                    <span class="status-badge badge bg-danger mb-2">
                                                        <i class="fas fa-times-circle"></i> Ditolak
                                                    </span>
                                                @elseif($consultation->status == 'pending')
                                                    <span class="status-badge badge bg-warning mb-2">
                                                        <i class="fas fa-clock"></i> Pending
                                                    </span>
                                                @elseif($consultation->status == 'paid')
                                                    <span class="status-badge badge bg-info mb-2">
                                                        <i class="fas fa-credit-card"></i> Dibayar
                                                    </span>
                                                @endif
                                                
                                                <!-- Price -->
                                                <div class="mb-2">
                                                    <span class="text-success fw-bold">Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</span>
                                                </div>
                                                
                                                <!-- Actions -->
                                                <div class="d-flex gap-1 justify-content-md-end">
                                                    <a href="{{ route('pengguna.consultations.show', $consultation->id) }}" 
                                                       class="btn btn-outline-info btn-sm btn-action">
                                                        Detail
                                                    </a>
                                                    @if(in_array($consultation->status, ['completed', 'approved']))
                                                        <a href="{{ route('pengguna.consultations.chat', $consultation->id) }}" 
                                                           class="btn btn-outline-primary btn-sm btn-action">
                                                            Chat
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $allConsultations->appends(request()->query())->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5>Tidak Ada Data</h5>
                    @if(request()->hasAny(['search', 'date_from', 'date_to']))
                        <p class="text-muted">Tidak ditemukan riwayat konsultasi yang sesuai dengan pencarian Anda.</p>
                        <a href="{{ route('pengguna.consultations.history') }}" class="btn btn-outline-primary">
                            Reset Pencarian
                        </a>
                    @else
                        <p class="text-muted">Anda belum memiliki riwayat konsultasi.</p>
                    @endif
                </div>
                @endif
            </div>

            <!-- Completed History Tab -->
            <div class="tab-pane fade" id="completed-history" role="tabpanel">
                @if($completedConsultations->count() > 0)
                <div class="row g-3">
                    @foreach($completedConsultations as $consultation)
                    <div class="col-12">
                        <div class="history-item p-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="position-relative">
                                        @if($consultation->dokter->foto)
                                            <img src="{{ asset('storage/' . $consultation->dokter->foto) }}" 
                                                 class="rounded doctor-photo" style="width: 70px; height: 90px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center rounded doctor-photo" 
                                                 style="background: linear-gradient(135deg, #6f42c1, #007bff); width: 70px; height: 90px;">
                                                <i class="fas fa-balance-scale text-white" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                        <span class="position-absolute top-0 end-0 badge bg-success" 
                                              style="padding: 2px 6px; transform: translate(30%, -30%); font-size: 0.6rem;">
                                            Selesai
                                        </span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="ps-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 class="fw-bold mb-1">{{ $consultation->dokter->name }}</h6>
                                                <p class="text-primary mb-1 small">{{ $consultation->dokter->keahlian }}</p>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $consultation->created_at->format('d M Y') }} - {{ $consultation->updated_at->format('d M Y') }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-comment-medical me-1"></i>
                                                    {{ Str::limit($consultation->keluhan, 40) }}
                                                </small>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <div class="mb-2">
                                                    <span class="text-success fw-bold">Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex gap-1 justify-content-md-end">
                                                    <a href="{{ route('pengguna.consultations.show', $consultation->id) }}" 
                                                       class="btn btn-outline-info btn-sm btn-action">Detail</a>
                                                    <a href="{{ route('pengguna.consultations.chat', $consultation->id) }}" 
                                                       class="btn btn-outline-primary btn-sm btn-action">Chat</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $completedConsultations->appends(request()->query())->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                    <h5>Belum Ada Konsultasi Selesai</h5>
                    <p class="text-muted">Anda belum memiliki konsultasi yang selesai.</p>
                </div>
                @endif
            </div>

            <!-- Cancelled History Tab -->
            <div class="tab-pane fade" id="cancelled-history" role="tabpanel">
                @if($cancelledConsultations->count() > 0)
                <div class="row g-3">
                    @foreach($cancelledConsultations as $consultation)
                    <div class="col-12">
                        <div class="history-item p-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="position-relative">
                                        @if($consultation->dokter->foto)
                                            <img src="{{ asset('storage/' . $consultation->dokter->foto) }}" 
                                                 class="rounded doctor-photo" style="width: 70px; height: 90px; object-fit: cover; filter: grayscale(50%);">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center rounded doctor-photo" 
                                                 style="background: linear-gradient(135deg, #6c757d, #495057); width: 70px; height: 90px;">
                                                <i class="fas fa-balance-scale text-white" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                        <span class="position-absolute top-0 end-0 badge bg-secondary" 
                                              style="padding: 2px 6px; transform: translate(30%, -30%); font-size: 0.6rem;">
                                            Batal
                                        </span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="ps-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 class="fw-bold mb-1 text-muted">{{ $consultation->dokter->name }}</h6>
                                                <p class="text-secondary mb-1 small">{{ $consultation->dokter->keahlian }}</p>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Dibatalkan: {{ $consultation->updated_at->format('d M Y, H:i') }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-comment-medical me-1"></i>
                                                    {{ Str::limit($consultation->keluhan, 40) }}
                                                </small>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <div class="mb-2">
                                                    <span class="text-muted fw-bold">Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex gap-1 justify-content-md-end">
                                                    <a href="{{ route('pengguna.consultations.show', $consultation->id) }}" 
                                                       class="btn btn-outline-secondary btn-sm btn-action">Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $cancelledConsultations->appends(request()->query())->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-ban fa-3x text-muted mb-3"></i>
                    <h5>Tidak Ada Konsultasi Dibatalkan</h5>
                    <p class="text-muted">Anda tidak memiliki konsultasi yang dibatalkan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- History Section End -->

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.filter-tabs .nav-link');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs and panes
            tabLinks.forEach(l => l.classList.remove('active'));
            tabPanes.forEach(p => {
                p.classList.remove('show', 'active');
            });
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show corresponding pane
            const targetId = this.getAttribute('href').substring(1);
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });

    // Set max date for date inputs (today)
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.setAttribute('max', today);
    });
});
</script>

@endsection