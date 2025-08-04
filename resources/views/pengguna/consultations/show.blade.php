@extends('pengguna.layouts.app')

@section('title', 'Detail Konsultasi')
@section('page-title', 'Detail Konsultasi')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Detail Konsultasi</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.consultations.index') }}">Konsultasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informasi Konsultasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Ahli Hukum:</div>
                            <div class="col-sm-8">{{ $consultation->dokter->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Keahlian:</div>
                            <div class="col-sm-8">{{ $consultation->dokter->keahlian }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Keluhan:</div>
                            <div class="col-sm-8">{{ $consultation->keluhan }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Tarif:</div>
                            <div class="col-sm-8">
                                <span class="fw-bold text-success">Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Status:</div>
                            <div class="col-sm-8">
                                @if($consultation->status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i>Menunggu Pembayaran
                                    </span>
                                @elseif($consultation->status == 'paid')
                                    <span class="badge bg-info">
                                        <i class="fas fa-credit-card me-1"></i>Dibayar
                                    </span>
                                @elseif($consultation->status == 'approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Disetujui
                                    </span>
                                @elseif($consultation->status == 'completed')
                                    <span class="badge bg-primary">
                                        <i class="fas fa-check-double me-1"></i>Selesai
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-bold">Tanggal:</div>
                            <div class="col-sm-8">{{ $consultation->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        @if($consultation->status == 'pending')
                        <div class="d-grid">
                            <a href="{{ route('pengguna.consultations.payment', $consultation->id) }}" class="btn btn-warning">
                                <i class="fas fa-credit-card me-2"></i>Lakukan Pembayaran
                            </a>
                        </div>
                        @elseif(in_array($consultation->status, ['approved', 'completed']))
                        <div class="d-grid">
                            <a href="{{ route('pengguna.consultations.chat', $consultation->id) }}" class="btn btn-success">
                                <i class="fa fa-comments me-2"></i>Mulai Chat
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-credit-card me-2"></i>Status Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($consultation->payment)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Jumlah:</div>
                            <div class="col-sm-8">
                                <span class="fw-bold text-success">Rp {{ number_format($consultation->payment->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Metode:</div>
                            <div class="col-sm-8">{{ $consultation->payment->payment_method }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Status:</div>
                            <div class="col-sm-8">
                                @if($consultation->payment->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                @elseif($consultation->payment->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 fw-bold">Tanggal Upload:</div>
                            <div class="col-sm-8">{{ $consultation->payment->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                            <h6 class="text-muted">Belum Ada Pembayaran</h6>
                            <p class="text-muted small mb-0">Silakan lakukan pembayaran untuk melanjutkan konsultasi.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($consultation->diagnosis)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-check me-2"></i>Hasil Konsultasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Saran Hukum:</h6>
                            <p class="mb-0">{{ $consultation->diagnosis }}</p>
                        </div>
                        @if($consultation->obat_resep)
                        <div class="mb-0">
                            <h6 class="fw-bold text-primary">Tindak Lanjut:</h6>
                            <p class="mb-0">{{ $consultation->obat_resep }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pengguna.consultations.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Konsultasi Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection