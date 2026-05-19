<?php
// app/Models/Payment.php
require_once __DIR__ . '/../Core/Database.php';

class Payment {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Mengambil semua data pembayaran beserta profil pendaftar
    // Mengambil semua data pembayaran beserta profil pendaftar
    public function getAllPayments() {
        try {
            $sql = "SELECT p.*, pr.full_name, pr.nisn 
                    FROM payments p 
                    JOIN profiles pr ON p.user_id = pr.user_id 
                    ORDER BY CASE WHEN p.status = 'pending' THEN 1 ELSE 2 END, p.created_at DESC";
            
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            // Jika ada error database, tampilkan pesannya, jangan biarkan blank putih!
            die("Error Database pada Modul Pembayaran: " . $e->getMessage());
        }
    }

    // Memperbarui status pembayaran
    public function updateStatus($id, $status) {
        $this->db->query("UPDATE payments SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
