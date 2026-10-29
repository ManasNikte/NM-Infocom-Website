<?php
require_once __DIR__ . '/../config/database.php';

class ReviewData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Get all public reviews
     */
    public function getPublicReviews() {
        try {
            $query = "
                SELECT * FROM reviews 
                WHERE reviewer_status = 'public'
                ORDER BY reviewer_date DESC
            ";
            
            $stmt = $this->conn->query($query);
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($reviews)) {
                error_log("No public reviews found in database");
                return [];
            }

            return $reviews;

        } catch (PDOException $e) {
            error_log("Error fetching public reviews: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all reviews (including non-public ones)
     */
    public function getAllReviews() {
        try {
            $query = "
                SELECT * FROM reviews 
                ORDER BY reviewer_date DESC
            ";
            
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching all reviews: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get review by ID
     */
    public function getReviewById($review_id) {
        try {
            $query = "
                SELECT * FROM reviews 
                WHERE review_id = :review_id
            ";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['review_id' => $review_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error fetching review {$review_id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add new review
     */
    public function addReview($review_data) {
        try {
            $query = "
                INSERT INTO reviews (
                    reviewer_name, reviewer_email, reviewer_contact,
                    reviewer_designation, reviewer_rating, review_text,
                    reviewer_date, reviewer_status
                ) VALUES (
                    :reviewer_name, :reviewer_email, :reviewer_contact,
                    :reviewer_designation, :reviewer_rating, :review_text,
                    CURDATE(), :reviewer_status
                )
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'reviewer_name' => $review_data['reviewer_name'],
                'reviewer_email' => $review_data['reviewer_email'],
                'reviewer_contact' => $review_data['reviewer_contact'],
                'reviewer_designation' => $review_data['reviewer_designation'],
                'reviewer_rating' => $review_data['reviewer_rating'],
                'review_text' => $review_data['review_text'],
                'reviewer_status' => $review_data['reviewer_status'] ?? 'pending',
            ]);

        } catch (PDOException $e) {
            error_log("Error adding review: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update review
     */
    public function updateReview($review_id, $review_data) {
        try {
            $query = "
                UPDATE reviews 
                SET reviewer_name = :reviewer_name,
                    reviewer_email = :reviewer_email,
                    reviewer_contact = :reviewer_contact,
                    reviewer_designation = :reviewer_designation,
                    reviewer_rating = :reviewer_rating,
                    review_text = :review_text,
                    reviewer_status = :reviewer_status,
                WHERE review_id = :review_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'review_id' => $review_id,
                'reviewer_name' => $review_data['reviewer_name'],
                'reviewer_email' => $review_data['reviewer_email'],
                'reviewer_contact' => $review_data['reviewer_contact'],
                'reviewer_designation' => $review_data['reviewer_designation'],
                'reviewer_rating' => $review_data['reviewer_rating'],
                'review_text' => $review_data['review_text'],
                'reviewer_status' => $review_data['reviewer_status'],
            ]);

        } catch (PDOException $e) {
            error_log("Error updating review: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete review
     */
    public function deleteReview($review_id) {
        try {
            $query = "
                DELETE FROM reviews 
                WHERE review_id = :review_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(['review_id' => $review_id]);

        } catch (PDOException $e) {
            error_log("Error deleting review: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update review status
     */
    public function updateReviewStatus($review_id, $status) {
        try {
            $query = "
                UPDATE reviews 
                SET reviewer_status = :status 
                WHERE review_id = :review_id
            ";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'review_id' => $review_id,
                'status' => $status
            ]);

        } catch (PDOException $e) {
            error_log("Error updating review status: " . $e->getMessage());
            return false;
        }
    }
}

// Get the data
try {
    $reviewDataObj = new ReviewData();
    $reviews = $reviewDataObj->getPublicReviews();
} catch (Exception $e) {
    error_log("Error initializing ReviewData: " . $e->getMessage());
    $reviews = [];
}

// Debug information - remove in production
if (empty($reviews)) {
    error_log("Reviews data is empty");
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        echo "<!-- Debug: Reviews data is empty -->";
    }
}
?>

