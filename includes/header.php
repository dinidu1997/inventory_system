<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Inventory Management System</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Welcome, <?= $_SESSION['username'] ?> (<?= $_SESSION['role'] ?>)</span>
                    <a href="/auth/logout.php">Logout</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    
    <div class="container"></div>