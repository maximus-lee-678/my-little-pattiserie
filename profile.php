<!-- Head -->
<?php include "./includes/header.inc.php" ?>
<?php
if (!isset($_SESSION["member_id"])) {
    header("location: ./index.php?error=accessdenied");
    exit();
}

$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

if (!$conn) {
    header("location: ../index.php?error=sqlconnfailed");
    die("Connection failed: " . mysqli_connect_error());
}
require_once "./includes/functions.inc.php";

$sql = "SELECT * FROM ICT1004_Project.members WHERE member_id = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ./index.php?error=stmtfailed1");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["member_id"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        header("location: ./index.php?error=stmtfailed");
        exit();
    } else {
        $fname = $row["fname"];
        $lname = $row["lname"];
        $email = $row["email"];
        $mobile = $row["mobile"];
        $points = $row["points"];
        if ($points == 0) {
            $points = 0;
        }
    }
}


$sql = "SELECT * FROM ICT1004_Project.orders WHERE cust_id = ?;";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ./index.php?error=stmtfailed");
    exit();
} else {
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["member_id"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>

<body>
    <!-- Navbar -->
    <?php include"./includes/nav.inc.php" ?>

    <main>
        <div class="container">
            <!-- Profile Page -->
            <section class="profile-page my-5">
                <div class="section-title">
                    <h2>Welcome back, <?php echo $fname ?>!</h2>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "updated") {
                            echo "<div class='alert alert-success alert-dismissible col-lg-30'>";
                            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                            echo "Your profile has been updated!</div>";
                        } else if ($_GET["error"] == "incorrectpassword") {
                            echo "<div class='alert alert-warning alert-dismissible col-lg-30'>";
                            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                            echo "Invalid Current Password!</div>";
                        }
                    }
                    ?>
                </div>

                <div id="accordion">
                    <div class="card">
                        <div class="card-header text-center" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Profile Details
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <form action="./includes/update-profile.inc.php" method="post">
                                    <div class="container">
                                        <div class="form-row px-5">
                                            <div class="form-group col-md-6">
                                                <label for="fname">First Name: </label>
                                                <input type="text" name="fname" required maxlength="45" value="<?php echo $fname ?>" disabled class="form-control my-1 p-2 editable">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="fname">Last Name: </label>
                                                <input type="text" name="lname" maxlength="45" value="<?php echo $lname ?>" disabled class="form-control my-1 p-2 editable">
                                            </div>
                                        </div>

                                        <div class="form-row px-5">
                                            <div class="form-group col-md-6">
                                                <label for="fname">Email Address: </label>
                                                <input type="email" name="email" required maxlength="45" value="<?php echo $email ?>" disabled class="form-control my-1 p-2">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fname">Phone Number: </label>
                                                <input type="number" name=tel required min="60000000" max="99999999" required value="<?php echo $mobile ?>" disabled class="form-control my-1 p-2 editable">
                                            </div>
                                        </div>

                                        <div class="form-row px-5">
                                            <div class="form-group col-md-6">
                                                <label for="points">Points: </label>
                                                <input type="text" name="points" required maxlength="10" value="<?php echo $points ?>" disabled class="form-control my-1 p-2">
                                            </div>
                                        </div>

                                        <div class="form-row px-5">
                                            <div class="form-group col-md-6">
                                                <button type="button" name="edit" id="edit-changes" class="btn1 mt-3">Edit Details</button>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <button type="submit" name="submit" class="btn1 mt-3">Confirm Changes</button>
                                            </div>
                                        </div>

                                    </div>  

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header text-center" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Change Password
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <form action="./includes/change-password.inc.php" method="post">
                                    <div class="container">
                                        <div class="form-row px-5">
                                            <div class="form-group col-md-6">
                                                <label for="pwd">New Password: </label>
                                                <input type="password" name="pwd" required minlength="8" maxlength="45" placeholder="New Password" class="form-control my-1 p-2">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="cfmPwd">Confirm Password: </label>
                                                <input type="password" name="cfmPwd" minlength="8" maxlength="45" placeholder="Confirm Password" class="form-control my-1 p-2">
                                            </div>
                                        </div>

                                        <div class="form-row px-5">
                                            <div class="form-group col-md-6">
                                                <label for="currentPwd">Current Password: </label>
                                                <input type="password" name="currentPwd" required minlength="8" maxlength="45" placeholder="Current Password" class="form-control my-1 p-2">
                                            </div>
                                        </div>

                                        <div class="form-row px-5">
                                            <div class="form-group col-md">
                                                <button type="submit" name="submit" class="btn1 mt-3">Change Password</button>
                                            </div>
                                        </div>

                                    </div>  

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header text-center" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Order History
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Order ID</th>
                                                <th scope="col">Total Cost</th>
                                                <th scope="col">Points Accumulated</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                                <tr id="<?php echo $row["cart_id"]; ?>">
                                                    <td><?php echo $row["order_date"]; ?></td>
                                                    <td><?php echo $row["order_id"]; ?></td>
                                                    <td>$<?php echo $row["grand_total"]; ?></td>
                                                    <td><?php echo $row["points_rewarded"]; ?></td>

                                                </tr>
                                                <?php
                                            }
                                            mysqli_stmt_close($stmt);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <?php include "./includes/footer.inc.php" ?>

</body>
</html>


