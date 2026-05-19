<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if ($this->userModel->register($email, $password)) {
                // Redirect ke halaman login setelah sukses
                header("Location: " . BASE_URL . "/login");
                exit;
            } else {
                $error = "Pendaftaran gagal. Email mungkin sudah digunakan.";
                require_once __DIR__ . '/../../views/auth/register.php';
            }
        } else {
            require_once __DIR__ . '/../../views/auth/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $loggedInUser = $this->userModel->login($email, $password);

            if ($loggedInUser) {
                // Buat Session
                $_SESSION['user_id'] = $loggedInUser['id'];
                $_SESSION['role'] = $loggedInUser['role'];
                
                // Arahkan berdasarkan role
                if ($loggedInUser['role'] === 'admin') {
                    header("Location: " . BASE_URL . "/admin");
                } else {
                    header("Location: " . BASE_URL . "/dashboard");
                }
                exit;
            } else {
                $error = "Email atau password salah!";
                require_once __DIR__ . '/../../views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../../views/auth/login.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}