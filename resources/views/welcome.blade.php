@extends('layouts.app')

@section('title', 'Hilaw - Solusi Hukum Terpercaya untuk Anda')
@section('keywords', 'konsultasi hukum, pengacara, bantuan hukum, hukum pidana, hukum perdata')
@section('description', 'Hilaw menyediakan layanan konsultasi hukum profesional dan terpercaya. Tim pengacara berpengalaman siap membantu menyelesaikan masalah hukum Anda.')

@push('styles')
<style>
/* General font size optimizations */
body {
    font-size: 0.85rem;
}

/* Carousel optimizations */
.carousel-caption h1 {
    font-size: 1.5rem !important;
    line-height: 1.2;
    color: white !important;
}

.carousel-caption .btn {
    font-size: 0.85rem !important;
    padding: 0.6rem 1.2rem !important;
}

/* Carousel controls styling - FIXED */
.carousel-control-prev,
.carousel-control-next {
    width: 50px !important;
    height: 50px !important;
    background-color: rgba(244, 165, 56, 0.9) !important;
    border: 2px solid var(--orange) !important;
    border-radius: 50% !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    opacity: 0.9 !important;
    z-index: 10 !important;
}

.carousel-control-prev {
    left: 20px !important;
}

.carousel-control-next {
    right: 20px !important;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: var(--orange) !important;
    opacity: 1 !important;
    border-color: var(--orange) !important;
}

/* Fixed carousel icons with visible arrows */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 24px !important;
    height: 24px !important;
    background-image: none !important;
    background-color: transparent !important;
    border: none !important;
    font-family: Arial, sans-serif !important;
    font-size: 28px !important;
    font-weight: 900 !important;
    color: white !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    line-height: 1 !important;
}

.carousel-control-prev-icon {
    margin-left: -2px;
}

.carousel-control-next-icon {
    margin-right: -2px;
}

.carousel-control-prev-icon::after {
    content: "❮" !important;
    color: white !important;
    font-size: 24px !important;
    font-weight: 900 !important;
}

.carousel-control-next-icon::after {
    content: "❯" !important;
    color: white !important;
    font-size: 24px !important;
    font-weight: 900 !important;
}

/* Top features section */
.top-feature h4 {
    font-size: 1rem !important;
    margin-bottom: 0.5rem !important;
    color: var(--primary-green) !important;
}

.top-feature span {
    font-size: 0.8rem !important;
}

.top-feature .btn-lg-square {
    width: 50px !important;
    height: 50px !important;
}

.top-feature .fa {
    font-size: 1.2rem !important;
    color: var(--orange) !important;
}

/* About section optimizations */
.display-1 {
    font-size: 3rem !important;
    color: var(--orange) !important;
}

.display-5 {
    font-size: 1.5rem !important;
    color: var(--primary-green) !important;
}

.about-content p {
    font-size: 0.85rem !important;
}

.about-content .btn {
    font-size: 0.85rem !important;
    padding: 0.6rem 1rem !important;
}

.border-start h4 {
    font-size: 1rem !important;
    color: var(--primary-green) !important;
}

.border-start span {
    font-size: 0.8rem !important;
}

.fa-3x {
    font-size: 2rem !important;
    color: var(--orange) !important;
}

/* Facts section */
.facts .display-4 {
    font-size: 2.5rem !important;
}

.facts .fs-5 {
    font-size: 0.9rem !important;
}

/* Features section */
.features .fs-5 {
    font-size: 0.95rem !important;
    color: var(--orange) !important;
}

.features .display-5 {
    font-size: 1.4rem !important;
    color: var(--primary-green) !important;
}

.features p {
    font-size: 0.85rem !important;
}

.features .btn {
    font-size: 0.85rem !important;
    padding: 0.6rem 1rem !important;
}

.features .btn-square {
    width: 70px !important;
    height: 70px !important;
}

