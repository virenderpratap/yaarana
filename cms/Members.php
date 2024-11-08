<?php
session_start();
include_once('include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add or update a member
    if (isset($_POST['save_member'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $imagePath = '';

        // Check if it's an update or new member addition
        if (isset($_POST['member_id']) && !empty($_POST['member_id'])) {
            $member_id = $_POST['member_id'];

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

            // Update the member in the database
            $sql_update = "UPDATE members SET name = '$name'";
            if (!empty($imagePath)) {
                $sql_update .= ", image_path = '$imagePath'";
            }
            $sql_update .= " WHERE id = $member_id";

            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Member updated successfully!";
                header('Location: Members.php');
                exit;
            } else {
                echo "<script>alert('Error updating member: " . mysqli_error($con) . "');</script>";
            }

        } else {
            // Insert a new member if no ID is present
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
            $sql_insert = "INSERT INTO members (name, image_path) VALUES ('$name', '$imagePath')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Member added successfully!";
                header('Location: Members.php');
                exit;
            } else {
                echo "<script>alert('Error adding member: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch member details if editing
    $edit_member = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM members WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_member = mysqli_fetch_assoc($result_edit);
    }

    // Delete a member
    if (isset($_GET['delete_id'])) {
        $member_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM members WHERE id = $member_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Member deleted successfully!";
            header('Location: Members.php');
            exit;
        } else {
            echo "<script>alert('Error deleting member: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Members</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>

<div id="container-wrapper">
    <?php include 'sidebar.php'; ?> <!-- Include Sidebar -->

    <div id="dashboard">
        <?php include 'header.php'; ?> <!-- Include Header -->

        <div class="dashboard-content">
            <div class="row">

                <section class="top-deals">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($edit_member) ? 'Edit' : 'Add a New'; ?> <span>Member</span></h2>
                        </div>

                        <form action="Members.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Member Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($edit_member) ? htmlspecialchars($edit_member['name']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Member Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if (isset($edit_member) && $edit_member['image_path']): ?>
                                    <img src="<?php echo $edit_member['image_path']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>

                            <input type="hidden" name="member_id" value="<?php echo isset($edit_member) ? $edit_member['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary" name="save_member">
                                <?php echo isset($edit_member) ? 'Update Member' : 'Add Member'; ?>
                            </button>
                        </form>
                    </div>
                </section>

                <section class="package-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Members</span></h2>
                        </div>

                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_members = "SELECT * FROM members";
                                $result_members = mysqli_query($con, $sql_members);

                                if (mysqli_num_rows($result_members) > 0) {
                                    while ($member = mysqli_fetch_assoc($result_members)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($member['name']) . "</td>";
                                        echo "<td><img src='" . $member['image_path'] . "' alt='" . htmlspecialchars($member['name']) . "' style='width: 100px;'></td>";
                                        echo "<td>
                                            <a href='Members.php?edit_id=" . $member['id'] . "' class='btn btn-warning'>Edit</a>
                                            <a href='Members.php?delete_id=" . $member['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this member?\")'>Delete</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='no-data'>No members available.</td></tr>";
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
<style>
.header_black {
    background: #242424;
}
</style>
</html>

<?php
}
?>
