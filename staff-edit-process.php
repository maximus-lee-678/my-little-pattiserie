<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=staff-overview.php");
    exit;
}

// Functions
// Function to sanitize inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<?php
// For when staff is to be updated
if (isset($_POST['submit'])) {
    $staffID = sanitize_input($_POST['submit']);
    $fname = sanitize_input($_POST['fname']);
    $lname = sanitize_input($_POST['lname']);
    $role = sanitize_input($_POST['role']);

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $displayText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement: 
        $stmt = $conn->prepare("UPDATE staff_details SET fname=?, lname=?, role=? WHERE staffID=?");
        // Bind & execute the query statement:
        $stmt->bind_param("ssss", $fname, $lname, $role, $staffID);
        if (!$stmt->execute()) {
            $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $displayText = $staffID . " successfully updated!";
        }
        $stmt->close();
    }
    $conn->close();

    echo $displayText;
}

// For when staff is to be disabled
if (isset($_POST['delete'])) {
    $staffID = sanitize_input($_POST['delete']);

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $displayText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement: 
        $stmt = $conn->prepare("UPDATE staff_details SET active='NO' WHERE staffID=?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $staffID);
        if (!$stmt->execute()) {
            $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $displayText = $staffID . " successfully updated!";
        }
        $stmt->close();
    }
    $conn->close();

    echo $displayText;
}

// For when staff password is to be reset
if (isset($_POST['reset'])) {
    $staffID = sanitize_input($_POST['reset']);
    $password = password_hash("default", PASSWORD_DEFAULT);

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $displayText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement: 
        $stmt = $conn->prepare("UPDATE staff_details SET password=? WHERE staffID=?");
        // Bind & execute the query statement:
        $stmt->bind_param("ss", $password, $staffID);
        if (!$stmt->execute()) {
            $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $displayText = $staffID . "'s password successfully reset!";
        }
        $stmt->close();
    }
    $conn->close();

    echo $displayText;
}
?>