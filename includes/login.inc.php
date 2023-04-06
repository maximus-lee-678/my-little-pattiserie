<?php
  
  if(isset($_POST["submit"])) {

    require_once "db.inc.php";
    require_once "functions.inc.php";
    
    $email = sanitize_input($_POST["email"]);
    $pwd = $_POST["pwd"];


    if (emptyInputLogin($email, $pwd) !== false) {
      header("location: ../login.php?error=emptyinput");
      exit();
    }
    
    loginUser($conn, $email, $pwd);
    
  } 
  else {
    header("location: ../login.php");
    exit();
  }
?>