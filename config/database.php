<?php
$host = '172.23.112.22';
$user = 'root';
$password = '';
$database = 'inventory_system';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($conn, $data) {
    return $conn->real_escape_string(htmlspecialchars(trim($data)));
}
?>