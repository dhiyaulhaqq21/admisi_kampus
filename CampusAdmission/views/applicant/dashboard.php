<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biodata - CampusAdmission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <span class="navbar-brand fw-bold">CampusAdmission</span>
            <div class="d-flex">
                <a href="<?php echo BASE_URL; ?>/apply" class="btn btn-outline-light btn-sm me-2">Pendaftaran Prodi</a>
                <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php if (isset($_SESSION['success_msg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error_msg'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white pt-4 pb-0 border-0">
                        <h4 class="card-title text-primary fw-bold">Lengkapi Biodata Anda</h4>
                        <p class="text-muted small">Pastikan data yang diisi sesuai dengan dokumen asli.</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="<?php echo BASE_URL; ?>/save_profile" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="full_name" class="form-control" value="<?php echo $profile['full_name'] ?? ''; ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">NISN</label>
                                    <input type="text" name="nisn" class="form-control" value="<?php echo $profile['nisn'] ?? ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nomor Telepon/WA</label>
                                    <input type="text" name="phone_number" class="form-control" value="<?php echo $profile['phone_number'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Asal Sekolah (SMA/SMK/MA)</label>
                                <input type="text" name="high_school_name" class="form-control" value="<?php echo $profile['high_school_name'] ?? ''; ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Alamat Domisili</label>
                                <textarea name="home_address" class="form-control" rows="3" required><?php echo $profile['home_address'] ?? ''; ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Simpan Biodata</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>