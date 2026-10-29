<?php
// Website "Contact" form -> contact_submits (shown to the website manager in the CRM).
require_once __DIR__ . '/public_form.php';

public_form_begin('contact', 5, 3600);

$name = public_form_field('name', 100);
$email = public_form_field('email', 150);
$contact = public_form_field('contact', 20);
$subject = public_form_field('subject', 120);
$message = public_form_field('message', 1000);

$errors = [];
if ($name === '') $errors[] = 'Please enter your name.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
if (!preg_match('/^\+?[0-9 ()-]{7,20}$/', $contact)) $errors[] = 'Please enter a valid phone number.';
if ($subject === '') $errors[] = 'Please choose what you are interested in.';
if (mb_strlen($message) < 10) $errors[] = 'Please tell us a little more (at least 10 characters).';
if ($errors) {
    public_form_reply(false, 'Please check the form.', 422, ['errors' => $errors]);
}

try {
    // Stored as plain text; every place that displays it must escape on output.
    getDBConnection()->prepare("INSERT INTO contact_submits (name, email, contact, subject, message, status, added_on)
                                VALUES (?, ?, ?, ?, ?, 'Pending', NOW())")
                     ->execute([$name, $email, $contact, $subject, $message]);
    public_form_record('contact');
    public_form_reply(true, 'Thank you for contacting us. We will get back to you soon.');
} catch (Exception $e) {
    error_log('handle_contact_form: ' . $e->getMessage());
    public_form_reply(false, 'Something went wrong. Please try again later.', 500);
}
