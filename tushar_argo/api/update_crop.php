<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $crop = mysqli_real_escape_string($connect, $_POST['crop']);
    $fertilizer = mysqli_real_escape_string($connect, $_POST['fertilizer']);
    $price = mysqli_real_escape_string($connect, $_POST['price']);
    $district = mysqli_real_escape_string($connect, $_POST['district']);

    $updateQuery = "UPDATE crops SET crop_name='$crop', fertilizer='$fertilizer', price='$price', district='$district' WHERE id='$id'";
    
    if (mysqli_query($connect, $updateQuery)) {
        echo "Crop updated successfully!";
    } else {
        echo "Error updating crop: " . mysqli_error($connect);
    }
}
?>
