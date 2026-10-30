<?php
require_once __DIR__ . '/../../config/auth.php';
$auth = crm_require_api('Admin');
require_once __DIR__ . '/../../../config/format.php';
header('Content-Type: application/json');

// Enable error reporting for debugging

function validateJobData($data) {
    $errors = [];
    
    // Required fields validation (excluding auto-generated fields)
    $requiredFields = [
        'title' => 'Job Title',
        'category' => 'Category',
        'type' => 'Job Type',
        'location' => 'Location',
        'salary' => 'Salary',
        'description' => 'Description',
        'skills' => 'Skills',
        'icon' => 'Icon',
        'deadline' => 'Deadline',
        'experience' => 'Experience',
        'education' => 'Education',
        'responsibilities' => 'Responsibilities',
        'requirements' => 'Requirements'
    ];
    
    foreach ($requiredFields as $field => $label) {
        if (empty(trim($data[$field] ?? ''))) {
            $errors[] = "$label is required";
        }
    }
    
    // Date validation
    if (!empty($data['deadline']) && !strtotime($data['deadline'])) {
        $errors[] = "Invalid Deadline format";
    }
    
    // Date logic validation
    $date_posted = date('Y-m-d'); // Always use today's date
    if (!empty($date_posted) && !empty($data['deadline'])) {
        if (strtotime($date_posted) > strtotime($data['deadline'])) {
            $errors[] = "Deadline must be after Date Posted";
        }
    }
    
    return $errors;
}

