<?php
// Database connection
include('cms/include/config.php');

// Query to fetch deals from the database
$sql = "SELECT * FROM top_deals";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Top Deals</title>
    <style>
        .slider-itemm:nth-of-type(1n) .dealx {
            background-color: lightgreen !important;
        }
        .slider-itemm:nth-of-type(2n) .dealx {
            background-color: lightpink !important;
        }
        .slider-itemm:nth-of-type(3n) .dealx {
            background-color: yellowgreen !important;
        }
        .slider-itemm:nth-of-type(4n) .dealx {
            background-color: peru !important;
        }
        .slider-itemm:nth-of-type(5n) .dealx {
            background-color: orchid !important;
        }
    </style>
</head>
<body>

<section class="top-deals">
    <div class="container">
        <div class="section-title title-full">
            <h2 class="mar-0">Today's <span>Top Deals</span></h2>
        </div>
        <div class="row top-deal-slider">
            <?php
            // Check if there are any deals in the database
            if (mysqli_num_rows($result) > 0) {
                // Loop through each deal from the database
                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch the values for title, subtitle, and image path
                    $title = $row['title'];
                    $subtitle = $row['subtitle'];
                    // Image path (make sure it's relative to the project root)
                    $image_path = 'cms/' . $row['image_path']; // Assuming 'image_path' stores the image filename or relative path
            ?>
            <div class="col-md-4 slider-itemm">
                <div class="dealx">
                    <div class="one">
                        <!-- Dynamically output the title and subtitle -->
                        <div class="tr-yaa"><?php echo htmlspecialchars($title); ?></div>
                        <div class="tr-yaa2"><?php echo htmlspecialchars($subtitle); ?></div>
                    </div>
                    <div class="two">
                        <div class="deal-img">
                            <!-- Dynamically output the image -->
                            <img src="<?php echo $image_path; ?>" alt="Deal Image">
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                // In case there are no deals in the database
                echo "<p>No deals available at the moment.</p>";
            }
            ?>
            
        </div>
    </div>
</section>

</body>
</html>
