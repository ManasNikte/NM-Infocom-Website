<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class FaqsData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getFaqsData() {
        try {
            $query = "SELECT faq_id, faq_title, faq_description, category, status, date_added, last_modified FROM faqs ORDER BY faq_id ASC";
            $stmt = $this->conn->query($query);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($data)) {
                error_log("No FAQs data found.");
            }
            return $data;
        } catch (PDOException $e) {
            error_log("Error fetching FAQs data: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $faqsDataObj = new FaqsData();
    $faqs_data = $faqsDataObj->getFaqsData();
    if (empty($faqs_data)) {
        error_log("No FAQs data found.");
    }
    echo json_encode($faqs_data);
} catch (Exception $e) {
    error_log("Error initializing FaqsData: " . $e->getMessage());
    echo json_encode([]);
}
?>