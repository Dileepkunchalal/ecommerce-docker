<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("Product not found");
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['name']) ?></title>

    <style>

        body{
            font-family:Arial;
            background:#f5f5f5;
            padding:40px;
        }

        .container{
            background:white;
            max-width:1000px;
            margin:auto;
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:40px;
            padding:40px;
            border-radius:20px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        img{
            width:100%;
            border-radius:20px;
            height:450px;
            object-fit:cover;
        }

        h1{
            margin-bottom:20px;
        }

        .price{
            color:green;
            font-size:32px;
            font-weight:bold;
            margin-bottom:20px;
        }

        .btn{
            display:inline-block;
            padding:15px 30px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:10px;
            font-weight:bold;
        }

        .btn:hover{
            background:#1d4ed8;
        }

    </style>

</head>

<body>

<div class="container">

    <div>
        <img src="<?= htmlspecialchars($product['image']) ?>">
    </div>

    <div>

        <h1>
            <?= htmlspecialchars($product['name']) ?>
        </h1>

        <div class="price">
            ₹<?= number_format($product['price'],2) ?>
        </div>

        <p>
            Premium quality product with modern design and excellent performance.
        </p>

        <br><br>

        <a 
            href="add_to_cart.php?id=<?= $product['id'] ?>" 
            class="btn"
        >
            Add to Cart
        </a>

    </div>

</div>

</body>
</html>