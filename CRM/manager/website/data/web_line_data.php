<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class WebLineData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getWebLineData() {
        try {
            $query = "SELECT web_id, site_name, whyus_introline, team_introline, address, contact_no, email, map_link, twitter_link, facebook_link, instagram_link, linkedin_link, last_updated FROM web_data ORDER BY web_id ASC";
            $stmt = $this->conn->query($query);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($data)) {
                error_log("No web line data found.");
            }
            return $data;
        } catch (PDOException $e) {
            error_log("Error fetching web line data: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $webLineDataObj = new WebLineData();
    $web_line_data = $webLineDataObj->getWebLineData();
    if (empty($web_line_data)) {
        error_log("No web line data found.");
    }
    echo json_encode($web_line_data);
} catch (Exception $e) {
    error_log("Error initializing WebLineData: " . $e->getMessage());
    echo json_encode([]);
}
?>