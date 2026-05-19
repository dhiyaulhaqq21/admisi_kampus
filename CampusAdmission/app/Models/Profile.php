<?php
// app/Models/Profile.php
require_once __DIR__ . '/../Core/Database.php';

class Profile {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Mengambil data profil berdasarkan ID User
    public function getProfileByUserId($userId) {
        $this->db->query("SELECT * FROM profiles WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    // Menyimpan atau memperbarui profil (Upsert)
    public function saveProfile($data) {
        // Cek apakah profil sudah ada
        $existing = $this->getProfileByUserId($data['user_id']);

        if ($existing) {
            // Update data jika sudah ada
            $this->db->query("UPDATE profiles SET full_name = :full_name, nisn = :nisn, phone_number = :phone_number, home_address = :home_address, high_school_name = :high_school_name WHERE user_id = :user_id");
        } else {
            // Insert data baru jika belum ada
            $this->db->query("INSERT INTO profiles (user_id, full_name, nisn, phone_number, home_address, high_school_name) VALUES (:user_id, :full_name, :nisn, :phone_number, :home_address, :high_school_name)");
        }

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':nisn', $data['nisn']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':home_address', $data['home_address']);
        $this->db->bind(':high_school_name', $data['high_school_name']);

        return $this->db->execute();
    }
}