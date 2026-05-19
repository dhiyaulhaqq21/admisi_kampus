<?php
// app/Models/User.php
require_once __DIR__ . '/../Core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fungsi Mendaftar Akun Baru
    public function register($email, $password) {
        // Enkripsi password menggunakan algoritma Bcrypt
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $this->db->query("INSERT INTO users (email, password_hash, role) VALUES (:email, :password, 'applicant')");
        $this->db->bind(':email', $email);
        $this->db->bind(':password', $passwordHash);

        try {
            return $this->db->execute();
        } catch (PDOException $e) {
            return false; // Email mungkin sudah terdaftar (UNIQUE constraint)
        }
    }

    // Fungsi Cek Login
    public function login($email, $password) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        $user = $this->db->single();

        // Verifikasi password hash
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user; // Kembalikan data user jika cocok
        }
        return false; // Gagal login
    }
}