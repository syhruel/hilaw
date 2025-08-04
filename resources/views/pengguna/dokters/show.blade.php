@extends('pengguna.layouts.app')

@section('title', 'Detail Ahli Hukum - ' . $dokter->name)
@section('page-title', 'Detail Ahli Hukum')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Detail Ahli Hukum</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dokters.index') }}">Ahli Hukum</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $dokter->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Lawyer Detail Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="text-center mb-4">
                        @if($dokter->foto)
                            <img class="img-fluid rounded" src="{{ asset('storage/' . $dokter->foto) }}" alt="{{ $dokter->name }}" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded mx-auto" style="background: linear-gradient(135deg, #6f42c1, #007bff); width: 200px; height: 200px;">
                                <i class="fas fa-balance-scale text-white" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-center">
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
                        
                        <div class="mb-4 p-3 bg-primary text-white rounded">
                            <h5 class="text-white mb-0">Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</h5>
                            <small>Per Konsultasi</small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            @php
                                $konsul = $dokter->konsultasiAktifDengan(auth()->id())->first();
                            @endphp

                            @if ($konsul && is_null($konsul->chat_ended_at))
                                <a href="{{ route('pengguna.consultations.chat', $konsul->id) }}" class="btn btn-success">
                                    <i class="fa fa-comments me-1"></i>Lanjutkan Chat
                                </a>
                            @else
                                <a href="{{ route('pengguna.consultations.create', $dokter->id) }}" class="btn btn-primary">
                                    <i class="fa fa-comments me-1"></i>Konsultasi
                                </a>
                            @endif
                            
                            <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="col-lg-8">
                <!-- Main Information -->
                <div class="bg-light rounded p-5 mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <h4 class="mb-4">
                        <i class="fas fa-user-tie text-primary me-2"></i>Informasi Lengkap
                    </h4>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="200"><strong>Nama Lengkap:</strong></td>
                                    <td>{{ $dokter->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Spesialisasi:</strong></td>
                                    <td><span class="badge bg-primary">{{ $dokter->keahlian }}</span></td>
                                </tr>
                                @if($dokter->pengalaman_tahun)
                                <tr>
                                    <td><strong>Pengalaman:</strong></td>
                                    <td>{{ $dokter->pengalaman_tahun }} tahun</td>
                                </tr>
                                @endif
                                @if($dokter->lulusan_universitas)
                                <tr>
                                    <td><strong>Pendidikan:</strong></td>
                                    <td>{{ $dokter->lulusan_universitas }}</td>
                                </tr>
                                @endif
                                @if($dokter->nomor_izin_praktik)
                                <tr>
                                    <td><strong>No. Izin Praktik:</strong></td>
                                    <td>{{ $dokter->nomor_izin_praktik }}</td>
                                </tr>
                                @endif
                                @if($dokter->jadwal_kerja)
                                <tr>
                                    <td><strong>Jadwal Kerja:</strong></td>
                                    <td>
                                        <i class="fas fa-clock text-muted me-1"></i>
                                        {{ $dokter->jadwal_kerja }}
                                    </td>
                                </tr>
                                @endif
                                @if($dokter->alamat)
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td>{{ $dokter->alamat }}</td>
                                </tr>
                                @endif
                                @if($dokter->no_telepon)
                                <tr>
                                    <td><strong>No. Telepon:</strong></td>
                                    <td>{{ $dokter->no_telepon }}</td>
                                </tr>
                                @endif
                                @if($dokter->email)
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $dokter->email }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Tarif Konsultasi:</strong></td>
                                    <td class="fw-bold text-success">Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                            Online
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($dokter->deskripsi)
                <!-- Professional Profile -->
                <div class="bg-light rounded p-5 mb-4 wow fadeInUp" data-wow-delay="0.3s">
                    <h4 class="mb-4">
                        <i class="fas fa-info-circle text-primary me-2"></i>Profil Profesional
                    </h4>
                    <p class="text-justify">{{ $dokter->deskripsi }}</p>
                </div>
                @endif

                <!-- Quick Features -->
                <div class="bg-light rounded p-5 wow fadeInUp" data-wow-delay="0.4s">
                    <h4 class="mb-4">
                        <i class="fas fa-star text-primary me-2"></i>Keunggulan Layanan
                    </h4>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shield-alt text-success fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-1">Terverifikasi</h6>
                                    <small class="text-muted">Ahli hukum tersertifikasi</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-comments text-primary fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-1">Konsultasi Online</h6>
                                    <small class="text-muted">Chat langsung tersedia</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-info fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-1">Respons Cepat</h6>
                                    <small class="text-muted">Rata-rata 5 menit</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star text-warning fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-1">Rating Tinggi</h6>
                                    <small class="text-muted">4.8/5.0 dari klien</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Lawyer Detail Section End -->

@endsection