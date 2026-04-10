<?php
session_start();

if (!isset($_SESSION['userdata'])) {
    echo "Unauthorized access!";
    exit();
}

if (isset($_GET['index'])) {
    $index = $_GET['index'];

    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]); 
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    }
}

header("Location: ../pages/dashboard.php?page=market");
exit();
?>
