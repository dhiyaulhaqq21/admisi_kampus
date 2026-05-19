<?php
// app/Controllers/ApplicantController.php
require_once __DIR__ . '/../Models/Profile.php';

class ApplicantController {
    private $profileModel;

    public function __construct() {
        // Proteksi: Lempar ke login jika belum ada session
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        $this->profileModel = new Profile();
    }

    // Menampilkan halaman dashboard
    public function dashboard() {
        $userId = $_SESSION['user_id'];
        $profile = $this->profileModel->getProfileByUserId($userId);
        
        require_once __DIR__ . '/../../views/applicant/dashboard.php';
    }

    // Memproses data dari form
    public function saveProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'full_name' => htmlspecialchars($_POST['full_name']),
                'nisn' => htmlspecialchars($_POST['nisn']),
                'phone_number' => htmlspecialchars($_POST['phone_number']),
                'home_address' => htmlspecialchars($_POST['home_address']),
                'high_school_name' => htmlspecialchars($_POST['high_school_name'])
            ];

            if ($this->profileModel->saveProfile($data)) {
                $_SESSION['success_msg'] = "Profil berhasil disimpan!";
            } else {
                $_SESSION['error_msg'] = "Gagal menyimpan profil.";
            }
            
            header("Location: " . BASE_URL . "/dashboard");
            exit;
        }
    }

    // Tambahkan fungsi ini di dalam class ApplicantController

    public function apply() {
        require_once __DIR__ . '/../Models/Application.php';
        $appModel = new Application();
        
        // Ambil data prodi dan cek apakah sudah pernah mendaftar
        $programs = $appModel->getPrograms();
        $application = $appModel->getApplicationByUserId($_SESSION['user_id']);
        
        require_once __DIR__ . '/../../views/applicant/apply.php';
    }

    public function submitApplication() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $program_id = $_POST['program_id'];
            $average_grade = $_POST['average_grade'];

            // 1. Keamanan Upload Berkas
            $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
            $file_name = $_FILES['document']['name'];
            $file_tmp = $_FILES['document']['tmp_name'];
            $file_size = $_FILES['document']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validasi ekstensi dan ukuran (Max 2MB)
            if (in_array($file_ext, $allowed_ext) && $file_size < 2097152) {
                // Rename file agar unik dan mencegah path traversal
                $new_file_name = uniqid('doc_') . '.' . $file_ext;
                $upload_dir = __DIR__ . '/../../public/uploads/';
                $upload_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // 2. Kriptografi: Hasilkan Hash SHA-256 dari dokumen fisik
                    $document_hash = hash_file('sha256', $upload_path);

                    require_once __DIR__ . '/../Models/Application.php';
                    $appModel = new Application();

                    $data = [
                        'user_id' => $_SESSION['user_id'],
                        'program_id' => $program_id,
                        'average_grade' => $average_grade,
                        'document_url' => 'uploads/' . $new_file_name,
                        'document_hash' => $document_hash
                    ];

                    if ($appModel->submitApplication($data)) {
                        $_SESSION['success_msg'] = "Pendaftaran berhasil! Hash Dokumen: " . substr($document_hash, 0, 15) . "...";
                    } else {
                        $_SESSION['error_msg'] = "Gagal menyimpan pendaftaran.";
                    }
                } else {
                    $_SESSION['error_msg'] = "Gagal memindahkan file yang diunggah.";
                }
            } else {
                $_SESSION['error_msg'] = "Format file tidak valid (Hanya PDF/JPG/PNG) atau ukuran lebih dari 2MB.";
            }
            
            header("Location: " . BASE_URL . "/apply");
            exit;
        }
    }
}