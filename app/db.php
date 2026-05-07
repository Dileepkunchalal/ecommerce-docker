<?php

$host = "mysql-pkvo.railway.internal";
$dbname = "railway";
$user = "root";
$pass = "xoLasFNtaWixgFxyiZzoFiXNEEWFNzGK";
$port = "3306";

try {

    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname",
        $user,
        $pass
    );

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch(PDOException $e) {

    die("Database connection failed: " . $e->getMessage());
}
?>