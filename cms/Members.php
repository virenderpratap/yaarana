<?php
session_start();
include('include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Set timezone and current time
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add or update banner
    if (isset($_POST['save_banner'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $imagePath = '';

        // Handle image upload
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

        // Insert or update banner
        if (isset($_POST['banner_id']) && !empty($_POST['banner_id'])) {
            $banner_id = $_POST['banner_id'];
            $sql_update = "UPDATE banners SET title = '$title', image_url = '$imagePath' WHERE id = $banner_id";
            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Banner updated successfully!";
                header('Location: Banners.php');
                exit;
            } else {
                echo "<script>alert('Error updating banner: " . mysqli_error($con) . "');</script>";
            }
        } else {
            // Insert a new banner
            $sql_insert = "INSERT INTO banners (title, image_url) VALUES ('$title', '$imagePath')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Banner added successfully!";
                header('Location: Banners.php');
                exit;
            } else {
                echo "<script>alert('Error adding banner: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch banner details if editing
    $edit_banner = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM banners WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_banner = mysqli_fetch_assoc($result_edit);
    }

    // Delete a banner
    if (isset($_GET['delete_id'])) {
        $banner_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM banners WHERE id = $banner_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Banner deleted successfully!";
            header('Location: Banners.php');
            exit;
        } else {
            echo "<script>alert('Error deleting banner: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Banners</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

<body>

<!-- Start Container Wrapper -->
<div id="container-wrapper">
    <!-- Sidebar Navigation -->
    <div class="dashboard-nav-container">
        <div class="dashboard-nav">
            <ul class="dashboard-nav-list">
                <li><a href="Banners.php" class="active"><i class="sl sl-icon-home"></i> Banners</a></li>  
                <li><a href="welcome.php"><i class="sl sl-icon-home"></i> Add New Deals</a></li>
                <li><a href="/yaarana/cms/IndiaTour.php"><i class="sl sl-icon-book-open"></i> India Tour Packages</a></li>               
                <li><a href="HolidayTheam.php"><i class="sl sl-icon-book-open"></i> Holiday Themes</a></li>
                <li><a href="InternationalTour.php"><i class="sl sl-icon-globe"></i> International Tour </a></li>
                <li><a href="Members.php"><i class="sl sl-icon-book-open"></i> Members</a></li>
            </ul>
        </div>
    </div>

    <!-- Dashboard Main Content -->
    <div id="dashboard">
        <!-- Sticky Navigation -->
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

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="row">
                <!-- Banner Management -->
                <section class="banner-management">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($edit_banner) ? 'Edit' : 'Add a New'; ?> <span>Banner</span></h2>
                        </div>

                        <form action="Banners.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Banner Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($edit_banner) ? htmlspecialchars($edit_banner['title']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Banner Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if (isset($edit_banner) && $edit_banner['image_url']): ?>
                                    <img src="<?php echo $edit_banner['image_url']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>

                            <input type="hidden" name="banner_id" value="<?php echo isset($edit_banner) ? $edit_banner['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary" name="save_banner">
                                <?php echo isset($edit_banner) ? 'Update Banner' : 'Add Banner'; ?>
                            </button>
                        </form>
                    </div>
                </section>

                <!-- Banner List -->
                <section class="banner-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Banners</span></h2>
                        </div>

                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_banners = "SELECT * FROM banners";
                                $result_banners = mysqli_query($con, $sql_banners);
                                if (mysqli_num_rows($result_banners) > 0) {
                                    while ($banner = mysqli_fetch_assoc($result_banners)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($banner['title']) . "</td>";
                                        echo "<td><img src='uploads/" . basename($banner['image_url']) . "' alt='" . htmlspecialchars($banner['title']) . "' style='width: 100px;'></td>";
                                        echo "<td>
                                            <a href='Banners.php?edit_id=" . $banner['id'] . "' class='btn btn-warning'>Edit</a>
                                            <a href='Banners.php?delete_id=" . $banner['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this banner?\")'>Delete</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='no-data'>No banners available.</td></tr>";
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

</body>
</html>
<?php
}
?>
