<?php
include 'admin_guard.php';
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name']);
    $price = (int)$_POST['price'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $tmp = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tmp, "uploads/" . $imageName)) {
            $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?,?,?)");
            $stmt->execute([$name, $price, $imageName]);
            $message = "✅ Product added!";
        } else {
            $message = "❌ Image upload failed";
        }
    } else {
        $message = "❌ Please select an image";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .box{max-width:420px;margin:40px auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.1)}
        input,button{width:100%;padding:10px;margin:8px 0;border-radius:8px;border:1px solid #ccc}
        button{background:#28a745;color:#fff;border:none}
    </style>
</head>
<body>

<div class="box">
    <h2>➕ Add Product</h2>
    <p><?= $message ?></p>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="file" name="image" required>
        <button>Add Product</button>
    </form>

    <a href="admin_products.php">← Back</a>
</div>

</body>
</html>