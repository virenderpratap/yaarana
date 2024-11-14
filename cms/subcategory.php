<?php
session_start();
include('include/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    // Add new subcategory
    if (isset($_POST['submit'])) {
        $category = $_POST['category']; // Category ID
        $subcat = $_POST['subcategory']; // Subcategory name

        // Insert subcategory into the database
        $sql = mysqli_query($con, "INSERT INTO subcategory(categoryid, subcategory) VALUES('$category', '$subcat')");
        $_SESSION['msg'] = "Subcategory Added Successfully!";
    }

    // Update existing subcategory
    if (isset($_POST['update'])) {
        $subcategory_id = $_POST['subcategory_id'];
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];

        // Update the subcategory in the database
        $sql = mysqli_query($con, "UPDATE subcategory SET categoryid='$category', subcategory='$subcat' WHERE id='$subcategory_id'");
        $_SESSION['msg'] = "Subcategory Updated Successfully!";
    }

    // Delete subcategory
    if (isset($_GET['del'])) {
        $id = $_GET['id'];
        mysqli_query($con, "DELETE FROM subcategory WHERE id='$id'");
        $_SESSION['delmsg'] = "Subcategory Deleted Successfully!";
    }

    // Fetch data for editing if edit_id is present
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql_edit = mysqli_query($con, "SELECT * FROM subcategory WHERE id = '$edit_id'");
        $edit_package = mysqli_fetch_array($sql_edit);
    }
?>
    <!DOCTYPE html>
    <html lang="zxx">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage India Tour Packages</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/dashboard.css" rel="stylesheet">
    </head>

    <body>

        <div id="container-wrapper">
            <!-- Include Sidebar -->
            <?php include('sidebar.php'); ?>

            <!-- Include Header -->
            <?php include('header.php'); ?>

            <!-- Main Content -->
            <div class="dashboard-content">
                <div class="row">
                    <section class="top-deals">
                        <div class="container">
                            <div class="section-title title-full">
                                <h2><?php echo isset($edit_package) ? 'Edit' : 'Add a New'; ?> <span>Subcategory</span></h2>
                            </div>

                            <!-- Add or Update Subcategory Form -->
                            <form action="subcategory.php" method="POST">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        // Fetch all categories from the database
                                        $query = mysqli_query($con, "SELECT * FROM category");
                                        while ($row = mysqli_fetch_array($query)) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo isset($edit_package) && $edit_package['categoryid'] == $row['id'] ? 'selected' : ''; ?>>
                                                <?php echo $row['categoryName']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subcategory">Subcategory Name</label>
                                    <input type="text" placeholder="Enter Subcategory Name" name="subcategory" class="form-control" required value="<?php echo isset($edit_package) ? htmlspecialchars($edit_package['subcategory']) : ''; ?>">
                                </div>

                                <input type="hidden" name="subcategory_id" value="<?php echo isset($edit_package) ? $edit_package['id'] : ''; ?>">

                                <button type="submit" class="btn btn-primary" name="<?php echo isset($edit_package) ? 'update' : 'submit'; ?>">
                                    <?php echo isset($edit_package) ? 'Update Subcategory' : 'Add Subcategory'; ?>
                                </button>
                            </form>
                        </div>
                    </section>

                    <section class="package-list">
                        <div class="container">
                            <div class="section-title title-full">
                                <h2>Manage <span>Subcategories</span></h2>
                            </div>

                            <table class="table table-bordered table-custom">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Subcategory Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch all subcategories and their associated categories
                                    $sql_subcategories = "SELECT subcategory.id, subcategory.subcategory, category.categoryName 
                                                          FROM subcategory 
                                                          JOIN category ON subcategory.categoryid = category.id";
                                    $result_subcategories = mysqli_query($con, $sql_subcategories);

                                    if (mysqli_num_rows($result_subcategories) > 0) {
                                        while ($subcategory = mysqli_fetch_assoc($result_subcategories)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($subcategory['categoryName']) . "</td>";
                                            echo "<td>" . htmlspecialchars($subcategory['subcategory']) . "</td>";
                                            echo "<td>
                                                    <a href='subcategory.php?edit_id=" . $subcategory['id'] . "' class='btn btn-warning'>Edit</a>
                                                    <a href='subcategory.php?del&id=" . $subcategory['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this subcategory?\")'>Delete</a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='no-data'>No subcategories available.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
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
