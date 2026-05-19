<?php
// app/Controllers/HomeController.php

class HomeController {
    public function index() {
        // Jika user sudah login, kita bisa mengambil data session
        // untuk mengubah tombol di navbar (misal: "Login" menjadi "Dashboard")
        $isLoggedIn = isset($_SESSION['user_id']);
        $role = $_SESSION['role'] ?? null;
        
        require_once __DIR__ . '/../../views/home/index.php';
    }
}