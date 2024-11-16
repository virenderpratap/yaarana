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
                        // Verify the password by comparing plain text (since it's not hashed)
                        if ($password === $stored_password) {
                            // Password is correct, start a new session
                            $_SESSION["alogin"] = true;
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
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file here -->
</head>
<body>
    <div class="area">
        <div class="circles">
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

        <!-- Position title and form together in a container -->
        <div class="form-container">
            <div class="context">
                <h1>Admin</h1>
            </div>
            <div class="login-form">
                <?php 
                if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>
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
                        <p>Don't have an account? <a href="#">Register here</a>.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
   @import url('https://fonts.googleapis.com/css?family=Exo:400,700');

body {
    font-family: 'Exo', sans-serif;
    margin: 0;
    padding: 0;
}

.area {
    background: #4e54c8;
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);
    width: 100%;
    height: 100vh;
    position: relative;
    overflow: hidden; /* Prevents scrollbars from showing */
}

.circles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.circles ul li {
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
}

.circles ul li:nth-child(1) {
    left: 25%;
    width: 80px;
    height: 80px;
    animation-delay: 0s;
}

.circles ul li:nth-child(2) {
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}

.circles ul li:nth-child(3) {
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}

.circles ul li:nth-child(4) {
    left: 40%;
    width: 60px;
    height: 60px;
    animation-delay: 0s;
    animation-duration: 18s;
}

.circles ul li:nth-child(5) {
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}

.circles ul li:nth-child(6) {
    left: 75%;
    width: 110px;
    height: 110px;
    animation-delay: 3s;
}

.circles ul li:nth-child(7) {
    left: 35%;
    width: 150px;
    height: 150px;
    animation-delay: 7s;
}

.circles ul li:nth-child(8) {
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}

.circles ul li:nth-child(9) {
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}

.circles ul li:nth-child(10) {
    left: 85%;
    width: 150px;
    height: 150px;
    animation-delay: 0s;
    animation-duration: 11s;
}

@keyframes animate {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }
    100% {
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }
}

/* Center title and form together */
.form-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    max-width: 400px;
    z-index: 1; /* Ensure form appears above the animation */
}

/* Center title text */
.context h1 {
    color: #fff;
    font-size: 50px;
    text-align: center;
    margin-bottom: 20px;
}

/* Form styling */
.login-form {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 8px;
    backdrop-filter: blur(10px);
}

/* Smaller screens adjustments */
@media (max-width: 768px) {
    .context h1 {
        font-size: 30px;
    }
}

@media (max-width: 480px) {
    .context h1 {
        font-size: 24px;
    }
}
</style>
</html>
