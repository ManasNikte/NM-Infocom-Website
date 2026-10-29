<?php
/**
 * Server settings and secrets (database, SMTP, CRM_JWT_SECRET, ...).
 *
 * Each key is looked up, first match wins:
 *   1. real environment variables (getenv / SetEnv)
 *   2. a .env file OUTSIDE the web root: the folder that contains this project
 *      (on Hostinger: domains/<your-domain>/.env, next to public_html)
 *   3. a .env file in the project root (blocked from the web by .htaccess)
 * See .env.example for every key.
 */
function nm_config($key, $default = null) {
    static $settings = null;
    if ($settings === null) {
        $settings = [];
        // Later files win, so load the in-project .env first and the outside-web-root one last.
        foreach ([dirname(__DIR__) . '/.env', dirname(__DIR__, 2) . '/.env'] as $envFile) {
            if (is_file($envFile) && is_readable($envFile)) {
                $settings = nm_parse_env_file($envFile) + $settings;
            }
        }
    }
    $env = getenv($key);
    if ($env !== false && $env !== '') {
        return $env;
    }
    return $settings[$key] ?? $default;
}

/** Minimal .env parser: KEY=value lines, optional quotes, # comments, "export " prefix allowed. */
function nm_parse_env_file($path) {
    $values = [];
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        if (str_starts_with($line, 'export ')) {
            $line = substr($line, 7);
        }
        [$name, $value] = array_pad(explode('=', $line, 2), 2, '');
        $name = trim($name);
        $value = trim($value);
        if ($value !== '' && ($value[0] === '"' || $value[0] === "'") && substr($value, -1) === $value[0]) {
            $value = substr($value, 1, -1);
        } elseif (($hash = strpos($value, ' #')) !== false) {
            $value = rtrim(substr($value, 0, $hash));
        }
        if (preg_match('/^[A-Z][A-Z0-9_]*$/', $name)) {
            $values[$name] = $value;
        }
    }
    return $values;
}

/** True when running locally with APP_DEBUG=1 (shows errors, allows insecure fallbacks). */
function nm_debug() {
    return (bool) nm_config('APP_DEBUG', false);
}
