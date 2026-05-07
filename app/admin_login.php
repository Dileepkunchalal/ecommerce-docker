<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['id'];
        header("Location: admin.php");
        exit;
    } else {
        $message = "❌ Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: linear-gradient(135deg, #212529, #343a40);
        }

        .auth-container {
            max-width: 350px;
            margin: 100px auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            text-align: center;
        }

        .auth-container h2 {
            margin-bottom: 15px;
        }

        .auth-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .auth-container button {
            width: 100%;
            padding: 10px;
            background: #212529;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .auth-container button:hover {
            background: #000;
        }

        .message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="auth-container">
    <h2>👑 Admin Login</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Login</button>
    </form>
</div>

</body>
</html>