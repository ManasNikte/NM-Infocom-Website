<?php
// Connection to the WitJab website database (used by the website manager's WitJab pages).
// Settings come from .env / environment: WITJAB_DB_HOST, WITJAB_DB_NAME, WITJAB_DB_USER, WITJAB_DB_PASS.
require_once __DIR__ . '/../../../../config/app.php';

$conn = @new mysqli(
    nm_config('WITJAB_DB_HOST', nm_config('DB_HOST', 'localhost')),
    nm_config('WITJAB_DB_USER', nm_config('DB_USER', 'root')),
    nm_config('WITJAB_DB_PASS', nm_config('DB_PASS', '')),
    nm_config('WITJAB_DB_NAME', 'witjab')
);

if ($conn->connect_error) {
    error_log('WitJab database connection failed: ' . $conn->connect_error);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}
