@extends('pengguna.layouts.app')

@section('title', 'Konsultasi Baru')
@section('page-title', 'Konsultasi dengan Dr. ' . $dokter->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Konsultasi</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('pengguna.consultations.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="keluhan" class="form-label">Keluhan</label>
                        <textarea name="keluhan" id="keluhan" class="form-control" rows="3" required>{{ old('keluhan') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="durasi" class="form-label">Durasi Konsultasi (jam)</label>
                        <input type="number" name="durasi" id="durasi" class="form-control" min="1" max="5" required>
                        <small class="text-muted">Biaya per jam: Rp{{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</small>
                        <div id="total-biaya" class="text-success mt-1"></div>
                    </div>

                    <input type="hidden" name="dokter_id" value="{{ $dokter->id }}">

                    <button type="submit" class="btn btn-primary">Ajukan Konsultasi</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Dokter</h3>
            </div>
            <div class="card-body text-center">
                @if($dokter->foto)
                    <img src="{{ asset('storage/' . $dokter->foto) }}" class="rounded-circle mb-3" width="100" height="100">
                @else
                    <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <i class="fas fa-user-md text-white fa-3x"></i>
                    </div>
                @endif
                <h5>Dr. {{ $dokter->name }}</h5>
                <p class="text-muted">{{ $dokter->keahlian }}</p>
                <span class="badge badge-success">
                    <i class="fas fa-circle"></i> Online
                </span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tarifPerJam = {{ $dokter->tarif_konsultasi }};
    const inputDurasi = document.getElementById('durasi');
    const totalBiaya = document.getElementById('total-biaya');

    inputDurasi.addEventListener('input', function () {
        const jam = parseInt(this.value);
        if (!isNaN(jam) && jam > 0) {
            const total = tarifPerJam * jam;
            totalBiaya.innerHTML = `Total biaya kira-kira: Rp${total.toLocaleString('id-ID')}`;
        } else {
            totalBiaya.innerHTML = '';
        }
    });
});
</script>
@endsection
