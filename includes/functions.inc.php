<?php

///////////////////////////////////////
// Sanitise 
///////////////////////////////////////
function sanitize_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

///////////////////////////////////////
// Register 
///////////////////////////////////////
function emptyInputSignup($fname, $email, $tel, $pwd, $pwdconfirm) {
  if(empty($fname) || empty($email) || empty($tel) || empty($pwd) || empty($pwdconfirm)) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}


function invalidEmail($email) {
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}


function pwdMatch($pwd, $pwdconfirm) {
  if($pwd !== $pwdconfirm) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}


function emailExists($conn, $email) {
  $sql = "SELECT * FROM ICT1004_Project.members WHERE email = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../register.php?error=stmtfailed1");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  }
  else {
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}


function createUser($conn, $fname, $lname, $email, $tel, $pwd) {
  $sql = "INSERT INTO ICT1004_Project.members (fname, lname, email, mobile, pwd) VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../register.php?error=stmtfailed");
    exit();
  }

  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $email, $tel, $hashedPwd);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../login.php?error=success");
  exit();
}


///////////////////////////////////////
// Login 
///////////////////////////////////////
function emptyInputLogin($email, $pwd) {
  if(empty($email) || empty($pwd)) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}


function loginUser($conn, $email, $pwd) {
  $emailExists = emailExists($conn, $email);

  if($emailExists == false) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }

  $pwdHashed = $emailExists["pwd"];
  $checkPwd = password_verify($pwd, $pwdHashed);

  if($checkPwd == false) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }
  else if ($checkPwd == true) {
    session_start();
    $_SESSION["member_id"] = $emailExists["member_id"];
    $_SESSION["email"] = $emailExists["email"];
    //TODO retrieve and check for exsisting open cart
    $existCart = checkCart($conn, $emailExists["member_id"]);

    //TODO create new cart if dont have
    if ($existCart == -1) {
        createEmptyCart($conn, $emailExists["member_id"]);
        // retrieve and set $existCart to new id
        $existCart = checkCart($conn, $emailExists["member_id"]);
    }
    //TODO add cart id to session
    $_SESSION["cart_id"] = $existCart;
    header("location: ../index.php");
    exit();
  }
}

///////////////////////////////////////
// User Cart 
///////////////////////////////////////
function checkCart($conn, $mem_id) {
    $cart_id;
    $sql = "SELECT * FROM ICT1004_Project.cart WHERE cust_id = ? AND status=\"active\";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=cartCheckError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $mem_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $cart_id = $row["cart_id"];
    } else {
        $result = false;
        $cart_id = -1;
    }
    return $cart_id;
    mysqli_stmt_close($stmt);
}

function createEmptyCart($conn, $mem_id) {
    $status = "active";
    $sql = "INSERT INTO ICT1004_Project.cart (cust_id, created_date, status) VALUES (?, date_format(curdate(), '%d %M %Y'), \"active\");";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $mem_id);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //header("location: ../login.php?error=success");
    // exit();
}


///////////////////////////////////////
// Update Profile
///////////////////////////////////////
function emptyInputUpdate($fname, $tel) {
  if(empty($fname) || empty($tel)) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}

function updateProfile($conn, $fname, $lname, $tel, $member_id) {
  $sql = "UPDATE ICT1004_Project.members SET fname = ?, lname = ?, mobile = ? WHERE member_id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../profile.php?error=stmtfailed");
    exit();
  }


  mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $tel, $member_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../profile.php?error=updated");
  exit();
}


///////////////////////////////////////
// Change Password
///////////////////////////////////////
function changePwd($conn, $member_id, $pwd, $cfmPwd, $currentPwd) {
   $sql = "SELECT * FROM ICT1004_Project.members WHERE member_id = ?;";
   $stmt = mysqli_stmt_init($conn);
   if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../profile.php?error=stmtfailed1");
    exit();
  } 
  else {
   mysqli_stmt_bind_param($stmt, "s", $member_id);
   mysqli_stmt_execute($stmt);
   
   $result = mysqli_stmt_get_result($stmt);
   mysqli_stmt_close($stmt);
   $row = mysqli_fetch_assoc($result);
   if(!$row) {
     header("location: ../profile.php?error=stmtfailed2");
     exit();
   } else {     
     $pwdHashed = $row["pwd"];
     $checkPwd = password_verify($currentPwd, $pwdHashed);

     if($checkPwd == false) {
       header("location: ../profile.php?error=incorrectpassword");
       exit();
     }
     else if ($checkPwd == true) {
       $sql = "UPDATE ICT1004_Project.members SET pwd = ? WHERE member_id = ?;";
       $stmt = mysqli_stmt_init($conn);
       if(!mysqli_stmt_prepare($stmt, $sql)) {
         header("location: ../profile.php?error=stmtfailed3");
         exit();
       }
       else {
         $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
         mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $member_id);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_close($stmt);
         header("location: ../profile.php?error=updated");
         exit();
       }
       

     }
     

    }
  }
}


///////////////////////////////////////
// Send Email
///////////////////////////////////////
function sendEmail($subject, $message, $userEmail) {
    $config = parse_ini_file('../../../private/sEmail-config.ini');
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = "465";
    $mail->isHTML();
    $mail->Username = $config['username'];
    $mail->Password = $config['password'];
    $mail->SetFrom( $config['username']);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AddAddress($userEmail);

    $mail->Send();
}

///////////////////////////////////////
// Mailing List 
///////////////////////////////////////
function mlEmailExists($conn, $email) {
  $sql = "SELECT * FROM ICT1004_Project.mailingList WHERE email = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../index.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  }
  else {
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}



///////////////////////////////////////
// Contact Us
///////////////////////////////////////
function emptyInputContact($email, $feedback) {
  if(empty($email) || empty($feedback)) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}


