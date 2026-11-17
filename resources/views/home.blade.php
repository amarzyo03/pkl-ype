<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-PKL | SMK YPE Kroya</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* Variabel Tema Warna Biru Laut & Putih Minimalis */
        :root {
            --ocean-primary: #005A9C;
            --ocean-medium: #0077B6;
            --ocean-soft: #EBF5FB;
            --bg-light: #F8FAFC;
            --white-pure: #FFFFFF;
            --text-dark: #1E293B;
            --text-muted: #64748B;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Bersih */
        .navbar-minimal {
            background-color: var(--white-pure);
            border-bottom: 1px solid #E2E8F0;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background-color: var(--ocean-primary);
            color: var(--white-pure);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .nav-link-home {
            color: var(--ocean-primary) !important;
            font-weight: 600;
            padding: 0.45rem 1rem !important;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .nav-link-home:hover {
            background-color: var(--ocean-soft);
        }

        /* Tombol Utama Biru Laut */
        .btn-ocean {
            background-color: var(--ocean-primary);
            color: var(--white-pure);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-ocean:hover {
            background-color: var(--ocean-medium);
            color: var(--white-pure);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 90, 156, 0.22);
        }

        /* Hero Section Sederhana */
        .hero-minimal {
            background: linear-gradient(135deg, var(--ocean-primary) 0%, var(--ocean-medium) 100%);
            color: var(--white-pure);
            padding: 6.5rem 0 4.5rem;
        }

        /* Kartu Fitur Ringkas */
        .feature-card-minimal {
            background-color: var(--white-pure);
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 1.75rem 1.5rem;
            height: 100%;
            transition: all 0.25s ease;
        }

        .feature-card-minimal:hover {
            border-color: var(--ocean-medium);
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 90, 156, 0.08);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: var(--ocean-soft);
            color: var(--ocean-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        /* Animasi Kemunculan Halus */
        .fade-in-up {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Footer Sederhana */
        .footer-minimal {
            margin-top: auto;
            background-color: var(--white-pure);
            border-top: 1px solid #E2E8F0;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <!-- 1. NAVBAR BERSIH -->
    <nav class="navbar navbar-expand-md navbar-minimal fixed-top py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#home" style="color: var(--ocean-primary);">
                <span class="brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
                <span>SMK YPE Kroya</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-md-center gap-2 mt-2 mt-md-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-home active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="/app-pkl/auth" class="btn btn-ocean px-3 py-2 w-100 w-md-auto">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION SEDERHANA DI TENGAH -->
    <header id="home" class="hero-minimal text-center">
        <div class="container">
            <div class="mx-auto fade-in-up" style="max-width: 680px;">
                <span class="badge rounded-pill bg-white bg-opacity-25 text-white px-3 py-2 mb-3 fw-semibold">
                    SMK YPE Kroya
                </span>
                <h1 class="fw-bold mb-3">Sistem Informasi Praktek Kerja Lapangan</h1>
                <p class="lead opacity-90 mb-4 fs-6">
                    Platform resmi pengelolaan administrasi penempatan industri, pengisian jurnal harian, serta monitoring pelaksanaan PKL siswa SMK YPE Kroya secara daring.
                </p>
            </div>
        </div>
    </header>

    <!-- 3. TIGA KARTU FITUR UTAMA RINGKAS -->
    <main class="py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Fitur 1 -->
                <div class="col-md-4 fade-in-up">
                    <div class="feature-card-minimal text-center">
                        <div class="feature-icon">
                            <i class="bi bi-building-check"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--ocean-primary);">Penempatan DUDI</h5>
                        <p class="text-muted small mb-0">Pengajuan dan pendataan lokasi tempat PKL secara daring.</p>
                    </div>
                </div>

                <!-- Fitur 2 -->
                <div class="col-md-4 fade-in-up">
                    <div class="feature-card-minimal text-center">
                        <div class="feature-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--ocean-primary);">Jurnal Harian</h5>
                        <p class="text-muted small mb-0">Pencatatan kegiatan harian siswa selama pelaksanaan PKL.</p>
                    </div>
                </div>

                <!-- Fitur 3 -->
                <div class="col-md-4 fade-in-up">
                    <div class="feature-card-minimal text-center">
                        <div class="feature-icon">
                            <i class="bi bi-clipboard2-check"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--ocean-primary);">Monitoring & Nilai</h5>
                        <p class="text-muted small mb-0">Pemantauan dan evaluasi hasil PKL oleh pembimbing.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- 4. FOOTER SEDERHANA -->
    <footer class="footer-minimal py-3 text-center">
        <div class="container">
            <small>&copy; 2026 <strong>SMK YPE Kroya</strong>. Sistem Informasi Praktek Kerja Lapangan.</small>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vanilla JavaScript Ringan -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const homeLink = document.querySelector('.nav-link-home');
            const navCollapse = document.getElementById('navMenu');
            const animatedItems = document.querySelectorAll('.fade-in-up');

            // 1. Smooth scroll ke atas untuk menu Home & tutup menu mobile otomatis
            if (homeLink) {
                homeLink.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    homeLink.classList.add('active');

                    if (navCollapse && navCollapse.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                        if (bsCollapse) bsCollapse.hide();
                    }
                });
            }

            // 2. Animasi masuk halus saat halaman dimuat
            animatedItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('visible');
                }, 100 * index);
            });
        });
    </script>
</body>
</html>