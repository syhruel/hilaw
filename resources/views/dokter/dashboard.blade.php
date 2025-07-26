@extends('dokter.layouts.app')

@section('title', 'Dokter Dashboard')
@section('page-title', 'Dashboard Dokter')

@section('content')
<!-- Notifikasi Persetujuan Akun -->
@if($showApprovalNotification)
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <strong>Selamat!</strong> Akun Anda sudah disetujui oleh admin. Anda sekarang dapat menerima konsultasi dari pasien.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Cards Row -->
<div class="row">
    <!-- Total Konsultasi Card -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title text-primary mb-1">
                            {{ auth()->user()->consultationsAsDoctor()->count() }}
                        </h5>
                        <p class="card-text text-muted mb-0">Total Konsultasi</p>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-stethoscope text-primary fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Konsultasi Hari Ini Card -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title text-success mb-1">
                            {{ auth()->user()->consultationsAsDoctor()->whereDate('created_at', today())->count() }}
                        </h5>
                        <p class="card-text text-muted mb-0">Konsultasi Hari Ini</p>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day text-success fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Card -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card border-0 shadow h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="card-title {{ auth()->user()->is_online ? 'text-success' : 'text-secondary' }} mb-1">
                            {{ auth()->user()->is_online ? 'Online' : 'Offline' }}
                        </h5>
                        <p class="card-text text-muted mb-2">Status Anda</p>
                        <small class="text-muted">
                            Tarif Konsultasi: <strong>Rp {{ number_format(auth()->user()->tarif_konsultasi, 0, ',', '.') }} / jam</strong>
                        </small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-circle {{ auth()->user()->is_online ? 'text-success' : 'text-secondary' }} fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title mb-3">
                            Selamat Datang, Dr. {{ auth()->user()->name }}!
                        </h4>
                    </div>
                    <div>
                        <form action="{{ route('dokter.toggle-online') }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn {{ auth()->user()->is_online ? 'btn-outline-secondary' : 'btn-success' }}">
                                <i class="fas fa-power-off me-2"></i>
                                {{ auth()->user()->is_online ? 'Set Offline' : 'Set Online' }}
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="alert {{ auth()->user()->is_online ? 'alert-success' : 'alert-secondary' }} mb-3" role="alert">
                    <h6 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>
                        Ini adalah dashboard dokter untuk mengelola konsultasi dan pembayaran.
                    </h6>
                    <hr>
                    <p class="mb-2">
                        Status Anda saat ini: <strong>{{ auth()->user()->is_online ? 'Online' : 'Offline' }}</strong>
                    </p>
                    @if(auth()->user()->is_online)
                        <p class="mb-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Anda sedang online dan dapat menerima konsultasi dari pasien.
                        </p>
                    @else
                        <p class="mb-0">
                            <i class="fas fa-eye-slash text-secondary me-2"></i>
                            Anda sedang offline. Pasien tidak dapat melihat profil Anda.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
