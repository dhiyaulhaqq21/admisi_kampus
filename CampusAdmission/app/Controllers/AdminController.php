<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Application.php';

class AdminController {
    private $appModel;

    public function __construct() {
        // Proteksi Lapis Ganda: Harus login DAN harus berstatus admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            die("Akses Ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.");
        }
        $this->appModel = new Application();
    }

    // Tampilkan tabel pelamar
    public function dashboard() {
        $applications = $this->appModel->getAllApplications();
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    // Proses Terima/Tolak
    public function changeStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $application_id = filter_var($_POST['application_id'], FILTER_SANITIZE_NUMBER_INT);
            $new_status = $_POST['status']; // 'accepted' atau 'rejected'

            // Validasi input status agar aman dari manipulasi
            if (in_array($new_status, ['accepted', 'rejected', 'under_review'])) {
                if ($this->appModel->updateStatus($application_id, $new_status)) {
                    $_SESSION['success_msg'] = "Status pendaftaran berhasil diperbarui.";
                } else {
                    $_SESSION['error_msg'] = "Gagal memperbarui status.";
                }
            }
            
            header("Location: " . BASE_URL . "/admin");
            exit;
        }
    }
}