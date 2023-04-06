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
        <script defer src="./assets/js/orders.js"></script>

    </head>

    <?php

    // Displays all active products (This function is always called)
    function populateTables() {
        global $captionText;

        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
        // Check connection
        if ($conn->connect_error) {
            $captionText = "Connection failed: " . $conn->connect_error;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("SELECT collect_date,collect_time,cust_name,cust_mobile,order_type,remarks,payment_mode,cart_id,status FROM orders WHERE NOT status='Collected' ORDER BY collect_date ASC");
            // execute the query statement:
            if (!$stmt->execute()) {
                $captionText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $captionText = "Retrieved " . $result->num_rows . " rows.";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["collect_date"] .
                    "</td>\n<td>" . $row["collect_time"] .
                    "</td>\n<td>" . $row["cust_name"] .
                    "</td>\n<td>" . $row["cust_mobile"] .
                    "</td>\n<td>" . $row["order_type"] .
                    "</td>\n<td>" . $row["remarks"] .
                    "</td>\n<td>" . $row["payment_mode"] .
                    "</td>\n<td>" . '<button type="button" id="cart_' . $row["cart_id"] . '" class="btn btn-info view-cart">#' . $row["cart_id"] . '</button>' .
                    "</td>\n<td>" . '<button type="button" id="status_' . $row["cart_id"] . '" class="btn btn-success btn-block prep-status">' . $row["status"] . '</button>' . "</tr>\n\n";
                }
            } else {
                $captionText = "Retrieved 0 rows.";
            }
            $stmt->close();
        }
        $conn->close();
        echo "<caption>" . $captionText . "</caption>";
    }
    ?>

    <body>
        <!-- Navbar -->
        <?php
        if ($_SESSION['role'] == "Manager") {
            include "./includes/nav-inc-manager.php";
        } else {
            include "./includes/nav-inc-staff.php";
        }
        ?>

        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content: space-evenly;">
            <div>
                <a class="btn btn-secondary" id="view-historic-orders" href="order-overview-historic.php">View Historic Orders</a>
            </div>
            <div>
                <input type="text" id="search-field" placeholder="Search Customer Name" name="search">
            </div>
            <div id="stdout" style="border-style: groove; text-align: center; padding: 0px 5px 0px 5px; min-width:300px; min-height:28.8px;">            
                <?php
                if (isset($_SESSION["passed_stdout"])) {
                    echo $_SESSION["passed_stdout"];
                    unset($_SESSION["passed_stdout"]);
                } else {
                    echo "Welcome, " . $_SESSION["staffID"] . ".";
                }
                ?>
            </div>
        </div>
        <div id="table-contents" style="padding:35px; overflow-x:auto;">

            <table class="table table-sm" style="border-style:solid;">
                <tr>
                    <th scope="col"><p class="btn btn-static">Collect Date</p></button></th>
                    <th scope="col"><p class="btn btn-static">Collect Time</p></th>
                    <th scope="col"><p class="btn btn-static">Customer Name</p></th>
                    <th scope="col"><p class="btn btn-static">Customer Mobile</p></th>
                    <th scope="col"><p class="btn btn-static">Order Type</p></th>
                    <th scope="col"><p class="btn btn-static">Remarks</p></th>
                    <th scope="col"><p class="btn btn-static">Payment Mode</p></th>
                    <th scope="col"><p class="btn btn-static">View Cart</p></th>
                    <th scope="col"><p class="btn btn-static">Status (Click to Progress)</p></th>
                </tr>

                <?php
                populateTables();
                ?>

            </table>
        </div>
        <div id="overlay"></div>
        <span class="view-popup" id="edit-popup" hidden></span>
        <?php include "./includes/footer-inc-admin.php" ?>

    </body>
</html>