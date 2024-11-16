<?php
session_start();
include('include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // Set timezone
    $currentTime = date('d-m-Y h:i:s A', time()); // Current time

    // Add new category
    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $productimage1 = $_FILES["productimage1"]["name"];

        // If an image is uploaded, move the file to the target directory
        if ($productimage1) {
            move_uploaded_file($_FILES["productimage1"]["tmp_name"], "./uploads/" . $productimage1);
        }

        // Insert category into the database
        mysqli_query($con, "INSERT INTO category (categoryName, categoryDescription, categoryimg) VALUES ('$category', '$description', '$productimage1')");
        $_SESSION['msg'] = "Category Added Successfully!";
    }

    // Update category
    if (isset($_POST['update'])) {
        $category_id = $_POST['category_id'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $productimage1 = $_FILES["productimage1"]["name"];

        // If a new image is uploaded, update it
        if ($productimage1) {
            move_uploaded_file($_FILES["productimage1"]["tmp_name"], "./uploads/" . $productimage1);
            $update_image_query = ", categoryimg='$productimage1'";
        } else {
            $update_image_query = "";
        }

        // Update category in the database
        mysqli_query($con, "UPDATE category SET categoryName='$category', categoryDescription='$description' $update_image_query WHERE id='$category_id'");
        $_SESSION['msg'] = "Category Updated Successfully!";
    }

    // Delete category
    if (isset($_GET['del'])) {
        $id = $_GET['id'];
        mysqli_query($con, "DELETE FROM category WHERE id='$id'");
        $_SESSION['delmsg'] = "Category Deleted Successfully!";
    }

    // Fetch category data for editing
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = mysqli_query($con, "SELECT * FROM category WHERE id='$edit_id'");
        $edit_package = mysqli_fetch_array($sql_edit);
    }
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage India Tour Packages</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>

<div id="container-wrapper">
    <!-- Include Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Include Header -->
    <?php include('header.php'); ?>

    <!-- Main Content -->
    <div class="dashboard-content">
        <div class="row">
            <section class="top-deals">
                <div class="container">
                    <div class="section-title title-full">
                        <h2><?php echo isset($edit_package) ? 'Edit' : 'Add a New'; ?> <span style="color:#91b133">Category</span></h2>
                    </div>
                    <!-- Add or Edit Category Form -->
                    <form action="category.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="category">Category Name</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?php echo isset($edit_package) ? htmlspecialchars($edit_package['categoryName']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?php echo isset($edit_package) ? htmlspecialchars($edit_package['categoryDescription']) : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productimage1">Category Image</label>
                            <input type="file" class="form-control" id="productimage1" name="productimage1" accept="image/*">
                            <?php if (isset($edit_package) && $edit_package['categoryimg']): ?>
                                <img src="../uploads/<?php echo $edit_package['categoryimg']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                            <?php endif; ?>
                        </div>

                        <input type="hidden" name="category_id" value="<?php echo isset($edit_package) ? $edit_package['id'] : ''; ?>">
                        <button type="submit" class="btn btn-primary" name="<?php echo isset($edit_package) ? 'update' : 'submit'; ?>">
                            <?php echo isset($edit_package) ? 'Update Category' : 'Add Category'; ?>
                        </button>
                    </form>
                </div>
            </section>

            <section class="package-list">
                <div class="container">
                    <div class="section-title title-full">
                        <h2>Manage <span style="color:#91b133">Categories</span></h2>
                    </div>
                    <!-- DataTables Table -->
                    <table id="categoriesTable" class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#categoriesTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "categoriesData.php",
            "columns": [
                { "title": "Category Name" },
                { "title": "Description" },
                { "title": "Image" },
                { "title": "Action" }
            ]
        });
    });
</script>

</body>
<style>
    .header_black { background: #242424; }
    .table-custom {
        background-color: #f8f9fa; /* Light background for the table */
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #dee2e6; /* Border color */
    }

    .table-custom th {
        background-color: #343a40; /* Dark header background */
        color: #fff; /* White text */
        text-align: center;
        font-weight: bold;
        padding: 10px;
    }

    .table-custom td {
        padding: 10px;
        vertical-align: middle;
        text-align: center;
    }

    .table-custom tbody tr:hover {
        background-color: #e9ecef; /* Highlight on hover */
    }

    .table-custom img {
        border-radius: 5px;
        max-width: 80px; /* Restrict image size */
    }

    .btn-sm {
        margin: 0 5px; /* Space between buttons */
    }

    .dataTables_wrapper {
        margin-top: 20px;
    }
</style>
</html>
<?php
}
?>
