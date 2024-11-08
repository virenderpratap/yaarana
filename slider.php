<?php include ('cms/include/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sliderr {
            position: relative;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
            height: 212px;
        }
        .slides {
            display: flex;
            transition: transform 1s ease-in-out;
            width: 100%;
        }
        .slide {
            min-width: 100%;
            transition: opacity 1s ease;
        }
        button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .prev {
            left: -1px;
            top: -104px;
        }
        .next {
            top: -104px;
            right: -407px;
        }
    </style>
</head>
<body>
    <div class="sliderr">
        <div class="slides">
            <?php
            // Retrieve banners from the database
            $sql_banners = "SELECT * FROM banners";
            $result_banners = mysqli_query($con, $sql_banners);

            if (mysqli_num_rows($result_banners) > 0) {
                // Loop through each banner and create an image slide
                while ($banner = mysqli_fetch_assoc($result_banners)) {
                    $imagePath = 'cms/' . htmlspecialchars($banner['image_path']);
                    echo '<div class="slide"><img src="' . $imagePath . '" alt="Banner Image" style="width: 100%; height: 100%;"></div>';
                }
            } else {
                echo '<p>No banners available.</p>';
            }
            ?>
        </div>
        <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next" onclick="changeSlide(1)">&#10095;</button>
    </div>

    <script>
        let currentIndex = 0;
        const slides = document.querySelector('.slides');
        const slideCount = document.querySelectorAll('.slide').length;

        function showSlide(index) {
            if (index >= slideCount) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = slideCount - 1;
            } else {
                currentIndex = index;
            }

            // Apply transform for sliding effect
            slides.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';
        }

        function changeSlide(direction) {
            showSlide(currentIndex + direction);
        }

        function autoSlide() {
            showSlide(currentIndex + 1);
        }

        setInterval(autoSlide, 3000); // Change slide every 3 seconds
        showSlide(currentIndex);
    </script>
</body>
</html>
