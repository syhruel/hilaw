@extends('layouts.app')

@section('title', 'Tentang Kami - Hilaw')
@section('keywords', 'tentang hilaw, profil perusahaan, visi misi, sejarah hilaw')
@section('description', 'Pelajari lebih lanjut tentang Hilaw, visi misi kami, dan komitmen dalam memberikan layanan hukum terbaik di Indonesia.')

@push('styles')
<style>
/* Page specific styles */
.page-header {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('template/img/carousel-1.jpg') }}');
    background-size: cover;
    background-position: center;
    min-height: 300px;
    display: flex;
    align-items: center;
}

.about-content h2 {
    color: var(--primary-green) !important;
    font-size: 1.8rem !important;
    margin-bottom: 1rem;
}

.about-content h3 {
    color: var(--orange) !important;
    font-size: 1.3rem !important;
    margin-bottom: 0.8rem;
}

.about-content p {
    font-size: 0.9rem !important;
    line-height: 1.7;
    margin-bottom: 1rem;
}

.stats-card {
    background: white;
    border-radius: 10px;
    padding: 2rem 1rem;
    text-align: center;
    box-shadow: 0 0 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--orange);
    margin-bottom: 0.5rem;
}

.stats-label {
    color: var(--primary-green);
    font-weight: 500;
}

.timeline-item {
    position: relative;
    padding-left: 3rem;
    margin-bottom: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 15px;
    height: 15px;
    background: var(--orange);
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px var(--orange);
}

.timeline-item::after {
    content: '';
    position: absolute;
    left: 7px;
    top: 15px;
    width: 2px;
    height: calc(100% + 1rem);
    background: #ddd;
}

.timeline-item:last-child::after {
    display: none;
}

.timeline-year {
    font-weight: bold;
    color: var(--orange);
    font-size: 1.1rem;
}

.timeline-content {
    margin-top: 0.5rem;
    color: #666;
}

.team-member {
    text-align: center;
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.team-member:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.team-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 1rem;
    border: 4px solid var(--orange);
}

