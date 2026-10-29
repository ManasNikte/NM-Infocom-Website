<?php
require_once __DIR__ . '/../config/database.php';

class AboutData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAboutData() {
        try {
            $query = "SELECT * FROM about ORDER BY about_id ASC";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching about data: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $aboutDataObj = new AboutData();
    $about_data = $aboutDataObj->getAboutData();
} catch (Exception $e) {
    error_log("Error initializing AboutData: " . $e->getMessage());
    $about_data = [];
}
?> 