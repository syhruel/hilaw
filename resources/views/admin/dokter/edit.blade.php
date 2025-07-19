@extends('admin.layouts.app')

@section('title', 'Edit Dokter')
@section('page-title', 'Edit Dokter')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Dokter</h3>
            </div>
            
            <form method="POST" action="{{ route('dokter.update', $dokter->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Dokter <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $dokter->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $dokter->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keahlian">Keahlian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('keahlian') is-invalid @enderror" 
                                       id="keahlian" name="keahlian" value="{{ old('keahlian', $dokter->keahlian) }}" required>
                                @error('keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lulusan_universitas">Lulusan Universitas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lulusan_universitas') is-invalid @enderror" 
                                       id="lulusan_universitas" name="lulusan_universitas" value="{{ old('lulusan_universitas', $dokter->lulusan_universitas) }}" required>
                                @error('lulusan_universitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pengalaman">Pengalaman <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('pengalaman') is-invalid @enderror" 
                                  id="pengalaman" name="pengalaman" rows="4" required>{{ old('pengalaman', $dokter->pengalaman) }}</textarea>
                        @error('pengalaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required>{{ old('alamat', $dokter->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tarif_konsultasi">Tarif Konsultasi per Jam (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('tarif_konsultasi') is-invalid @enderror"
                            id="tarif_konsultasi" name="tarif_konsultasi" value="{{ old('tarif_konsultasi', $dokter->tarif_konsultasi) }}" required min="0">
                        @error('tarif_konsultasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Profil</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            <label class="custom-file-label" for="foto">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 10MB.
                        </small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Status Persetujuan</label>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                    <a href="{{ route('dokter.show', $dokter->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ route('dokter.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Foto Profil Saat Ini</h4>
            </div>
            <div class="card-body text-center">
                @if($dokter->foto)
                    <img src="{{ asset('storage/' . $dokter->foto) }}" 
                         alt="{{ $dokter->name }}" 
                         class="img-fluid rounded-circle mb-3"
                         style="width: 200px; height: 200px; object-fit: cover;">
                    <p class="text-muted">Foto profil saat ini</p>
                    <small class="text-info">
                        <i class="fas fa-info-circle"></i> 
                        Upload foto baru untuk mengganti yang lama
                    </small>
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 200px; height: 200px;">
                        <i class="fas fa-user-md fa-4x text-white"></i>
                    </div>
                    <p class="text-muted">Belum ada foto profil</p>
                    <small class="text-info">
                        <i class="fas fa-info-circle"></i> 
                        Upload foto untuk menampilkan profil
                    </small>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Informasi</h4>
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
                
                <div class="info-item">
                    <strong>Role:</strong><br>
                    <span class="badge badge-primary">{{ ucfirst($dokter->role) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview image
                const existingImg = document.querySelector('.current-photo img');
                if (existingImg) {
                    existingImg.src = e.target.result;
                } else {
                    // If no existing image, create new one
                    const photoContainer = document.querySelector('.card-body.text-center');
                    const placeholder = photoContainer.querySelector('.bg-secondary');
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid rounded-circle mb-3';
                    img.style.width = '200px';
                    img.style.height = '200px';
                    img.style.objectFit = 'cover';
                    photoContainer.prepend(img);
                }
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Update file input label
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file...';
        document.querySelector('.custom-file-label').textContent = fileName;
    });
</script>
@endpush
@endsection