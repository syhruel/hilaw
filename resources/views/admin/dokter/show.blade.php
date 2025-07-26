@extends('admin.layouts.app')

@section('title', 'Detail Dokter')
@section('page-title', 'Detail Dokter')

@push('styles')
<style>
    .doctor-photo {
        width: 180px;
        height: 240px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .doctor-photo-placeholder {
        width: 180px;
        height: 240px;
        background: #6c757d;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Dokter</h3>
                <div class="card-tools">
                    <a href="{{ route('dokter.index') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Foto Profil -->
                    <div class="col-md-3 text-center">
                        @if($dokter->foto)
                            <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                 alt="{{ $dokter->name }}" 
                                 class="doctor-photo">
                        @else
                            <div class="doctor-photo-placeholder">
                                <i class="fas fa-user-md fa-4x text-white"></i>
                            </div>
                        @endif
                        
                        <h4 class="mt-3">{{ $dokter->name }}</h4>
                        <p class="text-muted">{{ $dokter->keahlian ?? 'Dokter Umum' }}</p>
                        
                        @if($dokter->approval_status == 'approved')
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i> Disetujui
                            </span>
                        @elseif($dokter->approval_status == 'rejected')
                            <span class="badge badge-danger">
                                <i class="fas fa-times"></i> Ditolak
                            </span>
                        @else
                            <span class="badge badge-warning">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @endif
                    </div>
                    
                    <!-- Informasi -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                <p class="text-muted">{{ $dokter->email }}</p>
                                
                                <strong><i class="fas fa-university mr-1"></i> Lulusan</strong>
                                <p class="text-muted">{{ $dokter->lulusan_universitas ?? '-' }}</p>
                                
                                <strong><i class="fas fa-calendar mr-1"></i> Pengalaman</strong>
                                <p class="text-muted">{{ $dokter->pengalaman_tahun ?? 0 }} tahun</p>
                                
                                <strong><i class="fas fa-money-bill mr-1"></i> Tarif</strong>
                                <p class="text-muted">Rp {{ number_format($dokter->tarif_konsultasi ?? 0, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="col-md-6">
                                <strong><i class="fas fa-clock mr-1"></i> Jadwal</strong>
                                <p class="text-muted">{{ $dokter->jadwal_kerja ?? '-' }}</p>
                                
                                <strong><i class="fas fa-circle mr-1"></i> Status</strong>
                                <p class="text-muted">
                                    @if($dokter->is_online)
                                        <span class="badge badge-success">Online</span>
                                    @else
                                        <span class="badge badge-secondary">Offline</span>
                                    @endif
                                </p>
                                
                                <strong><i class="fas fa-calendar-plus mr-1"></i> Bergabung</strong>
                                <p class="text-muted">{{ $dokter->created_at->format('d M Y') }}</p>
                                
                                @if($dokter->sertifikat)
                                <strong><i class="fas fa-certificate mr-1"></i> Sertifikat</strong>
                                <p class="text-muted">
                                    <a href="{{ asset('storage/' . $dokter->sertifikat) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </p>
                                @endif
                            </div>
                        </div>
                        
                        @if($dokter->pengalaman_deskripsi)
                        <strong><i class="fas fa-file-text mr-1"></i> Deskripsi Pengalaman</strong>
                        <p class="text-muted">{{ $dokter->pengalaman_deskripsi }}</p>
                        @endif
                        
                        @if($dokter->alamat)
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted">{{ $dokter->alamat }}</p>
                        @endif
                        
                        @if($dokter->approval_status == 'rejected' && $dokter->rejection_reason)
                        <div class="alert alert-danger mt-3">
                            <h5><i class="fas fa-exclamation-triangle"></i> Alasan Penolakan</h5>
                            {{ $dokter->rejection_reason }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                @if($dokter->approval_status != 'approved')
                    <form action="{{ route('dokter.approve', $dokter->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success" 
                                onclick="return confirm('Yakin ingin menyetujui dokter {{ $dokter->name }}?')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>
                @endif
                
                @if($dokter->approval_status != 'rejected')
                    <button type="button" class="btn btn-danger ml-2" 
                            data-toggle="modal" data-target="#rejectModal">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                @endif
                
                @if($dokter->approval_status == 'approved')
                    <form action="{{ route('admin.dokter.toggle-online', $dokter->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $dokter->is_online ? 'btn-secondary' : 'btn-info' }} ml-2">
                            <i class="fas fa-power-off"></i> 
                            {{ $dokter->is_online ? 'Set Offline' : 'Set Online' }}
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-primary ml-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                
                <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger ml-2" 
                            onclick="return confirm('Yakin ingin menghapus dokter {{ $dokter->name }}?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($dokter->approval_status == 'approved')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $dokter->konsultasi_count ?? 0 }}</h3>
                <p>Total Konsultasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $dokter->pasien_count ?? 0 }}</h3>
                <p>Pasien</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $dokter->rating ?? '0.0' }}</h3>
                <p>Rating</p>
            </div>
            <div class="icon">
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $dokter->response_time ?? '-' }}</h3>
                <p>Respon (mnt)</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
</div>
@endif

@if($dokter->approval_status != 'rejected')
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dokter.reject', $dokter->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Tolak Dokter</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        Dokter <strong>{{ $dokter->name }}</strong> akan ditolak.
                    </div>
                    
                    <div class="form-group">
                        <label for="rejection_reason">Alasan Penolakan *</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" 
                                  rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection