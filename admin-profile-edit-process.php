<?php
session_start();

if ($_SESSION['role'] != "Manager" && $_SESSION['role'] != "Staff") {
    header("refresh: 0; url=admin-login.php");
    exit;
}

// Function to sanitize inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$staffID = $_SESSION["staffID"];
$fname = sanitize_input($_POST['fname']);
$lname = sanitize_input($_POST['lname']);
$mobile = sanitize_input($_POST['mobile']);
$email = sanitize_input($_POST['email']);

$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
// Check connection
if ($conn->connect_error) {
    $displayText .= "Connection failed: " . $conn->connect_error;
} else {
    // Prepare the statement: 
    $stmt = $conn->prepare("UPDATE staff_details SET fname=?, lname=?, mobile=?, email=? WHERE staffID=?");
    // Bind & execute the query statement:
    $stmt->bind_param("sssss", $fname, $lname, $mobile, $email, $staffID);
    if (!$stmt->execute()) {
        $displayText .= "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $displayText .= $staffID . " successfully updated! ";
    }
    $stmt->close();
}
$conn->close();

if ($_POST['submit'] == "yes-password") {
    $password_current = $_POST["password-current"];
    $password_new = $_POST["password-new"];
    $password_new_confirm = $_POST["password-new-confirm"];

    if ($password_new == $password_new_confirm) {
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
// Check connection
        if ($conn->connect_error) {
            $displayText .= "Connection failed: " . $conn->connect_error;
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
                if (!password_verify($password_current, $password_hashed)) {
                    $displayText .= "Current password is incorrect!";
                } else {
                    // Prepare the statement: 
                    $stmt = $conn->prepare("UPDATE staff_details SET password=? WHERE staffID=?");
                    // Bind & execute the query statement:
                    $stmt->bind_param("ss", password_hash($password_new, PASSWORD_DEFAULT), $staffID);
                    if (!$stmt->execute()) {
                        $displayText .= "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    } else {
                        $displayText .= "Password successfully updated!";
                    }
                }
            }
            $stmt->close();
        }
        $conn->close();
    } else {
        $displayText .= "Passwords do not match!";
    }
}

$_SESSION['outcome'] = $displayText;
header("refresh: 0; url=admin-profile-edit.php");
?>