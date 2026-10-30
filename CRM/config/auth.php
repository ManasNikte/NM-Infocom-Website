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
        if ($decoded && !crm_session_still_valid($decoded)) {
            $decoded = null;
        }
    }
    return $decoded;
}

/**
 * A signed token alone isn't enough: the account must still exist, be active, have the same role and
 * department, and the token must be newer than the account's last password change (tokens_valid_after).
 * So firing someone or changing a password ends their other sessions at once. One primary-key lookup per request.
 */
function crm_session_still_valid($token) {
    $id = (int) ($token->id ?? 0);
    try {
        $conn = (new Database())->getConnection();
        try {
            $stmt = $conn->prepare('SELECT role, sub_role, status, tokens_valid_after FROM users WHERE id = ?');
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Database not migrated yet (2026_10_30_session_revocation.sql): check everything except that column.
            error_log('crm_session_still_valid: ' . $e->getMessage() . ' (run database/migrations/2026_10_30_session_revocation.sql)');
            $stmt = $conn->prepare('SELECT role, sub_role, status, NULL AS tokens_valid_after FROM users WHERE id = ?');
            $stmt->execute([$id]);
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log('crm_session_still_valid: ' . $e->getMessage());
        return false;
    }
    if (!$row || !in_array(strtolower((string) $row['status']), ['', 'active'], true)) {
        return false;
    }
    if ($row['role'] !== ($token->role ?? null) || ($row['sub_role'] ?? null) !== ($token->sub_role ?? null)) {
        return false;
    }
    return !$row['tokens_valid_after'] || (int) ($token->iat ?? 0) >= strtotime($row['tokens_valid_after']);
}

/** URL of the CRM login page, relative to the site root, wherever the app is installed. */
function crm_login_url() {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $pos = strpos($script, '/CRM/');
    return ($pos === false ? '' : substr($script, 0, $pos)) . '/CRM/index.html';
}

/**
 * Department workspace a CRM URL path belongs to: ['Manager', 'sales'] for /CRM/manager/sales/…, null elsewhere.
 * Folder names are matched case-insensitively (manager/HR -> 'hr').
 */
function crm_workspace_of_path($path) {
    if (preg_match('#^(?:/[\w.-]+)*/CRM/(manager|employee)/(marketing|sales|purchase|website|hr)/(?:(?:data|analytics)/)?[\w.-]*$#i', (string) $path, $m)) {
        return [ucfirst(strtolower($m[1])), strtolower($m[2])];
    }
    return null;
}

/**
 * Admins can work inside any manager or employee workspace with that role's tools.
 *
 * The workspace comes from the script's own folder (pages and their data/ endpoints) or, for shared/
 * endpoints, from the same-origin page that called them (Referer). The returned token then reads as that
 * department's Manager/Employee, so every existing department check applies unchanged, while `id` stays the
 * admin's own (records show who acted) and `acting_admin` marks the session. Only a signed-in admin token
 * is ever converted, so the Referer cannot grant anything an admin couldn't already do.
 *
 * @return object|null acting token, or null when the request is not in a workspace this endpoint serves
 */
function crm_admin_workspace_token($token, array $allowed, $subRole) {
    $workspace = crm_workspace_of_path($_SERVER['SCRIPT_NAME'] ?? '');
    if (!$workspace && !empty($_SERVER['HTTP_REFERER'])) {
        $ref = parse_url($_SERVER['HTTP_REFERER']);
        $host = parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
        if (($ref['host'] ?? null) === $host) {
            $workspace = crm_workspace_of_path($ref['path'] ?? '');
        }
    }
    if (!$workspace) {
        return null;
    }
    [$actRole, $dept] = $workspace;
    if (!in_array(strtolower($actRole), $allowed, true) || ($subRole !== null && $subRole !== $dept)) {
        return null;
    }
    $acting = clone $token;
    $acting->role = $actRole;
    $acting->sub_role = $dept;
    $acting->acting_admin = true;
    return $acting;
}

/**
 * Applies the admin workspace rule: inside a workspace an admin acts as its manager/employee; elsewhere
 * (admin pages) the admin keeps admin rights. Non-admin tokens are returned unchanged.
 */
function crm_effective_token($token, $roles, $subRole) {
    if (!$token || strtolower($token->role ?? '') !== 'admin') {
        return $token;
    }
    $allowed = array_map('strtolower', (array) $roles);
    $acting = crm_admin_workspace_token($token, $allowed, $subRole);
    if ($acting) {
        return $acting;
    }
    return in_array('admin', $allowed, true) ? $token : null;
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
    $token = crm_effective_token(crm_token(), $roles, $subRole);
    if (!crm_is_allowed($token, $roles, $subRole)) {
        header('Location: ' . crm_login_url());
        exit();
    }
    return $token;
}

function crm_require_api($roles, $subRole = null) {
    crm_security_headers();
    crm_reject_cross_site();
    $raw = crm_token();
    $token = crm_effective_token($raw, $roles, $subRole);
    if (!crm_is_allowed($token, $roles, $subRole)) {
        $token = $raw;
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

/**
 * Message safe to show the user for a caught exception. Database/driver errors and anything that looks like
 * internals (SQL, file paths) become a generic message; deliberate validation messages pass through.
 * The full error always goes to the server log.
 */
function crm_public_error($e, $fallback = 'Something went wrong. Please try again.') {
    $message = $e instanceof Throwable ? $e->getMessage() : (string) $e;
    if ($e instanceof Throwable) {
        error_log(basename($e->getFile()) . ':' . $e->getLine() . ' ' . $message);
    }
    $internal = ($e instanceof PDOException)
        || preg_match('/SQLSTATE|PDO|mysqli|SQL syntax|Unknown column|Table \'|Duplicate entry|constraint|Integrity|Data truncated|\\/home\\/|\\/Users\\/|\\.php\\b|Stack trace/i', $message);
    return $internal ? $fallback : preg_replace('/^(Database error|DB error|Error|Server error):\s*/i', '', $message);
}
