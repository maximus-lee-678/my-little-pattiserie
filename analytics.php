<?php
session_start();
if ($_SESSION['role'] != "Manager") {
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
        <script defer src="./assets/js/sales.js"></script>

    </head>

    <body>
        <!-- Navbar -->
        <?php include "./includes/nav-inc-manager.php" ?>

        <div id="selection-span">
            <div class="chart-divs">
                <label for="month-year">Choose Month or Year:</label>
                <select name="month-year" id="month-year-selector">
                    <option selected disabled>Select..</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <div id="month-div" hidden>
                <label for="month">Select Month:</label>
                <input type="month" id="month-selected" name="month" min="2021-01" value="2021-01">
            </div>
            <div id="year-div" hidden>
                <label for="year">Select Year:</label>
                <input type="number" id="year-selected" name="year" min="2021" max="2099" step="1" value="2021" />
            </div> 
            <div id="submit-div" hidden>
                <button class="btn btn-light" id="submit-button">Go!</button>
            </div> 
        </div>
        <br>
        <div id="chart-div">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>

        <?php include "./includes/footer-inc-admin.php" ?>
    </body>
</html>