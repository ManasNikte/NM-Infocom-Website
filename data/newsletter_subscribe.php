<?php
// Footer newsletter form -> newsletter_subscribers.
require_once __DIR__ . '/public_form.php';

public_form_begin('newsletter', 5, 3600);

$email = strtolower(public_form_field('email', 150));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    public_form_reply(false, 'Please enter a valid email address.', 422);
}

try {
    getDBConnection()->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)
                                ON DUPLICATE KEY UPDATE status = 'subscribed'")
                     ->execute([$email]);
    public_form_record('newsletter');
    public_form_reply(true, "You're subscribed. Thanks for joining!");
} catch (Exception $e) {
    error_log('newsletter_subscribe: ' . $e->getMessage());
    public_form_reply(false, 'Could not subscribe right now. Please try again later.', 500);
}
