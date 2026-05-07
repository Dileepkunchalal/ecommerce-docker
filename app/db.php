<?php

$host = "turntable.proxy.rlwy.net";
$port = "20568";
$dbname = "railway";
$user = "root";
$pass = "xoLasFNtaWixgFxyiZzoFiXNEEWFNzGK";

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