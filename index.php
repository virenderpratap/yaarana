<!DOCTYPE html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yaarana Holidays</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!--Default CSS-->
    <link href="css/default.css" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!--Color Switcher CSS-->
    <link rel="stylesheet" href="css/color/color-default.css">
    <!--Plugin CSS-->
    <link href="css/plugin.css" rel="stylesheet" type="text/css">
    <!--Flaticons CSS-->
    <link href="fonts/flaticon.css" rel="stylesheet" type="text/css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
</head>

<body>
    <?php include "head.php" ?>

    <!-- banner starts -->
    <section class="banner">
        <div class="slider slide-height">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-inner">
                            <div class="slide-image" style="background-image:url(images/christmas-offer.jpg)"></div>
                            <!-- <div class="swiper-content">
                                <h1>Make you Free to <span>travel</span> with us</h1>
                                <p class="mar-bottom-20">Foresee the pain and trouble that are bound to ensue and equal fail in their duty through weakness. </p>
                                <a href="" class="biz-btn">Explore More</a>
                                <a href="" class="biz-btn mar-left-10">Contact Us</a>
                            </div>  -->
                            <div class="overlay"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-inner">
                            <div class="slide-image" style="background-image:url(images/new-year-offer.jpg)"></div>

                            <div class="overlay"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-inner">
                            <div class="slide-image" style="background-image:url(images/ban2.jpg)"></div>

                            <div class="overlay"></div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-inner">
                            <div class="slide-image" style="background-image:url(images/slider/slider3.jpg)"></div>

                            <div class="overlay"></div>
                        </div>
                    </div>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        </div>
    </section>
    <!-- banner ends -->

    <!-- form starts -->
    <?php include "index-form.php" ?>
    <!-- form ends -->

    <!-- top deal starts -->
    <?php include "deals.php" ?>
    <!-- top deal ends -->

    <!-- holiday Themes starts -->

    <section class="top-destinations top-desti1">
    <div class="container">
        <div class="section-title title-full">
            <h2 class="mar-0">Holiday <span>Themes Special</span></h2>
        </div>
        <div class="grid-container">
            <?php
            // Fetching packages from database
            $conn = new mysqli('localhost', 'root', '', 'yaarana2');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM holiday_packages ORDER BY created_at DESC LIMIT 6";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $class = ($i % 2 == 0) ? "package-small" : "package-large";
                    ?>
                    <div class="package-item <?php echo $class; ?>">
                        <div class="td-item box-shadow-0 border-0">
                            <div class="holiday-yaarana-theme">
                                <img src="cms/uploads/<?php echo basename($row['image']); ?>" alt="image">
                            </div>
                            <div class="td-content">
                                <div class="rating mar-bottom-15">
                                    <?php for ($j = 0; $j < 5; $j++) {
                                        echo '<span class="fa fa-star checked"></span>';
                                    } ?>
                                </div>
                                <h3><i class="fa fa-map-marker-alt"></i> <?php echo $row['package_name']; ?></h3>
                                <p><?php echo $row['description']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
            } else {
                echo "<p>No holiday packages available.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
<!-- holiday Themes ends -->





    
    <!-- banner starts -->
    <section class="search-banner display-flex">
        <div class="slider video-slider">
            <div class="banner-outer">
                <div class="video-banner">
                    <video autoplay muted loop id="vid">
                        <source src="images/tour.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="overlay"></div>
        </div>

        <div class="container">
            <div class="search-content">
                <div class="row display-flex">
                    <div class="col-md-12">
                        <div class="ef-item">

                            <div class="content">

                                <h2 class="mar-0 white text-center cus">Yaarana <span>Holidays</span></h2>
                                <h2 class="white text-center pad-top-0">You Plan , We Pack!</h2>
                                <p class="white text-center">There are many variation of passages of lorem ipsum is simply free text is now available for web but the majority have suffer.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner ends -->
    <!-- india packages starts -->
    <section class="top-destinations top-desti2">
        <div class="container">
            <div class="section-title">
                <h2>India <span> Tour Packages</span></h2>
                <p>Dive into the spiritual heart of India, visiting sacred sites and experiencing traditional rituals.</p>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/himachal.jpg" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Himachal</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/package2.jpg" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Spiti</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/uttarakhand.jpg" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Uttarakhand</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/kerala.jpg" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Kerala</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/nainital.jpg" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Kashmir</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/rajasthan.jpg" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Rajasthan</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/goa.jpg" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Goa</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">
                        <div class="td-item td-item">
                            <div class="td-image">
                                <img src="images/package/meghalaya.png" alt="image">
                            </div>
                            <p class="price white">trending</span></p>
                            <div class="td-content">
                                <h3><i class="fa fa-map-marker-alt"></i>Meghalaya</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- india packages ends -->
    <!-- Trending Starts -->
    <section class="trending pad-bottom-50 bg-grey">
        <div class="container">
            <div class="section-title title-full">
                <h2 class="mar-0">Perfect <span>Holiday</span> Plan</h2>
            </div>
            <div class="trend-box">
                <div class="row ticket-slider">
                    <div class="col-md-4 mar-bottom-30">
                        <div class="trend-item">
                            <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                            <div class="trend-image">
                                <img src="images/package/package2.jpg" alt="image">
                                <div class="trend-tags">
                                    <a href="#"><i class="flaticon-like"></i></a>
                                </div>
                                <div class="trend-price">
                                    <p class="price">From <span>₹15000/-</span></p>
                                </div>
                            </div>
                            <div class="trend-content">
                                <div class="sect">
                                    <p class="ryt1"><i class="flaticon-location-pin"></i> Spiti</p>
                                    <p class="mar-0 ryt1"><i class="fa fa-clock-o" aria-hidden="true"></i> 5 Nights 6 Days</p>
                                </div>
                                <h4><a href="#">Spiti Valley Tour Package From Shimla</a></h4>
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <span class="mar-left-5">38 Reviews</span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mar-bottom-30">
                        <div class="trend-item">
                            <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                            <div class="trend-image">
                                <img src="images/package/nainital.jpg" alt="image">
                                <div class="trend-tags">
                                    <a href="#"><i class="flaticon-like"></i></a>
                                </div>
                                <div class="trend-price">
                                    <p class="price">From <span>₹18990/-</span></p>
                                </div>
                            </div>
                            <div class="trend-content">
                                <div class="sect">
                                    <p class="ryt1"><i class="flaticon-location-pin"></i> Uttarakhand</p>
                                    <p class="mar-0 ryt1"><i class="fa fa-clock-o" aria-hidden="true"></i> 4 Nights 5 Days</p>
                                </div>
                                <h4><a href="#">Nainital with Mussoorie Tour Package</a></h4>
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-half checked"></span>
                                    <span class="fa fa-star-half checked"></span>
                                </div>
                                <span class="mar-left-5">48 Reviews</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mar-bottom-30">
                        <div class="trend-item">
                            <div class="ribbon ribbon-top-left"><span>Featured</span></div>
                            <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                            <div class="trend-image">
                                <img src="images/package/golden.jpg" alt="image">
                                <div class="trend-tags">
                                    <a href="#"><i class="flaticon-like"></i></a>
                                </div>
                                <div class="trend-price">
                                    <p class="price">From <span>₹19999/-</span></p>
                                </div>
                            </div>
                            <div class="trend-content">
                                <div class="sect">
                                    <p class="ryt1"><i class="flaticon-location-pin"></i> Himachal</p>
                                    <p class="mar-0 ryt1"><i class="fa fa-clock-o" aria-hidden="true"></i> 9 Nights 10 Days</p>
                                </div>
                                <h4><a href="#">Complete Himachal With Golden Temple</a></h4>
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <span class="mar-left-5">32 Reviews</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mar-bottom-30">
                        <div class="trend-item">
                            <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                            <div class="trend-image">
                                <img src="images/package/package2.jpg" alt="image">
                                <div class="trend-tags">
                                    <a href="#"><i class="flaticon-like"></i></a>
                                </div>
                                <div class="trend-price">
                                    <p class="price">From <span>₹15000/-</span></p>
                                </div>
                            </div>
                            <div class="trend-content">
                                <div class="sect">
                                    <p class="ryt1"><i class="flaticon-location-pin"></i> Spiti</p>
                                    <p class="mar-0 ryt1"><i class="fa fa-clock-o" aria-hidden="true"></i> 5 Nights 6 Days</p>
                                </div>
                                <h4><a href="#">Spiti Valley Tour Package From Shimla</a></h4>
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <span class="mar-left-5">38 Reviews</span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mar-bottom-30">
                        <div class="trend-item">
                            <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                            <div class="trend-image">
                                <img src="images/package/nainital.jpg" alt="image">
                                <div class="trend-tags">
                                    <a href="#"><i class="flaticon-like"></i></a>
                                </div>
                                <div class="trend-price">
                                    <p class="price">From <span>₹18990/-</span></p>
                                </div>
                            </div>
                            <div class="trend-content">
                                <div class="sect">
                                    <p class="ryt1"><i class="flaticon-location-pin"></i> Uttarakhand</p>
                                    <p class="mar-0 ryt1"><i class="fa fa-clock-o" aria-hidden="true"></i> 4 Nights 5 Days</p>
                                </div>
                                <h4><a href="#">Nainital with Mussoorie Tour Package</a></h4>
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-half checked"></span>
                                    <span class="fa fa-star-half checked"></span>
                                </div>
                                <span class="mar-left-5">48 Reviews</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mar-bottom-30">
                        <div class="trend-item">
                            <div class="ribbon ribbon-top-left"><span>Featured</span></div>
                            <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                            <div class="trend-image">
                                <img src="images/package/golden.jpg" alt="image">
                                <div class="trend-tags">
                                    <a href="#"><i class="flaticon-like"></i></a>
                                </div>
                                <div class="trend-price">
                                    <p class="price">From <span>₹19999/-</span></p>
                                </div>
                            </div>
                            <div class="trend-content">
                                <div class="sect">
                                    <p class="ryt1"><i class="flaticon-location-pin"></i> Himachal</p>
                                    <p class="mar-0 ryt1"><i class="fa fa-clock-o" aria-hidden="true"></i> 9 Nights 10 Days</p>
                                </div>
                                <h4><a href="#">Complete Himachal With Golden Temple</a></h4>
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <span class="mar-left-5">32 Reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Trending Ends -->

    
    <?php
// Fetch packages for the "International Tour Packages" section
$sql_international_packages = "SELECT * FROM international_tours";
$result_international_packages = mysqli_query($con, $sql_international_packages);
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>International Tour Packages</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>

<!-- International Packages Section -->
<section class="top-destinations top-desti2">
    <div class="container">
        <div class="section-title">
            <h2>International <span>Tour Packages</span></h2>
            <p>Dive into the spiritual heart of the world, visiting breathtaking destinations and experiencing vibrant cultures.</p>
        </div>
        <div class="content">
            <div class="row">
                <?php
                // Loop through each international package and display it
                if (mysqli_num_rows($result_international_packages) > 0) {
                    while ($package = mysqli_fetch_assoc($result_international_packages)) {
                        echo '<div class="col-md-3 col-sm-6 col-xs-12 mar-bottom-30">';
                        echo '    <div class="td-item">';
                        echo '        <div class="td-image">';
                        echo '            <img src="cms/uploads/' . basename(htmlspecialchars($package['image_url'])) . '" alt="image">';
                        echo '        </div>';
                        echo '        <p class="price white">trending</p>';
                        echo '        <div class="td-content">';
                        echo '            <h3><i class="fa fa-map-marker-alt"></i>' . htmlspecialchars($package['title']) . '</h3>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No international packages available at the moment.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- International Packages Ends -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


    
    <!-- top destination starts -->
    <section class="top-destinations top-desti1">
        <div class="container">
            <div class="section-title title-full">
                <h2 class="mar-0">Best Selling International <span> Packages</span></h2>
            </div>
            <div class="content">
                <div class="row review-slider">
                    <div class="col-md-6">
                        <div class="td-item box-shadow-0 border-0">
                            <div class="td-image inter">
                                <img src="images/package/singapore-and-bali-honeymoon.avif" alt="image">
                            </div>
                            <div class="td-content">
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <h3><i class="fa fa-map-marker-alt"></i> Singapore and Bali Honeymoon Bliss</h3>
                                <a href="#" class="biz-btn">Book Now</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="td-item box-shadow-0 border-0">
                            <div class="td-image inter">
                                <img src="images/package/Escape-to-Dubai.jpg" alt="image">
                            </div>
                            <div class="td-content">
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <h3><i class="fa fa-map-marker-alt"></i> Escape to Dubai | Flights Inclusive Deal</h3>
                                <a href="#" class="biz-btn">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="td-item box-shadow-0 border-0">
                            <div class="td-image inter">
                                <img src="images/package/singapore-and-bali-honeymoon.avif" alt="image">
                            </div>
                            <div class="td-content">
                                <div class="rating mar-bottom-15">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <h3><i class="fa fa-map-marker-alt"></i> Singapore and Bali Honeymoon Bliss</h3>
                                <a href="#" class="biz-btn">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- top destination ends -->
    <!-- short section  -->
    <section class="b2cpanel">
        <div class="_innerWrap">
            <div class="_tvl_guid">
                <div class="w100 cstwid bg3">
                    <div class="_ico"><img src="https://www.easemytrip.com/images/desk-img/full-ref-lft.png" alt="Full Refund"></div>
                    <div class="new50">
                        <div><span class="_t1m"><!--Full Refund--> Full Refund<sup>*</sup></span> <span class="_t1s"><!--Due to Medical Reasons :-->Due to Medical Reasons<span></span></span></div>
                        <div class="_t2">
                            <ul>
                                <li><!--Presenting you an extraordinary offer in these unfavorable circumstances.-->
                                    Presenting you an extraordinary offer in these unfavorable circumstances..
                                </li>
                                <li><!--Get a full refund on a domestic ticket in case you cancel it due to medical sickness.-->
                                    Get a full refund on a domestic ticket in case you cancel it due to medical sickness..
                                </li>
                                <li><!--The Best Part - There are ZERO extra charges for this service.-->
                                    The Best Part - There are ZERO extra charges for this service.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="_iconvr2"><img src="./images/refund1.png" alt="Medical Refund"></div>
                </div>
                <a href="" target="_new" class="cstwid2 bgref" style="text-decoration:none">
                    <div class="new50">
                        <p class="fct14"><!--Claim For-->Claim for</p>
                        <p class="fct28"><!--COVID-->Medical<br><!--Refund-->Refund</p>
                        <p class="fct14"><!--here-->here </p>
                    </div>
                    <div class="iconcf2"><img src="./images/refund.png" alt="Covid Refund"></div>
                </a>
            </div>

        </div>
    </section>
    <!-- short section  -->

    <!-- why us starts -->
    <section class="why-us">
        <div class="container">
            <div class="why-us-box">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="why-us-item why-us-item1 text-center">
                            <div class="why-us-icon">
                                <i class="flaticon-call"></i>
                            </div>
                            <div class="why-us-content">
                                <h4>Advice & Support</h4>
                                <p class="mar-0">Travel worry free knowing that we're here if you need us, 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="why-us-item why-us-item1 text-center">
                            <div class="why-us-icon">
                                <i class="flaticon-global"></i>
                            </div>
                            <div class="why-us-content">
                                <h4>Air Ticketing</h4>
                                <p class="mar-0">Travel worry free knowing that we're here if you need us, 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="why-us-item why-us-item1 text-center">
                            <div class="why-us-icon">
                                <i class="flaticon-building"></i>
                            </div>
                            <div class="why-us-content">
                                <h4>Hotel Accomodation</h4>
                                <p class="mar-0">Travel worry free knowing that we're here if you need us, 24 hours a day</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="why-us-item why-us-item1 text-center">
                            <div class="why-us-icon">
                                <i class="flaticon-location-pin"></i>
                            </div>
                            <div class="why-us-content">
                                <h4>Tour Peckages</h4>
                                <p class="mar-0">Travel worry free knowing that we're here if you need us, 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- why us ends -->
    <!-- tour agents starts -->
    <section class="tour-agent tour-agent1">
        <div class="container">
            <div class="row display-flex">
                <div class="col-md-4 col-xs-12">
                    <div class="section-title title-full width100">
                        <h2 class="white">Yaarana Holidays & Team</h2>
                        <p class="white mar-0">Travel experts at your service, crafting experiences that make every trip extraordinary and memorable.</p>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="agent-main">
                        <div class="row team-slider">
                            <div class="col-md-4">
                                <div class="agent-list">
                                    <div class="agent-image">
                                        <img src="images/team/boss.JPG" alt="agent">
                                        <div class="agent-content">
                                            <h3 class="white mar-bottom-5">Raj Nagvanshi</h3>
                                            <p class="white mar-0">Founder & CEO</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="agent-list">
                                    <div class="agent-image">
                                        <img src="images/team/hr.jpg" alt="agent">
                                        <div class="agent-content">
                                            <h3 class="white mar-bottom-5">Salmon Thuir</h3>
                                            <p class="white mar-0">HR Manager</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="agent-list">
                                    <div class="agent-image">
                                        <img src="images/team.JPG" alt="agent">
                                        <div class="agent-content">
                                            <h3 class="white mar-bottom-5">Salmon Thuir</h3>
                                            <p class="white mar-0">HR Manager</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- tour agents Ends -->



    <!-- cta_one starts -->
    <section class="cta-one">
        <div class="container">
            <div class="cta-one_block display-flex space-between">
                <h2 class="white mar-bottom-0">Work with our amazing tour guides</h2>
                <a href="contact.html" class="biz-btn-white">Join our team</a>
            </div>
        </div>
    </section>
    <!-- cta_one ends -->

    <!-- top deal starts -->
    <section class="top-deals">
        <div class="container">
            <div class="section-title">
                <h2>Today's Top Deals</h2>
                <p>Lorem Ipsum is simply dummy text the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="row top-deal-slider">
                <div class="col-md-4 slider-item">
                    <div class="slider-image">
                        <img src="images/trending7.jpg" alt="image">
                    </div>
                    <div class="slider-content">
                        <h6 class="mar-bottom-10"><i class="fa fa-map-marker-alt"></i> United Kingdom</h6>
                        <h4><a href="#">Earning Asiana Club Miles</a></h4>
                        <p>With upto 30% Off, experience Europe your way!</p>
                        <div class="deal-price">
                            <p class="price">From <span>$250.00</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 slider-item">
                    <div class="slider-image">
                        <img src="images/trending8.jpg" alt="image">
                    </div>
                    <div class="slider-content">
                        <h6 class="mar-bottom-10"><i class="fa fa-map-marker-alt"></i> Thailand</h6>
                        <h4><a href="#">Save big on hotels!</a></h4>
                        <p>With upto 30% Off, experience Europe your way!</p>
                        <div class="deal-price">
                            <p class="price">From <span>$250.00</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 slider-item">
                    <div class="slider-image">
                        <img src="images/trending9.jpg" alt="image">
                    </div>
                    <div class="slider-content">
                        <h6 class="mar-bottom-10"><i class="fa fa-map-marker-alt"></i> South Korea</h6>
                        <h4><a href="#">Experience Europe Your Way</a></h4>
                        <p>With upto 30% Off, experience Europe your way!</p>
                        <div class="deal-price">
                            <p class="price">From <span>$250.00</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 slider-item">
                    <div class="slider-image">
                        <img src="images/trending10.jpg" alt="image">
                    </div>
                    <div class="slider-content">
                        <h6 class="mar-bottom-10"><i class="fa fa-map-marker-alt"></i> Germany</h6>
                        <h4><a href="#">Earning Asiana Club Miles</a></h4>
                        <p>With upto 30% Off, experience Europe your way!</p>
                        <div class="deal-price">
                            <p class="price">From <span>$250.00</span></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- top deal ends -->
    <!-- partners starts -->
    <section class="partners bg-grey">
        <div class="container">
            <div class="section-title">
                <h2>Our Awesome Parnters</h2>
                <p>Lorem Ipsum is simply dummy text the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="dest-partner">
                <div class="row partner-slider">
                    <div class="col-md-2">
                        <img src="images/cl-3.png" alt="partners">
                    </div>
                    <div class="col-md-2">
                        <img src="images/cl-3.png" alt="partners">
                    </div>
                    <div class="col-md-2">
                        <img src="images/cl-3.png" alt="partners">
                    </div>
                    <div class="col-md-2">
                        <img src="images/cl-3.png" alt="partners">
                    </div>
                    <div class="col-md-2">
                        <img src="images/cl-3.png" alt="partners">
                    </div>
                    <div class="col-md-2">
                        <img src="images/cl-3.png" alt="partners">
                    </div>
                    <div class="col-md-2">
                        <img src="images/cl-3.png" alt="partners">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- partners ends -->
    <!-- Top Featured -->
    <section class="travelcounter">
        <div class="container">
            <div class="section-title">
                <h2 class="white">call our agents to book</h2>
                <p class="white">Travel award winning and top rated tour operator</p>
            </div>
            <div class="row service-gg">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fas fa-hiking" aria-hidden="true"></i>
                        </div>
                        <div class="counter-content">
                            <h3 class="boats">80</h3>
                            <p class="mar-0">Pro Tour Guides</p>
                        </div>
                    </div>

                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fa fa-map-marker-alt" aria-hidden="true"></i>
                        </div>
                        <div class="counter-content">
                            <h3 class="location">19</h3>
                            <p class="mar-0">Tours are Completed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fa fa-walking" aria-hidden="true"></i>
                        </div>
                        <div class="counter-content">
                            <h3 class="showroom">10</h3>
                            <p class="mar-0">Traveling Experience</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <div class="counter-content">
                            <h3 class="lisence">100</h3>
                            <p class="mar-0">Happy Customers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Top Featured -->





    <?php include "footer.php" ?>


    <!-- search popup -->
    <div id="search1">
        <button type="button" class="close">×</button>
        <form>
            <input type="search" value="" placeholder="type keyword(s) here" />
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="modal fade" id="login" role="dialog">
        <div class="modal-dialog">
            <div class="login-content">
                <div class="login-title section-border">
                    <h3>Login</h3>
                </div>
                <div class="login-form section-border">
                    <form>
                        <div class="form-group">
                            <input type="email" placeholder="Enter email address">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Enter password">
                        </div>
                    </form>
                    <div class="form-btn">
                        <a href="#" class="biz-btn biz-btn1">LOGIN</a>
                    </div>
                    <div class="form-group form-checkbox">
                        <input type="checkbox"> Remember Me
                        <a href="#">Forgot password?</a>
                    </div>
                </div>
                <div class="login-social section-border">
                    <p>or continue with</p>
                    <a href="#" class="btn-facebook"><i class="fab fa-facebook" aria-hidden="true"></i> Facebook</a>
                    <a href="#" class="btn-twitter"><i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a>
                </div>
                <div class="sign-up">
                    <p>Do not have an account?<a href="#">Sign Up</a></p>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    </div>

    <div class="modal fade formcontainer" id="register" role="dialog">
        <div class="modal-dialog">
            <div class="row">
                <div class="col-md-6 pad-0 bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <?php include "slider.php" ?>
                        </div>
                        <div class="col-md-4 set-ico">
                            <div class="form-ico">
                                <div class="form-in-ico">
                                    <img src="./images/icon1.gif" alt="">
                                </div>
                                <h5 class="set-icohf">10000+</h5>
                                <p class="set-icop text-center">Verified Agent</p>
                            </div>
                        </div>
                        <div class="col-md-4 set-ico">
                            <div class="form-ico">
                                <div class="form-in-ico">
                                    <img src="./images/icon1.gif" alt="">
                                </div>
                                <h5 class="set-icohf">10000+</h5>
                                <p class="set-icop">Verified Agent</p>
                            </div>
                        </div>
                        <div class="col-md-4 set-ico">
                            <div class="form-ico">
                                <div class="form-in-ico">
                                    <img src="./images/icon1.gif" alt="">
                                </div>
                                <h5 class="set-icohf">10000+</h5>
                                <p class="set-icop">Verified Agent</p>
                            </div>
                        </div>
                        <div class="col-md-4 set-ico">
                            <div class="form-ico">
                                <div class="form-in-ico">
                                    <img src="./images/icon1.gif" alt="">
                                </div>
                                <h5 class="set-icohf">10000+</h5>
                                <p class="set-icop">Verified Agent</p>
                            </div>
                        </div>
                        <div class="col-md-4 set-ico">
                            <div class="form-ico">
                                <div class="form-in-ico">
                                    <img src="./images/icon1.gif" alt="">
                                </div>
                                <h5 class="set-icohf">10000+</h5>
                                <p class="set-icop">Verified Agent</p>
                            </div>
                        </div>
                        <div class="col-md-4 set-ico">
                            <div class="form-ico">
                                <div class="form-in-ico">
                                    <img src="./images/icon1.gif" alt="">
                                </div>
                                <h5 class="set-icohf">10000+</h5>
                                <p class="set-icop">Verified Agent</p>
                            </div>
                        </div>
                        <div class="col-md-3 set-ico">
                            <div class="form-ico">
                                <h5 class="text-center apr">Approved By</h5>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row pcsd">
                                <div class="col-md-4">
                                    <div class="approved-ico">
                                        <img src="./images/ministry.png" alt="">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="approved-ico">
                                        <img src="./images/iaai.png" alt="">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="approved-ico">
                                        <img src="./images/iata.jpg" alt="">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div>
                                <h5 class="text-center">DMC Specialist For Pan India</h5>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="cont-icos flo">
                                <a href="tel:123456789">Call Us : <i class="fa fa-phone"></i> 098169 45091</a>&nbsp;&nbsp;
                                <a href="tel:123456789"><i class="fa fa-phone"></i> 098169 45091</a>&nbsp;&nbsp;
                                <a href="tel:123456789"><i class="fa fa-phone"></i> 098169 45091</a>
                            </div>
                            <div class="cont-ico flo">
                                <a href="tel:123456789">Mail Us at: <i class="fa fa-envelope"></i> bookings@yaaranaholiday.com</a>&nbsp;&nbsp;
                            </div>
                            <div class="cont-ico flo">
                                <a>Location <i class="fa fa-map"></i> Yaarana Holiday Tours Pvt. Ltd, Corporate Office, near Tenzin Hospital, Kasumpti Colony, Panthaghati, Shimla, Himachal Pradesh 171009</a>&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pad-0">
                    <div class="login-content">
                        <div class="login-title section-border">
                            <h3>Fill Out the Form Now for amazing travel offers!</h3>
                        </div>
                        <div class="login-formm section-border">
                            <form action="mail.php" method="post">
                                <div class="form-group">
                                    <input type="text" placeholder="Name" />
                                </div>
                                <div class="form-group">
                                    <input type="email" placeholder="Email" />
                                </div>
                                <div class="form-group">
                                    <input type="text" pattern="[8,9][0-9]{9}" placeholder="Phone Number" />
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="City" />
                                </div>
                                <div class="form-btnn">
                                    <input type="submit" class="biz-btn biz-btn1" value="Send Enquiry" />
                                </div>
                            </form>


                        </div>
                        <div class="login-social section-border">
                            <p>Get the best deal today!!</p>
                            <a href="#" class="btn-facebook"><i class="fab fa-facebook" aria-hidden="true"></i> Facebook</a>
                            <a href="#" class="btn-instagram"><i class="fab fa-instagram" aria-hidden="true"></i> Instagram</a>
                            <a href="#" class="btn-twitter"><i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a>
                            <a href="#" class="btn-linkedin"><i class="fab fa-linkedin" aria-hidden="true"></i> Linkedin</a>
                        </div>
                        <div class="sign-up">
                            <p>Do not have an account?<a href="#">Sign Up</a></p>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>
            </div>
        </div>

    </div>
    <!-- *Scripts* -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/color-switcher.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/main.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/custom-swiper2.js"></script>
    <script src="js/custom-nav.js"></script>
    <script src="js/custom-date.js"></script>

</body>
<style>
  /* Grid container for the tile layout */
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Adjusts for responsive layout */
    gap: 20px; /* Space between grid items */
    margin-top: 20px;
}

/* Style for larger packages */
.package-large .holiday-yaarana-theme img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

/* Style for smaller packages */
.package-small .holiday-yaarana-theme img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Shared styles for package items */
.package-item {
    transition: transform 0.3s ease-in-out;
}

.package-item:hover {
    transform: scale(1.05);
}

/* Responsive design adjustments */
@media (max-width: 768px) {
    .grid-container {
        grid-template-columns: 1fr; /* Stack items on smaller screens */
    }
}

</style>

</html>