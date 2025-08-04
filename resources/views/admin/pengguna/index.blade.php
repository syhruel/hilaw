@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header" style="background-color: #4a5a4a; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

<!-- Breadcrumb -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" style="color: #4a5a4a; text-decoration: none;">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" style="color: #4a5a4a;">Kelola Pengguna</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.pengguna.create') }}" class="btn btn-sm px-4 py-2 fw-semibold" style="background-color: #4a5a4a; color: white; border: none;">
        <i class="fas fa-plus me-2"></i>Tambah Pengguna
    </a>
</div>

<!-- Header Section -->
<div class="mb-4">
    <div class="bg-white rounded-3 shadow-sm p-4" style="border-left: 6px solid #4a5a4a;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #4a5a4a;">
                            <i class="fas fa-users text-white" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #4a5a4a;">Kelola Pengguna</h4>
                        <p class="text-muted mb-0">Manajemen data pengguna platform HiLaw</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Form -->
<div class="bg-white rounded-3 shadow-sm p-4 mb-4">
    <form method="GET" action="{{ route('admin.pengguna.index') }}" id="filterForm">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" 
                       class="form-control" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama atau email..."
                       style="border-color: #dee2e6;">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="verified" style="border-color: #dee2e6;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Belum Verifikasi</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="suspended" style="border-color: #dee2e6;" onchange="this.form.submit()">
                    <option value="">Semua Akun</option>
                    <option value="0" {{ request('suspended') == '0' ? 'selected' : '' }}>Aktif</option>
                    <option value="1" {{ request('suspended') == '1' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="active" style="border-color: #dee2e6;" onchange="this.form.submit()">
                    <option value="">Semua Online</option>
                    <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Online</option>
                    <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Offline</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn px-3" style="background-color: #4a5a4a; color: white; border: none;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-secondary px-3">
                        <i class="fas fa-sync"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Table Section -->
<div class="bg-white rounded-3 shadow-sm">
    <div class="p-4 border-bottom">
        <h5 class="mb-0 fw-bold" style="color: #4a5a4a;">Data Pengguna ({{ $pengguna->total() }} pengguna)</h5>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size: 0.85rem;">
            <thead style="background-color: #4a5a4a; color: white;">
                <tr>
                    <th class="py-2 px-3" width="50">No</th>
                    <th class="py-2 px-3" width="70">Foto</th>
                    <th class="py-2 px-3">Nama & Info</th>
                    <th class="py-2 px-3">Email</th>
                    <th class="py-2 px-3" width="120">Telepon</th>
                    <th class="py-2 px-3" width="80">Status</th>
                    <th class="py-2 px-3" width="100">Aktivitas</th>
                    <th class="py-2 px-3" width="100">Bergabung</th>
                    <th class="py-2 px-3" width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengguna as $index => $user)
                    <tr class="{{ $user->is_suspended ? 'bg-warning bg-opacity-10' : '' }}">
                        <td class="py-2 px-3">{{ $pengguna->firstItem() + $index }}</td>
                        <td class="py-2 px-3">
                            @if($user->foto)
                                <img src="{{ Storage::url($user->foto) }}" 
                                     alt="Foto {{ $user->name }}" 
                                     class="rounded" 
                                     width="35" height="35"
                                     style="object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                                     style="width: 35px; height: 35px;">
                                    <i class="fas fa-user text-white" style="font-size: 0.7rem;"></i>
                                </div>
                            @endif
                        </td>
                        <td class="py-2 px-3">
                            <div class="fw-semibold mb-1" style="color: #4a5a4a; font-size: 0.9rem;">{{ $user->name }}</div>
                            @if($user->date_of_birth)
                                <small class="text-muted d-block">{{ \Carbon\Carbon::parse($user->date_of_birth)->age }} tahun</small>
                            @endif
                            @if($user->gender)
                                @if($user->gender == 'male')
                                    <span class="badge bg-primary" style="font-size: 0.65rem;">Laki-laki</span>
                                @else
                                    <span class="badge" style="background-color: #e91e63; font-size: 0.65rem;">Perempuan</span>
                                @endif
                            @endif
                        </td>
                        <td class="py-2 px-3">
                            <div style="font-size: 0.8rem;">{{ $user->email }}</div>
                            @if($user->email_verified_at)
                                <span class="badge bg-success" style="font-size: 0.65rem;">
                                    <i class="fas fa-check"></i> Terverifikasi
                                </span>
                            @else
                                <span class="badge bg-warning" style="font-size: 0.65rem;">
                                    <i class="fas fa-clock"></i> Belum Verifikasi
                                </span>
                            @endif
                        </td>
                        <td class="py-2 px-3">{{ $user->phone ?? '-' }}</td>
                        <td class="py-2 px-3">
                            @if($user->is_suspended)
                                <span class="badge bg-danger" style="font-size: 0.65rem;">
                                    <i class="fas fa-ban"></i> Suspended
                                </span>
                            @else
                                <span class="badge bg-success" style="font-size: 0.65rem;">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            @endif
                        </td>
                        <td class="py-2 px-3">
                            @if($user->isCurrentlyActive())
                                <span class="badge bg-success" style="font-size: 0.65rem;">
                                    <i class="fas fa-circle"></i> Online
                                </span>
                                <small class="text-muted d-block">Aktif sekarang</small>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.65rem;">
                                    <i class="fas fa-circle"></i> Offline
                                </span>
                                @if($user->last_active_at)
                                    <small class="text-muted d-block">{{ $user->last_active_at->diffForHumans() }}</small>
                                @else
                                    <small class="text-muted d-block">Belum pernah aktif</small>
                                @endif
                            @endif
                        </td>
                        <td class="py-2 px-3">
                            <div style="font-size: 0.8rem;">{{ $user->created_at->format('d M Y') }}</div>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                        <td class="py-2 px-3">
                            <div class="d-flex flex-wrap gap-1">
                                <!-- View Button -->
                                <a href="{{ route('admin.pengguna.show', $user) }}" 
                                   class="btn btn-outline-info btn-sm" 
                                   style="padding: 0.2rem 0.4rem; font-size: 0.7rem;"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('admin.pengguna.edit', $user) }}" 
                                   class="btn btn-outline-warning btn-sm" 
                                   style="padding: 0.2rem 0.4rem; font-size: 0.7rem;"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Email Verification Toggle -->
                                @if($user->email_verified_at)
                                    <form action="{{ route('admin.pengguna.unverify-email', $user) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Yakin ingin membatalkan verifikasi email?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-outline-warning btn-sm" 
                                                style="padding: 0.2rem 0.4rem; font-size: 0.7rem;"
                                                title="Batalkan Verifikasi">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.pengguna.verify-email', $user) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-outline-success btn-sm" 
                                                style="padding: 0.2rem 0.4rem; font-size: 0.7rem;"
                                                title="Verifikasi Email">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Suspend/Unsuspend Toggle -->
                                @if($user->is_suspended)
                                    <form action="{{ route('admin.pengguna.unsuspend', $user) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Yakin ingin mengaktifkan kembali pengguna ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-outline-success btn-sm" 
                                                style="padding: 0.2rem 0.4rem; font-size: 0.7rem;"
                                                title="Aktifkan Kembali">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.pengguna.suspend', $user) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Yakin ingin mensuspend pengguna ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm" 
                                                style="padding: 0.2rem 0.4rem; font-size: 0.7rem;"
                                                title="Suspend">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Delete Button -->
                                <form action="{{ route('admin.pengguna.destroy', $user) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini? Data yang terhapus tidak dapat dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm" 
                                            style="padding: 0.2rem 0.4rem; font-size: 0.7rem;"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                     style="width: 80px; height: 80px; background-color: rgba(74, 90, 74, 0.1);">
                                    <i class="fas fa-users fa-2x" style="color: #4a5a4a;"></i>
                                </div>
                                <h5 class="text-muted mb-2">Belum ada data pengguna</h5>
                                <p class="text-muted mb-3">Mulai dengan menambah pengguna baru</p>
                                <a href="{{ route('admin.pengguna.create') }}" class="btn px-4" style="background-color: #4a5a4a; color: white; border: none;">
                                    <i class="fas fa-plus me-2"></i>Tambah Pengguna
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pengguna->hasPages())
        <div class="d-flex justify-content-between align-items-center p-4 border-top">
            <div>
                <p class="text-muted mb-0">
                    Menampilkan {{ $pengguna->firstItem() }} - {{ $pengguna->lastItem() }} 
                    dari {{ $pengguna->total() }} hasil
                </p>
            </div>
            <div>
                {{ $pengguna->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh untuk update status online
    setInterval(function() {
        if (window.location.search.includes('active=1')) {
            window.location.reload();
        }
    }, 30000);
    
    // Auto-hide toast
    setTimeout(function() {
        var toasts = document.querySelectorAll('.toast');
        toasts.forEach(function(toast) {
            var bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        });
    }, 5000);
});
</script>
@endpush