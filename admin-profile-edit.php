<?php
session_start();
if ($_SESSION['role'] != "Manager" && $_SESSION['role'] != "Staff") {
    header("refresh: 0; url=admin-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Little Patisserie</title>


        <!--jQuery-->
        <script
            defer
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"
        ></script>

        <!--Bootstrap JS-->
        <script
            defer
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
            integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
            crossorigin="anonymous"
        ></script>

        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
            crossorigin="anonymous"
            />

        <!-- CSS -->
        <link rel="stylesheet" href="./assets/css/main.css" />
        <link rel="stylesheet" href="./assets/css/max.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;500&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap">

        <!-- JS -->
        <script defer src="./assets/js/admin-others.js"></script>

    </head>

    <?php
    $staffID = $_SESSION['staffID'];
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $captionText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM staff_details WHERE active='YES' AND staffID=?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $staffID);
        // execute the query statement:
        if (!$stmt->execute()) {
            $captionText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $fname = $row['fname'];
            $lname = $row['lname'];
            $mobile = $row['mobile'];
            $email = $row['email'];
        } else {
            $captionText = "Staff not found!";
        }
        $stmt->close();
    }
    $conn->close();
    ?>

    <body>
        <!-- Navbar -->
        <?php 
        if ($_SESSION['role'] == "Manager"){
            include "./includes/nav-inc-manager.php";
        }
        else{
            include "./includes/nav-inc-staff.php";
        }  
        ?>

        <?php
        if (isset($captionText)) {
            echo "<main class=\"container\"><div><h1>" . $captionText . "</h1></div></main>";
            include "./includes/footer-inc-admin.php";
            exit;
        }
        ?>

        <main class="container">
            <h1>Edit Credentials</h1>
            <?php
            if (isset($_SESSION["outcome"])) {
                echo "<p>" . $_SESSION["outcome"] . "</p>";
                unset($_SESSION["outcome"]);
            }
            ?>
            <form action="admin-profile-edit-process.php" onsubmit="return confirm('Are you sure?');" method="post">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input class="form-control" id="fname" value="<?php echo $fname; ?>" maxlength="45" 
                           required name="fname" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input class="form-control" id="lname" value="<?php echo $lname; ?>" maxlength="45" 
                           required name="lname" placeholder="Enter Last Name">
                </div>
                <div class="form-group"> 
                    <label for="mobile">Mobile:</label>
                    <input class="form-control" id="mobile" type="tel" pattern="[0-9]{8}" value="<?php echo $mobile; ?>"
                           name="mobile" placeholder="xxxxxxxx">
                </div>
                <div class="form-group"> 
                    <label for="email">Email:</label>
                    <input class="form-control" id="email" type="email" value="<?php echo $email; ?>"  maxlength="45" 
                           name="email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <a class="btn btn-outline-primary" id="change-password-button">Change Password</a>
                </div>
                <div class="form-group password-divs" hidden>
                    <label for="password-current">Current Password:</label>
                    <input class="form-control password-fields" type="password" id="password-current" maxlength="225" 
                           name="password-current" placeholder="Enter Current Password">
                </div>
                <div class="form-group password-divs" hidden>
                    <label for="password-new">New Password:</label>
                    <input class="form-control password-fields" type="password" id="password-new" maxlength="225" 
                           name="password-new" placeholder="Enter New Password">
                </div>
                <div class="form-group password-divs" hidden>
                    <label for="password-new-confirm">Confirm New Password:</label>
                    <input class="form-control password-fields" type="password" id="password-new-confirm" maxlength="225" 
                           name="password-new-confirm" placeholder="Confirm New Password">
                </div>
                <div class="form-group password-divs" hidden>
                    <a class="btn btn-outline-danger" id="discard-password-button">Cancel Password Change</a>
                </div>
                <div class="form-group">
                    <button class="btn btn-secondary" type="submit" id="submit-button" name="submit" value="no-password" href="admin-profile-edit-process.php">Submit</button>
                </div>
            </form>
        </main>

        <?php include "./includes/footer-inc-admin.php" ?>

    </body>
</html>