<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    redirect('/auth/login.php');
}

// Get counts for dashboard
$inventory_count = $conn->query("SELECT COUNT(*) as count FROM inventory")->fetch_assoc()['count'];
$low_stock_count = $conn->query("SELECT COUNT(*) as count FROM standard_stock WHERE current_stock <= minimum_stock")->fetch_assoc()['count'];
$maintenance_count = $conn->query("SELECT COUNT(*) as count FROM maintenance_history WHERE next_maintenance_date <= CURDATE()")->fetch_assoc()['count'];
?>

<div class="dashboard">
    <h2>Dashboard</h2>
    
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Inventory Items</h3>
            <p><?= $inventory_count ?></p>
        </div>
        
        <div class="card">
            <h3>Low Stock Items</h3>
            <p><?= $low_stock_count ?></p>
        </div>
        
        <div class="card">
            <h3>Pending Maintenance</h3>
            <p><?= $maintenance_count ?></p>
        </div>
    </div>
    
    <div class="recent-activity">
        <h3>Recent Activity</h3>
        <?php
        $sql = "SELECT mh.*, i.item_name 
                FROM maintenance_history mh
                JOIN inventory i ON mh.inventory_id = i.id
                ORDER BY mh.maintenance_date DESC
                LIMIT 5";
        $result = $conn->query($sql);
        ?>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Maintenance Type</th>
                    <th>Performed By</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['maintenance_date'] ?></td>
                    <td><?= $row['item_name'] ?></td>
                    <td><?= $row['maintenance_type'] ?></td>
                    <td><?= $row['performed_by'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>