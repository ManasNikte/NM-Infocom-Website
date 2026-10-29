<?php
require_once __DIR__ . '/../config/database.php';

class ClientsData {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Get all clients
     */
    public function getClients() {
        try {
            $query = "
                SELECT client_id, client_img, client_name, date_added, last_modified 
                FROM clients 
                ORDER BY client_id ASC
            ";
            
            $stmt = $this->conn->query($query);
            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Debug log
            error_log("Fetched clients data: " . print_r($clients, true));

            return $clients;

        } catch (PDOException $e) {
            error_log("Error fetching clients: " . $e->getMessage());
            return [];
        }
    }
}

// Get the data
try {
    $clientsDataObj = new ClientsData();
    $clients_data = $clientsDataObj->getClients();
} catch (Exception $e) {
    error_log("Error initializing ClientsData: " . $e->getMessage());
    $clients_data = [];
}

// Debug information
if (empty($clients_data)) {
    error_log("Clients data is empty");
} else {
    error_log("Successfully loaded " . count($clients_data) . " clients");
}
?> 