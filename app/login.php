<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "⚠️ Please fill all fields";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $message = "❌ Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Use your main CSS -->
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
        }

        .auth-container {
            max-width: 350px;
            margin: 100px auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
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
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        .auth-container button:hover {
            background: #0b5ed7;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
            color: red;
        }

        .bottom-link {
            margin-top: 10px;
            display: block;
        }
    </style>
</head>

<body>

<div class="auth-container">
    <h2>🔐 Login</h2>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <input 
            type="email" 
            name="email" 
            placeholder="Enter Email" 
            required
        >

        <input 
            type="password" 
            name="password" 
            placeholder="Enter Password" 
            required
        >

        <button>Login</button>
    </form>

    <a class="bottom-link" href="register.php">
        New user? Register here
    </a>
</div>

</body>
</html>