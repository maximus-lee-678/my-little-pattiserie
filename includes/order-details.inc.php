<?php
 eror_reporting(E_ALL);
 ini_set("display-errors", "on");
 
 if(isset($_POST["cart_id"])) {

  require_once "db.inc.php";
  require_once "functions.inc.php";
  
  $cart_id = $_POST["cart_id"];
  $sql = "SELECT cart_id, my_little_patisserie.products.products_id, my_little_patisserie.products.item_name, my_little_patisserie.cart_items.quantity, my_little_patisserie.products.price, my_little_patisserie.products.image_path, my_little_patisserie.products.image_alt_text FROM my_little_patisserie.cart_items INNER JOIN my_little_patisserie.products ON my_little_patisserie.cart_items.products_id = my_little_patisserie.products.products_id WHERE cart_id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../profile.php?error=stmtfailed"); 
  exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $cart_id);
    mysqli_stmt_execute($stmt);
    $cart_result = mysqli_stmt_get_result($stmt);  
    
    echo $stmt;
//    echo $cart_result;
//    echo $cart_id;
  } 
  
 } else {
  header("location: ../index.php");
  exit();
}
  
 ?>