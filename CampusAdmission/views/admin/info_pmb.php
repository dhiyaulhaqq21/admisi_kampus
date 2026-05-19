<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informasi PMB - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #001f3f; color: white; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; border-left: 3px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background-color: #003366; color: white; border-left: 3px solid #0d6efd; }
        .sidebar .nav-icon { margin-right: 10px; width: 20px; text-align: center; }
        .content-area { padding: 30px; width: 100%; }
        .nav-tabs .nav-link { color: #495057; font-weight: 600; border-radius: 0; }
        .nav-tabs .nav-link.active { color: #0d6efd; border-bottom: 3px solid #0d6efd; }
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
            <a href="<?php echo BASE_URL; ?>/admin/pembayaran"><i class="bi bi-wallet2 nav-icon"></i> Validasi Pembayaran</a>
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Master Data</small>
            <a href="<?php echo BASE_URL; ?>/admin/info_pmb" class="active"><i class="bi bi-megaphone nav-icon"></i> Pengumuman & Jadwal</a>
            <a href="<?php echo BASE_URL; ?>/admin/prodi"><i class="bi bi-journal-bookmark nav-icon"></i> Program Studi</a>
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Laporan</small>
            <a href="<?php echo BASE_URL; ?>/admin/laporan"><i class="bi bi-printer nav-icon"></i> Ekspor Data Pendaftar</a>
        </div>
        <div class="p-3 border-top border-secondary">
            <a href="<?php echo BASE_URL; ?>/logout" class="text-danger fw-bold"><i class="bi bi-box-arrow-left nav-icon"></i> Logout</a>
        </div>
    </div>

    <div class="content-area">
        <h2 class="fw-bold text-dark mb-4">Manajemen Informasi PMB</h2>

        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success py-2"><i class="bi bi-check-circle-fill me-2"></i><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger py-2"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
                <ul class="nav nav-tabs" id="infoTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pengumuman-tab" data-bs-toggle="tab" data-bs-target="#pengumuman" type="button" role="tab"><i class="bi bi-megaphone me-1"></i> Pengumuman</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab"><i class="bi bi-calendar3 me-1"></i> Jadwal Kegiatan</button>
                    </li>
                </ul>
            </div>
            
            <div class="card-body p-4">
                <div class="tab-content" id="infoTabsContent">
                    
                    <div class="tab-pane fade show active" id="pengumuman" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-bold text-primary">Daftar Pengumuman Aktif</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPengumuman"><i class="bi bi-plus"></i> Buat Pengumuman</button>
                        </div>
                        <div class="list-group">
                            <?php if(empty($announcements)): ?>
                                <div class="alert alert-light text-center border">Belum ada pengumuman yang dipublikasikan.</div>
                            <?php else: foreach($announcements as $ann): ?>
                                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start p-3">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold fs-5"><?php echo htmlspecialchars($ann['title']); ?></div>
                                        <p class="mb-1 text-muted"><?php echo nl2br(htmlspecialchars($ann['content'])); ?></p>
                                        <small class="text-primary"><i class="bi bi-clock"></i> Dipublikasikan: <?php echo date('d M Y, H:i', strtotime($ann['created_at'])); ?></small>
                                    </div>
                                    <a href="<?php echo BASE_URL; ?>/admin/info_del_pengumuman/<?php echo $ann['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pengumuman ini?')"><i class="bi bi-trash"></i></a>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="jadwal" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-bold text-success">Timeline Jadwal PMB</h5>
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalJadwal"><i class="bi bi-plus"></i> Tambah Jadwal</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Berakhir</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($schedules)): ?>
                                        <tr><td colspan="4" class="text-center py-3 text-muted">Jadwal belum dikonfigurasi.</td></tr>
                                    <?php else: foreach($schedules as $sch): ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo htmlspecialchars($sch['activity_name']); ?></td>
                                            <td><span class="badge bg-primary fs-6"><?php echo date('d M Y', strtotime($sch['start_date'])); ?></span></td>
                                            <td><span class="badge bg-danger fs-6"><?php echo date('d M Y', strtotime($sch['end_date'])); ?></span></td>
                                            <td class="text-center">
                                                <a href="<?php echo BASE_URL; ?>/admin/info_del_jadwal/<?php echo $sch['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPengumuman" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Buat Pengumuman Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo BASE_URL; ?>/admin/info_add_pengumuman" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Pengumuman</label>
                            <input type="text" name="title" class="form-control" required placeholder="Contoh: Perpanjangan Masa Pendaftaran">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Isi Pengumuman</label>
                            <textarea name="content" class="form-control" rows="4" required placeholder="Tuliskan detail pengumuman di sini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Publikasikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalJadwal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Tambah Jadwal Kegiatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo BASE_URL; ?>/admin/info_add_jadwal" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kegiatan</label>
                            <input type="text" name="activity_name" class="form-control" required placeholder="Contoh: Tes Wawancara Gelombang 1">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Berakhir</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold text-white">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>