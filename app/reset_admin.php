<?php
include 'includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        UPDATE users
        SET password = ?
        WHERE email = ? AND role = 'admin'
    ");

    $stmt->execute([$new_password, $email]);

    if ($stmt->rowCount() > 0) {
        $message = "✅ Admin password updated successfully!";
    } else {
        $message = "❌ Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Admin Password</title>

    <style>
        body{
            font-family: Arial;
            background: linear-gradient(135deg,#1d4ed8,#7c3aed);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .box{
            background:white;
            padding:30px;
            border-radius:15px;
            width:350px;
        }

        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            background:#2563eb;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
        }

        h2{
            text-align:center;
        }

        p{
            text-align:center;
            font-weight:bold;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>🔑 Reset Admin Password</h2>

    <?php if($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Admin Email" required>

        <input type="password" name="password" placeholder="New Password" required>

        <button type="submit">
            Reset Password
        </button>

    </form>

</div>

</body>
</html>