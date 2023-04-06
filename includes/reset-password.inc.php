<?php

  if(isset($_POST["submit"])) {
    
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $pwd = $_POST["pwd"];
    $pwdConfirm = $_POST["pwdConfirm"];

    if(empty($pwd) || empty($pwdConfirm)) {
      header("Location: ../login.php?error=newpwdempty");
      exit();
    } else if ($pwd != $pwdConfirm) {
      header("Location: ../login.php?error=pwdnotsame");
      exit();
    }

    $currentDate = date("U");

    require_once "db.inc.php";

    $sql = "SELECT * FROM ICT1004_Project.pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../login.php?error=stmtfailed");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      if(!$row = mysqli_fetch_assoc($result)) {
        header("location: ../login.php?error=reqfailed");
        exit();
      } else {

        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

        if($tokenCheck == false) {
          header("location: ../login.php?error=reqfailed");
          exit();
        } elseif($tokenCheck == true) {

          $tokenEmail = $row["pwdResetEmail"];

          $sql = "SELECT * FROM ICT1004_Project.members WHERE email=?;";
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../login.php?error=stmtfailed");
            exit();
          } else {

            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)) {
              header("location: ../login.php?error=stmtfailed");
              exit();
            } else {

              $sql = "UPDATE ICT1004_Project.members SET pwd=? WHERE email=?;";
              $stmt = mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../login.php?error=stmtfailed");
                exit();
              } else {

                $newPwdHash = password_hash($pwd, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                mysqli_stmt_execute($stmt);

                $sql = "DELETE FROM ICT1004_Project.pwdReset WHERE pwdResetEmail=?;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                  header("location: ../login.php?error=stmtfailed");
                  exit();
                } else {
                  mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                  mysqli_stmt_execute($stmt);
                  header("Location: ../login.php?error=passwordupdated");
                }
              }
              }
            }         
          }
        }
      } 
    

  } else {
    header("Location: ../index.php");
  }