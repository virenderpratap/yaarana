<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nepayatri - Tour & Travel Multipurpose Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Default CSS -->
    <link href="css/default.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!-- Color Switcher CSS -->
    <link rel="stylesheet" href="css/color/color-default.css">
    <!-- Plugin CSS -->
    <link href="css/plugin.css" rel="stylesheet" type="text/css">
    <!-- Flaticons CSS -->
    <link href="fonts/flaticon.css" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <style>
        .events-section {
            padding: 50px 0;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #333;
        }

        .section-title span {
            color: #007bff;
        }

        .event-card {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .event-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .event-date {
            font-size: 0.9rem;
            color: #999;
            margin-bottom: 15px;
        }

        .event-content {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
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

        .carousel-inner {
            max-height: 300px;
            overflow: hidden;
        }

        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 300px;
        }

        .ftr {
            display: flex;
            justify-content: right;
        }
    </style>

</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- Preloader Ends -->

    <!-- Breadcrumb -->
    <section class="breadcrumb-outer text-center">
        <div class="container">
            <div class="breadcrumb-content">
                <h2 class="white">Events From Yaarana</h2>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Car Booking</li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="overlay"></div>
    </section>
    <!-- BreadCrumb Ends -->

    <?php
    // Include database configuration file
    include_once('cms/include/config.php');

    // Query to fetch events from the database
    $sql_events = "SELECT * FROM events ORDER BY date DESC";
    $result_events = mysqli_query($con, $sql_events);
    ?>

    <!-- Events Section -->
    <section class="events-section text-center">
        <div class="container">
            <div class="section-title">
                <h2>Upcoming <span>Events</span></h2>
                <p>Discover our latest events and stay updated on what’s happening.</p>
            </div>

            <div class="row">
                <?php
                // Check if there are events available
                if (mysqli_num_rows($result_events) > 0) {
                    // Loop through each event and display it in a card
                    while ($event = mysqli_fetch_assoc($result_events)) {
                        // Get event images
                        $event_id = $event['id'];
                        $sql_images = "SELECT image_path FROM event_images WHERE event_id = $event_id";
                        $result_images = mysqli_query($con, $sql_images);
                        
                        // Start the event card
                        echo '<div class="col-md-4">
                                <div class="event-card">';
                        
                        // Display carousel if images are available
                        if (mysqli_num_rows($result_images) > 0) {
                            echo '<div id="carousel-' . $event_id . '" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">';
                                    
                            $active = true;
                            // Loop through all event images and display them in carousel
                            while ($image = mysqli_fetch_assoc($result_images)) {
                                echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">
                                        <img src="cms/' . $image['image_path'] . '" alt="Event Image" class="d-block w-100">
                                      </div>';
                                $active = false;
                            }
                            echo '</div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-' . $event_id . '" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-' . $event_id . '" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                  </div>';
                        }

                        // Event details
                        echo '
                            <h3 class="event-title">' . htmlspecialchars($event['title']) . '</h3>
                            <p class="event-date"><i class="far fa-calendar-alt"></i> ' . date("F j, Y", strtotime($event['date'])) . '</p>
                            <p class="event-content">' . htmlspecialchars($event['content']) . '</p>';

                        // Learn more button
                        echo '<a href="#" class="btn btn-primary">Learn More</a>';

                        // Close event card
                        echo '</div>
                            </div>';
                    }
                } else {
                    echo '<p>No events available at the moment.</p>';
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script src="js/main.js"></script>

</body>

</html>
