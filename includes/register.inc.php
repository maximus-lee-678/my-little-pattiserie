<?php
  
  if(isset($_POST["submit"])) {

    require_once "db.inc.php";
    require_once "functions.inc.php";
    $fname = sanitize_input($_POST["fname"]);
    $lname = sanitize_input($_POST["lname"]);
    $email = sanitize_input($_POST["email"]);
    $tel = sanitize_input($_POST["tel"]);
    $pwd = $_POST["pwd"];
    $pwdConfirm = $_POST["pwdConfirm"];


    if(emptyInputSignup($fname, $email, $tel, $pwd, $pwdConfirm) !== false) {
      header("location: ../register.php?error=emptyinput");
      exit();
    }

    if(invalidEmail($email) !== false) {
      header("location: ../register.php?error=invalidemail");
      exit();
    }   
  
    if(pwdMatch($pwd, $pwdConfirm) !== false) {
      header("location: ../register.php?error=passwordsdontmatch");
      exit();
    }  

    if(emailExists($conn, $email) !== false) {
      header("location: ../register.php?error=emailtaken");
      exit();
    }  

    createUser($conn, $fname, $lname, $email, $tel, $pwd);

  }
  else {
    header("location: ../register.php");
    exit();
  }

?>