<?php
// "Leave a review" form -> reviews (status 'pending' until the website manager publishes it).
require_once __DIR__ . '/data/public_form.php';

public_form_begin('review', 3, 3600);

$name = public_form_field('name', 255);
$email = public_form_field('email', 255);
$designation = public_form_field('designation', 255);
$review = public_form_field('review', 2000);
$rating = (int) ($_POST['rating'] ?? 0);

if ($name === '' || $designation === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    public_form_reply(false, 'Please fill in your name, email and designation.', 422);
}
if ($rating < 1 || $rating > 5) {
    public_form_reply(false, 'Please select a rating.', 422);
}
if (mb_strlen($review) < 10) {
    public_form_reply(false, 'Please write a few words about your experience.', 422);
}

try {
    getDBConnection()->prepare("INSERT INTO reviews (reviewer_name, reviewer_email, reviewer_designation, reviewer_rating, review_text, reviewer_date, reviewer_status)
                                VALUES (?, ?, ?, ?, ?, CURDATE(), 'pending')")
                     ->execute([$name, $email, $designation, $rating, $review]);
    public_form_record('review');
    public_form_reply(true, 'Thank you for your review! It will be published after moderation.', 200, ['redirect' => 'index.php#reviews']);
} catch (Exception $e) {
    error_log('submit_review: ' . $e->getMessage());
    public_form_reply(false, 'Something went wrong. Please try again later.', 500);
}
