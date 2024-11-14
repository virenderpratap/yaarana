<?php
session_start();
include('include/config.php');

// Check if the user is logged in
if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // Set timezone
    $currentTime = date('d-m-Y h:i:s A', time()); // Current time

    // Add new category
    if(isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $productimage1 = $_FILES["productimage1"]["name"];
        
        // If an image is uploaded, move the file to the target directory
        if($productimage1) {
            move_uploaded_file($_FILES["productimage1"]["tmp_name"], "./uploads/" . $productimage1);
        }

        // Insert category into the database
        $sql = mysqli_query($con, "INSERT INTO category (categoryName, categoryDescription, categoryimg) VALUES ('$category', '$description', '$productimage1')");

        $_SESSION['msg'] = "Category Added Successfully!";
    }

    // Update category
    if(isset($_POST['update'])) {
        $category_id = $_POST['category_id'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $productimage1 = $_FILES["productimage1"]["name"];
        
        // If a new image is uploaded, update it
        if($productimage1) {
            move_uploaded_file($_FILES["productimage1"]["tmp_name"], "./uploads/" . $productimage1);
            $update_image_query = ", categoryimg='$productimage1'";
        } else {
            $update_image_query = "";
        }

        // Update category in the database
        $sql = mysqli_query($con, "UPDATE category SET categoryName='$category', categoryDescription='$description' $update_image_query WHERE id='$category_id'");
        
        $_SESSION['msg'] = "Category Updated Successfully!";
    }

    // Delete category
    if(isset($_GET['del'])) {
        $id = $_GET['id'];
        mysqli_query($con, "DELETE FROM category WHERE id='$id'");
        $_SESSION['delmsg'] = "Category Deleted Successfully!";
    }

    // Fetch category data for editing
    if(isset($_GET['edit_id'])) {
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
                        <h2><?php echo isset($edit_package) ? 'Edit' : 'Add a New'; ?> <span>Category</span></h2>
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
                        <h2>Manage <span>Categories</span></h2>
                    </div>
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_categories = "SELECT * FROM category";
                            $result_categories = mysqli_query($con, $sql_categories);
                            
                            if (mysqli_num_rows($result_categories) > 0) {
                                while ($category = mysqli_fetch_assoc($result_categories)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($category['categoryName']) . "</td>";
                                    echo "<td>" . htmlspecialchars($category['categoryDescription']) . "</td>";
                                    echo "<td><img src='uploads/" . basename($category['categoryimg']) . "' alt='" . htmlspecialchars($category['categoryName']) . "' style='width: 100px;'></td>";
                                    echo "<td>
                                        <a href='category.php?edit_id=" . $category['id'] . "' class='btn btn-warning'>Edit</a>
                                        <a href='category.php?del&id=" . $category['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this category?\")'>Delete</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='no-data'>No categories available.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
    .header_black {
        background: #242424;
    }
</style>
</html>

<?php
}
?>
