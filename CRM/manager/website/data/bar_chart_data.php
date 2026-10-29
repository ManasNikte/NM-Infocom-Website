<?php
// "Monthly Enquiries" bar chart: website contact-form submissions over the last 3 months.
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
header('Content-Type: application/json');

$conn = (new Database())->getConnection();
$stmt = $conn->prepare("SELECT DATE_FORMAT(added_on, '%Y-%m'), COUNT(*) FROM contact_submits
                        WHERE added_on >= ? GROUP BY DATE_FORMAT(added_on, '%Y-%m')");
$stmt->execute([date('Y-m-01', strtotime('first day of -2 months'))]);
$counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$data = ['months' => [], 'values' => []];
for ($i = 2; $i >= 0; $i--) {
    $ts = strtotime("first day of -$i months");
    $data['months'][] = date('F', $ts);
    $data['values'][date('F', $ts)] = (int) ($counts[date('Y-m', $ts)] ?? 0);
}
echo json_encode($data);
