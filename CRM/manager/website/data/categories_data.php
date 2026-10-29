<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');

// Set error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/categories_error.log');

// Create logs directory if it doesn't exist
if (!is_dir(__DIR__ . '/../../logs')) {
    mkdir(__DIR__ . '/../../logs', 0755, true);
}

// Log the start of the script
error_log("=== Starting categories_data.php ===");

try {
} catch (Exception $e) {
    error_log("Error including database.php: " . $e->getMessage());
    die(json_encode(['success' => false, 'message' => 'Database configuration error']));
}

header('Content-Type: application/json');

// Function to handle errors and return JSON
function returnJsonError($message, $code = 500) {
    http_response_code($code);
    $error = ['success' => false, 'message' => $message];
    error_log("Returning error: " . print_r($error, true));
    echo json_encode($error);
    exit;
}

try {
    // Initialize database connection
    $db = new Database();
    $pdo = $db->getConnection();
    
    if (!$pdo) {
        returnJsonError('Database connection failed');
    }
    
    // Log the request for debugging
    error_log('Categories API Request: ' . print_r($_POST, true));
    
    // Handle different actions
    $action = $_POST['action'] ?? '';
    
    if (empty($action)) {
        error_log('No action specified in request');
        returnJsonError('No action specified', 400);
    }
    
    switch ($action) {
        case 'get_categories':
            // Get paginated categories with product counts
            // First check if the table exists
            $tableCheck = $pdo->query("SHOW TABLES LIKE 'product_categories'");
            if ($tableCheck->rowCount() === 0) {
                error_log('product_categories table does not exist');
                returnJsonError('Categories table not found', 500);
            }
            
            // Get pagination parameters
            $page = isset($_POST['page']) ? max(1, (int)$_POST['page']) : 1;
            $perPage = isset($_POST['per_page']) ? max(1, (int)$_POST['per_page']) : 10;
            $offset = ($page - 1) * $perPage;
            
            // Get total count for pagination
            $countSql = "SELECT COUNT(*) as total FROM product_categories";
            $countStmt = $pdo->query($countSql);
            $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            $totalPages = ceil($total / $perPage);
            
            // Get paginated categories with product counts
            $sql = "
                SELECT 
                    c.*, 
                    COUNT(p.product_id) as product_count,
                    SUM(CASE WHEN p.product_status = 'active' THEN 1 ELSE 0 END) as active_products
                FROM product_categories c
                LEFT JOIN products p ON c.category_id = p.category_id
                GROUP BY c.category_id
                ORDER BY c.category_name
                LIMIT :limit OFFSET :offset
            ";
            
            error_log('Executing SQL: ' . $sql . ' with limit: ' . $perPage . ', offset: ' . $offset);
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt === false) {
                $error = $pdo->errorInfo();
                error_log('SQL Error: ' . print_r($error, true));
                returnJsonError('Database error: ' . ($error[2] ?? 'Unknown error'), 500);
            }
            
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Found ' . count($categories) . ' categories (page ' . $page . ' of ' . $totalPages . ')');
            
            echo json_encode([
                'success' => true, 
                'data' => $categories,
                'pagination' => [
                    'total' => (int)$total,
                    'per_page' => $perPage,
                    'current_page' => $page,
                    'total_pages' => $totalPages,
                    'has_more' => $page < $totalPages
                ]
            ]);
            break;
            
        case 'add_category':
            $categoryName = trim($_POST['category_name'] ?? '');
            
            if (empty($categoryName)) {
                returnJsonError('Category name is required', 400);
            }
            
            $stmt = $pdo->prepare("INSERT INTO product_categories (category_name, date_added) VALUES (?, CURDATE())");
            $success = $stmt->execute([$categoryName]);
            
            if ($success) {
                $newId = $pdo->lastInsertId();
                echo json_encode(['success' => true, 'message' => 'Category added successfully', 'id' => $newId]);
            } else {
                returnJsonError('Failed to add category');
            }
            break;
            
        case 'update_category':
            $categoryId = $_POST['category_id'] ?? 0;
            $categoryName = trim($_POST['category_name'] ?? '');
            
            if (empty($categoryName) || empty($categoryId)) {
                returnJsonError('Category ID and name are required', 400);
            }
            
            $stmt = $pdo->prepare("UPDATE product_categories SET category_name = ? WHERE category_id = ?");
            $success = $stmt->execute([$categoryName, $categoryId]);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
            } else {
                returnJsonError('Failed to update category');
            }
            break;
            
        case 'delete_category':
            $categoryId = $_POST['category_id'] ?? 0;
            
            if (empty($categoryId)) {
                returnJsonError('Category ID is required', 400);
            }
            
            // Check for active products
            $stmt = $pdo->prepare("SELECT COUNT(*) as product_count FROM products WHERE category_id = ? AND product_status = 'active'");
            $stmt->execute([$categoryId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['product_count'] > 0) {
                returnJsonError('Cannot delete category with active products', 400);
            }
            
            $stmt = $pdo->prepare("DELETE FROM product_categories WHERE category_id = ?");
            $success = $stmt->execute([$categoryId]);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
            } else {
                returnJsonError('Failed to delete category');
            }
            break;
            
        default:
            returnJsonError('Invalid action', 400);
    }
    
} catch (PDOException $e) {
    error_log('Database Error: ' . $e->getMessage());
    returnJsonError('A database error occurred');
} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
    returnJsonError('An error occurred');
}
?>
