<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CampusAdmission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4 fw-bold text-primary">CampusAdmission</h3>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger py-2"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form action="<?php echo BASE_URL; ?>/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Masuk Sistem</button>
                </form>
                
                <div class="text-center mt-3 small">
                    Belum punya akun? <a href="<?php echo BASE_URL; ?>/register" class="text-decoration-none">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>