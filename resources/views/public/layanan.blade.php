@extends('layouts.app')

@section('title', 'Layanan Hukum - Hilaw')
@section('keywords', 'layanan hukum, konsultasi hukum, hukum pidana, hukum perdata, hukum bisnis')
@section('description', 'Hilaw menyediakan berbagai layanan hukum profesional meliputi hukum pidana, perdata, bisnis, keluarga, dan konsultasi online 24/7.')

@push('styles')
<style>
.page-header {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('template/img/carousel-2.jpg') }}');
    background-size: cover;
    background-position: center;
    min-height: 300px;
    display: flex;
    align-items: center;
}

.service-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    border: 2px solid transparent;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    border-color: var(--orange);
}

.service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--orange), var(--dark-orange));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.service-title {
    color: var(--primary-green);
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 1rem;
    text-align: center;
}

.service-description {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    text-align: center;
}

.service-features {
    list-style: none;
    padding: 0;
    margin-bottom: 1.5rem;
}

.service-features li {
    padding: 0.3rem 0;
    font-size: 0.85rem;
    color: #555;
}

.service-features li i {
    color: var(--orange);
    margin-right: 0.5rem;
}

.price-tag {
    background: var(--orange);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.9rem;
    display: inline-block;
    margin-bottom: 1rem;
}

.process-step {
    text-align: center;
    padding: 2rem 1rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
    margin-bottom: 2rem;
}

.process-step:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.step-number {
    width: 50px;
    height: 50px;
    background: var(--orange);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: bold;
    margin: 0 auto 1rem;
}

.step-title {
    color: var(--primary-green);
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 0.8rem;
}

.step-description {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
}

