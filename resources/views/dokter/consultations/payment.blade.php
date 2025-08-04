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
                                @if($payment->payment_proof)
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#approvalModal{{ $payment->id }}">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-exclamation-triangle"></i> Bukti belum diupload
                                    </span>
                                @endif
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

<!-- Modal Approval untuk setiap payment -->
@foreach($payments as $payment)
    @if($payment->status == 'pending' && $payment->payment_proof)
    <div class="modal fade" id="approvalModal{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel{{ $payment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel{{ $payment->id }}">
                        <i class="fas fa-check-circle text-success"></i> Konfirmasi Persetujuan Pembayaran
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold mb-3">Detail Pembayaran:</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Pasien:</strong></td>
                                    <td>{{ $payment->consultation->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah:</strong></td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Metode:</strong></td>
                                    <td>{{ $payment->payment_method }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($payment->consultation->durasi)
                                <tr>
                                    <td><strong>Durasi:</strong></td>
                                    <td>{{ $payment->consultation->durasi }} jam</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold mb-3">Bukti Pembayaran:</h6>
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                                     alt="Bukti Pembayaran" 
                                     class="img-fluid rounded border" 
                                     style="max-height: 300px; cursor: pointer;"
                                     onclick="openImageModal('{{ asset('storage/' . $payment->payment_proof) }}')">
                                <p class="mt-2 text-muted small">Klik gambar untuk memperbesar</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($payment->consultation->keluhan)
                    <div class="mt-3">
                        <h6 class="font-weight-bold">Keluhan/Masalah Hukum:</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $payment->consultation->keluhan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <form method="POST" action="{{ route('dokter.payments.approve', $payment->id) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Ya, Setujui Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<!-- Modal untuk memperbesar gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a id="downloadLink" href="" download class="btn btn-primary">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('downloadLink').href = imageSrc;
    $('#imageModal').modal('show');
}

// Sweet Alert konfirmasi (opsional, jika menggunakan SweetAlert)
document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan konfirmasi tambahan jika diperlukan
    const approvalForms = document.querySelectorAll('form[action*="approve"]');
    
    approvalForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Bisa ditambahkan SweetAlert confirmation di sini jika diperlukan
        });
    });
});
</script>

<style>
.modal-lg {
    max-width: 900px;
}

.modal-xl {
    max-width: 1200px;
}

.table-sm td {
    padding: 0.3rem;
    vertical-align: middle;
}

.img-fluid {
    transition: transform 0.2s;
}

.img-fluid:hover {
    transform: scale(1.02);
}

.badge {
    font-size: 0.875em;
}
</style>
@endsection