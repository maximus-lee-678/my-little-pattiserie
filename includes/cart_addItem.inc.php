<?php

session_start();
if (isset($_POST["submit"])) {
    $product_id = $_POST["id_to_remove"];
    if (!isset($_SESSION["member_id"]) || $_SESSION["member_id"] == "") {
        header("location: ../productDetails.php?id=" . $product_id . "&error=noLogin");
    } else {
        $cart_id = $_SESSION["cart_id"];
        //$product_id = $_SESSION["item_id"];
        //$product_id = 1; //TODO REMOVE!!!!!
        require_once "db.inc.php";
        require_once "cart.inc.php";

        //check if product and cart combi exist in db and retrieve current quantity and id

        $quantity = 1;

        $checkCartItemExist = checkCartItemExist($conn, $cart_id, $product_id); //if none return -1, else return row

        if ($checkCartItemExist == -1) {
            //if no add to cart
            addToCart($conn, $cart_id, $product_id, 1);
        } else {
            //else update quantity
            $checkCartItemExist = $checkCartItemExist + 1;
            updateCartItem($conn, $cart_id, $product_id, $checkCartItemExist);
        }
        header("location: ../productDetails.php?id=" . $product_id."&error=success");
    }
} else {
    header("location: ../index.php"); //redirect to requesting site
    exit();
}
?>