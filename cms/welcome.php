<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add or update a deal
    if (isset($_POST['save_deal'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);
        $imagePath = '';

        // Check if it's an update or new deal addition
        if (isset($_POST['deal_id']) && !empty($_POST['deal_id'])) {
            $deal_id = $_POST['deal_id'];

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

            // Update the deal in the database
            $sql_update = "UPDATE top_deals SET title = '$title', subtitle = '$subtitle'";
            if (!empty($imagePath)) {
                $sql_update .= ", image_path = '$imagePath'";
            }
            $sql_update .= " WHERE id = $deal_id";

            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Deal updated successfully!";
                header('Location: welcome.php');
                exit;
            } else {
                echo "<script>alert('Error updating deal: " . mysqli_error($con) . "');</script>";
            }

        } else {
            // Insert a new deal if no ID is present
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
            $sql_insert = "INSERT INTO top_deals (title, subtitle, image_path) VALUES ('$title', '$subtitle', '$imagePath')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Deal added successfully!";
                header('Location: welcome.php');
                exit;
            } else {
                echo "<script>alert('Error adding deal: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch deal details if editing
    $edit_deal = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM top_deals WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_deal = mysqli_fetch_assoc($result_edit);
    }

    // Delete a deal
    if (isset($_GET['delete_id'])) {
        $deal_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM top_deals WHERE id = $deal_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Deal deleted successfully!";
            header('Location: welcome.php');
            exit;
        } else {
            echo "<script>alert('Error deleting deal: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Welcome - Manage Deals</title>
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
                <section class="top-deals">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($edit_deal) ? 'Edit' : 'Add a New'; ?> <span>Deal</span></h2>
                        </div>
                        <form action="welcome.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Deal Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($edit_deal) ? htmlspecialchars($edit_deal['title']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="subtitle">Deal Subtitle</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo isset($edit_deal) ? htmlspecialchars($edit_deal['subtitle']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Deal Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if (isset($edit_deal) && $edit_deal['image_path']): ?>
                                    <img src="<?php echo $edit_deal['image_path']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="deal_id" value="<?php echo isset($edit_deal) ? $edit_deal['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary" name="save_deal">
                                <?php echo isset($edit_deal) ? 'Update Deal' : 'Add Deal'; ?>
                            </button>
                        </form>
                    </div>
                </section>

                <section class="deal-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Deals</span></h2>
                        </div>
                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Deal Title</th>
                                    <th>Deal Subtitle</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_deals = "SELECT * FROM top_deals";
                                $result_deals = mysqli_query($con, $sql_deals);
                                if (mysqli_num_rows($result_deals) > 0) {
                                    while ($deal = mysqli_fetch_assoc($result_deals)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($deal['title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($deal['subtitle']) . "</td>";
                                        echo "<td><img src='" . $deal['image_path'] . "' alt='" . htmlspecialchars($deal['title']) . "' width='100'></td>";
                                        echo "<td>
                                                <a href='welcome.php?edit_id=" . $deal['id'] . "' class='btn btn-warning'>Edit</a>
                                                <a href='welcome.php?delete_id=" . $deal['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this deal?\")'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='no-data'>No deals available.</td></tr>";
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
