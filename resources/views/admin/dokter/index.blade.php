@extends('admin.layouts.app')

@section('title', 'Kelola Ahli')
@section('page-title', 'Kelola Ahli')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Ahli</h3>
        <div class="card-tools">
            <a href="{{ route('dokter.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Ahli
            </a>
        </div>
    </div>
    
    <div class="card-body">
        @php
            $pendingCount = $dokters->filter(function($dokter) {
                return isset($dokter->approval_status) 
                    ? ($dokter->approval_status == 'pending' || $dokter->approval_status == null)
                    : !$dokter->is_approved;
            })->count();
            
            $profileChangesCount = App\Models\ProfileChange::where('status', 'pending')->count();
        @endphp
        
        <ul class="nav nav-tabs" id="dokterTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="approved-tab" data-toggle="tab" href="#approved" role="tab">
                    <i class="fas fa-check text-success"></i> Disetujui
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab">
                    <i class="fas fa-times text-danger"></i> Ditolak
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab">
                    <i class="fas fa-clock text-warning"></i> Pending
                    @if($pendingCount > 0)
                        <span class="badge badge-warning ml-1">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-changes-tab" data-toggle="tab" href="#profile-changes" role="tab">
                    <i class="fas fa-edit text-info"></i> Ubah Profil
                    @if($profileChangesCount > 0)
                        <span class="badge badge-info ml-1">{{ $profileChangesCount }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="dokterTabContent">
            <div class="tab-pane fade show active" id="approved" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Foto</th>
                                <th width="20%">Nama</th>
                                <th width="20%">Email</th>
                                <th>Online</th>
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $approvedDokters = $dokters->filter(function($dokter) {
                                    return isset($dokter->approval_status) 
                                        ? $dokter->approval_status == 'approved'
                                        : $dokter->is_approved;
                                });
                            @endphp
                            
                            @foreach($approvedDokters as $key => $dokter)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($dokter->foto)
                                        <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                             alt="Foto" class="img-circle" width="40" height="40">
                                    @else
                                        <i class="fas fa-user-circle fa-2x text-muted"></i>
                                    @endif
                                </td>
                                <td>{{ $dokter->name }}</td>
                                <td>{{ $dokter->email }}</td>
                                <td>
                                    @if($dokter->is_online)
                                        <span class="badge badge-success">
                                            <i class="fas fa-circle"></i> Online
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-circle"></i> Offline
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dokter.show', $dokter->id) }}" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.dokter.toggle-online', $dokter->id) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $dokter->is_online ? 'btn-secondary' : 'btn-success' }}" 
                                                    title="{{ $dokter->is_online ? 'Set Offline' : 'Set Online' }}">
                                                <i class="fas fa-power-off"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('dokter.destroy', $dokter->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Yakin ingin menghapus dokter {{ $dokter->name }}?')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($approvedDokters->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada ahli yang disetujui</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="rejected" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Foto</th>
                                <th width="20%">Nama</th>
                                <th width="20%">Email</th>
                                <th>Alasan Ditolak</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rejectedDokters = $dokters->filter(function($dokter) {
                                    return isset($dokter->approval_status) && $dokter->approval_status == 'rejected';
                                });
                            @endphp
                            
                            @foreach($rejectedDokters as $key => $dokter)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($dokter->foto)
                                        <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                             alt="Foto" class="img-circle" width="40" height="40">
                                    @else
                                        <i class="fas fa-user-circle fa-2x text-muted"></i>
                                    @endif
                                </td>
                                <td>{{ $dokter->name }}</td>
                                <td>{{ $dokter->email }}</td>
                                <td>
                                    @if($dokter->rejection_reason)
                                        <small class="text-danger">{{ $dokter->rejection_reason }}</small>
                                    @else
                                        <small class="text-muted">Tidak ada alasan</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dokter.show', $dokter->id) }}" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('dokter.destroy', $dokter->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Yakin ingin menghapus dokter {{ $dokter->name }}?')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($rejectedDokters->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-user-times fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada ahli yang ditolak</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pending" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Foto</th>
                                <th width="20%">Nama</th>
                                <th width="20%">Email</th>
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pendingDokters = $dokters->filter(function($dokter) {
                                    return isset($dokter->approval_status) 
                                        ? ($dokter->approval_status == 'pending' || $dokter->approval_status == null)
                                        : !$dokter->is_approved;
                                });
                            @endphp
                            
                            @foreach($pendingDokters as $key => $dokter)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($dokter->foto)
                                        <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                             alt="Foto" class="img-circle" width="40" height="40">
                                    @else
                                        <i class="fas fa-user-circle fa-2x text-muted"></i>
                                    @endif
                                </td>
                                <td>{{ $dokter->name }}</td>
                                <td>{{ $dokter->email }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dokter.show', $dokter->id) }}" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('dokter.destroy', $dokter->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Yakin ingin menghapus dokter {{ $dokter->name }}?')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($pendingDokters->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada ahli yang menunggu persetujuan</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="profile-changes" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Dokter</th>
                                <th width="25%">Perubahan</th>
                                <th width="15%">Tanggal</th>
                                <th width="40%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $profileChanges = App\Models\ProfileChange::with('user')->where('status', 'pending')->latest()->get();
                            @endphp
                            
                            @foreach($profileChanges as $key => $change)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($change->user->foto)
                                            <img src="{{ asset('storage/' . $change->user->foto) }}" 
                                                 alt="Foto" class="img-circle mr-2" width="30" height="30">
                                        @else
                                            <i class="fas fa-user-circle fa-lg text-muted mr-2"></i>
                                        @endif
                                        <div>
                                            <strong>{{ $change->user->name }}</strong><br>
                                            <small class="text-muted">{{ $change->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small>
                                        @php 
                                            $changeCount = 0; 
                                            $changesData = is_string($change->changes) ? json_decode($change->changes, true) : $change->changes;
                                            if (!is_array($changesData)) {
                                                $changesData = [];
                                            }
                                        @endphp
                                        @foreach($changesData as $field => $value)
                                            @if($changeCount < 2)
                                                @if(in_array($field, ['foto', 'sertifikat']))
                                                    <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong> <span class="text-info">Diperbarui</span><br>
                                                @else
                                                    <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong> {{ Str::limit($value, 20) }}<br>
                                                @endif
                                                @php $changeCount++; @endphp
                                            @endif
                                        @endforeach
                                        @if(count($changesData) > 2)
                                            <small class="text-muted">dan {{ count($changesData) - 2 }} lainnya...</small>
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        {{ $change->created_at->format('d/m/Y') }}<br>
                                        <span class="text-muted">{{ $change->created_at->format('H:i') }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="mb-2">
                                        <button class="btn btn-info btn-sm btn-block" type="button" data-toggle="collapse" 
                                                data-target="#detail-{{ $change->id }}" aria-expanded="false">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </button>
                                    </div>
                                    
                                    <div class="collapse" id="detail-{{ $change->id }}">
                                        <div class="card card-body mb-2" style="font-size: 12px;">
                                            <h6 class="font-weight-bold mb-2">Detail Perubahan:</h6>
                                            @foreach($changesData as $field => $newValue)
                                                @php
                                                    $oldData = is_string($change->old_data) ? json_decode($change->old_data, true) : $change->old_data;
                                                    if (!is_array($oldData)) {
                                                        $oldData = [];
                                                    }
                                                    $oldValue = $oldData[$field] ?? 'Tidak ada data lama';
                                                @endphp
                                                
                                                <div class="mb-2">
                                                    <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong><br>
                                                    
                                                    @if(in_array($field, ['foto', 'sertifikat']))
                                                        <!-- Untuk file -->
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <span class="text-muted">Lama:</span><br>
                                                                @if($oldValue && $oldValue != 'Tidak ada data lama')
                                                                    @if($field == 'foto')
                                                                        <img src="{{ asset('storage/' . $oldValue) }}" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                                                    @else
                                                                        <a href="{{ asset('storage/' . $oldValue) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                                            <i class="fas fa-file"></i> Lihat File
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted">Tidak ada</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-6">
                                                                <span class="text-success">Baru:</span><br>
                                                                @if($field == 'foto')
                                                                    <img src="{{ asset('storage/' . $newValue) }}" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                                                @else
                                                                    <a href="{{ asset('storage/' . $newValue) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                                        <i class="fas fa-file"></i> Lihat File
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Lama:</span> {{ $oldValue }}<br>
                                                        <span class="text-success">Baru:</span> {{ $newValue }}
                                                    @endif
                                                </div>
                                                <hr style="margin: 5px 0;">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="btn-group btn-group-sm d-flex">
                                        <form method="POST" action="{{ route('admin.dokter.approve-profile-change', $change->id) }}" class="flex-fill">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100" 
                                                    onclick="return confirm('Yakin ingin menyetujui perubahan profil ini?')" title="Setujui">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.dokter.reject-profile-change', $change->id) }}" class="flex-fill ml-1">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm w-100" 
                                                    data-toggle="collapse" data-target="#reject-form-{{ $change->id }}" title="Tolak">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="collapse mt-2" id="reject-form-{{ $change->id }}">
                                        <form method="POST" action="{{ route('admin.dokter.reject-profile-change', $change->id) }}">
                                            @csrf
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Alasan Penolakan:</label>
                                                <textarea name="rejection_reason" class="form-control form-control-sm" rows="3" required 
                                                          placeholder="Masukkan alasan mengapa perubahan ini ditolak..."></textarea>
                                            </div>
                                            <div class="btn-group btn-group-sm w-100">
                                                <button type="button" class="btn btn-secondary" 
                                                        data-toggle="collapse" data-target="#reject-form-{{ $change->id }}">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-times"></i> Tolak Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($profileChanges->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-edit fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada pengajuan perubahan profil</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
/* Simple CSS untuk tampilan yang rapi */
.img-thumbnail {
    max-width: 100px;
    max-height: 100px;
}

.btn-group-sm .btn {
    font-size: 11px;
    padding: 4px 8px;
}

.card-body {
    font-size: 13px;
}

.collapse {
    transition: none; /* Menghilangkan animasi untuk kesederhanaan */
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 10px;
}
</style>
@endsection