<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $image);

    $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $stmt->execute([$name, $price, $image]);

    echo "✅ Product Added Successfully!";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <input type="number" name="price" placeholder="Price" required><br>
    <input type="file" name="image" required><br>
    <button>Add Product</button>
</form>