<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .orders-box {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
        }

        .order {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .item {
            margin-left: 10px;
            font-size: 14px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }

        .pending {
            background: #ffc107;
        }

        .shipped {
            background: #28a745;
            color: white;
        }
    </style>
</head>

<body>

<div class="orders-box">
    <h2>📦 My Orders</h2>

<?php
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$orders) {
    echo "No orders yet";
}

foreach ($orders as $o):
?>
    <div class="order">
        <b>Order #<?= $o['id'] ?></b><br>
        Total: ₹<?= $o['total'] ?><br>
        Date: <?= $o['created_at'] ?><br>

        Status:
        <?php if ($o['status'] == 'pending'): ?>
            <span class="badge pending">Pending</span>
        <?php else: ?>
            <span class="badge shipped">Shipped</span>
        <?php endif; ?>

        <h4>Items:</h4>

        <?php
        $stmt2 = $conn->prepare("
            SELECT oi.*, p.name 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id=?
        ");
        $stmt2->execute([$o['id']]);

        foreach ($stmt2 as $item):
        ?>
            <div class="item">
                <?= htmlspecialchars($item['name']) ?> 
                (x<?= $item['quantity'] ?>) 
                - ₹<?= $item['price'] ?>
            </div>
        <?php endforeach; ?>

    </div>
<?php endforeach; ?>

</div>

</body>
</html>