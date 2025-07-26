{{-- resources/views/admin/dokter/partials/profile-change-detail.blade.php --}}
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Informasi Dokter</h5>
            </div>
            <div class="card-body text-center">
                @if($change->user->foto)
                    <img src="{{ asset('storage/' . $change->user->foto) }}" 
                         alt="Foto Dokter" class="img-circle mb-3" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <i class="fas fa-user-circle fa-5x text-muted mb-3"></i>
                @endif
                <h5>{{ $change->user->name }}</h5>
                <p class="text-muted">{{ $change->user->email }}</p>
                <small class="text-info">{{ $change->user->keahlian ?? 'Belum diisi' }}</small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-info-circle"></i> Info Pengajuan</h6>
            </div>
            <div class="card-body">
                <p><strong>Tanggal:</strong><br>{{ $change->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Status:</strong><br>
                    <span class="badge badge-warning">
                        <i class="fas fa-clock"></i> Pending
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i> Detail Perubahan</h5>
            </div>
            <div class="card-body">
                @if(empty($changes))
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Tidak ada perubahan yang ditemukan.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th width="25%">Field</th>
                                    <th width="37.5%">Data Lama</th>
                                    <th width="37.5%">Data Baru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($changes as $field => $newValue)
                                    <tr>
                                        <td>
                                            <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}</strong>
                                        </td>
                                        <td>
                                            @if($field === 'foto')
                                                @if(isset($oldData[$field]) && $oldData[$field])
                                                    <img src="{{ asset('storage/' . $oldData[$field]) }}" 
                                                         alt="Foto Lama" class="img-thumbnail" 
                                                         style="max-width: 100px; max-height: 100px;">
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            @elseif($field === 'sertifikat')
                                                @if(isset($oldData[$field]) && $oldData[$field])
                                                    <a href="{{ asset('storage/' . $oldData[$field]) }}" 
                                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-file-alt"></i> Lihat Sertifikat Lama
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada sertifikat</span>
                                                @endif
                                            @elseif($field === 'tarif_konsultasi')
                                                @if(isset($oldData[$field]))
                                                    Rp {{ number_format($oldData[$field], 0, ',', '.') }}
                                                @else
                                                    <span class="text-muted">Belum diisi</span>
                                                @endif
                                            @else
                                                @if(isset($oldData[$field]) && $oldData[$field])
                                                    {{ $oldData[$field] }}
                                                @else
                                                    <span class="text-muted">Belum diisi</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($field === 'foto')
                                                @if($newValue)
                                                    <img src="{{ asset('storage/' . $newValue) }}" 
                                                         alt="Foto Baru" class="img-thumbnail" 
                                                         style="max-width: 100px; max-height: 100px;">
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            @elseif($field === 'sertifikat')
                                                @if($newValue)
                                                    <a href="{{ asset('storage/' . $newValue) }}" 
                                                       target="_blank" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-file-alt"></i> Lihat Sertifikat Baru
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada sertifikat</span>
                                                @endif
                                            @elseif($field === 'tarif_konsultasi')
                                                <span class="text-success font-weight-bold">
                                                    Rp {{ number_format($newValue, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="text-success font-weight-bold">{{ $newValue }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>