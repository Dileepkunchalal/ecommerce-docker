<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    die("Cart empty");
}

$user_id = $_SESSION['user'];

$total = 0;

foreach ($_SESSION['cart'] as $id => $qty) {

    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE id=?
    ");

    $stmt->execute([$id]);

    $p = $stmt->fetch(PDO::FETCH_ASSOC);

    $total += $p['price'] * $qty;
}

// Payment method
$payment = $_POST['payment'] ?? 'COD';

// Insert order
$stmt = $conn->prepare("
    INSERT INTO orders
    (user_id, total, status)
    VALUES (?, ?, 'pending')
");

$stmt->execute([$user_id, $total]);

$order_id = $conn->lastInsertId();

// Order items
foreach ($_SESSION['cart'] as $id => $qty) {

    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE id=?
    ");

    $stmt->execute([$id]);

    $p = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("
        INSERT INTO order_items
        (order_id, product_id, price, quantity)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $order_id,
        $id,
        $p['price'],
        $qty
    ]);
}

// Clear cart
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>

    <style>

        body{
            font-family:'Segoe UI';
            background:#f4f6f9;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .success-box{
            background:white;
            padding:40px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        h1{
            color:green;
        }

        a{
            display:inline-block;
            margin-top:20px;
            text-decoration:none;
            background:#0d6efd;
            color:white;
            padding:10px 20px;
            border-radius:8px;
        }

    </style>
</head>

<body>

<div class="success-box">

    <h1>✅ Payment Successful</h1>

    <p>Payment Method: <?= htmlspecialchars($payment) ?></p>

    <p>Your order has been placed successfully.</p>

    <a href="index.php">
        Continue Shopping
    </a>

</div>

</body>
</html>