<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission for adding/updating a gallery image
    if (isset($_POST['save_image'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        
        // Handle multiple image uploads
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $image_files = $_FILES['images'];
            $image_count = count($image_files['name']);
            $image_urls = [];

            // Ensure the directory exists
            $uploadFolder = 'uploads/gallery/';
            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder, 0777, true);
            }

            // Loop through each uploaded image
            for ($i = 0; $i < $image_count; $i++) {
                $imageTmpName = $image_files['tmp_name'][$i];
                $imageName = basename($image_files['name'][$i]);
                $imageType = mime_content_type($imageTmpName);
                $imagePath = $uploadFolder . $imageName;

                // Upload image only if it's a valid image file
                if (strpos($imageType, 'image') !== false) {
                    if (move_uploaded_file($imageTmpName, $imagePath)) {
                        // Store each image path in an array
                        $image_urls[] = $imagePath;
                    } else {
                        echo "<script>alert('Error uploading image: $imageName');</script>";
                    }
                }
            }

            // Join the image paths into a comma-separated string
            $image_urls_str = implode(',', $image_urls);

            // Insert the new gallery entry with all image URLs
            $sql_insert = "INSERT INTO gallery1 (title, image_urls) VALUES ('$title', '$image_urls_str')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Images added successfully!";
                header('Location: AddToGallery.php');
                exit;
            } else {
                echo "<script>alert('Error inserting images into database: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Delete an image from the gallery (Note: This deletes the record, not individual images)
    if (isset($_GET['delete_id'])) {
        $image_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM gallery1 WHERE id = $image_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Image deleted successfully!";
            header('Location: AddToGallery.php');
            exit;
        } else {
            echo "<script>alert('Error deleting image: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Manage Gallery</title>
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
                <section class="gallery-management">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Add <span>Multiple Gallery Images</span></h2>
                        </div>
                        <form action="AddToGallery.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Gallery Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="images">Select Multiple Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_image">Add Images</button>
                        </form>
                    </div>
                </section>

                <!-- Gallery List Section -->
                <section class="gallery-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Gallery Images</span></h2>
                        </div>
                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Image Title</th>
                                    <th>Images</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_images = "SELECT * FROM gallery1";
                                $result_images = mysqli_query($con, $sql_images);
                                
                                if (mysqli_num_rows($result_images) > 0) {
                                    while ($image = mysqli_fetch_assoc($result_images)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($image['title']) . "</td>";
                                        
                                        // Display all images in this gallery record
                                        $image_urls = explode(',', $image['image_urls']);
                                        echo "<td>";
                                        foreach ($image_urls as $img_url) {
                                            echo "<img src='" . htmlspecialchars($img_url) . "' alt='Gallery Image' style='width: 100px; margin-top: 10px;'>";
                                        }
                                        echo "</td>";
                                        
                                        echo "<td>
                                            <a href='AddToGallery.php?delete_id=" . $image['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this image?\")'>Delete</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No images available.</td></tr>";
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
    .header_black { background: #242424; }
    .dashboard-content { margin-left: 250px; margin-top: 80px; padding: 20px; }
    .section-title { margin-bottom: 20px; }
    .btn-primary, .btn-danger { border-radius: 5px; }
    .table-custom th, .table-custom td { text-align: center; vertical-align: middle; }
    .gallery-list img { width: 100px; margin-top: 10px; }
</style>
</html>
<?php } ?>
