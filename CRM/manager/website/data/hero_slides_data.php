<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
// Add error reporting for debugging

class HeroData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        
        if (!$this->conn) {
            error_log("Failed to connect to database");
            throw new Exception("Database connection failed");
        }
    }

    public function getHeroSlides() {
        try {
            $query = "SELECT * FROM hero_slides ORDER BY display_order ASC, slide_id ASC";
            $stmt = $this->conn->query($query);
            
            if (!$stmt) {
                error_log("Query failed: " . print_r($this->conn->errorInfo(), true));
                return [];
            }
            
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
}

// Handle GET requests for data retrieval
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$rowsPerPage = isset($_GET['rowsPerPage']) ? (int)$_GET['rowsPerPage'] : 5;

try {
    $heroData = new HeroData();
    $slides = $heroData->getHeroSlides();
    
    // Calculate pagination
    $totalSlides = count($slides);
    $totalPages = ceil($totalSlides / $rowsPerPage);
    $start = ($page - 1) * $rowsPerPage;
    $paginatedSlides = array_slice($slides, $start, $rowsPerPage);

    $response = [
        'slides' => $paginatedSlides,
        'pagination' => [
            'page' => $page,
            'rowsPerPage' => $rowsPerPage,
            'totalPages' => $totalPages,
            'totalSlides' => $totalSlides
        ]
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
