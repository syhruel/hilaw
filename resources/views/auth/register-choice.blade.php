<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Jenis Registrasi - HILAW</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #4a5d4f 0%, #3a4d3f 100%);
            min-height: 100vh;
            margin: 0;
            padding: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-section {
            background: white;
            border-radius: 12px;
            padding: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        
        .logo-img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
        }
        
        .logo-hi { color: #f39c12; }
        .logo-law { color: #2c3e50; }
        
        .page-title {
            color: white;
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .page-subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 12px;
            margin: 0;
        }
        
        .cards-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 15px;
        }
        
        .registration-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .registration-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-left-color: #f39c12;
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        
        .card-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }
        
        .card-description {
            color: #5a6c7d;
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 12px;
        }
        
        .features-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            margin-bottom: 12px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            color: #34495e;
        }
        
        .feature-item i {
            color: #27ae60;
            font-size: 8px;
        }
        
        .register-btn {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(243, 156, 18, 0.3);
        }
        
        .register-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(243, 156, 18, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .back-link a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 11px;
            transition: color 0.3s ease;
        }
        
        .back-link a:hover {
            color: white;
        }
        
        .back-link i {
            margin-right: 5px;
        }
        
        @media (min-width: 576px) {
            .cards-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
            
            .features-list {
                grid-template-columns: 1fr;
            }
            
            .container {
                max-width: 600px;
            }
        }
        
        @media (max-width: 400px) {
            body {
                padding: 8px;
            }
            
            .logo-section {
                padding: 10px;
            }
            
            .logo-img {
                width: 28px;
                height: 28px;
            }
            
            .logo-text {
                font-size: 18px;
            }
            
            .page-title {
                font-size: 18px;
            }
            
            .registration-card {
                padding: 14px;
            }
            
            .card-icon {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
            
            .features-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <img src="{{ asset('template/img/hilaw-logo.png') }}" alt="HiLAW Logo" class="logo-img">
                <h1 class="logo-text">
                    <span class="logo-hi">Hi</span><span class="logo-law">LAW</span>
                </h1>
            </div>
            <h2 class="page-title">Pilih Jenis Registrasi</h2>
            <p class="page-subtitle">Platform konsultasi hukum terpercaya Indonesia</p>
        </div>

        <!-- Registration Cards -->
        <div class="cards-container">
            <!-- User Registration -->
            <div class="registration-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 class="card-title">Pengguna</h3>
                </div>
                <p class="card-description">
                    Konsultasi hukum profesional dengan ahli hukum berpengalaman untuk menyelesaikan masalah hukum Anda.
                </p>
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Ahli hukum tersertifikasi</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Chat real-time</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Riwayat tersimpan</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Biaya transparan</span>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="register-btn">
                    <i class="fas fa-user-plus"></i> Daftar Sebagai Pengguna
                </a>
            </div>

            <!-- Lawyer Registration -->
            <div class="registration-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h3 class="card-title">Ahli Hukum</h3>
                </div>
                <p class="card-description">
                    Bergabung sebagai ahli hukum profesional dan berikan layanan konsultasi kepada klien yang membutuhkan.
                </p>
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Platform terintegrasi</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Jadwal fleksibel</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Pembayaran otomatis</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>Dashboard analitik</span>
                    </div>
                </div>
                <a href="{{ route('register.dokter') }}" class="register-btn">
                    <i class="fas fa-gavel"></i> Daftar Sebagai Ahli Hukum
                </a>
            </div>
        </div>

        <!-- Back Link -->
        <div class="back-link">
            <a href="{{ route('welcome') }}">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>

    <script>
        // Page load animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.registration-card');
            const header = document.querySelector('.header');
            
            // Animate header
            header.style.opacity = '0';
            header.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                header.style.transition = 'all 0.5s ease';
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
            }, 100);
            
            // Animate cards
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 300 + (index * 150));
            });
        });

        // Button click effect
        document.querySelectorAll('.register-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    </script>
</body>
</html>