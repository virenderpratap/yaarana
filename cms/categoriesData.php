<?php
include('include/config.php');

$draw = $_GET['draw'];
$start = $_GET['start'];
$length = $_GET['length'];
$searchValue = $_GET['search']['value'];

// Query to fetch filtered data
$query = "SELECT * FROM category WHERE categoryName LIKE '%$searchValue%' LIMIT $start, $length";
$result = mysqli_query($con, $query);

// Get total number of records
$totalQuery = "SELECT COUNT(*) AS total FROM category";
$totalResult = mysqli_query($con, $totalQuery);
$totalRecords = mysqli_fetch_assoc($totalResult)['total'];

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        htmlspecialchars($row['categoryName']),
        htmlspecialchars($row['categoryDescription']),
        '<img src="uploads/' . htmlspecialchars($row['categoryimg']) . '" style="width:100px;">',
        '<a href="category.php?edit_id=' . $row['id'] . '" class="btn btn-warning">Edit</a>
         <a href="category.php?del&id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>'
    ];
}

echo json_encode([
    "draw" => intval($draw),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords, // Adjust if search filtering is enabled
    "data" => $data
]);
?>
