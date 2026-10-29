<?php
// Streams a product's catalogue PDF as a download: data/download_catalogue.php?id=<product_id>
require_once __DIR__ . '/../config/database.php';

$productId = ctype_digit((string) ($_GET['id'] ?? '')) ? (int) $_GET['id'] : 0;
$stmt = getDBConnection()->prepare("SELECT product_name, catalogue_pdf FROM products WHERE product_id = ? AND product_status = 'active'");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Only files inside uploads/catalogue/ are ever served.
$base = realpath(__DIR__ . '/../uploads/catalogue');
$file = ($product && $product['catalogue_pdf'] && $base) ? realpath($base . '/' . basename($product['catalogue_pdf'])) : false;
if (!$file || !str_starts_with($file, $base . DIRECTORY_SEPARATOR) || !is_file($file)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Catalogue not found.');
}

$downloadName = trim(preg_replace('/[^A-Za-z0-9]+/', '-', $product['product_name']), '-') ?: 'product';
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $downloadName . '-catalogue.pdf"');
header('Content-Length: ' . filesize($file));
header('X-Content-Type-Options: nosniff');
readfile($file);
