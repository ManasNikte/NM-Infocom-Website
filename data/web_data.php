<?php
require_once __DIR__ . '/../config/database.php';

class WebData {
    private $db;
    private $conn;
    private static $instance = null;
    private $web_data = null;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->loadWebData();
    }

    /**
     * Singleton pattern to ensure we only load the data once
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new WebData();
        }
        return self::$instance;
    }

    /**
     * Load web data from database
     */
    private function loadWebData() {
        try {
            $query = "SELECT * FROM web_data ORDER BY web_id DESC LIMIT 1";
            $stmt = $this->conn->query($query);
            $this->web_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$this->web_data) {
                error_log("No web data found in database");
                $this->web_data = [];
            }

        } catch (PDOException $e) {
            error_log("Error loading web data: " . $e->getMessage());
            $this->web_data = [];
        }
    }

    /**
     * Get all web data
     */
    public function getAllData() {
        return $this->web_data;
    }

    /**
     * Get specific web data field
     */
    public function get($field) {
        return $this->web_data[$field] ?? null;
    }

    /**
     * Update web data
     */
    public function updateWebData($data) {
        try {
            $query = "
                UPDATE web_data 
                SET site_name = :site_name,
                    whyus_introline = :whyus_introline,
                    team_introline = :team_introline,
                    address = :address,
                    contact_no = :contact_no,
                    email = :email,
                    map_link = :map_link,
                    twitter_link = :twitter_link,
                    facebook_link = :facebook_link,
                    instagram_link = :instagram_link,
                    linkedin_link = :linkedin_link
                WHERE web_id = :web_id
            ";
            
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([
                'web_id' => $this->web_data['web_id'],
                'site_name' => $data['site_name'],
                'whyus_introline' => $data['whyus_introline'],
                'team_introline' => $data['team_introline'],
                'address' => $data['address'],
                'contact_no' => $data['contact_no'],
                'email' => $data['email'],
                'map_link' => $data['map_link'],
                'twitter_link' => $data['twitter_link'],
                'facebook_link' => $data['facebook_link'],
                'instagram_link' => $data['instagram_link'],
                'linkedin_link' => $data['linkedin_link']
            ]);

            if ($result) {
                $this->loadWebData(); // Reload the data
            }

            return $result;

        } catch (PDOException $e) {
            error_log("Error updating web data: " . $e->getMessage());
            return false;
        }
    }
}

// Initialize the web data
try {
    $webData = WebData::getInstance();
    $web_data = $webData->getAllData();

    // Individual variables for easy access
    $content_id = $web_data['web_id'] ?? null;
    $why_us_intro = $web_data['whyus_introline'] ?? '';
    $team_intro = $web_data['team_introline'] ?? '';
    $company_address = $web_data['address'] ?? '';
    $contact_number = $web_data['contact_no'] ?? '';
    $contact_email = $web_data['email'] ?? '';
    $google_map = $web_data['map_link'] ?? '';

    // Social media links
    $twitter_link = $web_data['twitter_link'] ?? '';
    $facebook_link = $web_data['facebook_link'] ?? '';
    $instagram_link = $web_data['instagram_link'] ?? '';
    $linkedin_link = $web_data['linkedin_link'] ?? '';

} catch (Exception $e) {
    error_log("Error initializing WebData: " . $e->getMessage());
    // Set default values if data loading fails
    $content_id = null;
    $why_us_intro = '';
    $team_intro = '';
    $company_address = '';
    $contact_number = '';
    $contact_email = '';
    $google_map = '';
    $twitter_link = '';
    $facebook_link = '';
    $instagram_link = '';
    $linkedin_link = '';
}

// Debug information - remove in production
if (empty($web_data)) {
    error_log("Web data is empty");
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<!-- Debug: Web data is empty -->";
    }
}
?> 