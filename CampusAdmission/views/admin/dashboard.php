<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - CampusAdmission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #001f3f; color: white; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; border-left: 3px solid transparent; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #003366; color: white; border-left: 3px solid #0d6efd; }
        .sidebar .nav-icon { margin-right: 10px; width: 20px; text-align: center; }
        .content-area { padding: 30px; width: 100%; overflow-x: hidden; }
        .stat-card { border-radius: 10px; border: none; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-lg { font-size: 2.5rem; opacity: 0.3; }
    </style>
</head>
<body class="d-flex">

    <div class="sidebar d-flex flex-column" style="width: 250px; flex-shrink: 0;">
        <div class="p-4 text-center border-bottom border-secondary">
            <i class="bi bi-shield-lock-fill display-5 text-warning mb-2 d-block"></i>
            <h5 class="fw-bold m-0">Admin Portal</h5>
        </div>
        
        <div class="flex-grow-1 mt-3">
            <small class="px-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem;">Menu Utama</small>
            <a href="<?php echo BASE_URL; ?>/admin" class="active mt-2"><i class="bi bi-speedometer2 nav-icon"></i> Dashboard</a>
            
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Manajemen PMB</small>
            <a href="<?php echo BASE_URL; ?>/admin/verifikasi_berkas"><i class="bi bi-file-earmark-check nav-icon"></i> Verifikasi Berkas</a>
            <a href="<?php echo BASE_URL; ?>/admin/pembayaran"><i class="bi bi-wallet2 nav-icon"></i> Validasi Pembayaran</a>
            
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Master Data</small>
            <a href="<?php echo BASE_URL; ?>/admin/info_pmb"><i class="bi bi-megaphone nav-icon"></i> Pengumuman & Jadwal</a>
            <a href="<?php echo BASE_URL; ?>/admin/prodi"><i class="bi bi-journal-bookmark nav-icon"></i> Program Studi</a>
            
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Laporan</small>
            <a href="<?php echo BASE_URL; ?>/admin/laporan"><i class="bi bi-printer nav-icon"></i> Ekspor Data Pendaftar</a>
        </div>

        <div class="p-3 border-top border-secondary">
            <a href="<?php echo BASE_URL; ?>/logout" class="text-danger fw-bold"><i class="bi bi-box-arrow-left nav-icon"></i> Logout</a>
        </div>
    </div>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Dashboard Overview</h2>
            <div class="d-flex align-items-center">
                <span class="me-3">Halo, <strong>Administrator</strong></span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" class="rounded-circle" width="40" alt="Admin">
            </div>
        </div>

        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card stat-card bg-primary text-white h-100 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Total Pendaftar</h6>
                            <h2 class="fw-bold mb-0"><?php echo count($applications ?? []); ?></h2>
                        </div>
                        <i class="bi bi-people-fill icon-lg text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-warning text-dark h-100 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Menunggu Review</h6>
                            <h2 class="fw-bold mb-0 text-dark">
                                <?php echo count(array_filter($applications ?? [], fn($a) => $a['status'] == 'pending' || $a['status'] == 'under_review')); ?>
                            </h2>
                        </div>
                        <i class="bi bi-hourglass-split icon-lg text-dark"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success text-white h-100 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Diterima</h6>
                            <h2 class="fw-bold mb-0">
                                <?php echo count(array_filter($applications ?? [], fn($a) => $a['status'] == 'accepted')); ?>
                            </h2>
                        </div>
                        <i class="bi bi-check-circle-fill icon-lg text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-info text-white h-100 shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Pembayaran Baru</h6>
                            <h2 class="fw-bold mb-0">0</h2> </div>
                        <i class="bi bi-wallet2 icon-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pt-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-list-columns-reverse me-2"></i>Antrean Verifikasi Berkas</h5>
                <a href="<?php echo BASE_URL; ?>/admin/verifikasi_berkas" class="btn btn-sm btn-outline-primary">Lihat Semua Data</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Pelamar</th>
                                <th>Prodi</th>
                                <th>Hash Integritas</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($applications)): ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data masuk.</td></tr>
                            <?php else: ?>
                                <?php foreach (array_slice($applications, 0, 5) as $app): // Hanya tampilkan 5 terbaru di dashboard ?>
                                    <tr>
                                        <td class="ps-4 fw-bold">
                                            <?php echo htmlspecialchars($app['full_name']); ?>
                                            <div class="small text-muted fw-normal">NISN: <?php echo htmlspecialchars($app['nisn']); ?></div>
                                        </td>
                                        <td><?php echo htmlspecialchars($app['program_name']); ?></td>
                                        <td>
                                            <code class="bg-dark text-light px-2 py-1 rounded small" title="<?php echo $app['document_hash']; ?>">
                                                <?php echo substr($app['document_hash'], 0, 10) . '...'; ?>
                                            </code>
                                        </td>
                                        <td>
                                            <?php 
                                                $badge_class = $app['status'] == 'accepted' ? 'success' : ($app['status'] == 'rejected' ? 'danger' : 'warning text-dark');
                                            ?>
                                            <span class="badge bg-<?php echo $badge_class; ?>">
                                                <?php echo strtoupper(str_replace('_', ' ', $app['status'])); ?>
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <form action="<?php echo BASE_URL; ?>/admin_update_status" method="POST" class="d-inline-block">
                                                <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                                <div class="input-group input-group-sm">
                                                    <select name="status" class="form-select">
                                                        <option value="under_review" <?php echo $app['status'] == 'under_review' ? 'selected' : ''; ?>>Review</option>
                                                        <option value="accepted" <?php echo $app['status'] == 'accepted' ? 'selected' : ''; ?>>Terima</option>
                                                        <option value="rejected" <?php echo $app['status'] == 'rejected' ? 'selected' : ''; ?>>Tolak</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>