.why-choose-card {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.why-choose-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.why-icon {
    font-size: 3rem;
    color: var(--orange);
    margin-bottom: 1rem;
}

.why-title {
    color: var(--primary-green);
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.pricing-card {
    background: white;
    border-radius: 15px;
    padding: 2.5rem 2rem;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
    height: 100%;
}

.pricing-card.featured {
    border: 3px solid var(--orange);
    transform: scale(1.05);
}

.pricing-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.pricing-card.featured:hover {
    transform: translateY(-10px) scale(1.05);
}

.popular-badge {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--orange);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

.pricing-title {
    color: var(--primary-green);
    font-size: 1.3rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 1rem;
}

.pricing-price {
    text-align: center;
    margin-bottom: 2rem;
}

.price-amount {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--orange);
}

.price-period {
    color: #666;
    font-size: 0.9rem;
}

.pricing-features {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

.pricing-features li {
    padding: 0.5rem 0;
    font-size: 0.9rem;
    color: #555;
}

.pricing-features li i {
    color: var(--orange);
    margin-right: 0.5rem;
}
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Layanan Hukum</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item text-orange active" aria-current="page">Layanan</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Services Overview Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Layanan Kami</h3>
            <h2 class="mb-5">Solusi Hukum Komprehensif untuk Setiap Kebutuhan</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h4 class="service-title">Hukum Pidana</h4>
                    <p class="service-description">
                        Penanganan kasus pidana dengan pendekatan profesional dan strategis untuk melindungi hak-hak Anda.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Konsultasi kasus pidana</li>
                        <li><i class="fas fa-check"></i> Pendampingan penyidikan</li>
                        <li><i class="fas fa-check"></i> Pembelaan di pengadilan</li>
                        <li><i class="fas fa-check"></i> Banding & kasasi</li>
                    </ul>
                    <div class="text-center">
                        <div class="price-tag">Mulai dari Rp 500.000</div>
                        <br>
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">Konsultasi Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="service-title">Hukum Perdata</h4>
                    <p class="service-description">
                        Penyelesaian sengketa perdata, kontrak, dan perjanjian dengan solusi yang menguntungkan semua pihak.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Sengketa kontrak</li>
                        <li><i class="fas fa-check"></i> Wanprestasi</li>
                        <li><i class="fas fa-check"></i> Mediasi & negosiasi</li>
                        <li><i class="fas fa-check"></i> Eksekusi putusan</li>
                    </ul>
                    <div class="text-center">
                        <div class="price-tag">Mulai dari Rp 750.000</div>
                        <br>
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">Konsultasi Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h4 class="service-title">Hukum Bisnis</h4>
                    <p class="service-description">
                        Konsultasi hukum bisnis untuk mendukung pertumbuhan dan melindungi investasi perusahaan Anda.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Pendirian perusahaan</li>
                        <li><i class="fas fa-check"></i> Kontrak bisnis</li>
                        <li><i class="fas fa-check"></i> Merger & akuisisi</li>
                        <li><i class="fas fa-check"></i> Compliance hukum</li>
                    </ul>
                    <div class="text-center">
                        <div class="price-tag">Mulai dari Rp 1.000.000</div>
                        <br>
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">Konsultasi Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4 class="service-title">Hukum Keluarga</h4>
                    <p class="service-description">
                        Penanganan masalah hukum keluarga dengan pendekatan yang sensitif dan solutif.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Perceraian & pembagian harta</li>
                        <li><i class="fas fa-check"></i> Hak asuh anak</li>
                        <li><i class="fas fa-check"></i> Adopsi</li>
                        <li><i class="fas fa-check"></i> Waris & hibah</li>
                    </ul>
                    <div class="text-center">
                        <div class="price-tag">Mulai dari Rp 600.000</div>
                        <br>
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">Konsultasi Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.9s">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h4 class="service-title">Hukum Ketenagakerjaan</h4>
                    <p class="service-description">
                        Solusi hukum untuk hubungan industrial dan perlindungan hak pekerja maupun pengusaha.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Kontrak kerja</li>
                        <li><i class="fas fa-check"></i> PHK & pesangon</li>
                        <li><i class="fas fa-check"></i> Sengketa industrial</li>
                        <li><i class="fas fa-check"></i> Compliance ketenagakerjaan</li>
                    </ul>
                    <div class="text-center">
                        <div class="price-tag">Mulai dari Rp 400.000</div>
                        <br>
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">Konsultasi Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="1.1s">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h4 class="service-title">Konsultasi Online 24/7</h4>
                    <p class="service-description">
                        Layanan konsultasi hukum online yang dapat diakses kapan saja dan di mana saja.
                    </p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Chat real-time</li>
                        <li><i class="fas fa-check"></i> Video consultation</li>
                        <li><i class="fas fa-check"></i> Dokumen digital</li>
                        <li><i class="fas fa-check"></i> Follow-up berkala</li>
                    </ul>
                    <div class="text-center">
                        <div class="price-tag">Mulai dari Rp 200.000</div>
                        <br>
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">Mulai Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Services Overview End -->

<!-- How It Works Start -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Cara Kerja</h3>
            <h2 class="mb-5">Mudah dan Sederhana dalam 4 Langkah</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h5 class="step-title">Daftar & Pilih Pengacara</h5>
                    <p class="step-description">
                        Daftar akun dan pilih pengacara sesuai dengan kebutuhan dan bidang hukum Anda.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h5 class="step-title">Ceritakan Masalah</h5>
                    <p class="step-description">
                        Jelaskan masalah hukum Anda secara detail melalui chat atau video call.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h5 class="step-title">Dapatkan Solusi</h5>
                    <p class="step-description">
                        Terima analisis hukum dan rekomendasi langkah terbaik dari pengacara ahli.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h5 class="step-title">Tindak Lanjut</h5>
                    <p class="step-description">
                        Dapatkan pendampingan berkelanjutan hingga masalah hukum Anda terselesaikan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- How It Works End -->

<!-- Why Choose Us Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Mengapa Hilaw?</h3>
            <h2 class="mb-5">Keunggulan Layanan Kami</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="why-choose-card">
                    <div class="why-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="why-title">Respon Cepat</h5>
                    <p>Dapatkan tanggapan dalam hitungan menit, bukan jam atau hari.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="why-choose-card">
                    <div class="why-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="why-title">Keamanan Terjamin</h5>
                    <p>Data dan informasi Anda dilindungi dengan enkripsi tingkat militer.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="why-choose-card">
                    <div class="why-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h5 class="why-title">Harga Transparan</h5>
                    <p>Tidak ada biaya tersembunyi. Semua tarif jelas dan kompetitif.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="why-choose-card">
                    <div class="why-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h5 class="why-title">Kualitas Terbaik</h5>
                    <p>Pengacara bersertifikat dengan track record dan pengalaman terbukti.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Why Choose Us End -->

<!-- Pricing Plans Start -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Paket Layanan</h3>
            <h2 class="mb-5">Pilih Paket yang Sesuai dengan Kebutuhan Anda</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="pricing-card">
                    <h4 class="pricing-title">Konsultasi Basic</h4>
                    <div class="pricing-price">
                        <span class="price-amount">200K</span>
                        <div class="price-period">per konsultasi</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Chat consultation (30 menit)</li>
                        <li><i class="fas fa-check"></i> Analisis masalah hukum</li>
                        <li><i class="fas fa-check"></i> Rekomendasi langkah awal</li>
                        <li><i class="fas fa-check"></i> Dokumen legal advice</li>
                    </ul>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="btn btn-outline-orange rounded-pill px-4">Pilih Paket</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="pricing-card featured">
                    <div class="popular-badge">Paling Populer</div>
                    <h4 class="pricing-title">Konsultasi Premium</h4>
                    <div class="pricing-price">
                        <span class="price-amount">500K</span>
                        <div class="price-period">per konsultasi</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Video consultation (60 menit)</li>
                        <li><i class="fas fa-check"></i> Analisis mendalam</li>
                        <li><i class="fas fa-check"></i> Draft dokumen hukum</li>
                        <li><i class="fas fa-check"></i> Follow-up 2 minggu</li>
                        <li><i class="fas fa-check"></i> Priority support</li>
                    </ul>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">Pilih Paket</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="pricing-card">
                    <h4 class="pricing-title">Legal Companion</h4>
                    <div class="pricing-price">
                        <span class="price-amount">2M</span>
                        <div class="price-period">per bulan</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Unlimited consultation</li>
                        <li><i class="fas fa-check"></i> Dedicated lawyer</li>
                        <li><i class="fas fa-check"></i> Legal document review</li>
                        <li><i class="fas fa-check"></i> Court representation</li>
                        <li><i class="fas fa-check"></i> 24/7 emergency support</li>
                    </ul>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="btn btn-outline-orange rounded-pill px-4">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pricing Plans End -->

<!-- CTA Section Start -->
<div class="container-fluid bg-dark-green text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <h3 class="mb-2">Butuh Konsultasi Hukum Segera?</h3>
                <p class="mb-0">Jangan tunda masalah hukum Anda. Konsultasikan dengan pengacara ahli kami sekarang juga!</p>
            </div>
            <div class="col-lg-4 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('login') }}" class="btn btn-orange btn-lg rounded-pill px-4 me-2">
                    <i class="fas fa-comments me-2"></i>Chat Sekarang
                </a>
                <a href="{{ route('kontak') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection