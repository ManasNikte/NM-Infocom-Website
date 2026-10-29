<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'hr');
header('Content-Type: application/json');

// Enable error reporting for debugging

function getCareerData($page = 1, $itemsPerPage = 5) {
    $database = new Database();
    $conn = $database->getConnection();

    $startIndex = ($page - 1) * $itemsPerPage;

    // Fetch all relevant columns from the careers table, ordered by id DESC (latest first)
    $query = "SELECT 
        id, title, category, type, location, salary, description, skills, icon, 
        date_posted, deadline, experience, education, responsibilities, requirements, 
        date_added, last_modified
        FROM careers
        ORDER BY id DESC
        LIMIT :startIndex, :itemsPerPage";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':startIndex', $startIndex, PDO::PARAM_INT);
    $stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $careerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of career entries
    $totalQuery = "SELECT COUNT(*) as totalItems FROM careers";
    $totalStmt = $conn->prepare($totalQuery);
    $totalStmt->execute();
    $totalItems = $totalStmt->fetch(PDO::FETCH_ASSOC)['totalItems'];

    return [
        'totalItems' => $totalItems,
        'pageData' => $careerData,
    ];
}

function getCareerById($id) {
    $database = new Database();
    $conn = $database->getConnection();
    $query = "SELECT 
        id, title, category, type, location, salary, description, skills, icon, 
        date_posted, deadline, experience, education, responsibilities, requirements, 
        date_added, last_modified
        FROM careers WHERE id = :id LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);
    return $job;
}

try {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $job = getCareerById($id);
        if ($job) {
            echo json_encode($job);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Job not found']);
        }
        exit;
    }
    
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = isset($_GET['rowsPerPage']) ? (int)$_GET['rowsPerPage'] : 5;
    $data = getCareerData($page, $itemsPerPage);

    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
?>

<script>
    const currentPage = 1;
    const rowsPerPage = 5;

    fetch(`./data/career_data.php?page=${currentPage}&rowsPerPage=${rowsPerPage}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle the data
            console.log(data);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
</script>
