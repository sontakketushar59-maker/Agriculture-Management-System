<?php
include("connect.php");
session_start();

if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['register_as'] !== 'Admin') {
    echo "Unauthorized access!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['fertilizer_id']);
    $fertilizer_name = mysqli_real_escape_string($connect, $_POST['fertilizer_name']);
    $fertilizer_price = mysqli_real_escape_string($connect, $_POST['fertilizer_price']);
    $fertilizer_quantity = mysqli_real_escape_string($connect, $_POST['fertilizer_quantity']);

    $updateQuery = "UPDATE fertilizers SET 
                    fertilizer_name='$fertilizer_name', 
                    fertilizer_price='$fertilizer_price', 
                    fertilizer_quantity='$fertilizer_quantity' 
                    WHERE id='$id'";

    if (mysqli_query($connect, $updateQuery)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($connect);
    }
}
?>
