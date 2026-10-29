<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class WhyUsData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getWhyUsData() {
        try {
            $query = "SELECT whyus_id, whyus_title, whyus_card_number, whyus_description FROM why_us ORDER BY whyus_id ASC";
            $stmt = $this->conn->query($query);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($data)) {
                error_log("No why us data found.");
            }
            return $data;
        } catch (PDOException $e) {
            error_log("Error fetching why us data: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $whyUsDataObj = new WhyUsData();
    $why_us_data = $whyUsDataObj->getWhyUsData();
    if (empty($why_us_data)) {
        error_log("No why us data found.");
    }
    echo json_encode($why_us_data);
} catch (Exception $e) {
    error_log("Error initializing WhyUsData: " . $e->getMessage());
    echo json_encode([]);
}
?>