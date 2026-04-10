<?php
echo '<h2>🧾 Checkout</h2>';

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p style='color: red;'>Your cart is empty!</p>";
    exit();
}

$user_id = $_SESSION['userdata']['id'];
$total_price = 0;
$invoice_no = 'INV-' . strtoupper(uniqid());

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
echo '<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>';
echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">';

echo '<div class="container">
        <div class="row">
            <!-- Cart Summary -->
            <div class="col-md-6">
                <div class="border rounded shadow p-3 bg-white">
                    <h4 class="text-success">🛒 Order Summary</h4>
                    <div class="table-responsive">
                        <table id="cartTable" class="table table-bordered table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>📦 Item Name</th>
                                    <th>🔖 Type</th>
                                    <th>💰 Price</th>
                                </tr>
                            </thead>
                            <tbody>';

foreach ($_SESSION['cart'] as $item) {
    echo "<tr>
            <td>{$item['name']}</td>
            <td>" . ucfirst($item['type']) . "</td>
            <td>₹{$item['price']}</td>
          </tr>";
    $total_price += $item['price'];
}

echo '          </tbody>
                        </table>
                    </div>
                    <p class="fw-bold mt-2">Total Price: ₹' . $total_price . '</p>
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="col-md-6">
                <div class="border rounded p-4 bg-light shadow">
                    <h4 class="text-success">📦 Delivery Details</h4>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Delivery Address:</label>
                            <textarea name="address" class="form-control" rows="3" required placeholder="Enter your address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Payment Mode:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_mode" value="cash" required>
                                <label class="form-check-label">💰 Cash on Delivery</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_mode" value="card" required>
                                <label class="form-check-label">💳 Credit/Debit Card</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">🛒 Confirm Order</button>
                    </form>
                </div>
            </div>
        </div>
      </div>';

// Order Processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $payment_mode = mysqli_real_escape_string($connect, $_POST['payment_mode']);
    $order_data = json_encode($_SESSION['cart']);
    
    $sql = "INSERT INTO orders (user_id, invoice_no, items, total_price, address, payment_mode) VALUES ('$user_id', '$invoice_no', '$order_data', '$total_price', '$address', '$payment_mode')";
    
    if (mysqli_query($connect, $sql)) {
        unset($_SESSION['cart']); 
        echo "<script>alert('✅ Order Placed Successfully!'); window.location.href='dashboard.php?page=invoice';</script>";
    } else {
        echo "<p style='color: red;'>❌ Error placing order.</p>";
    }
}
?>

<!-- DataTables Script -->
<script>
    $(document).ready(function () {
        $('#cartTable').DataTable({
            "paging": true,
            "searching": false,
            "lengthChange": false,
            "pageLength": 5
        });
    });
</script>
