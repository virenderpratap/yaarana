<?php
session_start();
include('include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata'); // Set the timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add or update a tour package
    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $title = $_POST['title'];
        $products = $_POST['products'];

        // Insert case study into the database
        $sql = mysqli_query($con, "INSERT INTO casestudy(categoryName, categoryDescription, title, products) 
                                   VALUES('$category', '$description', '$title', '$products')");

        if ($sql) {
            $_SESSION['msg'] = "Itinerary Created !!";
        } else {
            $_SESSION['msg'] = "Error creating itinerary: " . mysqli_error($con);
        }
    }

    // Fetch package details if editing
    $edit_package = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM casestudy WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_package = mysqli_fetch_assoc($result_edit);
    }

    // Delete a package
    if (isset($_GET['delete_id'])) {
        $package_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM casestudy WHERE id = $package_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Package deleted successfully!";
            header('Location: manage-itinerary.php');
            exit;
        } else {
            echo "<script>alert('Error deleting package: " . mysqli_error($con) . "');</script>";
        }
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
                        <h2><?php echo isset($edit_package) ? 'Edit' : 'Add a New'; ?> <span>Manage Itinerary</span></h2>
                    </div>
                    <form action="manage-itinerary.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label" for="basicinput">Select Package</label>
                            <div class="controls">
                                <select name="products" class="" onChange="getSubcat(this.value);" required>
                                    <?php
                                    $query1 = mysqli_query($con, "SELECT * FROM products");
                                    while ($row1 = mysqli_fetch_array($query1)) {
                                        echo "<option value='" . $row1['id'] . "'>" . $row1['productName'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="basicinput">Day</label>
                            <div class="controls">
                                <input type="text" placeholder="Day 1" name="category" class="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="basicinput">Title</label>
                            <div class="controls">
                                <input type="text" placeholder="Enter Title" name="title" class="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="basicinput">Description</label>
                            <div class="controls">
                                <textarea class="ckeditor" name="description" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="controls">
                                <button type="submit" name="submit" class="btn">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <section class="package-list">
                <div class="container">
                    <div class="section-title title-full">
                        <h2>Manage <span>India Tour Packages</span></h2>
                    </div>
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Package Title</th>
                                <th>Category Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_packages = "SELECT * FROM casestudy";
                            $result_packages = mysqli_query($con, $sql_packages);

                            if (mysqli_num_rows($result_packages) > 0) {
                                while ($package = mysqli_fetch_assoc($result_packages)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($package['title']) . "</td>";
                                    echo "<td>" . htmlspecialchars($package['categoryDescription']) . "</td>";
                                    echo "<td>
                                        <a href='manage-itinerary.php?edit_id=" . $package['id'] . "' class='btn btn-warning'>Edit</a>
                                        <a href='manage-itinerary.php?delete_id=" . $package['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this package?\")'>Delete</a>
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
<style>
    .header_black {
        background: #242424;
    }
</style>
</html>

<?php
}
?>
