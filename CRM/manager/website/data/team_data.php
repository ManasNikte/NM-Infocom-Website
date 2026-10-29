
<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
class TeamData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getTeamData() {
        try {
            $query = "SELECT emp_id, emp_name, emp_post, emp_img, insta_link, github_link, linkedin_link, x_link, web_link, date_added, last_modified, status FROM team_members ORDER BY emp_id ASC";
            $stmt = $this->conn->query($query);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($data)) {
                error_log("No team data found.");
            }
            return $data;
        } catch (PDOException $e) {
            error_log("Error fetching team data: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $teamDataObj = new TeamData();
    $team_data = $teamDataObj->getTeamData();
    if (empty($team_data)) {
        error_log("No team data found.");
    }
    echo json_encode($team_data);
} catch (Exception $e) {
    error_log("Error initializing TeamData: " . $e->getMessage());
    echo json_encode([]);
}
?>