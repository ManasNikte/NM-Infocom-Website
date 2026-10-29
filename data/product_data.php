<?php
require_once __DIR__ . '/../config/database.php';

function getProductsData() {
    try {
        // Create new database instance
        $database = new Database();
        $conn = $database->getConnection();
        
        if (!$conn) {
            throw new Exception("Database connection failed");
        }
        
        $query = "SELECT p.*, c.category_name 
                  FROM products p 
                  JOIN product_categories c ON p.category_id = c.category_id 
                  WHERE p.product_status = 'active'";
                  
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return data as JSON if requested via AJAX
        if (isset($_GET['format']) && $_GET['format'] === 'json') {
            header('Content-Type: application/json');
            echo json_encode(['products' => $productsData]);
            exit;
        }
        
        return $productsData;
        
    } catch (PDOException $e) {
        // Log the error
        error_log("Database Error in getProductsData: " . $e->getMessage());
        return [];
    } catch (Exception $e) {
        // Log the error
        error_log("Error in getProductsData: " . $e->getMessage());
        return [];
    }
}

function getRelatedProducts($currentProductId, $categoryId, $limit = 3) {
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "SELECT p.*, c.category_name 
                  FROM products p 
                  JOIN product_categories c ON p.category_id = c.category_id 
                  WHERE p.product_status = 'active' 
                  AND p.category_id = :category_id 
                  AND p.product_id != :current_product_id 
                  ORDER BY p.date_added DESC 
                  LIMIT :limit";
                  
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':current_product_id', $currentProductId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Database Error in getRelatedProducts: " . $e->getMessage());
        return [];
    }
}

// Get the products data
$productsData = getProductsData();

// Return the data
return $productsData;