<?php
require_once __DIR__ . '/../config/database.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function getCategories($conn) {
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    return $categories;
}

function getBuildings($conn) {
    $sql = "SELECT * FROM buildings";
    $result = $conn->query($sql);
    $buildings = [];
    while ($row = $result->fetch_assoc()) {
        $buildings[] = $row;
    }
    return $buildings;
}

function getInventoryItems($conn) {
    $sql = "SELECT i.*, b.building_name, c.name as category_name 
            FROM inventory i
            LEFT JOIN buildings b ON i.building_id = b.id
            LEFT JOIN standard_stock ss ON i.standard_stock_id = ss.id
            LEFT JOIN categories c ON ss.category_id = c.id";
    $result = $conn->query($sql);
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}
?>