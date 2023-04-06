<?php
session_start();

if ($_SESSION['role'] == "Manager" || $_SESSION['role'] == "Staff") {
    header("refresh: 0; url=order-overview.php");
    exit;
}
?>

<!DOCTYPE html>
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

    <!-- Charts.js -->
    <script 
        defer
    src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

</head>

<html lang="en">
    <body>
        <main>
            <!-- Login Form -->
            <section class="login-form my-5">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="cover-photo col-lg-5">
                            <img src="./assets/img/login.jpg" class="img-fluid" alt="Cinammon Rolls">
                        </div>
                        <div class="col-lg-7 px-5 py-5">
                            <h4>Administrator Login</h4>
                            <form action="admin-login-process.php" method="post">
                                <div class="form-row">
                                    <div class="col-lg-10">
                                        <input class="form-control" type="staffID" id="staffID" maxlength="45"
                                               required name="staffID" placeholder="Enter Staff ID">
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-lg-10">
                                        <input class="form-control" type="password" id="password" maxlength="225"
                                               required name="password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-10">
                                        <button type="submit" name="submit" class="btn1 mt-3 mb-5">Login</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                            if (isset($_SESSION["error_msg"])) {
                                echo "<p>" . $_SESSION["error_msg"] . "</p>";
                                unset($_SESSION["error_msg"]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
