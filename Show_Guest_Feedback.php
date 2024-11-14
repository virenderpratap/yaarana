<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Reviews - Nepayatri</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Default CSS -->
    <link href="css/default.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Color Switcher CSS -->
    <link rel="stylesheet" href="css/color/color-default.css">
    <!-- Plugin CSS -->
    <link href="css/plugin.css" rel="stylesheet">
    <!-- Flaticons CSS -->
    <link href="fonts/flaticon.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <style>
        .reviews-section {
            padding: 50px 0;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #333;
        }

        .section-title span {
            color: #007bff;
        }

        /* Fixed tile size for standard layout */
        .review-card {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            width: 100%; /* or set a specific pixel value */
            height: 400px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .review-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .review-date {
            font-size: 0.9rem;
            color: #999;
            margin-bottom: 15px;
        }

        .review-content {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
        }

        .video-section video {
            width: 100%;
            max-height: 200px;
            border-radius: 5px;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 20px;
            padding: 8px 20px;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

<!-- Preloader -->
<!-- Breadcrumb -->
<section class="breadcrumb-outer text-center">
    <div class="container">
        <div class="breadcrumb-content">
            <h2 class="white">Customer Reviews</h2>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customer Reviews</li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="overlay"></div>
</section>
<!-- Breadcrumb Ends -->

<?php
// Include database configuration file
include_once('cms/include/config.php');

// Query to fetch customer reviews from the database
$sql_reviews = "SELECT * FROM feedback ORDER BY date DESC";
$result_reviews = mysqli_query($con, $sql_reviews);

// Define truncateText function
function truncateText($text, $length = 120) {
    return (strlen($text) > $length) ? substr($text, 0, $length) . '...' : $text;
}
?>

<!-- Reviews Section -->
<section class="reviews-section text-center">
    <div class="container">
        <div class="section-title">
            <h2>Customer <span>Reviews</span></h2>
            <p>See what our customers have to say about their experiences with Nepayatri.</p>
        </div>

        <div class="row">
            <?php
            if (mysqli_num_rows($result_reviews) > 0) {
                while ($review = mysqli_fetch_assoc($result_reviews)) {
                    echo '<div class="col-md-4">
                            <div class="review-card">' ;

                    echo '
                        <h3 class="review-title">' . htmlspecialchars($review['title']) . '</h3>
                        <p class="review-date"><i class="far fa-calendar-alt"></i> ' . date("F j, Y", strtotime($review['date'])) . '</p>
                        <p id="truncated-' . $review['id'] . '" class="review-content">' .
                            truncateText(htmlspecialchars($review['content'])) .
                        '</p>
                        <p id="content-' . $review['id'] . '" class="review-content" style="display: none;">' .
                            htmlspecialchars($review['content']);

                    $feedback_id = $review['id'];
                    $sql_videos = "SELECT video_path FROM feedback_videos WHERE feedback_id = $feedback_id";
                    $result_videos = mysqli_query($con, $sql_videos);

                    if (mysqli_num_rows($result_videos) > 0) {
                        echo "<div class='video-section'>";
                        while ($video = mysqli_fetch_assoc($result_videos)) {
                            echo "<video src='cms/" . htmlspecialchars($video['video_path']) . "' autoplay loop muted></video>";
                        }
                        echo "</div>";
                    }

                    echo '</div></div>';
                }
            } else {
                echo '<p>No reviews available at the moment.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container ftr">
        <p>2024 Nepayatri. All rights reserved.</p>
    </div>
</footer>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Script for Show/Hide Content -->
<script>
    function toggleContent(reviewId) {
        const content = document.getElementById('content-' + reviewId);
        const truncatedContent = document.getElementById('truncated-' + reviewId);

        if (content.style.display === "none") {
            content.style.display = "block";
            truncatedContent.style.display = "none";
        } else {
            content.style.display = "none";
            truncatedContent.style.display = "block";
        }
    }
</script>

</body>
</html>
