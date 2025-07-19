@extends('dokter.layouts.app')

@section('title', 'Persetujuan Pembayaran')
@section('page-title', 'Pembayaran Pasien')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pembayaran Konsultasi</h3>
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
                        <td>{{ ucfirst($payment->method) }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            @if ($payment->status === 'pending')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif ($payment->status === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($payment->status === 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            @if ($payment->status === 'pending')
                                <form method="POST" action="{{ route('dokter.payments.approve', $payment->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin menyetujui pembayaran ini?')">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                            @else
                                <span>-</span>
                            @endif
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
