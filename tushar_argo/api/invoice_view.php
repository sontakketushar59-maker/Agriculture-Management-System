<?php
include("../api/connect.php");

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid Invoice!</div>";
    exit();
}

$invoice_no = mysqli_real_escape_string($connect, $_GET['id']);

// Fetch order and user details
$sql = "SELECT orders.*, user.name, user.mobile, user.address 
        FROM orders 
        INNER JOIN user ON orders.user_id = user.id 
        WHERE orders.invoice_no = '$invoice_no'";

$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
} else {
    echo "<div class='alert alert-warning'>Invoice not found!</div>";
    exit();
}

// Decode order items
$order_items = json_decode($order['items'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo $order['invoice_no']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-container {
            max-width: 800px;
            margin: auto;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container invoice-container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3>🧾 Invoice Details</h3>
        </div>
        <div class="card-body">
            <h5 class="text-secondary">Order Information</h5>
            <hr>
            <p><strong>Invoice No:</strong> <?php echo $order['invoice_no']; ?></p>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
            <p><strong>Customer:</strong> <?php echo $order['name']; ?> (<?php echo $order['mobile']; ?>)</p>
            <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
            <p><strong>Payment Mode:</strong> <?php echo ucfirst($order['payment_mode']); ?></p>
            <p class="fw-bold text-success"><strong>Total Price:</strong> ₹<?php echo $order['total_price']; ?></p>

            <h5 class="mt-4 text-secondary">🛒 Order Items</h5>
            <hr>
            <table class="table table-striped table-hover text-center">
                <thead class="table-success">
                    <tr>
                        <th>Item Name</th>
                        <th>Type</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item) { ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo ucfirst($item['type']); ?></td>
                            <td>₹<?php echo $item['price']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-center">
            <button onclick="window.print()" class="btn btn-outline-primary me-2">🖨 Print Invoice</button>
            <a href="../pages/dashboard.php?page=reports" class="btn btn-outline-primary me-2">🔙 Back to Invoices</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
