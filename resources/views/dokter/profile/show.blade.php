@extends('dokter.layouts.app')

@section('title', 'Profil Dokter')
@section('page-title', 'Profil Dokter')

@section('content')
<!-- Profile Header -->
<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($dokter->foto)
                        <img src="{{ Storage::url($dokter->foto) }}" 
                             alt="Foto {{ $dokter->name }}" 
                             class="profile-user-img img-fluid"
                             style="width: 150px; height: 200px; object-fit: cover;">
                    @else
                        <div class="profile-user-img img-fluid d-flex align-items-center justify-content-center bg-light" 
                             style="width: 150px; height: 200px;">
                            <i class="fas fa-user-md fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>

                <h3 class="profile-username text-center">{{ $dokter->name }}</h3>
                <p class="text-muted text-center">{{ $dokter->keahlian }}</p>

                <!-- Status Badges -->
                <div class="text-center mb-3">
                    @if($dokter->is_approved && $dokter->approval_status === 'approved')
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> Terverifikasi
                        </span>
                    @elseif($dokter->approval_status === 'rejected')
                        <span class="badge badge-danger">
                            <i class="fas fa-times-circle"></i> Ditolak
                        </span>
                    @else
                        <span class="badge badge-warning">
                            <i class="fas fa-clock"></i> Menunggu Verifikasi
                        </span>
                    @endif

                    @if($dokter->is_online)
                        <span class="badge badge-success ml-1">
                            <i class="fas fa-circle"></i> Online
                        </span>
                    @else
                        <span class="badge badge-secondary ml-1">
                            <i class="fas fa-circle"></i> Offline
                        </span>
                    @endif
                </div>

                <a href="{{ route('dokter.profile.edit') }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>

        <!-- Sertifikat Card -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-certificate"></i> Sertifikat</h3>
            </div>
            <div class="card-body">
                @if($dokter->sertifikat)
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-pdf text-danger fa-2x mr-3"></i>
                        <div>
                            <a href="{{ Storage::url($dokter->sertifikat) }}" 
                               target="_blank" 
                               class="text-decoration-none">
                                <i class="fas fa-external-link-alt"></i> Lihat Sertifikat
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="fas fa-file-upload fa-2x mb-2"></i>
                        <p>Belum ada sertifikat</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('error') }}
            </div>
        @endif

        @if($certificateStatus)
            <div class="alert alert-{{ $certificateStatus['type'] }} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas {{ $certificateStatus['type'] === 'success' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                {{ $certificateStatus['message'] }}
                <br><small>{{ $certificateStatus['date']->format('d/m/Y H:i') }}</small>
            </div>
        @endif

        <!-- Pending Changes -->
        @php
            $pendingChanges = $dokter->profileChanges()->where('status', 'pending')->latest()->get();
        @endphp

        @if($pendingChanges->count() > 0)
            <div class="alert alert-warning">
                <h6><i class="fas fa-clock"></i> Pengajuan Perubahan Menunggu Persetujuan</h6>
                @foreach($pendingChanges as $change)
                    @php
                        $changes = $change->changes;
                    @endphp
                    <small>Diajukan: {{ $change->created_at->format('d/m/Y H:i') }}</small>
                    @if(isset($changes['sertifikat']))
                        <p class="mb-1">
                            <strong>{{ $changes['sertifikat'] === null ? 'Penghapusan' : 'Upload' }} Sertifikat:</strong> 
                            Menunggu persetujuan admin
                        </p>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Main Profile Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user"></i> Informasi Profil</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">{{ $dokter->email }}</p>
                        <hr>
                        <strong><i class="fas fa-graduation-cap mr-1"></i> Lulusan</strong>
                        <p class="text-muted">{{ $dokter->lulusan_universitas }}</p>
                        <hr>
                        <strong><i class="fas fa-money-bill-wave mr-1"></i> Tarif Konsultasi</strong>
                        <p class="text-muted">Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-calendar mr-1"></i> Pengalaman</strong>
                        <p class="text-muted">
                            {{ $dokter->pengalaman_tahun ? $dokter->pengalaman_tahun . ' tahun' : '-' }}
                        </p>
                        <hr>
                        <strong><i class="fas fa-clock mr-1"></i> Jadwal Kerja</strong>
                        <p class="text-muted">{{ $dokter->jadwal_kerja ?: 'Belum diatur' }}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted">{{ $dokter->alamat }}</p>
                    </div>
                </div>

                @if($dokter->pengalaman_deskripsi)
                    <hr>
                    <strong><i class="fas fa-info-circle mr-1"></i> Deskripsi Pengalaman</strong>
                    <p class="text-muted">{{ $dokter->pengalaman_deskripsi }}</p>
                @endif
            </div>
        </div>

        <!-- Rejection Reason -->
        @if($dokter->approval_status === 'rejected' && $dokter->rejection_reason)
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Alasan Penolakan</h3>
                </div>
                <div class="card-body">
                    <p>{{ $dokter->rejection_reason }}</p>
                </div>
            </div>
        @endif

        <!-- Account Info -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Akun</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Bergabung Sejak:</strong>
                        <p class="text-muted">{{ $dokter->created_at->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Terakhir Diperbarui:</strong>
                        <p class="text-muted">{{ $dokter->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <a href="{{ route('dokter.dashboard') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<style>
.profile-user-img {
    border: 3px solid #adb5bd;
    margin: 0 auto;
    padding: 3px;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.badge {
    font-size: 75%;
}
</style>
@endsection