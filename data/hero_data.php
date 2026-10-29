<?php
require_once __DIR__ . '/../config/database.php';

class HeroData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getHeroSlides() {
        try {
            $query = "
                SELECT * FROM hero_slides 
                ORDER BY display_order ASC, slide_id ASC
            ";
            
            $stmt = $this->conn->query($query);
            $hero_slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($hero_slides)) {
                error_log("No hero slides found in database");
                return [];
            }

            return $hero_slides;

        } catch (PDOException $e) {
            error_log("Error fetching hero slides: " . $e->getMessage());
            return [];
        }
    }

    public function getSlideById($slide_id) {
        try {
            $query = "
                SELECT * FROM hero_slides 
                WHERE slide_id = :slide_id
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['slide_id' => $slide_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching slide {$slide_id}: " . $e->getMessage());
            return null;
        }
    }

    public function updateSlideOrder($slide_id, $new_order) {
        try {
            $query = "
                UPDATE hero_slides 
                SET display_order = :new_order 
                WHERE slide_id = :slide_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'slide_id' => $slide_id,
                'new_order' => $new_order
            ]);

        } catch (PDOException $e) {
            error_log("Error updating slide order: " . $e->getMessage());
            return false;
        }
    }
}

// Get the data
try {
    $heroDataObj = new HeroData();
    $hero_slides = $heroDataObj->getHeroSlides();
} catch (Exception $e) {
    error_log("Error initializing HeroData: " . $e->getMessage());
    $hero_slides = [];
}

// Debug information - remove in production
if (empty($hero_slides)) {
    error_log("Hero slides data is empty");
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<!-- Debug: Hero slides data is empty -->";
    }
}
?>
