@extends('dokter.layouts.app')

@section('title', 'Edit Profil Dokter')
@section('page-title', 'Edit Profil Dokter')

@section('content')
<div class="container-fluid px-0">
    <div class="row no-gutters">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit"></i> Edit Profil Dokter</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('info') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Pending Changes Alert -->
                    @if($pendingChanges->count() > 0)
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-clock"></i> Pengajuan Perubahan Menunggu Persetujuan</h6>
                            @foreach($pendingChanges as $change)
                                <div class="mt-2">
                                    <small class="text-muted">{{ $change->created_at->format('d/m/Y H:i') }}</small>
                                    @if(isset($change->changes['sertifikat']))
                                        <p class="mb-1"><strong>Sertifikat:</strong> Menunggu persetujuan admin</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('dokter.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> Informasi Dasar</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $dokter->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
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
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="keahlian">Spesialisasi/Keahlian <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('keahlian') is-invalid @enderror" 
                                                   id="keahlian" name="keahlian" value="{{ old('keahlian', $dokter->keahlian) }}" required>
                                            @error('keahlian')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="lulusan_universitas">Lulusan Universitas <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('lulusan_universitas') is-invalid @enderror" 
                                                   id="lulusan_universitas" name="lulusan_universitas" 
                                                   value="{{ old('lulusan_universitas', $dokter->lulusan_universitas) }}" required>
                                            @error('lulusan_universitas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="pengalaman_tahun">Pengalaman (Tahun)</label>
                                            <input type="number" class="form-control @error('pengalaman_tahun') is-invalid @enderror" 
                                                   id="pengalaman_tahun" name="pengalaman_tahun" min="0" max="50"
                                                   value="{{ old('pengalaman_tahun', $dokter->pengalaman_tahun) }}">
                                            @error('pengalaman_tahun')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="tarif_konsultasi">Tarif Konsultasi <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('tarif_konsultasi') is-invalid @enderror" 
                                                   id="tarif_konsultasi" name="tarif_konsultasi" min="0" step="1000"
                                                   value="{{ old('tarif_konsultasi', $dokter->tarif_konsultasi) }}" required>
                                            @error('tarif_konsultasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="pengalaman_deskripsi">Deskripsi Pengalaman</label>
                                            <textarea class="form-control @error('pengalaman_deskripsi') is-invalid @enderror" 
                                                      id="pengalaman_deskripsi" name="pengalaman_deskripsi" rows="3">{{ old('pengalaman_deskripsi', $dokter->pengalaman_deskripsi) }}</textarea>
                                            @error('pengalaman_deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                      id="alamat" name="alamat" rows="2" required>{{ old('alamat', $dokter->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule -->
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-clock"></i> Jadwal Kerja</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="hari_mulai">Hari Mulai <span class="text-danger">*</span></label>
                                            <select class="form-control @error('hari_mulai') is-invalid @enderror" 
                                                    id="hari_mulai" name="hari_mulai" required>
                                                <option value="">Pilih Hari</option>
                                                @php
                                                    $days = [
                                                        'senin' => 'Senin',
                                                        'selasa' => 'Selasa',
                                                        'rabu' => 'Rabu',
                                                        'kamis' => 'Kamis',
                                                        'jumat' => 'Jumat',
                                                        'sabtu' => 'Sabtu',
                                                        'minggu' => 'Minggu'
                                                    ];
                                                @endphp
                                                @foreach($days as $key => $day)
                                                    <option value="{{ $key }}" 
                                                        {{ old('hari_mulai', $jadwalParsed['hari_mulai']) == $key ? 'selected' : '' }}>
                                                        {{ $day }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('hari_mulai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="hari_berakhir">Hari Berakhir (Opsional)</label>
                                            <select class="form-control @error('hari_berakhir') is-invalid @enderror" 
                                                    id="hari_berakhir" name="hari_berakhir">
                                                <option value="">Pilih Hari</option>
                                                @foreach($days as $key => $day)
                                                    <option value="{{ $key }}" 
                                                        {{ old('hari_berakhir', $jadwalParsed['hari_berakhir']) == $key ? 'selected' : '' }}>
                                                        {{ $day }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('hari_berakhir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                                   id="jam_mulai" name="jam_mulai" 
                                                   value="{{ old('jam_mulai', $jadwalParsed['jam_mulai']) }}" required>
                                            @error('jam_mulai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="jam_berakhir">Jam Berakhir <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control @error('jam_berakhir') is-invalid @enderror" 
                                                   id="jam_berakhir" name="jam_berakhir" 
                                                   value="{{ old('jam_berakhir', $jadwalParsed['jam_berakhir']) }}" required>
                                            @error('jam_berakhir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo and Certificate Upload -->
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-upload"></i> Upload File</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="foto">Foto Profil</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" 
                                                           id="foto" name="foto" accept="image/*">
                                                    <label class="custom-file-label" for="foto">Pilih file</label>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 10MB</small>
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if($dokter->foto)
                                                <div class="mt-3">
                                                    <img src="{{ Storage::url($dokter->foto) }}" 
                                                         alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                                                    <div class="mt-2">
                                                        <a href="{{ route('dokter.profile.delete-photo') }}" 
                                                           class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('Yakin ingin menghapus foto?')">
                                                            <i class="fas fa-trash"></i> Hapus Foto
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="sertifikat">
                                                Sertifikat 
                                                <i class="fas fa-info-circle text-info" 
                                                   title="Upload sertifikat memerlukan persetujuan admin"></i>
                                            </label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('sertifikat') is-invalid @enderror" 
                                                           id="sertifikat" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png">
                                                    <label class="custom-file-label" for="sertifikat">Pilih file</label>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 10MB</small>
                                            <small class="form-text text-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Upload sertifikat memerlukan persetujuan admin
                                            </small>
                                            @error('sertifikat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if($dokter->sertifikat)
                                                <div class="mt-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                        <a href="{{ Storage::url($dokter->sertifikat) }}" 
                                                           target="_blank" class="text-decoration-none">
                                                            Lihat Sertifikat Saat Ini
                                                        </a>
                                                    </div>
                                                    <div class="mt-2">
                                                        <a href="{{ route('dokter.profile.delete-certificate') }}" 
                                                           class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('Yakin ingin mengajukan penghapusan sertifikat? Memerlukan persetujuan admin.')">
                                                            <i class="fas fa-trash"></i> Hapus Sertifikat
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Change -->
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-key"></i> Ubah Password (Opsional)</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="current_password">Password Saat Ini</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                   id="current_password" name="current_password">
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="password">Password Baru</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" minlength="8">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" minlength="8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href="{{ route('dokter.profile.show') }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary ml-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Form validation
    $('form').on('submit', function(e) {
        const password = $('#password').val();
        const currentPassword = $('#current_password').val();
        
        if (password && !currentPassword) {
            e.preventDefault();
            alert('Password saat ini wajib diisi untuk mengubah password');
            $('#current_password').focus();
        }
    });
});
</script>
@endsection