.features .btn-square .fa-3x {
    font-size: 1.8rem !important;
    color: var(--orange) !important;
}

.features h4 {
    font-size: 0.95rem !important;
    color: var(--primary-green) !important;
}

/* Pengacara section - Consultation style layout */
.lawyer-card {
    transition: all 0.3s ease;
    border: 1px solid #eee;
    border-radius: 8px;
    background: #fff;
}

.lawyer-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--orange);
}

.lawyer-photo {
    width: 80px;
    height: 100px;
    object-fit: cover;
    object-position: center top;
    border-radius: 6px;
}

.lawyer-info h6 {
    font-size: 0.95rem !important;
    margin-bottom: 0.25rem;
    color: var(--primary-green) !important;
}

.lawyer-info .text-primary {
    font-size: 0.8rem !important;
    color: var(--orange) !important;
}

.lawyer-details {
    font-size: 0.75rem !important;
}

.status-badge {
    font-size: 0.65rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
}

/* Fixed button colors for lawyer cards */
.btn-action {
    font-size: 0.7rem;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
}

.btn-outline-info {
    color: var(--orange) !important;
    border-color: var(--orange) !important;
}

.btn-outline-info:hover {
    background-color: var(--orange) !important;
    border-color: var(--orange) !important;
    color: white !important;
}

/* Quote/Konsultasi section */
.quote h1 {
    font-size: 1.6rem !important;
    color: var(--primary-green) !important;
}

.quote .form-control {
    font-size: 0.8rem !important;
    padding: 0.6rem 0.75rem !important;
}

.quote label {
    font-size: 0.8rem !important;
    color: var(--primary-green) !important;
}

.quote .btn {
    font-size: 0.85rem !important;
    padding: 0.6rem 1.2rem !important;
}

/* Testimonial carousel controls - Fixed with consistent orange theme */
.testimonial-carousel .owl-nav button,
.testimonial-carousel .owl-nav .owl-prev,
.testimonial-carousel .owl-nav .owl-next,
.owl-carousel .owl-nav button,
.owl-carousel .owl-nav .owl-prev,
.owl-carousel .owl-nav .owl-next {
    width: 50px !important;
    height: 50px !important;
    background-color: #F4A538 !important;
    background: #F4A538 !important;
    border: 2px solid #F4A538 !important;
    border-radius: 50% !important;
    color: white !important;
    font-size: 18px !important;
    margin: 0 5px !important;
    transition: all 0.3s ease !important;
    position: relative !important;
}

.testimonial-carousel .owl-nav button:hover,
.testimonial-carousel .owl-nav .owl-prev:hover,
.testimonial-carousel .owl-nav .owl-next:hover,
.owl-carousel .owl-nav button:hover,
.owl-carousel .owl-nav .owl-prev:hover,
.owl-carousel .owl-nav .owl-next:hover,
.testimonial-carousel .owl-nav button:focus,
.testimonial-carousel .owl-nav .owl-prev:focus,
.testimonial-carousel .owl-nav .owl-next:focus,
.owl-carousel .owl-nav button:focus,
.owl-carousel .owl-nav .owl-prev:focus,
.owl-carousel .owl-nav .owl-next:focus,
.testimonial-carousel .owl-nav button:active,
.testimonial-carousel .owl-nav .owl-prev:active,
.testimonial-carousel .owl-nav .owl-next:active,
.owl-carousel .owl-nav button:active,
.owl-carousel .owl-nav .owl-prev:active,
.owl-carousel .owl-nav .owl-next:active {
    background-color: #E6941F !important;
    background: #E6941F !important;
    border-color: #E6941F !important;
    transform: scale(1.05) !important;
    color: white !important;
}

/* Force override for owl carousel specific classes */
.owl-theme .owl-nav [class*='owl-']:hover,
.owl-theme .owl-nav [class*='owl-']:focus,
.owl-theme .owl-nav [class*='owl-']:active {
    background: #E6941F !important;
    color: white !important;
    border-color: #E6941F !important;
}

