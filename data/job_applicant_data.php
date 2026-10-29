<?php
// Careers page "Apply" form -> job_applicants, with the resume saved to uploads/resume/.
require_once __DIR__ . '/public_form.php';

public_form_begin('job_application', 5, 3600);

$fullName = public_form_field('full_name', 255);
$email = public_form_field('email', 255);
$contact = public_form_field('contact', 20);
$location = public_form_field('location', 255);
$jobId = ctype_digit((string) ($_POST['job_id'] ?? '')) ? (int) $_POST['job_id'] : null;

if ($fullName === '' || $location === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || !preg_match('/^\+?[0-9 ()-]{7,20}$/', $contact)) {
    public_form_reply(false, 'Please fill in your name, a valid email, phone number and location.', 422);
}

// Resume: PDF only (checked by content, not by the client's filename), max 5 MB.
$file = $_FILES['resume'] ?? null;
if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    public_form_reply(false, 'Please attach your resume as a PDF.', 422);
}
if ($file['size'] > 5 * 1024 * 1024) {
    public_form_reply(false, 'Your resume must be 5 MB or smaller.', 422);
}
$mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
$header = (string) file_get_contents($file['tmp_name'], false, null, 0, 5);
if ($mime !== 'application/pdf' || $header !== '%PDF-') {
    public_form_reply(false, 'Your resume must be a PDF file.', 422);
}

if ($jobId !== null) {
    $stmt = getDBConnection()->prepare('SELECT COUNT(*) FROM careers WHERE id = ?');
    $stmt->execute([$jobId]);
    if (!$stmt->fetchColumn()) {
        $jobId = null;
    }
}

$uploadDir = __DIR__ . '/../uploads/resume/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
$filename = 'EMP_' . bin2hex(random_bytes(8)) . '_' . time() . '.pdf';
if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
    error_log('job_applicant_data: could not move upload to ' . $uploadDir);
    public_form_reply(false, 'We could not save your resume. Please try again later.', 500);
}
chmod($uploadDir . $filename, 0644);

try {
    getDBConnection()->prepare("INSERT INTO job_applicants (job_id, full_name, email, contact, location, pdf_link, status, date_applied)
                                VALUES (?, ?, ?, ?, ?, ?, 'Applied', NOW())")
                     ->execute([$jobId, $fullName, $email, $contact, $location, 'resume/' . $filename]);
    public_form_record('job_application');
    public_form_reply(true, 'Application received. Thank you!');
} catch (Exception $e) {
    error_log('job_applicant_data: ' . $e->getMessage());
    @unlink($uploadDir . $filename);
    public_form_reply(false, 'Something went wrong. Please try again later.', 500);
}
