<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'hr');
require_once __DIR__ . '/../../../../config/format.php';
header('Content-Type: application/json');

// Enable error reporting for debugging

function editJob($data) {
    foreach (['skills', 'responsibilities', 'requirements'] as $listField) {
        // One item per line (or a JSON array) -> stored JSON array.
        $data[$listField] = nm_list_json($data[$listField] ?? '');
    }
    $database = new Database();
    $conn = $database->getConnection();
    
    try {
        // Validate required fields including ID (excluding auto-generated fields)
        $requiredFields = ['id', 'title', 'category', 'type', 'location', 'salary', 'description', 'skills', 'icon', 'date_posted', 'deadline', 'experience', 'education', 'responsibilities', 'requirements'];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Field '$field' is required");
            }
        }

        // Salaries are always shown in Indian rupees.
        $data['salary'] = nm_salary_inr($data['salary']);
        if ($data['salary'] === null) {
            throw new Exception('Please enter the salary in INR (for example ₹25,000 - ₹40,000 per month or 6 - 9 LPA), not another currency.');
        }
        
        // Get the old category before updating
        $getOldCategoryQuery = "SELECT category FROM careers WHERE id = :id";
        $getOldStmt = $conn->prepare($getOldCategoryQuery);
        $getOldStmt->bindParam(':id', $data['id']);
        $getOldStmt->execute();
        $oldJob = $getOldStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$oldJob) {
            throw new Exception("Job not found");
        }
        
        $oldCategory = $oldJob['category'];
        $newCategory = $data['category'];
        
        // Prepare the update query with automatic last_modified timestamp
        $query = "UPDATE careers SET 
            title = :title, 
            category = :category, 
            type = :type, 
            location = :location, 
            salary = :salary, 
            description = :description, 
            skills = :skills, 
            icon = :icon,
            date_posted = :date_posted, 
            deadline = :deadline, 
            experience = :experience, 
            education = :education, 
            responsibilities = :responsibilities, 
            requirements = :requirements,
            last_modified = CURRENT_TIMESTAMP
            WHERE id = :id";
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters (excluding auto-generated timestamp fields)
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':salary', $data['salary']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':skills', $data['skills']);
        $stmt->bindParam(':icon', $data['icon']);
        $stmt->bindParam(':date_posted', $data['date_posted']);
        $stmt->bindParam(':deadline', $data['deadline']);
        $stmt->bindParam(':experience', $data['experience']);
        $stmt->bindParam(':education', $data['education']);
        $stmt->bindParam(':responsibilities', $data['responsibilities']);
        $stmt->bindParam(':requirements', $data['requirements']);
        
        // Execute the query
        if ($stmt->execute()) {
            // Update category counts if category changed
            if ($oldCategory !== $newCategory) {
                // Decrease count for old category
                $decreaseCountQuery = "UPDATE career_categories SET count = count - 1 WHERE category_id = :category";
                $decreaseStmt = $conn->prepare($decreaseCountQuery);
                $decreaseStmt->bindParam(':category', $oldCategory);
                $decreaseStmt->execute();
                
                // Increase count for new category
                $increaseCountQuery = "UPDATE career_categories SET count = count + 1 WHERE category_id = :category";
                $increaseStmt = $conn->prepare($increaseCountQuery);
                $increaseStmt->bindParam(':category', $newCategory);
                $increaseStmt->execute();
            }
            
            return [
                'success' => true,
                'message' => 'Job updated successfully',
                'job_id' => $data['id']
            ];
        } else {
            throw new Exception("Failed to update job");
        }
        
    } catch (PDOException $e) {
        throw new Exception("Database error: " . crm_public_error($e));
    }
}

try {
    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    // Get POST data
    $postData = $_POST;
    
    // Edit the job
    $result = editJob($postData);
    
    echo json_encode($result);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => crm_public_error($e)
    ]);
}
?> 