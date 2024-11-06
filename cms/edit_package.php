<?php
include('include/config.php');

if (isset($_GET['id'])) {
    $package_id = intval($_GET['id']);
    $sql = "SELECT * FROM tour_packages WHERE id = $package_id";
    $result = mysqli_query($con, $sql);
    $package = mysqli_fetch_assoc($result);
    
    if (!$package) {
        echo "Package not found!";
        exit;
    }
} else {
    echo "Invalid package ID!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $image_url = $package['image_url'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $uploadFolder = 'uploads/';
        if (!is_dir($uploadFolder)) mkdir($uploadFolder, 0777, true);
        $image_url = $uploadFolder . $imageName;
        move_uploaded_file($imageTmpName, $image_url);
    }

    $sql_update = "UPDATE tour_packages SET title='$title', image_url='$image_url' WHERE id=$package_id";
    if (mysqli_query($con, $sql_update)) {
        header("Location: holidaytheam.php");
    } else {
        echo "Error updating package: " . mysqli_error($con);
    }
}
?>

<form action="edit_package.php?id=<?php echo $package_id; ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Package Title</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($package['title']); ?>" required>

    <label for="image">Image</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Update Package</button>
</form>
