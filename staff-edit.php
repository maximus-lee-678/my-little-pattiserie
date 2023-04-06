<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=staff-overview.php");
    exit;
}
$staffID = $_POST["staff-id"];

// Create database connection.
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'],
        $config['password'], $config['dbname']);
// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    // Select staff based on staff_id
    $stmt = $conn->prepare("SELECT * FROM staff_details WHERE staffID = ?");
    // Bind & execute the query statement:
    $stmt->bind_param("s", $staffID);
    // execute the query statement:
    if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
    } else {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $fname = $row['fname'];
            $lname = $row['lname'];
            $role = $row['role'];
            $created_date = $row['created_date'];
        } else {
            $errorMsg = "Staff not found!";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

if (!$success) {
    echo $errorMsg;
}
?>

<body>
    <main class="container">
        <div style="float:right;">
            <a class="bi bi-x-square" style="font-size:36px;" id="close-view"></a>
        </div><br>
        <form action="staff-edit-process.php" id="staff-edit" method="post">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input class="form-control" disabled="disabled"  maxlength="45" 
                       required name="fname" placeholder="Enter First Name" value="<?php echo $fname; ?>">
            </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input class="form-control" disabled="disabled" maxlength="45" 
                       required name="lname" placeholder="Enter Last Name" value="<?php echo $lname; ?>">
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                        <select class="form-control" name="role" disabled="disabled" required>
                            <option selected readonly value="<?php echo $role; ?>"><?php echo $role; ?></option>
                            <option value="Staff">Staff</option>
                            <option value="Manager">Manager</option>
                        </select>
                </div>
            <span style="white-space:normal;">
                <div class="form-group edit-features" style="display:inline-block;" hidden>
                    <button class="btn btn-success" id="submit-button" type="submit" name="submit" value="<?php echo $staffID; ?>">Submit</button>
                </div>
                <div class="form-group edit-features" style="display:inline-block;" hidden>
                    <a class="btn btn-secondary" id="discard-button" style="color:white;">Discard Changes</a>
                </div>
                <div class="form-group edit-features" style="display:inline-block;" hidden>
                    <button class="btn btn-danger" id="delete-button" type="delete" name="delete" value="<?php echo $staffID; ?>">Delete</button>
                </div>
            </span>
        </form>
        <div class="form-group">
            <button class="btn btn-secondary" id="edit-button" type="edit" name="edit">Edit</button>
        </div>
        <div class="form-group">
            <p>Created: <?php echo $created_date; ?></p>
        </div>
    </main>
</body>