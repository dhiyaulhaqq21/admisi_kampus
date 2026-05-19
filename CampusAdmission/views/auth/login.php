<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Secure Campus Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .login-side {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-side {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.9), rgba(0, 30, 80, 0.9)), url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
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
        <div class="row h-100">
            <div class="col-lg-6 d-none d-lg-flex image-side">
                <div class="mb-4">
                    <i class="bi bi-shield-lock-fill display-3 text-warning"></i>
                </div>
                <h1 class="fw-bold mb-3">CampusAdmission Portal</h1>
                <p class="lead" style="opacity: 0.9;">Sistem autentikasi terenkripsi. Semua data transmisi dan dokumen dijamin integritasnya.</p>
                <div class="mt-5">
                    <small class="text-white-50"><i class="bi bi-check-circle-fill text-success me-2"></i>Secure Connection</small><br>
                    <small class="text-white-50"><i class="bi bi-check-circle-fill text-success me-2"></i>Data Integrity Protected</small>
                </div>
            </div>

            <div class="col-lg-6 col-12 login-side">
                <div class="w-100" style="max-width: 420px; padding: 20px;">
                    <div class="text-center mb-5 d-lg-none">
                        <i class="bi bi-shield-lock-fill display-4 text-primary mb-2"></i>
                        <h2 class="fw-bold">CampusAdmission</h2>
                    </div>
                    
                    <h3 class="fw-bold mb-1">Selamat Datang Kembali</h3>
                    <p class="text-muted mb-4">Silakan masuk ke akun pendaftar Anda.</p>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center py-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Alamat Email</label>
                            <div class="input-group mb-3 shadow-sm rounded">
                                <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control py-2" placeholder="nama@email.com" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Password</label>
                            <div class="input-group shadow-sm rounded">
                                <span class="input-group-text"><i class="bi bi-key text-muted"></i></span>
                                <input type="password" name="password" class="form-control py-2" placeholder="••••••••" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sistem
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small">Belum punya akun? <a href="<?php echo BASE_URL; ?>/register" class="text-primary fw-bold text-decoration-none">Daftar sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>