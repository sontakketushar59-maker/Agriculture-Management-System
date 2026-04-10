<?php
include("connect.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $deleteQuery = "DELETE FROM crops WHERE id = $id";

    if (mysqli_query($connect, $deleteQuery)) {
        echo "Crop deleted successfully!";
    } else {
        echo "Error deleting crop: " . mysqli_error($connect);
    }
}
?>
