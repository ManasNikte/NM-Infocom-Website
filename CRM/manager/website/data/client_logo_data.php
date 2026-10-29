<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class ClientLogoData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }


    public function getClientLogos() {
        try {
            $query = "SELECT client_id, client_img, client_name, date_added, last_modified FROM clients ORDER BY client_id ASC";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching client logos: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $clientLogoDataObj = new ClientLogoData();
    $client_logos = $clientLogoDataObj->getClientLogos();
    if (empty($client_logos)) {
        error_log("No client logos found.");
    }
    echo json_encode($client_logos);
} catch (Exception $e) {
    error_log("Error initializing ClientLogoData: " . $e->getMessage());
    echo json_encode([]);
}
?>