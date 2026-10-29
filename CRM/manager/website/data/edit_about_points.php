<?php
require_once __DIR__ . '/../../../config/auth.php';
$auth = crm_require_api(['Admin', 'Manager'], 'website');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aboutId = $_POST['about_id'];
    $points = $_POST['points'];

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $conn->beginTransaction();

        foreach ($points as $pointId => $pointData) {
            $query = "UPDATE about_points SET heading = :heading, description = :description WHERE about_pointsid = :point_id AND about_id = :about_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':heading', $pointData['heading']);
            $stmt->bindParam(':description', $pointData['description']);
            $stmt->bindParam(':point_id', $pointId);
            $stmt->bindParam(':about_id', $aboutId);

            if (!$stmt->execute()) {
                throw new PDOException('Failed to update point ID ' . $pointId);
            }
        }

        $conn->commit();
        $response['success'] = true;
        $response['message'] = 'About points updated successfully';
    } catch (PDOException $e) {
        $conn->rollBack();
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
