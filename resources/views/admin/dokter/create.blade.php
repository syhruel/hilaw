@extends('admin.layouts.app')

@section('title', 'Tambah Ahli Hukum')
@section('page-title', 'Tambah Ahli Hukum')

@push('styles')
<style>
    .preview-container {
        position: relative;
        display: inline-block;
        margin-top: 10px;
    }
    
    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border: 2px solid #ddd;
        border-radius: 8px;
        object-fit: cover;
    }
    
    .preview-file {
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 8px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .remove-preview {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .file-info {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
    
    .required-field {
        color: #dc3545;
    }
    
    .form-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #007bff;
    }
    
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .auto-approve-info {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
        color: #155724;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-balance-scale"></i> Form Tambah Ahli Hukum
        </h3>
        <div class="card-tools">
            <small class="text-muted">
                <i class="fas fa-info-circle"></i> 
                Field dengan tanda <span class="required-field">*</span> wajib diisi
            </small>
        </div>
    </div>

    <form method="POST" action="{{ route('dokter.store') }}" enctype="multipart/form-data" id="dokterForm">
        @csrf
        <div class="card-body">
            <!-- Info Auto Approval -->
            <div class="auto-approve-info">
                <i class="fas fa-check-circle"></i>
                <strong>Info:</strong> Akun ahli hukum yang dibuat melalui admin akan otomatis terverifikasi dan dapat langsung digunakan.
            </div>

            <!-- Informasi Akun -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Informasi Akun
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama Lengkap Ahli Hukum <span class="required-field">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Masukkan nama lengkap ahli hukum">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="required-field">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="dokter@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="required-field">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required
                                       placeholder="Minimal 6 karakter">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto">Foto Profil</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            <div class="file-info">
                                Format: JPG, PNG, JPEG | Maksimal: 10MB
                            </div>
                            <div id="fotoPreview"></div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sertifikat">Sertifikat/Lisensi Hukum</label>
                            <input type="file" class="form-control @error('sertifikat') is-invalid @enderror" 
                                   id="sertifikat" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="file-info">
                                Format: PDF, JPG, PNG, JPEG | Maksimal: 10MB
                            </div>
                            <div id="sertifikatPreview"></div>
                            @error('sertifikat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Profesional -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    Informasi Profesional
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keahlian">Keahlian/Bidang Hukum <span class="required-field">*</span></label>
                            <input type="text" class="form-control @error('keahlian') is-invalid @enderror" 
                                   id="keahlian" name="keahlian" value="{{ old('keahlian') }}" required
                                   placeholder="Contoh: Hukum Pidana, Hukum Perdata, Hukum Bisnis, dll">
                            @error('keahlian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lulusan_universitas">Lulusan Universitas <span class="required-field">*</span></label>
                            <input type="text" class="form-control @error('lulusan_universitas') is-invalid @enderror" 
                                   id="lulusan_universitas" name="lulusan_universitas" value="{{ old('lulusan_universitas') }}" required
                                   placeholder="Nama universitas tempat menempuh pendidikan">
                            @error('lulusan_universitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pengalaman_tahun">Pengalaman (Tahun) <span class="required-field">*</span></label>
                            <input type="number" class="form-control @error('pengalaman_tahun') is-invalid @enderror" 
                                   id="pengalaman_tahun" name="pengalaman_tahun" value="{{ old('pengalaman_tahun') }}" 
                                   required min="0" max="50"
                                   placeholder="Berapa tahun pengalaman">
                            @error('pengalaman_tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pengalaman_deskripsi">Deskripsi Pengalaman <span class="required-field">*</span></label>
                            <textarea class="form-control @error('pengalaman_deskripsi') is-invalid @enderror" 
                                      id="pengalaman_deskripsi" name="pengalaman_deskripsi" rows="4" required
                                      placeholder="Deskripsikan pengalaman menangani kasus hukum, firma hukum sebelumnya, dll">{{ old('pengalaman_deskripsi') }}</textarea>
                            @error('pengalaman_deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat Kantor/Praktik <span class="required-field">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required
                                      placeholder="Alamat lengkap kantor hukum atau tempat praktik">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Konsultasi -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-calendar-alt"></i>
                    Informasi Konsultasi & Jadwal
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tarif_konsultasi">Tarif Konsultasi Hukum (Rupiah) <span class="required-field">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control @error('tarif_konsultasi') is-invalid @enderror" 
                                       id="tarif_konsultasi" name="tarif_konsultasi" value="{{ old('tarif_konsultasi') }}" 
                                       required min="0" step="1000"
                                       placeholder="150000">
                            </div>
                            <small class="form-text text-muted">Tarif per sesi konsultasi hukum</small>
                            @error('tarif_konsultasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Online</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_online" name="is_online" value="1">
                                <label class="custom-control-label" for="is_online">
                                    Aktif Online (dapat menerima konsultasi)
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Akun akan otomatis terverifikasi. Status online dapat diubah kapan saja.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jadwal Kerja Ahli Hukum <span class="required-field">*</span></label>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Hari Mulai <span class="required-field">*</span></label>
                            <select class="form-control @error('hari_mulai') is-invalid @enderror" name="hari_mulai" required>
                                <option value="">Pilih Hari</option>
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                    <option value="{{ $hari }}" {{ old('hari_mulai') == $hari ? 'selected' : '' }}>
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-3">
                            <label>Hari Selesai <small class="text-muted">(Opsional)</small></label>
                            <select class="form-control @error('hari_selesai') is-invalid @enderror" name="hari_selesai">
                                <option value="">Pilih Hari</option>
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                    <option value="{{ $hari }}" {{ old('hari_selesai') == $hari ? 'selected' : '' }}>
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label>Jam Mulai <span class="required-field">*</span></label>
                            <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                   name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label>Jam Selesai <span class="required-field">*</span></label>
                            <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                   name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i>
                        Jika hanya satu hari, kosongkan "Hari Selesai". Untuk rentang hari (misal: Senin-Jumat), pilih kedua hari.
                    </small>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('dokter.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div>
                <button type="reset" class="btn btn-warning mr-2">
                    <i class="fas fa-undo"></i> Reset Form
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan & Verifikasi Ahli Hukum
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Preview foto profil
    $('#foto').change(function() {
        const file = this.files[0];
        const preview = $('#fotoPreview');
        
        preview.empty();
        
        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewHtml = `
                        <div class="preview-container">
                            <img src="${e.target.result}" class="preview-image" alt="Preview Foto">
                            <button type="button" class="remove-preview" onclick="removePreview('foto')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    preview.html(previewHtml);
                };
                reader.readAsDataURL(file);
            } else {
                preview.html('<div class="alert alert-warning">File yang dipilih bukan gambar!</div>');
                $(this).val('');
            }
        }
    });

    // Preview sertifikat
    $('#sertifikat').change(function() {
        const file = this.files[0];
        const preview = $('#sertifikatPreview');
        
        preview.empty();
        
        if (file) {
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            
            if (allowedTypes.includes(file.type)) {
                let previewHtml = '';
                
                if (file.type === 'application/pdf') {
                    previewHtml = `
                        <div class="preview-container">
                            <div class="preview-file">
                                <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                <div>
                                    <strong>${file.name}</strong><br>
                                    <small>PDF - ${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                                </div>
                            </div>
                            <button type="button" class="remove-preview" onclick="removePreview('sertifikat')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                } else {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imagePreview = `
                            <div class="preview-container">
                                <img src="${e.target.result}" class="preview-image" alt="Preview Sertifikat">
                                <button type="button" class="remove-preview" onclick="removePreview('sertifikat')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                        preview.html(imagePreview);
                    };
                    reader.readAsDataURL(file);
                    return;
                }
                
                preview.html(previewHtml);
            } else {
                preview.html('<div class="alert alert-warning">Format file tidak didukung! Gunakan PDF, JPG, PNG, atau JPEG.</div>');
                $(this).val('');
            }
        }
    });

    // Format tarif konsultasi
    $('#tarif_konsultasi').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value) {
            $(this).val(parseInt(value));
        }
    });

    // Validasi jam
    $('input[name="jam_mulai"], input[name="jam_selesai"]').change(function() {
        const jamMulai = $('input[name="jam_mulai"]').val();
        const jamSelesai = $('input[name="jam_selesai"]').val();
        
        if (jamMulai && jamSelesai && jamMulai >= jamSelesai) {
            alert('Jam selesai harus lebih besar dari jam mulai!');
            $(this).focus();
        }
    });

    // Form validation
    $('#dokterForm').submit(function(e) {
        let isValid = true;
        
        // Validasi password
        const password = $('#password').val();
        if (password.length < 6) {
            isValid = false;
            $('#password').addClass('is-invalid');
            $('#password').siblings('.invalid-feedback').text('Password minimal 6 karakter');
        }
        
        // Validasi jam
        const jamMulai = $('input[name="jam_mulai"]').val();
        const jamSelesai = $('input[name="jam_selesai"]').val();
        if (jamMulai && jamSelesai && jamMulai >= jamSelesai) {
            isValid = false;
            alert('Jam selesai harus lebih besar dari jam mulai!');
        }
        
        if (!isValid) {
            e.preventDefault();
        } else {
            // Show confirmation
            if (!confirm('Apakah Anda yakin ingin menambahkan ahli hukum ini? Akun akan langsung terverifikasi dan dapat digunakan.')) {
                e.preventDefault();
            }
        }
    });
});

// Function to remove preview
function removePreview(type) {
    $(`#${type}`).val('');
    $(`#${type}Preview`).empty();
}
</script>
@endpush