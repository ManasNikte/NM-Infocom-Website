<?php
// Product page "Enquire" form -> a new lead, and bumps the product's enquiry counters.
require_once __DIR__ . '/public_form.php';

public_form_begin('enquiry', 10, 3600);

$name = public_form_field('name', 100);
$email = public_form_field('email', 100);
$phone = public_form_field('phone', 20);
$productId = ctype_digit((string) ($_POST['product_id'] ?? '')) ? (int) $_POST['product_id'] : 0;
$quantity = max(1, min(100000, (int) ($_POST['quantity'] ?? 1)));

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9+\-()\s]{10,20}$/', $phone)) {
    public_form_reply(false, 'Please enter your name, a valid email and phone number.', 422);
}

try {
    $conn = getDBConnection();
    // Use the catalogue's product name rather than trusting the posted text.
    $stmt = $conn->prepare("SELECT product_name FROM products WHERE product_id = ? AND product_status = 'active'");
    $stmt->execute([$productId]);
    $productName = $stmt->fetchColumn() ?: public_form_field('product_name', 100);
    if ($productName === '') {
        public_form_reply(false, 'Please choose a product.', 422);
    }

    $conn->prepare("INSERT INTO leads (name, contact, email, product, quantity, status, added_on) VALUES (?, ?, ?, ?, ?, 'new', NOW())")
         ->execute([$name, $phone, $email, $productName, $quantity]);
    if ($productId) {
        $conn->prepare('UPDATE products SET enquiries_count = enquiries_count + 1, last_enquiry = CURDATE() WHERE product_id = ?')
             ->execute([$productId]);
    }
    public_form_record('enquiry');
    public_form_reply(true, 'Thank you for your enquiry! We will get back to you soon.');
} catch (Exception $e) {
    error_log('enquiry_sumbission: ' . $e->getMessage());
    public_form_reply(false, 'Failed to submit your enquiry. Please try again later.', 500);
}
