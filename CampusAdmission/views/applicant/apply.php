<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran - CampusAdmission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <span class="navbar-brand fw-bold">CampusAdmission</span>
            <div class="d-flex">
                <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-outline-light btn-sm me-2">Biodata</a>
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

                <?php if ($application): ?>
                    <div class="card shadow-sm border-0 border-top border-primary border-4">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Status Pendaftaran Anda</h4>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%" class="text-muted">Program Studi</th>
                                    <td class="fw-bold"><?php echo $application['program_name']; ?></td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Status</th>
                                    <td>
                                        <span class="badge bg-<?php echo ($application['status'] == 'accepted') ? 'success' : (($application['status'] == 'rejected') ? 'danger' : 'warning text-dark'); ?> fs-6">
                                            <?php echo strtoupper(str_replace('_', ' ', $application['status'])); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Dokumen</th>
                                    <td><a href="<?php echo BASE_URL . '/' . $application['document_url']; ?>" class="btn btn-sm btn-outline-secondary" target="_blank">📄 Lihat Berkas</a></td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Integritas Data (Hash)</th>
                                    <td><code class="bg-dark text-light p-1 rounded small"><?php echo $application['document_hash']; ?></code></td>
                                </tr>
                            </table>
                            <div class="alert alert-info mt-3 mb-0 small">
                                ℹ️ Pendaftaran Anda sedang diproses. Integritas dokumen Anda dilindungi secara kriptografis.
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white pt-4 pb-0 border-0">
                            <h4 class="card-title text-primary">Pilih Program Studi</h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="<?php echo BASE_URL; ?>/submit_application" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Program Studi Pilihan</label>
                                    <select name="program_id" class="form-select" required>
                                        <option value="">-- Pilih Prodi --</option>
                                        <?php foreach($programs as $prog): ?>
                                            <option value="<?php echo $prog['id']; ?>"><?php echo $prog['name']; ?> (Kuota: <?php echo $prog['quota']; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nilai Rata-rata Ijazah/Rapor</label>
                                    <input type="number" step="0.01" name="average_grade" max="100" min="0" class="form-control" placeholder="Contoh: 85.50" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Unggah Scan Ijazah/Identitas</label>
                                    <input type="file" name="document" class="form-control" accept=".pdf, .jpg, .jpeg, .png" required>
                                    <div class="form-text">Maksimal 2MB. Format: PDF, JPG, PNG.</div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-bold">Kirim Pendaftaran</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>