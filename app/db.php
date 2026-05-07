<?php
try {
    $conn = new PDO("mysql:host=db;dbname=ecommerce", "user", "password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>