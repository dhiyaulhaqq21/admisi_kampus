<?php
// app/Models/Application.php
require_once __DIR__ . '/../Core/Database.php';

class Application {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Ambil daftar prodi untuk dropdown form
    public function getPrograms() {
        $this->db->query("SELECT * FROM programs");
        return $this->db->resultSet();
    }

    // Cek apakah user sudah mendaftar
    public function getApplicationByUserId($userId) {
        $this->db->query("SELECT a.*, p.name as program_name FROM applications a JOIN programs p ON a.program_id = p.id WHERE a.user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    // Simpan pendaftaran
    public function submitApplication($data) {
        $this->db->query("INSERT INTO applications (user_id, program_id, average_grade, document_url, document_hash) VALUES (:user_id, :program_id, :average_grade, :document_url, :document_hash)");
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':program_id', $data['program_id']);
        $this->db->bind(':average_grade', $data['average_grade']);
        $this->db->bind(':document_url', $data['document_url']);
        $this->db->bind(':document_hash', $data['document_hash']);

        return $this->db->execute();
    }

    // Ambil SEMUA data pendaftaran beserta biodata pelamar untuk Admin
    public function getAllApplications() {
        $sql = "SELECT a.*, p.name as program_name, pr.full_name, pr.nisn 
                FROM applications a 
                JOIN programs p ON a.program_id = p.id 
                JOIN profiles pr ON a.user_id = pr.user_id 
                ORDER BY a.applied_at DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    // Update status pendaftaran (Terima/Tolak)
    public function updateStatus($application_id, $status) {
        $this->db->query("UPDATE applications SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $application_id);
        return $this->db->execute();
    }
}