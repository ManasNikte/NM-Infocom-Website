<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
// Initialize response array
$response = [
    'success' => false,
    'slides' => [],
    'pagination' => [],
    'message' => ''
];

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Get pagination parameters
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $rowsPerPage = isset($_GET['rowsPerPage']) ? (int)$_GET['rowsPerPage'] : 5;
    $offset = ($page - 1) * $rowsPerPage;

    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM about";
    $countStmt = $conn->query($countQuery);
    $totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalRows / $rowsPerPage);

    // Main query to get about data with points count
    $query = "
        SELECT 
            a.about_id,
            a.about_subintroline,
            (SELECT COUNT(*) FROM about_points ap WHERE ap.about_id = a.about_id) as points_count
        FROM about a
        ORDER BY a.about_id DESC
        LIMIT :offset, :limit
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $rowsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for response
    $formattedSlides = array_map(function($slide) {
        return [
            'slide_id' => $slide['about_id'],
            'slide_title' => 'About Section ' . $slide['about_id'],
            'slide_description' => $slide['about_subintroline'],
            'points_count' => $slide['points_count'],
            'link' => '#',  // Placeholder link
            'date_added' => '-',  // Placeholder since we don't have these columns
            'last_modified' => '-'  // Placeholder since we don't have these columns
        ];
    }, $slides);

    // Prepare pagination info
    $response['pagination'] = [
        'page' => $page,
        'rowsPerPage' => $rowsPerPage,
        'totalRows' => $totalRows,
        'totalPages' => $totalPages,
        'showing' => count($formattedSlides),
        'showingFrom' => $offset + 1,
        'showingTo' => min($offset + $rowsPerPage, $totalRows)
    ];

    $response['success'] = true;
    $response['slides'] = $formattedSlides;

} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
    error_log('Database error in about_slides_data.php: ' . $e->getMessage());
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
    error_log('Error in about_slides_data.php: ' . $e->getMessage());
}

// Handle POST requests for actions like delete, update, etc.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'delete':
                try {
                    // First delete related points
                    $deletePointsQuery = "DELETE FROM about_points WHERE about_id = :id";
                    $stmt = $conn->prepare($deletePointsQuery);
                    $stmt->execute(['id' => $data['slide_id']]);

                    // Then delete the about entry
                    $deleteQuery = "DELETE FROM about WHERE about_id = :id";
                    $stmt = $conn->prepare($deleteQuery);
                    $stmt->execute(['id' => $data['slide_id']]);

                    $response['success'] = true;
                    $response['message'] = 'About section deleted successfully';
                } catch (PDOException $e) {
                    $response['success'] = false;
                    $response['message'] = 'Error deleting about section: ' . $e->getMessage();
                }
                break;

            default:
                $response['message'] = 'Invalid action';
                break;
        }
    }
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response); 