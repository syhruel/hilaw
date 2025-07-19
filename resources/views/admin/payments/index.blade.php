@extends('admin.layouts.app')

@section('title', 'Kelola Pembayaran')
@section('page-title', 'Daftar Pembayaran Konsultasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pembayaran Konsultasi</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Waktu Konsultasi</th>
                        <th>Status</th>
                        <th>Bukti Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->consultation->user->name ?? '-' }}</td>
                            <td>{{ $payment->consultation->dokter->name ?? '-' }}</td>
                            <td>{{ $payment->consultation->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($payment->status === 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($payment->status === 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-warning">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($payment->proof && \Illuminate\Support\Facades\Storage::exists($payment->proof))
                                    <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-image"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </td>
                            <td>
                                @if($payment->status === 'pending')
                                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-success btn-sm" onclick="return confirm('Yakin setujui pembayaran ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Tolak pembayaran ini?')">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
