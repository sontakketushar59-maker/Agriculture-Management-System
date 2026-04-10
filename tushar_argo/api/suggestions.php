<?php
include("../api/connect.php");

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';

// Pagination setup
$limit = 4; // Number of results per page
$page = isset($_GET['page_number']) ? (int)$_GET['page_number'] : 1;
$offset = ($page - 1) * $limit;

// Preserve district input
$district = isset($_POST['district']) ? $_POST['district'] : (isset($_GET['district']) ? $_GET['district'] : '');

// Fetch unique districts from database
$districtQuery = "SELECT DISTINCT district FROM crops ORDER BY district ASC";
$districtResult = mysqli_query($connect, $districtQuery);

echo '<div class="container mt-0">
        <h2 class="mb-3 text-success">🌱 Get Crop & Fertilizer Suggestions</h2>
        <form method="POST" action="" class="d-flex gap-2">
            <select name="district" id="district" class="form-control w-50" required>
                <option value="">-- Select District --</option>';
                while ($row = mysqli_fetch_assoc($districtResult)) {
                    $selected = ($row['district'] == $district) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($row['district']) . '" ' . $selected . '>' . htmlspecialchars($row['district']) . '</option>';
                }
echo '      </select>
            <button type="submit" class="btn btn-success">🔍 Get Suggestions</button>
        </form>
      </div>';

if (!empty($district)) {
    $district = mysqli_real_escape_string($connect, $district);

    // Get total records count
    $countQuery = "SELECT COUNT(*) as total FROM crops WHERE district = '$district'";
    $countResult = mysqli_query($connect, $countQuery);
    $totalRows = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRows / $limit);

    // Fetch paginated results
    $sql = "SELECT id, crop_name, fertilizer, price FROM crops WHERE district = '$district' LIMIT $limit OFFSET $offset";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="container mt-4">
                <h3 class="text-primary">📍 Suggestions for <b>' . htmlspecialchars($district) . '</b>:</h3>
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Crop Name 🌾</th>
                            <th>Fertilizer Recommendation 🧪</th>
                            <th>Price per kg 💰</th>
                            <th>Action 🛒</th>
                        </tr>
                    </thead>
                    <tbody>';

        $index = $offset + 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $index++ . '</td>
                    <td class="fw-bold">' . htmlspecialchars($row['crop_name']) . '</td>
                    <td>' . htmlspecialchars($row['fertilizer']) . '</td>
                    <td class="text-danger fw-bold">' . number_format($row['price'], 2) . '</td>
                    <td>
                        <form method="POST" action="../api/add_to_cart.php">
                            <input type="hidden" name="crop_id" value="' . $row['id'] . '">
                            <input type="hidden" name="crop_name" value="' . htmlspecialchars($row['crop_name']) . '">
                            <input type="hidden" name="fertilizer" value="' . htmlspecialchars($row['fertilizer']) . '">
                            <input type="hidden" name="price" value="' . $row['price'] . '">
                            <button type="submit" class="btn btn-primary btn-sm">➕ Add to Cart</button>
                        </form>
                    </td>
                  </tr>';
        }

        echo '</tbody></table>'; // End Table

        // Pagination UI
        echo '<nav class="mt-3">
                <ul class="pagination justify-content-center">';

        if ($page > 1) {
            echo '<li class="page-item">
                    <a class="page-link" href="?page=suggestions&district=' . urlencode($district) . '&page_number=' . ($page - 1) . '">⬅️ Prev</a>
                  </li>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<li class="page-item ' . ($i == $page ? "active" : "") . '">
                    <a class="page-link" href="?page=suggestions&district=' . urlencode($district) . '&page_number=' . $i . '">' . $i . '</a>
                  </li>';
        }

        if ($page < $totalPages) {
            echo '<li class="page-item">
                    <a class="page-link" href="?page=suggestions&district=' . urlencode($district) . '&page_number=' . ($page + 1) . '">Next ➡️</a>
                  </li>';
        }

        echo '  </ul>
              </nav>
            </div>'; // End container
    } else {
        echo '<div class="container mt-3"><p class="alert alert-danger">⚠️ No recommendations found for this district.</p></div>';
    }
}
?>
