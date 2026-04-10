<?php
include("../api/connect.php");
if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['register_as'] !== 'Admin') {
    echo "<div class='alert alert-danger text-center'>Unauthorized access!</div>";
    exit();
}

// Handle Add or Edit Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $crop = mysqli_real_escape_string($connect, $_POST['crop']);
    $fertilizer = mysqli_real_escape_string($connect, $_POST['fertilizer']);
    $price = mysqli_real_escape_string($connect, $_POST['price']);
    $district = mysqli_real_escape_string($connect, $_POST['district']);

    if (!empty($_POST['crop_id'])) {
        $id = intval($_POST['crop_id']);
        $updateQuery = "UPDATE crops SET crop_name='$crop', fertilizer='$fertilizer', price='$price', district='$district' WHERE id='$id'";
        mysqli_query($connect, $updateQuery);
        echo "<script>alert('Crop updated successfully!'); window.location.href='';</script>";
    } else {
        $insertQuery = "INSERT INTO crops (crop_name, fertilizer, price, district) VALUES ('$crop', '$fertilizer', '$price', '$district')";
        mysqli_query($connect, $insertQuery);
        echo "<script>alert('Crop added successfully!'); window.location.href='';</script>";
    }
}

// Fetch all crops
$query = "SELECT * FROM crops";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Crops</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center text-success">🌱 Manage Crops</h2>

    <!-- Add / Edit Form -->
    <div class="card shadow-sm p-4 mt-3">
        <form id="cropForm" method="POST">
            <input type="hidden" name="crop_id" id="crop_id">
            
            <div class="row">
                <div class="col-md-6">
                    <label for="crop" class="form-label">Crop Name:</label>
                    <input type="text" name="crop" id="crop" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="fertilizer" class="form-label">Fertilizer Name:</label>
                    <input type="text" name="fertilizer" id="fertilizer" class="form-control" required>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="price" class="form-label">Price (₹):</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                </div>
                <div class="col-md-6">
                    <label for="district" class="form-label">District:</label>
                    <input type="text" name="district" id="district" class="form-control" required>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" id="submitBtn" class="btn btn-success">Add Crop</button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
