<?php
require_once __DIR__ . '/../config/database.php';

class TeamData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Get all active team members
     */
    public function getTeamMembers($includeInactive = false) {
        try {
            $query = "
                SELECT * FROM team_members 
                " . (!$includeInactive ? "WHERE status = 'active'" : "") . "
                ORDER BY emp_id ASC
            ";
            
            $stmt = $this->conn->query($query);
            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($members)) {
                error_log("No team members found in database");
                return [];
            }

            return $members;

        } catch (PDOException $e) {
            error_log("Error fetching team members: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get team member by ID
     */
    public function getMemberById($emp_id) {
        try {
            $query = "
                SELECT * FROM team_members 
                WHERE emp_id = :emp_id
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['emp_id' => $emp_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching team member {$emp_id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add new team member
     */
    public function addTeamMember($member_data) {
        try {
            $query = "
                INSERT INTO team_members (
                    emp_id, emp_name, emp_post, emp_img,
                    insta_link, github_link, linkedin_link, x_link, web_link,
                    date_added, status
                ) VALUES (
                    :emp_id, :emp_name, :emp_post, :emp_img,
                    :insta_link, :github_link, :linkedin_link, :x_link, :web_link,
                    CURDATE(), :status
                )
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'emp_id' => $member_data['emp_id'],
                'emp_name' => $member_data['emp_name'],
                'emp_post' => $member_data['emp_post'],
                'emp_img' => $member_data['emp_img'],
                'insta_link' => $member_data['insta_link'] ?? null,
                'github_link' => $member_data['github_link'] ?? null,
                'linkedin_link' => $member_data['linkedin_link'] ?? null,
                'x_link' => $member_data['x_link'] ?? null,
                'web_link' => $member_data['web_link'] ?? null,
                'status' => $member_data['status'] ?? 'active'
            ]);

        } catch (PDOException $e) {
            error_log("Error adding team member: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update team member
     */
    public function updateTeamMember($emp_id, $member_data) {
        try {
            $query = "
                UPDATE team_members 
                SET emp_name = :emp_name,
                    emp_post = :emp_post,
                    emp_img = :emp_img,
                    insta_link = :insta_link,
                    github_link = :github_link,
                    linkedin_link = :linkedin_link,
                    x_link = :x_link,
                    web_link = :web_link,
                    status = :status
                WHERE emp_id = :emp_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'emp_id' => $emp_id,
                'emp_name' => $member_data['emp_name'],
                'emp_post' => $member_data['emp_post'],
                'emp_img' => $member_data['emp_img'],
                'insta_link' => $member_data['insta_link'] ?? null,
                'github_link' => $member_data['github_link'] ?? null,
                'linkedin_link' => $member_data['linkedin_link'] ?? null,
                'x_link' => $member_data['x_link'] ?? null,
                'web_link' => $member_data['web_link'] ?? null,
                'status' => $member_data['status'] ?? 'active'
            ]);

        } catch (PDOException $e) {
            error_log("Error updating team member: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete team member (soft delete by setting status to inactive)
     */
    public function deleteTeamMember($emp_id) {
        try {
            $query = "
                UPDATE team_members 
                SET status = 'inactive' 
                WHERE emp_id = :emp_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(['emp_id' => $emp_id]);

        } catch (PDOException $e) {
            error_log("Error deleting team member: " . $e->getMessage());
            return false;
        }
    }
}

// Get the data
try {
    $teamDataObj = new TeamData();
    $team_members = $teamDataObj->getTeamMembers();
} catch (Exception $e) {
    error_log("Error initializing TeamData: " . $e->getMessage());
    $team_members = [];
}

// Debug information - remove in production
if (empty($team_members)) {
    error_log("Team members data is empty");
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<!-- Debug: Team members data is empty -->";
    }
}
?>