<?php
include("../api/connect.php");

if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['register_as'] !== 'Admin') {
    echo "<div class='alert alert-danger text-center'>Unauthorized access!</div>";
    exit();
}

// Pagination Setup
$limit = 5; // Number of records per page
$page = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
$page = max(1, $page); // Ensure page is at least 1
$start = ($page - 1) * $limit;

// Fetch Crops in Descending Order with Pagination
$query = "SELECT * FROM crops ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($connect, $query);

// Count total records for pagination
$totalQuery = "SELECT COUNT(*) as total FROM crops";
$totalResult = mysqli_query($connect, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crop List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <!-- Title and Back Button -->
    <div class="d-flex justify-content-between align-items-center">
    <h2 class="text-success">🌱 Crop List</h2>
    <a href="dashboard.php?page=add_crops_fertilizers" class="btn btn-primary">⬅ Back to Add Crop</a>
</div>

    
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-success text-center">
                <tr>
                    <th>Crop Name</th>
                    <th>Fertilizer</th>
                    <th>Price Per kg</th>
                    <th>District</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cropTable">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr id="row_<?php echo $row['id']; ?>">
                        <td><?php echo htmlspecialchars($row['crop_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['fertilizer']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['district']); ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['crop_name']); ?>', '<?php echo htmlspecialchars($row['fertilizer']); ?>', '<?php echo htmlspecialchars($row['price']); ?>', '<?php echo htmlspecialchars($row['district']); ?>')">✏️ Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteCrop(<?php echo $row['id']; ?>)">🗑️ Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Crop Modal -->
<div class="modal fade" id="editCropModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Crop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCropForm">
                    <input type="hidden" id="editCropId">
                    <div class="mb-3">
                        <label for="editCropName" class="form-label">Crop Name:</label>
                        <input type="text" id="editCropName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFertilizer" class="form-label">Fertilizer:</label>
                        <input type="text" id="editFertilizer" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price (₹):</label>
                        <input type="number" id="editPrice" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDistrict" class="form-label">District:</label>
                        <input type="text" id="editDistrict" class="form-control" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-success" onclick="updateCrop()">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="dashboard.php?page=list_crop&pageno=<?php echo $page - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="dashboard.php?page=list_crop&pageno=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="dashboard.php?page=list_crop&pageno=<?php echo $page + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<!-- JavaScript for Edit & Delete -->
<script>
function openEditModal(id, crop, fertilizer, price, district) {
    document.getElementById('editCropId').value = id;
    document.getElementById('editCropName').value = crop;
    document.getElementById('editFertilizer').value = fertilizer;
    document.getElementById('editPrice').value = price;
    document.getElementById('editDistrict').value = district;
    new bootstrap.Modal(document.getElementById('editCropModal')).show();
}

function updateCrop() {
    let id = document.getElementById('editCropId').value;
    let crop = document.getElementById('editCropName').value;
    let fertilizer = document.getElementById('editFertilizer').value;
    let price = document.getElementById('editPrice').value;
    let district = document.getElementById('editDistrict').value;

    fetch("../api/update_crop.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}&crop=${crop}&fertilizer=${fertilizer}&price=${price}&district=${district}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    });
}

function deleteCrop(id) {
    if (confirm("Are you sure you want to delete this crop?")) {
        fetch(`../api/delete_crop.php?id=${id}`)
            .then(response => response.text())
            .then(() => {
                alert("Crop deleted successfully!");
                document.getElementById("row_" + id).remove();
            })
            .catch(error => console.error('Error:', error));
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>