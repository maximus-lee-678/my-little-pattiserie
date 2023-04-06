<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=view-all-products.php");
    exit;
}
?>

<table class="table table-sm" style="border-style:solid;">
    <tr>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-products_id">ID</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-item_name">Item Name</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-price">Price($)</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-category">Category</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-sub_category">Subcategory</button></th>
        <th scope="col"><p class="btn btn-static">View Info</p></th>
        <th scope="col"><p class="btn btn-static"><i class="bi bi-images"></i></p></th>
    </tr>

    <?php

    // Function to sanitize inputs
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // If page is called to sort
    if (($_POST['sort-by']) != null && ($_POST['direction']) != null) {

        $order_by = sanitize_input($_POST["sort-by"]);
        $direction = sanitize_input($_POST["direction"]);

        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
        // Check connection
        if ($conn->connect_error) {
            $captionText = "Connection failed: " . $conn->connect_error;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("SELECT * FROM products WHERE active='YES' ORDER BY " . $order_by . " " . $direction);
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
    }
    // If page is called to filter by name
    else if ($_POST['item-name'] != null) {
        $item_name = sanitize_input($_POST['item-name']);
        $item_name = "%{$item_name}%";

        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
        // Check connection
        if ($conn->connect_error) {
            $captionText = "Connection failed: " . $conn->connect_error;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("SELECT * FROM products WHERE active='YES' AND item_name LIKE ?");
            // Bind & execute the query statement:
            $stmt->bind_param("s", $item_name);
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
    }
    // Refresh Table with no filter
    else {
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
    }

    echo "<caption>" . $captionText . "</caption>";
    ?>

</table>
