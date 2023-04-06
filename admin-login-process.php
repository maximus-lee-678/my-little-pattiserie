<?php
session_start();
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=admin-login.php");
    exit;
}
//Functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

    $staffID = sanitize_input($_POST['staffID']);
    $password = $_POST['password'];

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $error_msg = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM staff_details WHERE active='YES' AND staffID=?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $staffID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Note that email field is unique, so should only have
            // one row in the result set.
            $row = $result->fetch_assoc();

            $password_hashed = $row["password"];
            // Check if the password matches:
            if (!password_verify($password, $password_hashed)) {
                // Don't be too specific with the error message - hackers don't
                // need to know which one they got right or wrong. :)
                $error_msg = "Email not found or password doesn't match.";
            } else {
                $_SESSION['role'] = $row['role'];
                $_SESSION['staffID'] = $row['staffID'];
            }
        } else {
            $error_msg = "Email not found or password doesn't match.";
        }
        $stmt->close();
    }
    $conn->close();

if (isset($error_msg)) {
    $_SESSION['error_msg'] = $error_msg;
    header("refresh: 0; url=admin-login.php");
    exit;
} else {
    header("refresh: 0; url=order-overview.php");
    exit;
}
?>