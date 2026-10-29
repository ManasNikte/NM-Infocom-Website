<?php
require_once __DIR__ . '/../config/database.php';

class WhyUsData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Get all why us items
     */
    public function getWhyUsItems() {
        try {
            $query = "
                SELECT * FROM why_us 
                ORDER BY whyus_id ASC
            ";
            
            $stmt = $this->conn->query($query);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($items)) {
                error_log("No why us items found in database");
                return [];
            }

            return $items;

        } catch (PDOException $e) {
            error_log("Error fetching why us items: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get why us item by ID
     */
    public function getWhyUsById($whyus_id) {
        try {
            $query = "
                SELECT * FROM why_us 
                WHERE whyus_id = :whyus_id
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['whyus_id' => $whyus_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching why us item {$whyus_id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add new why us item
     */
    public function addWhyUsItem($item_data) {
        try {
            $query = "
                INSERT INTO why_us (
                    whyus_title, 
                    whyus_card_number, 
                    whyus_description
                ) VALUES (
                    :whyus_title, 
                    :whyus_card_number, 
                    :whyus_description
                )
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'whyus_title' => $item_data['whyus_title'],
                'whyus_card_number' => $item_data['whyus_card_number'],
                'whyus_description' => $item_data['whyus_description']
            ]);

        } catch (PDOException $e) {
            error_log("Error adding why us item: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update why us item
     */
    public function updateWhyUsItem($whyus_id, $item_data) {
        try {
            $query = "
                UPDATE why_us 
                SET whyus_title = :whyus_title,
                    whyus_card_number = :whyus_card_number,
                    whyus_description = :whyus_description,
                WHERE whyus_id = :whyus_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'whyus_id' => $whyus_id,
                'whyus_title' => $item_data['whyus_title'],
                'whyus_card_number' => $item_data['whyus_card_number'],
                'whyus_description' => $item_data['whyus_description']
            ]);

        } catch (PDOException $e) {
            error_log("Error updating why us item: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete why us item
     */
    public function deleteWhyUsItem($whyus_id) {
        try {
            $query = "
                DELETE FROM why_us 
                WHERE whyus_id = :whyus_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(['whyus_id' => $whyus_id]);

        } catch (PDOException $e) {
            error_log("Error deleting why us item: " . $e->getMessage());
            return false;
        }
    }
}

// Get the data
try {
    $whyUsDataObj = new WhyUsData();
    $whyus_data = $whyUsDataObj->getWhyUsItems();
} catch (Exception $e) {
    error_log("Error initializing WhyUsData: " . $e->getMessage());
    $whyus_data = [];
}

// Debug information - remove in production
if (empty($whyus_data)) {
    error_log("Why Us data is empty");
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<!-- Debug: Why Us data is empty -->";
    }
}
?> 