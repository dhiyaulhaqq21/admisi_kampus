<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pendaftar - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #001f3f; color: white; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; border-left: 3px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background-color: #003366; color: white; border-left: 3px solid #0d6efd; }
        .sidebar .nav-icon { margin-right: 10px; width: 20px; text-align: center; }
        .content-area { padding: 30px; width: 100%; }
        
        /* Instruksi Khusus Saat Halaman Dicetak (Print/Save as PDF) */
        @media print {
            .sidebar, .btn, .no-print { display: none !important; }
            body { background-color: white; }
            .content-area { padding: 0; margin: 0; width: 100%; }
            .card { border: none !important; box-shadow: none !important; }
            .table { width: 100% !important; border-collapse: collapse !important; }
            .table th, .table td { border: 1px solid #000 !important; }
            @page { margin: 1cm; size: landscape; }
        }
    </style>
</head>
<body class="d-flex">

    <div class="sidebar d-flex flex-column no-print" style="width: 250px; flex-shrink: 0;">
        <div class="p-4 text-center border-bottom border-secondary">
            <i class="bi bi-shield-lock-fill display-5 text-warning mb-2 d-block"></i>
            <h5 class="fw-bold m-0">Admin Portal</h5>
        </div>
        <div class="flex-grow-1 mt-3">
            <small class="px-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem;">Menu Utama</small>
            <a href="<?php echo BASE_URL; ?>/admin"><i class="bi bi-speedometer2 nav-icon"></i> Dashboard</a>
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Manajemen PMB</small>
            <a href="<?php echo BASE_URL; ?>/admin/verifikasi_berkas"><i class="bi bi-file-earmark-check nav-icon"></i> Verifikasi Berkas</a>
            <a href="<?php echo BASE_URL; ?>/admin/pembayaran"><i class="bi bi-wallet2 nav-icon"></i> Validasi Pembayaran</a>
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Master Data</small>
            <a href="<?php echo BASE_URL; ?>/admin/info_pmb"><i class="bi bi-megaphone nav-icon"></i> Pengumuman & Jadwal</a>
            <a href="<?php echo BASE_URL; ?>/admin/prodi"><i class="bi bi-journal-bookmark nav-icon"></i> Program Studi</a>
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Laporan</small>
            <a href="<?php echo BASE_URL; ?>/admin/laporan" class="active"><i class="bi bi-printer nav-icon"></i> Ekspor Data Pendaftar</a>
        </div>
        <div class="p-3 border-top border-secondary">
            <a href="<?php echo BASE_URL; ?>/logout" class="text-danger fw-bold"><i class="bi bi-box-arrow-left nav-icon"></i> Logout</a>
        </div>
    </div>

    <div class="content-area">
        
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <div>
                <h2 class="fw-bold text-dark mb-1">Laporan Data Pendaftar</h2>
                <p class="text-muted mb-0 no-print">Pratinjau data keseluruhan sebelum dicetak atau diekspor.</p>
            </div>
            <div class="d-flex gap-2 no-print">
                <button onclick="window.print()" class="btn btn-secondary fw-bold shadow-sm">
                    <i class="bi bi-printer me-2"></i> Cetak PDF
                </button>
                <a href="<?php echo BASE_URL; ?>/admin/laporan_csv" class="btn btn-success fw-bold shadow-sm">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Ekspor CSV
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Nama Pendaftar</th>
                                <th>NISN</th>
                                <th>Program Studi</th>
                                <th>Nilai</th>
                                <th>Status Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($applications)): ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pendaftar.</td></tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($applications as $app): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo $no++; ?></td>
                                        <td class="fw-bold text-primary"><?php echo htmlspecialchars($app['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($app['nisn']); ?></td>
                                        <td><?php echo htmlspecialchars($app['program_name']); ?></td>
                                        <td><?php echo htmlspecialchars($app['average_grade']); ?></td>
                                        <td>
                                            <?php 
                                                $status = strtoupper(str_replace('_', ' ', $app['status']));
                                                // Warna khusus untuk print
                                                $color = ($app['status'] == 'accepted') ? 'text-success' : (($app['status'] == 'rejected') ? 'text-danger' : 'text-warning');
                                            ?>
                                            <span class="fw-bold <?php echo $color; ?>"><?php echo $status; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="text-end mt-4 text-muted small d-none d-print-block">
            <p>Dicetak secara otomatis oleh Sistem Admisi Kampus pada <?php echo date('d M Y H:i'); ?></p>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>