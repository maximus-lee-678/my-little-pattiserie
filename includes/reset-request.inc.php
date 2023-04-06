<?php
  echo $_POST["submit"];
  if(isset($_POST["submit"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://35.240.192.18/mylittlepatisserie/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;
    
    require_once "db.inc.php";
    require_once "functions.inc.php";

    $userEmail = sanitize_input($_POST["email"]);

    $sql = "DELETE FROM ICT1004_Project.pwdReset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    $error = mysqli_stmt_error($stmt);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../reset-password.php?error=stmtfailed1");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    
    $sql = "INSERT INTO ICT1004_Project.pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../reset-password.php?error=stmtfailed");
      exit();
    } else {
      $hashedToken = password_hash($token, PASSWORD_DEFAULT);

      mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }

    $subject = "Reset your password for My Little Patisserie";

    $message = "<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>";
    $message .= "<p>Here is your password reset link: <br>";
    $message .= "<a href='" . $url . "'>" . $url . "</a></p>";

    require_once("../assets/lib/PHPMailer/PHPMailerAutoload.php");
    sendEmail($subject, $message, $userEmail);

    header("Location: ../reset-password.php?error=success");
    exit();
  }
  else {
    header("location: ../index.php");
    exit();
  }

?>

