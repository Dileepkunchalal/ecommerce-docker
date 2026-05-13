<?php

include 'db.php';

$newPassword = password_hash("admin123", PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    UPDATE users
    SET password=?
    WHERE email='admin@gmail.com'
");

$stmt->execute([$newPassword]);

echo "Admin password reset successful";

?>