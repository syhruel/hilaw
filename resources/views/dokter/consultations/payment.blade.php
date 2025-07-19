@extends('dokter.layouts.app')

@section('title', 'Pembayaran')
@section('page-title', 'Persetujuan Pembayaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pembayaran</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->consultation->user->name }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>
                            @if($payment->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($payment->status == 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($payment->status == 'pending')
                                <form method="POST" action="{{ route('dokter.payments.approve', $payment->id) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                            @endif
                            @if($payment->payment_proof)
                                <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-image"></i> Lihat Bukti
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection