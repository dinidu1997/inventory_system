<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('/auth/login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = sanitizeInput($conn, $_POST['item_name']);
    $model_name = sanitizeInput($conn, $_POST['model_name']);
    $building_id = intval($_POST['building_id']);
    $standard_stock_id = intval($_POST['standard_stock_id']);
    $serial_number = sanitizeInput($conn, $_POST['serial_number']);
    $status = sanitizeInput($conn, $_POST['status_details']);
    
    $sql = "INSERT INTO inventory (item_name, model_name, building_id, standard_stock_id, serial_number, status_details)
            VALUES ('$item_name', '$model_name', $building_id, $standard_stock_id, '$serial_number', '$status')";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Item added successfully";
        redirect('/pages/inventory/index.php');
    } else {
        $error = "Error: " . $conn->error;
    }
}

$categories = getCategories($conn);
$buildings = getBuildings($conn);
$standard_stock = [];
$result = $conn->query("SELECT * FROM standard_stock");
while ($row = $result->fetch_assoc()) {
    $standard_stock[] = $row;
}
?>

<div class="container">
    <h2>Add Inventory Item</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Model Name</label>
            <input type="text" name="model_name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Building</label>
            <select name="building_id" class="form-control" required>
                <option value="">Select Building</option>
                <?php foreach ($buildings as $building): ?>
                    <option value="<?= $building['id'] ?>"><?= $building['building_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Standard Stock Item</label>
            <select name="standard_stock_id" class="form-control">
                <option value="">Select Standard Item</option>
                <?php foreach ($standard_stock as $item): ?>
                    <option value="<?= $item['id'] ?>"><?= $item['item_name'] ?> (<?= $item['model_name'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Serial Number</label>
            <input type="text" name="serial_number" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Status</label>
            <select name="status_details" class="form-control" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Under Repair">Under Repair</option>
                <option value="Damaged">Damaged</option>
                <option value="Disposed">Disposed</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>