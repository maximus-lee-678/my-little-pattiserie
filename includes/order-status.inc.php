<?php

if(isset($_POST["order_id"])) {

  require_once "db.inc.php";
  require_once "functions.inc.php";

  $order_id = sanitize_input($_POST["order_id"]);
  $sql = "SELECT * FROM ICT1004_Project.orders WHERE order_id = ?;";
  $stmt = mysqli_stmt_init($conn);  
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../index.php?error=stmtfailed");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
      echo "Order ID not found!";
      exit();
    } else {     
      $orderStatus = $row["status"];
      echo $orderStatus;
    }
  }
} else {
  header("location: ../index.php");
  exit();
}

