<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Secure Campus Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .register-side {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-side {
            background: linear-gradient(135deg, rgba(0, 30, 80, 0.9), rgba(13, 110, 253, 0.9)), url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100 flex-column-reverse flex-lg-row">
            
            <div class="col-lg-6 col-12 register-side">
                <div class="w-100" style="max-width: 420px; padding: 20px;">
                    <div class="text-center mb-4 d-lg-none">
                        <i class="bi bi-shield-lock-fill display-4 text-primary mb-2"></i>
                        <h2 class="fw-bold">CampusAdmission</h2>
                    </div>

                    <h3 class="fw-bold mb-1">Buat Akun Baru</h3>
                    <p class="text-muted mb-4">Mulai perjalanan akademis Anda dengan mendaftar di portal kami.</p>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center py-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>/register" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Alamat Email</label>
                            <div class="input-group mb-3 shadow-sm rounded">
                                <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control py-2" placeholder="nama@email.com" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Password Baru</label>
                            <div class="input-group shadow-sm rounded">
                                <span class="input-group-text"><i class="bi bi-shield-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control py-2" placeholder="Minimal 6 karakter" required>
                            </div>
                            <div class="form-text small"><i class="bi bi-info-circle me-1"></i>Password akan dienkripsi dengan algoritma bcrypt.</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow">
                            <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small">Sudah punya akun? <a href="<?php echo BASE_URL; ?>/login" class="text-primary fw-bold text-decoration-none">Masuk di sini</a></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-flex image-side text-end align-items-end">
                <div class="w-100">
                    <i class="bi bi-cpu-fill display-3 text-warning mb-3 d-block"></i>
                    <h1 class="fw-bold mb-3">Teknologi Terdepan</h1>
                    <p class="lead ms-auto" style="opacity: 0.9; max-width: 80%;">Kami menggunakan infrastruktur digital terkini untuk memastikan proses penerimaan berjalan cepat, transparan, dan aman.</p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>