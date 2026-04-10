<?php
// session_start();
include("../api/connect.php");

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
echo '<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>';
echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">';

echo '<div class="container mt-4">';
echo '<h2 class="mb-4 text-success fw-bold">🌱 Fertilizers</h2>';
echo '<div class="row">';

$sql = "SELECT * FROM fertilizers";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="table-responsive">';
    echo '<table id="fertilizerTable" class="table table-bordered table-hover">';
    echo '<thead class="table-success">';
    echo '<tr>';
    
    echo '<th>📌 Name</th>';
    echo '<th>📦 Quantity</th>';
    echo '<th>💰 Price</th>';
    echo '<th>🛒 Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
       
        echo '<td><strong>' . $row['fertilizer_name'] . '</strong></td>';
        echo '<td>' . $row['fertilizer_quantity'] . '</td>';
        echo '<td>₹' . $row['fertilizer_price'] . '</td>';
        echo '<td>';
        echo '<form method="post" action="../api/add_to_cart.php">';
        echo '<input type="hidden" name="type" value="fertilizer">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="name" value="' . $row['fertilizer_name'] . '">';
        echo '<input type="hidden" name="price" value="' . $row['fertilizer_price'] . '">';
        echo '<button type="submit" class="btn btn-primary btn-sm">🛍 Add to Cart</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<p class="alert alert-warning">No fertilizers found.</p>';
}

echo '</div>'; // row
echo '</div>'; // container
?>

<!-- DataTables Script for Pagination -->
<script>
    $(document).ready(function () {
        $('#fertilizerTable').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": false,
            "pageLength": 5
        });
    });
</script>
