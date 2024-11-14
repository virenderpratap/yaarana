<?php
include('./cms/include/config.php');
$pid = intval($_GET['pid']);
$er = mysqli_query($con, "select * from products where id='$pid'");
$row = mysqli_fetch_array($er);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yaarana Holiday</title>
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
    <!-- header starts -->
    <?php include "head.php" ?>
    <!-- header ends -->

    <!-- tour detail starts -->
    <section class="single">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <div class="single-content">
                        <div class="single-slider mar-bottom-30">
                            <div class="slider-1 slider-store">
                  
                                <div class="detail-slider-item inside-packages">
                                    <img src="images/package/spiti-tour-package.webp" alt="image">
                                </div>
                                <div class="detail-slider-item inside-packages">
                                    <img src="images/package/spiti-tour-package.webp" alt="image">
                                </div>
                                <div class="detail-slider-item inside-packages">
                                    <img src="images/package/spiti-tour-package.webp" alt="image">
                                </div>
                                <div class="detail-slider-item inside-packages">
                                    <img src="images/package/spiti-tour-package.webp" alt="image">
                                </div>
                               
                           
                            </div>
                            <div class="slider-1 slider-thumbs slider-sort-inner">
                                <div class="detail-slider-item">
                                    <img src="images/package/spiti-tour-package.webp" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti.jpg" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti1.jpg" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti2.jpeg" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti3.jpg" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti4.jpg" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti5.jpg" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti6.jpg" alt="image">
                                </div>
                                <div class="detail-slider-item slider-sort-inner">
                                    <img src="images/package/spiti7.jpg" alt="image">
                                </div>
                            </div>
                        </div>
                        <div class="single-full-title section-border">
                            <div class="single-title">
                                <h2><?php echo htmlentities($row['productName']); ?></h2>
                                <p><i class="flaticon-location-pin"></i> <?php echo htmlentities($row['covered']); ?></p>
                                <a href="#">View on map</a>
                                <div class="rating">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <p>(1,186 Reviews)</p>
                            </div>
                        </div>
                        <div class="tour-includes">
                            <ul>
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo htmlentities($row['duration']); ?></li>
                                <li><i class="fa fa-group" aria-hidden="true"></i> Max People : 26</li>
                                <li><i class="fa fa-wifi" aria-hidden="true"></i> Wifi Available</li>
                                <li><i class="fa fa-calendar" aria-hidden="true"></i> Jan 18 - Dec 21</li>
                                <li><i class="fa fa-user" aria-hidden="true"></i> Min Age : 10+</li>
                                <li><i class="fa fa-map-o" aria-hidden="true"></i> Pickup : Airport</li>
                            </ul>
                        </div>
                        <div class="description mar-bottom-30">
                            <h3>Description</h3>
                            <p><?php echo htmlentities($row['special']); ?></p>
                        </div>

                      <div class="itinerary mar-bottom-30">
                            <h3>Itinerary</h3>
                            <?php
                            $rt = mysqli_query($con, "SELECT * FROM casestudy WHERE products='$pid'");
                            $cnt = 1;
                            while ($ro = mysqli_fetch_array($rt)) {
                            ?>
                                <div class="itinerary-item">
                                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#it1"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
                                    <p class="mar-bottom-0"><span>Day <?php echo htmlentities($cnt); ?></span> <?php echo htmlentities($ro['categoryName']); ?>: <?php echo htmlentities($ro['title']); ?></p>
                                    <div id="planCollapse<?php echo $ro['id']; ?>" class="collapse in itinerary-para">
                                        <?php echo $ro['categoryDescription']; ?>
                                    </div>
                                </div>
                            <?php $cnt = $cnt + 1;
                            } ?>
                        </div>
                        <!-- blog blockquote -->
                        <div class="blog-quote mar-bottom-30">
                            <p class="white">“Embark on a journey to Spiti Valley from Shimla for stunning landscapes and unforgettable adventures!” </p>
                            <span class="white">Yaarana Holliday</span>
                            <i class="fas fa-quote-left"></i>
                        </div>

                        <div class="blog-imagelist mar-bottom-30">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <img src="images/package/spiti6.jpg" alt="image">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <img src="images/package/spiti.jpg" alt="image">
                                </div>
                            </div>
                        </div>



                        <!-- blog share -->
                        <!-- blog blockquote -->

                        <div class="single-rooms mar-bottom-30">
                            <h3>Select Your Package</h3>
                            <div class="room-item">
                                <div class="row display-flex">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="room-image">
                                            <img src="images/package/spiti6.jpg" alt="Image">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="room-content">
                                            <div class="room-info">
                                                <h4>Volvo Tour Pcakage Ex. Delhi</h4>
                                                <div class="content-lower">
                                                    <ul>
                                                        <li><i class="fa fa-bed"></i> 480 sq ft</li>
                                                        <li><i class="fa fa-bed"></i> 4 rooms</li>
                                                        <li><i class="fa fa-bed"></i> 2 bathrooms</li>
                                                        <li><i class="fa fa-bed"></i> 6 beds</li>
                                                    </ul>
                                                </div>

                                            </div>
                                            <div class="room-price">
                                                <span class="offer clearfix">Save 13% Today</span>
                                                <p class="price">From <span>$350.00</span> / night</p>
                                                <a href="#" class="biz-btn-black bg-green">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="room-item">
                                <div class="row display-flex">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="room-image">
                                            <img src="images/package/spiti2.jpeg" alt="Image">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="room-content">
                                            <div class="room-info">
                                                <h4>Cab Tour Package Ex. Chandigarh</h4>
                                                <div class="content-lower">
                                                    <ul>
                                                        <li><i class="fa fa-bed"></i> 480 sq ft</li>
                                                        <li><i class="fa fa-bed"></i> 4 rooms</li>
                                                        <li><i class="fa fa-bed"></i> 2 bathrooms</li>
                                                        <li><i class="fa fa-bed"></i> 6 beds</li>
                                                    </ul>
                                                </div>

                                            </div>
                                            <div class="room-price">
                                                <span class="offer clearfix">Save 13% Today</span>
                                                <p class="price">From <span>$350.00</span> / night</p>
                                                <a href="#" class="biz-btn-black bg-green">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php include "aside.php" ?>
            </div>

        </div>
    </section>
    <!-- tour detail ends -->

    <!-- hotel-nearby starts -->
    <section class="hotel-nearby bg-grey">
        <div class="container">
            <div class="section-title">
                <h2>Related <span>Holiday</span> Plan</h2>
                <p>Lorem Ipsum is simply dummy text the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
            <div class="row top-deal-slider">
                <div class="col-md-4">
                    <div class="trend-item">
                        <div class="trend-image">
                            <img src="images/package/spiti1.jpg" alt="image">
                            <div class="trend-tags">
                                <a href="#"><i class="flaticon-like"></i></a>
                            </div>
                            <div class="trend-price">
                                <p class="price">From <span>$350.00</span></p>
                            </div>
                        </div>
                        <div class="trend-content">
                            <p><i class="flaticon-location-pin"></i> Japan</p>
                            <h4><a href="#">Stonehenge, Windsor Castle, and Bath from London</a></h4>
                            <div class="rating mar-bottom-15">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star-half checked"></span>
                            </div>
                            <span class="mar-left-5">21 Reviews</span>
                            <p class="mar-0"><i class="fa fa-clock-o" aria-hidden="true"></i> 3 days & 2 night</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trend-item">
                        <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                        <div class="trend-image">
                            <img src="images/package/spiti2.jpeg" alt="image">
                            <div class="trend-tags">
                                <a href="#"><i class="flaticon-like"></i></a>
                            </div>
                            <div class="trend-price">
                                <p>Multi-day Tours</p>
                                <p class="price">From <span>$899.00</span></p>
                            </div>
                        </div>
                        <div class="trend-content">
                            <p><i class="flaticon-location-pin"></i> Italy</p>
                            <h4><a href="#">Bosphorus Strait and Black Sea Half-Day Cruise from Istanbul</a></h4>
                            <div class="rating mar-bottom-15">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star-half checked"></span>
                                <span class="fa fa-star-half checked"></span>
                            </div>
                            <span class="mar-left-5">48 Reviews</span>
                            <p class="mar-0"><i class="fa fa-clock-o" aria-hidden="true"></i> 3 days & 2 night</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trend-item">
                        <div class="trend-image">
                            <img src="images/package/spiti3.jpg" alt="image">
                            <div class="trend-tags">
                                <a href="#"><i class="flaticon-like"></i></a>
                            </div>
                            <div class="trend-price">
                                <p>Attraction Tickets</p>
                                <p class="price">From <span>$350.00</span></p>
                            </div>
                        </div>
                        <div class="trend-content">
                            <p><i class="flaticon-location-pin"></i> Turkey</p>
                            <h4><a href="#">NYC One World Observatory Skip-the-Line Ticket</a></h4>
                            <div class="rating mar-bottom-15">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </div>
                            <span class="mar-left-5">18 Reviews</span>
                            <p class="mar-0"><i class="fa fa-clock-o" aria-hidden="true"></i> 3 days & 2 night</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trend-item">
                        <div class="ribbon ribbon-top-left"><span>Featured</span></div>
                        <div class="trend-image">
                            <img src="images/package/spiti4.jpg" alt="image">
                            <div class="trend-tags">
                                <a href="#"><i class="flaticon-like"></i></a>
                            </div>
                            <div class="trend-price">
                                <p>Attraction Tickets</p>
                                <p class="price">From <span>$350.00</span></p>
                            </div>
                        </div>
                        <div class="trend-content">
                            <p><i class="flaticon-location-pin"></i> Denmark</p>
                            <h4><a href="#">NYC One World Observatory Skip-the-Line Ticket</a></h4>
                            <div class="rating mar-bottom-15">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </div>
                            <span class="mar-left-5">32 Reviews</span>
                            <p class="mar-0"><i class="fa fa-clock-o" aria-hidden="true"></i> 3 days & 2 night</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hotel-nearby Ends -->

    <!-- footer starts -->
    <?php include "footer.php" ?>
    <!-- footer ends -->

    <!-- Back to top start -->
    <div id="back-to-top">
        <a href="#"></a>
    </div>
    <!-- Back to top ends -->

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

    <div class="modal fade" id="register" role="dialog">
        <div class="modal-dialog">
            <div class="login-content">
                <div class="login-title section-border">
                    <h3>Register</h3>
                </div>
                <div class="login-form section-border">
                    <form>
                        <div class="form-group">
                            <input type="text" placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Password">
                        </div>
                    </form>
                    <div class="form-btn">
                        <a href="#" class="biz-btn biz-btn1">REGISTER</a>
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

    <!-- *Scripts* -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/color-switcher.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/main.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/custom-nav.js"></script>
    <script src="js/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4JwWo5VPt9WyNp3Ne2uc2FMGEePHpqJ8&amp;callback=initMap" async defer></script>

</body>

</html>