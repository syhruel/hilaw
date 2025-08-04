@extends('admin.layouts.app')

@section('title', 'Edit Ahli Hukum')
@section('page-title', 'Edit Ahli Hukum')

@section('content')
@php
    // Parse jadwal kerja untuk mendapatkan data hari dan jam
    $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    
    // Default values
    $hari_mulai_current = '';
    $hari_selesai_current = '';
    $jam_mulai_current = '';
    $jam_selesai_current = '';
    
    if ($dokter->jadwal_kerja) {
        // Parse jadwal_kerja format: "Senin-Jumat: 08:00 - 17:00" atau "Senin: 08:00 - 17:00"
        if (strpos($dokter->jadwal_kerja, ':') !== false) {
            $jadwal_parts = explode(':', $dokter->jadwal_kerja, 2);
            $hari_part = trim($jadwal_parts[0]);
            $jam_part = trim($jadwal_parts[1]);
            
            // Parse hari
            if (strpos($hari_part, '-') !== false) {
                $hari_range = explode('-', $hari_part);
                $hari_mulai_current = trim($hari_range[0]);
                $hari_selesai_current = trim($hari_range[1]);
            } else {
                $hari_mulai_current = trim($hari_part);
                $hari_selesai_current = '';
            }
            
            // Parse jam
            if (strpos($jam_part, ' - ') !== false) {
                $jam_range = explode(' - ', $jam_part);
                $jam_mulai_current = trim($jam_range[0]);
                $jam_selesai_current = trim($jam_range[1]);
            }
        }
    }
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Ahli Hukum</h3>
            </div>
            
            <form method="POST" action="{{ route('dokter.update', $dokter->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Ahli Hukum <span class="text-danger">*</span></label>
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
                                <label for="keahlian">Bidang Keahlian Hukum <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('keahlian') is-invalid @enderror" 
                                       id="keahlian" name="keahlian" value="{{ old('keahlian', $dokter->keahlian) }}" 
                                       placeholder="Contoh: Hukum Pidana, Hukum Perdata, dll" required>
                                @error('keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lulusan_universitas">Lulusan Universitas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lulusan_universitas') is-invalid @enderror" 
                                       id="lulusan_universitas" name="lulusan_universitas" 
                                       value="{{ old('lulusan_universitas', $dokter->lulusan_universitas) }}" 
                                       placeholder="Nama Universitas dan Fakultas" required>
                                @error('lulusan_universitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pengalaman_tahun">Pengalaman (Tahun) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('pengalaman_tahun') is-invalid @enderror" 
                                       id="pengalaman_tahun" name="pengalaman_tahun" 
                                       value="{{ old('pengalaman_tahun', $dokter->pengalaman_tahun) }}" 
                                       min="0" max="50" required>
                                @error('pengalaman_tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tarif_konsultasi">Tarif Konsultasi per Jam (Rp) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tarif_konsultasi') is-invalid @enderror"
                                       id="tarif_konsultasi" name="tarif_konsultasi" 
                                       value="{{ old('tarif_konsultasi', number_format($dokter->tarif_konsultasi ?? 0, 0, ',', '.')) }}" 
                                       required placeholder="Contoh: 500.000">
                                @error('tarif_konsultasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pengalaman Deskripsi - Perbaiki nama field menjadi 'pengalaman' -->
                    <div class="form-group">
                        <label for="pengalaman">Deskripsi Pengalaman <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('pengalaman') is-invalid @enderror" 
                                  id="pengalaman" name="pengalaman" rows="4" required 
                                  placeholder="Jelaskan pengalaman praktik hukum, kasus yang pernah ditangani, dll">{{ old('pengalaman', $dokter->pengalaman_deskripsi ?? $dokter->pengalaman) }}</textarea>
                        @error('pengalaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">Alamat Kantor/Praktik <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required 
                                  placeholder="Alamat lengkap kantor hukum atau tempat praktik">{{ old('alamat', $dokter->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jadwal Kerja - Jadikan opsional -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Jadwal Kerja (Opsional)</h5>
                            <small class="text-muted">Isi jika ingin mengubah jadwal kerja</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hari_mulai">Hari Mulai</label>
                                        <select class="form-control @error('hari_mulai') is-invalid @enderror" 
                                                id="hari_mulai" name="hari_mulai">
                                            <option value="">Pilih Hari</option>
                                            @foreach($hari_list as $hari)
                                                <option value="{{ $hari }}" {{ old('hari_mulai', $hari_mulai_current) == $hari ? 'selected' : '' }}>
                                                    {{ $hari }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hari_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hari_selesai">Hari Selesai</label>
                                        <select class="form-control @error('hari_selesai') is-invalid @enderror" 
                                                id="hari_selesai" name="hari_selesai">
                                            <option value="">Pilih Hari (Opsional)</option>
                                            @foreach($hari_list as $hari)
                                                <option value="{{ $hari }}" {{ old('hari_selesai', $hari_selesai_current) == $hari ? 'selected' : '' }}>
                                                    {{ $hari }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hari_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jam_mulai">Jam Mulai</label>
                                        <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                               id="jam_mulai" name="jam_mulai" 
                                               value="{{ old('jam_mulai', $jam_mulai_current) }}">
                                        @error('jam_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jam_selesai">Jam Selesai</label>
                                        <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                               id="jam_selesai" name="jam_selesai" 
                                               value="{{ old('jam_selesai', $jam_selesai_current) }}">
                                        @error('jam_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            @if($dokter->jadwal_kerja)
                            <div class="alert alert-info">
                                <strong>Jadwal Saat Ini:</strong> {{ $dokter->jadwal_kerja }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group mt-3">
                        <label for="foto">Foto Profil</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/jpeg,image/jpg,image/png">
                            <label class="custom-file-label" for="foto">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 100MB.
                        </small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview Foto Baru -->
                        <div id="foto-preview" class="mt-2" style="display: none;">
                            <label class="form-label text-info">Preview Foto Baru:</label>
                            <div>
                                <img id="foto-preview-img" src="" alt="Preview" 
                                     class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <!-- Upload Sertifikat -->
                    <div class="form-group">
                        <label for="sertifikat">Sertifikat/Ijazah Hukum</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('sertifikat') is-invalid @enderror" 
                                   id="sertifikat" name="sertifikat" accept=".pdf,image/jpeg,image/jpg,image/png">
                            <label class="custom-file-label" for="sertifikat">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang diperbolehkan: PDF, JPG, JPEG, PNG. Maksimal 100MB.
                        </small>
                        @error('sertifikat')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview Sertifikat Baru -->
                        <div id="sertifikat-preview" class="mt-2" style="display: none;">
                            <label class="form-label text-info">Preview Sertifikat Baru:</label>
                            <div id="sertifikat-preview-content">
                                <!-- Content will be inserted here -->
                            </div>
                        </div>
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

                    <!-- Status Online -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_online" name="is_online" 
                                   value="1" {{ old('is_online', $dokter->is_online) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_online">
                                Status Online (Tersedia untuk konsultasi)
                            </label>
                        </div>
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
        <!-- Foto Profil Saat Ini -->
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
                        <i class="fas fa-balance-scale fa-4x text-white"></i>
                    </div>
                    <p class="text-muted">Belum ada foto profil</p>
                    <small class="text-info">
                        <i class="fas fa-info-circle"></i> 
                        Upload foto untuk menampilkan profil
                    </small>
                @endif
            </div>
        </div>

        <!-- Sertifikat Saat Ini -->
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Sertifikat Saat Ini</h4>
            </div>
            <div class="card-body text-center">
                @if($dokter->sertifikat)
                    @php
                        $sertifikatExt = strtolower(pathinfo($dokter->sertifikat, PATHINFO_EXTENSION));
                    @endphp
                    
                    @if(in_array($sertifikatExt, ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $dokter->sertifikat) }}" 
                             alt="Sertifikat {{ $dokter->name }}" 
                             class="img-fluid mb-3" style="max-height: 300px;">
                    @else
                        <div class="text-center">
                            <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                            <p class="text-muted">Sertifikat PDF</p>
                        </div>
                    @endif
                    
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $dokter->sertifikat) }}" 
                           class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="fas fa-eye"></i> Lihat Sertifikat
                        </a>
                    </div>
                    <small class="text-info d-block mt-2">
                        <i class="fas fa-info-circle"></i> 
                        Upload sertifikat baru untuk mengganti yang lama
                    </small>
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 200px; height: 200px; border: 2px dashed #dee2e6;">
                        <i class="fas fa-certificate fa-4x text-muted"></i>
                    </div>
                    <p class="text-muted">Belum ada sertifikat</p>
                    <small class="text-info">
                        <i class="fas fa-info-circle"></i> 
                        Upload sertifikat untuk verifikasi
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
                
                <div class="info-item mb-2">
                    <strong>Role:</strong><br>
                    <span class="badge badge-primary">{{ ucfirst($dokter->role) }}</span>
                </div>

                <div class="info-item">
                    <strong>Status Online:</strong><br>
                    @if($dokter->is_online)
                        <span class="badge badge-success">
                            <i class="fas fa-circle"></i> Online
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            <i class="fas fa-circle"></i> Offline
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Debug: tampilkan jadwal kerja saat ini di console
    console.log('Jadwal Kerja Saat Ini:', @json($dokter->jadwal_kerja ?? ''));
    console.log('Parsed Data:', {
        hari_mulai: @json($hari_mulai_current),
        hari_selesai: @json($hari_selesai_current),
        jam_mulai: @json($jam_mulai_current),
        jam_selesai: @json($jam_selesai_current)
    });

    // Preview foto sebelum upload
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('foto-preview');
        const previewImg = document.getElementById('foto-preview-img');
        
        if (file) {
            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipe file tidak diperbolehkan. Gunakan JPG, JPEG, atau PNG.');
                this.value = '';
                preview.style.display = 'none';
                return;
            }
            
            // Validasi ukuran file (100MB)
            if (file.size > 100 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 100MB.');
                this.value = '';
                preview.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Preview sertifikat sebelum upload
    document.getElementById('sertifikat').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('sertifikat-preview');
        const previewContent = document.getElementById('sertifikat-preview-content');
        
        if (file) {
            // Validasi tipe file
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipe file tidak diperbolehkan. Gunakan PDF, JPG, JPEG, atau PNG.');
                this.value = '';
                preview.style.display = 'none';
                return;
            }
            
            // Validasi ukuran file (100MB)
            if (file.size > 100 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 100MB.');
                this.value = '';
                preview.style.display = 'none';
                return;
            }
            
            if (file.type === 'application/pdf') {
                // Preview untuk PDF
                previewContent.innerHTML = `
                    <div class="text-center">
                        <i class="fas fa-file-pdf fa-4x text-danger mb-2"></i>
                        <p class="mb-0"><strong>${file.name}</strong></p>
                        <small class="text-muted">File PDF - ${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                    </div>
                `;
                preview.style.display = 'block';
            } else {
                // Preview untuk gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContent.innerHTML = `
                        <img src="${e.target.result}" alt="Preview Sertifikat" 
                             class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                    `;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        } else {
            preview.style.display = 'none';
        }
    });
    
    // Update label file input
    document.querySelector('#foto').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file...';
        document.querySelector('label[for="foto"]').textContent = fileName;
    });

    document.querySelector('#sertifikat').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file...';
        document.querySelector('label[for="sertifikat"]').textContent = fileName;
    });

    // Format input tarif konsultasi dengan thousand separator
    document.getElementById('tarif_konsultasi').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
        if (value) {
            // Format with thousand separator
            let formatted = new Intl.NumberFormat('id-ID').format(value);
            e.target.value = formatted;
        }
    });

    // Remove formatting before form submission
    document.querySelector('form').addEventListener('submit', function() {
        const tarifInput = document.getElementById('tarif_konsultasi');
        // Remove dots for submission
        tarifInput.value = tarifInput.value.replace(/\./g, '');
    });

    // Validasi jadwal kerja - pastikan jika hari_mulai diisi, jam juga harus diisi
    document.querySelector('form').addEventListener('submit', function(e) {
        const hariMulai = document.getElementById('hari_mulai').value;
        const jamMulai = document.getElementById('jam_mulai').value;
        const jamSelesai = document.getElementById('jam_selesai').value;
        
        if (hariMulai && (!jamMulai || !jamSelesai)) {
            e.preventDefault();
            alert('Jika hari mulai dipilih, jam mulai dan jam selesai harus diisi juga.');
            return false;
        }
        
        if ((jamMulai || jamSelesai) && !hariMulai) {
            e.preventDefault();
            alert('Jika jam diisi, hari mulai harus dipilih juga.');
            return false;
        }
    });
</script>
@endpush
@endsection