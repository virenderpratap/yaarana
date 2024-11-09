<?php
session_start();
include('include/config.php');
<<<<<<< HEAD
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    date_default_timezone_set('Asia/Kolkata'); // change according to timezone
    $currentTime = date('d-m-Y h:i:s A', time());
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editable Deal Section</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/plugin.css" rel="stylesheet" type="text/css">
    <!--Icons CSS-->
    <link href="css/icons.css" rel="stylesheet" type="text/css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Editable Styles */
        .editable-title, .editable-subtitle {
            cursor: pointer;
            padding: 5px;
            border: 1px dashed transparent;
        }

        .editable-title:hover, .editable-subtitle:hover {
            border-color: #007bff;
            background-color: #f1f1f1;
        }

        .deal-img img {
            max-width: 100%;
            height: auto;
            cursor: pointer;
=======

if (strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add a deal
    if (isset($_POST['add_deal'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);
        $image_path = '';

        // Handle the image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $imageType = mime_content_type($imageTmpName);
            $uploadFolder = 'uploads/';

            // Check if it's a valid image
            if (strpos($imageType, 'image') !== false) {
                // Create the upload folder if it doesn't exist
                if (!is_dir($uploadFolder)) {
                    mkdir($uploadFolder, 0777, true);
                }

                // Define the image path and move the file
                $imagePath = $uploadFolder . $imageName;
                move_uploaded_file($imageTmpName, $imagePath);
            }
        }

        // Insert the new deal into the database
        $sql = "INSERT INTO top_deals(title, subtitle, image_path) VALUES ('$title', '$subtitle', '$imagePath')";
        if (mysqli_query($con, $sql)) {
            $_SESSION['add_message'] = "Deal added successfully!";
            header('Location: welcome.php');
            exit;
        } else {
            echo "<script>alert('Error adding deal: " . mysqli_error($con) . "');</script>";
        }
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
    <?php include('header.php'); ?> <!-- Include header file here -->
    <title>Welcome - Manage Deals</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <style>
        .header_black {
            background: #242424;
        }

        /* Mobile Layout for Sidebar */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100%;
                background: #333;
                transition: left 0.3s ease;
            }

            #sidebar.active {
                left: 0;
            }

            #dashboard {
                margin-left: 0;
            }

            .dashboard-responsive-nav-trigger {
                /* display: block; */
                padding: 10px;
                cursor: pointer;
                color: #fff;
            }

            .dashboard-content {
                margin-left: 0;
            }

            .content-left img {
                width: 120px;
            }
>>>>>>> c3e58290e2c4b1c6954f79584ed226bd8ebc4eed
        }
    </style>
</head>

<body>
<<<<<<< HEAD
    <div id="container-wrapper">
        <div id="dashboard">

            <div class="dashboard-content">
                <div class="row">
                    <section class="top-deals">
                        <div class="container">
                            <div class="section-title title-full">
                                <h2 class="mar-0">Today's <span>Top Deals</span></h2>
                            </div>
                            <div class="row top-deal-slider">
                                <div class="col-md-4 slider-itemm">
                                    <div class="dealx">
                                        <div class="one">
                                            <!-- Editable Title -->
                                            <div class="editable-title" contenteditable="true">Diwali Sale On</div>
                                            <!-- Editable Subtitle -->
                                            <div class="editable-subtitle" contenteditable="true">Summer Tour Packages</div>
                                        </div>
                                        <div class="two">
                                            <div class="deal-img">
                                                <!-- Editable Image -->
                                                <img src="./images/package/malaysia.webp" alt="Deal Image" class="editable-image" data-image="malaysia.webp">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Upload Modal -->
    <div class="modal" id="imageUploadModal" tabindex="-1" role="dialog" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageUploadModalLabel">Upload New Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="imageUploadForm" enctype="multipart/form-data">
                        <input type="hidden" id="imageFileName" name="imageFileName">
                        <div class="form-group">
                            <label for="newImage">Choose Image</label>
                            <input type="file" class="form-control-file" id="newImage" name="newImage" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Make image editable and trigger image upload modal on click
            $('.editable-image').on('click', function() {
                var imageName = $(this).data('image');
                $('#imageFileName').val(imageName); // Set current image name in the hidden field
                $('#imageUploadModal').modal('show'); // Show image upload modal
            });

            // Handle image upload form submission
            $('#imageUploadForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: 'upload_image.php', // Backend PHP script to handle image upload
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        alert('Image uploaded successfully!');
                        $('#imageUploadModal').modal('hide');
                        location.reload(); // Reload to show the updated image
                    },
                    error: function() {
                        alert('Error uploading image!');
                    }
                });
            });

        });
    </script>
</body>
</html>

=======

<!-- Start Container Wrapper -->
<div id="container-wrapper">
    <!-- Sidebar Navigation -->
    <?php include('sidebar.php'); ?> <!-- Include sidebar file here -->

    <!-- Dashboard Main Content -->
    <div id="dashboard">
        <!-- Responsive Navigation Trigger -->
        <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>  

        <!-- Sticky Navigation and Profile -->
        <div class="dashboard-sticky-nav header_black">
            <div class="content-left pull-left">
                <a href="dashboard.html"><img src="../images/logo-black.png" alt="logo"></a>
            </div>
            <div class="content-right pull-right">
                <button onclick="window.location.href='/yaarana/index.php'" class="btn"><i class="fa fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="row">
                <!-- Add New Deal Form -->
                <section class="top-deals">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2 class="mar-0">Add a New <span>Deal</span></h2>
                        </div>

                        <!-- Add Deal Form -->
                        <form action="welcome.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Deal Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="form-group">
                                <label for="subtitle">Deal Subtitle</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle" required>
                            </div>

                            <div class="form-group">
                                <label for="image">Deal Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary" name="add_deal">Add Deal</button>
                        </form>
                    </div>
                </section>

                <!-- Display Deals in a Table -->
                <section class="deal-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2 class="mar-0">Manage <span>Deals</span></h2>
                        </div>

                        <!-- Show Success Message if Deal was Added or Deleted -->
                        <?php if (isset($_SESSION['add_message'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                    echo $_SESSION['add_message']; 
                                    unset($_SESSION['add_message']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION['delete_message'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                    echo $_SESSION['delete_message']; 
                                    unset($_SESSION['delete_message']);
                                ?>
                            </div>
                        <?php endif; ?>

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
                                        echo "<td><a href='welcome.php?delete_id=" . $deal['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this deal?\")'>Delete</a></td>";
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar Toggle Button
    document.querySelector('.dashboard-responsive-nav-trigger').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });
</script>
</body>
</html>
>>>>>>> c3e58290e2c4b1c6954f79584ed226bd8ebc4eed
<?php } ?>
