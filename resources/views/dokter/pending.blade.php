@extends('dokter.layouts.pending')

@section('title', 'Status Pendaftaran Dokter')
@section('page-title', 'Status Pendaftaran Dokter')

@push('styles')
<style>
    .status-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: white;
    }
    .status-approved { background-color: #28a745; }
    .status-rejected { background-color: #dc3545; }
    .status-pending { background-color: #ffc107; }
    .status-incomplete { background-color: #007bff; }
    
    .file-preview {
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f8f9fa;
    }
    
    .file-preview img {
        max-width: 200px;
        max-height: 150px;
        border-radius: 5px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row no-gutters">
        <div class="col-12">
            <!-- Status Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-check"></i> Status Pendaftaran</h3>
                </div>
                <div class="card-body text-center">
                    @if(auth()->user()->approval_status == 'approved')
                        <!-- Approved Status -->
                        <div class="status-icon status-approved">
                            <i class="fas fa-check"></i>
                        </div>
                        <h4>Akun Disetujui</h4>
                        <p class="text-muted">
                            Selamat! Akun dokter Anda telah disetujui. Anda dapat mengakses dashboard sekarang.
                        </p>
                        <a href="{{ route('dokter.dashboard') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-arrow-right"></i> Masuk ke Dashboard
                        </a>

                    @elseif(auth()->user()->approval_status == 'rejected')
                        <!-- Rejected Status -->
                        <div class="status-icon status-rejected">
                            <i class="fas fa-times"></i>
                        </div>
                        <h4>Pendaftaran Ditolak</h4>
                        <p class="text-muted">
                            Silakan perbaiki data sesuai catatan di bawah ini.
                        </p>
                        
                        @if(auth()->user()->rejection_reason)
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-info-circle"></i> Alasan Penolakan</h6>
                                <p class="mb-0">{{ auth()->user()->rejection_reason }}</p>
                            </div>
                        @endif

                    @elseif(!auth()->user()->keahlian || !auth()->user()->foto || !auth()->user()->sertifikat)
                        <!-- Incomplete Data -->
                        <div class="status-icon status-incomplete">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h4>Lengkapi Data Profil</h4>
                        <p class="text-muted">
                            Silakan lengkapi data profil untuk menunggu persetujuan admin.
                        </p>

                    @else
                        <!-- Pending Status -->
                        <div class="status-icon status-pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Menunggu Persetujuan</h4>
                        <p class="text-muted">
                            Data Anda sedang dalam proses verifikasi oleh admin.
                        </p>
                        
                        <div class="callout callout-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Proses</h6>
                            <ul class="mb-0 text-left">
                                <li>Verifikasi membutuhkan waktu 1-3 hari kerja</li>
                                <li>Anda akan mendapat notifikasi via email</li>
                                <li>Pastikan email Anda aktif dan dapat menerima pesan</li>
                            </ul>
                        </div>

                        <button onclick="window.location.reload()" class="btn btn-outline-primary">
                            <i class="fas fa-sync-alt"></i> Refresh Status
                        </button>
                    @endif
                </div>
            </div>

            <!-- Form Section -->
            @if(auth()->user()->approval_status == 'rejected' || (!auth()->user()->keahlian || !auth()->user()->foto || !auth()->user()->sertifikat))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i> 
                            {{ auth()->user()->approval_status == 'rejected' ? 'Perbaiki Data Profil' : 'Lengkapi Data Profil' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Profile Form -->
                        <form method="POST" action="{{ route('dokter.update-profile') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Basic Information -->
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-user"></i> Informasi Dasar</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name') ?: auth()->user()->name }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email') ?: auth()->user()->email }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="keahlian">Spesialisasi/Keahlian <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('keahlian') is-invalid @enderror" 
                                                       id="keahlian" name="keahlian" value="{{ old('keahlian') ?: auth()->user()->keahlian }}" 
                                                       placeholder="" required>
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
                                                       value="{{ old('lulusan_universitas') ?: auth()->user()->lulusan_universitas }}" required>
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
                                                       id="pengalaman_tahun" name="pengalaman_tahun" min="0" max="50"
                                                       value="{{ old('pengalaman_tahun') ?: auth()->user()->pengalaman_tahun }}" required>
                                                @error('pengalaman_tahun')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tarif_konsultasi">Tarif Konsultasi <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('tarif_konsultasi') is-invalid @enderror" 
                                                       id="tarif_konsultasi" name="tarif_konsultasi" min="0" step="1000"
                                                       value="{{ old('tarif_konsultasi') ?: auth()->user()->tarif_konsultasi }}" required>
                                                @error('tarif_konsultasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="pengalaman_deskripsi">Deskripsi Pengalaman <span class="text-danger">*</span></label>
                                                <textarea class="form-control @error('pengalaman_deskripsi') is-invalid @enderror" 
                                                          id="pengalaman_deskripsi" name="pengalaman_deskripsi" rows="3" required>{{ old('pengalaman_deskripsi') ?: auth()->user()->pengalaman_deskripsi }}</textarea>
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
                                                          id="alamat" name="alamat" rows="2" required>{{ old('alamat') ?: auth()->user()->alamat }}</textarea>
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
                                    @php
                                        $hari_mulai = old('hari_mulai') ?: auth()->user()->hari_mulai;
                                        $hari_selesai = old('hari_selesai') ?: auth()->user()->hari_selesai;
                                        $jam_mulai = old('jam_mulai') ?: auth()->user()->jam_mulai;
                                        $jam_selesai = old('jam_selesai') ?: auth()->user()->jam_selesai;
                                    @endphp
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hari_mulai">Hari Mulai <span class="text-danger">*</span></label>
                                                <select class="form-control @error('hari_mulai') is-invalid @enderror" 
                                                        id="hari_mulai" name="hari_mulai" required>
                                                    <option value="">Pilih Hari</option>
                                                    <option value="senin" {{ $hari_mulai == 'senin' ? 'selected' : '' }}>Senin</option>
                                                    <option value="selasa" {{ $hari_mulai == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                                    <option value="rabu" {{ $hari_mulai == 'rabu' ? 'selected' : '' }}>Rabu</option>
                                                    <option value="kamis" {{ $hari_mulai == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                                    <option value="jumat" {{ $hari_mulai == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                                    <option value="sabtu" {{ $hari_mulai == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                                    <option value="minggu" {{ $hari_mulai == 'minggu' ? 'selected' : '' }}>Minggu</option>
                                                </select>
                                                @error('hari_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hari_selesai">Hari Selesai (Opsional)</label>
                                                <select class="form-control @error('hari_selesai') is-invalid @enderror" 
                                                        id="hari_selesai" name="hari_selesai">
                                                    <option value="">Pilih Hari (Kosongkan jika sama)</option>
                                                    <option value="senin" {{ $hari_selesai == 'senin' ? 'selected' : '' }}>Senin</option>
                                                    <option value="selasa" {{ $hari_selesai == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                                    <option value="rabu" {{ $hari_selesai == 'rabu' ? 'selected' : '' }}>Rabu</option>
                                                    <option value="kamis" {{ $hari_selesai == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                                    <option value="jumat" {{ $hari_selesai == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                                    <option value="sabtu" {{ $hari_selesai == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                                    <option value="minggu" {{ $hari_selesai == 'minggu' ? 'selected' : '' }}>Minggu</option>
                                                </select>
                                                @error('hari_selesai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                                       id="jam_mulai" name="jam_mulai" 
                                                       value="{{ $jam_mulai }}" required>
                                                @error('jam_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                                       id="jam_selesai" name="jam_selesai" 
                                                       value="{{ $jam_selesai }}" required>
                                                @error('jam_selesai')
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="foto">Foto Profil 
                                                    @if(!auth()->user()->foto) <span class="text-danger">*</span> @endif
                                                </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" 
                                                               id="foto" name="foto" accept="image/*">
                                                        <label class="custom-file-label" for="foto">Pilih file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 10MB</small>
                                                
                                                <!-- Current Photo Preview -->
                                                @if(auth()->user()->foto)
                                                    <div class="file-preview">
                                                        <strong>Foto Saat Ini:</strong><br>
                                                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="img-thumbnail">
                                                    </div>
                                                @endif
                                                
                                                <!-- New Photo Preview -->
                                                <div id="foto-preview" class="file-preview" style="display: none;">
                                                    <strong>Preview Foto Baru:</strong><br>
                                                    <img id="foto-preview-img" src="#" alt="Preview" class="img-thumbnail">
                                                </div>
                                                
                                                @error('foto')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sertifikat">Sertifikat 
                                                    @if(!auth()->user()->sertifikat) <span class="text-danger">*</span> @endif
                                                </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input @error('sertifikat') is-invalid @enderror" 
                                                               id="sertifikat" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png">
                                                        <label class="custom-file-label" for="sertifikat">Pilih file</label>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 10MB</small>
                                                
                                                <!-- Current Certificate -->
                                                @if(auth()->user()->sertifikat)
                                                    <div class="file-preview">
                                                        <strong>Sertifikat Saat Ini:</strong><br>
                                                        @php
                                                            $ext = pathinfo(auth()->user()->sertifikat, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ asset('storage/' . auth()->user()->sertifikat) }}" alt="Sertifikat" class="img-thumbnail">
                                                        @else
                                                            <a href="{{ asset('storage/' . auth()->user()->sertifikat) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-file-pdf"></i> Lihat Sertifikat PDF
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- New Certificate Preview -->
                                                <div id="sertifikat-preview" class="file-preview" style="display: none;">
                                                    <strong>Preview Sertifikat Baru:</strong><br>
                                                    <div id="sertifikat-preview-content"></div>
                                                </div>
                                                
                                                @error('sertifikat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if(auth()->user()->approval_status == 'pending' && auth()->user()->keahlian && auth()->user()->foto && auth()->user()->sertifikat)
<script>
    setInterval(function() {
        fetch('{{ route("dokter.pending") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes('Selamat! Akun Disetujui') || data.includes('Pendaftaran Ditolak')) {
                window.location.reload();
            }
        })
        .catch(error => console.log('Auto-check error:', error));
    }, 30000);
</script>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Photo preview
    $('#foto').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#foto-preview-img').attr('src', e.target.result);
                $('#foto-preview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#foto-preview').hide();
        }
    });

    // Certificate preview
    $('#sertifikat').on('change', function() {
        var file = this.files[0];
        if (file) {
            var fileType = file.type;
            var fileName = file.name;
            var fileExt = fileName.split('.').pop().toLowerCase();
            
            if (['jpg', 'jpeg', 'png'].includes(fileExt)) {
                // Image preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#sertifikat-preview-content').html('<img src="' + e.target.result + '" alt="Preview Sertifikat" class="img-thumbnail">');
                    $('#sertifikat-preview').show();
                }
                reader.readAsDataURL(file);
            } else if (fileExt === 'pdf') {
                // PDF preview info
                $('#sertifikat-preview-content').html('<div class="alert alert-info"><i class="fas fa-file-pdf"></i> File PDF: ' + fileName + '<br><small>File akan diupload saat form disimpan</small></div>');
                $('#sertifikat-preview').show();
            }
        } else {
            $('#sertifikat-preview').hide();
        }
    });
});
</script>
@endsection