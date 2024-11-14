<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Company Gallery</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <style>
        .gallery-section {
            padding: 50px 0;
        }

        .gallery-card {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .gallery-card h5 {
            color: #333;
            margin-bottom: 15px;
        }

        .carousel-inner {
            max-height: 400px;
            overflow: hidden;
        }

        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 300px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #333;
        }

        .section-title span {
            color: #007bff;
        }

        /* Preloader styling */
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
            <h2 class="white">Yaarana Gallery</h2>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ul>
            </nav>
        </div>
        <div class="overlay"></div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>Explore Our <span>Gallery</span></h2>
                <p>Check out some of the highlights from our company events and projects.</p>
            </div>

            <div class="row">
                <?php
                // Include database configuration
                include_once('cms/include/config.php');
                // Query to fetch gallery records
                $sql_gallery = "SELECT * FROM gallery1 ORDER BY created_at DESC";
                $result_gallery = mysqli_query($con, $sql_gallery);

                // Loop through the gallery records and display images
                if (mysqli_num_rows($result_gallery) > 0) {
                    while ($gallery = mysqli_fetch_assoc($result_gallery)) {
                        // Get the images for each gallery
                        $image_urls = explode(',', $gallery['image_urls']);
                        echo "<div class='col-md-4'>
                                <div class='gallery-card'>";

                        // Display carousel for each gallery
                        if (count($image_urls) > 1) {
                            echo "<div id='carousel-{$gallery['id']}' class='carousel slide' data-bs-ride='carousel'>
                                    <div class='carousel-inner'>";
                            $active = true;
                            foreach ($image_urls as $image_url) {
                                echo "<div class='carousel-item " . ($active ? 'active' : '') . "'>
                                        <img src='cms/$image_url' alt='Gallery Image'>
                                      </div>";
                                $active = false;
                            }
                            echo "</div>
                                  <button class='carousel-control-prev' type='button' data-bs-target='#carousel-{$gallery['id']}' data-bs-slide='prev'>
                                      <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                      <span class='visually-hidden'>Previous</span>
                                  </button>
                                  <button class='carousel-control-next' type='button' data-bs-target='#carousel-{$gallery['id']}' data-bs-slide='next'>
                                      <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                      <span class='visually-hidden'>Next</span>
                                  </button>
                              </div>";
                        } else {
                            // Display single image if only one is available
                            echo "<img src='cms/{$image_urls[0]}' alt='Gallery Image' class='d-block w-100'>";
                        }

                        // Gallery title (optional, add if needed)
                        echo "<h5>{$gallery['title']}</h5>";
                        echo "</div></div>";
                    }
                } else {
                    echo "<p>No galleries available.</p>";
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

    <!-- Preloader Script -->
    <script>
        let domContentLoaded = false;
        document.addEventListener("DOMContentLoaded", function() {
            domContentLoaded = true;
            checkPreloader();
        });

        function checkPreloader() {
            if (domContentLoaded) {
                setTimeout(function() {
                    document.getElementById('preloader').style.display = 'none';
                }, 1200); 
            }
        }

        window.onload = function() {
            checkPreloader();
        }
    </script>
</body>
</html>
