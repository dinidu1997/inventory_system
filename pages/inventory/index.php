<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('/auth/login.php');
}

$items = getInventoryItems($conn);
?>

<div class="container">
    <h2>Inventory Items</h2>
    <a href="add.php" class="btn btn-primary mb-3">Add New Item</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Model</th>
                <th>Category</th>
                <th>Building</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['item_name'] ?></td>
                <td><?= $item['model_name'] ?></td>
                <td><?= $item['category_name'] ?? 'N/A' ?></td>
                <td><?= $item['building_name'] ?? 'N/A' ?></td>
                <td><?= $item['status_details'] ?></td>
                <td>
                    <a href="view.php?id=<?= $item['id'] ?>" class="btn btn-info btn-sm">View</a>
                    <a href="edit.php?id=<?= $item['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>