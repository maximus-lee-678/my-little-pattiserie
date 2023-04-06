<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=order-overview.php");
    exit;
}

// Function to sanitize inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$cart_id = sanitize_input($_POST['cart-id']);
$status = sanitize_input($_POST['status']);

$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
// Check connection
if ($conn->connect_error) {
    $displayText = "Connection failed: " . $conn->connect_error;
} else {
    // Prepare the statement: 
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE cart_id =?");
    // Bind & execute the query statement:
    $stmt->bind_param("ss", $status, $cart_id);
    if (!$stmt->execute()) {
        $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $displayText = $cart_id . " changed to '" . $status . "'!";
    }
    $stmt->close();
}
$conn->close();

echo $displayText;
?>
