<?php
session_start();
include_once('include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission to add or update an event
    if (isset($_POST['save_event'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $content = mysqli_real_escape_string($con, $_POST['content']);
        $date = mysqli_real_escape_string($con, $_POST['date']);

        // Check if it's an update or new event addition
        if (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
            $event_id = $_POST['event_id'];
            $sql_update = "UPDATE events SET title = '$title', content = '$content', date = '$date' WHERE id = $event_id";

            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Event updated successfully!";
                header('Location: AddEvents.php');
                exit;
            } else {
                echo "<script>alert('Error updating event: " . mysqli_error($con) . "');</script>";
            }

        } else {
            // Insert a new event if no ID is present
            $sql_insert = "INSERT INTO events (title, content, date) VALUES ('$title', '$content', '$date')";
            if (mysqli_query($con, $sql_insert)) {
                $event_id = mysqli_insert_id($con); // Get the inserted event ID

                // Handle image uploads
                if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                    $image_files = $_FILES['images'];
                    $image_count = count($image_files['name']);

                    for ($i = 0; $i < $image_count; $i++) {
                        $image_name = $image_files['name'][$i];
                        $image_tmp_name = $image_files['tmp_name'][$i];
                        $image_path = 'uploads/events/' . basename($image_name);

                        // Move uploaded image to the appropriate directory
                        if (move_uploaded_file($image_tmp_name, $image_path)) {
                            // Insert the image path into the event_images table
                            $sql_image = "INSERT INTO event_images (event_id, image_path) VALUES ($event_id, '$image_path')";
                            mysqli_query($con, $sql_image);
                        }
                    }
                }

                $_SESSION['add_message'] = "Event added successfully!";
                header('Location: AddEvents.php');
                exit;
            } else {
                echo "<script>alert('Error adding event: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Fetch event details if editing
    $edit_event = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = "SELECT * FROM events WHERE id = $edit_id";
        $result_edit = mysqli_query($con, $sql_edit);
        $edit_event = mysqli_fetch_assoc($result_edit);
    }

    // Delete an event
    if (isset($_GET['delete_id'])) {
        $event_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM events WHERE id = $event_id";
        if (mysqli_query($con, $sql_delete)) {
            // Delete associated images
            $sql_delete_images = "DELETE FROM event_images WHERE event_id = $event_id";
            mysqli_query($con, $sql_delete_images);
            
            $_SESSION['delete_message'] = "Event deleted successfully!";
            header('Location: AddEvents.php');
            exit;
        } else {
            echo "<script>alert('Error deleting event: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Events</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>

<div id="container-wrapper">
    <?php include 'sidebar.php'; ?> <!-- Include Sidebar -->

    <div id="dashboard">
        <?php include 'header.php'; ?> <!-- Include Header -->

        <div class="dashboard-content">
            <div class="row">

                <section class="top-deals">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($edit_event) ? 'Edit' : 'Add a New'; ?> <span>Event</span></h2>
                        </div>

                        <form action="AddEvents.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Event Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($edit_event) ? htmlspecialchars($edit_event['title']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Event Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo isset($edit_event) ? htmlspecialchars($edit_event['content']) : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Event Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo isset($edit_event) ? htmlspecialchars($edit_event['date']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="images">Event Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
                            </div>

                            <input type="hidden" name="event_id" value="<?php echo isset($edit_event) ? $edit_event['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary" name="save_event">
                                <?php echo isset($edit_event) ? 'Update Event' : 'Add Event'; ?>
                            </button>
                        </form>
                    </div>
                </section>

                <section class="package-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Events</span></h2>
                        </div>

                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Date</th>
                                    <th>Images</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_events = "SELECT * FROM events";
                                $result_events = mysqli_query($con, $sql_events);

                                if (mysqli_num_rows($result_events) > 0) {
                                    while ($event = mysqli_fetch_assoc($result_events)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($event['title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($event['content']) . "</td>";
                                        echo "<td>" . htmlspecialchars($event['date']) . "</td>";

                                        // Fetch and display images for each event
                                        $event_id = $event['id'];
                                        $sql_images = "SELECT image_path FROM event_images WHERE event_id = $event_id";
                                        $result_images = mysqli_query($con, $sql_images);
                                        echo "<td>";
                                        while ($image = mysqli_fetch_assoc($result_images)) {
                                            echo "<img src='" . $image['image_path'] . "' alt='Event Image' style='width: 50px; height: 50px; margin: 2px;'>";
                                        }
                                        echo "</td>";

                                        echo "<td>
                                            <a href='AddEvents.php?edit_id=" . $event['id'] . "' class='btn btn-warning'>Edit</a>
                                            <a href='AddEvents.php?delete_id=" . $event['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this event?\")'>Delete</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='no-data'>No events available.</td></tr>";
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
.header_black {
    background: #242424;
}
</style>
</html>

<?php
}
?>
