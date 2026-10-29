<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class WebDataCounts {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getCounts() {
        $tables = [
            'about',
            'clients',
            'faqs',
            'hero_slides',
            'reviews',
            'stats_total',
            'team_members',
            'web_data',
            'why_us'
        ];

        $counts = [];
        try {
            foreach ($tables as $table) {
                $query = "SELECT COUNT(*) as count FROM {$table}";
                $stmt = $this->conn->query($query);
                $result = $stmt->fetch();
                $counts[$table] = $result['count'];
            }
        } catch (PDOException $e) {
            error_log("Error fetching counts: " . $e->getMessage());
            return [];
        }

        return $counts;
    }
}

// Get the data
try {
    $webDataCountsObj = new WebDataCounts();
    $counts = $webDataCountsObj->getCounts();
    echo json_encode($counts);
} catch (Exception $e) {
    error_log("Error initializing WebDataCounts: " . $e->getMessage());
    echo json_encode([]);
}
?>