<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Cart is empty";
    exit;
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body{
            font-family:'Segoe UI', sans-serif;
            background:#f4f6f9;
        }

        .checkout-box{
            max-width:800px;
            margin:30px auto;
            background:white;
            padding:25px;
            border-radius:14px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }

        h2,h3{
            margin-bottom:15px;
        }

        input,
        textarea{
            width:100%;
            padding:12px;
            margin:10px 0;
            border-radius:8px;
            border:1px solid #ccc;
            font-size:15px;
        }

        .item{
            border-bottom:1px solid #ddd;
            padding:10px 0;
        }

        .total{
            text-align:right;
            font-size:22px;
            margin-top:20px;
            font-weight:bold;
            color:green;
        }

        .btn{
            width:100%;
            padding:14px;
            background:#0d6efd;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
            margin-top:20px;
        }

        .btn:hover{
            background:#0b5ed7;
        }

    </style>
</head>

<body>

<div class="checkout-box">

    <h2>🧾 Checkout</h2>

    <!-- FORM -->
    <form action="payment.php" method="POST">

        <!-- DELIVERY DETAILS -->
        <h3>📦 Delivery Details</h3>

        <input 
            type="text"
            name="name"
            placeholder="Full Name"
            required
        >

        <input 
            type="text"
            name="phone"
            placeholder="Phone Number"
            required
        >

        <textarea 
            name="address"
            placeholder="Full Address"
            required
        ></textarea>

        <!-- ORDER SUMMARY -->
        <h3>🛒 Order Summary</h3>

        <?php foreach ($_SESSION['cart'] as $id => $qty): 

            $stmt = $conn->prepare("
                SELECT * FROM products 
                WHERE id=?
            ");

            $stmt->execute([$id]);

            $p = $stmt->fetch(PDO::FETCH_ASSOC);

            $subtotal = $p['price'] * $qty;
        ?>

            <div class="item">

                <strong>
                    <?= htmlspecialchars($p['name']) ?>
                </strong>

                <br>

                ₹<?= $p['price'] ?> × <?= $qty ?>

                = ₹<?= $subtotal ?>

            </div>

        <?php endforeach; ?>

        <div class="total">
            Total: ₹<?= $total ?>
        </div>

        <!-- PAYMENT BUTTON -->
        <button class="btn">
            Proceed to Payment 💳
        </button>

    </form>

</div>

</body>
</html>