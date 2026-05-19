<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Prodi - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #001f3f; color: white; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; border-left: 3px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background-color: #003366; color: white; border-left: 3px solid #0d6efd; }
        .sidebar .nav-icon { margin-right: 10px; width: 20px; text-align: center; }
        .content-area { padding: 30px; width: 100%; }
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
            <a href="<?php echo BASE_URL; ?>/admin/info_pmb"><i class="bi bi-megaphone nav-icon"></i> Pengumuman & Jadwal</a>
            <a href="<?php echo BASE_URL; ?>/admin/prodi" class="active"><i class="bi bi-journal-bookmark nav-icon"></i> Program Studi</a>
            <small class="px-3 mt-4 text-uppercase text-secondary fw-bold d-block" style="font-size: 0.75rem;">Laporan</small>
            <a href="<?php echo BASE_URL; ?>/admin/laporan"><i class="bi bi-printer nav-icon"></i> Ekspor Data Pendaftar</a>
        </div>
        <div class="p-3 border-top border-secondary">
            <a href="<?php echo BASE_URL; ?>/logout" class="text-danger fw-bold"><i class="bi bi-box-arrow-left nav-icon"></i> Logout</a>
        </div>
    </div>

    <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Manajemen Program Studi</h2>
            <button class="btn btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle me-2"></i>Tambah Prodi Baru
            </button>
        </div>

        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success py-2"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger py-2"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Kode Prodi</th>
                            <th>Nama Program Studi</th>
                            <th>Fakultas</th>
                            <th>Kuota Kelas</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($programs)): ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data program studi.</td></tr>
                        <?php else: ?>
                            <?php foreach ($programs as $prog): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-primary"><?php echo htmlspecialchars($prog['program_code']); ?></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($prog['name']); ?></td>
                                    <td><?php echo htmlspecialchars($prog['faculty']); ?></td>
                                    <td><span class="badge bg-secondary fs-6"><?php echo $prog['quota']; ?> Kursi</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-warning me-1 fw-bold text-white btn-edit" 
                                                data-id="<?php echo $prog['id']; ?>"
                                                data-code="<?php echo $prog['program_code']; ?>"
                                                data-name="<?php echo $prog['name']; ?>"
                                                data-faculty="<?php echo $prog['faculty']; ?>"
                                                data-quota="<?php echo $prog['quota']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>/admin/prodi_delete/<?php echo $prog['id']; ?>" 
                                           class="btn btn-sm btn-danger fw-bold" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus prodi ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" patchwork-id="modalTambah" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Program Studi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo BASE_URL; ?>/admin/prodi_add" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Prodi</label>
                            <input type="text" name="program_code" class="form-control" placeholder="Contoh: IF, SI, TE" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Program Studi</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Informatika" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fakultas</label>
                            <input type="text" name="faculty" class="form-control" placeholder="Contoh: Ilmu Komputer" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kuota Mahasiswa</label>
                            <input type="number" name="quota" class="form-control" placeholder="Contoh: 50" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Program Studi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo BASE_URL; ?>/admin/prodi_edit" method="POST">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Prodi</label>
                            <input type="text" name="program_code" id="edit-code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Program Studi</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Fakultas</label>
                            <input type="text" name="faculty" id="edit-faculty" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kuota Mahasiswa</label>
                            <input type="number" name="quota" id="edit-quota" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white fw-bold">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript Sederhana untuk Mengisi Data secara otomatis ke Form Edit Modal saat tombol Edit di-klik
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-code').value = this.dataset.code;
                document.getElementById('edit-name').value = this.dataset.name;
                document.getElementById('edit-faculty').value = this.dataset.faculty;
                document.getElementById('edit-quota').value = this.dataset.quota;
            });
        });
    </script>
</body>
</html>