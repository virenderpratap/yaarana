

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
session_start();
include('include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add or update a cab
    if (isset($_POST['save_cab'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $imagePath = '';

        // Check if it's an update or new cab addition
        if (isset($_POST['cab_id']) && !empty($_POST['cab_id'])) {
            $cab_id = $_POST['cab_id'];

            // Handle image upload only if a new image is uploaded
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

            // Update the cab in the database
            $sql_update = "UPDATE cabs SET title = '$title'";
            if (!empty($imagePath)) {
                $sql_update .= ", image_path = '$imagePath'";
            }
            $sql_update .= " WHERE id = $cab_id";

            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Cab updated successfully!";
                header('Location: AddCabs.php');
                exit;
            } else {
                echo "<script>alert('Error updating cab: " . mysqli_error($con) . "');</script>";
            }

        } else {
            // Insert a new cab if no ID is present
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

            // Insert new cab data into the database
            $sql_insert = "INSERT INTO cabs (title, image_path) VALUES ('$title', '$imagePath')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Cab added successfully!";
                header('Location: AddCabs.php');
                exit;
            } else {
                echo "<script>alert('Error adding cab: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch cab details if editing
    $edit_cab = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM cabs WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_cab = mysqli_fetch_assoc($result_edit);
    }

    // Delete a cab
    if (isset($_GET['delete_id'])) {
        $cab_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM cabs WHERE id = $cab_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Cab deleted successfully!";
            header('Location: AddCabs.php');
            exit;
        } else {
            echo "<script>alert('Error deleting cab: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Welcome - Manage Cabs</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>

<body>
<div id="container-wrapper">
    <?php include('sidebar.php'); ?>
    <div id="dashboard">
        <div class="dashboard-content">
            <div class="row">
                <section class="top-cabs">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($edit_cab) ? 'Edit' : 'Add a New'; ?> <span>Cab</span></h2>
                        </div>
                        <form action="AddCabs.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Cab Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($edit_cab) ? htmlspecialchars($edit_cab['title']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Cab Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if (isset($edit_cab) && $edit_cab['image_path']): ?>
                                    <img src="<?php echo $edit_cab['image_path']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="cab_id" value="<?php echo isset($edit_cab) ? $edit_cab['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary" name="save_cab">
                                <?php echo isset($edit_cab) ? 'Update Cab' : 'Add Cab'; ?>
                            </button>
                        </form>
                    </div>
                </section>

                <section class="cab-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Cabs</span></h2>
                        </div>
                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Cab Title</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_cabs = "SELECT * FROM cabs";
                                $result_cabs = mysqli_query($con, $sql_cabs);
                                if (mysqli_num_rows($result_cabs) > 0) {
                                    while ($cab = mysqli_fetch_assoc($result_cabs)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($cab['title']) . "</td>";
                                        echo "<td><img src='" . $cab['image_path'] . "' alt='" . htmlspecialchars($cab['title']) . "' width='100'></td>";
                                        echo "<td>
                                                <a href='AddCabs.php?edit_id=" . $cab['id'] . "' class='btn btn-warning'>Edit</a>
                                                <a href='AddCabs.php?delete_id=" . $cab['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this cab?\")'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='no-data'>No cabs available.</td></tr>";
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
<style>
    .header_black {
        background: #242424;
    }
</style>
</html>
<?php } ?>
