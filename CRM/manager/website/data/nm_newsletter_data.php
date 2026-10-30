<?php
// Newsletter subscribers (table newsletter_subscribers, filled by the public site's sign-up form).
//   GET  [search, status, page]       -> { success, totals, data, pagination }
//   GET  export=csv [search, status]  -> CSV download
//   POST action=status id, status     -> subscribed | unsubscribed
//   POST action=delete id
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');

try {
    $conn = (new Database())->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        $id = (int) ($_POST['id'] ?? 0);
        $action = $_POST['action'] ?? '';
        if ($action === 'status' && in_array($_POST['status'] ?? '', ['subscribed', 'unsubscribed'], true)) {
            $stmt = $conn->prepare('UPDATE newsletter_subscribers SET status = ? WHERE id = ?');
            $stmt->execute([$_POST['status'], $id]);
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare('DELETE FROM newsletter_subscribers WHERE id = ?');
            $stmt->execute([$id]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
            exit;
        }
        $found = $conn->prepare('SELECT COUNT(*) FROM newsletter_subscribers WHERE id = ?');
        $found->execute([$id]);
        echo json_encode($action === 'delete' ? ($stmt->rowCount() > 0 ? ['success' => true] : ['success' => false, 'message' => 'Subscriber not found'])
                                              : ($found->fetchColumn() ? ['success' => true] : ['success' => false, 'message' => 'Subscriber not found']));
        exit;
    }

    $where = ['1=1'];
    $params = [];
    if (($search = trim((string) ($_GET['search'] ?? ''))) !== '') {
        $where[] = 'email LIKE ?';
        $params[] = '%' . $search . '%';
    }
    if (in_array($_GET['status'] ?? '', ['subscribed', 'unsubscribed'], true)) {
        $where[] = 'status = ?';
        $params[] = $_GET['status'];
    }
    $whereSql = implode(' AND ', $where);

    if (($_GET['export'] ?? '') === 'csv') {
        $stmt = $conn->prepare("SELECT email, status, subscribed_at FROM newsletter_subscribers WHERE $whereSql ORDER BY subscribed_at DESC");
        $stmt->execute($params);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="newsletter-subscribers-' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Email', 'Status', 'Subscribed on']);
        foreach ($stmt->fetchAll(PDO::FETCH_NUM) as $row) {
            // A leading = + - @ would be run as a formula by spreadsheet apps.
            fputcsv($out, array_map(fn ($v) => preg_match('/^[=+\-@]/', (string) $v) ? "'" . $v : $v, $row));
        }
        exit;
    }

    header('Content-Type: application/json');
    $totals = $conn->query("SELECT
            SUM(status = 'subscribed') AS subscribed,
            SUM(status = 'unsubscribed') AS unsubscribed,
            SUM(status = 'subscribed' AND subscribed_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')) AS this_month,
            SUM(status = 'subscribed' AND subscribed_at >= CURDATE() - INTERVAL 30 DAY) AS last_30_days
        FROM newsletter_subscribers")->fetch(PDO::FETCH_ASSOC);

    $count = $conn->prepare("SELECT COUNT(*) FROM newsletter_subscribers WHERE $whereSql");
    $count->execute($params);
    $total = (int) $count->fetchColumn();
    $perPage = 10;
    $pages = max(1, (int) ceil($total / $perPage));
    $page = min($pages, max(1, (int) ($_GET['page'] ?? 1)));
    $stmt = $conn->prepare("SELECT id, email, status, subscribed_at FROM newsletter_subscribers WHERE $whereSql
                            ORDER BY subscribed_at DESC, id DESC LIMIT " . (($page - 1) * $perPage) . ", $perPage");
    $stmt->execute($params);

    echo json_encode([
        'success' => true,
        'totals' => array_map('intval', $totals),
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'pagination' => ['page' => $page, 'pages' => $pages, 'total' => $total, 'per_page' => $perPage],
    ]);
} catch (Exception $e) {
    if (!headers_sent()) {
        header('Content-Type: application/json');
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => crm_public_error($e)]);
}
