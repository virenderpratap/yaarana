<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{
    date_default_timezone_set('Asia/Kolkata'); // change according to timezone
    $currentTime = date('d-m-Y h:i:s A', time());
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editable Deal Section</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/plugin.css" rel="stylesheet" type="text/css">
    <!--Icons CSS-->
    <link href="css/icons.css" rel="stylesheet" type="text/css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Editable Styles */
        .editable-title, .editable-subtitle {
            cursor: pointer;
            padding: 5px;
            border: 1px dashed transparent;
        }

        .editable-title:hover, .editable-subtitle:hover {
            border-color: #007bff;
            background-color: #f1f1f1;
        }

        .deal-img img {
            max-width: 100%;
            height: auto;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="container-wrapper">
        <div id="dashboard">

            <div class="dashboard-content">
                <div class="row">
                    <section class="top-deals">
                        <div class="container">
                            <div class="section-title title-full">
                                <h2 class="mar-0">Today's <span>Top Deals</span></h2>
                            </div>
                            <div class="row top-deal-slider">
                                <div class="col-md-4 slider-itemm">
                                    <div class="dealx">
                                        <div class="one">
                                            <!-- Editable Title -->
                                            <div class="editable-title" contenteditable="true">Diwali Sale On</div>
                                            <!-- Editable Subtitle -->
                                            <div class="editable-subtitle" contenteditable="true">Summer Tour Packages</div>
                                        </div>
                                        <div class="two">
                                            <div class="deal-img">
                                                <!-- Editable Image -->
                                                <img src="./images/package/malaysia.webp" alt="Deal Image" class="editable-image" data-image="malaysia.webp">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Upload Modal -->
    <div class="modal" id="imageUploadModal" tabindex="-1" role="dialog" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageUploadModalLabel">Upload New Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="imageUploadForm" enctype="multipart/form-data">
                        <input type="hidden" id="imageFileName" name="imageFileName">
                        <div class="form-group">
                            <label for="newImage">Choose Image</label>
                            <input type="file" class="form-control-file" id="newImage" name="newImage" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Make image editable and trigger image upload modal on click
            $('.editable-image').on('click', function() {
                var imageName = $(this).data('image');
                $('#imageFileName').val(imageName); // Set current image name in the hidden field
                $('#imageUploadModal').modal('show'); // Show image upload modal
            });

            // Handle image upload form submission
            $('#imageUploadForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: 'upload_image.php', // Backend PHP script to handle image upload
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        alert('Image uploaded successfully!');
                        $('#imageUploadModal').modal('hide');
                        location.reload(); // Reload to show the updated image
                    },
                    error: function() {
                        alert('Error uploading image!');
                    }
                });
            });

        });
    </script>
</body>
</html>

<?php } ?>
