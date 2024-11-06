<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add a holiday package
    if (isset($_POST['add_package'])) {
        $packageName = mysqli_real_escape_string($con, $_POST['package_name']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $prise = isset($_POST['prise']) ? mysqli_real_escape_string($con, $_POST['prise']) : NULL; // Use NULL if not provided
        $imagePath = '';

        // Handle the image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $imageType = mime_content_type($imageTmpName);
            $uploadFolder = 'uploads/';

            if (strpos($imageType, 'image') !== false) {
                if (!is_dir($uploadFolder)) {
                    mkdir($uploadFolder, 0777, true);
                }
                $imagePath = $uploadFolder . $imageName;
                move_uploaded_file($imageTmpName, $imagePath);
            }
        }

        // Insert the new package into the database
        $sql = "INSERT INTO holiday_packages (package_name, description, prise, image) 
                VALUES ('$packageName', '$description', '$prise', '$imagePath')";
        if (mysqli_query($con, $sql)) {
            $_SESSION['add_message'] = "Holiday package added successfully!";
            // Redirect to the same page to refresh using JavaScript
            echo "<script>
                    window.location.href = 'HolidayTheam.php'; 
                  </script>";
            exit;
        } else {
            echo "<script>alert('Error adding package: " . mysqli_error($con) . "');</script>";
        }
    }

    // Delete a package
    if (isset($_GET['delete_id'])) {
        $package_id = $_GET['delete_id'];

        // Make sure the id is an integer to prevent SQL injection
        $package_id = intval($package_id); 

        $sql_delete = "DELETE FROM holiday_packages WHERE id = $package_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Package deleted successfully!";
            // Redirect to the same page to refresh using JavaScript
            echo "<script>
                    window.location.href = 'HolidayTheam.php'; 
                  </script>";
            exit;
        } else {
            echo "<script>alert('Error deleting package: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Holiday Packages</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script>
        // Function to hide the message after a few seconds
        function hideMessage() {
            setTimeout(function() {
                var message = document.getElementById("message");
                if (message) {
                    message.style.display = "none";
                }
            }, 2000); 
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Add New Holiday Package</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="package_name">Package Name</label>
            <input type="text" class="form-control" id="package_name" name="package_name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="prise">Price</label>
            <input type="number" class="form-control" id="prise" name="prise">
        </div>

        <div class="form-group">
            <label for="image">Package Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary" name="add_package">Add Package</button>
    </form>

    <!-- Display Packages -->
    <h2>Manage Holiday Packages</h2>

    <?php if (isset($_SESSION['add_message'])): ?>
        <div class="alert alert-success" id="message">
            <?php 
                echo $_SESSION['add_message']; 
                unset($_SESSION['add_message']);
            ?>
        </div>
        <script>hideMessage();</script>
    <?php elseif (isset($_SESSION['delete_message'])): ?>
        <div class="alert alert-success" id="message">
            <?php 
                echo $_SESSION['delete_message']; 
                unset($_SESSION['delete_message']);
            ?>
        </div>
        <script>hideMessage();</script>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Package Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_packages = "SELECT * FROM holiday_packages";
            $result_packages = mysqli_query($con, $sql_packages);
             
            if (mysqli_num_rows($result_packages) > 0) {
                while ($package = mysqli_fetch_assoc($result_packages)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($package['package_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($package['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($package['prise']) . "</td>";
                    echo "<td><img src='" . $package['image'] . "' alt='" . htmlspecialchars($package['package_name']) . "' width='100'></td>";
                    echo "<td><a href='HolidayTheam.php?delete_id=" . $package['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this package?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No packages available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
}
?>