.owl-theme .owl-nav [class*='owl-'] {
    background: #F4A538 !important;
    color: white !important;
    border: 2px solid #F4A538 !important;
}

/* Additional force override */
.testimonial-carousel .owl-controls .owl-nav div,
.owl-carousel .owl-controls .owl-nav div {
    background-color: #F4A538 !important;
    border: 2px solid #F4A538 !important;
    border-radius: 50% !important;
    width: 50px !important;
    height: 50px !important;
    color: white !important;
}

.testimonial-carousel .owl-controls .owl-nav div:hover,
.owl-carousel .owl-controls .owl-nav div:hover,
.testimonial-carousel .owl-controls .owl-nav div:focus,
.owl-carousel .owl-controls .owl-nav div:focus,
.testimonial-carousel .owl-controls .owl-nav div:active,
.owl-carousel .owl-controls .owl-nav div:active {
    background-color: #E6941F !important;
    border-color: #E6941F !important;
    color: white !important;
}

/* Additional testimonial styling fixes */
.testimonial-item {
    background: white !important;
    border: 1px solid #eee !important;
    border-radius: 8px !important;
    padding: 1.5rem !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
    transition: all 0.3s ease !important;
}

.testimonial-item:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    border-color: var(--orange) !important;
}

.testimonial-item h4 {
    color: var(--primary-green) !important;
    font-size: 1rem !important;
    margin-bottom: 0.25rem !important;
}

.testimonial-item span {
    color: var(--orange) !important;
    font-size: 0.85rem !important;
    font-weight: 500 !important;
}

.testimonial-item p {
    color: #666 !important;
    font-size: 0.9rem !important;
    line-height: 1.6 !important;
    margin-bottom: 1rem !important;
}

/* Section titles */
.section-header .fs-5 {
    color: var(--orange) !important;
}

.section-header .display-5 {
    color: var(--primary-green) !important;
}

/* Call to Action Section */
.cta-section h3 {
    color: white !important;
}

.cta-section p {
    color: rgba(255, 255, 255, 0.9) !important;
}

/* Price text styling */
.text-success {
    color: var(--primary-green) !important;
}

/* Icon styling fixes */
.text-primary {
    color: var(--orange) !important;
}

.bg-primary {
    background-color: var(--primary-green) !important;
}

/* Fixed background colors for CTA and other sections */
.bg-dark-green {
    background-color: var(--primary-green) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-caption h1 {
        font-size: 1.3rem !important;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 45px !important;
        height: 45px !important;
    }
    
    .carousel-control-prev {
        left: 10px !important;
    }
    
    .carousel-control-next {
        right: 10px !important;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        font-size: 18px !important;
    }
    
    .display-1 {
        font-size: 2.2rem !important;
    }
    
    .display-5 {
        font-size: 1.3rem !important;
    }
    
    .lawyer-card {
        margin-bottom: 1rem;
    }
    
    .lawyer-photo {
        width: 70px;
        height: 90px;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.5rem;
    }
}

