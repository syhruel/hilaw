@extends('admin.layouts.app')

@section('title', 'Kelola Pembayaran')
@section('page-title', 'Daftar Pembayaran Konsultasi')

@section('content')
@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header" style="background-color: #4a5a4a; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

<!-- Header Section -->
<div class="mb-5">
    <div class="bg-white rounded-3 shadow-sm p-4" style="border-left: 6px solid #4a5a4a;">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="me-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #4a5a4a;">
                            <i class="fas fa-money-bill-wave text-white" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-2" style="color: #4a5a4a;">Kelola Pembayaran</h1>
                        <p class="text-muted mb-0">Kelola dan verifikasi pembayaran konsultasi hukum</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Card -->
<div class="bg-white rounded-3 shadow-sm">
    <!-- Card Header with Filters -->
    <div class="p-4 border-bottom">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="searchInput" 
                           placeholder="Cari berdasarkan nama pasien, dokter, atau status...">
                </div>
            </div>
            <div class="col-md-6">
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="paymentsTable">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th class="fw-semibold text-muted">No</th>
                        <th class="fw-semibold text-muted">Pasien</th>
                        <th class="fw-semibold text-muted">Dokter</th>
                        <th class="fw-semibold text-muted">Waktu Konsultasi</th>
                        <th class="fw-semibold text-muted">Total</th>
                        <th class="fw-semibold text-muted">Status</th>
                        <th class="fw-semibold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $index => $payment)
                        <tr class="border-bottom">
                            <td class="fw-medium">{{ $loop->iteration }}</td>
                            <td class="patient-name">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-medium">{{ $payment->consultation->user->name ?? '-' }}</div>
                                        <small class="text-muted">{{ $payment->consultation->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="doctor-name">
                                <div class="fw-medium">{{ $payment->consultation->dokter->name ?? '-' }}</div>
                                <small class="text-muted">{{ $payment->consultation->dokter->specialization ?? '' }}</small>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $payment->consultation->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $payment->consultation->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <span class="fw-bold" style="color: #4a5a4a;">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="payment-status">
                                @if($payment->status === 'approved')
                                    <span class="badge rounded-pill bg-success px-3 py-2">
                                        <i class="fas fa-check me-1"></i>Disetujui
                                    </span>
                                @elseif($payment->status === 'rejected')
                                    <span class="badge rounded-pill bg-danger px-3 py-2">
                                        <i class="fas fa-times me-1"></i>Ditolak
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($payment->status === 'pending')
                                        <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-success" 
                                                    onclick="return confirm('Yakin setujui pembayaran ini?')"
                                                    data-bs-toggle="tooltip" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <button class="btn btn-sm btn-outline-warning" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $payment->id }}"
                                                data-bs-toggle="tooltip" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    
                                    <button class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $payment->id }}"
                                            data-bs-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Reject Modal -->
                        @if($payment->status === 'pending')
                        <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #4a5a4a;">
                                        <h5 class="modal-title text-white">
                                            <i class="fas fa-times-circle me-2"></i>Tolak Pembayaran
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejection_reason{{ $payment->id }}" class="form-label fw-medium">
                                                    Alasan Penolakan <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" 
                                                        id="rejection_reason{{ $payment->id }}" 
                                                        name="rejection_reason" 
                                                        rows="4" 
                                                        placeholder="Masukkan alasan penolakan pembayaran..."
                                                        required></textarea>
                                                <small class="text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-times-circle me-1"></i>Tolak Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $payment->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white">
                                            <i class="fas fa-trash me-2"></i>Hapus Pembayaran
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                                            <h5 class="mt-3 mb-3">Apakah Anda yakin?</h5>
                                            <p class="text-muted">
                                                Data pembayaran dari <strong>{{ $payment->consultation->user->name ?? 'Pengguna' }}</strong> 
                                                sebesar <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong> 
                                                akan dihapus secara permanen dan tidak dapat dikembalikan.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Batal
                                        </button>
                                        <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash me-1"></i>Ya, Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr id="noDataRow">
                            <td colspan="7" class="text-center py-5">
                                <div>
                                    <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted mt-3">Tidak ada data pembayaran</h5>
                                    <p class="text-muted">Belum ada pembayaran konsultasi yang masuk</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto hide toasts after 5 seconds
    setTimeout(function() {
        $('.toast').toast('hide');
    }, 5000);

    // Search functionality
    $('#searchInput').on('keyup', function() {
        filterTable();
    });

    // Status filter functionality
    $('#statusFilter').on('change', function() {
        filterTable();
    });

    function filterTable() {
        var searchValue = $('#searchInput').val().toLowerCase();
        var statusValue = $('#statusFilter').val().toLowerCase();
        var visibleRowCount = 0;

        $('#paymentsTable tbody tr').each(function() {
            if ($(this).attr('id') === 'noDataRow') {
                return;
            }

            var patientName = $(this).find('.patient-name').text().toLowerCase();
            var doctorName = $(this).find('.doctor-name').text().toLowerCase();
            var statusText = $(this).find('.payment-status').text().toLowerCase();
            var statusClass = '';
            
            // Get status class for filtering
            if ($(this).find('.bg-success').length > 0) {
                statusClass = 'approved';
            } else if ($(this).find('.bg-danger').length > 0) {
                statusClass = 'rejected';
            } else if ($(this).find('.bg-warning').length > 0) {
                statusClass = 'pending';
            }

            var matchesSearch = patientName.includes(searchValue) || 
                              doctorName.includes(searchValue) || 
                              statusText.includes(searchValue);
            
            var matchesStatus = statusValue === '' || statusClass === statusValue;

            if (matchesSearch && matchesStatus) {
                $(this).show();
                visibleRowCount++;
                // Update row number
                $(this).find('td:first').text(visibleRowCount);
            } else {
                $(this).hide();
            }
        });

        // Show/hide no data message
        if (visibleRowCount === 0 && $('#paymentsTable tbody tr').length > 1) {
            if ($('#noSearchResult').length === 0) {
                $('#paymentsTable tbody').append(
                    '<tr id="noSearchResult"><td colspan="7" class="text-center py-5"><div><i class="fas fa-search text-muted" style="font-size: 2rem;"></i><h6 class="text-muted mt-3">Tidak ada data yang sesuai</h6><p class="text-muted">Coba ubah kata kunci pencarian atau filter</p></div></td></tr>'
                );
            }
            $('#noSearchResult').show();
        } else {
            $('#noSearchResult').remove();
        }
    }

    // Confirm delete with enhanced styling
    $('[data-bs-target^="#deleteModal"]').on('click', function() {
        // You can add additional confirmation logic here if needed
    });
});
</script>
@endpush
@endsection