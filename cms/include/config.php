<?php
// Database configuration
if (!defined('DB_SERVER')) {
    define('DB_SERVER', 'localhost');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', '');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'yaarana');
}

// Establish the connection using $con only if it's not already set
if (!isset($con)) {
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    // Check if the connection was successful
    if (!$con) {
        // Log error to a file
        error_log("Connection failed: " . mysqli_connect_error(), 3, 'errors.log');
        
        // Provide a user-friendly message
        die("Connection failed. Please try again later.");
    }

    // Set the character set to UTF-8 for proper encoding
    mysqli_set_charset($con, 'utf8');
}

// Now you can use $con to interact with the database securely.
?>
