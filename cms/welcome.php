<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // Set the timezone
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
        $sql = "INSERT INTO holiday_packages (title, subtitle, image_path) VALUES ('$title', '$subtitle', '$imagePath')";
        if (mysqli_query($con, $sql)) {
            // Deal added successfully, redirect to prevent resubmission
            $_SESSION['add_message'] = "Deal added successfully!";
            header('Location: welcome.php'); // Redirect to prevent form resubmission
            exit; // Don't let the script continue after the redirect
        } else {
            echo "<script>alert('Error adding deal: " . mysqli_error($con) . "');</script>";
        }
    }

    // Delete a deal
    if (isset($_GET['delete_id'])) {
        $deal_id = $_GET['delete_id'];

        // Delete the deal from the database
        $sql_delete = "DELETE FROM top_deals WHERE id = $deal_id";
        if (mysqli_query($con, $sql_delete)) {
            // Set a session variable to display the success message
            $_SESSION['delete_message'] = "Deal deleted successfully!";
            // Redirect to the same page to prevent resubmitting the form on refresh
            header('Location: welcome.php');
            exit;
        } else {
            echo "<script>alert('Error deleting deal: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - Manage Deals</title>
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
                <li><a href="welcome.php"><i class="sl sl-icon-home"></i> Add New Deals</a></li>
                <li><a href="/yaarana/cms/IndiaTour.php"><i class="sl sl-icon-book-open"></i>India Tour Packages</a></li>               
                <li><a href="HolidayTheam.php"><i class="sl sl-icon-book-open"></i> Holiday Themes</a></li>
                <li><a href="InternationalTour.php" class="active"><i class="sl sl-icon-globe"></i> International Tour </a></li>
            </ul>
        </div>
    </div>

    <!-- Dashboard Main Content -->
    <div id="dashboard">
        <!-- Responsive Navigation Trigger -->
        <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>  

        <!-- Sticky Navigation and Profile -->
        <div class="dashboard-sticky-nav">
            <div class="content-left pull-left">
                <a href="dashboard.html"><img src="../images/logo-black.png" alt="logo"></a>
            </div>
            <div class="content-right pull-right">
                <div class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="profile-sec">
                            <div><a href="javascript:void(0);" onclick="window.location.href='index.php';">
                            <a href="javascript:void(0);" onclick="logoutAndRedirect();">
                                <button type="button"><i class="fa fa-sign-out-alt"></i> Logout</button>
                            </a>

                            </a></div>
                        <div class="dash-content">
                    
                        </div>
                            <!-- <div class="dash-content">
                                <h4>Loural Teak</h4>
                                <span>Post Manager</span>
                            </div> -->
                            <!-- <div class="dash-image">
                                <img src="images/comment.jpg" alt="profile">
                            </div> -->
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="sl sl-icon-settings"></i> Settings</a></li>
                        <li><a href="#"><i class="sl sl-icon-user"></i> Profile</a></li>
                        <li><a href="#"><i class="sl sl-icon-lock"></i> Change Password</a></li>
                        <li><a href="#"><i class="sl sl-icon-power"></i> Logout</a></li>
                    </ul>
                </div>
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
                                    unset($_SESSION['add_message']); // Unset session variable after displaying the message
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION['delete_message'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                    echo $_SESSION['delete_message']; 
                                    unset($_SESSION['delete_message']); // Unset session variable after displaying the message
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
                // Fetch all deals from the database
                $sql_deals = "SELECT * FROM top_deals";
                $result_deals = mysqli_query($con, $sql_deals);
                 
                if (mysqli_num_rows($result_deals) > 0) {
                    while ($deal = mysqli_fetch_assoc($result_deals)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($deal['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($deal['subtitle']) . "</td>";
                        echo "<td><img src='" . $deal['image_path'] . "' alt='" . htmlspecialchars($deal['title']) . "'></td>";
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

</body>
</html>
<style>
      .table-custom {
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-custom thead {
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
        }

        .table-custom th, .table-custom td {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        

        .table-custom td img {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }

        /* Hover effect for rows */
        .table-custom tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Styling action buttons */
        .btn-danger {
            background-color: #ff5c5c;
            border-color: #ff5c5c;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .btn-danger:hover {
            background-color: #e04d4d;
            border-color: #e04d4d;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
            padding: 20px 0;
        }

        /* Table responsive for smaller screens */
        @media (max-width: 767px) {
            .table-custom {
                font-size: 14px;
            }

            .table-custom th, .table-custom td {
                padding: 8px;
            }
        }
        </style>
<script>
    function logoutAndRedirect() {
    // Log the user out (by calling a PHP logout page or using AJAX)
    window.location.href = '/yaarana/index.php'; // This will trigger the PHP logout process
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
}
?>
