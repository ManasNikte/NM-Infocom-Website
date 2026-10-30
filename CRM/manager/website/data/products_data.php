<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
require_once __DIR__ . '/../../../config/uploads.php';
ini_set('display_errors', 0); // Disable HTML error output
ini_set('display_startup_errors', 0);

// Set JSON header immediately
header('Content-Type: application/json');

// Function to handle errors and return JSON
function returnJsonError($message, $code = 500) {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

// Function to return JSON success
function returnJsonSuccess($message, $data = null) {
    $response = ['success' => true, 'message' => $message];
    if ($data !== null) {
        $response = array_merge($response, $data);
    }
    echo json_encode($response);
    exit;
}



try {

    $db = new Database();
    $conn = $db->getConnection();

    if (!$conn) {
        returnJsonError('Database connection failed');
    }

    // Function to create directory if it doesn't exist
    function createDirectoryIfNotExists($path) {
        if (!file_exists($path)) {
            return mkdir($path, 0755, true);
        }
        return true;
    }

    // Function to handle PDF file upload
    function handlePdfUpload($file, $productId = null) {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return null; // No file uploaded
        }
        $name = crm_store_upload($file, 'catalogue', 'product_' . (int) $productId . '_', CRM_PDF_TYPES, 10 * 1024 * 1024);
        return 'uploads/catalogue/' . $name;
    }

    // Handle GET requests for categories
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['action'] ?? '') === 'get_categories') {
        try {
            $stmt = $conn->prepare("SELECT category_id, category_name FROM product_categories WHERE status = 'active'");
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            returnJsonSuccess('Categories loaded successfully', ['categories' => $categories]);
        } catch (Exception $e) {
            returnJsonError(crm_public_error($e));
        }
    }

    // Handle POST requests for add, edit, delete
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'add') {
            try {
                
                // Add product
                $name = $_POST['name'] ?? '';
                $category_id = $_POST['category_id'] ?? null;
                $cost = $_POST['cost'] ?? 0;
                $description = $_POST['description'] ?? null;
                $status = $_POST['status'] ?? 'active';
                
                // Validate required fields
                if (empty($name)) {
                    throw new Exception('Product name is required');
                }
                if (empty($category_id)) {
                    throw new Exception('Category is required');
                }
                if (empty($cost) || $cost <= 0) {
                    throw new Exception('Valid cost is required');
                }
                
                // Handle PDF upload if provided
                $pdfPath = null;
                if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
                    $pdfPath = handlePdfUpload($_FILES['pdf']);
                } else {
                    // No PDF file or upload error
                }
                
                // Insert product first to get the ID
                $sql = "INSERT INTO products (product_name, category_id, product_cost, catalogue_pdf, cover_image, product_description, product_status, date_added) 
                        VALUES (:name, :category_id, :cost, :pdf, :cover_image, :description, :status, CURDATE())";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([
                    ':name' => $name,
                    ':category_id' => $category_id,
                    ':cost' => $cost,
                    ':pdf' => $pdfPath,
                    ':cover_image' => '', // Default empty value
                    ':description' => $description,
                    ':status' => $status
                ]);
                
                if (!$result) {
                    throw new Exception('Database error: ' . implode(', ', $stmt->errorInfo()));
                }
                
                $productId = $conn->lastInsertId();
                
                // If PDF was uploaded, rename it with the product ID
                if ($pdfPath && isset($_FILES['pdf'])) {
                    $newPdfPath = handlePdfUpload($_FILES['pdf'], $productId);
                    if ($newPdfPath) {
                        // Update the record with the new PDF path
                        $updateSql = "UPDATE products SET catalogue_pdf = :pdf WHERE product_id = :id";
                        $updateStmt = $conn->prepare($updateSql);
                        $updateStmt->execute([':pdf' => $newPdfPath, ':id' => $productId]);
                        
                        // Delete the old file
                        crm_delete_upload($pdfPath, 'catalogue');
                        $pdfPath = $newPdfPath;
                    }
                }
                

                $coverImagePath = '';
                if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                    $coverImagePath = 'uploads/products/'
                        . crm_store_upload($_FILES['cover_image'], 'products', 'cover_', CRM_IMAGE_TYPES, 5 * 1024 * 1024);
                }
                
                // Save $coverImagePath to the database in a new column (e.g., `cover_image`)
                $updateSql = "UPDATE products SET cover_image = :cover_image WHERE product_id = :id";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->execute([':cover_image' => $coverImagePath, ':id' => $productId]);
                
                returnJsonSuccess('Product added successfully', ['product_id' => $productId]);
                
            } catch (Exception $e) {
                returnJsonError(crm_public_error($e));
            }
        }

        if ($action === 'edit') {
            try {
                
                // Edit product
                $id = $_POST['id'] ?? null;
                $name = $_POST['name'] ?? '';
                $category_id = $_POST['category_id'] ?? null;
                $cost = $_POST['cost'] ?? 0;
                $description = $_POST['description'] ?? null;
                $status = $_POST['status'] ?? 'active';
                
                // Validate required fields
                if (empty($id)) {
                    throw new Exception('Product ID is required');
                }
                if (empty($name)) {
                    throw new Exception('Product name is required');
                }
                if (empty($category_id)) {
                    throw new Exception('Category is required');
                }
                if (empty($cost) || $cost <= 0) {
                    throw new Exception('Valid cost is required');
                }
                
                $getStmt = $conn->prepare('SELECT catalogue_pdf, cover_image FROM products WHERE product_id = :id');
                $getStmt->execute([':id' => $id]);
                $currentProduct = $getStmt->fetch(PDO::FETCH_ASSOC);
                if (!$currentProduct) {
                    throw new Exception('Product not found');
                }

                // New files are stored first; old ones are deleted only once the database points at the new ones.
                $newPdf = $newCover = null;
                try {
                    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
                        $newPdf = handlePdfUpload($_FILES['pdf'], $id);
                    }
                    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                        $newCover = 'uploads/products/' . crm_store_upload($_FILES['cover_image'], 'products', 'cover_', CRM_IMAGE_TYPES, 5 * 1024 * 1024);
                    }
                    $stmt = $conn->prepare('UPDATE products SET product_name = :name, category_id = :category_id, product_cost = :cost, catalogue_pdf = :pdf,
                                                   cover_image = :cover, product_description = :description, product_status = :status, last_modified = NOW()
                                            WHERE product_id = :id');
                    $stmt->execute([
                        ':name' => $name,
                        ':category_id' => $category_id,
                        ':cost' => $cost,
                        ':pdf' => $newPdf ?? $currentProduct['catalogue_pdf'],
                        ':cover' => $newCover ?? $currentProduct['cover_image'],
                        ':description' => $description,
                        ':status' => $status,
                        ':id' => $id,
                    ]);
                } catch (Exception $uploadOrDb) {
                    if ($newPdf) crm_delete_upload($newPdf, 'catalogue');
                    if ($newCover) crm_delete_upload($newCover, 'products');
                    throw $uploadOrDb;
                }
                if ($newPdf && $currentProduct['catalogue_pdf']) {
                    crm_delete_upload($currentProduct['catalogue_pdf'], 'catalogue');
                }
                if ($newCover && $currentProduct['cover_image']) {
                    crm_delete_upload($currentProduct['cover_image'], 'products');
                }

                returnJsonSuccess('Product updated successfully');
                
            } catch (Exception $e) {
                returnJsonError(crm_public_error($e));
            }
        }

        if ($action === 'delete') {
            try {
                // Delete product
                $id = $_POST['id'] ?? null;
                
                if (empty($id)) {
                    throw new Exception('Product ID is required');
                }
                
                // Get PDF path before deletion
                $getStmt = $conn->prepare('SELECT catalogue_pdf, cover_image FROM products WHERE product_id = :id');
                $getStmt->execute([':id' => $id]);
                $product = $getStmt->fetch(PDO::FETCH_ASSOC);
                
                // Delete from database
                $sql = "DELETE FROM products WHERE product_id=:id";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([':id' => $id]);
                
                if (!$result) {
                    throw new Exception('Database error: ' . implode(', ', $stmt->errorInfo()));
                }
                
                // Delete PDF file if exists
                if ($product && $product['catalogue_pdf']) {
                    crm_delete_upload($product['catalogue_pdf'], 'catalogue');
                }
                if ($product && $product['cover_image']) {
                    crm_delete_upload($product['cover_image'], 'products');
                }
                
                returnJsonSuccess('Product deleted successfully');
                
            } catch (Exception $e) {
                returnJsonError(crm_public_error($e));
            }
        }

        // Invalid action
        returnJsonError('Invalid action');
    }

    // GET: Fetch products (pagination) - This is the main data loading
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $rowsPerPage = isset($_GET['rowsPerPage']) ? (int)$_GET['rowsPerPage'] : 5;
    $startIndex = ($page - 1) * $rowsPerPage;
    
    // Filter parameters
    $categoryFilter = isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : null;
    $statusFilter = isset($_GET['status']) && $_GET['status'] !== '' ? $_GET['status'] : null;
    
    // Build WHERE clause for filters
    $whereConditions = [];
    $params = [];
    
    if ($categoryFilter) {
        $whereConditions[] = "p.category_id = :category_filter";
        $params[':category_filter'] = $categoryFilter;
    }
    
    if ($statusFilter) {
        $whereConditions[] = "p.product_status = :status_filter";
        $params[':status_filter'] = $statusFilter;
    } else {
        // Default to active products if no status filter is specified
        $whereConditions[] = "p.product_status = 'active'";
    }
    
    $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
    
    // Count query with filters
    $countSql = "SELECT COUNT(*) as total FROM products p LEFT JOIN product_categories c ON p.category_id = c.category_id " . $whereClause;
    $countStmt = $conn->prepare($countSql);
    $countStmt->execute($params);
    $totalProducts = $countStmt->fetchColumn();
    $totalPages = ceil($totalProducts / $rowsPerPage);

    $sql = "
        SELECT 
            p.product_id AS id,
            p.product_name AS name,
            c.category_name AS category,
            c.category_id AS category_id,
            CONCAT('₹', FORMAT(p.product_cost, 2, 'en_IN')) AS cost,
            p.product_cost,
            p.catalogue_pdf AS pdf,
            p.cover_image,
            p.product_description AS description,
            p.product_status AS status
        FROM products p
        LEFT JOIN product_categories c ON p.category_id = c.category_id
        " . $whereClause . "
        ORDER BY p.product_id DESC
        LIMIT :limit OFFSET :offset
    ";
    $stmt = $conn->prepare($sql);
    
    // Bind filter parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    // Bind pagination parameters
    $stmt->bindValue(':limit', $rowsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $startIndex, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll();

    $response = [
        'products' => $products,
        'pagination' => [
            'page' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts
        ]
    ];

    echo json_encode($response);

} catch (Exception $e) {
    returnJsonError(crm_public_error($e));
} finally {
    if (isset($db)) {
        $db->closeConnection();
    }
}