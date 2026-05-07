<?php
include 'admin_guard.php';
include 'db.php';

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // (optional) fetch image to delete file
    $stmt = $conn->prepare("SELECT image FROM products WHERE id=?");
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();
    if ($img && file_exists("uploads/".$img)) {
        unlink("uploads/".$img);
    }

    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);

    header("Location: admin_products.php");
    exit;
}

$products = $conn->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .top{display:flex;justify-content:space-between;align-items:center;padding:15px;background:#212529;color:#fff}
        .top a{color:#fff;text-decoration:none}
        table{width:100%;border-collapse:collapse;background:#fff}
        th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
        img{width:60px;height:60px;object-fit:cover;border-radius:6px}
        .btn{padding:6px 10px;border-radius:6px;text-decoration:none}
        .edit{background:#0d6efd;color:#fff}
        .del{background:#dc3545;color:#fff}
        .add{background:#28a745;color:#fff;padding:8px 12px;border-radius:8px}
        .wrap{padding:20px}
    </style>
</head>
<body>

<div class="top">
    <div>🛍 Manage Products</div>
    <div>
        <a href="admin.php">Dashboard</a>
        <a class="add" href="admin_add_product.php">+ Add Product</a>
    </div>
</div>

<div class="wrap">
<table>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($products as $p): ?>
    <tr>
        <td><img src="uploads/<?= htmlspecialchars($p['image']) ?>"></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td>₹<?= htmlspecialchars($p['price']) ?></td>
        <td>
            <a class="btn edit" href="admin_edit_product.php?id=<?= $p['id'] ?>">Edit</a>
            <a class="btn del" href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>

</body>
</html>