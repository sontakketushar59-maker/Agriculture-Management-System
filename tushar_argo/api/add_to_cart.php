<?php
session_start();
include("../api/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['crop_id'])) {
        $item_id = $_POST['crop_id'];
        $item_name = $_POST['crop_name'];    
        $price = $_POST['price'];
        $type = 'crop';
    } elseif (isset($_POST['id']) && isset($_POST['type']) && $_POST['type'] == 'fertilizer') {
        $item_id = $_POST['id'];
        $item_name = $_POST['name'];
        $price = $_POST['price'];
        $type = 'fertilizer';
    } else {
        // Invalid request
        header("Location: http://localhost/darshan_agro/pages/dashboard.php?page=market");
        exit();
    }

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if item already exists in cart
    $exists = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $item_id && $item['type'] == $type) {
            $exists = true;
            break;
        }
    }

    if (!$exists) {
        $_SESSION['cart'][] = [
            'id' => $item_id,
            'name' => $item_name,
            'price' => $price,
            'type' => $type
        ];
    }

    // Redirect back to market page
    header("Location: http://localhost/darshan_agro/pages/dashboard.php?page=market");
    exit();
}
?>
