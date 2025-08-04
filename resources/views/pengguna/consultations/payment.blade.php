@extends('pengguna.layouts.app')

@section('title', 'Pembayaran Konsultasi')
@section('page-title', 'Pembayaran')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Pembayaran Konsultasi</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.consultations.index') }}">Konsultasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Payment Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Payment Form -->
            <div class="col-lg-8">
                <div class="bg-light rounded p-5 wow fadeInUp" data-wow-delay="0.1s">
                    <h4 class="mb-4">
                        <i class="fas fa-credit-card text-primary me-2"></i>Form Pembayaran
                    </h4>
                    
                    <form method="POST" action="{{ route('pengguna.consultations.process-payment', $consultation->id) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="Transfer Bank">Transfer Bank (BCA, BNI, Mandiri)</option>
                                <option value="E-Wallet">E-Wallet (OVO, GoPay, DANA)</option>
                                <option value="Cash">Pembayaran Tunai</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="payment_proof" class="form-label fw-bold">Bukti Pembayaran <span class="text-danger">*</span></label>
                            <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*" required>
                            <small class="text-muted">Upload foto bukti pembayaran (JPG, PNG, maksimal 2MB)</small>
                        </div>
                        
                        <div class="mb-4 p-4 bg-warning bg-opacity-10 rounded">
                            <h6 class="text-warning mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>Penting!
                            </h6>
                            <small class="text-muted">
                                Pastikan bukti pembayaran yang diupload jelas dan menunjukkan:
                                <br>• Jumlah pembayaran yang sesuai
                                <br>• Tanggal dan waktu transaksi
                                <br>• Nama pengirim yang jelas
                            </small>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <button type="submit" class="btn btn-primary btn-lg me-md-2">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pembayaran
                            </button>
                            <a href="{{ route('pengguna.consultations.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Payment Details -->
            <div class="col-lg-4">
                <!-- Consultation Details -->
                <div class="bg-light rounded p-4 wow fadeInUp" data-wow-delay="0.2s">
                    <h4 class="mb-4">
                        <i class="fas fa-file-invoice text-primary me-2"></i>Detail Konsultasi
                    </h4>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><strong>Ahli Hukum:</strong></td>
                                    <td>{{ $consultation->dokter->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Spesialisasi:</strong></td>
                                    <td><span class="badge bg-primary">{{ $consultation->dokter->keahlian }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $consultation->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><span class="badge bg-warning">Menunggu Pembayaran</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="text-primary mb-2">Keluhan:</h6>
                        <div class="p-3 bg-white rounded">
                            <p class="mb-0 text-muted small">{{ Str::limit($consultation->keluhan, 150) }}</p>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="p-4 bg-success text-white rounded text-center">
                        <h6 class="text-white mb-1">Total Pembayaran</h6>
                        <h3 class="text-white mb-0">Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</h3>
                    </div>
                </div>
                
                <!-- Payment Instructions -->
                <div class="bg-light rounded p-4 mt-4 wow fadeInUp" data-wow-delay="0.3s">
                    <h5 class="mb-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>Instruksi Pembayaran
                    </h5>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="btn-square rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 14px;">
                            1
                        </div>
                        <small class="text-muted">Lakukan pembayaran sesuai jumlah yang tertera di atas</small>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="btn-square rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 14px;">
                            2
                        </div>
                        <small class="text-muted">Upload bukti pembayaran yang jelas dan lengkap</small>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="btn-square rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 14px;">
                            3
                        </div>
                        <small class="text-muted">Tunggu verifikasi pembayaran dari admin (maksimal 24 jam)</small>
                    </div>
                    
                    <div class="d-flex align-items-start">
                        <div class="btn-square rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 14px;">
                            4
                        </div>
                        <small class="text-muted">Konsultasi akan dimulai setelah pembayaran disetujui</small>
                    </div>
                </div>
                
                <!-- Contact Support -->
                <div class="bg-light rounded p-4 mt-4 wow fadeInUp" data-wow-delay="0.4s">
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-headset me-2"></i>Butuh Bantuan?
                    </h6>
                    <p class="mb-3 text-muted small">Jika mengalami kesulitan dalam pembayaran, hubungi customer service kami:</p>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp: 0812-3456-7890
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-2"></i>Email: support@lawconsult.com
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Payment Section End -->

@endsection