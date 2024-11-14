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

    // Handle form submission to add a gallery image and a product
    if (isset($_POST['submit'])) {
        // Get the category from the form
        $category = $_POST['category'];

        // Initialize $gallery with an empty string
        $gallery = '';

        // Check if an image is uploaded
        if (isset($_FILES["gallery"]) && $_FILES["gallery"]["error"] == 0) {
            $gallery = $_FILES["gallery"]["name"];
            // Move the uploaded file to the 'uploads' folder
            $gallery_tmp = $_FILES["gallery"]["tmp_name"];
            move_uploaded_file($gallery_tmp, "uploads/" . $gallery);
        }

        // Insert product and gallery information into the products table
        $sql = mysqli_query($con, "INSERT INTO products (category, gallery) VALUES ('$category', '$gallery')");
        if ($sql) {
            $_SESSION['msg'] = "Package Inserted Successfully! Please go to ADD ITINERARY for adding itinerary in this package.";
        } else {
            $_SESSION['msg'] = "Error inserting product: " . mysqli_error($con);
        }
    }

    // Handle package deletion
    if (isset($_GET['del'])) {
        $package_id = $_GET['id'];
        $sql_delete = "DELETE FROM gallery WHERE id = $package_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Image deleted successfully!";
            header('Location: gallery.php');
            exit;
        } else {
            echo "<script>alert('Error deleting image: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Gallery</title>
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
                        <h2><?php echo isset($edit_package) ? 'Edit' : 'Add a New'; ?> <span>Gallery Image</span></h2>
                    </div>
                    <form action="manage-images.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label" for="category">Select Category</label>
                            <div class="controls">
                                <select name="category" class="form-control" required>
                                    <?php
                                    // Fetch product categories from the database
                                    $query1 = mysqli_query($con, "SELECT * FROM products");
                                    while ($row1 = mysqli_fetch_array($query1)) {
                                        echo "<option value='" . $row1['id'] . "'>" . $row1['productName'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="gallery">Gallery Image</label>
                            <div class="controls">
                                <input type="file" name="gallery" id="gallery" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="controls">
                                <button type="submit" name="submit" class="btn btn-primary">Upload Image</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <section class="package-list">
                <div class="container">
                    <div class="section-title title-full">
                        <h2>Manage <span>Gallery</span></h2>
                    </div>
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php 
                             // Fetch gallery images from the database
                             $query = mysqli_query($con, "SELECT * FROM gallery");
                             while ($row = mysqli_fetch_array($query)) {
                             ?>
                                <tr>
                                    <td><img src="uploads/<?php echo htmlentities($row['gallery']); ?>" width="100" height="100" alt="Gallery Image"></td>
                                    <td>
                                        <a href="edit-gallery.php?id=<?php echo $row['id']; ?>"><i class="icon-edit"></i></a>
                                        <a href="gallery.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure you want to delete this image?')"><i class="icon-remove-sign"></i></a>
                                    </td>
                                </tr>
                             <?php 
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
