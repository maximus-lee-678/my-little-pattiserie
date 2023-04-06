<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=analytics.php");
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

$month_names = array("January", "February", "March",
    "April", "May", "June",
    "July", "August", "September",
    "October", "November", "December"
);

// Month was sent, meaning user has requested for month data
if (isset($_POST['month'])) {
    $month = sanitize_input($_POST['month']);
    $year = sanitize_input($_POST['year']);
    $sql_month = "%{$month_names[$month - 1]}%";
    $sql_year = "%{$year}%";
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $count_per_day = array_fill(0, $days_in_month, 0);

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $displayText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT left(order_date, locate(':',order_date)-1) AS day, sum(grand_total) AS sum FROM orders WHERE order_date LIKE ? AND order_date LIKE ? group by day;");
        // Bind & execute the query statement:
        $stmt->bind_param("ss", $sql_month, $sql_year);
        // execute the query statement:
        $stmt->execute();
        if (!$stmt->execute()) {
            $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result = $stmt->get_result();
        $displayText = "Retrieved " . $result->num_rows . " rows.";

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            for ($i = 0; $i < $days_in_month; $i++){
                if($row['day'] == $i+1){
                    $count_per_day[$i] = $row['sum'];
                    $row = mysqli_fetch_assoc($result);
                }
            }
        } else {
            $displayText = "Retrieved 0 rows.";
        }
        $stmt->close();
    }
    $conn->close();
    
    for($i = 0; $i < $days_in_month-1; $i++){
        echo $count_per_day[$i] . ",";
    }
    echo end($count_per_day);
}
// Month was not sent, meaning user has requested for year data
else {
    $year = sanitize_input($_POST['year']);
    $sql_year = "%{$year}%";
    $count_per_month = array_fill(0,12,0);
    
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $displayText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT left(substring(order_date, locate(':',order_date)+1, 99), locate(':', substring(order_date, locate(':',order_date)+1, 99))-1) AS month, sum(grand_total) AS sum FROM orders WHERE order_date LIKE ? group by month;");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $sql_year);
        // execute the query statement:
        if (!$stmt->execute()) {
            $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result = $stmt->get_result();
        $displayText = "Retrieved " . $result->num_rows . " rows.";

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            for ($i = 0; $i < 12; $i++){
                if($row['month'] == $month_names[$i]){
                    $count_per_month[$i] = $row['sum'];
                    $row = mysqli_fetch_assoc($result);
                }
            }
        } else {
            $displayText = "Retrieved 0 rows.";
        }
        $stmt->close();
    }
    $conn->close();
    
    for($i = 0; $i < 12-1; $i++){
        echo $count_per_month[$i] . ",";
    }
    echo end($count_per_month);
}
?>
