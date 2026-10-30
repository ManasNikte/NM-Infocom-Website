<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');

try {
    $databasePath = __DIR__ . '/../../../config/database.php';
    if (!file_exists($databasePath)) {
        throw new Exception('Database configuration file not found at: ' . $databasePath);
    }
    require_once $databasePath;
    $database = new Database();
    $pdo = $database->getConnection();
    if (!$pdo) {
        throw new Exception('Failed to connect to database');
    }

    // 1. Total Contact Submits
    $stmt = $pdo->query("SELECT COUNT(*) FROM contact_submits");
    $total_submits = (int)$stmt->fetchColumn();

    // 2. Responded Submits (where status is 'responded')
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_submits WHERE status = 'responded'");
    $stmt->execute();
    $responded_count = (int)$stmt->fetchColumn();

    // 3. Response Pending (where status is NULL, empty, or 'pending')
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_submits WHERE status IS NULL OR status = '' OR status = 'pending'");
    $stmt->execute();
    $pending_count = (int)$stmt->fetchColumn();

    // 4. Today's Form Submits
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_submits WHERE DATE(added_on) = CURDATE()");
    $stmt->execute();
    $today_count = (int)$stmt->fetchColumn();

    // Get yesterday's count for percentage change
    $yesterday_stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_submits WHERE DATE(added_on) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
    $yesterday_stmt->execute();
    $yesterday_count = (int)$yesterday_stmt->fetchColumn();
    
    // Calculate percentage change
    $today_percent = 0;
    if ($yesterday_count > 0) {
        $today_percent = (int)((($today_count - $yesterday_count) / $yesterday_count) * 100);
    } elseif ($today_count > 0) {
        $today_percent = 100;
    }

    // Prepare response
    $response = [
        'success' => true,
        'data' => [
            'total_submits' => $total_submits,
            'responded_count' => $responded_count,
            'pending_count' => $pending_count,
            'today_count' => $today_count,
            'today_percent' => $today_percent
        ]
    ];
    
    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => crm_public_error($e)
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => crm_public_error($e)
    ]);
}
