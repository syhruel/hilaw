@extends('admin.layouts.app')

@section('title', 'Set Jadwal & Harga')
@section('page-title', 'Set Jadwal & Harga Dokter')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('dokter.setJadwalHargaSave', $dokter->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label>Tarif Konsultasi</label>
                    <input type="number" name="tarif_konsultasi" value="{{ old('tarif_konsultasi', $dokter->tarif_konsultasi) }}" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Hari Mulai</label>
                    <select class="form-control" name="hari_mulai" required>
                        <option value="">Pilih Hari</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                            <option value="{{ $hari }}">{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Hari Selesai <small class="text-muted">(Opsional)</small></label>
                    <select class="form-control" name="hari_selesai">
                        <option value="">Pilih Hari</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                            <option value="{{ $hari }}">{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" required>
                </div>
                <div class="col-md-3 mt-2">
                    <label>Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control" required>
                </div>
                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-success">Simpan Jadwal & Harga</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
