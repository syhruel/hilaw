@extends('admin.layouts.app')

@section('title', 'Kelola Invoice')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        Kelola Invoice
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>
                            Buat Invoice Baru
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" class="row align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label">Cari Invoice</label>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Nomor invoice atau nama pasien..." 
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Terbit</option>
                                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Dibayar</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search mr-1"></i>
                                        Cari
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-redo mr-1"></i>
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Invoice Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 15%">No. Invoice</th>
                                    <th style="width: 15%">Pasien</th>
                                    <th style="width: 15%">Dokter</th>
                                    <th style="width: 12%">Tanggal Terbit</th>
                                    <th style="width: 10%">Total</th>
                                    <th style="width: 8%">Status</th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ ($invoices->currentPage()-1) * $invoices->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $invoice->invoice_number }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $invoice->user->name }}</strong><br>
                                            <small class="text-muted">{{ $invoice->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $invoice->dokter->name }}</strong><br>
                                            <small class="text-muted">{{ $invoice->dokter->keahlian }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $invoice->issued_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @if($invoice->status == 'issued')
                                            <span class="badge badge-warning">Terbit</span>
                                        @elseif($invoice->status == 'paid')
                                            <span class="badge badge-success">Dibayar</span>
                                        @else
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                               class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.invoices.download', $invoice) }}" 
                                               class="btn btn-success btn-sm" title="Download PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="confirmDelete({{ $invoice->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-file-invoice fa-3x mb-3"></i>
                                            <p>Belum ada invoice yang dibuat</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($invoices->hasPages())
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p class="text-muted">
                                Menampilkan {{ $invoices->firstItem() }} - {{ $invoices->lastItem() }} 
                                dari {{ $invoices->total() }} invoice
                            </p>
                        </div>
                        <div class="col-md-6">
                            {{ $invoices->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus invoice ini?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(invoiceId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/invoices/${invoiceId}`;
    $('#deleteModal').modal('show');
}
</script>
@endpush