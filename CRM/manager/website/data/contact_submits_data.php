<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');

header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'data' => [],
    'message' => ''
];

try {
    // Get pagination parameters
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $rowsPerPage = isset($_GET['rowsPerPage']) ? (int)$_GET['rowsPerPage'] : 5;
    $offset = ($page - 1) * $rowsPerPage;

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db === null) {
        throw new Exception('Database connection failed');
    }
    
    // Get search term and status filter
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    $statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
    
    // Build WHERE conditions
    $whereConditions = [];
    $params = [];
    
    if (!empty($searchTerm)) {
        $searchParam = "%$searchTerm%";
        $whereConditions[] = "(name LIKE :search1 OR email LIKE :search2 OR contact LIKE :search3 OR subject LIKE :search4 OR message LIKE :search5)";
        $params[':search1'] = $searchParam;
        $params[':search2'] = $searchParam;
        $params[':search3'] = $searchParam;
        $params[':search4'] = $searchParam;
        $params[':search5'] = $searchParam;
    }
    
    if (!empty($statusFilter)) {
        if ($statusFilter === 'pending') {
            $whereConditions[] = "(status IS NULL OR status = 'pending' OR status = '')";
        } else if ($statusFilter === 'responded') {
            $whereConditions[] = "status = 'responded'";
        }
    }
    
    $whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';
    
    // First, get total count for pagination with filters
    $countQuery = "SELECT COUNT(*) as total FROM contact_submits $whereClause";
    $countStmt = $db->prepare($countQuery);
    
    // Bind all parameters to the count statement
    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    
    $countStmt->execute();
    $totalSubmits = (int)$countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalSubmits / $rowsPerPage);
    
    // Prepare and execute main query with pagination and filters
    $query = "SELECT 
                id, 
                name, 
                email, 
                contact, 
                subject, 
                message, 
                DATE(added_on) as date,
                TIME(added_on) as time,
                COALESCE(status, 'pending') as status,
                responded_on,
                response_message
              FROM contact_submits 
              $whereClause
              ORDER BY added_on DESC
              LIMIT :limit OFFSET :offset";
    
    $stmt = $db->prepare($query);
    
    // Bind all parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    
    // Bind pagination parameters
    $stmt->bindValue(':limit', $rowsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch all rows
    $contactSubmits = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $contactSubmits[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'], // escaped by the page when rendered
            'email' => $row['email'], // escaped by the page when rendered
            'contact' => $row['contact'], // escaped by the page when rendered
            'subject' => $row['subject'], // escaped by the page when rendered
            'message' => $row['message'], // escaped by the page when rendered
            'date' => $row['date'],
            'time' => $row['time'],
            'status' => $row['status'],
            'responded_on' => $row['responded_on'],
            'response_message' => $row['response_message']
        ];
    }
    
    $response = [
        'success' => true,
        'data' => $contactSubmits,
        'total' => $totalSubmits,
        'page' => $page,
        'rowsPerPage' => $rowsPerPage,
        'totalPages' => $totalPages
    ];
    
} catch (Exception $e) {
    http_response_code(500);
    $response = [
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'data' => []
    ];
    error_log('Error in contact_submits_data.php: ' . $e->getMessage());
}

echo json_encode($response);
?>