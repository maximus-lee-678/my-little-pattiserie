<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=order-overview.php");
    exit;
}
?>

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

    // Function to sanitize inputs
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // If page is called to filter by name
    if ($_POST['cust-name'] != null) {
        $cust_name = sanitize_input($_POST['cust-name']);
        $cust_name = "%{$cust_name}%";

        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
        // Check connection
        if ($conn->connect_error) {
            $captionText = "Connection failed: " . $conn->connect_error;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("SELECT collect_date,collect_time,cust_name,cust_mobile,order_type,remarks,payment_mode,cart_id,status FROM orders WHERE cust_name LIKE ? AND NOT status='Collected' ORDER BY collect_date ASC");
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
                    "</td>\n<td>" . '<button type="button" id="status_' . $row["cart_id"] . '" class="btn btn-success btn-block prep-status">' . $row["status"] . '</button>' . "</tr>\n\n";
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
    }

    echo "<caption>" . $captionText . "</caption>";
    ?>