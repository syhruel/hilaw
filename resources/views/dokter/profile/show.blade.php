
@extends('dokter.layouts.app')

@section('title', 'Profil Dokter')
@section('page-title', 'Profil Dokter')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Profil</h3>
                <div class="card-tools">
                    <a href="{{ route('dokter.profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nama Dokter</strong></label>
                            <p class="form-control-plaintext">{{ $dokter->name }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Email</strong></label>
                            <p class="form-control-plaintext">{{ $dokter->email }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Keahlian</strong></label>
                            <p class="form-control-plaintext">{{ $dokter->keahlian }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Lulusan Universitas</strong></label>
                            <p class="form-control-plaintext">{{ $dokter->lulusan_universitas }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><strong>Pengalaman</strong></label>
                    <p class="form-control-plaintext">{{ $dokter->pengalaman }}</p>
                </div>
                
                <div class="form-group">
                    <label><strong>Alamat</strong></label>
                    <p class="form-control-plaintext">{{ $dokter->alamat }}</p>
                </div>
                
                <div class="form-group">
                    <label><strong>Status Persetujuan</strong></label>
                    <p class="form-control-plaintext">
                        @if($dokter->is_approved)
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i> Disetujui
                            </span>
                        @else
                            <span class="badge badge-warning">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="card-footer">
                <a href="{{ route('dokter.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
                <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Foto Profil</h4>
            </div>
            <div class="card-body text-center">
                @if($dokter->foto)
                    <img src="{{ asset('storage/' . $dokter->foto) }}" 
                         alt="{{ $dokter->name }}" 
                         class="img-fluid rounded-circle mb-3"
                         style="width: 200px; height: 200px; object-fit: cover;">
                    <p class="text-muted">{{ $dokter->name }}</p>
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 200px; height: 200px;">
                        <i class="fas fa-user-md fa-4x text-white"></i>
                    </div>
                    <p class="text-muted">Belum ada foto profil</p>
                    <small class="text-info">
                        <i class="fas fa-info-circle"></i> 
                        Klik edit profil untuk menambahkan foto
                    </small>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Informasi Akun</h4>
            </div>
            <div class="card-body">
                <div class="info-item mb-2">
                    <strong>Tanggal Bergabung:</strong><br>
                    <small class="text-muted">{{ $dokter->created_at->format('d F Y, H:i') }}</small>
                </div>
                
                <div class="info-item mb-2">
                    <strong>Terakhir Diupdate:</strong><br>
                    <small class="text-muted">{{ $dokter->updated_at->format('d F Y, H:i') }}</small>
                </div>
                
                <div class="info-item mb-2">
                    <strong>Role:</strong><br>
                    <span class="badge badge-primary">{{ ucfirst($dokter->role) }}</span>
                </div>
                
                <div class="info-item">
                    <strong>Status Akun:</strong><br>
                    @if($dokter->is_approved)
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> Aktif
                        </span>
                    @else
                        <span class="badge badge-warning">
                            <i class="fas fa-clock"></i> Menunggu Persetujuan
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        @if(!$dokter->is_approved)
        <div class="card mt-3">
            <div class="card-header bg-warning">
                <h4 class="card-title text-white">
                    <i class="fas fa-exclamation-triangle"></i> Perhatian
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Akun Anda masih dalam tahap review oleh admin. 
                    Beberapa fitur mungkin belum tersedia hingga akun disetujui.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection