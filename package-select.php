    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $contact = $_POST["phone"];
        $package = $_POST["selected_package"];
        $price = $_POST["selected_price"];
        $tourdate = $_POST["tourdate"];


        $sql5 = "INSERT INTO `query` (`name`, `phone`, `email`, `package`, `price`,`tourdate`, `date`) VALUES ('$name', '$contact', '$email', '$package', '$price',DATE('$tourdate'), current_timestamp())";
        $result5 = mysqli_query($con, $sql5);
    }
    ?>
    <!-- select form  -->
    <style>
        .lisc {
            padding: 39px;
            border: 1px solid #cdcdcd;
            border-radius: 10px;
            box-shadow: 10px 10px 10px 10px #f2efef75 !important;
        }

        .neha-head {
            border-left: 3px solid blue;
        }

        .strn {
            padding: 37px;
            box-shadow: -1px 2px 10px #f0ecec;
            border-radius: -5px;
            padding-top: 29px;
            display: inline-block;
            width: 100%;
            background: #68cfff0d;
            color: black;
        }

        .col-nn h6 {
            font-size: 28px !important;
        }

        .col-nn {
            padding-left: 10px;
        }

        .rl {
            display: flex;
            justify-content: space-around;
        }
    </style>

    <div class="container mt-3 ">
        <?php

        $sql3 = "SELECT * FROM `package` WHERE productid = '$pid'";
        $result3 = mysqli_query($con, $sql3);
        if (mysqli_num_rows($result3) > 0) {
            echo '<div class="row">
        <h5 class="neha-head pt-1 pb-1 mb-3">Select Packages</h5>
    </div>';

            while ($row3 = mysqli_fetch_assoc($result3)) {
                $pkg = $row3['package'];
                $prc = $row3['price'];
                echo '<div class="col-md-8">
            <div class="row strn mb-2">
           <div class="rl">
                <div class="col-nn mt-2">
                    <input type="radio" name="package" data-toggle="modal" data-target="#batch5" onchange="updateForm(\'' . htmlentities($pkg) . '\', \'' . htmlentities($prc) . '\')">
                </div>
                <div class="col-nn">
                    <h5>' . $pkg . '</h5>
                </div>
                <div class="col-nn">
                    <h5>₹' . $prc . '</h5>
                </div>
           </div>
            </div>
        </div>';
            }
        }
        ?>
    </div>
    </div>
    <style>
        input[type="radio"] {
            display: grid;
            place-content: center;
            appearance: none;
            margin: 10% 0 0;
            width: 2rem;
            height: 2rem;
            align-items: center;
            background-color: #fff;
            border-radius: 46px;
            border: 1px solid #31a9e1;
        }

        .form-setter {
            padding: 10px;
        }

        input[type="radio"]:checked {
            background-color: #31a9e1;
        }

        input[type=submit]:hover {
            background-color: white;
            color: #31a9e1;

        }

        input[type=submit] {
            background-color: #31a9e1;
            color: white;

        }

        .radio {
            grid-template-columns: 1rem auto;
            gap: 0.5rem;
            background-color: hsl(183, 100%, 15%);
        }
    </style>
    <!-- select form  -->
    <div class="container">
        <div class="modal" id="batch5">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="inq">Fill Query Form For Selected Package</h5>
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 form-setter" method="post" action="package-submit.php">
                            <div class="input-group mb-3 fil">
                                <input type="text" class="form-control" name="name" placeholder="Your Name" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 fil">
                                <input type="number" class="form-control" name="phone" placeholder="Phone No." aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 fil">
                                <input type="email" class="form-control" name="email" placeholder="Email" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 fil">
                                <input type="text" class="form-control" name="selected_package" id="selected_package" placeholder="Selected Package" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 fil">
                                <input type="text" class="form-control" name="selected_price" id="selected_price" placeholder="Selected Price" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3 fil">
                                <input type="submit" class="form-control bts" name="submit" value="Submit Enquiry" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
   

    <script>
        // JavaScript function to update form fields with selected package and price
        function updateForm(packageName, price) {
            document.getElementById('selected_package').value = packageName;
            document.getElementById('selected_price').value = price;
        }
    </script>