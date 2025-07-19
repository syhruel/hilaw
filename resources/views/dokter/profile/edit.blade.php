@extends('dokter.layouts.app')

@section('title', 'Edit Profil Dokter')
@section('page-title', 'Edit Profil Dokter')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Informasi Profil</h3>
            </div>
            
            <form action="{{ route('dokter.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><strong>Nama Dokter <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $dokter->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><strong>Email <span class="text-danger">*</span></strong></label>
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
                                <label for="keahlian"><strong>Keahlian <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('keahlian') is-invalid @enderror" 
                                       id="keahlian" name="keahlian" value="{{ old('keahlian', $dokter->keahlian) }}" required>
                                @error('keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lulusan_universitas"><strong>Lulusan Universitas <span class="text-danger">*</span></strong></label>
                                <input type="text" class="form-control @error('lulusan_universitas') is-invalid @enderror" 
                                       id="lulusan_universitas" name="lulusan_universitas" value="{{ old('lulusan_universitas', $dokter->lulusan_universitas) }}" required>
                                @error('lulusan_universitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pengalaman"><strong>Pengalaman <span class="text-danger">*</span></strong></label>
                        <textarea class="form-control @error('pengalaman') is-invalid @enderror" 
                                  id="pengalaman" name="pengalaman" rows="4" required>{{ old('pengalaman', $dokter->pengalaman) }}</textarea>
                        @error('pengalaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat"><strong>Alamat <span class="text-danger">*</span></strong></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required>{{ old('alamat', $dokter->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto"><strong>Foto Profil</strong></label>
                        <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Format: JPG, JPEG, PNG. Maksimal 10MB
                        </small>
                    </div>

                    <hr>
                    <h5>Ubah Password</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_password"><strong>Password Saat Ini</strong></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password"><strong>Password Baru</strong></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation"><strong>Konfirmasi Password Baru</strong></label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('dokter.profile.show') }}" class="btn btn-secondary">
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
                    <p class="text-muted">{{ $dokter->name }}</p>
                    
                    <form action="{{ route('dokter.profile.delete-photo') }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Yakin ingin menghapus foto profil?')">
                            <i class="fas fa-trash"></i> Hapus Foto
                        </button>
                    </form>
                @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 200px; height: 200px;">
                        <i class="fas fa-user-md fa-4x text-white"></i>
                    </div>
                    <p class="text-muted">Belum ada foto profil</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection