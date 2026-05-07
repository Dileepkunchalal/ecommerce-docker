<?php
session_start();

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == "inc") {
        $_SESSION['cart'][$id]++;
    }

    if ($action == "dec") {
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    if ($action == "remove") {
        unset($_SESSION['cart'][$id]);
    }
}

header("Location: cart.php");
?>