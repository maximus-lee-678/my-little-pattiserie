<?php
  session_start();
  if(isset($_POST["submit"])) {

    require_once "db.inc.php";
    require_once "functions.inc.php";
    
    $fname = sanitize_input($_POST["fname"]);
    $lname = sanitize_input($_POST["lname"]);
    $tel = sanitize_input($_POST["tel"]);
    $member_id = $_SESSION["member_id"];
    
    if(emptyInputUpdate($fname, $tel) !== false) {
      header("location: ../profile.php?error=emptyinput");
      exit();
    }
    
    updateProfile($conn, $fname, $lname, $tel, $member_id);
     
  }
  else {
    header("location: ../profile.php");
    exit();
  }
  
 ?>