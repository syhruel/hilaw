@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header" style="background-color: #4a5a4a; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

<!-- Header Section -->
<div class="mb-5">
    <div class="bg-white rounded-3 shadow-sm p-5" style="border-left: 6px solid #4a5a4a;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #4a5a4a;">
                            <i class="fas fa-balance-scale text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-2" style="color: #4a5a4a;">HiLaw Admin Dashboard</h1>
                        <p class="text-muted mb-0 fs-5">Sistem Manajemen Platform Konsultasi Hukum</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Grid -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="bg-white rounded-3 shadow-sm p-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2 fw-bold" style="color: #4a5a4a;">{{ $stats['total_dokter'] }}</div>
                    <div class="text-muted">Advokat Terdaftar</div>
                </div>
                <div class="rounded-3 p-3" style="background-color: rgba(74, 90, 74, 0.1);">
                    <i class="fas fa-balance-scale fs-2" style="color: #4a5a4a;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="bg-white rounded-3 shadow-sm p-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2 fw-bold" style="color: #4a5a4a;">{{ $stats['total_pengguna'] }}</div>
                    <div class="text-muted">Klien Aktif</div>
                </div>
                <div class="rounded-3 p-3" style="background-color: rgba(74, 90, 74, 0.1);">
                    <i class="fas fa-users fs-2" style="color: #4a5a4a;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="bg-white rounded-3 shadow-sm p-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2 fw-bold" style="color: #4a5a4a;">{{ $stats['total_konsultasi'] }}</div>
                    <div class="text-muted">Total Konsultasi</div>
                </div>
                <div class="rounded-3 p-3" style="background-color: rgba(74, 90, 74, 0.1);">
                    <i class="fas fa-gavel fs-2" style="color: #4a5a4a;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="bg-white rounded-3 shadow-sm p-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fs-2 fw-bold" style="color: #4a5a4a;">Rp {{ number_format($stats['total_pembayaran'], 0, ',', '.') }}</div>
                    <div class="text-muted">Total Pendapatan</div>
                </div>
                <div class="rounded-3 p-3" style="background-color: rgba(74, 90, 74, 0.1);">
                    <i class="fas fa-money-bill-wave fs-2" style="color: #4a5a4a;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection