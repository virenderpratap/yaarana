<?php
session_start();
include('./include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata'); // Set the timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add a new tour package or update an existing one
    if (isset($_POST['submit'])) {
        // Get all the form data
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];
        $productname = $_POST['productName'];
        $covered = $_POST['covered'];
        $productdescription = $_POST['productDescription'];
        $duration = $_POST['duration'];
        $special = $_POST['special'];
        $cost = $_POST['cost'];
        $inclusion = $_POST['inclusion'];
        $exclusions = $_POST['exclusions'];
        $front = $_POST['front'];

        // Handle the image upload
        $productimage1 = $_FILES["productimage1"]["name"];
        if ($productimage1) {
            move_uploaded_file($_FILES["productimage1"]["tmp_name"], "uploads/" . $productimage1);
        }

        // Insert the new tour package
        $sql = mysqli_query($con, "INSERT INTO products(category, subCategory, productName, covered, productDescription, duration, productImage1, special, cost, inclusion, exclusions, front) 
                                   VALUES('$category', '$subcat', '$productname', '$covered', '$productdescription', '$duration', '$productimage1', '$special', '$cost', '$inclusion', '$exclusions', '$front')");
        $_SESSION['msg'] = "Package Inserted Successfully!! Please go to ADD ITINERARY for adding itinerary in this package.";
    }

    // Update an existing tour package
    if (isset($_POST['update'])) {
        // Get all the form data
        $package_id = $_POST['package_id'];
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];
        $productname = $_POST['productName'];
        $covered = $_POST['covered'];
        $productdescription = $_POST['productDescription'];
        $duration = $_POST['duration'];
        $special = $_POST['special'];
        $cost = $_POST['cost'];
        $inclusion = $_POST['inclusion'];
        $exclusions = $_POST['exclusions'];
        $front = $_POST['front'];

        // Handle the image upload
        $productimage1 = $_FILES["productimage1"]["name"];
        if ($productimage1) {
            move_uploaded_file($_FILES["productimage1"]["tmp_name"], "uploads/" . $productimage1);
            $sql_update = "UPDATE products SET category = '$category', subCategory = '$subcat', productName = '$productname', covered = '$covered', productDescription = '$productdescription', 
                           duration = '$duration', productImage1 = '$productimage1', special = '$special', cost = '$cost', inclusion = '$inclusion', exclusions = '$exclusions', front = '$front'
                           WHERE id = '$package_id'";
        } else {
            // If no new image uploaded, update the package without changing the image
            $sql_update = "UPDATE products SET category = '$category', subCategory = '$subcat', productName = '$productname', covered = '$covered', productDescription = '$productdescription', 
                           duration = '$duration', special = '$special', cost = '$cost', inclusion = '$inclusion', exclusions = '$exclusions', front = '$front'
                           WHERE id = '$package_id'";
        }

        if (mysqli_query($con, $sql_update)) {
            $_SESSION['edit_message'] = "Tour package updated successfully!";
            header('Location: insert-product.php');
            exit;
        } else {
            echo "<script>alert('Error updating package: " . mysqli_error($con) . "');</script>";
        }
    }

    // Delete a package
    if (isset($_GET['delete_id'])) {
        $package_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM products WHERE id = '$package_id'";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Package deleted successfully!";
            header('Location: insert-product.php');
            exit;
        } else {
            echo "<script>alert('Error deleting package: " . mysqli_error($con) . "');</script>";
        }
    }

    // Fetch package details if editing
    $edit_package = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM products WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_package = mysqli_fetch_assoc($result_edit);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage India Tour Packages</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function getSubcat(val) {
            $.ajax({
                type: "POST",
                url: "get_subcat.php",
                data: 'cat_id=' + val,
                success: function(data) {
                    $("#subcategory").html(data);
                }
            });
        }
    </script>
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
                        <h2><?php echo isset($edit_package) ? 'Edit' : 'Add a New'; ?> <span>India Tour Package</span></h2>
                    </div>
                    <form action="insert-product.php" method="POST" enctype="multipart/form-data">
                        <!-- Category selection -->
                        <div class="form-group">
                            <label for="category">State</label>
                            <select name="category" class="form-control" onChange="getSubcat(this.value);" required>
                                <option value="">Select State</option>
                                <?php 
                                $query = mysqli_query($con, "SELECT * FROM category");
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='{$row['id']}'" . (isset($edit_package) && $edit_package['category'] == $row['id'] ? ' selected' : '') . ">{$row['categoryName']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Subcategory selection -->
                        <div class="form-group">
                            <label for="subcategory">City</label>
                            <select name="subcategory" id="subcategory" class="form-control" required>
                                <?php
                                if (isset($edit_package)) {
                                    $subcat_query = mysqli_query($con, "SELECT * FROM subcategory WHERE categoryid='{$edit_package['category']}'");
                                    while ($row = mysqli_fetch_array($subcat_query)) {
                                        echo "<option value='{$row['id']}'" . ($edit_package['subCategory'] == $row['id'] ? ' selected' : '') . ">{$row['subcategory']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="productName">Package Name</label>
                            <input type="text" name="productName" id="productName" class="form-control" value="<?php echo isset($edit_package) ? $edit_package['productName'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="covered">Places Covered</label>
                            <input type="text" name="covered" id="covered" class="form-control" value="<?php echo isset($edit_package) ? $edit_package['covered'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="productDescription">Tour Description</label>
                            <textarea name="productDescription" id="productDescription" class="form-control" rows="6" required><?php echo isset($edit_package) ? $edit_package['productDescription'] : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" name="duration" id="duration" class="form-control" value="<?php echo isset($edit_package) ? $edit_package['duration'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="special">Special Attentions</label>
                            <textarea name="special" id="special" class="form-control" rows="6" required><?php echo isset($edit_package) ? $edit_package['special'] : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="cost">Package Cost</label>
                            <input type="text" name="cost" id="cost" class="form-control" value="<?php echo isset($edit_package) ? $edit_package['cost'] : 'On Request'; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="inclusion">Tour Inclusions</label>
                            <textarea name="inclusion" id="inclusion" class="form-control" rows="6" required><?php echo isset($edit_package) ? $edit_package['inclusion'] : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exclusions">Tour Exclusions</label>
                            <textarea name="exclusions" id="exclusions" class="form-control" rows="6" required><?php echo isset($edit_package) ? $edit_package['exclusions'] : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="front">Add in Front Page</label>
                            <select name="front" id="front" class="form-control" required>
                                <option value="yes" <?php echo isset($edit_package) && $edit_package['front'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="no" <?php echo isset($edit_package) && $edit_package['front'] == 'no' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="productimage1">Package Image</label>
                            <input type="file" name="productimage1" id="productimage1" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" name="<?php echo isset($edit_package) ? 'update' : 'submit'; ?>" class="btn btn-primary">
                                <?php echo isset($edit_package) ? 'Update' : 'Insert'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Package List -->
            <section class="package-list">
                <div class="container">
                    <div class="section-title title-full">
                        <h2>Manage <span>India Tour Packages</span></h2>
                    </div>
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Package Title</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_packages = "SELECT * FROM products";
                            $result_packages = mysqli_query($con, $sql_packages);

                            if (mysqli_num_rows($result_packages) > 0) {
                                while ($package = mysqli_fetch_assoc($result_packages)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($package['productName']) . "</td>";
                                    echo "<td><img src='uploads/" . basename($package['productImage1']) . "' alt='" . htmlspecialchars($package['productName']) . "' style='width: 100px;'></td>";
                                    echo "<td>
                                        <a href='insert-product.php?edit_id=" . $package['id'] . "' class='btn btn-warning'>Edit</a>
                                        <a href='insert-product.php?delete_id=" . $package['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this package?\")'>Delete</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='no-data'>No packages available.</td></tr>";
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
</html>

<?php } ?>
