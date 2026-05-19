<?php
// app/Controllers/AdminController.php
require_once __DIR__ . '/../Models/Application.php';
require_once __DIR__ . '/../Models/Payment.php';

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

    // Tampilkan Halaman Utama Manajemen Prodi
    public function kelolaProdi() {
        $programs = $this->appModel->getPrograms();
        require_once __DIR__ . '/../../views/admin/prodi.php';
    }

    // Proses Tambah Prodi
    public function tambahProdi() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'program_code' => htmlspecialchars($_POST['program_code']),
                'name' => htmlspecialchars($_POST['name']),
                'faculty' => htmlspecialchars($_POST['faculty']),
                'quota' => filter_var($_POST['quota'], FILTER_SANITIZE_NUMBER_INT)
            ];

            if ($this->appModel->addProgram($data)) {
                $_SESSION['success_msg'] = "Program Studi berhasil ditambahkan!";
            } else {
                $_SESSION['error_msg'] = "Gagal menambahkan Program Studi.";
            }
            header("Location: " . BASE_URL . "/admin/prodi");
            exit;
        }
    }

    // Proses Edit Prodi
    public function editProdi() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $_POST['id'],
                'program_code' => htmlspecialchars($_POST['program_code']),
                'name' => htmlspecialchars($_POST['name']),
                'faculty' => htmlspecialchars($_POST['faculty']),
                'quota' => filter_var($_POST['quota'], FILTER_SANITIZE_NUMBER_INT)
            ];

            if ($this->appModel->updateProgram($data)) {
                $_SESSION['success_msg'] = "Data Program Studi berhasil diperbarui!";
            } else {
                $_SESSION['error_msg'] = "Gagal memperbarui data.";
            }
            header("Location: " . BASE_URL . "/admin/prodi");
            exit;
        }
    }

    // Proses Hapus Prodi
    public function hapusProdi($id) {
        if ($this->appModel->deleteProgram($id)) {
            $_SESSION['success_msg'] = "Program Studi berhasil dihapus!";
        } else {
            $_SESSION['error_msg'] = "Gagal menghapus Program Studi karena masih terikat data lain.";
        }
        header("Location: " . BASE_URL . "/admin/prodi");
        exit;
    }

    // ... (di dalam AdminController, ganti placeholder kelolaInfoPMB dengan ini) ...

    public function kelolaInfoPMB() {
        require_once __DIR__ . '/../Models/Info.php';
        $infoModel = new Info();
        
        $announcements = $infoModel->getAnnouncements();
        $schedules = $infoModel->getSchedules();
        
        require_once __DIR__ . '/../../views/admin/info_pmb.php';
    }

    // --- PROSES PENGUMUMAN ---
    public function tambahPengumuman() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../Models/Info.php';
            $infoModel = new Info();
            
            $title = htmlspecialchars($_POST['title']);
            $content = htmlspecialchars($_POST['content']);

            if ($infoModel->addAnnouncement($title, $content)) {
                $_SESSION['success_msg'] = "Pengumuman berhasil dipublikasikan!";
            } else {
                $_SESSION['error_msg'] = "Gagal menyimpan pengumuman.";
            }
            header("Location: " . BASE_URL . "/admin/info_pmb");
            exit;
        }
    }

    public function hapusPengumuman($id) {
        require_once __DIR__ . '/../Models/Info.php';
        $infoModel = new Info();
        if ($infoModel->deleteAnnouncement($id)) $_SESSION['success_msg'] = "Pengumuman dihapus.";
        header("Location: " . BASE_URL . "/admin/info_pmb");
        exit;
    }

    // --- PROSES JADWAL ---
    public function tambahJadwal() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../Models/Info.php';
            $infoModel = new Info();
            
            $activity = htmlspecialchars($_POST['activity_name']);
            $start = $_POST['start_date'];
            $end = $_POST['end_date'];

            if ($infoModel->addSchedule($activity, $start, $end)) {
                $_SESSION['success_msg'] = "Jadwal kegiatan berhasil ditambahkan!";
            } else {
                $_SESSION['error_msg'] = "Gagal menyimpan jadwal.";
            }
            header("Location: " . BASE_URL . "/admin/info_pmb");
            exit;
        }
    }

    public function hapusJadwal($id) {
        require_once __DIR__ . '/../Models/Info.php';
        $infoModel = new Info();
        if ($infoModel->deleteSchedule($id)) $_SESSION['success_msg'] = "Jadwal dihapus.";
        header("Location: " . BASE_URL . "/admin/info_pmb");
        exit;
    }

    // Validasi Pembayaran
    public function kelolaPembayaran() {
        require_once __DIR__ . '/../Models/Payment.php';
        $paymentModel = new Payment();
        
        $payments = $paymentModel->getAllPayments();
        
        require_once __DIR__ . '/../../views/admin/pembayaran.php';
    }

    // Proses Terima/Tolak Pembayaran
    public function updateStatusPembayaran() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../Models/Payment.php';
            $paymentModel = new Payment();

            $payment_id = filter_var($_POST['payment_id'], FILTER_SANITIZE_NUMBER_INT);
            $status = $_POST['status']; // 'verified' atau 'rejected'

            if (in_array($status, ['verified', 'rejected', 'pending'])) {
                if ($paymentModel->updateStatus($payment_id, $status)) {
                    $_SESSION['success_msg'] = "Status pembayaran berhasil diperbarui!";
                } else {
                    $_SESSION['error_msg'] = "Gagal memperbarui status pembayaran.";
                }
            }
            
            header("Location: " . BASE_URL . "/admin/pembayaran");
            exit;
        }
    }

    // Tampilkan Halaman Verifikasi Berkas
    public function verifikasiBerkas() {
        $applications = $this->appModel->getAllApplications();
        require_once __DIR__ . '/../../views/admin/berkas.php';
    }

    // Proses Terima/Tolak Khusus dari Halaman Berkas
    public function updateStatusBerkas() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $application_id = filter_var($_POST['application_id'], FILTER_SANITIZE_NUMBER_INT);
            $new_status = $_POST['status']; 

            if (in_array($new_status, ['accepted', 'rejected', 'under_review'])) {
                if ($this->appModel->updateStatus($application_id, $new_status)) {
                    $_SESSION['success_msg'] = "Status berkas berhasil diperbarui.";
                } else {
                    $_SESSION['error_msg'] = "Gagal memperbarui status.";
                }
            }
            // Redirect kembali ke halaman verifikasi berkas, bukan ke dashboard utama
            header("Location: " . BASE_URL . "/admin/verifikasi_berkas");
            exit;
        }
    }

    // Cetak Laporan Pendaftar
    // Tampilkan Halaman Preview Laporan
    public function cetakLaporan() {
        $applications = $this->appModel->getAllApplications();
        require_once __DIR__ . '/../../views/admin/laporan.php';
    }

    // Proses Generate File CSV (Excel)
    public function exportCSV() {
        $applications = $this->appModel->getAllApplications();
        
        // Memberi tahu browser bahwa ini adalah file CSV yang harus diunduh
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Data_Pendaftar_CampusAdmission_' . date('Y-m-d') . '.csv');
        
        // Membuka output stream
        $output = fopen('php://output', 'w');
        
        // Tulis baris Header kolom
        fputcsv($output, ['No', 'Nama Lengkap', 'NISN', 'Program Studi', 'Nilai Rata-rata', 'Status Verifikasi', 'Hash Dokumen', 'Tanggal Daftar']);
        
        // Tulis baris data
        $no = 1;
        foreach ($applications as $app) {
            fputcsv($output, [
                $no++,
                $app['full_name'],
                $app['nisn'],
                $app['program_name'],
                $app['average_grade'],
                strtoupper(str_replace('_', ' ', $app['status'])),
                $app['document_hash'],
                $app['applied_at']
            ]);
        }
        
        fclose($output);
        exit;
    }
}