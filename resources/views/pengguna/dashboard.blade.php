@extends('pengguna.layouts.app')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-tachometer-alt"></i> Dashboard</h5>
            </div>
            <div class="card-body">
                <h4>Selamat Datang, {{ auth()->user()->name }}!</h4>
                <p>Ini adalah dashboard pengguna untuk mengakses layanan rumah sakit.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-calendar-check"></i> Jadwal Konsultasi</h5>
                                <p>Lihat jadwal konsultasi dengan dokter</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5><i class="fas fa-user-md"></i> Daftar Dokter</h5>
                                <p>Lihat daftar dokter yang tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informasi</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Status:</strong> <span class="badge badge-success">Aktif</span></p>
            </div>
        </div>
    </div>
</div>
@endsection