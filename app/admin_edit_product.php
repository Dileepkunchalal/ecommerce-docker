<?php
include 'admin_guard.php';
include 'db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name']);
    $price = (int)$_POST['price'];

    $imageName = $product['image'];

    if (!empty($_FILES['image']['name'])) {
        $newName = time() . "_" . basename($_FILES['image']['name']);
        $tmp = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tmp, "uploads/" . $newName)) {
            // delete old image
            if ($imageName && file_exists("uploads/".$imageName)) {
                unlink("uploads/".$imageName);
            }
            $imageName = $newName;
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=? WHERE id=?");
    $stmt->execute([$name, $price, $imageName, $id]);

    $message = "✅ Updated!";
    // refresh product
    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .box{max-width:420px;margin:40px auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.1)}
        input,button{width:100%;padding:10px;margin:8px 0;border-radius:8px;border:1px solid #ccc}
        button{background:#0d6efd;color:#fff;border:none}
        img{width:100%;max-height:200px;object-fit:cover;border-radius:8px}
    </style>
</head>
<body>

<div class="box">
    <h2>✏️ Edit Product</h2>
    <p><?= $message ?></p>

    <img src="uploads/<?= htmlspecialchars($product['image']) ?>">

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
        <input type="file" name="image">
        <button>Update</button>
    </form>

    <a href="admin_products.php">← Back</a>
</div>

</body>
</html>