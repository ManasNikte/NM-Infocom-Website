<?php
require_once __DIR__ . '/app.php';

// Errors go to the log; show them on screen only when APP_DEBUG=1 is set (local development).
ini_set('display_errors', nm_debug() ? '1' : '0');
ini_set('log_errors', '1');

// Connection details come from .env / environment (DB_HOST, DB_NAME, DB_USER, DB_PASS).
class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn = null;

    public function __construct() {
        $this->host = nm_config('DB_HOST', 'localhost');
        $this->dbname = nm_config('DB_NAME', 'nm');
        $this->username = nm_config('DB_USER', 'root');
        $this->password = nm_config('DB_PASS', '');
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4", 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            // Don't echo or exit here - let the calling code handle it
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed.");
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

// For direct database access when needed
function getDBConnection() {
    static $db = null;
    if ($db === null) {
        $db = new Database();
    }
    return $db->getConnection();
}
