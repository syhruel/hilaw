@extends('pengguna.layouts.app')

@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran Konsultasi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Pembayaran</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pengguna.consultations.process-payment', $consultation->id) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="E-Wallet">E-Wallet</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Bukti Pembayaran</label>
                        <input type="file" name="payment_proof" class="form-control-file" accept="image/*" required>
                        <small class="form-text text-muted">Upload foto bukti pembayaran (JPG, PNG, max 2MB)</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                    </button>
                    <a href="{{ route('pengguna.consultations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Konsultasi</h3>
            </div>
            <div class="card-body">
                <p><strong>Dokter:</strong> Dr. {{ $consultation->dokter->name }}</p>
                <p><strong>Keahlian:</strong> {{ $consultation->dokter->keahlian }}</p>
                <p><strong>Keluhan:</strong></p>
                <p class="text-muted">{{ Str::limit($consultation->keluhan, 100) }}</p>
                <hr>
                <p><strong>Total Pembayaran:</strong></p>
                <h4 class="text-success">Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</h4>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Instruksi Pembayaran</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    1. Lakukan pembayaran sesuai jumlah yang tertera<br>
                    2. Upload bukti pembayaran yang jelas<br>
                    3. Tunggu persetujuan dari dokter/admin<br>
                    4. Konsultasi akan dimulai setelah pembayaran disetujui
                </p>
            </div>
        </div>
    </div>
</div>
@endsection