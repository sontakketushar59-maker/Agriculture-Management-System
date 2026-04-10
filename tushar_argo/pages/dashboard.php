<?php
session_start();
if (!isset($_SESSION['userdata'])) {
    header("location: ../");
    exit();
} else {
    $values = $_SESSION['userdata'];
    $total_users = isset($_SESSION['total_users']) ? $_SESSION['total_users'] : 0;
    $total_crops = isset($_SESSION['total_crops']) ? $_SESSION['total_crops'] : 0;
    $total_orders = isset($_SESSION['total_orders']) ? $_SESSION['total_orders'] : 0;
   
    $user_role = $values['register_as']; // Get user role
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Management System - Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e8f5e9;
        }
        .header {
            background-color: #2e7d32;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }
        .sidebar {
            width: 20%;
            background-color: #1b5e20;
            color: white;
            position: fixed;
            height: 100%;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            cursor: pointer;
        }
        .sidebar a:hover {
            background-color: #4caf50;
        }
        .content {
            margin-left: 22%;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            width: 70%;
            margin-top: 20px;
        }
        .footer {
            background-color: #2e7d32;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
<div class="header">
    Agriculture Management System
    <button class="btn" style="float: right; margin-right: 20px;" onclick="window.location='../api/logout.php';">Logout</button>
    <button class="btn" style="float: left; margin-left: 20px;" onclick="history.back();">Back</button>
</div>

<div class="sidebar">
    <?php if ($user_role == 'Admin') : ?>
        <a href="dashboard.php?page=dashboard"> 🏡 Dashboard</a>
    <?php endif; ?>
    <a href="dashboard.php?page=profile">🆔 Profile</a>
    <?php if ($user_role == 'Admin') : ?>
    <a href="dashboard.php?page=add_crops_fertilizers">🌾 Add Crops</a>
    <a href="dashboard.php?page=list_crop">📋 Crop List</a>
    <?php endif; ?>
    <?php if ($user_role == 'Admin') : ?>
        <a href="dashboard.php?page=add_fertilizers">🧪 Add Fertilizers</a>
        <a href="dashboard.php?page=list_fertilizer">🧪 Fertilizers List</a>
    <?php endif; ?>    
    <?php if ($user_role == 'User') : ?>
        <a href="dashboard.php?page=suggestions">🌿 Crop Suggestions</a>
    <?php endif; ?>
    <?php if ($user_role == 'User') : ?>
        <a href="dashboard.php?page=fertilizer">🔬 Fertilizer Guide</a>
    <?php endif; ?>  
    <?php if ($user_role == 'User') : ?>
        <a href="dashboard.php?page=market">🛍️ Marketplace</a>
        <a href="dashboard.php?page=checkout">🛒 Checkout</a>
    <?php endif; ?>
    <?php if ($user_role == 'User') : ?>
        <a href="dashboard.php?page=invoice">📜 My Invoices</a>
    <?php endif; ?>
    <?php if ($user_role == 'Admin') : ?>
        <a href="dashboard.php?page=reports">📈 Reports & Analytics</a>
    <?php endif; ?>
</div>


<div class="content" id="content-area">
    <?php
        if (isset($_GET['page'])) {
            include("content.php");
        } else {
            echo "<h2>Welcome to the Dashboard</h2><p>Select an option from the sidebar to view details.</p>";
        }
    ?>
</div>

<div class="footer">
    &copy; 2025 Agriculture Management System. All rights reserved.
</div>
</body>
</html>
