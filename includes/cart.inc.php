<?php
//////-----ADD TO CART -----------SEANNNNN

function addToCart($conn,$cart_id, $product_id, $quantity) {
    $status = "active";
    $sql = "INSERT INTO ICT1004_Project.cart_items (cart_id, products_id, quantity) VALUES (?,?,1);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=addCartItemfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $cart_id, $product_id);

    if(mysqli_stmt_execute($stmt)){
        header("location: ../productDetails.php?id=".$product_id);

    }
    mysqli_stmt_close($stmt);
}

function checkCartItemExist($conn,$cart_id, $product_id) {
    $quantity;
    $sql = "SELECT * FROM ICT1004_Project.cart_items WHERE cart_id = ? AND products_id= ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=cartItemCheckError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $cart_id, $product_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $quantity = $row["quantity"];
    } else {
        $result = false;
        $quantity = -1;
    }
    return $quantity;
    mysqli_stmt_close($stmt);
}

function updateCartItem($conn,$cart_id, $product_id, $quantity) {

    $sql = "UPDATE ICT1004_Project.cart_items SET quantity = ? WHERE cart_id = ? AND products_id= ? ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=cartItemUpdateError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $quantity, $cart_id, $product_id);
    if(mysqli_stmt_execute($stmt)){
        

    }
    mysqli_stmt_close($stmt);
}

////-----------RETRIEVE ALL CART ITEMS
function retrieveCart($conn,$cart_id) {
    $sql = "SELECT cart_id,ICT1004_Project.products.products_id,item_name,ICT1004_Project.cart_items.quantity,price,image_path,image_alt_text FROM ICT1004_Project.cart_items INNER JOIN ICT1004_Project.products ON ICT1004_Project.cart_items.products_id = ICT1004_Project.products.products_id WHERE cart_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=cartItemRetrieveError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $cart_id);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=cartRetrieveItemError");
        exit();
    }

    $resultData = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
       return $row;
    } else {
        echo "ITEM NOT FOUND.";
    }
    mysqli_stmt_close($stmt);
}



////------------Delete cart item
function deleteCartItem($conn, $cart_id, $product_id){
    $sql = "DELETE FROM ICT1004_Project.cart_items WHERE cart_id=? AND products_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=cartItemUpdateError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $cart_id, $product_id);
    if(mysqli_stmt_execute($stmt)){
        header("location: ../shoppingCart.php");

    }
    mysqli_stmt_close($stmt);
}

?>