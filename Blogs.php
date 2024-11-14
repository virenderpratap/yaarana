<?php
session_start();
include_once('cms/include/config.php');

// Query to fetch blog records
$sql_blogs = "SELECT * FROM blogs ORDER BY created_at DESC";
$result_blogs = mysqli_query($con, $sql_blogs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Company Blogs</title>

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

        .blog-section {
            padding: 50px 0;
        }

        .blog-card {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .blog-card h5 {
            color: #333;
            margin-bottom: 15px;
        }

        .blog-card p {
            color: #777;
            font-size: 16px;
            line-height: 1.6;
        }

        .blog-card img {
            max-height: 300px;
            width: 100%;
            object-fit: cover;
            margin-bottom: 15px;
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
            <h2 class="white">Yaarana Blogs</h2>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                </ul>
            </nav>
        </div>
        <div class="overlay"></div>
    </section>

    <!-- Blog Section -->
    <section class="blog-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>Explore Our <span>Blogs</span></h2>
                <p>Read the latest insights and updates from our team.</p>
            </div>

            <div class="row">
                <?php
                // Loop through the blog records and display them
                if (mysqli_num_rows($result_blogs) > 0) {
                    while ($blog = mysqli_fetch_assoc($result_blogs)) {
                        echo "<div class='col-md-4'>
                                <div class='blog-card'>";

                        // Display blog image if exists
                        if (!empty($blog['image_url'])) {
                            echo "<img src='cms/{$blog['image_url']}' alt='Blog Image'>";
                        }

                        // Blog title and content
                        echo "<h5>" . htmlspecialchars($blog['title']) . "</h5>";
                        echo "<p>" . nl2br(htmlspecialchars(substr($blog['content'],0,103))) . "</p>";

                        // Blog date (optional)
                        echo "<p><small><em>Posted on: " . date('d-m-Y', strtotime($blog['created_at'])) . "</em></small></p>";
                        echo "<a href='Blog_Details.php?id=" . $blog['id'] . "' class='btn btn-primary'>Read More</a>";

                        echo "</div></div>";
                    }
                } else {
                    echo "<p>No blogs available.</p>";
                }
                ?>
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
                }, 1000); // Hides after 3 seconds (adjust as needed)
            }
        }

        window.onload = function() {
            checkPreloader(); // Ensure preloader hides even if load takes longer
        }
    </script>

</body>

</html>
