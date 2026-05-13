<?php
session_start();
include 'db.php';

// Search
$search = $_GET['search'] ?? '';

// Fetch products
$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
$stmt->execute(["%$search%"]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get username
function getUserName($user_id, $conn) {
    $stmt = $conn->prepare("SELECT name FROM users WHERE id=?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ? $user['name'] : "User";
}

// Cart count
$count = 0;
if (isset($_SESSION['cart'])) {
    $count = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <style>
        .navbar {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            background: linear-gradient(90deg, #0d6efd, #4dabf7);
            padding: 15px 20px;
            color: white;
        }

        .nav-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand h2 {
            margin: 0;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-right a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .welcome {
            font-size: 14px;
        }

        .badge {
            background: red;
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 12px;
            color: white;
            margin-left: 4px;
        }
    </style>
</head>

<body>

<!-- 🔵 NAVBAR -->
<div class="navbar">

    <!-- CENTER -->
    <div class="nav-center">
        <div class="brand">
            <span style="font-size:22px;">🛍</span>
            <h2>My Store</h2>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="nav-right">

        <?php if(isset($_SESSION['user'])): ?>
            
            <span class="welcome">
                👋 <?= htmlspecialchars(getUserName($_SESSION['user'], $conn)) ?>
            </span>

            <!-- Orders -->
            <a href="orders.php">📦 Orders</a>

            <!-- Cart with badge -->
            <a href="cart.php">
                🛒 Cart 
                <span class="badge"><?= $count ?></span>
            </a>

            <!-- Logout -->
            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php endif; ?>

    </div>

</div>

<!-- 🔍 SEARCH -->
<div class="search-box">
    <form method="GET">
        <input 
            type="text" 
            name="search" 
            placeholder="Search products..." 
            value="<?= htmlspecialchars($search) ?>"
        >
        <button>🔍</button>
    </form>
</div>

<!-- 🛍️ PRODUCTS -->
<div class="products">

<?php if (!empty($products)): ?>

    <?php foreach($products as $p): ?>
        <div class="product">
            
            <img src="<?= htmlspecialchars($p['image']) ?>" alt="Product"> alt="Product">

            <h3><?= htmlspecialchars($p['name']) ?></h3>

            <p>₹<?= htmlspecialchars($p['price']) ?></p>

            <a href="add_to_cart.php?id=<?= $p['id'] ?>">
                <button>Add to Cart</button>
            </a>

        </div>
    <?php endforeach; ?>

<?php else: ?>

    <p style="text-align:center; width:100%;">No products found</p>

<?php endif; ?>

</div>

</body>
</html>