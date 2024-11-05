<?php
// Start the session at the very beginning
session_start();

// Include the database connection file
include('include/config.php');

// Initialize variables
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if the password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If there are no errors, proceed with the database query
    if (empty($username_err) && empty($password_err)) {
        // Prepare the SQL query to fetch user details from the database
        $sql = "SELECT id, username, password FROM admin WHERE username = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind the username to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the parameter
            $param_username = $username;

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Store the result
                mysqli_stmt_store_result($stmt);

                // Check if the username exists in the database
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username_db, $stored_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        // Debugging: Check if the username and password match
                        // echo "Username found: $username_db<br>";  // Debugging line
                        // echo "Stored password: $stored_password<br>"; // Debugging line
                        
                        // Verify the password by comparing plain text (since it's not hashed)
                        if ($password === $stored_password) {
                            // Password is correct, start a new session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username_db;

                            // Redirect user to the welcome page (or dashboard)
                            header("location: /yaarana/cms/welcome.php");
                            exit();  // Always call exit after header redirection
                        } else {
                            // Display an error if password is incorrect
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Display an error if the username does not exist
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close the connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>

        <!-- Display error messages if any -->
        <?php 
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <!-- Login form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="<?php echo $username; ?>" required>
                <span class="text-danger"><?php echo $username_err; ?></span>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>

            <div class="mb-3">
                <p>Don't have an account? <a href="register.php">Register here</a>.</p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
