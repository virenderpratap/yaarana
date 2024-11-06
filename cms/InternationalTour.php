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
    if (isset($_POST['save_package'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $image_path = '';
        
        // Check if it's an update or new package addition
        if (isset($_POST['package_id']) && !empty($_POST['package_id'])) {
            $package_id = $_POST['package_id'];

            // Handle image upload only if a new image is uploaded
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $imageTmpName = $_FILES['image']['tmp_name'];
                $imageName = basename($_FILES['image']['name']);
                $imageType = mime_content_type($imageTmpName);
                $uploadFolder = 'uploads/';

                // Check if it's a valid image
                if (strpos($imageType, 'image') !== false) {
                    if (!is_dir($uploadFolder)) {
                        mkdir($uploadFolder, 0777, true);
                    }
                    $imagePath = $uploadFolder . $imageName;
                    move_uploaded_file($imageTmpName, $imagePath);
                }
            }

            // Update the package in the database
            $sql_update = "UPDATE international_tours SET title = '$title'";
            if (!empty($imagePath)) {
                $sql_update .= ", image_url = '$imagePath'";
            }
            $sql_update .= " WHERE id = $package_id";

            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Tour package updated successfully!";
                header('Location: InternationalTour.php');
                exit;
            } else {
                echo "<script>alert('Error updating package: " . mysqli_error($con) . "');</script>";
            }

        } else {
            // Insert a new package if no ID is present
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
            $sql_insert = "INSERT INTO international_tours (title, image_url) VALUES ('$title', '$imagePath')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Tour package added successfully!";
                header('Location: InternationalTour.php');
                exit;
            } else {
                echo "<script>alert('Error adding package: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch package details if editing
    $edit_package = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM international_tours WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_package = mysqli_fetch_assoc($result_edit);
    }

    // Delete a package
    if (isset($_GET['delete_id'])) {
        $package_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM international_tours WHERE id = $package_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Package deleted successfully!";
            header('Location: InternationalTour.php');
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
    <title>Manage International Tour Packages</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>

<div id="container-wrapper">
    <div class="dashboard-nav-container">
        <div class="dashboard-nav">
            <ul class="dashboard-nav-list">
                <li><a href="welcome.php"><i class="sl sl-icon-home"></i> Add New Deals</a></li>
                <li><a href="/yaarana/cms/IndiaTour.php"><i class="sl sl-icon-book-open"></i>India Tour Packages</a></li>               
                <li><a href="HolidayTheam.php"><i class="sl sl-icon-book-open"></i> Holiday Themes</a></li>
                <li><a href="InternationalTour.php" class="active"><i class="sl sl-icon-globe"></i> International Tour </a></li>
            </ul>
        </div>
    </div>

    <div id="dashboard">
        <div class="dashboard-sticky-nav">
            <div class="content-left pull-left">
                <a href="dashboard.html"><img src="../images/logo-black.png" alt="logo"></a>
            </div>
            <div class="content-right pull-right">
                <div class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="profile-sec">
                            <a href="index.php"><button type="button"><i class="fa fa-sign-out-alt"></i> Logout</button></a>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="row">

                <section class="top-deals">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($edit_package) ? 'Edit' : 'Add a New'; ?> <span>International Tour Package</span></h2>
                        </div>

                        <form action="InternationalTour.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Package Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($edit_package) ? htmlspecialchars($edit_package['title']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Package Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if (isset($edit_package) && $edit_package['image_url']): ?>
                                    <img src="<?php echo $edit_package['image_url']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>

                            <input type="hidden" name="package_id" value="<?php echo isset($edit_package) ? $edit_package['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary" name="save_package">
                                <?php echo isset($edit_package) ? 'Update Package' : 'Add Package'; ?>
                            </button>
                        </form>
                    </div>
                </section>

                <section class="package-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Tour Packages</span></h2>
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
                                $sql_packages = "SELECT * FROM international_tours";
                                $result_packages = mysqli_query($con, $sql_packages);
                                 
                                if (mysqli_num_rows($result_packages) > 0) {
                                    while ($package = mysqli_fetch_assoc($result_packages)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($package['title']) . "</td>";
                                      
                                        echo "<td><img src='" . $package['image_url'] . "' alt='" . htmlspecialchars($package['title']) . "' style='width: 100px;'></td>";
                                        echo "<td>
                                            <a href='InternationalTour.php?edit_id=" . $package['id'] . "' class='btn btn-warning'>Edit</a>
                                            <a href='InternationalTour.php?delete_id=" . $package['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this package?\")'>Delete</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='no-data'>No packages available.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
}
?>
