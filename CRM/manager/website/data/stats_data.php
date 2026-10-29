<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class StatsData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getStatsData() {
        try {
            $query = "SELECT stats_id, stat, counts, date_added, last_modified FROM stats_total ORDER BY stats_id ASC";
            $stmt = $this->conn->query($query);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($data)) {
                error_log("No stats data found.");
            }
            return $data;
        } catch (PDOException $e) {
            error_log("Error fetching stats data: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $statsDataObj = new StatsData();
    $stats_data = $statsDataObj->getStatsData();
    if (empty($stats_data)) {
        error_log("No stats data found.");
    }
    echo json_encode($stats_data);
} catch (Exception $e) {
    error_log("Error initializing StatsData: " . $e->getMessage());
    echo json_encode([]);
}
?>