<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission for adding or editing a package
    if (isset($_POST['save_package'])) {
        $packageName = mysqli_real_escape_string($con, $_POST['package_name']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $prise = isset($_POST['prise']) ? mysqli_real_escape_string($con, $_POST['prise']) : NULL;
        $imagePath = '';

        // Handle image upload if a new image is uploaded
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

        // Check if editing an existing package
        if (isset($_POST['package_id']) && !empty($_POST['package_id'])) {
            $package_id = $_POST['package_id'];

            // Update query
            $sql_update = "UPDATE holiday_packages SET package_name = '$packageName', description = '$description', prise = '$prise'";
            if (!empty($imagePath)) {
                $sql_update .= ", image = '$imagePath'";
            }
            $sql_update .= " WHERE id = $package_id";

            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Package updated successfully!";
                echo "<script>window.location.href = 'HolidayTheam.php';</script>";
                exit;
            } else {
                echo "<script>alert('Error updating package: " . mysqli_error($con) . "');</script>";
            }

        } else {
            // Insert a new package if no ID is present
            $sql_insert = "INSERT INTO holiday_packages (package_name, description, prise, image) VALUES ('$packageName', '$description', '$prise', '$imagePath')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Holiday package added successfully!";
                echo "<script>window.location.href = 'HolidayTheam.php';</script>";
                exit;
            } else {
                echo "<script>alert('Error adding package: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch package details if editing
    $edit_package = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = intval($_GET['edit_id']);
        $sql_edit = "SELECT * FROM holiday_packages WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_package = mysqli_fetch_assoc($result_edit);
    }

    // Delete a package
    if (isset($_GET['delete_id'])) {
        $package_id = intval($_GET['delete_id']);
        $sql_delete = "DELETE FROM holiday_packages WHERE id = $package_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Package deleted successfully!";
            echo "<script>window.location.href = 'HolidayTheam.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error deleting package: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Manage Holiday Packages</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <script>
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
<div id="container-wrapper">
    <?php include('sidebar.php'); ?>
    <div id="dashboard">
        <div class="dashboard-content">
            <div class="container">
                <h2><?php echo isset($edit_package) ? 'Edit' : 'Add New'; ?> Holiday Package</h2>
                <form action="HolidayTheam.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="package_name">Package Name</label>
                        <input type="text" class="form-control" id="package_name" name="package_name" value="<?php echo isset($edit_package) ? htmlspecialchars($edit_package['package_name']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo isset($edit_package) ? htmlspecialchars($edit_package['description']) : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prise">Price</label>
                        <input type="number" class="form-control" id="prise" name="prise" value="<?php echo isset($edit_package) ? htmlspecialchars($edit_package['prise']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Package Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <?php if (isset($edit_package) && $edit_package['image']): ?>
                            <img src="<?php echo $edit_package['image']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="package_id" value="<?php echo isset($edit_package) ? $edit_package['id'] : ''; ?>">
                    <button type="submit" class="btn btn-primary" name="save_package">
                        <?php echo isset($edit_package) ? 'Update Package' : 'Add Package'; ?>
                    </button>
                </form>

                <h2>Manage Holiday Packages</h2>

                <?php if (isset($_SESSION['add_message'])): ?>
                    <div class="alert alert-success" id="message">
                        <?php echo $_SESSION['add_message']; unset($_SESSION['add_message']); ?>
                    </div>
                    <script>hideMessage();</script>
                <?php elseif (isset($_SESSION['edit_message'])): ?>
                    <div class="alert alert-success" id="message">
                        <?php echo $_SESSION['edit_message']; unset($_SESSION['edit_message']); ?>
                    </div>
                    <script>hideMessage();</script>
                <?php elseif (isset($_SESSION['delete_message'])): ?>
                    <div class="alert alert-success" id="message">
                        <?php echo $_SESSION['delete_message']; unset($_SESSION['delete_message']); ?>
                    </div>
                    <script>hideMessage();</script>
                <?php endif; ?>

                <table class="table table-bordered table-custom">
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
                                echo "<td>
                                        <a href='HolidayTheam.php?edit_id=" . $package['id'] . "' class='btn btn-warning'>Edit</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='no-data'>No packages available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
<?php } ?>
