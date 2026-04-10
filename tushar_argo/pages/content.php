<?php
include("../api/connect.php");

if (!isset($_SESSION['userdata'])) {
    echo "Unauthorized access!";
    exit();
}
?><style>
     .dashboard-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            background: #4caf50;
            padding: 15px;
            color: white;
            text-align: center;
            border-radius: 5px;
            width: 30%;
        }
</style>
<?php
$values = $_SESSION['userdata'];
$total_users = isset($_SESSION['total_users']) ? $_SESSION['total_users'] : 0;
$total_crops = isset($_SESSION['total_crops']) ? $_SESSION['total_crops'] : 0;
$total_orders = isset($_SESSION['total_orders']) ? $_SESSION['total_orders'] : 0;
$total_fertilizers = isset($_SESSION['total_fertilizers']) ? $_SESSION['total_fertilizers'] : 0;
$page = isset($_GET['page']) ? $_GET['page'] : '';

if ($page == 'profile') {
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';

    echo '<div class="container mt-4">
            <h2 class="text-success mb-4">👤 Profile</h2>
            <div class="card shadow-lg p-3 mb-5 bg-white rounded" style="max-width: 500px;">
                <div class="card-body">
                    <h4 class="card-title text-center text-primary fw-bold">User Details</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>🆔 Name:</strong> ' . $values['name'] . '</li>
                        <li class="list-group-item"><strong>📍 Address:</strong> ' . $values['address'] . '</li>
                        <li class="list-group-item"><strong>📞 Mobile:</strong> ' . $values['mobile'] . '</li>
                        <li class="list-group-item"><strong>🎭 Role:</strong> ' . ucfirst($values['register_as']) . '</li>
                    </ul>
                    
                </div>
            </div>
        </div>';
}
elseif ($page == 'dashboard') {
    echo "<h2 style='text-align:center; font-size:26px; color:#333; font-weight:bold; margin-bottom:20px;'>📊 Dashboard</h2>
        <div class='dashboard-stats' style='display:flex; justify-content:space-around; flex-wrap:wrap; gap:20px;'>
            <div class='stat-box' style='background:linear-gradient(135deg, #007bff, #00c6ff); padding:25px; border-radius:12px; text-align:center; box-shadow:0 6px 10px rgba(0,0,0,0.15); transition:transform 0.3s ease; color:white; flex:1; min-width:200px;'>
                <span style='font-size:35px;'>👥</span>
                <p style='font-size:20px; margin:12px 0; font-weight:bold;'>Total Users</p>
                <b style='font-size:24px;'>{$total_users}</b>
            </div>
            <div class='stat-box' style='background:linear-gradient(135deg, #28a745, #9be15d); padding:25px; border-radius:12px; text-align:center; box-shadow:0 6px 10px rgba(0,0,0,0.15); transition:transform 0.3s ease; color:white; flex:1; min-width:200px;'>
                <span style='font-size:35px;'>🌿</span>
                <p style='font-size:20px; margin:12px 0; font-weight:bold;'>Total Crops</p>
                <b style='font-size:24px;'>{$total_crops}</b>
            </div>
            <div class='stat-box' style='background:linear-gradient(135deg, #dc3545, #ff758c); padding:25px; border-radius:12px; text-align:center; box-shadow:0 6px 10px rgba(0,0,0,0.15); transition:transform 0.3s ease; color:white; flex:1; min-width:200px;'>
                <span style='font-size:35px;'>🛍️</span>
                <p style='font-size:20px; margin:12px 0; font-weight:bold;'>Total Orders</p>
                <b style='font-size:24px;'>{$total_orders}</b>
            </div>
            <div class='stat-box' style='background:linear-gradient(135deg, #ff9800, #ffcc80); padding:25px; border-radius:12px; text-align:center; box-shadow:0 6px 10px rgba(0,0,0,0.15); transition:transform 0.3s ease; color:white; flex:1; min-width:200px;'>
                <span style='font-size:35px;'>🧪</span>
                <p style='font-size:20px; margin:12px 0; font-weight:bold;'>Total Fertilizers</p>
                <b style='font-size:24px;'>{$total_fertilizers}</b>
            </div>
        </div>

        <style>
            .stat-box:hover {
                transform: scale(1.05);
            }
        </style>";
}
 elseif ($page == 'add_crops_fertilizers') {
    include("../api/add_crops_fertilizers.php");
} elseif ($page == 'list_crop') {
    include("../api/list_crops.php");
} elseif ($page == 'add_fertilizers') {
    include("../api/add_fertilizers.php");
} elseif ($page == 'list_fertilizer') {
    include("../api/list_fertilizer.php");
} elseif ($page == 'suggestions') {
    include("../api/suggestions.php"); 
} 
 elseif ($page == 'fertilizer') {
    include("../api/getfertilizer.php");
} 
elseif ($page == 'invoice') {
   include("../api/invoice.php");

}
elseif ($page == 'reports') {
    include("../api/report.php");
 
 }
