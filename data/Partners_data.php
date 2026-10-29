<?php
require_once __DIR__ . '/../config/database.php';

class PartnersData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Get all active partners
     */
    public function getActivePartners() {
        try {
            $query = "
                SELECT 
                    partner_id,
                    partner_name,
                    partner_img,
                    status,
                    DATE_FORMAT(date_added, '%Y-%m-%d %H:%i:%s') as date_added,
                    DATE_FORMAT(last_modified, '%Y-%m-%d %H:%i:%s') as last_modified
                FROM partners 
                ORDER BY partner_id DESC
            ";
            
            $stmt = $this->conn->query($query);
            $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($partners)) {
                error_log("No partners found in database");
                return [];
            }

            return $partners;

        } catch (PDOException $e) {
            error_log("Error fetching partners: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get partners for a specific page/slide
     */
    public function getPartnersForSlide($page, $partnersPerSlide = 9) {
        try {
            $offset = ($page - 1) * $partnersPerSlide;
            
            $query = "
                SELECT * FROM partners 
                WHERE status = 'active'
                ORDER BY display_order ASC, partner_id ASC
                LIMIT :limit OFFSET :offset
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limit', $partnersPerSlide, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching partners for slide {$page}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total number of active partners
     */
    public function getTotalPartners() {
        try {
            $query = "
                SELECT COUNT(*) as total 
                FROM partners 
                WHERE status = 'active'
            ";
            
            $stmt = $this->conn->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return (int)$result['total'];

        } catch (PDOException $e) {
            error_log("Error getting total partners count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total number of slides needed
     */
    public function getTotalSlides($partnersPerSlide = 9) {
        $totalPartners = $this->getTotalPartners();
        return ceil($totalPartners / $partnersPerSlide);
    }

    /**
     * Add new partner
     */
    public function addPartner($partnerData) {
        try {
            $query = "
                INSERT INTO partners (
                    partner_name, 
                    partner_img, 
                    display_order,
                    status
                ) VALUES (
                    :partner_name,
                    :partner_img,
                    :display_order,
                    :status
                )
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'partner_name' => $partnerData['partner_name'],
                'partner_img' => $partnerData['partner_img'],
                'display_order' => $partnerData['display_order'] ?? 0,
                'status' => $partnerData['status'] ?? 'active'
            ]);

        } catch (PDOException $e) {
            error_log("Error adding partner: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update partner
     */
    public function updatePartner($partner_id, $partnerData) {
        try {
            $query = "
                UPDATE partners 
                SET partner_name = :partner_name,
                    partner_img = :partner_img,
                    display_order = :display_order,
                    status = :status
                WHERE partner_id = :partner_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'partner_id' => $partner_id,
                'partner_name' => $partnerData['partner_name'],
                'partner_img' => $partnerData['partner_img'],
                'display_order' => $partnerData['display_order'],
                'status' => $partnerData['status']
            ]);

        } catch (PDOException $e) {
            error_log("Error updating partner: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete partner (soft delete by setting status to inactive)
     */
    public function deletePartner($partner_id) {
        try {
            $query = "
                UPDATE partners 
                SET status = 'inactive' 
                WHERE partner_id = :partner_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(['partner_id' => $partner_id]);

        } catch (PDOException $e) {
            error_log("Error deleting partner: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update display order
     */
    public function updateDisplayOrder($partner_id, $new_order) {
        try {
            $query = "
                UPDATE partners 
                SET display_order = :new_order 
                WHERE partner_id = :partner_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'partner_id' => $partner_id,
                'new_order' => $new_order
            ]);

        } catch (PDOException $e) {
            error_log("Error updating partner order: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get partners for a specific page
     */
    public function getPartnersForPage($page = 1, $partnersPerPage = 6) {
        try {
            $offset = ($page - 1) * $partnersPerPage;
            
            $query = "
                SELECT 
                    partner_id,
                    partner_name,
                    partner_img,
                    status
                FROM partners 
                WHERE status = 'active'
                ORDER BY partner_id DESC
                LIMIT :limit OFFSET :offset
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limit', $partnersPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching partners for page: " . $e->getMessage());
            return [];
        }
    }
}

// Initialize the partners data
try {
    $partnersDataObj = new PartnersData();
    $partnersPerSlide = 9; // Number of partners per slide
    $totalPartners = $partnersDataObj->getTotalPartners();
    $totalSlides = $partnersDataObj->getTotalSlides($partnersPerSlide);
    
    // Get all partners (you can modify this to get specific slides as needed)
    $partners = $partnersDataObj->getActivePartners();

} catch (Exception $e) {
    error_log("Error initializing PartnersData: " . $e->getMessage());
    $partners = [];
    $totalPartners = 0;
    $totalSlides = 0;
}

// Debug information - remove in production
if (empty($partners)) {
    error_log("Partners data is empty");
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<!-- Debug: Partners data is empty -->";
    }
}
?>