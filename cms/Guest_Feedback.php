<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission for adding feedback with videos
    if (isset($_POST['save_feedback'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $content = mysqli_real_escape_string($con, $_POST['content']);
        $date = date("Y-m-d");

        // Insert feedback entry into the `feedback` table
        $sql_insert_feedback = "INSERT INTO feedback (title, content, date) VALUES ('$title', '$content', '$date')";
        if (mysqli_query($con, $sql_insert_feedback)) {
            $feedback_id = mysqli_insert_id($con); // Get the inserted feedback ID

            // Handle multiple video uploads
            if (isset($_FILES['videos']) && !empty($_FILES['videos']['name'][0])) {
                $video_files = $_FILES['videos'];
                $video_count = count($video_files['name']);
                $uploadFolder = 'uploads/feedback_videos/';

                // Ensure the directory exists
                if (!is_dir($uploadFolder)) {
                    mkdir($uploadFolder, 0777, true);
                }

                // Loop through each uploaded video
                for ($i = 0; $i < $video_count; $i++) {
                    $videoTmpName = $video_files['tmp_name'][$i];
                    $videoName = basename($video_files['name'][$i]);
                    $videoPath = $uploadFolder . $videoName;

                    // Upload video file
                    if (move_uploaded_file($videoTmpName, $videoPath)) {
                        // Insert video path into `feedback_videos` table
                        $sql_insert_video = "INSERT INTO feedback_videos (feedback_id, video_path) VALUES ('$feedback_id', '$videoPath')";
                        mysqli_query($con, $sql_insert_video);
                    } else {
                        echo "<script>alert('Error uploading video: $videoName');</script>";
                    }
                }
            }

            $_SESSION['add_message'] = "Feedback and videos added successfully!";
            header('Location: Guest_Feedback.php');
            exit;
        } else {
            echo "<script>alert('Error inserting feedback into database: " . mysqli_error($con) . "');</script>";
        }
    }

    // Delete feedback and associated videos
    if (isset($_GET['delete_id'])) {
        $feedback_id = $_GET['delete_id'];
        $sql_delete_feedback = "DELETE FROM feedback WHERE id = $feedback_id";
        $sql_delete_videos = "DELETE FROM feedback_videos WHERE feedback_id = $feedback_id";

        if (mysqli_query($con, $sql_delete_feedback) && mysqli_query($con, $sql_delete_videos)) {
            $_SESSION['delete_message'] = "Feedback deleted successfully!";
            header('Location: Guest_Feedback.php');
            exit;
        } else {
            echo "<script>alert('Error deleting feedback: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Manage Feedback</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>
<div id="container-wrapper">
    <?php include('sidebar.php'); ?>
    <div id="dashboard">
        <div class="dashboard-content">
            <div class="row">
                <section class="feedback-management">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Add <span>Guest Feedback</span></h2>
                        </div>
                        <form action="Guest_Feedback.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Feedback Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Feedback Content</label>
                                <textarea class="form-control" id="content" name="content" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="videos">Select Multiple Videos</label>
                                <input type="file" class="form-control" id="videos" name="videos[]" accept="video/*" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_feedback">Add Feedback</button>
                        </form>
                    </div>
                </section>

                <!-- Feedback List Section -->
                <section class="feedback-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Guest Feedback</span></h2>
                        </div>
                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Feedback Title</th>
                                    <th>Content</th>
                                    <th>Videos</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_feedback = "SELECT * FROM feedback";
                                $result_feedback = mysqli_query($con, $sql_feedback);
                                
                                if (mysqli_num_rows($result_feedback) > 0) {
                                    while ($feedback = mysqli_fetch_assoc($result_feedback)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($feedback['title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($feedback['content']) . "</td>";
                                        
                                        // Display all videos related to this feedback record
                                        $feedback_id = $feedback['id'];
                                        $sql_videos = "SELECT video_path FROM feedback_videos WHERE feedback_id = $feedback_id";
                                        $result_videos = mysqli_query($con, $sql_videos);
                                        
                                        echo "<td>";
                                        while ($video = mysqli_fetch_assoc($result_videos)) {
                                            echo "<video src='" . htmlspecialchars($video['video_path']) . "' controls style='width: 100px; margin-top: 10px;'></video>";
                                        }
                                        echo "</td>";
                                        
                                        echo "<td>
                                            <a href='Guest_Feedback.php?delete_id=" . $feedback['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this feedback?\")'>Delete</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No feedback available.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</body>
<style>
    .header_black { background: #242424; }
    .dashboard-content { margin-left: 250px; margin-top: 80px; padding: 20px; }
    .section-title { margin-bottom: 20px; }
    .btn-primary, .btn-danger { border-radius: 5px; }
    .table-custom th, .table-custom td { text-align: center; vertical-align: middle; }
    .feedback-list video { width: 100px; margin-top: 10px; }
</style>
</html>
<?php } ?>
