@extends('pengguna.layouts.app')

@section('title', 'Daftar Dokter')
@section('page-title', 'Dokter Online')

@section('content')
<style>
    .doctor-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background: white;
        overflow: hidden;
    }

    .doctor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .doctor-photo {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #f8f9fa;
    }

    .doctor-placeholder {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6c5ce7, #a29bfe);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #f8f9fa;
    }

    .doctor-name {
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 0.3rem;
    }

    .doctor-specialty {
        color: #636e72;
        font-size: 0.9rem;
        margin-bottom: 0.8rem;
    }

    .online-badge {
        background: #00b894;
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .online-dot {
        width: 6px;
        height: 6px;
        background: white;
        border-radius: 50%;
    }

    .price-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.8rem;
        margin: 1rem 0;
        text-align: center;
    }

    .price-text {
        color: #00b894;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
    }

    .btn-outline-primary {
        border-color: #6c5ce7;
        color: #6c5ce7;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #6c5ce7;
        border-color: #6c5ce7;
        color: white;
    }

    .btn-primary {
        background: #00b894;
        border-color: #00b894;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #00a085;
        border-color: #00a085;
    }

    .empty-state {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        border: 2px dashed #ddd;
    }

    .empty-icon {
        color: #b2bec3;
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-title {
        color: #2d3436;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #636e72;
        margin: 0;
    }
</style>

<div class="row">
    @foreach($dokters as $dokter)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card doctor-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                        @if($dokter->foto)
                            <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                 class="doctor-photo">
                        @else
                            <div class="doctor-placeholder">
                                <i class="fas fa-user-md text-white"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-grow-1">
                        <h6 class="doctor-name">Dr. {{ $dokter->name }}</h6>
                        <p class="doctor-specialty">{{ $dokter->keahlian }}</p>
                        
                        <div class="mb-3">
                            <span class="online-badge">
                                <span class="online-dot"></span>
                                Online
                            </span>
                        </div>
                        
                        <div class="price-container">
                            <div class="price-text">
                                Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('pengguna.dokters.show', $dokter->id) }}" 
                               class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i> Profil
                            </a>

                            @php
                                $konsul = $dokter->konsultasi_aktif;
                            @endphp

                            @if ($konsul && is_null($konsul->chat_ended_at))
                                <a href="{{ route('pengguna.consultations.chat', $konsul->id) }}" 
                                class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-comments me-1"></i> Lanjutkan Chat
                                </a>
                            @else
                                <a href="{{ route('pengguna.consultations.create', $dokter->id) }}" 
                                class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-comments me-1"></i> Chat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($dokters->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-user-md"></i>
        </div>
        <h5 class="empty-title">Tidak ada dokter yang online</h5>
        <p class="empty-text">Silakan coba lagi nanti atau hubungi layanan pelanggan</p>
    </div>
@endif
@endsection