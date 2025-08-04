@extends('admin.layouts.app')

@section('title', 'Detail Invoice')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Detail Invoice {{ $invoice->invoice_number }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download mr-1"></i>
                            Download PDF
                        </a>
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Invoice Header Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                                        {{ $invoice->invoice_number }}
                                    </h5>
                                    <p class="card-text mb-1">
                                        <strong>Status:</strong> 
                                        @if($invoice->status == 'issued')
                                            <span class="badge badge-warning">Terbit</span>
                                        @elseif($invoice->status == 'paid')
                                            <span class="badge badge-success">Dibayar</span>
                                        @else
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        @endif
                                    </p>
                                    <p class="card-text mb-0">
                                        <strong>Tanggal Terbit:</strong> {{ $invoice->issued_at->format('d F Y, H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-money-bill-wave mr-2"></i>
                                        Total Invoice
                                    </h5>
                                    <h3 class="mb-1">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</h3>
                                    <p class="card-text mb-0">
                                        <small>Sudah termasuk PPN 11%</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patient & Doctor Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user-injured mr-2"></i>
                                        Informasi Pasien
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Nama:</strong></div>
                                        <div class="col-sm-8">{{ $invoice->user->name }}</div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Email:</strong></div>
                                        <div class="col-sm-8">{{ $invoice->user->email }}</div>
                                    </div>
                                    @if($invoice->user->alamat)
                                    <hr class="my-2">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Alamat:</strong></div>
                                        <div class="col-sm-8">{{ $invoice->user->alamat }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user-md mr-2"></i>
                                        Informasi Dokter
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Nama:</strong></div>
                                        <div class="col-sm-8">{{ $invoice->dokter->name }}</div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Spesialisasi:</strong></div>
                                        <div class="col-sm-8">{{ $invoice->dokter->keahlian ?? 'Dokter Umum' }}</div>
                                    </div>
                                    @if($invoice->dokter->lulusan_universitas)
                                    <hr class="my-2">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Lulusan:</strong></div>
                                        <div class="col-sm-8">{{ $invoice->dokter->lulusan_universitas }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Details -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-comments mr-2"></i>
                                        Detail Konsultasi
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Tanggal Mulai:</strong></div>
                                                <div class="col-sm-7">
                                                    {{ $invoice->consultation->chat_started_at ? $invoice->consultation->chat_started_at->format('d F Y, H:i') . ' WIB' : '-' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Tanggal Selesai:</strong></div>
                                                <div class="col-sm-7">
                                                    {{ $invoice->consultation->chat_ended_at ? $invoice->consultation->chat_ended_at->format('d F Y, H:i') . ' WIB' : '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Durasi:</strong></div>
                                                <div class="col-sm-7">
                                                    @if($invoice->consultation->chat_started_at && $invoice->consultation->chat_ended_at)
                                                        {{ $invoice->consultation->chat_started_at->diffInMinutes($invoice->consultation->chat_ended_at) }} menit
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-sm-5"><strong>Status:</strong></div>
                                                <div class="col-sm-7">
                                                    <span class="badge badge-success">{{ ucfirst($invoice->consultation->status) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Keluhan Pasien:</strong>
                                            <div class="mt-2 p-3 bg-light border rounded">
                                                {{ $invoice->consultation->keluhan }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Breakdown -->
                    <div class="row mb-4">
                        <div class="col-md-8 offset-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-calculator mr-2"></i>
                                        Rincian Biaya
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Biaya Konsultasi:</strong></td>
                                                    <td class="text-right">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>PPN (11%):</strong></td>
                                                    <td class="text-right">Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr class="border-top">
                                                    <td><strong class="text-primary">TOTAL:</strong></td>
                                                    <td class="text-right"><strong class="text-primary h5">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($invoice->notes)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-sticky-note mr-2"></i>
                                        Catatan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $invoice->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-clock mr-1"></i>
                                Invoice dibuat pada: {{ $invoice->created_at->format('d F Y, H:i') }} WIB
                            </small>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn btn-success">
                                <i class="fas fa-download mr-1"></i>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection