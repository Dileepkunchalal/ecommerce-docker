<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>

    <style>

        body{
            font-family:'Segoe UI';
            background:#f4f6f9;
        }

        .payment-box{
            max-width:500px;
            margin:50px auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        .method{
            border:1px solid #ddd;
            padding:15px;
            border-radius:8px;
            margin-bottom:10px;
        }

        button{
            width:100%;
            padding:12px;
            background:#0d6efd;
            color:white;
            border:none;
            border-radius:8px;
            font-size:16px;
            cursor:pointer;
            margin-top:20px;
        }

        button:hover{
            background:#0b5ed7;
        }

    </style>
</head>

<body>

<div class="payment-box">

    <h2>💳 Payment Method</h2>

    <form action="place_order.php" method="POST">

        <div class="method">
            <input type="radio" name="payment" value="COD" required>
            Cash on Delivery
        </div>

        <div class="method">
            <input type="radio" name="payment" value="UPI">
            UPI Payment
        </div>

        <div class="method">
            <input type="radio" name="payment" value="Card">
            Debit / Credit Card
        </div>

        <div class="method">
            <input type="radio" name="payment" value="NetBanking">
            Net Banking
        </div>

        <button>
            Pay Now
        </button>

    </form>

</div>

</body>
</html>