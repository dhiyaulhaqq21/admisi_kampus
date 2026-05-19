<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - CampusAdmission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid px-4">
            <span class="navbar-brand fw-bold">⚙️ Admin Panel</span>
            <div class="d-flex">
                <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Daftar Pelamar Masuk</h3>
        </div>

        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success py-2"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">Nama Pelamar</th>
                                <th>NISN</th>
                                <th>Prodi</th>
                                <th>Nilai</th>
                                <th>Verifikasi Berkas</th>
                                <th>Status</th>
                                <th class="pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($applications)): ?>
                                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada pendaftar masuk.</td></tr>
                            <?php else: ?>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td class="ps-3 fw-bold"><?php echo htmlspecialchars($app['full_name']); ?></td>
                                        <td><?php echo htmlspecialchars($app['nisn']); ?></td>
                                        <td><?php echo htmlspecialchars($app['program_name']); ?></td>
                                        <td><h5><span class="badge bg-secondary"><?php echo htmlspecialchars($app['average_grade']); ?></span></h5></td>
                                        <td>
                                            <a href="<?php echo BASE_URL . '/' . $app['document_url']; ?>" class="btn btn-sm btn-info text-white mb-1" target="_blank">Lihat Berkas</a><br>
                                            <code class="text-light bg-dark px-1 rounded" style="font-size:0.75rem;" title="<?php echo $app['document_hash']; ?>">
                                                <?php echo substr($app['document_hash'], 0, 12) . '...'; ?>
                                            </code>
                                        </td>
                                        <td>
                                            <?php 
                                                $bg = 'warning text-dark';
                                                if($app['status'] == 'accepted') $bg = 'success';
                                                if($app['status'] == 'rejected') $bg = 'danger';
                                            ?>
                                            <span class="badge bg-<?php echo $bg; ?>">
                                                <?php echo strtoupper(str_replace('_', ' ', $app['status'])); ?>
                                            </span>
                                        </td>
                                        <td class="pe-3">
                                            <form action="<?php echo BASE_URL; ?>/admin_update_status" method="POST" class="d-flex gap-1">
                                                <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                                <select name="status" class="form-select form-select-sm" style="width: auto;">
                                                    <option value="under_review" <?php echo $app['status'] == 'under_review' ? 'selected' : ''; ?>>Review</option>
                                                    <option value="accepted" <?php echo $app['status'] == 'accepted' ? 'selected' : ''; ?>>Terima</option>
                                                    <option value="rejected" <?php echo $app['status'] == 'rejected' ? 'selected' : ''; ?>>Tolak</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
</body>
</html>