@media (max-width: 576px) {
    .top-feature .d-flex {
        flex-direction: column;
        text-align: center;
    }
    
    .top-feature .ps-3 {
        padding-left: 0 !important;
        margin-top: 0.5rem;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 40px !important;
        height: 40px !important;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        font-size: 16px !important;
    }
}
</style>
@endpush

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('template/img/carousel-1.jpg') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <h1 class="display-1 text-white mb-4 animated slideInDown">
                                        Solusi Hukum Terpercaya untuk Anda
                                    </h1>
                                    <a href="{{ route('login') }}" class="btn btn-orange py-sm-3 px-sm-4">Konsultasikan Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('template/img/carousel-2.jpg') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7">
                                    <h1 class="display-1 text-white mb-4 animated slideInDown">
                                        Dapatkan Bantuan Hukum dari Ahlinya
                                    </h1>
                                    <a href="{{ route('login') }}" class="btn btn-orange py-sm-3 px-sm-4">Mulai Konsultasi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Berikutnya</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->

   <!-- Top Feature Start -->
    <div class="container-fluid top-feature py-4 pt-lg-0">
        <div class="container py-4 pt-lg-0">
            <div class="row gx-0">
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="bg-white shadow d-flex align-items-center h-100 px-4" style="min-height: 120px;">
                        <div class="d-flex">
                            <div class="flex-shrink-0 btn-lg-square rounded-circle bg-light">
                                <i class="fa fa-times text-orange"></i>
                            </div>
                            <div class="ps-3">
                                <h4>Tanpa Biaya Tersembunyi</h4>
                                <span>Kami transparan dalam seluruh biaya layanan hukum.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="bg-white shadow d-flex align-items-center h-100 px-4" style="min-height: 120px;">
                        <div class="d-flex">
                            <div class="flex-shrink-0 btn-lg-square rounded-circle bg-light">
                                <i class="fa fa-users text-orange"></i>
                            </div>
                            <div class="ps-3">
                                <h4>Tim Profesional & Berpengalaman</h4>
                                <span>Didukung oleh tim ahli hukum dari berbagai bidang.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="bg-white shadow d-flex align-items-center h-100 px-4" style="min-height: 120px;">
                        <div class="d-flex">
                            <div class="flex-shrink-0 btn-lg-square rounded-circle bg-light">
                                <i class="fa fa-phone text-orange"></i>
                            </div>
                            <div class="ps-3">
                                <h4>Layanan Konsultasi 24/7</h4>
                                <span>Siap membantu Anda kapan pun dibutuhkan.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Feature End -->

    <!-- About Start -->
    <div class="container-xxl py-4">
        <div class="container">
            <div class="row g-4 align-items-end">
                <div class="col-lg-3 col-md-5 wow fadeInUp" data-wow-delay="0.1s">
                    <img class="img-fluid rounded" src="{{ asset('template/img/about.jpg') }}">
                </div>
                <div class="col-lg-6 col-md-7 wow fadeInUp" data-wow-delay="0.3s">
                    <h1 class="display-1 mb-0">25</h1>
                    <p class="text-orange mb-3">Tahun Pengalaman</p>
                    <h1 class="display-5 mb-3">Konsultasi Hukum yang Profesional & Terpercaya</h1>
                    <p class="mb-3">
                        Kami telah membantu ribuan klien mendapatkan solusi hukum terbaik. 
                        Dengan tim pengacara berpengalaman dan berdedikasi, kami siap memberikan pelayanan konsultasi yang tepat, cepat, dan akurat.
                    </p>
                    <a class="btn btn-orange py-3 px-4" href="{{ route('login') }}">Hubungi Kami</a>
                </div>
                <div class="col-lg-3 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row g-4">
                        <div class="col-12 col-sm-6 col-lg-12">
                            <div class="border-start ps-3">
                                <i class="fa fa-gavel fa-3x mb-3"></i>
                                <h4 class="mb-2">Terpercaya</h4>
                                <span>Kami telah dipercaya oleh berbagai pihak dalam menangani berbagai kasus hukum.</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-12">
                            <div class="border-start ps-3">
                                <i class="fa fa-user-shield fa-3x mb-3"></i>
                                <h4 class="mb-2">Tim Profesional</h4>
                                <span>Tim pengacara kami terdiri dari ahli hukum berpengalaman dan berdedikasi.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Facts Start -->
    <div class="container-fluid facts my-4 py-4" data-parallax="scroll" data-image-src="{{ asset('template/img/carousel-1.jpg') }}">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-4 text-white" data-toggle="counter-up">1234</h1>
                    <span class="fs-5 fw-semi-bold text-light">Klien Puas</span>
                </div>
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                    <h1 class="display-4 text-white" data-toggle="counter-up">567</h1>
                    <span class="fs-5 fw-semi-bold text-light">Kasus Terselesaikan</span>
                </div>
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-4 text-white" data-toggle="counter-up">{{ $pengacara->count() > 0 ? $pengacara->count() : 25 }}</h1>
                    <span class="fs-5 fw-semi-bold text-light">Pengacara Profesional</span>
                </div>
                <div class="col-sm-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                    <h1 class="display-4 text-white" data-toggle="counter-up">15</h1>
                    <span class="fs-5 fw-semi-bold text-light">Penghargaan Diterima</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Facts End -->

    <!-- Features Start -->
    <div class="container-xxl py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="fs-5 fw-bold section-header">Mengapa Memilih Kami?</p>
                    <h1 class="display-5 mb-3 section-header">Alasan Kenapa Banyak Klien Mempercayai Kami</h1>
                    <p class="mb-3">Kami memberikan layanan konsultasi hukum yang profesional, cepat, dan terpercaya. Didukung oleh tim pengacara berpengalaman, kami siap membantu menyelesaikan berbagai masalah hukum Anda dengan pendekatan yang humanis dan solutif.</p>
                    <a class="btn btn-orange py-3 px-4" href="{{ route('login') }}">Pelajari Lebih Lanjut</a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="row g-3">
                                <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                                    <div class="text-center rounded py-4 px-3" style="box-shadow: 0 0 45px rgba(0,0,0,.08);">
                                        <div class="btn-square bg-light rounded-circle mx-auto mb-3" style="width: 70px; height: 70px;">
                                            <i class="fa fa-balance-scale fa-3x"></i>
                                        </div>
                                        <h4 class="mb-0">Konsultasi Hukum Online</h4>
                                    </div>
                                </div>
                                <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="text-center rounded py-4 px-3" style="box-shadow: 0 0 45px rgba(0,0,0,.08);">
                                        <div class="btn-square bg-light rounded-circle mx-auto mb-3" style="width: 70px; height: 70px;">
                                            <i class="fa fa-user-shield fa-3x"></i>
                                        </div>
                                        <h4 class="mb-0">Tim Profesional</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 wow fadeIn" data-wow-delay="0.7s">
                            <div class="text-center rounded py-4 px-3" style="box-shadow: 0 0 45px rgba(0,0,0,.08);">
                                <div class="btn-square bg-light rounded-circle mx-auto mb-3" style="width: 70px; height: 70px;">
                                    <i class="fa fa-headset fa-3x"></i>
                                </div>
                                <h4 class="mb-0">Respon Cepat 24/7</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->

    <!-- Pengacara Start - Consultation Style Layout -->
    <div id="pengacara" class="container-xxl py-4">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-bold text-orange">Tim Pengacara Kami</p>
                <h1 class="display-5 mb-4 text-dark-green">Bertemu dengan Para Ahli Hukum Profesional</h1>
            </div>
            
            @if($pengacara->count() > 0)
                <div class="row g-3">
                    @foreach($pengacara->take(6) as $index => $lawyer)
                    <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index % 2) * 0.2 }}s">
                        <div class="lawyer-card p-3">
                            <div class="row align-items-center">
                                <!-- Lawyer Photo -->
                                <div class="col-auto">
                                    <div class="position-relative">
                                        @if($lawyer->foto)
                                            <img src="{{ asset('storage/' . $lawyer->foto) }}" 
                                                 alt="{{ $lawyer->name }}"
                                                 class="rounded lawyer-photo">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center rounded lawyer-photo" 
                                                 style="background: linear-gradient(135deg, var(--primary-green), var(--orange)); width: 80px; height: 100px;">
                                                <i class="fas fa-balance-scale text-white" style="font-size: 1.8rem;"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Status Badge -->
                                        @if($lawyer->is_online)
                                            <span class="position-absolute top-0 end-0 status-badge badge bg-success" 
                                                  style="transform: translate(30%, -30%);">
                                                Online
                                            </span>
                                        @else
                                            <span class="position-absolute top-0 end-0 status-badge badge bg-secondary" 
                                                  style="transform: translate(30%, -30%);">
                                                Offline
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Lawyer Info -->
                                <div class="col">
                                    <div class="ps-3 lawyer-info">
                                        <!-- Name and Specialty -->
                                        <div class="mb-2">
                                            <h6 class="fw-bold mb-1">{{ $lawyer->name }}</h6>
                                            <p class="text-orange fw-semibold mb-1">{{ $lawyer->keahlian }}</p>
                                        </div>
                                        
                                        <!-- Details -->
                                        <div class="mb-2 lawyer-details">
                                            @if($lawyer->lulusan_universitas)
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-graduation-cap text-muted me-2" style="width: 12px;"></i>
                                                <small class="text-muted">{{ Str::limit($lawyer->lulusan_universitas, 25) }}</small>
                                            </div>
                                            @endif
                                            
                                            @if($lawyer->pengalaman_tahun)
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-briefcase text-muted me-2" style="width: 12px;"></i>
                                                <small class="text-muted">{{ $lawyer->pengalaman_tahun }} tahun pengalaman</small>
                                            </div>
                                            @endif
                                            
                                            @if($lawyer->alamat)
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt text-muted me-2" style="width: 12px;"></i>
                                                <small class="text-muted">{{ Str::limit($lawyer->alamat, 25) }}</small>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Price and Action -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if($lawyer->tarif_konsultasi)
                                                <div class="text-dark-green fw-bold" style="font-size: 0.85rem;">
                                                    Rp {{ number_format($lawyer->tarif_konsultasi, 0, ',', '.') }}
                                                </div>
                                                <small class="text-muted" style="font-size: 0.7rem;">per konsultasi</small>
                                                @endif
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('login') }}" class="btn btn-outline-info btn-sm btn-action">
                                                    Detail
                                                </a>
                                                @if($lawyer->is_online)
                                                    <a href="{{ route('login') }}" class="btn btn-orange btn-sm btn-action">
                                                        Konsultasi
                                                    </a>
                                                @else
                                                    <button class="btn btn-outline-secondary btn-sm btn-action" disabled>
                                                        Offline
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- View All Button -->
                <div class="text-center mt-4 wow fadeInUp" data-wow-delay="0.1s">
                    <a class="btn btn-orange py-2 px-4 rounded-pill" href="{{ route('login') }}">
                        <i class="fas fa-users me-2"></i>Lihat Semua Pengacara
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="mb-3">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Pengacara Tersedia</h4>
                        <p class="text-muted">Saat ini belum ada pengacara yang terdaftar dan disetujui dalam sistem.</p>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-orange py-2 px-3">
                        <i class="fas fa-envelope me-2"></i>Hubungi Admin
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- Pengacara End -->

    <!-- Quote Start -->
    <div id="konsultasi" class="container-fluid quote my-4 py-4" data-parallax="scroll" data-image-src="{{ asset('template/img/carousel-2.jpg') }}">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="bg-white rounded p-4 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="display-5 text-center mb-4">Konsultasi Gratis</h1>
                        <form method="POST" action="{{ route('login') }}" id="konsultasiForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-light border-0" id="gname" name="nama" placeholder="Nama Lengkap" required>
                                        <label for="gname">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control bg-light border-0" id="gmail" name="email" placeholder="Email" required>
                                        <label for="gmail">Email</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control bg-light border-0" id="cname" name="telepon" placeholder="No. Telepon" required>
                                        <label for="cname">No. Telepon</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <select class="form-control bg-light border-0" id="cage" name="jenis_layanan" required>
                                            <option value="">Pilih Jenis Layanan</option>
                                            <option value="hukum-pidana">Hukum Pidana</option>
                                            <option value="hukum-perdata">Hukum Perdata</option>
                                            <option value="hukum-bisnis">Hukum Bisnis</option>
                                            <option value="hukum-keluarga">Hukum Keluarga</option>
                                            <option value="hukum-properti">Hukum Properti</option>
                                            <option value="hukum-ketenagakerjaan">Hukum Ketenagakerjaan</option>
                                        </select>
                                        <label for="cage">Jenis Layanan</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control bg-light border-0" placeholder="Ceritakan masalah hukum Anda" id="message" name="deskripsi" style="height: 100px" required></textarea>
                                        <label for="message">Deskripsi Masalah</label>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-orange py-2 px-4 rounded-pill" type="submit">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Sekarang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quote End -->

    <!-- Testimonial Start -->
    <div class="container-xxl py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                    <p class="fs-5 fw-bold text-orange">Testimoni</p>
                    <h1 class="display-5 mb-4 text-dark-green">Apa Kata Klien Kami!</h1>
                    <p class="mb-3">Kepuasan klien adalah prioritas utama kami. Berikut adalah testimoni dari beberapa klien yang telah mempercayakan masalah hukum mereka kepada kami.</p>
                    <a class="btn btn-orange py-2 px-3" href="{{ route('login') }}">Lihat Semua Testimoni</a>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="owl-carousel testimonial-carousel">
                        <div class="testimonial-item">
                            <img class="img-fluid rounded mb-3" src="{{ asset('template/img/testimonial-1.jpg') }}" alt="" style="width: 80px; height: 80px; object-fit: cover;">
                            <p class="fs-5">"Pelayanan yang sangat profesional dan memuaskan. Tim Hilaw berhasil menyelesaikan kasus hukum saya dengan cepat dan efektif. Sangat direkomendasikan!"</p>
                            <h4>Ahmad Subagyo</h4>
                            <span>Pengusaha</span>
                        </div>
                        <div class="testimonial-item">
                            <img class="img-fluid rounded mb-3" src="{{ asset('template/img/testimonial-2.jpg') }}" alt="" style="width: 80px; height: 80px; object-fit: cover;">
                            <p class="fs-5">"Konsultasi online yang mudah dan praktis. Pengacara sangat responsif dan memberikan solusi terbaik untuk masalah hukum keluarga saya."</p>
                            <h4>Siti Nurhaliza</h4>
                            <span>Ibu Rumah Tangga</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Call to Action Section -->
    <div class="container-fluid bg-dark-green text-white py-4 my-4 cta-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="mb-2">Butuh Konsultasi Hukum Segera?</h3>
                    <p class="mb-0" style="font-size: 0.9rem;">Jangan tunda masalah hukum Anda. Tim pengacara profesional kami siap membantu 24/7.</p>
                </div>
                <div class="col-lg-4 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
                    <a href="{{ route('login') }}" class="btn btn-orange btn-lg rounded-pill px-4">
                        <i class="fas fa-phone me-2"></i>Hubungi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional JavaScript for smooth scrolling and form handling -->
    <script>
        // Smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Form submission handler - redirect to login
            const konsultasiForm = document.getElementById('konsultasiForm');
            if (konsultasiForm) {
                konsultasiForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show alert message
                    alert('Silakan login terlebih dahulu untuk melakukan konsultasi.');
                    
                    // Redirect to login page
                    window.location.href = '{{ route("login") }}';
                });
            }
        });
        
        // Counter animation for facts section
        function animateCounter() {
            const counters = document.querySelectorAll('[data-toggle="counter-up"]');
            
            counters.forEach(counter => {
                const target = parseInt(counter.innerText);
                const increment = target / 200;
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    counter.innerText = Math.floor(current);
                    
                    if (current >= target) {
                        counter.innerText = target;
                        clearInterval(timer);
                    }
                }, 10);
            });
        }
        
        // Trigger counter animation when facts section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        const factsSection = document.querySelector('.facts');
        if (factsSection) {
            observer.observe(factsSection);
        }
    </script>
@endsection