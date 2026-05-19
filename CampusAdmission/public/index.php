<?php
// public/index.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../config.php';
require_once '../app/Core/Database.php';

// Masukkan file Controller baru di sini
require_once '../app/Controllers/HomeController.php';
require_once '../app/Controllers/AuthController.php';
require_once '../app/Controllers/ApplicantController.php';
require_once '../app/Controllers/AdminController.php';

// Routing sangat sederhana untuk MVP
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = $url[0];

// public/index.php (Bagian Routing)
switch ($controllerName) {
    case 'login':
        $auth = new AuthController();
        $auth->login();
        break;
    case 'register':
        $auth = new AuthController();
        $auth->register();
        break;
    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;
    case 'dashboard':
        $applicant = new ApplicantController();
        $applicant->dashboard();
        break;
    case 'save_profile':
        $applicant = new ApplicantController();
        $applicant->saveProfile();
        break;
    case 'apply':
        $applicant = new ApplicantController();
        $applicant->apply();
        break;
    case 'submit_application':
        $applicant = new ApplicantController();
        $applicant->submitApplication();
        break;
    case 'admin':
        $admin = new AdminController();
        // Membaca sub-url setelah kata 'admin' (contoh: /admin/prodi atau /admin/prodi_add)
        $action = $url[1] ?? 'index'; 

        switch ($action) {
            case 'prodi':
                $admin->kelolaProdi();
                break;
            case 'prodi_add':
                $admin->tambahProdi();
                break;
            case 'prodi_edit':
                $admin->editProdi();
                break;
            case 'prodi_delete':
                $id = $url[2] ?? null;
                if ($id) {
                    $admin->hapusProdi($id);
                } else {
                    header("Location: " . BASE_URL . "/admin/prodi");
                }
                break;
            
            // verifikasi berkas
            case 'verifikasi_berkas':
                $admin->verifikasiBerkas();
                break;
            case 'verifikasi_berkas_update': // <--- TAMBAHKAN BARIS INI
                $admin->updateStatusBerkas();
                break;
                
            // pembayaran
            case 'pembayaran':
                $admin->kelolaPembayaran();
                break;
            case 'pembayaran_update':
                $admin->updateStatusPembayaran();
                break;  
            
            // info PMB
            case 'info_pmb':
                $admin->kelolaInfoPMB();
                break;
            case 'info_add_pengumuman':
                $admin->tambahPengumuman();
                break;
            case 'info_del_pengumuman':
                $id = $url[2] ?? null;
                if ($id) $admin->hapusPengumuman($id);
                else header("Location: " . BASE_URL . "/admin/info_pmb");
                break;
            
            // info PMB - jadwal
            case 'info_add_jadwal':
                $admin->tambahJadwal();
                break;
            case 'info_del_jadwal':
                $id = $url[2] ?? null;
                if ($id) $admin->hapusJadwal($id);
                else header("Location: " . BASE_URL . "/admin/info_pmb");
                break;
            
            // laporan
            case 'laporan':
                $admin->cetakLaporan();
                break;
            case 'laporan_csv': // <--- TAMBAHKAN BARIS INI
                $admin->exportCSV();
                break;
            
            // Default admin dashboard
            case 'index':
            default:
                $admin->dashboard();
                break;
        }
        break;
    case 'home':
    default:
        // Arahkan ke HomeController
        $home = new HomeController();
        $home->index();
        break;
}