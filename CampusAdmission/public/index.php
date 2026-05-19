<?php
// public/index.php
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
        $admin->dashboard();
        break;
    case 'admin_update_status':
        $admin = new AdminController();
        $admin->changeStatus();
        break;
    case 'home':
    default:
        // Arahkan ke HomeController
        $home = new HomeController();
        $home->index();
        break;
}