<?php
include("../api/connect.php");

if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['register_as'] !== 'Admin') {
    echo "<div class='alert alert-danger text-center'>Unauthorized access!</div>";
    exit();
}

// Handle Add Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fertilizer_name = mysqli_real_escape_string($connect, $_POST['fertilizer_name']);
    $fertilizer_price = mysqli_real_escape_string($connect, $_POST['fertilizer_price']);
    $fertilizer_quantity = mysqli_real_escape_string($connect, $_POST['fertilizer_quantity']);

    $insertQuery = "INSERT INTO fertilizers (fertilizer_name, fertilizer_price, fertilizer_quantity) 
                    VALUES ('$fertilizer_name', '$fertilizer_price', '$fertilizer_quantity')";
    mysqli_query($connect, $insertQuery);
    
    echo "<script>alert('Fertilizer added successfully!')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Fertilizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center text-success">🌿 Add Fertilizer</h2>

    <div class="card shadow-sm p-4 mt-3">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Fertilizer Name:</label>
                <input type="text" name="fertilizer_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price (₹):</label>
                <input type="number" name="fertilizer_price" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity:</label>
                <input type="text" name="fertilizer_quantity" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add Fertilizer</button>
            <a href="dashboard.php?page=list_fertilizer" class="btn btn-secondary">View Fertilizers</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
