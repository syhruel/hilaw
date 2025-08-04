@extends('admin.layouts.app')

@section('title', 'Detail Ahli Hukum')
@section('page-title', 'Detail Ahli Hukum')

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
    .info-row {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .badge-status {
        font-size: 12px;
        padding: 4px 8px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Ahli Hukum</h3>
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
                                <i class="fas fa-balance-scale fa-4x text-white"></i>
                            </div>
                        @endif
                        
                        <h4 class="mt-3">{{ $dokter->name }}</h4>
                        <p class="text-muted">{{ $dokter->keahlian ?? 'Ahli Hukum Umum' }}</p>
                        
                        <!-- Status Badges -->
                        <div class="mb-2">
                            @if($dokter->approval_status == 'approved')
                                <span class="badge badge-success badge-status">
                                    <i class="fas fa-check"></i> Disetujui
                                </span>
                            @elseif($dokter->approval_status == 'rejected')
                                <span class="badge badge-danger badge-status">
                                    <i class="fas fa-times"></i> Ditolak
                                </span>
                            @else
                                <span class="badge badge-warning badge-status">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @endif
                        </div>

                        <div class="mb-2">
                            @if($dokter->is_online)
                                <span class="badge badge-success badge-status">
                                    <i class="fas fa-circle"></i> Online
                                </span>
                            @else
                                <span class="badge badge-secondary badge-status">
                                    <i class="fas fa-circle"></i> Offline
                                </span>
                            @endif
                        </div>

                        @if($dokter->hasVerifiedEmail())
                            <span class="badge badge-info badge-status">
                                <i class="fas fa-envelope-check"></i> Email Terverifikasi
                            </span>
                        @else
                            <span class="badge badge-warning badge-status">
                                <i class="fas fa-envelope"></i> Email Belum Terverifikasi
                            </span>
                        @endif
                    </div>
                    
                    <!-- Informasi -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                    <p class="text-muted">{{ $dokter->email ?: 'Belum diisi' }}</p>
                                </div>

                                <div class="info-row">
                                    <strong><i class="fas fa-phone mr-1"></i> Nomor Telepon</strong>
                                    <p class="text-muted">
                                        @if($dokter->phone)
                                            {{ $dokter->phone }}
                                        @else
                                            <span class="text-warning">Belum diisi</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="info-row">
                                    <strong><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</strong>
                                    <p class="text-muted">
                                        @if($dokter->gender)
                                            @if($dokter->gender == 'male')
                                                <i class="fas fa-mars text-primary"></i> Laki-laki
                                            @elseif($dokter->gender == 'female')
                                                <i class="fas fa-venus text-pink"></i> Perempuan
                                            @else
                                                {{ $dokter->gender }}
                                            @endif
                                        @else
                                            <span class="text-warning">Belum diisi</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="info-row">
                                    <strong><i class="fas fa-birthday-cake mr-1"></i> Tanggal Lahir</strong>
                                    <p class="text-muted">
                                        @if($dokter->date_of_birth)
                                            {{ $dokter->date_of_birth->format('d M Y') }}
                                            <small class="text-muted">({{ $dokter->date_of_birth->age }} tahun)</small>
                                        @else
                                            <span class="text-warning">Belum diisi</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="info-row">
                                    <strong><i class="fas fa-university mr-1"></i> Lulusan Universitas</strong>
                                    <p class="text-muted">{{ $dokter->lulusan_universitas ?: 'Belum diisi' }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-row">
                                    <strong><i class="fas fa-balance-scale mr-1"></i> Bidang Keahlian Hukum</strong>
                                    <p class="text-muted">{{ $dokter->keahlian ?: 'Belum diisi' }}</p>
                                </div>

                                <div class="info-row">
                                    <strong><i class="fas fa-calendar mr-1"></i> Pengalaman</strong>
                                    <p class="text-muted">{{ $dokter->pengalaman_tahun ? $dokter->pengalaman_tahun . ' tahun' : 'Belum diisi' }}</p>
                                </div>
                                
                                <div class="info-row">
                                    <strong><i class="fas fa-money-bill-wave mr-1"></i> Tarif Konsultasi</strong>
                                    <p class="text-muted">
                                        @if($dokter->tarif_konsultasi)
                                            <strong class="text-success">
                                                Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}
                                            </strong>
                                        @else
                                            <span class="text-warning">Belum diisi</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="info-row">
                                    <strong><i class="fas fa-clock mr-1"></i> Jadwal Kerja</strong>
                                    <p class="text-muted">{{ $dokter->jadwal_kerja ?: 'Belum diisi' }}</p>
                                </div>

                                <div class="info-row">
                                    <strong><i class="fas fa-calendar-plus mr-1"></i> Bergabung</strong>
                                    <p class="text-muted">{{ $dokter->created_at->format('d M Y H:i') }}</p>
                                </div>

                                @if($dokter->last_active_at)
                                <div class="info-row">
                                    <strong><i class="fas fa-history mr-1"></i> Terakhir Aktif</strong>
                                    <p class="text-muted">{{ $dokter->last_active_at->diffForHumans() }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Kantor/Praktik</strong>
                            <p class="text-muted">{{ $dokter->alamat ?: 'Belum diisi' }}</p>
                        </div>

                        <div class="info-row">
                            <strong><i class="fas fa-file-text mr-1"></i> Deskripsi Pengalaman</strong>
                            <p class="text-muted">{{ $dokter->pengalaman_deskripsi ?: 'Belum diisi' }}</p>
                        </div>

                        @if($dokter->sertifikat)
                        <div class="info-row">
                            <strong><i class="fas fa-certificate mr-1"></i> Sertifikat/Lisensi</strong>
                            <div class="text-muted">
                                @php
                                    $ext = pathinfo($dokter->sertifikat, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/' . $dokter->sertifikat) }}" 
                                         alt="Sertifikat" style="max-width: 200px; max-height: 150px;" class="img-thumbnail mb-2">
                                    <br>
                                @endif
                                <a href="{{ asset('storage/' . $dokter->sertifikat) }}" target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Lihat Sertifikat
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="info-row">
                            <strong><i class="fas fa-certificate mr-1"></i> Sertifikat/Lisensi</strong>
                            <p class="text-muted text-warning">Belum diupload</p>
                        </div>
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
                                onclick="return confirm('Yakin ingin menyetujui ahli hukum {{ $dokter->name }}?')">
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
                            onclick="return confirm('Yakin ingin menghapus ahli hukum {{ $dokter->name }}? Data ini tidak dapat dikembalikan.')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($dokter->approval_status != 'rejected')
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dokter.reject', $dokter->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Tolak Ahli Hukum</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        Ahli hukum <strong>{{ $dokter->name }}</strong> akan ditolak.
                    </div>
                    
                    <div class="form-group">
                        <label for="rejection_reason">Alasan Penolakan *</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" 
                                  rows="4" required placeholder="Masukkan alasan penolakan yang jelas dan konstruktif..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Ahli Hukum</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection