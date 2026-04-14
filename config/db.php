<?php

// Database credentials
define('DB_HOST', 'mysql-abhihours24-6206.d.aivencloud.com');
define('DB_PORT', '17086');
define('DB_USERNAME', 'avnadmin');
define('DB_PASSWORD', 'AVNS_md11gQiokKqjQCd8Cxn');
define('DB_NAME', 'SupplyNet');

// Create a new database connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8mb4
$conn->set_charset("utf8mb4");

require_once __DIR__ . '/notifications.php';

?>
