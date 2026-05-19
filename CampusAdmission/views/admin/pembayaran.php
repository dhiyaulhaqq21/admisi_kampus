<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validasi Pembayaran - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #001f3f; color: white; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; border-left: 3px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background-color: #003366; color: white; border-left: 3px solid #0d6efd; }
        .sidebar .nav-icon { margin-right: 10px; width: 20px; text-align: center; }
        .content-area { padding: 30px; width: 100%; }
        .proof-img { max-height: 60px; cursor: pointer; border-radius: 5px; transition: transform 0.2s; }
        .proof-img:hover { transform: scale(1.1); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
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
            <a href="<?php echo BASE_URL; ?>/admin/verifikasi_berkas"><i class="bi bi-file-earmark-check nav-icon"></i> Verifikasi Berkas</a>
            <a href="<?php echo BASE_URL; ?>/admin/pembayaran" class="active"><i class="bi bi-wallet2 nav-icon"></i> Validasi Pembayaran</a>
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
        <h2 class="fw-bold text-dark mb-4">Validasi Bukti Pembayaran</h2>

        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success py-2"><i class="bi bi-check-circle-fill me-2"></i><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger py-2"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Data Pendaftar</th>
                                <th>Tanggal Upload</th>
                                <th>Nominal (Rp)</th>
                                <th>Bukti Transfer</th>
                                <th>Status</th>
                                <th class="pe-4 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($payments)): ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi pembayaran masuk.</td></tr>
                            <?php else: foreach($payments as $pay): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-primary"><?php echo htmlspecialchars($pay['full_name']); ?></div>
                                        <div class="small text-muted">NISN: <?php echo htmlspecialchars($pay['nisn']); ?></div>
                                    </td>
                                    <td><?php echo date('d M Y, H:i', strtotime($pay['created_at'])); ?></td>
                                    <td class="fw-bold"><?php echo number_format($pay['amount'], 0, ',', '.'); ?></td>
                                    <td>
                                        <a href="<?php echo BASE_URL . '/' . $pay['proof_url']; ?>" target="_blank">
                                            <img src="<?php echo BASE_URL . '/' . $pay['proof_url']; ?>" alt="Bukti" class="proof-img border">
                                        </a>
                                    </td>
                                    <td>
                                        <?php 
                                            $badge = 'warning text-dark';
                                            $icon = 'hourglass-split';
                                            if($pay['status'] == 'verified') { $badge = 'success'; $icon = 'check-circle'; }
                                            if($pay['status'] == 'rejected') { $badge = 'danger'; $icon = 'x-circle'; }
                                        ?>
                                        <span class="badge bg-<?php echo $badge; ?> px-2 py-1">
                                            <i class="bi bi-<?php echo $icon; ?> me-1"></i><?php echo strtoupper($pay['status']); ?>
                                        </span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <?php if($pay['status'] == 'pending'): ?>
                                            <form action="<?php echo BASE_URL; ?>/admin/pembayaran_update" method="POST" class="d-inline-flex gap-1">
                                                <input type="hidden" name="payment_id" value="<?php echo $pay['id']; ?>">
                                                <button type="submit" name="status" value="verified" class="btn btn-sm btn-success fw-bold text-white shadow-sm" title="Verifikasi">
                                                    <i class="bi bi-check2"></i> Sahkan
                                                </button>
                                                <button type="submit" name="status" value="rejected" class="btn btn-sm btn-danger fw-bold shadow-sm" title="Tolak">
                                                    <i class="bi bi-x-lg"></i> Tolak
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?php echo BASE_URL; ?>/admin/pembayaran_update" method="POST">
                                                <input type="hidden" name="payment_id" value="<?php echo $pay['id']; ?>">
                                                <button type="submit" name="status" value="pending" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>