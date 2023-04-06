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
        <script defer src="./assets/js/products.js"></script>

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
            $stmt = $conn->prepare("SELECT * FROM products WHERE active='YES'");
            // execute the query statement:
            if (!$stmt->execute()) {
                $captionText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $captionText = "Retrieved " . $result->num_rows . " rows.";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["products_id"] .
                    "</td>\n<td>" . $row["item_name"] .
                    "</td>\n<td>" . $row["price"] .
                    "</td>\n<td>" . $row["category"] .
                    "</td>\n<td>" . $row["sub_category"] .
                    "</td>\n<td>" . '<button type="button" id="view_' . $row["products_id"] . '" class="btn btn-secondary view-details">View Info</button>' .
                    "</td>\n<td>" . '<button type="button" id="file_' . $row["products_id"] . "_" . $row["item_name"] . '" class="btn btn-secondary image-upload"><i class="bi bi-upload"></i></button>' . "</tr>\n\n";
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
        <?php include "./includes/nav-inc-manager.php" ?>

        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content: space-evenly;">
            <div>
                <a class="btn btn-secondary" id="new-product-button" href="create-new-product.php">Add new Product</a>
            </div>
            <div>
                <input type="text" id="search-field" placeholder="Search Item Name" name="search">
            </div>
            <div id="stdout" style="border-style: groove; text-align: center; padding: 0px 5px 0px 5px; min-width:300px; min-height:28.8px;">            
                <?php
                if (isset($_SESSION["passed_stdout"])) {
                    echo $_SESSION["passed_stdout"];
                    unset($_SESSION["passed_stdout"]);
                }
                else{
                    echo "Welcome, " .  $_SESSION["staffID"] . ".";
                }
                ?>
            </div>
        </div>
        <div id="table-contents" style="padding:35px; overflow-x:auto;">

            <table class="table table-sm" style="border-style:solid;">
                <tr>
                    <th scope="col"><button class="btn btn-light table-top" id="table-top-products_id">ID<i class="bi bi-arrow-up"></i></button></th>
                    <th scope="col"><button class="btn btn-light table-top" id="table-top-item_name">Item Name</button></th>
                    <th scope="col"><button class="btn btn-light table-top" id="table-top-price">Price($)</button></th>
                    <th scope="col"><button class="btn btn-light table-top" id="table-top-category">Category</button></th>
                    <th scope="col"><button class="btn btn-light table-top" id="table-top-sub_category">Subcategory</button></th>
                    <th scope="col"><p class="btn btn-static">View Info</p></th>
                    <th scope="col"><p class="btn btn-static"><i class="bi bi-images"></i></p></th>
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