.team-name {
    color: var(--primary-green);
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.team-position {
    color: var(--orange);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.values-card {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.values-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.values-icon {
    font-size: 3rem;
    color: var(--orange);
    margin-bottom: 1rem;
}

.values-title {
    color: var(--primary-green);
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 1rem;
}
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Tentang Kami</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item text-orange active" aria-current="page">Tentang</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- About Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="about-content">
                    <h3>Selamat Datang di Hilaw</h3>
                    <h2>Solusi Hukum Terpercaya untuk Masa Depan yang Lebih Baik</h2>
                    <p>
                        Hilaw adalah platform konsultasi hukum digital yang berkomitmen memberikan akses mudah dan terjangkau 
                        terhadap layanan hukum berkualitas tinggi. Kami menghubungkan masyarakat dengan para ahli hukum 
                        berpengalaman melalui teknologi modern.
                    </p>
                    <p>
                        Dengan pengalaman lebih dari 10 tahun dalam bidang hukum, kami telah membantu ribuan klien 
                        menyelesaikan berbagai permasalahan hukum mereka dengan pendekatan yang profesional, cepat, dan efektif.
                    </p>
                    <div class="d-flex align-items-center mt-4">
                        <div class="flex-shrink-0 btn-square bg-orange rounded-circle me-3" style="width: 60px; height: 60px;">
                            <i class="fa fa-check text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Tim Profesional & Bersertifikat</h5>
                            <span class="text-muted">Pengacara berpengalaman dengan track record terbukti</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <img class="img-fluid rounded shadow" src="{{ asset('template/img/about.jpg') }}" alt="Tentang Hilaw">
            </div>
        </div>
    </div>
</div>
<!-- About Section End -->

<!-- Stats Section Start -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="stats-card">
                    <div class="stats-number">5000+</div>
                    <div class="stats-label">Klien Dilayani</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="stats-card">
                    <div class="stats-number">98%</div>
                    <div class="stats-label">Tingkat Kepuasan</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="stats-card">
                    <div class="stats-number">50+</div>
                    <div class="stats-label">Pengacara Ahli</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="stats-card">
                    <div class="stats-number">24/7</div>
                    <div class="stats-label">Layanan Online</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Stats Section End -->

<!-- Vision Mission Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Visi & Misi</h3>
            <h2 class="mb-5">Komitmen Kami untuk Indonesia</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="values-card">
                    <div class="values-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4 class="values-title">Visi Kami</h4>
                    <p>
                        Menjadi platform hukum digital terdepan di Indonesia yang memberikan akses mudah, 
                        cepat, dan terjangkau terhadap layanan konsultasi hukum berkualitas tinggi untuk 
                        semua lapisan masyarakat.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="values-card">
                    <div class="values-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h4 class="values-title">Misi Kami</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-orange me-2"></i>Menyediakan konsultasi hukum yang mudah diakses</li>
                        <li class="mb-2"><i class="fas fa-check text-orange me-2"></i>Menghubungkan masyarakat dengan pengacara terbaik</li>
                        <li class="mb-2"><i class="fas fa-check text-orange me-2"></i>Memberikan solusi hukum yang inovatif dan efektif</li>
                        <li><i class="fas fa-check text-orange me-2"></i>Meningkatkan literasi hukum masyarakat Indonesia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vision Mission End -->

<!-- Values Section Start -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Nilai-Nilai Kami</h3>
            <h2 class="mb-5">Prinsip yang Kami Junjung Tinggi</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="values-card text-center">
                    <div class="values-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="values-title">Integritas</h5>
                    <p>Kami berkomitmen untuk selalu jujur, transparan, dan bertanggung jawab dalam setiap layanan yang diberikan.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="values-card text-center">
                    <div class="values-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="values-title">Profesionalisme</h5>
                    <p>Tim kami terdiri dari para ahli hukum berpengalaman yang siap memberikan solusi terbaik.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="values-card text-center">
                    <div class="values-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 class="values-title">Empati</h5>
                    <p>Kami memahami setiap masalah hukum dengan pendekatan yang humanis dan solutif.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Values Section End -->

<!-- History Timeline Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Sejarah Kami</h3>
            <h2 class="mb-5">Perjalanan Hilaw</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline wow fadeInUp" data-wow-delay="0.1s">
                    <div class="timeline-item">
                        <div class="timeline-year">2015</div>
                        <div class="timeline-content">
                            <h5>Pendirian Hilaw</h5>
                            <p>Hilaw didirikan dengan visi menjadi platform hukum digital pertama di Indonesia.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2017</div>
                        <div class="timeline-content">
                            <h5>Peluncuran Platform Online</h5>
                            <p>Meluncurkan platform konsultasi hukum online pertama dengan 10 pengacara partner.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2019</div>
                        <div class="timeline-content">
                            <h5>Ekspansi Nasional</h5>
                            <p>Memperluas jangkauan ke seluruh Indonesia dengan 100+ pengacara berpengalaman.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2022</div>
                        <div class="timeline-content">
                            <h5>Inovasi Teknologi</h5>
                            <p>Mengintegrasikan AI dan machine learning untuk memberikan rekomendasi hukum yang lebih akurat.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-year">2024</div>
                        <div class="timeline-content">
                            <h5>Hilaw Hari Ini</h5>
                            <p>Melayani 5000+ klien dengan tingkat kepuasan 98% dan terus berinovasi untuk masa depan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- History Timeline End -->

<!-- CTA Section Start -->
<div class="container-fluid bg-dark-green text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <h3 class="mb-2">Siap Memulai Konsultasi Hukum?</h3>
                <p class="mb-0">Bergabunglah dengan ribuan klien yang telah mempercayakan masalah hukum mereka kepada kami.</p>
            </div>
            <div class="col-lg-4 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
                <a href="{{ route('login') }}" class="btn btn-orange btn-lg rounded-pill px-4">
                    <i class="fas fa-comments me-2"></i>Mulai Konsultasi
                </a>
            </div>
        </div>
    </div>
</div>
<!-- CTA Section End -->
@endsection