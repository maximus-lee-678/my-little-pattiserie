<?php
  session_start();
  if(isset($_POST["submit"])) {
      require_once "db.inc.php";
      require_once "functions.inc.php";     
      
      $pwd = $_POST["pwd"];
      $cfmPwd = $_POST["cfmPwd"];
      $currentPwd = $_POST["currentPwd"];
      $member_id = $_SESSION["member_id"];
              

    if(empty($pwd) || empty($cfmPwd) || empty($currentPwd) ) {
      header("Location: ../profile.php?error=pwdempty");
      exit();
    }
      
    if ($pwd != $cfmPwd) {
      header("Location: ../profile.php?error=pwdnotsame");
      exit();
    }
    
    changePwd($conn, $member_id, $pwd, $cfmPwd, $currentPwd);
     
  } else {
      header("Location: ../profile.php");
  }
