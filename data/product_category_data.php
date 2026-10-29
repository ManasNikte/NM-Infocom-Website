<?php
require_once __DIR__ . '/../config/database.php';

class ProductCategory {
    private static $categories = [];
    private static $conn = null;
    
    public static function initialize() {
        try {
            $database = new Database();
            self::$conn = $database->getConnection();
            
            $query = "SELECT * FROM product_categories WHERE status = 'active'";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $row) {
                self::$categories[$row['category_id']] = $row;
            }
            
            return self::$categories;
            
        } catch (PDOException $e) {
            error_log("Database Error in ProductCategory::initialize: " . $e->getMessage());
            return [];
        }
    }
    
    public static function getAllCategories() {
        return self::$categories;
    }
    
    public static function getActiveCategories() {
        return array_filter(self::$categories, function($category) {
            return $category['status'] === 'active';
        });
    }
    
    public static function calculateProductCounts() {
        try {
            $query = "SELECT c.category_id, COUNT(p.product_id) as num_of_products 
                     FROM product_categories c 
                     LEFT JOIN products p ON c.category_id = p.category_id 
                     WHERE c.status = 'active' 
                     GROUP BY c.category_id";
                     
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($results as $row) {
                if (isset(self::$categories[$row['category_id']])) {
                    self::$categories[$row['category_id']]['num_of_products'] = $row['num_of_products'];
                }
            }
            
            return self::$categories;
            
        } catch (PDOException $e) {
            error_log("Database Error in ProductCategory::calculateProductCounts: " . $e->getMessage());
            return self::$categories;
        }
    }
}

// Initialize and get the categories
$categoriesData = ProductCategory::initialize();

// Calculate product counts
if (!empty($categoriesData)) {
    $categoriesData = ProductCategory::calculateProductCounts();
}

return $categoriesData;