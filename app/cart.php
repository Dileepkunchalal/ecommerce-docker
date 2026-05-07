<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .cart-container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        img {
            width: 80px;
            border-radius: 8px;
        }

        .qty {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty a {
            padding: 5px 10px;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .remove {
            color: red;
            text-decoration: none;
        }

        .total {
            text-align: right;
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="cart-container">
<h2>🛒 Your Cart</h2>

<?php
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Cart is empty";
    exit;
}

$total = 0;

foreach ($_SESSION['cart'] as $id => $qty) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);

    $subtotal = $p['price'] * $qty;
    $total += $subtotal;
?>

<div class="cart-item">
    <img src="uploads/<?= $p['image'] ?>">

    <div>
        <h4><?= $p['name'] ?></h4>
        <p>₹<?= $p['price'] ?></p>
        <p>Subtotal: ₹<?= $subtotal ?></p>
    </div>

    <div class="qty">
        <a href="update_cart.php?id=<?= $id ?>&action=dec">-</a>
        <span><?= $qty ?></span>
        <a href="update_cart.php?id=<?= $id ?>&action=inc">+</a>
    </div>

    <a class="remove" href="update_cart.php?id=<?= $id ?>&action=remove">❌</a>
</div>

<?php } ?>

<div class="total">
    Total: ₹<?= $total ?>
</div>

<a href="checkout.php" class="checkout-btn">Checkout</a>

</div>

</body>
</html>