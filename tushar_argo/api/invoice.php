<?php
include("../api/connect.php");

if (!isset($_SESSION['userdata'])) {
    echo "<div class='alert alert-danger text-center'>Unauthorized access!</div>";
    exit();
}

$user_id = $_SESSION['userdata']['id'];

// Pagination setup
$limit = 5; // Records per page
$page = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
$page = max(1, $page);
$start = ($page - 1) * $limit;

// Get total number of orders for pagination
$totalQuery = "SELECT COUNT(*) as total FROM orders WHERE user_id = '$user_id'";
$totalResult = mysqli_query($connect, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch user orders with pagination
$sql = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC LIMIT $start, $limit";
$result = mysqli_query($connect, $sql);
$invoice_count = mysqli_num_rows($result); // Count records
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        thead th {
            position: sticky;
            top: 0;
            background: #198754;
            color: white;
            z-index: 2;
        }
        .search-box {
            max-width: 300px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center">
            <h4>📊 Order Reports (<?php echo $invoice_count; ?>)</h4>
        </div>
        <div class="card-body">
            
            <!-- Search Bar -->
            <div class="d-flex justify-content-between align-items-center mt-0 mb-1">
                <input type="text" id="searchInput" class="form-control search-box" placeholder="🔍 Search Invoice...">
            </div>

            <?php if ($invoice_count > 0) { ?>
                <div class="table-container">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Order Date</th>
                                <th>Total Price</th>
                                <th>Payment Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="orderTable">
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['invoice_no']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td>₹<?php echo $row['total_price']; ?></td>
                                    <td><?php echo ucfirst($row['payment_mode']); ?></td>
                                    <td>
                                        <a href="../api/invoice_view.php?id=<?php echo $row['invoice_no']; ?>" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination UI -->
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=reports&pageno=<?php echo ($page - 1); ?>">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=reports&pageno=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>

                            <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=reports&pageno=<?php echo ($page + 1); ?>">Next</a>
                            </li>
                        </ul>
                    </nav>

                    <span class="text-muted">Showing <?php echo ($start + 1); ?> to <?php echo min($start + $limit, $totalRecords); ?> of <?php echo $totalRecords; ?> records</span>
                </div>
            <?php } else { ?>
                <p class="text-danger text-center">No invoices found!</p>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Search Functionality
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let searchQuery = this.value.toLowerCase();
        let rows = document.querySelectorAll("#orderTable tr");

        rows.forEach(row => {
            let invoiceNo = row.cells[0].textContent.toLowerCase();
            if (invoiceNo.includes(searchQuery)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

</body>
</html>
