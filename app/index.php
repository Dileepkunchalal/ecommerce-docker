<?php
session_start();
include 'db.php';

$stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Store</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            background:#f5f5f5;
        }

        header{
            background:#111827;
            color:white;
            padding:20px 40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
        }

        header h1{
            font-size:30px;
        }

        nav{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        nav a{
            color:white;
            text-decoration:none;
            font-weight:bold;
        }

        .hero{
            background:linear-gradient(135deg,#2563eb,#7c3aed);
            color:white;
            text-align:center;
            padding:70px 20px;
        }

        .hero h2{
            font-size:45px;
            margin-bottom:15px;
        }

        .hero p{
            font-size:20px;
        }

        .search-box{
            padding:30px;
            text-align:center;
        }

        .search-box input{
            width:300px;
            padding:12px;
            border-radius:8px 0 0 8px;
            border:1px solid #ccc;
            outline:none;
        }

        .search-box button{
            padding:12px 20px;
            border:none;
            background:#2563eb;
            color:white;
            border-radius:0 8px 8px 0;
            cursor:pointer;
        }

        .products{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:25px;
            padding:40px;
        }

        .card{
            background:white;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card img{
            width:100%;
            height:250px;
            object-fit:cover;
        }

        .card-content{
            padding:20px;
        }

        .card h3{
            margin-bottom:10px;
        }

        .card h3 a{
            text-decoration:none;
            color:#111827;
        }

        .price{
            color:green;
            font-size:28px;
            font-weight:bold;
            margin-bottom:15px;
        }

        .btn{
            display:block;
            width:100%;
            text-align:center;
            padding:12px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:10px;
            font-weight:bold;
        }

        .btn:hover{
            background:#1d4ed8;
        }

        footer{
            background:#111827;
            color:white;
            text-align:center;
            padding:20px;
            margin-top:40px;
        }

    </style>

</head>

<body>

<header>

    <h1>🛒 My Store</h1>

    <nav>

        <a href="index.php">Home</a>

        <a href="cart.php">Cart</a>

        <?php if(isset($_SESSION['user'])): ?>

            <a href="orders.php">Orders</a>

            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        <?php endif; ?>

        <a href="admin_login.php">Admin</a>

    </nav>

</header>

<section class="hero">

    <h2>Welcome to My Ecommerce Store</h2>

    <p>
        Buy latest gadgets, fashion, electronics and more.
    </p>

</section>

<div class="search-box">

    <form method="GET">

        <input 
            type="text" 
            name="search" 
            placeholder="Search products..."
        >

        <button>
            🔍
        </button>

    </form>

</div>

<section class="products">

<?php foreach($products as $product): ?>

    <?php

        $image = $product['image'];

        if(str_starts_with($image, 'http')) {

            $imgPath = $image;

        } else {

            $imgPath = 'uploads/' . $image;

        }

    ?>

    <div class="card">

        <a href="product.php?id=<?= $product['id'] ?>">

            <img 
                src="<?= htmlspecialchars($imgPath) ?>" 
                alt="Product"
            >

        </a>

        <div class="card-content">

            <h3>

                <a href="product.php?id=<?= $product['id'] ?>">

                    <?= htmlspecialchars($product['name']) ?>

                </a>

            </h3>

            <div class="price">

                ₹<?= number_format($product['price'],2) ?>

            </div>

            <a 
                href="add_to_cart.php?id=<?= $product['id'] ?>" 
                class="btn"
            >
                Add to Cart
            </a>

        </div>

    </div>

<?php endforeach; ?>

</section>

<footer>

    © <?= date('Y') ?> My Store | Built by Dileep 🚀

</footer>

</body>
</html>