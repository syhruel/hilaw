@extends('admin.layouts.app')

@section('title', 'Dashboard Dokter')
@section('page-title', 'Dashboard')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_konsultasi'] ?? 0 }}</h3>
                <p>Total Konsultasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-stethoscope"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['konsultasi_pending'] ?? 0 }}</h3>
                <p>Konsultasi Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['konsultasi_selesai'] ?? 0 }}</h3>
                <p>Konsultasi Selesai</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}</h3>
                <p>Total Pendapatan</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang, Dr. {{ auth()->user()->name }}!</h3>
    </div>
    <div class="card-body">
        <p>Selamat datang di dashboard dokter. Anda dapat mengelola konsultasi dan profil Anda dari sini.</p>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Keahlian:</strong> {{ auth()->user()->keahlian ?? 'Belum diisi' }}</p>
                        <p><strong>Pengalaman:</strong> {{ auth()->user()->pengalaman_tahun ?? 0 }} tahun</p>
                        <p><strong>Jadwal Kerja:</strong> {{ auth()->user()->jadwal_kerja ?? 'Belum diatur' }}</p>
                        <p><strong>Tarif Konsultasi:</strong> Rp {{ number_format(auth()->user()->tarif_konsultasi ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-calendar-alt"></i> Lihat Jadwal Konsultasi
                        </a>
                        <a href="#" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-user-edit"></i> Edit Profil
                        </a>
                        <a href="#" class="btn btn-info btn-block">
                            <i class="fas fa-history"></i> Riwayat Konsultasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection