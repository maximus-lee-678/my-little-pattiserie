<?php

if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=create-new-staff.php");
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

$staffID = sanitize_input($_POST['staffID']);
$fname = sanitize_input($_POST['fname']);
$lname = sanitize_input($_POST['lname']);
$role = "Staff";
$password = password_hash("default", PASSWORD_DEFAULT);
$active = "YES";

$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
// Check connection
if ($conn->connect_error) {
    $displayText = "Connection failed: " . $conn->connect_error;
} else {
    $stmt = $conn->prepare("INSERT INTO staff_details (staffID, fname, lname, role, password, created_date, active) VALUES ( ?,?,?,?,?, date_format(curdate(), '%d %M %Y'),?)");
//Bind & execute the query statement: 
    $stmt->bind_param("ssssss", $staffID, $fname, $lname, $role, $password, $active);
    if (!$stmt->execute()) {
        $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $displayText = $staffID . " successfully created!";
    }
    $stmt->close();
}
$conn->close();

echo $displayText;
?>