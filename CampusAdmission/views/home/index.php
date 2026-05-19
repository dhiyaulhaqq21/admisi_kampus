<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CampusAdmission - Universitas Internasional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            color: white;
            padding: 120px 0;
        }
        .section-title {
            font-weight: 700;
            color: #003366;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #003366;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>">🎓 CampusAdmission</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang Kampus</a></li>
                    <li class="nav-item"><a class="nav-link" href="#programs">Program Studi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#events">Event</a></li>
                </ul>
                <div class="d-flex">
                    <?php if ($isLoggedIn): ?>
                        <a href="<?php echo BASE_URL . ($role === 'admin' ? '/admin' : '/dashboard'); ?>" class="btn btn-outline-light me-2">Dashboard Saya</a>
                        <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-danger">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline-light me-2">Login Portal</a>
                        <a href="<?php echo BASE_URL; ?>/register" class="btn btn-warning fw-bold text-dark">Daftar Sekarang</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Wujudkan Masa Depan Global Anda</h1>
            <p class="lead mb-5">Bergabunglah dengan komunitas akademis kelas dunia. Inovasi, riset, dan teknologi adalah inti dari perjalanan kami.</p>
            <?php if (!$isLoggedIn): ?>
                <a href="<?php echo BASE_URL; ?>/register" class="btn btn-warning btn-lg fw-bold text-dark px-5 py-3 rounded-pill shadow">Mulai Pendaftaran 2026/2027</a>
            <?php endif; ?>
        </div>
    </section>

    <section id="about" class="py-5 bg-white">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-md-4">
                    <h2 class="display-5 fw-bold text-primary">A+</h2>
                    <p class="text-muted fw-bold">Akreditasi Internasional (AACSB & ABET)</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-5 fw-bold text-primary">98%</h2>
                    <p class="text-muted fw-bold">Lulusan Bekerja dalam 6 Bulan</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-5 fw-bold text-primary">50+</h2>
                    <p class="text-muted fw-bold">Mitra Universitas Global</p>
                </div>
            </div>
        </div>
    </section>

    <section id="programs" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Program Unggulan</h2>
            <div class="row g-4">
                
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-body p-5">
                            <span class="badge bg-primary mb-3">Undergraduate (S1)</span>
                            <h4 class="card-title fw-bold">School of Computer Science</h4>
                            <p class="text-muted">Membangun fondasi kuat dalam rekayasa perangkat lunak dan arsitektur sistem.</p>
                            <ul class="list-unstyled mt-3">
                                <li>✔️ B.Sc. in Informatics (Informatika)</li>
                                <li>✔️ B.Sc. in Information Systems</li>
                                <li>✔️ B.Eng. in Internet of Things (IoT) Systems</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm card-hover h-100" style="background-color: #f8f9fa;">
                        <div class="card-body p-5">
                            <span class="badge bg-dark mb-3">Postgraduate (S2)</span>
                            <h4 class="card-title fw-bold">School of Advanced Technology</h4>
                            <p class="text-muted">Program riset intensif untuk para profesional yang ingin mendalami teknologi spesifik.</p>
                            <ul class="list-unstyled mt-3">
                                <li>✔️ M.Sc. in Applied Cryptography & Cybersecurity</li>
                                <li>✔️ M.Sc. in Data Engineering</li>
                                <li>✔️ Master of Tech Management</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="events" class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-center">Event & Riset Terkini</h2>
            <div class="row g-4">
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Cybersecurity">
                        <div class="card-body">
                            <p class="text-muted small mb-1">📅 15 Juni 2026</p>
                            <h5 class="card-title fw-bold">Symposium: Mitigasi Pencurian Data di Ekosistem E-Commerce</h5>
                            <p class="card-text text-muted small">Membahas studi kasus celah keamanan platform digital dan strategi pencegahannya.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="IoT">
                        <div class="card-body">
                            <p class="text-muted small mb-1">📅 22 Juni 2026</p>
                            <h5 class="card-title fw-bold">Workshop: Arsitektur Sensor IoT untuk Smart Campus</h5>
                            <p class="card-text text-muted small">Praktik langsung integrasi perangkat keras dengan sistem jaringan lokal.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Blockchain">
                        <div class="card-body">
                            <p class="text-muted small mb-1">📅 01 Juli 2026</p>
                            <h5 class="card-title fw-bold">Tech Talk: Implementasi Ledger Independen untuk Verifikasi Ijazah</h5>
                            <p class="card-text text-muted small">Seminar pemanfaatan struktur kriptografi dalam menjaga integritas dokumen akademik.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="text-white py-4" style="background-color: #001a33;">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 CampusAdmission. Hak Cipta Dilindungi.</p>
            <small class="text-white-50">Portal Pendaftaran Resmi Universitas</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>