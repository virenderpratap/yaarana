<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Handle form submission for adding or updating a blog post with image
    if (isset($_POST['save_blog'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $content = mysqli_real_escape_string($con, $_POST['content']);
        $image_url = '';

        // Handle image upload (if any)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_name = basename($_FILES['image']['name']);
            $image_type = mime_content_type($image_tmp);
            $image_path = 'uploads/blog_images/' . $image_name;

            if (strpos($image_type, 'image') !== false) {
                if (!is_dir('uploads/blog_images')) {
                    mkdir('uploads/blog_images', 0777, true);
                }

                if (move_uploaded_file($image_tmp, $image_path)) {
                    $image_url = $image_path;
                } else {
                    echo "<script>alert('Error uploading image.');</script>";
                }
            }
        }

        // Check if we are editing an existing blog or adding a new one
        if (isset($_GET['edit_id'])) {
            // Update the existing blog
            $blog_id = $_GET['edit_id'];
            $sql_update = "UPDATE blogs SET title = '$title', content = '$content', image_url = '$image_url' WHERE id = $blog_id";
            if (mysqli_query($con, $sql_update)) {
                $_SESSION['edit_message'] = "Blog updated successfully!";
                header('Location: Add_Blogs.php');
                exit;
            } else {
                echo "<script>alert('Error updating blog: " . mysqli_error($con) . "');</script>";
            }
        } else {
            // Insert new blog post
            $sql_insert = "INSERT INTO blogs (title, content, image_url) VALUES ('$title', '$content', '$image_url')";
            if (mysqli_query($con, $sql_insert)) {
                $_SESSION['add_message'] = "Blog added successfully!";
                header('Location: Add_Blogs.php');
                exit;
            } else {
                echo "<script>alert('Error inserting blog into database: " . mysqli_error($con) . "');</script>";
            }
        }
    }

    // Delete a blog post
    if (isset($_GET['delete_id'])) {
        $blog_id = $_GET['delete_id'];
        $sql_delete = "DELETE FROM blogs WHERE id = $blog_id";
        if (mysqli_query($con, $sql_delete)) {
            $_SESSION['delete_message'] = "Blog deleted successfully!";
            header('Location: Add_Blogs.php');
            exit;
        } else {
            echo "<script>alert('Error deleting blog: " . mysqli_error($con) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php'); ?>
    <title>Manage Blogs</title>
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
                <!-- Add/Edit Blog Form Section -->
                <section class="blog-management">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2><?php echo isset($_GET['edit_id']) ? 'Edit' : 'Add'; ?> <span>Blog</span></h2>
                        </div>
                        <form action="Add_Blogs.php<?php echo isset($_GET['edit_id']) ? '?edit_id=' . $_GET['edit_id'] : ''; ?>" method="POST" enctype="multipart/form-data">
                            <?php
                            // Pre-populate form if editing an existing blog
                            if (isset($_GET['edit_id'])) {
                                $blog_id = $_GET['edit_id'];
                                $sql_blog = "SELECT * FROM blogs WHERE id = $blog_id";
                                $result_blog = mysqli_query($con, $sql_blog);
                                if ($result_blog && mysqli_num_rows($result_blog) > 0) {
                                    $blog = mysqli_fetch_assoc($result_blog);
                                    $title = $blog['title'];
                                    $content = $blog['content'];
                                    $image_url = $blog['image_url'];
                                }
                            }
                            ?>
                            <div class="form-group">
                                <label for="title">Blog Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Blog Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo isset($content) ? htmlspecialchars($content) : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Blog Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <?php if (isset($image_url) && !empty($image_url)): ?>
                                    <br><img src="<?php echo htmlspecialchars($image_url); ?>" alt="Blog Image" style="width: 100px;">
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_blog"><?php echo isset($blog) ? 'Update' : 'Add'; ?> Blog</button>
                        </form>
                    </div>
                </section>

                <!-- Blog List Section -->
                <section class="blog-list">
                    <div class="container">
                        <div class="section-title title-full">
                            <h2>Manage <span>Blogs</span></h2>
                        </div>
                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Blog Title</th>
                                    <th>Content</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_blogs = "SELECT * FROM blogs";
                                $result_blogs = mysqli_query($con, $sql_blogs);
                                
                                if (mysqli_num_rows($result_blogs) > 0) {
                                    while ($blog = mysqli_fetch_assoc($result_blogs)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($blog['title']) . "</td>";
                                        echo "<td>" . nl2br(htmlspecialchars($blog['content'])) . "</td>";
                                        echo "<td>";
                                        if (!empty($blog['image_url'])) {
                                            echo "<img src='" . htmlspecialchars($blog['image_url']) . "' alt='Blog Image' style='width: 100px;'>";
                                        }
                                        echo "</td>";
                                        echo "<td>
                                            <a href='Add_Blogs.php?edit_id=" . $blog['id'] . "' class='btn btn-warning'>Edit</a>
                                            <a href='Add_Blogs.php?delete_id=" . $blog['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this blog?\")'>Delete</a>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No blogs available.</td></tr>";
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
    .btn-primary, .btn-danger, .btn-warning { border-radius: 5px; }
    .table-custom th, .table-custom td { text-align: center; vertical-align: middle; }
    .blog-list img { width: 100px; margin-top: 10px; }
</style>
</html>
<?php } ?>
