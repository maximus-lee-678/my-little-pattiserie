<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=staff-overview.php");
    exit;
}
?>

<table class="table table-sm" style="border-style:solid;">
    <tr>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-staffID">Staff ID</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-fname">First Name</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-lname">Last Name</button></th>
        <th scope="col"><button class="btn btn-light table-top" id="table-top-role">Role</button></th>
        <th scope="col"><p class="btn btn-static">View Info</p></th>
        <th scope="col"><p class="btn btn-static">Reset Password</p></th>
    </tr>

    <?php

    // Function to sanitize inputs
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $success = $errorMsg = "";

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
            $stmt = $conn->prepare("SELECT * FROM staff_details  WHERE active='YES' ORDER BY " . $order_by . " " . $direction);
            // execute the query statement:
            if (!$stmt->execute()) {
                $captionText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $captionText = "Retrieved " . $result->num_rows . " rows.";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["staffID"] .
                    "</td>\n<td>" . $row["fname"] .
                    "</td>\n<td>" . $row["lname"] .
                    "</td>\n<td>" . $row["role"] .
                    "</td>\n<td>" . '<button type="button" id="view_' . $row["staffID"] . '" class="btn btn-secondary view-details">View More...</button>' .
                    "</td>\n<td>" . '<button type="button" id="reset_' . $row["staffID"] . '" class="btn btn-secondary reset-password"><i class="bi bi-bootstrap-reboot"></i></button>' . "</tr>\n\n";
                }
            } else {
                $captionText = "Retrieved 0 rows.";
            }
            $stmt->close();
        }
        $conn->close();
    }
    // If page is called to filter by name
    else if ($_POST['staff-name'] != null) {
        $f_l_name = sanitize_input($_POST['staff-name']);
        $f_l_name = "%{$f_l_name}%";

        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
        // Check connection
        if ($conn->connect_error) {
            $captionText = "Connection failed: " . $conn->connect_error;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("SELECT * FROM staff_details WHERE (fname LIKE ? OR lname LIKE ?) AND active='YES'");
            // Bind & execute the query statement:
            $stmt->bind_param("ss", $f_l_name, $f_l_name);
            // execute the query statement:
            if (!$stmt->execute()) {
                $captionText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $captionText = "Retrieved " . $result->num_rows . " rows.";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["staffID"] .
                    "</td>\n<td>" . $row["fname"] .
                    "</td>\n<td>" . $row["lname"] .
                    "</td>\n<td>" . $row["role"] .
                    "</td>\n<td>" . '<button type="button" id="view_' . $row["staffID"] . '" class="btn btn-secondary view-details">View More...</button>' .
                    "</td>\n<td>" . '<button type="button" id="reset_' . $row["staffID"] . '" class="btn btn-secondary reset-password"><i class="bi bi-bootstrap-reboot"></i></button>' . "</tr>\n\n";
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
            $stmt = $conn->prepare("SELECT * FROM staff_details WHERE active='YES'");
            // execute the query statement:
            if (!$stmt->execute()) {
                $captionText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $result = $stmt->get_result();
            $captionText = "Retrieved " . $result->num_rows . " rows.";

            if ($result->num_rows > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["staffID"] .
                    "</td>\n<td>" . $row["fname"] .
                    "</td>\n<td>" . $row["lname"] .
                    "</td>\n<td>" . $row["role"] .
                    "</td>\n<td>" . '<button type="button" id="view_' . $row["staffID"] . '" class="btn btn-secondary view-details">View More...</button>' .
                    "</td>\n<td>" . '<button type="button" id="reset_' . $row["staffID"] . '" class="btn btn-secondary reset-password"><i class="bi bi-bootstrap-reboot"></i></button>' . "</tr>\n\n";
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