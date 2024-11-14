<?php
session_start();
include_once('cms/include/config.php');

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Query to fetch the blog details based on the ID
    $sql_blog_details = "SELECT * FROM blogs WHERE id = $blog_id";
    $result_blog_details = mysqli_query($con, $sql_blog_details);

    if (mysqli_num_rows($result_blog_details) > 0) {
        $blog = mysqli_fetch_assoc($result_blog_details);
    } else {
        // Redirect to blog listing page if the blog is not found
        header("Location: blogs.php");
        exit();
    }
} else {
    // Redirect to blog listing page if no valid ID is provided
    header("Location: blogs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($blog['title']); ?> - Blog Details</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <style>
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

        .blog-detail-section {
            padding: 50px 0;
        }

        .blog-detail-card {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .blog-detail-card h1 {
            color: #333;
        }

        .blog-detail-card p {
            color: #777;
            font-size: 16px;
            line-height: 1.8;
        }

        .blog-detail-card img {
            max-height: 500px;
            width: 100%;
            object-fit: cover;
            margin-bottom: 30px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #333;
        }

        .section-title span {
            color: #007bff;
        }
    </style>
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Preloader Ends -->

    <!-- Breadcrumb Section -->
    <section class="breadcrumb-outer text-center">
        <div class="container">
            <h2 class="white">Yaarana Blog Details</h2>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="blogs.php">Blogs</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($blog['title']); ?></li>
                </ul>
            </nav>
        </div>
        <div class="overlay"></div>
    </section>

    <!-- Blog Detail Section -->
    <section class="blog-detail-section">
        <div class="container">
            <div class="blog-detail-card">
                <!-- Display blog image if exists -->
                <?php if (!empty($blog['image_url'])): ?>
                    <img src="cms/<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image">
                <?php endif; ?>

                <!-- Blog title -->
                <h1><?php echo htmlspecialchars($blog['title']); ?></h1>

                <!-- Blog content -->
                <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>

                <!-- Blog date -->
                <p><small><em>Posted on: <?php echo date('d-m-Y', strtotime($blog['created_at'])); ?></em></small></p>

                <!-- Optionally add a back button -->
                <a href="blogs.php" class="btn btn-secondary mt-3">Back to Blogs</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4">
        <div class="container">
            <p>2024 Yaarana. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
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
                }, 1000); // Hides after 1 second (adjust as needed)
            }
        }

        window.onload = function() {
            checkPreloader(); // Ensure preloader hides even if load takes longer
        }
    </script>

</body>

</html>
