@extends('admin.layouts.app')

@section('title', 'Tambah Dokter')
@section('page-title', 'Tambah Dokter')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Dokter</h3>
    </div>

    <form method="POST" action="{{ route('dokter.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Dokter</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Profil</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tarif_konsultasi">Tarif Konsultasi (per jam)</label>
                        <input type="number" class="form-control @error('tarif_konsultasi') is-invalid @enderror" 
                               id="tarif_konsultasi" name="tarif_konsultasi" value="{{ old('tarif_konsultasi') }}" required>
                        @error('tarif_konsultasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jadwal Kerja Dokter</label>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Hari Mulai</label>
                                <select class="form-control" name="hari_mulai" required>
                                    <option value="">Pilih Hari</option>
                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                        <option value="{{ $hari }}">{{ $hari }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Hari Selesai <small class="text-muted">(Opsional)</small></label>
                                <select class="form-control" name="hari_selesai">
                                    <option value="">Pilih Hari</option>
                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                        <option value="{{ $hari }}">{{ $hari }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Jam Mulai</label>
                                <input type="time" class="form-control" name="jam_mulai" required>
                            </div>

                            <div class="col-md-3">
                                <label>Jam Selesai</label>
                                <input type="time" class="form-control" name="jam_selesai" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="keahlian">Keahlian/Spesialisasi</label>
                        <input type="text" class="form-control @error('keahlian') is-invalid @enderror" 
                               id="keahlian" name="keahlian" value="{{ old('keahlian') }}" required>
                        @error('keahlian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lulusan_universitas">Lulusan Universitas</label>
                        <input type="text" class="form-control @error('lulusan_universitas') is-invalid @enderror" 
                               id="lulusan_universitas" name="lulusan_universitas" value="{{ old('lulusan_universitas') }}" required>
                        @error('lulusan_universitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pengalaman">Pengalaman</label>
                        <textarea class="form-control @error('pengalaman') is-invalid @enderror" 
                                  id="pengalaman" name="pengalaman" rows="3" required>{{ old('pengalaman') }}</textarea>
                        @error('pengalaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('dokter.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
