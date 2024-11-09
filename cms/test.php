<?php
// Including the header.php file at the beginning of the body.
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Dashboard Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        #sidebar {
            position: fixed;
            top: 0;
            left: -250px;  /* Sidebar is hidden initially */
            width: 250px;
            height: 100%;
            background-color: #333;
            color: white;
            transition: left 0.3s ease;
        }

        /* Sidebar active class to show it */
        #sidebar.active {
            left: 0;  /* Sidebar slides in */
        }

        /* Responsive sidebar on mobile */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100%;
                background-color: #333;
                color: white;
                transition: left 0.3s ease;
            }

            #sidebar.active {
                left: 0;
            }

            .dashboard-responsive-nav-trigger {
                padding: 10px;
                cursor: pointer;
                color: #fff;
            }
        }

        /* Simple styling for the main content */
        #dashboard {
            margin-left: 250px;
            padding: 20px;
        }

        .header_black {
            background-color: #242424;
            padding: 10px;
            color: white;
        }
    </style>
</head>

<body>

<!-- Start Container Wrapper -->
<div id="container-wrapper">

    <!-- Sidebar Navigation (Including sidebar.php) -->
    <?php include('sidebar.php'); ?>

    <!-- Dashboard Main Content -->
    <div id="dashboard">
        <!-- Responsive Navigation Trigger -->
        <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>

        <!-- Sticky Navigation and Profile -->
        <div class="dashboard-sticky-nav header_black">
            <div class="content-left pull-left">
                <a href="dashboard.html"><img src="../images/logo-black.png" alt="logo" width="100"></a>
            </div>
            <div class="content-right pull-right">
                <button class="btn btn-light"><i class="fa fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <h1>Welcome to the Dashboard</h1>
            <p>This is a test page to check if the sidebar and dashboard navigation work on small screens.</p>
        </div>
    </div>

</div>

<!-- Include necessary JS libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar Toggle Button
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarTrigger = document.querySelector('.dashboard-responsive-nav-trigger');
        const sidebar = document.getElementById('sidebar');

        if (sidebarTrigger && sidebar) {
            sidebarTrigger.addEventListener('click', function() {
                // Log click event for debugging
                console.log('Dashboard navigation trigger clicked');
                
                // Toggle the active class on the sidebar
                sidebar.classList.toggle('active');
                
                // Log current class list for debugging
                console.log('Sidebar class toggled. Current class list:', sidebar.classList);
            });
        } else {
            console.error('Sidebar or trigger element not found');
        }
    });
</script>

</body>
</html>
