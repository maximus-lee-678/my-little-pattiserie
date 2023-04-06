<?php
  if(isset($_POST["submit"])) {
    
    require_once "db.inc.php";
    require_once "functions.inc.php";

    $email = $_POST["email"];
    
    if(invalidEmail($email) !== false) {
      header("location: ../index.php?error=invalidemail");
      exit();      
    }

    if(mlEmailExists($conn, $email) !== false) {
      header("location: ../index.php?error=alreadysubscribed");
      exit();
    } 

    $sql = "INSERT INTO mailingList (email) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../index.php?error=stmtfailed");
      exit();
    }
    
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    

    $subject = "My Little Patisserie Newsletter";
    $message = "<p>Thank you for subscribing to our mailing list. Stay tuned for more!</p>";

    require_once("../assets/lib/PHPMailer/PHPMailerAutoload.php");
    sendEmail($subject, $message, $email);
    
    header("location: ../index.php?error=subscribed");
    exit();  
  }
  else {
    header("location: ../index.php");
  }

?>