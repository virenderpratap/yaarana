
<?php
include('./cms/include/config.php');
$cid="14";
// $cid=intval($_GET['cid']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

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


 <!-- header starts -->
    <?php include "head.php" ?>
<?php
// Assuming $cid is the category ID from the URL or request parameters
$er = mysqli_query($con, "SELECT * FROM category WHERE id='$cid'");
$r = mysqli_fetch_array($er);

// Fetch category image (from the database)
$category_image = isset($r['categoryimg']) && !empty($r['categoryimg']) ? htmlspecialchars($r['categoryimg']) : 'default-image.jpg'; // Fallback image
?>
<!-- Breadcrumb -->
<section class="breadcrumb-outer text-center" style="background: url(./cms/uploads/<?php echo $category_image; ?>);">
    <div class="container">
        <div class="breadcrumb-content">
            <h2 class="white"><?php echo htmlspecialchars($r['categoryName']); ?></h2>
        </div>
    </div>
    <div class="overlay"></div>
</section>
<!-- BreadCrumb Ends -->


    <!-- tour list starts -->
    <section class="list">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12 pull-right scroller">
                    <div class="trend-box">
                        <div class="list-results display-flex space-between">
                            <div class="list-results-sort pull-left pad-top-5">
                                <p class="mar-0">Showing All of 80 results</p>
                            </div>
                            <div class="click-menu pull-right">
                                <!-- <div class="change-list mar-right-10"><a href="all-spiti-packages.php"><i class="fa fa-bars"></i></a></div> -->
                                <div class="change-grid f-active"><a href="all-spiti-packages.php"><i class="fa fa-th"></i></a></div>
                            </div>
                        </div>
                        <div class="row">
                                                   <?php
$ret=mysqli_query($con,"select * from products where category='$cid'");
$num=mysqli_num_rows($ret);
if($num>0)
{
while ($row=mysqli_fetch_array($ret)) 
{?>		
                            <div class="col-md-6 col-sm-6 col-xs-12 mar-bottom-30">
                                <div class="trend-item">
                                    <div class="ribbon ribbon-top-left"><span>25% OFF</span></div>
                                    <div class="trend-image">
                                        <a href="package-detail.php?pid=<?php echo htmlentities($row['id']);?>&<?php echo htmlentities($row['productName']);?>"></a>
                                        <img src="cms/uploads/<?php echo htmlentities($row['productImage1']);?>" alt="image">
                                        <div class="trend-tags">
                                            <a href="#"><i class="flaticon-like"></i></a>
                                        </div>
                                        <div class="trend-price">
                                            <p class="price">From <span>₹<?php echo htmlentities($row['cost']);?>/-</span></p>
                                        </div>
                                    </div>
                                    <div class="trend-content">
                                        <p><i class="flaticon-location-pin"></i> <?php echo htmlentities(substr($row['covered'], 0, 33)); ?></p>
                                        <h4><a href="package-detail.php?pid=<?php echo htmlentities($row['id']);?>&<?php echo htmlentities($row['productName']);?>"><?php echo htmlentities(substr($row['productName'], 0, 33)); ?></a></h4>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="rating mar-bottom-15">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ccol-sm-6 col-xs-6">
                                                <p class="mar-0"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo htmlentities($row['duration']);?></p>

                                            </div>
                                        </div>
                                        <div class="row yaarana-border-btm">
                                            <div class="col-md-5">
                                                <div class="yaarana-package-icon">
                                                      <img src="./icon/yaarana-whatsapp.png" alt="">
                                                      <img src="./icon/yaarana-calling.png" alt="">
                                                      <img src="./icon/yaarana-mail.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-7 yarana-flex-end">
                                                <div class="yaarana-package-icon">
                                                    <button class="yaarana-btn">Redeem This Offer</button>
                                                </div>
                                            </div>  

                                        </div>
                                        <div class="row yarana-full-btn">
                                             <div class="col-md-12 yarana-flex-center">
                                                <div class="yaarana-package-icon">
                                                    <button class="yaarana-btn-green"><a href="package-detail.php?pid=<?php echo htmlentities($row['id']);?>&<?php echo htmlentities($row['productName']);?>">Get This Package </aDetails</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php } } else {?>
	
		  <div> <h3>No Records Found</h3>
		</div>
		
<?php } ?>	
                            <div class="col-xs-12">
                                <div class="blog-button text-center">
                                    <a href="car-detail.html" class="biz-btn biz-btn1">Load More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             <?php include "side.php" ?>
            </div>
        </div>
    </section>
    <!-- tour list ends -->

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

</body>

</html>