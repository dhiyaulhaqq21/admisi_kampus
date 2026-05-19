<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Berkas - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #001f3f; color: white; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; border-left: 3px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background-color: #003366; color: white; border-left: 3px solid #0d6efd; }
        .sidebar .nav-icon { margin-right: 10px; width: 20px; text-align: center; }
        .content-area { padding: 30px; width: 100%; }
        .hash-block { background-color: #1e1e1e; color: #00ff00; font-family: 'Courier New', monospace; font-size: 0.85rem; padding: 8px; border-radius: 4px; word-break: break-all; }
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
            <a href="<?php echo BASE_URL; ?>/admin"><i class="bi bi-speedometer2 nav-icon"></i> Dashboard</a>
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Manajemen PMB</small>
            <a href="<?php echo BASE_URL; ?>/admin/verifikasi_berkas" class="active"><i class="bi bi-file-earmark-check nav-icon"></i> Verifikasi Berkas</a>
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
        <h2 class="fw-bold text-dark mb-1">Verifikasi Integritas Berkas</h2>
        <p class="text-muted mb-4">Pastikan dokumen fisik sesuai dengan data pendaftaran. Hash kriptografi digunakan untuk melacak orisinalitas file.</p>

        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success py-2"><i class="bi bi-check-circle-fill me-2"></i><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4" width="25%">Data Pendaftar</th>
                                <th width="35%">Integritas Dokumen (SHA-256)</th>
                                <th width="15%" class="text-center">Status</th>
                                <th class="pe-4 text-end" width="25%">Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($applications)): ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada berkas pendaftaran yang masuk.</td></tr>
                            <?php else: ?>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-primary fs-5"><?php echo htmlspecialchars($app['full_name']); ?></div>
                                            <div class="small fw-semibold mt-1"><i class="bi bi-person-badge me-1"></i>NISN: <?php echo htmlspecialchars($app['nisn']); ?></div>
                                            <div class="small text-muted mt-1"><i class="bi bi-journal-text me-1"></i>Prodi: <?php echo htmlspecialchars($app['program_name']); ?></div>
                                            <div class="small text-muted"><i class="bi bi-bar-chart me-1"></i>Nilai Rapot: <strong><?php echo htmlspecialchars($app['average_grade']); ?></strong></div>
                                        </td>
                                        
                                        <td>
                                            <a href="<?php echo BASE_URL . '/' . $app['document_url']; ?>" class="btn btn-sm btn-outline-primary mb-2 shadow-sm" target="_blank">
                                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Buka Dokumen Fisik
                                            </a>
                                            <div class="hash-block shadow-sm">
                                                <?php echo $app['document_hash'] ? $app['document_hash'] : 'Hash tidak ditemukan / Error komputasi'; ?>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php 
                                                $bg = 'warning text-dark';
                                                $icon = 'hourglass-split';
                                                if($app['status'] == 'accepted') { $bg = 'success'; $icon = 'check-circle'; }
                                                if($app['status'] == 'rejected') { $bg = 'danger'; $icon = 'x-circle'; }
                                            ?>
                                            <span class="badge bg-<?php echo $bg; ?> px-2 py-2 w-100 shadow-sm">
                                                <i class="bi bi-<?php echo $icon; ?> me-1"></i> <?php echo strtoupper(str_replace('_', ' ', $app['status'])); ?>
                                            </span>
                                        </td>
                                        
                                        <td class="pe-4 text-end">
                                            <form action="<?php echo BASE_URL; ?>/admin/verifikasi_berkas_update" method="POST" class="d-flex justify-content-end gap-1">
                                                <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                                
                                                <?php if($app['status'] !== 'accepted'): ?>
                                                    <button type="submit" name="status" value="accepted" class="btn btn-success fw-bold text-white shadow-sm" title="Terima Berkas">
                                                        <i class="bi bi-check2-all"></i> Terima
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <?php if($app['status'] !== 'rejected'): ?>
                                                    <button type="submit" name="status" value="rejected" class="btn btn-danger fw-bold shadow-sm" title="Tolak Berkas">
                                                        <i class="bi bi-x-octagon"></i> Tolak
                                                    </button>
                                                <?php endif; ?>
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