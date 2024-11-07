<?php
// Query to fetch team members from the database
$sql_team_members = "SELECT * FROM members";
$result_team_members = mysqli_query($con, $sql_team_members);
?>

<section class="tour-agent tour-agent1">
    <div class="container">
        <div class="row display-flex">
            <div class="col-md-4 col-xs-12">
                <div class="section-title title-full width100">
                    <h2 class="white">Yaarana Holidays & Team</h2>
                    <p class="white mar-0">Travel experts at your service, crafting experiences that make every trip extraordinary and memorable.</p>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="agent-main">
                    <div class="row team-slider">
                        <?php
                        // Check if there are any members in the database
                        if (mysqli_num_rows($result_team_members) > 0) {
                            while ($member = mysqli_fetch_assoc($result_team_members)) {
                                // Fetch the name, role, and image path for each member
                                $name = htmlspecialchars($member['name']);

                                $image_path = 'cms/' . htmlspecialchars($member['image_path']);
                        ?>
                        <div class="col-md-4">
                            <div class="agent-list">
                                <div class="agent-image">
                                    <!-- Display the member's image -->
                                    <img src="<?php echo $image_path; ?>" alt="<?php echo $name; ?>">
                                    <div class="agent-content">
                                        <h3 class="white mar-bottom-5"><?php echo $name; ?></h3>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "<p class='white'>No team members available at the moment.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
