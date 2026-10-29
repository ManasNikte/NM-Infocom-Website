<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'purchase');



header('Content-Type: application/json');

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Get parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status = isset($_GET['status']) ? trim($_GET['status']) : 'all';
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $items_per_page = 6;

    $sql = "SELECT t.id, u.name, t.task, t.date_added, t.due_date, t.date_of_completion, t.status
            FROM tasks t
            JOIN users u ON t.assigned_to = u.id
            WHERE u.role = 'Employee' AND u.sub_role = 'purchase'";
    $params = [];

    if ($status !== 'all' && $status !== '') {
        $sql .= " AND t.status = :status";
        $params[':status'] = $status;
    }

    // Always add the search filter, even if empty
    $sql .= " AND (LOWER(t.task) LIKE :search_task
        OR LOWER(t.status) LIKE :search_status
        OR LOWER(u.name) LIKE :search_name
        OR LOWER(t.date_added) LIKE :search_date_added
        OR LOWER(t.due_date) LIKE :search_due_date
        OR LOWER(t.date_of_completion) LIKE :search_date_of_completion
        OR t.id = :search_id
    )";
    $params[':search_task'] = '%' . strtolower($search) . '%';
    $params[':search_status'] = '%' . strtolower($search) . '%';
    $params[':search_name'] = '%' . strtolower($search) . '%';
    $params[':search_date_added'] = '%' . strtolower($search) . '%';
    $params[':search_due_date'] = '%' . strtolower($search) . '%';
    $params[':search_date_of_completion'] = '%' . strtolower($search) . '%';
    if (is_numeric($search)) {
        $params[':search_id'] = intval($search);
    } else {
        $params[':search_id'] = -1;
    }

    // Count total items
    $count_sql = "SELECT COUNT(*) FROM tasks t JOIN users u ON t.assigned_to = u.id WHERE u.role = 'Employee' AND u.sub_role = 'marketing'";
    $count_params = [];
    if ($status !== 'all' && $status !== '') {
        $count_sql .= " AND t.status = :status";
        $count_params[':status'] = $status;
    }
    // Always add the search filter, even if empty
    $count_sql .= " AND (LOWER(t.task) LIKE :search_task
        OR LOWER(t.status) LIKE :search_status
        OR LOWER(u.name) LIKE :search_name
        OR LOWER(t.date_added) LIKE :search_date_added
        OR LOWER(t.due_date) LIKE :search_due_date
        OR LOWER(t.date_of_completion) LIKE :search_date_of_completion
        OR t.id = :search_id
    )";
    $count_params[':search_task'] = $params[':search_task'];
    $count_params[':search_status'] = $params[':search_status'];
    $count_params[':search_name'] = $params[':search_name'];
    $count_params[':search_date_added'] = $params[':search_date_added'];
    $count_params[':search_due_date'] = $params[':search_due_date'];
    $count_params[':search_date_of_completion'] = $params[':search_date_of_completion'];
    $count_params[':search_id'] = $params[':search_id'];

    $count_stmt = $conn->prepare($count_sql);
    if (isset($count_params[':status'])) $count_stmt->bindValue(':status', $count_params[':status']);
    $count_stmt->bindValue(':search_task', $count_params[':search_task']);
    $count_stmt->bindValue(':search_status', $count_params[':search_status']);
    $count_stmt->bindValue(':search_name', $count_params[':search_name']);
    $count_stmt->bindValue(':search_date_added', $count_params[':search_date_added']);
    $count_stmt->bindValue(':search_due_date', $count_params[':search_due_date']);
    $count_stmt->bindValue(':search_date_of_completion', $count_params[':search_date_of_completion']);
    $count_stmt->bindValue(':search_id', $count_params[':search_id'], PDO::PARAM_INT);
    $count_stmt->execute();
    $total_items = $count_stmt->fetchColumn();
    $total_pages = ceil($total_items / $items_per_page);
    $offset = ($page - 1) * $items_per_page;

    $sql .= " ORDER BY t.id DESC LIMIT :limit OFFSET :offset";
    error_log('EMPLOYEE TASK SQL: ' . $sql);
    error_log('EMPLOYEE TASK PARAMS: ' . print_r($params, true));
    $stmt = $conn->prepare($sql);
    if (isset($params[':status'])) $stmt->bindValue(':status', $params[':status']);
    $stmt->bindValue(':search_task', $params[':search_task']);
    $stmt->bindValue(':search_status', $params[':search_status']);
    $stmt->bindValue(':search_name', $params[':search_name']);
    $stmt->bindValue(':search_date_added', $params[':search_date_added']);
    $stmt->bindValue(':search_due_date', $params[':search_due_date']);
    $stmt->bindValue(':search_date_of_completion', $params[':search_date_of_completion']);
    $stmt->bindValue(':search_id', $params[':search_id'], PDO::PARAM_INT);
    $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        error_log('EMPLOYEE TASK EXECUTE ERROR: ' . $e->getMessage());
        throw $e;
    }

    $tasks = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tasks[] = [
            $row['id'],
            $row['name'],
            $row['task'],
            $row['date_added'],
            $row['due_date'],
            $row['date_of_completion'] ? $row['date_of_completion'] : '-',
            ucfirst($row['status'])
        ];
    }

    echo json_encode([
        'success' => true,
        'tasks' => $tasks,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_items' => $total_items,
            'items_per_page' => $items_per_page,
            'showing_start' => $total_items > 0 ? ($offset + 1) : 0,
            'showing_end' => min($offset + $items_per_page, $total_items)
        ]
    ]);
} catch (Exception $e) {
    error_log('Employee task table error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to load employee tasks.'
    ]);
} 