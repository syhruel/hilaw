@extends('dokter.layouts.app')

@section('title', 'Riwayat Pembayaran')
@section('page-title', 'Riwayat Pembayaran Pasien')

@section('content')
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> 
    <strong>Informasi:</strong> Pembayaran dikelola oleh admin. Anda hanya dapat melihat status pembayaran pasien.
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pembayaran Konsultasi</h3>
        <div class="card-tools">
            <div class="badge badge-info">
                Total: {{ $payments->count() }} pembayaran
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Metode</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment->consultation->user->name }}</td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            @if ($payment->status === 'pending')
                                <span class="badge bg-warning">Menunggu Persetujuan Admin</span>
                            @elseif ($payment->status === 'approved')
                                <span class="badge bg-success">Disetujui Admin</span>
                            @elseif ($payment->status === 'rejected')
                                <span class="badge bg-danger">Ditolak Admin</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('dokter.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection