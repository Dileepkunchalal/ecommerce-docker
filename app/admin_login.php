<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("
        SELECT * FROM users
        WHERE email=? AND role='admin'
    ");

    $stmt->execute([$email]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {

        // DEBUG
        // echo $admin['password'];

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin'] = $admin['id'];

            header("Location: admin.php");
            exit;

        } else {

            $error = "❌ Wrong password";
        }

    } else {

        $error = "❌ Admin not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>

        body{
            margin:0;
            font-family:Arial;
            background:linear-gradient(135deg,#0d6efd,#6610f2);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .box{
            background:white;
            width:350px;
            padding:35px;
            border-radius:15px;
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            margin-bottom:25px;
        }

        input{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border-radius:8px;
            border:1px solid #ccc;
            font-size:16px;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:8px;
            background:#0d6efd;
            color:white;
            font-size:16px;
            cursor:pointer;
        }

        button:hover{
            background:#0b5ed7;
        }

        .error{
            text-align:center;
            margin-bottom:15px;
            color:red;
            font-weight:bold;
        }

    </style>

</head>

<body>

<div class="box">

    <h2>👑 Admin Login</h2>

    <?php if($error): ?>
        <div class="error">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">

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

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>