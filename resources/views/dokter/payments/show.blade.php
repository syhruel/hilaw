@extends('dokter.layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Pembayaran</h3>
                <div class="card-tools">
                    <span class="badge badge-{{ $payment->status === 'pending' ? 'warning' : ($payment->status === 'approved' ? 'success' : 'danger') }}">
                        @if($payment->status === 'pending')
                            Menunggu Persetujuan Admin
                        @elseif($payment->status === 'approved')
                            Disetujui Admin
                        @else
                            Ditolak Admin
                        @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Nama Pasien</strong></td>
                        <td>{{ $payment->consultation->user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Keluhan</strong></td>
                        <td>{{ $payment->consultation->keluhan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Durasi</strong></td>
                        <td>{{ $payment->consultation->duration_hours }} Jam</td>
                    </tr>
                    <tr>
                        <td><strong>Total Pembayaran</strong></td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Metode Pembayaran</strong></td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Waktu Upload</strong></td>
                        <td>{{ $payment->created_at->format('d F Y, H:i') }} WIB</td>
                    </tr>
                    @if($payment->status === 'approved')
                        <tr>
                            <td><strong>Disetujui Pada</strong></td>
                            <td>{{ $payment->approved_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                    @elseif($payment->status === 'rejected')
                        <tr>
                            <td><strong>Ditolak Pada</strong></td>
                            <td>{{ $payment->rejected_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Alasan Penolakan</strong></td>
                            <td>{{ $payment->rejection_reason }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bukti Pembayaran</h3>
            </div>
            <div class="card-body text-center">
                @if($payment->payment_proof)
                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                         alt="Bukti Pembayaran" 
                         class="img-fluid rounded"
                         style="max-width: 100%; height: auto; cursor: pointer;"
                         onclick="window.open(this.src, '_blank')">
                    <p class="text-muted mt-2 small">Klik gambar untuk memperbesar</p>
                @else
                    <p class="text-muted">Bukti pembayaran tidak tersedia</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Informasi:</strong> 
            @if($payment->status === 'pending')
                Pembayaran sedang menunggu persetujuan dari admin. Konsultasi akan dapat dimulai setelah pembayaran disetujui.
            @elseif($payment->status === 'approved')
                Pembayaran telah disetujui admin. Konsultasi dapat dimulai.
            @else
                Pembayaran ditolak oleh admin. Pasien dapat mengupload ulang bukti pembayaran.
            @endif
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('dokter.payments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
@endsection