<?php
include("connect.php");
session_start();

if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['register_as'] !== 'Admin') {
    echo "Unauthorized access!";
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $deleteQuery = "DELETE FROM fertilizers WHERE id='$id'";

    if (mysqli_query($connect, $deleteQuery)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($connect);
    }
}
?>
