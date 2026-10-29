<?php
/**
 * Helpers for the website's public form endpoints (contact, newsletter, reviews, job applications).
 *
 *   public_form_begin('contact', 5, 3600);   // POST only, honeypot check, max 5 per IP per hour
 *   $name = public_form_field('name', 100);
 *   public_form_reply(true, 'Thanks!');
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/app.php';

function public_form_reply($success, $message, $status = 200, array $extra = []) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message] + $extra);
    exit;
}

function public_form_ip_hash() {
    $salt = nm_config('NM_IP_SALT') ?: 'nm-infocom-forms';
    return hash('sha256', $salt . '|' . ($_SERVER['REMOTE_ADDR'] ?? ''));
}

/** Rejects non-POST requests, silently drops honeypot hits, and enforces a per-IP rate limit. */
function public_form_begin($form, $maxPerWindow, $windowSeconds) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        public_form_reply(false, 'Invalid request method', 405);
    }
    // Bots fill the hidden "website" field; pretend success so they don't retry.
    if (trim($_POST['website'] ?? '') !== '') {
        public_form_reply(true, 'Thank you!');
    }
    try {
        $conn = getDBConnection();
        // Window computed by the database so it matches created_at's clock.
        $stmt = $conn->prepare('SELECT COUNT(*) FROM form_submission_log
                                WHERE form = ? AND ip_hash = ? AND created_at >= NOW() - INTERVAL ? SECOND');
        $stmt->execute([$form, public_form_ip_hash(), (int) $windowSeconds]);
        if ((int) $stmt->fetchColumn() >= $maxPerWindow) {
            public_form_reply(false, 'Too many submissions. Please try again later.', 429);
        }
    } catch (Exception $e) {
        // Logging table missing: fail open rather than blocking real customers.
        error_log("public_form rate limit ($form): " . $e->getMessage());
    }
}

/** Call after a successful insert so the submission counts toward the rate limit. */
function public_form_record($form) {
    try {
        getDBConnection()->prepare('INSERT INTO form_submission_log (form, ip_hash) VALUES (?, ?)')
                         ->execute([$form, public_form_ip_hash()]);
    } catch (Exception $e) {
        error_log("public_form record ($form): " . $e->getMessage());
    }
}

/** Trimmed POST value with control characters removed, cut to $maxLength characters. */
function public_form_field($name, $maxLength) {
    $value = trim((string) ($_POST[$name] ?? ''));
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
    return mb_substr($value, 0, $maxLength);
}
