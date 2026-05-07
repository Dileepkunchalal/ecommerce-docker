<?php
include 'db.php';

if (!isset($_GET['token'])) {
    die("Invalid token");
}

$token = $_GET['token'];

$stmt = $conn->prepare("
    SELECT * FROM users
    WHERE verify_token=?
");

$stmt->execute([$token]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Invalid token");
}

$stmt = $conn->prepare("
    UPDATE users
    SET is_verified=1,
        verify_token=NULL
    WHERE id=?
");

$stmt->execute([$user['id']]);

echo "
<h2>✅ Email Verified Successfully!</h2>
<a href='login.php'>Login Now</a>
";
?>