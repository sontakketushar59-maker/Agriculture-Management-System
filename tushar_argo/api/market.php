<?php
session_start();
?>

<h2><i class="fas fa-shopping-cart"></i> Your Cart</h2>

<?php
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p style='color: red;'>Your cart is empty!</p>";
} else {
    echo "<table border='1' cellspacing='0' cellpadding='10' style='width: 100%; border-collapse: collapse;'>
            <thead style='background-color: #4caf50; color: white;'>
                <tr>
                    <th>Crop Name</th>
                    <th>Fertilizer</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($_SESSION['cart'] as $key => $item) {
        echo "<tr>
                <td>{$item['crop_name']}</td>
                <td>{$item['fertilizer']}</td>
                <td>{$item['price']}</td>
                <td>
                    <form method='POST' action='remove_from_cart.php'>
                        <input type='hidden' name='remove_key' value='{$key}'>
                        <button type='submit' class='btn' style='background-color: red;'>Remove</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
    echo "<br><a href='../pages/dashboard.php?page=checkout' class='btn'>Proceed to Checkout</a>";
}
?>
