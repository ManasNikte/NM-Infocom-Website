<?php
require_once __DIR__ . '/../config/database.php';

class AboutPointsData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAboutPoints() {
        try {
            $query = "
                SELECT ap.*, a.about_subintroline 
                FROM about_points ap
                JOIN about a ON ap.about_id = a.about_id 
                ORDER BY ap.about_id ASC, ap.about_pointsid ASC
            ";
            
            $stmt = $this->conn->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Group points by about_id for easier use in template
            $grouped_points = [];
            foreach ($results as $row) {
                $about_id = $row['about_id'];
                if (!isset($grouped_points[$about_id])) {
                    $grouped_points[$about_id] = [];
                }
                $grouped_points[$about_id][] = $row;
            }

            return $grouped_points;

        } catch (PDOException $e) {
            error_log("Error fetching about points: " . $e->getMessage());
            return [];
        }
    }

    public function getPointsByTabId($tab_id) {
        try {
            $query = "
                SELECT * FROM about_points 
                WHERE about_id = :tab_id 
                ORDER BY about_pointsid ASC
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['tab_id' => $tab_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching points for tab {$tab_id}: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $aboutPointsObj = new AboutPointsData();
    $about_points = $aboutPointsObj->getAboutPoints();
} catch (Exception $e) {
    error_log("Error initializing AboutPointsData: " . $e->getMessage());
    $about_points = [];
}
?> 