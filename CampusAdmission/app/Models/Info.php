<?php
// app/Models/Info.php
require_once __DIR__ . '/../Core/Database.php';

class Info {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // --- FUNGSI PENGUMUMAN ---
    public function getAnnouncements() {
        $this->db->query("SELECT * FROM announcements ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function addAnnouncement($title, $content) {
        $this->db->query("INSERT INTO announcements (title, content) VALUES (:title, :content)");
        $this->db->bind(':title', $title);
        $this->db->bind(':content', $content);
        return $this->db->execute();
    }

    public function deleteAnnouncement($id) {
        $this->db->query("DELETE FROM announcements WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // --- FUNGSI JADWAL ---
    public function getSchedules() {
        $this->db->query("SELECT * FROM schedules ORDER BY start_date ASC");
        return $this->db->resultSet();
    }

    public function addSchedule($activity, $start, $end) {
        $this->db->query("INSERT INTO schedules (activity_name, start_date, end_date) VALUES (:activity, :start, :end)");
        $this->db->bind(':activity', $activity);
        $this->db->bind(':start', $start);
        $this->db->bind(':end', $end);
        return $this->db->execute();
    }

    public function deleteSchedule($id) {
        $this->db->query("DELETE FROM schedules WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}