<?php

if (isset($_POST["submit"])) {
    session_start();
    $cart_id = $_SESSION["cart_id"];
    $product_id = $_POST["id_to_remove"];
    $oldQ = $_POST["oldQuan"];
    $newQ = $_POST["newQ"];
    $action = $_POST["action"]; //0 minus 1 add

    require_once "db.inc.php";
    require_once "cart.inc.php";

    //$checkCartItemExist = checkCartItemExist($conn, $cart_id, $product_id); //if none return -1, else return row
    if ($quantity == 0) {
        deleteCartItem($conn, $cart_id, $product_id);
    } else {
        updateCartItem($conn, $cart_id, $product_id, $newQ);
    }

    header("location: ../shoppingCart.php?id=" . $product_id . "&status=updated");
} else {
    header("location: ../index.php"); //redirect to requesting site
    exit();
}
?>