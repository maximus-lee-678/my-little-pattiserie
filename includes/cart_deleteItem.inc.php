<?php

if (isset($_POST["submit"])) {
    session_start();
    $cart_id = $_SESSION["cart_id"];
    $product_id = $_POST["id_to_remove"];


    require_once "db.inc.php";
    require_once "cart.inc.php";

    deleteCartItem($conn, $cart_id, $product_id);
} else {
    header("location: ../index.php"); //redirect to requesting site
    exit();
}
?>