<?php
session_start();
include('cms/include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Fetch all team members
    $sql_members = "SELECT * FROM members";
    $result_members = mysqli_query($con, $sql_members);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Our Team</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Default CSS -->
    <link href="css/default.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!-- Color Switcher CSS -->
    <link rel="stylesheet" href="css/color/color-default.css">
    <!-- Plugin CSS -->
    <link href="css/plugin.css" rel="stylesheet" type="text/css">
    <!-- Flaticons CSS -->
    <link href="fonts/flaticon.css" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        /* Preloader Styling */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #status {
            width: 50px;
            height: 50px;
            border: 5px solid #fff;
            border-radius: 50%;
            border-top: 5px solid transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .team-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        .event-card {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-10px);
        }

        .event-card img {
            border-radius: 10px;
            max-height: 450px;
            min-height: 450px;
            object-fit: cover;
            width: 100%;
            margin-bottom: 15px;
            
        }

        .event-title {
            font-size: 1.25rem;
            color: black;
            margin-bottom: 15px;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 20px;
            padding: 8px 20px;
            font-size: 1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .breadcrumb-outer {
            background-color: #007bff;
            color: #fff;
            padding: 50px 0;
        }

        .breadcrumb-outer h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .breadcrumb-item a {
            color: #fff;
        }

        .breadcrumb-item.active {
            color: #f8f9fa;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
    </style>

</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div id="status"></div>
    </div>

    <!-- Breadcrumb -->
    <section class="breadcrumb-outer text-center">
        <div class="container">
            <div class="breadcrumb-content">
                <h2 class="white">Yaarana Members</h2>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Team</li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="overlay"></div>
    </section>
    <!-- BreadCrumb Ends -->

    <!-- Team Section -->
    <section class="team-section text-center">
        <div class="container">
            <div class="section-title">
                <h2>Meet <span>Our Team</span></h2>
                <p>Discover the people behind our success.</p>
            </div>

            <div class="row">
                <?php
                // Check if there are members available
                if (mysqli_num_rows($result_members) > 0) {
                    // Loop through each member and display it in a card
                    while ($member = mysqli_fetch_assoc($result_members)) {
                        // Start the member card
                        echo '<div class="col-md-4">
                                <div class="event-card">';

                        // Member image
                        $imagePath = !empty($member['image_path']) ? 'cms/' . htmlspecialchars($member['image_path']) : 'cms/uploads/default-image.jpg';
                        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($member['name']) . '" class="d-block w-100">';

                        // Member name
                        echo '<h3 class="event-title">' . htmlspecialchars($member['name']) . '</h3>';

                      
                        // Close event card
                        echo '</div>
                            </div>';
                    }
                } else {
                    echo '<p>No team members available at the moment.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>2024 Nepayatri. All rights reserved.</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script to Hide Preloader -->
    <script>
        let domContentLoaded = false;

        document.addEventListener("DOMContentLoaded", function() {
            domContentLoaded = true;
            checkPreloader();
        });

        // Function to hide preloader after the content is loaded
        function checkPreloader() {
            if (domContentLoaded) {
                setTimeout(function() {
                    document.getElementById('preloader').style.display = 'none';
                }, 1200); // Hides after 3 seconds (adjust as needed)
            }
        }

        window.onload = function() {
            checkPreloader(); // Ensure preloader hides even if load takes longer
        }
    </script>

</body>

</html>
