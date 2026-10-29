<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class WebDataStats {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getStats() {
        try {
            $query = "SELECT stat, counts FROM stats_total WHERE stat IN ('client', 'websites', 'hours_of_support', 'employee_count')";
            $stmt = $this->conn->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Format into single object
            $stats = [];
            foreach ($results as $row) {
                $stats[$row['stat']] = $row['counts'];
            }
            
            return [
                'clients' => $stats['client'] ?? 0,
                'websites' => $stats['websites'] ?? 0,
                'hours_of_support' => $stats['hours_of_support'] ?? 0,
                'employees' => $stats['employee_count'] ?? 0
            ];
        } catch (PDOException $e) {
            error_log("Error fetching stats: " . $e->getMessage());
            return null;
        }
    }
}

try {
    $statsObj = new WebDataStats();
    $stats = $statsObj->getStats();
    header('Content-Type: application/json');
    echo json_encode($stats ?: ['error' => 'No stats available']);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to fetch stats']);
}