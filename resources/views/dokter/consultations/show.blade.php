@extends('dokter.layouts.app')

@section('title', 'Detail Konsultasi')
@section('page-title', 'Detail Konsultasi')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Pasien</h3>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $consultation->user->name }}</p>
                <p><strong>Email:</strong> {{ $consultation->user->email }}</p>
                <p><strong>Keluhan:</strong></p>
                <p>{{ $consultation->keluhan }}</p>
                <p><strong>Tarif:</strong> Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> 
                    @if($consultation->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($consultation->status == 'paid')
                        <span class="badge badge-info">Dibayar</span>
                    @elseif($consultation->status == 'approved')
                        <span class="badge badge-success">Disetujui</span>
                    @elseif($consultation->status == 'completed')
                        <span class="badge badge-primary">Selesai</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Pembayaran</h3>
            </div>
            <div class="card-body">
                @if($consultation->payment)
                    <p><strong>Jumlah:</strong> Rp {{ number_format($consultation->payment->amount, 0, ',', '.') }}</p>
                    <p><strong>Metode:</strong> {{ $consultation->payment->payment_method }}</p>
                    <p><strong>Status:</strong> 
                        @if($consultation->payment->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($consultation->payment->status == 'approved')
                            <span class="badge badge-success">Disetujui</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </p>
                    @if($consultation->payment->payment_proof)
                        <p><strong>Bukti Pembayaran:</strong></p>
                        <img src="{{ asset('storage/' . $consultation->payment->payment_proof) }}" class="img-fluid" style="max-width: 300px;">
                    @endif
                @else
                    <p class="text-muted">Belum ada pembayaran</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($consultation->status == 'approved')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Diagnosis & Resep</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('dokter.consultations.diagnose', $consultation->id) }}">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label>Diagnosis</label>
                <textarea name="diagnosis" class="form-control" rows="4" required>{{ $consultation->diagnosis }}</textarea>
            </div>
            <div class="form-group">
                <label>Resep Obat</label>
                <textarea name="obat_resep" class="form-control" rows="3">{{ $consultation->obat_resep }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Diagnosis
            </button>
        </form>
    </div>
</div>
@endif

@if($consultation->diagnosis)
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Hasil Konsultasi</h3>
    </div>
    <div class="card-body">
        <p><strong>Diagnosis:</strong></p>
        <p>{{ $consultation->diagnosis }}</p>
        @if($consultation->obat_resep)
            <p><strong>Resep Obat:</strong></p>
            <p>{{ $consultation->obat_resep }}</p>
        @endif
    </div>
</div>
@endif
@endsection