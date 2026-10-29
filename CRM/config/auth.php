<?php
/**
 * Shared JWT auth for every CRM page and data endpoint.
 *
 * Pages:      $auth = crm_require_page('Manager', 'sales');
 * Endpoints:  $auth = crm_require_api(['Admin', 'Manager'], 'sales');
 *
 * Both return the decoded token (id, email, role, sub_role) or stop the request.
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/app.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function crm_jwt_secret() {
    // Set CRM_JWT_SECRET (32+ random characters) in the server .env file (see .env.example).
    // The fallback only keeps old sessions valid until that is done.
    $secret = nm_config('CRM_JWT_SECRET');
    if ($secret && strlen($secret) >= 32) {
        return $secret;
    }
    // The development key is public (this repository is open source), so it is only ever
    // accepted locally with APP_DEBUG=1. Anywhere else the CRM refuses to sign or verify sessions.
    if (nm_debug()) {
        return 'local-development-only-insecure-jwt-signing-key';
    }
    error_log('SECURITY: CRM_JWT_SECRET is missing or shorter than 32 characters; CRM logins are disabled.');
    http_response_code(503);
    exit('CRM is not configured: set CRM_JWT_SECRET (32+ characters) in the server .env file.');
}

function crm_is_https() {
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
}

/** Session cookie attributes shared by login and logout. */
function crm_cookie_options($expires) {
    return ['expires' => $expires, 'path' => '/', 'secure' => crm_is_https(), 'httponly' => true, 'samesite' => 'Lax'];
}

/** Baseline headers for every CRM response (also set in .htaccess where Apache allows). */
function crm_security_headers() {
    if (headers_sent()) {
        return;
    }
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: same-origin');
    header('Cache-Control: no-store');
}

/**
 * Refuses state-changing requests (anything but GET/HEAD) that a browser reports as coming from another
 * site. Together with the SameSite=Lax cookie this blocks cross-site request forgery.
 */
function crm_reject_cross_site() {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    if ($method === 'GET' || $method === 'HEAD') {
        return;
    }
    $site = $_SERVER['HTTP_SEC_FETCH_SITE'] ?? '';
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    $crossOrigin = $origin !== '' && parse_url($origin, PHP_URL_HOST) !== parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
    if ($site === 'cross-site' || $crossOrigin) {
        if (basename($_SERVER['SCRIPT_NAME'] ?? '') === 'login.php') {
            header('Location: ../index.html?error=blocked');
            exit();
        }
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'status' => 'error', 'message' => 'Cross-site request blocked']);
        exit();
    }
}

function crm_issue_token(array $user) {
    $payload = [
        'id' => $user['id'],
        'email' => $user['email'],
        'role' => $user['role'],
        'sub_role' => $user['sub_role'],
        'iat' => time(),
        'exp' => time() + 60 * 60 * 24,
    ];
    $jwt = JWT::encode($payload, crm_jwt_secret(), 'HS256');
    setcookie('token', $jwt, crm_cookie_options(time() + 60 * 60 * 24));
}

/** Decoded token payload, or null when missing/invalid/expired. */
function crm_token() {
    static $decoded = false;
    if ($decoded === false) {
        $decoded = null;
        if (!empty($_COOKIE['token'])) {
            try {
                $decoded = JWT::decode($_COOKIE['token'], new Key(crm_jwt_secret(), 'HS256'));
            } catch (Exception $e) {
                $decoded = null;
            }
        }
    }
    return $decoded;
}

/** URL of the CRM login page, relative to the site root, wherever the app is installed. */
function crm_login_url() {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $pos = strpos($script, '/CRM/');
    return ($pos === false ? '' : substr($script, 0, $pos)) . '/CRM/index.html';
}

/**
 * @param string|string[] $roles    Allowed roles ('Admin', 'Manager', 'Employee').
 * @param string|null     $subRole  Required sub_role for non-admin roles (Admin always passes).
 */
function crm_is_allowed($token, $roles, $subRole = null) {
    if (!$token || empty($token->id) || empty($token->role)) {
        return false;
    }
    $role = strtolower($token->role);
    $allowed = array_map('strtolower', (array) $roles);
    if (!in_array($role, $allowed, true)) {
        return false;
    }
    return $role === 'admin' || $subRole === null || ($token->sub_role ?? null) === $subRole;
}

function crm_require_page($roles, $subRole = null) {
    crm_security_headers();
    crm_reject_cross_site();
    $token = crm_token();
    if (!crm_is_allowed($token, $roles, $subRole)) {
        header('Location: ' . crm_login_url());
        exit();
    }
    return $token;
}

function crm_require_api($roles, $subRole = null) {
    crm_security_headers();
    crm_reject_cross_site();
    $token = crm_token();
    if (!crm_is_allowed($token, $roles, $subRole)) {
        header('Content-Type: application/json');
        http_response_code($token ? 403 : 401);
        echo json_encode(['success' => false, 'status' => 'error', 'message' => $token ? 'Forbidden' : 'Unauthorized']);
        exit();
    }
    return $token;
}

/** The logged-in user's row (without password), or null. */
function crm_current_user(PDO $conn) {
    $token = crm_token();
    if (!$token || empty($token->id)) {
        return null;
    }
    $stmt = $conn->prepare('SELECT id, name, contact, email, DOB AS dob, role, sub_role, status, date_of_joining FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$token->id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
