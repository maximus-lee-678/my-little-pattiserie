<?php
session_start();

if ($_SESSION['role'] != "Manager") {
    header("refresh: 0; url=admin-login.php");
    exit;
}
?>

<main class="container">
    <div style="float:right;">
        <a class="bi bi-x-square" style="font-size:36px;" id="close-view"></a>
    </div><br>
    <h1>Staff Creation</h1>
    <form action="create-new-staff-process.php" id="staff-create" onsubmit="return confirm('Are you sure?');" method="post">
        <div class="form-group">
            <label for="staffID">Staff ID:</label>
            <input class="form-control" id="staffID"
                   required name="staffID" placeholder="Enter Staff ID">
        </div>
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input class="form-control" id="fname"  maxlength="45" 
                   name="fname" required placeholder="Enter First Name">
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input class="form-control" id="lname" maxlength="45" 
                   name="lname" required placeholder="Enter Last Name">
        </div>
        <div class="form-group">
            <button class="btn btn-secondary" type="submit" name="submit" href="create-new-staff-process.php">Submit</button>
        </div>
    </form>
</main>
