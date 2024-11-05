<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
<style>
    .slider-itemm:nth-of-type(1n) .dealx {
        background-color: lightgreen !important; /* Color for first deal */
    }

    .slider-itemm:nth-of-type(2n) .dealx {
        background-color: lightpink !important; /* Color for second deal */
    }
    .slider-itemm:nth-of-type(3n) .dealx {
        background-color: yellowgreen !important; /* Color for second deal */
    }
    .slider-itemm:nth-of-type(4n) .dealx {
        background-color: peru !important; /* Color for second deal */
    }
    .slider-itemm:nth-of-type(5n) .dealx {
        background-color: orchid !important; /* Color for second deal */
    }

 /* Modal styles */
 .modal {
            display: none; /* Hidden by default */
            position: fixed; 
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
            padding-top: 50px;
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

</style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Nepayatri - Tour & Travel Multipurpose Template</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="../css/default.css" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <!--Plugin CSS-->
    <link href="../css/plugin.css" rel="stylesheet" type="text/css">
    <!--Dashboard CSS-->
    <link href="../css/dashboard.css" rel="stylesheet" type="text/css">
    <!--Icons CSS-->
    <link href="css/icons.css" rel="stylesheet" type="text/css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
</head>
<body>

    <!-- start Container Wrapper -->
    <div id="container-wrapper">
        <!-- Dashboard -->
        <div id="dashboard">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>  

            <div class="dashboard-sticky-nav">
                <div class="content-left pull-left">
                    <a href="dashboard.html"><img src="../images/logo-black.png" alt="logo"></a>
                </div>
                <div class="content-right pull-right">
                    <div class="search-bar">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="search" placeholder="Search Now">
                                <a href="#"><span class="search_btn"><i class="fa fa-search" aria-hidden="true"></i></span></a>
                            </div>
                        </form>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="profile-sec">
                                <div class="dash-content">
                                    <h4>Loural Teak</h4>
                                    <span>Post Manager</span>
                                </div>
                                <div class="dash-image">
                                    <img src="images/comment.jpg" alt="">
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="sl sl-icon-settings"></i>Settings</a></li>
                            <li><a href="#"><i class="sl sl-icon-user"></i>Profile</a></li>
                            <li><a href="#"><i class="sl sl-icon-lock"></i>Change Password</a></li>
                            <li><a href="#"><i class="sl sl-icon-power"></i>Logout</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="dropdown-item">
                                <i class="sl sl-icon-envelope-open"></i>
                                <span class="notify">3</span>
                            </div>
                        </a>
                        <div class="dropdown-menu notification-menu">
                        <h4> 23 Messages</h4>
                        <ul>
                            <li>
                                <a href="#">
                                    <div class="notification-item">
                                        <div class="notification-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="notification-content">
                                            <p>You have a notification.</p><span class="notification-time">2 hours ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="notification-item">
                                        <div class="notification-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="notification-content">
                                            <p>You have a notification.</p><span class="notification-time">2 hours ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="notification-item">
                                        <div class="notification-image">
                                            <img src="images/comment.jpg" alt="">
                                        </div>
                                        <div class="notification-content">
                                            <p>You have a notification.</p><span class="notification-time">2 hours ago</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <p class="all-noti"><a href="#">See all messages</a></p>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="dropdown-item">
                                <i class="sl sl-icon-bell"></i>
                                <span class="notify">3</span>
                            </div>
                        </a>
                        <div class="dropdown-menu notification-menu">
                            <h4> 599 Notifications</h4>
                            <ul>
                                <li>
                                    <a href="#">
                                        <div class="notification-item">
                                            <div class="notification-image">
                                                <img src="images/comment.jpg" alt="">
                                            </div>
                                            <div class="notification-content">
                                                <p>You have a notification.</p><span class="notification-time">2 hours ago</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="notification-item">
                                            <div class="notification-image">
                                                <img src="images/comment.jpg" alt="">
                                            </div>
                                            <div class="notification-content">
                                                <p>You have a notification.</p><span class="notification-time">2 hours ago</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="notification-item">
                                            <div class="notification-image">
                                                <img src="images/comment.jpg" alt="">
                                            </div>
                                            <div class="notification-content">
                                                <p>You have a notification.</p><span class="notification-time">2 hours ago</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <p class="all-noti"><a href="#">See all notifications</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">
                    <ul>
                        <li class="active"><a href="dashboard.html"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
                        <!-- <li><a href="dashboard-my-profile.html"><i class="sl sl-icon-user"></i> Profile</a></li> -->
                        <!-- <li><a href="dashboard-list.html"><i class="sl sl-icon-plus"></i> Wishlist</a></li>                         -->
                        <!-- <li><a href="dashboard-messages.html"><i class="sl sl-icon-envelope-open"></i> Messages</a></li> -->
                        <li>
                            <!-- <a><i class="sl sl-icon-layers"></i> Hotel</a> -->
                            <ul>
                                <li><a href="dashboard-history.html">Booking History</a></li>
                                <li><a href="dashboard-add-new.html">Add New Hotel</a></li>
                                <li><a href="dashboard-hotel-list.html">My Hotel</a></li>
                                <li><a href="dashboard-reviews.html">Reviews</a></li>
                            </ul>   
                        </li>
                    </ul>
                </div>
            </div>
            <div class="dashboard-content">
                <div class="row">

                    <!-- Item -->
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-1">
                            <div class="dashboard-stat-content"><h4>6</h4> <span>Active Listings</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Map2"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-2">
                            <div class="dashboard-stat-content"><h4>726</h4> <span>Total Bookings</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>


                    <!-- Item -->
                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-3">
                            <div class="dashboard-stat-content"><h4>95</h4> <span>Total Reviews</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Add-UserStar"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-xs-6">
                        <div class="dashboard-stat color-4">
                            <div class="dashboard-stat-content"><h4>126</h4> <span>Bookmarks</span></div>
                            <div class="dashboard-stat-icon"><i class="im im-icon-Heart"></i></div>
                            <div class="dashboard-stat-item"><p>Someone bookmarked your listing!</p></div>
                        </div>
                    </div>
                </div>
                
 







                

<!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<section class="top-dealrs">
        <div class="container">
               <div class="section-title title-full">
                <h2 class="mar-0">Today's  <span>Top Deals</span></h2>
            </div>
            <div class="row top-deal-slider">
                <div class="col-md-4 slider-itemm art">
                    <div class="dealx">
                        <div class="one">
                            <div class="tr-yaa">Diwali Sale On</div>
                            <div class="tr-yaa2">Summer Tour Packages</div>
                        </div>
                        <div class="two">
                            <div class="deal-img">
                                <img src="./images/package/Singapore.jpg" alt="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 slider-itemm art">
                    <div class="dealx">
                        <div class="one">
                            <div class="tr-yaa">Diwali Sale On</div>
                            <div class="tr-yaa2">Summer Tour Packages</div>
                        </div>
                        <div class="two">
                            <div class="deal-img">
                                <img src="./images/package/bali.jpg" alt="">
                            </div>
                        </div>
                    </div>
            











                </div>
                <div class="col-md-4 slider-itemm">
                    <div class="dealx">
                        <div class="one">
                        <button id="openModalBtn">eddit</button>
                            <div class="tr-yaa">Diwali Sale On</div>
                            <div class="tr-yaa2">Summer Tour Packages</div>
                        </div>
                        <div class="two">
                            <div class="deal-img">
                                <img src="./images/family.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>













                 <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalBtn">&times;</span>
            <h2>Deal Form</h2>
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" required>
                </div>

                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>

                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>











                <div class="col-md-4 slider-itemm">
                    <div class="dealx">
                        <div class="one">
                            <div class="tr-yaa">Diwali Sale On</div>
                            <div class="tr-yaa2">Summer Tour Packages</div>
                        </div>
                        <div class="two">
                            <div class="deal-img">
                                <img src="./images/package/malaysia.webp" alt="">
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </section>
    
    
    <?php
    if (isset($_POST['submit'])) {
        // Get the form data
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        
        // Handle image upload
        if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $imagePath = 'uploads/' . $imageName;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($imageTmpName, $imagePath)) {
                echo "<p>Title: $title</p>";
                echo "<p>Subtitle: $subtitle</p>";
                echo "<p>Uploaded Image: <img src='$imagePath' alt='$imageName' width='100'></p>";
            } else {
                echo "<p>Image upload failed!</p>";
            }
        } else {
            echo "<p>Error uploading the image.</p>";
        }
    }
    ?>





    <!-- *Scripts* -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/jpanelmenu.min.js"></script>
    <script src="js/dashboard-custom.js"></script>

    <script>
        // Get modal and buttons
        var modal = document.getElementById('myModal');
        var openModalBtn = document.getElementById('openModalBtn');
        var closeModalBtn = document.getElementById('closeModalBtn');

        // Open the modal
        openModalBtn.onclick = function() {
            modal.style.display = "block";
        }

        // Close the modal
        closeModalBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
<?php } ?>