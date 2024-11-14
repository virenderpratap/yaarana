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

    // Handle form submission to add or update a hotel
    if (isset($_POST['save_hotel'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $imagePath = '';

        // Check if it's an update or new hotel addition
        if (isset($_POST['hotel_id']) && !empty($_POST['hotel_id'])) {
            $hotel_id = $_POST['hotel_id'];

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

            // Update the hotel in the database
            $sql_update = "UPDATE hotels SET title = '$title', address = '$address', phone_number = '$phone_number', description = '$description'";
            if (!empty($imagePath)) {
                $sql_update .= ", image_path = '$imagePath'";
            }
            $sql_update .= " WHERE id = $hotel_id";

            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Hotel updated successfully!";
                header('Location: AddHotel.php');
                exit;
            } else {
                echo "<script>alert('Error updating hotel: " . mysqli_error($con) . "');</script>";
            }

        } else {
            // Insert a new hotel if no ID is present
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

            // Insert new hotel data into the database
            $sql_insert = "INSERT INTO hotels (title, address, phone_number, description, image_path) VALUES ('$title', '$address', '$phone_number', '$description', '$imagePath')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Hotel added successfully!";
                header('Location: AddHotel.php');
                exit;
            } else {
                echo "<script>alert('Error adding hotel: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch hotel details if editing
    $edit_hotel = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM hotels WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_hotel = mysqli_fetch_assoc($result_edit);
    }

    // Delete a hotel
    if (isset($_GET['delete_id'])) {
        $hotel_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM hotels WHERE id = $hotel_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Hotel deleted successfully!";
            header('Location: AddHotel.php');
            exit;
        } else {
            echo "<script>alert('Error deleting hotel: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Welcome - Manage Hotels</title>
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
                <section class="top-hotels">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($edit_hotel) ? 'Edit' : 'Add a New'; ?> <span>Hotel</span></h2>
                        </div>
                        <form action="AddHotel.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Hotel Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($edit_hotel) ? htmlspecialchars($edit_hotel['title']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Hotel Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($edit_hotel) ? htmlspecialchars($edit_hotel['address']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Hotel Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo isset($edit_hotel) ? htmlspecialchars($edit_hotel['phone_number']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Hotel Description</label>
                                <textarea class="form-control" id="description" name="description" required><?php echo isset($edit_hotel) ? htmlspecialchars($edit_hotel['description']) : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Hotel Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if (isset($edit_hotel) && $edit_hotel['image_path']): ?>
                                    <img src="<?php echo $edit_hotel['image_path']; ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="hotel_id" value="<?php echo isset($edit_hotel) ? $edit_hotel['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary" name="save_hotel">
                                <?php echo isset($edit_hotel) ? 'Update Hotel' : 'Add Hotel'; ?>
                            </button>
                        </form>
                    </div>
                </section>

                <section class="hotel-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Hotels</span></h2>
                        </div>
                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Hotel Title</th>
                                    <th>Address</th>
                                    <th>Phone Number</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_hotels = "SELECT * FROM hotels";
                                $result_hotels = mysqli_query($con, $sql_hotels);
                                if (mysqli_num_rows($result_hotels) > 0) {
                                    while ($hotel = mysqli_fetch_assoc($result_hotels)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($hotel['title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($hotel['address']) . "</td>";
                                        echo "<td>" . htmlspecialchars($hotel['phone_number']) . "</td>";
                                        echo "<td>" . htmlspecialchars($hotel['description']) . "</td>";
                                        echo "<td><img src='" . $hotel['image_path'] . "' alt='" . htmlspecialchars($hotel['title']) . "' width='100'></td>";
                                        echo "<td>
                                                <a href='AddHotel.php?edit_id=" . $hotel['id'] . "' class='btn btn-warning'>Edit</a>
                                                <a href='AddHotel.php?delete_id=" . $hotel['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this hotel?\")'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='no-data'>No hotels available.</td></tr>";
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
