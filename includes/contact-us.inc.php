<?php
  if(isset($_POST["submit"])) {
      
    require_once "db.inc.php";
    require_once "functions.inc.php";
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $feedback = sanitize_input($_POST["feedback"]);


    if (emptyInputContact($email, $feedback) !== false) {
      header("location: ../contact-us.php?error=emptyinput");
      exit();
    }
    

    if (empty($name)) {
      $custName = "Anonymous";
    } elseif (!empty($name)) {
      $custName = $name;
    }
    

    $subject = "Feedback/Suggestion from " . $custName . " [" . $email . "]";
    $message = $feedback;
    $userEmail = "mylilpatisserie@gmail.com";
    
    require_once("../assets/lib/PHPMailer/PHPMailerAutoload.php");
    sendEmail($subject, $message, $userEmail);
    header("location: ../contact-us.php?error=success");
    exit();
  } else {
    header("location: ../contact-us.php");
    exit();
  }
  
?>


//<?php
//  
//  if(isset($_POST["submit"])) {
//
//    require_once "db.inc.php";
//    require_once "functions.inc.php";
//    
//    $name = sanitize_input($_POST["name"]);
//    $email = sanitize_input($_POST["email"]);
//    $feedback = sanitize_input($_POST["feedback"]);
//
//
//    if (emptyInputLogin($email, $pwd) !== false) {
//      header("location: ../login.php?error=emptyinput");
//      exit();
//    }
//    
//    loginUser($conn, $email, $pwd);
//    
//  } 
//  else {
//    header("location: ../login.php");
//    exit();
//  }
//?>