function addJob($data) {
    foreach (['skills', 'responsibilities', 'requirements'] as $listField) {
        // One item per line (or a JSON array) -> stored JSON array.
        $data[$listField] = nm_list_json($data[$listField] ?? '');
    }
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        // Start transaction
        $conn->beginTransaction();
        
        try {
            // Validate input data
            $validationErrors = validateJobData($data);
            if (!empty($validationErrors)) {
                throw new Exception("Validation failed: " . implode(", ", $validationErrors));
            }
            
            // Validate that the category exists in career_categories table
            $categoryCheckQuery = "SELECT category_id, name FROM career_categories WHERE category_id = :category";
            $categoryStmt = $conn->prepare($categoryCheckQuery);
            $categoryStmt->bindParam(':category', $data['category']);
            $categoryStmt->execute();
            
            $categoryData = $categoryStmt->fetch(PDO::FETCH_ASSOC);
            if (!$categoryData) {
                throw new Exception("Invalid category: '{$data['category']}'. Please select a valid category.");
            }
            
            // Salaries are always shown in Indian rupees.
            $salary = nm_salary_inr($data['salary']);
            if ($salary === null) {
                throw new Exception('Please enter the salary in INR (for example ₹25,000 - ₹40,000 per month or 6 - 9 LPA), not another currency.');
            }

            // Clean and sanitize data
            $cleanData = [
                'title' => trim($data['title']),
                'category' => trim($data['category']),
                'type' => trim($data['type']),
                'location' => trim($data['location']),
                'salary' => $salary,
                'description' => trim($data['description']),
                'skills' => trim($data['skills']),
                'icon' => trim($data['icon']),
                'deadline' => $data['deadline'],
                'experience' => trim($data['experience']),
                'education' => trim($data['education']),
                'responsibilities' => trim($data['responsibilities']),
                'requirements' => trim($data['requirements'])
            ];
            // Always set date_posted to today
            $cleanData['date_posted'] = date('Y-m-d');
            
            // Debug: Log the skills data before processing
            
            // Handle skills field more carefully
            $skills = $cleanData['skills'];
            
            // Remove any problematic characters
            $skills = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $skills);
            
            // Ensure proper UTF-8 encoding
            if (!mb_check_encoding($skills, 'UTF-8')) {
                $skills = mb_convert_encoding($skills, 'UTF-8', 'UTF-8');
            }
            
            // Convert to UTF-8 if needed
            $skills = mb_convert_encoding($skills, 'UTF-8', 'UTF-8');
            
            // Ensure the string is not too long for the field
            if (strlen($skills) > 4294967295) { // max longtext length
                $skills = substr($skills, 0, 4294967295);
            }
            
            
            // Ensure proper encoding for longtext fields
            $cleanData['skills'] = $skills;
            $cleanData['responsibilities'] = mb_convert_encoding($cleanData['responsibilities'], 'UTF-8', 'UTF-8');
            $cleanData['requirements'] = mb_convert_encoding($cleanData['requirements'], 'UTF-8', 'UTF-8');
            $cleanData['description'] = mb_convert_encoding($cleanData['description'], 'UTF-8', 'UTF-8');
            
            // Prepare the insert query with automatic timestamp fields
            $query = "INSERT INTO careers (
                title, category, type, location, salary, description, skills, icon, 
                date_posted, deadline, experience, education, responsibilities, requirements, 
                date_added, last_modified
            ) VALUES (
                :title, :category, :type, :location, :salary, :description, :skills, :icon,
                :date_posted, :deadline, :experience, :education, :responsibilities, :requirements,
                CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
            )";
            
            $stmt = $conn->prepare($query);
            
            // Bind parameters (excluding auto-generated timestamp fields)
            $stmt->bindParam(':title', $cleanData['title']);
            $stmt->bindParam(':category', $cleanData['category']);
            $stmt->bindParam(':type', $cleanData['type']);
            $stmt->bindParam(':location', $cleanData['location']);
            $stmt->bindParam(':salary', $cleanData['salary']);
            $stmt->bindParam(':description', $cleanData['description'], PDO::PARAM_STR);
            $stmt->bindParam(':skills', $cleanData['skills'], PDO::PARAM_STR);
            $stmt->bindParam(':icon', $cleanData['icon']);
            $stmt->bindParam(':date_posted', $cleanData['date_posted']);
            $stmt->bindParam(':deadline', $cleanData['deadline']);
            $stmt->bindParam(':experience', $cleanData['experience']);
            $stmt->bindParam(':education', $cleanData['education']);
            $stmt->bindParam(':responsibilities', $cleanData['responsibilities'], PDO::PARAM_STR);
            $stmt->bindParam(':requirements', $cleanData['requirements'], PDO::PARAM_STR);
            
            // Execute the insert
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Failed to insert job: " . $errorInfo[2]);
            }
            
            $jobId = $conn->lastInsertId();
            
            // Update the count in career_categories table
            $updateCountQuery = "UPDATE career_categories SET count = count + 1 WHERE category_id = :category";
            $updateStmt = $conn->prepare($updateCountQuery);
            $updateStmt->bindParam(':category', $cleanData['category']);
            
            if (!$updateStmt->execute()) {
                throw new Exception("Failed to update category count");
            }
            
            // Commit transaction
            $conn->commit();
            
            return [
                'success' => true,
                'message' => 'Job added successfully',
                'job_id' => $jobId,
                'category_name' => $categoryData['name']
            ];
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollBack();
            throw $e;
        }
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        
        // Handle specific constraint violations
        if (strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
            if (strpos($e->getMessage(), 'careers.skills') !== false) {
                throw new Exception("Skills field constraint violation. Please check the skills data format.");
            } elseif (strpos($e->getMessage(), 'careers.category') !== false) {
                throw new Exception("Category constraint violation. Please select a valid category.");
            } else {
                throw new Exception("Data constraint violation: " . crm_public_error($e));
            }
        }
        
        throw new Exception("Database error: " . crm_public_error($e));
    } catch (Exception $e) {
        error_log("General error: " . $e->getMessage());
        throw $e;
    }
}

try {
    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. Expected POST, got ' . $_SERVER['REQUEST_METHOD']);
    }
    
    // Get POST data
    $postData = $_POST;
    
    // Add the job
    $result = addJob($postData);
    
    echo json_encode($result);
    
} catch (Exception $e) {
    error_log("Error in add_job.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => crm_public_error($e)
    ]);
}
?> 