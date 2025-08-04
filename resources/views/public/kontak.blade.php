@extends('layouts.app')

@section('title', 'Kontak Kami - Hilaw')
@section('keywords', 'kontak hilaw, hubungi kami, alamat kantor, customer service')
@section('description', 'Hubungi tim Hilaw untuk konsultasi hukum atau pertanyaan lainnya. Kami siap membantu Anda 24/7 melalui berbagai saluran komunikasi.')

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

.contact-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    text-align: center;
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.contact-icon {
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

.contact-title {
    color: var(--primary-green);
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.contact-info {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.contact-action {
    margin-top: auto;
}

.form-section {
    background: white;
    border-radius: 15px;
    padding: 2.5rem;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.form-title {
    color: var(--primary-green);
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    text-align: center;
}

.form-subtitle {
    color: #666;
    font-size: 1rem;
    text-align: center;
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    color: var(--primary-green);
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 0.2rem rgba(244, 165, 56, 0.25);
}

.map-section {
    background: #f8f9fa;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.map-container {
    height: 350px;
    background: #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-size: 1.1rem;
}

.office-info {
    padding: 2rem;
    background: white;
}

.office-title {
    color: var(--primary-green);
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.office-details {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
}

.office-details .detail-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 0.8rem;
}

.office-details .detail-item i {
    width: 20px;
    color: var(--orange);
    margin-right: 0.8rem;
    margin-top: 0.2rem;
}

.social-links {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 1.5rem;
}

.social-link {
    width: 50px;
    height: 50px;
    background: var(--orange);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--dark-orange);
    transform: translateY(-3px);
    color: white;
}

.faq-section {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
}

.faq-title {
    color: var(--primary-green);
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
    text-align: center;
}

.faq-item {
    background: white;
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.faq-question {
    padding: 1rem 1.5rem;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    color: var(--primary-green);
    font-weight: 500;
    transition: all 0.3s ease;
}

.faq-question:hover {
    background: #f8f9fa;
}

.faq-answer {
    padding: 0 1.5rem 1rem;
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
    display: none;
}

.faq-answer.show {
    display: block;
}

.success-alert {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

.success-alert i {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .form-section {
        padding: 1.5rem;
    }
    
    .office-info {
        padding: 1.5rem;
    }
    
    .social-links {
        gap: 0.5rem;
    }
    
    .social-link {
        width: 45px;
        height: 45px;
        font-size: 1rem;
    }
}
</style>
@endpush

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-4 animated slideInDown">Kontak Kami</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item text-orange active" aria-current="page">Kontak</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Contact Info Cards Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h3 class="text-orange">Hubungi Kami</h3>
            <h2 class="mb-5">Berbagai Cara untuk Menghubungi Tim Hilaw</h2>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4 class="contact-title">Telepon</h4>
                    <div class="contact-info">
                        <p>Hubungi kami langsung untuk konsultasi urgent atau informasi cepat.</p>
                        <strong>+62 251 123 4567</strong><br>
                        <small class="text-muted">Senin - Jumat: 08:00 - 20:00<br>Sabtu: 09:00 - 15:00</small>
                    </div>
                    <div class="contact-action">
                        <a href="tel:+622511234567" class="btn btn-orange rounded-pill px-4">
                            <i class="fas fa-phone me-2"></i>Telepon Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4 class="contact-title">Email</h4>
                    <div class="contact-info">
                        <p>Kirim pertanyaan detail atau dokumen melalui email resmi kami.</p>
                        <strong>info@hilaw.com</strong><br>
                        <small class="text-muted">Respon dalam 2-4 jam kerja</small>
                    </div>
                    <div class="contact-action">
                        <a href="mailto:info@hilaw.com" class="btn btn-orange rounded-pill px-4">
                            <i class="fas fa-envelope me-2"></i>Kirim Email
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4 class="contact-title">Live Chat</h4>
                    <div class="contact-info">
                        <p>Chat langsung dengan customer service kami untuk bantuan instant.</p>
                        <strong>Online 24/7</strong><br>
                        <small class="text-muted">Respon rata-rata < 5 menit</small>
                    </div>
                    <div class="contact-action">
                        <a href="{{ route('login') }}" class="btn btn-orange rounded-pill px-4">
                            <i class="fas fa-comments me-2"></i>Mulai Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Info Cards End -->

<!-- Contact Form & Map Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="form-section">
                    @if(session('success'))
                        <div class="success-alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="form-title">Kirim Pesan</h3>
                    <p class="form-subtitle">Isi formulir di bawah ini dan kami akan segera menghubungi Anda</p>
                    
                    <form action="{{ route('kontak.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Subjek *</label>
                                    <input type="text" class="form-control @error('subjek') is-invalid @enderror" 
                                           name="subjek" value="{{ old('subjek') }}" required>
                                    @error('subjek')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Pesan *</label>
                                    <textarea class="form-control @error('pesan') is-invalid @enderror" 
                                              name="pesan" rows="6" required>{{ old('pesan') }}</textarea>
                                    @error('pesan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-orange rounded-pill px-4 w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Map & Office Info -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="map-section">
                    <div class="map-container">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt fa-3x text-orange mb-3"></i>
                            <h5>Lokasi Kantor Kami</h5>
                            <p class="text-muted">Jl. Raya Pajajaran No. 123<br>Bogor, Jawa Barat 16143</p>
                        </div>
                    </div>
                    <div class="office-info">
                        <h4 class="office-title">Informasi Kantor</h4>
                        <div class="office-details">
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <strong>Alamat:</strong><br>
                                    Jl. Raya Pajajaran No. 123<br>
                                    Bogor, Jawa Barat 16143<br>
                                    Indonesia
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <strong>Jam Operasional:</strong><br>
                                    Senin - Jumat: 08:00 - 20:00<br>
                                    Sabtu: 09:00 - 15:00<br>
                                    Minggu: Tutup
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-parking"></i>
                                <div>
                                    <strong>Fasilitas:</strong><br>
                                    Parkir gratis, WiFi, Ruang tunggu ber-AC
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Media Links -->
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Form & Map End -->

<!-- FAQ Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="faq-section wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="faq-title">Pertanyaan yang Sering Diajukan</h3>
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Bagaimana cara memulai konsultasi hukum di Hilaw?
                        <i class="fas fa-chevron-down float-end"></i>
                    </button>
                    <div class="faq-answer">
                        Anda dapat memulai konsultasi dengan mendaftar akun terlebih dahulu, kemudian memilih pengacara sesuai kebutuhan, dan langsung memulai chat atau video call.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Berapa lama waktu respons dari pengacara?
                        <i class="fas fa-chevron-down float-end"></i>
                    </button>
                    <div class="faq-answer">
                        Pengacara kami berkomitmen memberikan respons dalam waktu maksimal 30 menit untuk konsultasi urgent, dan rata-rata 2-4 jam untuk konsultasi reguler.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Apakah konsultasi online sama efektifnya dengan tatap muka?
                        <i class="fas fa-chevron-down float-end"></i>
                    </button>
                    <div class="faq-answer">
                        Ya, konsultasi online terbukti efektif untuk sebagian besar kasus hukum. Pengacara dapat memberikan analisis hukum yang sama mendalam melalui platform digital kami.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Bagaimana sistem pembayaran di Hilaw?
                        <i class="fas fa-chevron-down float-end"></i>
                    </button>
                    <div class="faq-answer">
                        Kami menerima berbagai metode pembayaran termasuk transfer bank, e-wallet, dan kartu kredit. Pembayaran dilakukan setelah Anda memilih paket konsultasi.
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Apakah data dan informasi saya aman?
                        <i class="fas fa-chevron-down float-end"></i>
                    </button>
                    <div class="faq-answer">
                        Keamanan data adalah prioritas utama kami. Semua informasi dilindungi dengan enkripsi tingkat militer dan tunduk pada kerahasiaan advokat-klien.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FAQ Section End -->

<!-- Emergency Contact Start -->
<div class="container-fluid bg-dark-green text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <h3 class="mb-2">Butuh Bantuan Hukum Darurat?</h3>
                <p class="mb-0">Untuk kasus urgent yang memerlukan bantuan segera, hubungi hotline 24/7 kami.</p>
            </div>
            <div class="col-lg-4 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
                <div class="d-flex flex-column flex-lg-row gap-2">
                    <a href="tel:+622511234567" class="btn btn-orange btn-lg rounded-pill px-4">
                        <i class="fas fa-phone me-2"></i>Hotline 24/7
                    </a>
                    <a href="https://wa.me/622511234567" class="btn btn-outline-light btn-lg rounded-pill px-4" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Emergency Contact End -->

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

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                input.classList.add('is-invalid');
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });
});
</script>
@endsection