@extends('admin.layouts.app')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Pengguna: {{ $pengguna->name }}</h4>
                    <div>
                        <a href="{{ route('admin.pengguna.edit', $pengguna) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column - Profile Info -->
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                @if($pengguna->foto)
                                    <img src="{{ Storage::url($pengguna->foto) }}" 
                                         alt="Foto {{ $pengguna->name }}" 
                                         class="rounded-circle img-fluid mb-3" 
                                         style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                         style="width: 200px; height: 200px;">
                                        <i class="fas fa-user fa-5x text-white"></i>
                                    </div>
                                @endif
                                
                                <h4>{{ $pengguna->name }}</h4>
                                <p class="text-muted">{{ $pengguna->email }}</p>
                                
                                <!-- Status Badges -->
                                <div class="mb-3">
                                    @if($pengguna->email_verified_at)
                                        <span class="badge bg-success mb-1">
                                            <i class="fas fa-check"></i> Email Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge bg-warning mb-1">
                                            <i class="fas fa-clock"></i> Email Belum Verifikasi
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    @if($pengguna->email_verified_at)
                                        <form action="{{ route('admin.pengguna.unverify-email', $pengguna) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning btn-sm w-100"
                                                    onclick="return confirm('Yakin ingin membatalkan verifikasi email?')">
                                                <i class="fas fa-times"></i> Batalkan Verifikasi
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.pengguna.verify-email', $pengguna) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="fas fa-check"></i> Verifikasi Email
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Detailed Info -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Informasi Personal</h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;">Nama Lengkap:</td>
                                            <td>{{ $pengguna->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Email:</td>
                                            <td>{{ $pengguna->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">No. Telepon:</td>
                                            <td>{{ $pengguna->phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Jenis Kelamin:</td>
                                            <td>
                                                @if($pengguna->gender == 'male')
                                                    <span class="badge bg-primary">Laki-laki</span>
                                                @elseif($pengguna->gender == 'female')
                                                    <span class="badge bg-pink">Perempuan</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tanggal Lahir:</td>
                                            <td>
                                                @if($pengguna->date_of_birth)
                                                    {{ $pengguna->date_of_birth->format('d M Y') }}
                                                    <br><small class="text-muted">({{ $pengguna->date_of_birth->age }} tahun)</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Informasi Akun</h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;">Role:</td>
                                            <td><span class="badge bg-info">{{ ucfirst($pengguna->role) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Status Email:</td>
                                            <td>
                                                @if($pengguna->email_verified_at)
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                    <br><small class="text-muted">{{ $pengguna->email_verified_at->format('d M Y H:i') }}</small>
                                                @else
                                                    <span class="badge bg-warning">Belum Verifikasi</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Bergabung:</td>
                                            <td>
                                                {{ $pengguna->created_at->format('d M Y H:i') }}
                                                <br><small class="text-muted">{{ $pengguna->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Terakhir Update:</td>
                                            <td>
                                                {{ $pengguna->updated_at->format('d M Y H:i') }}
                                                <br><small class="text-muted">{{ $pengguna->updated_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Activity Statistics -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">Statistik Aktivitas</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h4 class="text-primary">{{ $pengguna->consultationsAsPatient()->count() }}</h4>
                                                    <p class="mb-0">Total Konsultasi</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h4 class="text-success">{{ $pengguna->consultationsAsPatient()->where('status', 'completed')->count() }}</h4>
                                                    <p class="mb-0">Konsultasi Selesai</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h4 class="text-warning">{{ $pengguna->consultationsAsPatient()->whereIn('status', ['pending', 'approved'])->count() }}</h4>
                                                    <p class="mb-0">Konsultasi Aktif</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Zona Berbahaya</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.</p>
                                    <form action="{{ route('admin.pengguna.destroy', $pengguna) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('PERINGATAN!\n\nAnda akan menghapus pengguna: {{ $pengguna->name }}\n\nSemua data konsultasi dan riwayat pengguna ini akan ikut terhapus dan tidak dapat dikembalikan.\n\nApakah Anda yakin ingin melanjutkan?')">
                                            <i class="fas fa-trash"></i> Hapus Pengguna Permanen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-pink {
    background-color: #e91e63 !important;
}

.table-borderless td {
    padding: 0.5rem 0;
}

.card-body h4 {
    margin-bottom: 0.5rem;
}

.img-fluid {
    border: 3px solid #dee2e6;
}
</style>
@endpush