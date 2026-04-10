<?php
include("../api/connect.php");

if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['register_as'] !== 'Admin') {
    echo "<div class='alert alert-danger text-center'>Unauthorized access!</div>";
    exit();
}

// Pagination Setup
$limit = 5; // Number of entries per page
$page = isset($_GET['page_no']) ? intval($_GET['page_no']) : 1;
$offset = ($page - 1) * $limit;

// Fetch fertilizers with pagination
$query = "SELECT * FROM fertilizers LIMIT $limit OFFSET $offset";
$result = mysqli_query($connect, $query);


// Get total records
$totalQuery = "SELECT COUNT(*) AS total FROM fertilizers";
$totalResult = mysqli_query($connect, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fertilizer List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
   
<div class="d-flex justify-content-between align-items-center">
    <h2 class="text-success">🌿 Fertilizer List</h2>
    <a href="dashboard.php?page=add_fertilizers" class="btn btn-primary">⬅ Back to Add Fertilizer</a>
</div>
    

<div class="table-responsive mt-4">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-success text-center">
                <tr>
                    <th>Fertilizer Name</th>
                    <th>Price (₹)</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                 while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr id="row_<?php echo $row['id']; ?>">
                        <td><?php echo $row['fertilizer_name']; ?></td>
                        <td>₹<?php echo $row['fertilizer_price']; ?></td>
                        <td><?php echo $row['fertilizer_quantity']; ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" 
                                    onclick="editFertilizer(<?php echo $row['id']; ?>, 
                                                             '<?php echo $row['fertilizer_name']; ?>', 
                                                             '<?php echo $row['fertilizer_price']; ?>', 
                                                             '<?php echo $row['fertilizer_quantity']; ?>')">
                                ✏️ Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteFertilizer(<?php echo $row['id']; ?>)">🗑️ Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="dashboard.php?page=list_fertilizer&page_no=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Edit Fertilizer Modal -->
<div class="modal fade" id="editFertilizerModal" tabindex="-1" aria-labelledby="editFertilizerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Fertilizer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateFertilizerForm">
                    <input type="hidden" name="fertilizer_id" id="fertilizer_id">
                    <div class="mb-3">
                        <label class="form-label">Fertilizer Name:</label>
                        <input type="text" name="fertilizer_name" id="fertilizer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (₹):</label>
                        <input type="number" name="fertilizer_price" id="fertilizer_price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity:</label>
                        <input type="text" name="fertilizer_quantity" id="fertilizer_quantity" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="updateFertilizer()">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editFertilizer(id, name, price, quantity) {
    document.getElementById("fertilizer_id").value = id;
    document.getElementById("fertilizer_name").value = name;
    document.getElementById("fertilizer_price").value = price;
    document.getElementById("fertilizer_quantity").value = quantity;
    var editModal = new bootstrap.Modal(document.getElementById('editFertilizerModal'));
    editModal.show();
}

function updateFertilizer() {
    let formData = new FormData(document.getElementById("updateFertilizerForm"));

    fetch("../api/update_fertilizer.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("Fertilizer updated successfully!");
            location.reload();
        } else {
            alert("Update failed: " + data);
        }
    })
    .catch(error => console.error("Error:", error));
}

function deleteFertilizer(id) {
    if (confirm("Are you sure you want to delete this fertilizer?")) {
        fetch(`../api/delete_fertilizer.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Fertilizer deleted successfully!");
                    document.getElementById("row_" + id).remove();
                } else {
                    alert("Delete failed: " + data);
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
