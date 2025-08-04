@extends('layouts.app')

@section('title', 'Pusat Bantuan - Hilaw')
@section('keywords', 'bantuan hilaw, panduan penggunaan, cara konsultasi, tutorial')
@section('description', 'Pusat bantuan Hilaw dengan panduan lengkap cara menggunakan platform, melakukan konsultasi, dan berbagai tips hukum.')

@push('styles')
<style>
.page-header {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('template/img/carousel-1.jpg') }}');
    background-size: cover;
    background-position: center;
    min-height: 300px;
    display: flex;
    align-items: center;
}

.help-category {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    text-align: center;
}

.help-category:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.help-icon {
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

.help-title {
    color: var(--primary-green);
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.help-description {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.guide-step {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
    position: relative;
}

.step-number {
    position: absolute;
    top: -15px;
    left: 2rem;
    width: 40px;
    height: 40px;
    background: var(--orange);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
}

.step-title {
    color: var(--primary-green);
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 0.8rem;
    margin-top: 0.5rem;
}

.step-content {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
}

.faq-section {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
}

.faq-title {
    color: var(--primary-green);
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
    text-align: center;
}

.faq-item {
    background: white;
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.faq-question {
    padding: 1.2rem 1.5rem;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    color: var(--primary-green);
    font-weight: 500;
    font-size: 1rem;
    transition: all 0.3s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.faq-question:hover {
    background: #f8f9fa;
}

.faq-answer {
    padding: 0 1.5rem 1.2rem;
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
    display: none;
    border-top: 1px solid #f0f0f0;
}

.faq-answer.show {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
    }
    to {
        opacity: 1;
        max-height: 200px;
    }
}

.search-help {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    margin-bottom: 3rem;
}

.search-title {
    color: var(--primary-green);
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
    text-align: center;
}

.search-subtitle {
    color: #666;
    text-align: center;
    margin-bottom: 2rem;
}

.contact-support {
    background: var(--primary-green);
    color: white;
    border-radius: 15px;
    padding: 2.5rem;
    text-align: center;
    margin-top: 3rem;
}

.support-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.support-subtitle {
    margin-bottom: 2rem;
    opacity: 0.9;
}

.support-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.video-tutorial {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.video-tutorial:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.video-thumbnail {
    height: 200px;
    background: linear-gradient(135deg, var(--primary-green), var(--orange));
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.play-button {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--orange);
    cursor: pointer;
    transition: all 0.3s ease;
}

.play-button:hover {
    transform: scale(1.1);
    background: white;
}

.video-info {
    padding: 1.5rem;
}

.video-title {
    color: var(--primary-green);
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.video-duration {
    color: #666;
    font-size: 0.85rem;
}

@media (max-width: 768px) {
    .support-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .support-buttons .btn {
        width: 100%;
        max-width: 250px;
    }
    
    .help-category {
        margin-bottom: 2rem;
    }
}
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Pusat Bantuan</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item text-orange active" aria-current="page">Bantuan</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Search Help Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="search-help wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="search-title">Cari Bantuan</h3>
            <p class="search-subtitle">Ketik kata kunci untuk menemukan jawaban yang Anda butuhkan</p>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Contoh: cara daftar, pembayaran, konsultasi..." id="searchInput">
                        <button class="btn btn-orange btn-lg px-4" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Search Help End -->

<!-- Help Categories Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Kategori Bantuan</h3>
            <h2 class="mb-5">Pilih Topik yang Ingin Anda Pelajari</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="help-category">
                    <div class="help-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h4 class="help-title">Memulai</h4>
                    <p class="help-description">
                        Panduan lengkap untuk mendaftar akun, verifikasi email, dan mengatur profil Anda di Hilaw.
                    </p>
                    <a href="#getting-started" class="btn btn-orange rounded-pill px-4">Pelajari</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="help-category">
                    <div class="help-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4 class="help-title">Konsultasi</h4>
                    <p class="help-description">
                        Cara memilih pengacara, memulai konsultasi, dan tips mendapatkan hasil maksimal dari sesi konsultasi.
                    </p>
                    <a href="#consultation" class="btn btn-orange rounded-pill px-4">Pelajari</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="help-category">
                    <div class="help-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h4 class="help-title">Pembayaran</h4>
                    <p class="help-description">
                        Informasi tentang metode pembayaran, paket layanan, dan cara mengelola tagihan Anda.
                    </p>
                    <a href="#payment" class="btn btn-orange rounded-pill px-4">Pelajari</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Help Categories End -->

<!-- Getting Started Guide Start -->
<div id="getting-started" class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Panduan Memulai</h3>
            <h2 class="mb-5">Langkah Mudah Bergabung dengan Hilaw</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="guide-step">
                    <div class="step-number">1</div>
                    <h5 class="step-title">Daftar Akun</h5>
                    <div class="step-content">
                        <p>Klik tombol "Daftar" di pojok kanan atas. Isi form pendaftaran dengan data yang valid:</p>
                        <ul>
                            <li>Nama lengkap sesuai KTP</li>
                            <li>Email aktif</li>
                            <li>Password minimal 8 karakter</li>
                            <li>Nomor telepon yang dapat dihubungi</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="guide-step">
                    <div class="step-number">2</div>
                    <h5 class="step-title">Verifikasi Email</h5>
                    <div class="step-content">
                        <p>Setelah mendaftar, cek email Anda dan klik link verifikasi. Jika tidak ada di inbox, cek folder spam/junk.</p>
                        <p><strong>Catatan:</strong> Akun harus diverifikasi sebelum dapat menggunakan layanan konsultasi.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="guide-step">
                    <div class="step-number">3</div>
                    <h5 class="step-title">Lengkapi Profil</h5>
                    <div class="step-content">
                        <p>Login ke akun dan lengkapi profil Anda:</p>
                        <ul>
                            <li>Upload foto profil (opsional)</li>
                            <li>Isi alamat lengkap</li>
                            <li>Tambahkan informasi kontak tambahan</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="guide-step">
                    <div class="step-number">4</div>
                    <h5 class="step-title">Mulai Konsultasi</h5>
                    <div class="step-content">
                        <p>Sekarang Anda siap untuk:</p>
                        <ul>
                            <li>Browse daftar pengacara</li>
                            <li>Pilih pengacara sesuai kebutuhan</li>
                            <li>Mulai konsultasi pertama Anda</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Getting Started Guide End -->

<!-- Video Tutorials Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Tutorial Video</h3>
            <h2 class="mb-5">Pelajari Melalui Video Panduan</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="video-tutorial">
                    <div class="video-thumbnail">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <h5 class="video-title">Cara Mendaftar dan Verifikasi Akun</h5>
                        <p class="video-duration">
                            <i class="fas fa-clock me-2"></i>3:45 menit
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="video-tutorial">
                    <div class="video-thumbnail">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <h5 class="video-title">Memilih dan Berkonsultasi dengan Pengacara</h5>
                        <p class="video-duration">
                            <i class="fas fa-clock me-2"></i>5:20 menit
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="video-tutorial">
                    <div class="video-thumbnail">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <h5 class="video-title">Cara Melakukan Pembayaran</h5>
                        <p class="video-duration">
                            <i class="fas fa-clock me-2"></i>2:30 menit
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Video Tutorials End -->

<!-- FAQ Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="faq-section wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="faq-title">Pertanyaan yang Sering Diajukan</h3>
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Apakah layanan Hilaw tersedia 24 jam?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Platform Hilaw dapat diakses 24/7, namun ketersediaan pengacara tergantung pada jadwal masing-masing. Sebagian besar pengacara aktif pada jam kerja (08:00-20:00), namun ada juga yang melayani di luar jam tersebut untuk kasus urgent.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Bagaimana cara memilih pengacara yang tepat?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Pilih pengacara berdasarkan: (1) Keahlian yang sesuai dengan kasus Anda, (2) Pengalaman dan track record, (3) Rating dan review dari klien sebelumnya, (4) Tarif yang sesuai budget, (5) Ketersediaan waktu konsultasi.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Apakah konsultasi pertama gratis?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Kami menawarkan konsultasi singkat gratis (15 menit) untuk pengguna baru. Ini cukup untuk menjelaskan garis besar masalah dan mendapat saran awal. Untuk konsultasi mendalam, berlaku tarif sesuai paket yang dipilih.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Bagaimana jika saya tidak puas dengan layanan?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Kami memiliki garansi kepuasan klien. Jika tidak puas, Anda dapat: (1) Request pengacara lain tanpa biaya tambahan, (2) Komplain melalui customer service untuk mediasi, (3) Refund sesuai syarat dan ketentuan yang berlaku.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Metode pembayaran apa saja yang diterima?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Kami menerima: Transfer bank (BCA, Mandiri, BRI, BNI), E-wallet (OVO, GoPay, DANA, LinkAja), Kartu kredit/debit (Visa, Mastercard), dan Virtual account. Semua transaksi aman dan terenkripsi.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Apakah data saya aman dan rahasia?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Ya, keamanan dan kerahasiaan adalah prioritas utama. Data dilindungi enkripsi SSL 256-bit, tunduk pada kode etik advokat tentang kerahasiaan klien, dan tidak akan dibagikan kepada pihak ketiga tanpa persetujuan Anda.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Bisakah saya mendapat dokumen hukum dari konsultasi?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Ya, setelah konsultasi Anda akan mendapat: (1) Ringkasan konsultasi dan saran hukum, (2) Template dokumen jika diperlukan, (3) Daftar langkah-langkah yang harus diambil, (4) Referensi peraturan yang relevan.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Bagaimana cara mengajukan komplain atau saran?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        Anda dapat menghubungi customer service melalui: (1) Live chat di platform, (2) Email ke info@hilaw.com, (3) Telepon ke (021) 1234-5678, (4) Form komplain di menu "Kontak Kami". Tim kami akan merespons maksimal 24 jam.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FAQ Section End -->

<!-- Contact Support Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="contact-support wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="support-title">Masih Butuh Bantuan?</h3>
            <p class="support-subtitle">Tim customer service kami siap membantu Anda 24/7</p>
            <div class="support-buttons">
                <a href="{{ route('kontak') }}" class="btn btn-orange btn-lg rounded-pill px-4">
                    <i class="fas fa-envelope me-2"></i>Kirim Pesan
                </a>
                <a href="tel:+622511234567" class="btn btn-outline-light btn-lg rounded-pill px-4">
                    <i class="fas fa-phone me-2"></i>Telepon Kami
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                    <i class="fas fa-comments me-2"></i>Live Chat
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Contact Support End -->

<script>
function toggleFaq(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    // Close all other FAQ items
    document.querySelectorAll('.faq-answer').forEach(item => {
        if (item !== answer) {
            item.classList.remove('show');
        }
    });
    
    document.querySelectorAll('.faq-question i').forEach(item => {
        if (item !== icon) {
            item.classList.remove('fa-chevron-up');
            item.classList.add('fa-chevron-down');
        }
    });
    
    // Toggle current FAQ item
    answer.classList.toggle('show');
    
    if (answer.classList.contains('show')) {
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.querySelector('.btn-orange');
    
    function performSearch() {
        const query = searchInput.value.toLowerCase().trim();
        
        if (query === '') {
            alert('Silakan masukkan kata kunci pencarian');
            return;
        }
        
        // Simple search in FAQ items
        const faqItems = document.querySelectorAll('.faq-item');
        let found = false;
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question span').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
            
            if (question.includes(query) || answer.includes(query)) {
                item.style.display = 'block';
                item.style.backgroundColor = '#fff3cd';
                found = true;
                
                // Scroll to first match
                if (!found) {
                    item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                item.style.display = 'none';
            }
        });
        
        if (!found) {
            alert('Tidak ditemukan hasil untuk: ' + query + '\nSilakan hubungi customer service untuk bantuan lebih lanjut.');
            // Reset display
            faqItems.forEach(item => {
                item.style.display = 'block';
                item.style.backgroundColor = '';
            });
        }
    }
    
    searchButton.addEventListener('click', performSearch);
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    // Reset search when input is cleared
    searchInput.addEventListener('input', function() {
        if (this.value === '') {
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                item.style.display = 'block';
                item.style.backgroundColor = '';
            });
        }
    });
    
    // Smooth scrolling for category links
    document.querySelectorAll('a[href^="#"]').forEach(link => {
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
    
    // Video tutorial click handlers
    document.querySelectorAll('.play-button').forEach(button => {
        button.addEventListener('click', function() {
            alert('Video tutorial akan segera tersedia! Untuk sementara, silakan hubungi customer service untuk panduan lebih detail.');
        });
    });
});
</script>
@endsection