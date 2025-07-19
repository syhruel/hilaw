@extends('pengguna.layouts.app')

@section('title', 'Detail Konsultasi')
@section('page-title', 'Detail Konsultasi')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Konsultasi</h3>
            </div>
            <div class="card-body">
                <p><strong>Dokter:</strong> Dr. {{ $consultation->dokter->name }}</p>
                <p><strong>Keahlian:</strong> {{ $consultation->dokter->keahlian }}</p>
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
                <p><strong>Tanggal:</strong> {{ $consultation->created_at->format('d/m/Y H:i') }}</p>
                
                @if($consultation->status == 'pending')
                    <a href="{{ route('pengguna.consultations.payment', $consultation->id) }}" class="btn btn-warning">
                        <i class="fas fa-credit-card"></i> Lakukan Pembayaran
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status Pembayaran</h3>
            </div>
            <div class="card-body">
                @if($consultation->payment)
                    <p><strong>Jumlah:</strong> Rp {{ number_format($consultation->payment->amount, 0, ',', '.') }}</p>
                    <p><strong>Metode:</strong> {{ $consultation->payment->payment_method }}</p>
                    <p><strong>Status:</strong> 
                        @if($consultation->payment->status == 'pending')
                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                        @elseif($consultation->payment->status == 'approved')
                            <span class="badge badge-success">Disetujui</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </p>
                    <p><strong>Tanggal Upload:</strong> {{ $consultation->payment->created_at->format('d/m/Y H:i') }}</p>
                @else
                    <p class="text-muted">Belum ada pembayaran</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($consultation->diagnosis)
<div class="card mt-3">
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