@extends('admin.layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Pembayaran</h3>
                <div class="card-tools">
                    <span class="badge badge-{{ $payment->status === 'pending' ? 'warning' : ($payment->status === 'approved' ? 'success' : 'danger') }}">
                        @if($payment->status === 'pending')
                            Menunggu Persetujuan
                        @elseif($payment->status === 'approved')
                            Disetujui
                        @else
                            Ditolak
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
                        <td><strong>Nama Dokter</strong></td>
                        <td>{{ $payment->consultation->dokter->name }}</td>
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

@if($payment->status === 'pending')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tindakan Admin</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Approve Button -->
                        <form method="POST" action="{{ route('admin.payments.approve', $payment->id) }}" onsubmit="return confirm('Yakin ingin menyetujui pembayaran ini?')" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Setujui Pembayaran
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <!-- Toggle Reject Form Button -->
                        <button type="button" class="btn btn-danger btn-block" onclick="toggleRejectForm()">
                            <i class="fas fa-times"></i> Tolak Pembayaran
                        </button>
                    </div>
                </div>

                <!-- Reject Form (Hidden by default) -->
                <div id="rejectForm" style="display: none;" class="mt-3">
                    <div class="card border-danger">
                        <div class="card-header bg-danger">
                            <h5 class="mb-0 text-white">Tolak Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}" onsubmit="return confirmReject()">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="rejection_reason">Alasan Penolakan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required placeholder="Masukkan alasan penolakan pembayaran..."></textarea>
                                    <small class="form-text text-muted">Minimal 10 karakter</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Tolak Pembayaran
                                    </button>
                                    <button type="button" class="btn btn-secondary ml-2" onclick="toggleRejectForm()">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-3">
    <div class="col-12">
        <div class="alert alert-info">
            <strong>Status:</strong> Pembayaran sudah diproses dengan status: <strong>{{ ucfirst($payment->status) }}</strong>
            @if($payment->status === 'rejected' && $payment->rejection_reason)
                <br><strong>Alasan penolakan:</strong> {{ $payment->rejection_reason }}
                <br><small class="text-muted">Ditolak pada: {{ $payment->rejected_at->format('d F Y, H:i') }} WIB</small>
            @endif
        </div>
    </div>
</div>
@endif

<div class="mt-3">
    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<script>
function toggleRejectForm() {
    const form = document.getElementById('rejectForm');
    if (form.style.display === 'none') {
        form.style.display = 'block';
        form.scrollIntoView({behavior: 'smooth'});
    } else {
        form.style.display = 'none';
    }
}

function confirmReject() {
    const reason = document.getElementById('rejection_reason').value.trim();
    if (reason.length < 10) {
        alert('Alasan penolakan minimal 10 karakter');
        return false;
    }
    return confirm('Yakin ingin menolak pembayaran ini? Pasien akan mendapat notifikasi dan dapat mengupload ulang bukti pembayaran.');
}
</script>
@endsection