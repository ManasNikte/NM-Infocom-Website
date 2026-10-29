<?php
require_once __DIR__ . '/../config/database.php';

function getStatsData() {
    $conn = getDBConnection();
    
    // Initialize default values
    $stats = [
        'total' => [
            'client_count' => 0,
            'websites_count' => 0,
            'hours_of_support' => 0,
            'emp_count' => 0
        ]
    ];
    
    try {
        // Get all stats from database
        $query = "SELECT stat, counts FROM stats_total";
        $stmt = $conn->query($query);
        
        // Map database results to stats array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            switch ($row['stat']) {
                case 'client':
                    $stats['total']['client_count'] = (int)$row['counts'];
                    break;
                case 'websites':
                    $stats['total']['websites_count'] = (int)$row['counts'];
                    break;
                case 'hours_of_support':
                    $stats['total']['hours_of_support'] = (int)$row['counts'];
                    break;
                case 'employee_count':
                    $stats['total']['emp_count'] = (int)$row['counts'];
                    break;
            }
        }
    } catch (PDOException $e) {
        // Handle database error
        error_log("Database error: " . $e->getMessage());
    }
    
    return $stats;
}

// Function to update stats
function updateStat($stat, $count) {
    global $conn;
    
    try {
        $query = "UPDATE stats_total SET 
                  counts = :count,
                  last_modified = CURRENT_TIMESTAMP 
                  WHERE stat = :stat";
                  
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            ':count' => (int)$count,
            ':stat' => $stat
        ]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

// Function to get a specific stat
function getStat($stat) {
    global $conn;
    
    try {
        $query = "SELECT counts FROM stats_total WHERE stat = :stat";
        $stmt = $conn->prepare($query);
        $stmt->execute([':stat' => $stat]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return (int)$row['counts'];
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
    }
    
    return 0;
}
?>
