<?php
session_start();
include 'db.php';

$message = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check duplicate email
    $check = $conn->prepare("
        SELECT id FROM users 
        WHERE email=?
    ");

    $check->execute([$email]);

    if ($check->rowCount() > 0) {

        $message = "❌ Email already exists";

    } else {

        // Generate verification token
        $token = bin2hex(random_bytes(32));

        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $stmt = $conn->prepare("
            INSERT INTO users
            (name, email, password, role, verify_token)
            VALUES (?, ?, ?, 'user', ?)
        ");

        $stmt->execute([
            $name,
            $email,
            $hash,
            $token
        ]);

        // Show verification link directly
        $message = "
            ✅ Registration successful!<br><br>

            Click below to verify your account:<br><br>

            <a href='verify.php?token=$token'>
                Verify Account
            </a>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Segoe UI', sans-serif;
            background:linear-gradient(135deg,#0d6efd,#4dabf7);
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            padding:20px;
        }

        .register-box{
            width:100%;
            max-width:420px;
            background:white;
            padding:30px;
            border-radius:16px;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
        }

        .register-box h2{
            text-align:center;
            margin-bottom:20px;
        }

        .message{
            background:#f8f9fa;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
            text-align:center;
            line-height:1.6;
        }

        .message a{
            color:#0d6efd;
            font-weight:bold;
            text-decoration:none;
        }

        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:15px;
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
            margin-top:10px;
        }

        button:hover{
            background:#0b5ed7;
        }

        .login-link{
            text-align:center;
            margin-top:15px;
        }

        .login-link a{
            color:#0d6efd;
            text-decoration:none;
        }

    </style>
</head>

<body>

<div class="register-box">

    <h2>📝 Register</h2>

    <?php if($message): ?>
        <div class="message">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <input 
            type="text"
            name="name"
            placeholder="Full Name"
            required
        >

        <input 
            type="email"
            name="email"
            placeholder="Email Address"
            required
        >

        <input 
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <button name="register">
            Register
        </button>

    </form>

    <div class="login-link">
        Already have account?
        <a href="login.php">Login</a>
    </div>

</div>

</body>
</html>