<?php
require_once __DIR__ . '/../config/database.php';

class FaqData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Get all active FAQs
     */
    public function getActiveFaqs() {
        try {
            $query = "
                SELECT * FROM faqs 
                WHERE status = 'active'
                ORDER BY display_order ASC, faq_id ASC
            ";
            
            $stmt = $this->conn->query($query);
            $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($faqs)) {
                error_log("No active FAQs found in database");
                return [];
            }

            return $faqs;

        } catch (PDOException $e) {
            error_log("Error fetching FAQs: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get FAQs by category
     */
    public function getFaqsByCategory($category) {
        try {
            $query = "
                SELECT * FROM faqs 
                WHERE status = 'active' 
                AND category = :category
                ORDER BY display_order ASC, faq_id ASC
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['category' => $category]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching FAQs for category {$category}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get FAQ by ID
     */
    public function getFaqById($faq_id) {
        try {
            $query = "
                SELECT * FROM faqs 
                WHERE faq_id = :faq_id
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['faq_id' => $faq_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching FAQ {$faq_id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add new FAQ
     */
    public function addFaq($faq_data) {
        try {
            $query = "
                INSERT INTO faqs (
                    faq_title, faq_description, category,
                    display_order, status, date_added
                ) VALUES (
                    :faq_title, :faq_description, :category,
                    :display_order, :status, CURDATE()
                )
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'faq_title' => $faq_data['faq_title'],
                'faq_description' => $faq_data['faq_description'],
                'category' => $faq_data['category'] ?? 'general',
                'display_order' => $faq_data['display_order'] ?? 0,
                'status' => $faq_data['status'] ?? 'active'
            ]);

        } catch (PDOException $e) {
            error_log("Error adding FAQ: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update FAQ
     */
    public function updateFaq($faq_id, $faq_data) {
        try {
            $query = "
                UPDATE faqs 
                SET faq_title = :faq_title,
                    faq_description = :faq_description,
                    category = :category,
                    display_order = :display_order,
                    status = :status
                WHERE faq_id = :faq_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'faq_id' => $faq_id,
                'faq_title' => $faq_data['faq_title'],
                'faq_description' => $faq_data['faq_description'],
                'category' => $faq_data['category'],
                'display_order' => $faq_data['display_order'],
                'status' => $faq_data['status']
            ]);

        } catch (PDOException $e) {
            error_log("Error updating FAQ: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete FAQ (soft delete by setting status to inactive)
     */
    public function deleteFaq($faq_id) {
        try {
            $query = "
                UPDATE faqs 
                SET status = 'inactive' 
                WHERE faq_id = :faq_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(['faq_id' => $faq_id]);

        } catch (PDOException $e) {
            error_log("Error deleting FAQ: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update display order
     */
    public function updateDisplayOrder($faq_id, $new_order) {
        try {
            $query = "
                UPDATE faqs 
                SET display_order = :new_order 
                WHERE faq_id = :faq_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'faq_id' => $faq_id,
                'new_order' => $new_order
            ]);

        } catch (PDOException $e) {
            error_log("Error updating FAQ order: " . $e->getMessage());
            return false;
        }
    }
}

// Get the data
try {
    $faqDataObj = new FaqData();
    $faqs = $faqDataObj->getActiveFaqs();
} catch (Exception $e) {
    error_log("Error initializing FaqData: " . $e->getMessage());
    $faqs = [];
}

// Debug information - remove in production
if (empty($faqs)) {
    error_log("FAQs data is empty");
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<!-- Debug: FAQs data is empty -->";
    }
}
?> 