elseif ($page == 'checkout') {
    include("../api/checkout.php");
}
elseif ($page == 'market') {
   
        echo "<h2 style='font-family: Arial, sans-serif; color: #333; text-align: center; margin-bottom: 20px;'>🛒 Your Cart</h2>";
    
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $cart = $_SESSION['cart'];
            $items_per_page = 5; // Number of items per page
            $total_items = count($cart);
            $total_pages = ceil($total_items / $items_per_page);
            $current_page = isset($_GET['page_num']) ? max(1, min($total_pages, intval($_GET['page_num']))) : 1;
            $start_index = ($current_page - 1) * $items_per_page;
            $cart_items = array_slice($cart, $start_index, $items_per_page);
            
            echo "<div style='max-height: 350px; overflow-y: auto; border: 1px solid #ddd; border-radius: 8px; padding: 8px; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
            <table border='0' cellspacing='0' cellpadding='10' style='width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;'>
                <thead style='background-color: #4CAF50; color: white; position: sticky; top: 0; z-index: 2;'>
                    <tr style='text-align: left;'>
                        <th style='padding: 12px;'>Item Name</th>
                        <th style='padding: 12px;'>Type</th>
                        <th style='padding: 12px;'>Price</th>
                        <th style='padding: 12px; text-align: center;'>Action</th>
                    </tr>
                </thead>
                <tbody>";
            
            foreach ($cart_items as $index => $item) {
                $real_index = $start_index + $index; // Adjust index for actual cart
                echo "<tr style='background-color: #f9f9f9; transition: background 0.3s;'>
                        <td style='padding: 12px; border-bottom: 1px solid #ddd;'>{$item['name']}</td>
                        <td style='padding: 12px; border-bottom: 1px solid #ddd;'>" . ucfirst($item['type']) . "</td>
                        <td style='padding: 12px; border-bottom: 1px solid #ddd; font-weight: bold; color: #4CAF50;'>₹{$item['price']}</td>
                        <td style='padding: 12px; border-bottom: 1px solid #ddd; text-align: center;'>
                            <a href='../api/remove_from_cart.php?index={$real_index}' 
                               style='background-color: red; color: white; padding: 8px 14px; text-decoration: none; border-radius: 5px; font-size: 14px; transition: 0.3s; display: inline-block;'>
                               ❌ Remove
                            </a>
                        </td>
                      </tr>";
            }
        
            echo "  </tbody>
            </table>
          </div>";
        
            // Pagination Controls
            echo "<div style='text-align: center; margin-top: 15px;'>";
            if ($total_pages > 1) {
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $current_page) ? "background-color: #4CAF50; color: white;" : "background-color: #ddd; color: black;";
                    echo "<a href='?page=market&page_num=$i' 
                            style='margin: 2px; padding: 8px 12px; text-decoration: none; border-radius: 5px; font-size: 14px; display: inline-block; $active'>
                            $i
                          </a>";
                }
            }
            echo "</div>";
        
            echo "<br><div style='text-align: center;'>
                    <a href='../pages/dashboard.php?page=checkout' 
                    style='display: inline-block; background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; font-size: 16px; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); transition: 0.3s;'>
                    ✅ Proceed to Checkout
                  </a></div>";
        } else {
            echo "<p style='color: red; font-weight: bold; text-align: center;'>Your cart is empty!</p>";
        }
    } else {
        echo "<h2>Welcome to the Dashboard</h2><p>Select an option from the sidebar to view details.</p>";
    }


?>


<!-- Order Confirmation Popup -->
<div id="orderPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); 
    background: white; padding: 20px; box-shadow: 0px 0px 10px rgba(0,0,0,0.2); text-align: center; border-radius: 8px; z-index: 1000;">
    <p style="color: green; font-size: 18px;">✅ Order placed successfully! <br> Invoice No: <b><?php echo $invoice_no; ?></b></p>
    <a href="../pages/dashboard.php?page=invoice" style="display: inline-block; padding: 10px 15px; background: #4caf50; color: white; text-decoration: none; border-radius: 5px;">View Invoice</a>
</div>