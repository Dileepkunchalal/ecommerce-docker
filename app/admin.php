<?php
session_start();
include 'db.php';

// Protect admin page
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Dashboard stats
$totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalUsers    = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalOrders   = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();

/* =========================
   ADD NEW ADMIN
========================= */
$message = "";

if (isset($_POST['add_admin'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check duplicate email
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {

        $message = "❌ Email already exists";

    } else {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, 'admin')
        ");

        $stmt->execute([$name, $email, $hash]);

        $message = "✅ New admin added successfully";
    }
}

/* =========================
   UPDATE ORDER STATUS
========================= */
if (isset($_GET['ship'])) {

    $id = (int)$_GET['ship'];

    $stmt = $conn->prepare("
        UPDATE orders 
        SET status='shipped'
        WHERE id=?
    ");

    $stmt->execute([$id]);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Segoe UI', sans-serif;
            background:#f4f6f9;
        }

        /* NAVBAR */
        .admin-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 25px;
            background:linear-gradient(90deg,#212529,#343a40);
            color:white;
        }

        .admin-links{
            display:flex;
            gap:15px;
        }

        .admin-links a{
            color:white;
            text-decoration:none;
            font-weight:500;
        }

        .admin-links a:hover{
            text-decoration:underline;
        }

        /* STATS */
        .stats{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            padding:20px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:14px;
            text-align:center;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card h3{
            margin-bottom:10px;
            color:#555;
        }

        .card b{
            font-size:28px;
            color:#0d6efd;
        }

        /* ADD ADMIN */
        .admin-form{
            max-width:700px;
            margin:20px auto;
            background:white;
            padding:20px;
            border-radius:14px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
        }

        .admin-form h2{
            margin-bottom:15px;
        }

        .admin-form input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border-radius:8px;
            border:1px solid #ccc;
        }

        .admin-form button{
            width:100%;
            padding:12px;
            background:#0d6efd;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
        }

        .admin-form button:hover{
            background:#0b5ed7;
        }

        .message{
            margin-bottom:10px;
            font-weight:bold;
        }

        /* ORDERS */
        .orders{
            padding:20px;
        }

        .orders h2{
            margin-bottom:15px;
        }

        .order{
            background:white;
            padding:18px;
            border-radius:12px;
            margin-bottom:15px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
            line-height:1.8;
        }

        .badge{
            padding:5px 10px;
            border-radius:6px;
            font-size:12px;
            font-weight:bold;
        }

        .pending{
            background:#ffc107;
            color:black;
        }

        .shipped{
            background:#28a745;
            color:white;
        }

        .btn{
            display:inline-block;
            margin-top:10px;
            padding:8px 12px;
            background:#0d6efd;
            color:white;
            text-decoration:none;
            border-radius:6px;
        }

        .btn:hover{
            background:#0b5ed7;
        }

        /* MOBILE */
        @media(max-width:768px){

            .admin-bar{
                flex-direction:column;
                gap:10px;
            }

            .admin-links{
                flex-wrap:wrap;
                justify-content:center;
            }
        }

    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="admin-bar">

    <h2>👑 Admin Dashboard</h2>

    <div class="admin-links">
        <a href="index.php">🏠 Store</a>
        <a href="admin_products.php">🛍 Products</a>
        <a href="orders.php">📦 Orders</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

</div>

<!-- STATS -->
<div class="stats">

    <div class="card">
        <h3>🛍 Total Products</h3>
        <b><?= $totalProducts ?></b>
    </div>

    <div class="card">
        <h3>👤 Total Users</h3>
        <b><?= $totalUsers ?></b>
    </div>

    <div class="card">
        <h3>📦 Total Orders</h3>
        <b><?= $totalOrders ?></b>
    </div>

</div>

<!-- ADD NEW ADMIN -->
<div class="admin-form">

    <h2>➕ Add New Admin</h2>

    <?php if($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">

        <input 
            type="text" 
            name="name"
            placeholder="Admin Name"
            required
        >

        <input 
            type="email" 
            name="email"
            placeholder="Admin Email"
            required
        >

        <input 
            type="password" 
            name="password"
            placeholder="Password"
            required
        >

        <button name="add_admin">
            Add Admin
        </button>

    </form>

</div>

<!-- ORDERS -->
<div class="orders">

    <h2>📦 Recent Orders</h2>

    <?php
    $orders = $conn->query("
        SELECT o.*, u.email
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.id DESC
    ");

    foreach($orders as $o):
    ?>

    <div class="order">

        <b>Order #<?= $o['id'] ?></b><br>

        👤 <?= htmlspecialchars($o['name']) ?><br>

        📧 <?= htmlspecialchars($o['email']) ?><br>

        📞 <?= htmlspecialchars($o['phone']) ?><br>

        📍 <?= nl2br(htmlspecialchars($o['address'])) ?><br>

        💰 Total: ₹<?= $o['total'] ?><br>

        🕒 <?= $o['created_at'] ?><br>

        Status:
        <?php if($o['status'] == 'pending'): ?>

            <span class="badge pending">Pending</span><br>

            <a class="btn" href="?ship=<?= $o['id'] ?>">
                Mark Shipped
            </a>

        <?php else: ?>

            <span class="badge shipped">Shipped</span>

        <?php endif; ?>

    </div>

    <?php endforeach; ?>

</div>

</body>
</html>