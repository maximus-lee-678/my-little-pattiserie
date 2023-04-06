<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=order-overview-historic.php");
    exit;
}
?>

<table class="table table-sm" style="border-style:solid;">
    <tr>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-collect_date">Collect Date</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-collect_time">Collect Time</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-cust_name">Customer Name</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-cust_mobile">Customer Mobile</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-order_type">Order Type</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-remarks">Remarks</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-payment_mode">Payment Mode</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-cart_id">View Cart</button></th>
        <th scope="col"><p class="btn btn-static">Status</p></th>
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
            $stmt = $conn->prepare("SELECT collect_date,collect_time,cust_name,cust_mobile,order_type,remarks,payment_mode,cart_id,status FROM orders WHERE status='Collected' ORDER BY " . $order_by . " " . $direction);
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
                    "</td>\n<td>" . $row['status'] . "</tr>\n\n";
                }
            } else {
                $captionText = "Retrieved 0 rows.";
            }
            $stmt->close();
        }
        $conn->close();
    }
    // If page is called to filter by name
    else if ($_POST['cust-name'] != null) {
        $cust_name = sanitize_input($_POST['cust-name']);
        $cust_name = "%{$cust_name}%";

        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
        // Check connection
        if ($conn->connect_error) {
            $captionText = "Connection failed: " . $conn->connect_error;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("SELECT collect_date,collect_time,cust_name,cust_mobile,order_type,remarks,payment_mode,cart_id,status FROM orders WHERE status='Collected' AND cust_name LIKE ? ORDER BY collect_date ASC");
            // Bind & execute the query statement:
            $stmt->bind_param("s", $cust_name);
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
                    "</td>\n<td>" . $row['status'] . "</tr>\n\n";
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
            $stmt = $conn->prepare("SELECT collect_date,collect_time,cust_name,cust_mobile,order_type,remarks,payment_mode,cart_id,status FROM orders WHERE status='Collected' ORDER BY collect_date ASC");
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
                    "</td>\n<td>" . $row['status'] . "</tr>\n\n";
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
