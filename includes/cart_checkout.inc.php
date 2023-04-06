<?php

if (isset($_POST["submit"])) {
    session_start();
    echo("checkpoint1");

    require_once "db.inc.php";
    require_once "checkout_function.inc.php";
    echo("checkpoint2");
    //auto gen parameters
    //$order_id = $_POST['order_id'];
    //$order_date = $_POST['order_date'];
    //$order_time = $_POST['order_time'];
    //session parameters
    $cart_id = $_SESSION["cart_id"];
    $cust_id = $_SESSION["member_id"];
    $cust_email = $_SESSION['email'];
    echo("checkpoint3");
    ////-----Start db name retrieve-------
    $cust_name;
    $sql = "SELECT fname FROM ICT1004_Project.members WHERE member_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=nameCheckError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $cust_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $cust_name = $row["fname"];
        $_SESSION["name"] = $cust_name;
    } else {
        $result = false;
        $cust_name = -1;
    }
    mysqli_stmt_close($stmt);
    ////-----end db name retrieve-------

    echo("checkpoint4");
    //form parameters
    $payment_mode = $_POST['mode'];

    $grand_total = $_POST['grand_total'];

    $cust_mobile = $_POST['cust_mobile'];
    $order_type = $_POST['order_type'];
    $collect_date = $_POST['collect_date'];
    $collect_time = $_POST['collect_time'];

    echo("checkpoint5");
    $remarks = $_POST['remarks'];
    $remarks = filter_var($remarks, FILTER_SANITIZE_STRING); //sanitize remarks text area input
    $points_rewarded = $_POST['points_rewarded'];

    $status = "Pending Payment";

    //check cc before processing order:
    if ($payment_mode === "credit card") {

        $orderId = $_POST["orderId"];
        $expiry = $_POST["expiryDate"];
        echo "check1";
        $creditCardNum = $_POST["card-number"] . $_POST["card-number-1"] . $_POST["card-number-2"] . $_POST["card-number-3"];
        echo $creditCardNum;

        //1. Check the date ----ERROR
        $expires = DateTime::createFromFormat('my', $_POST['expMonth'] . $_POST['expYear']);
        $now = new DateTime();

        if ($expires < $now) {
            //2. Check the pattern
            
            if (check_cc($creditCardNum)) {
                
                //3. Check luhn algo
                if (luhn_check($creditCardNum)) {
                    //valid card no--> can submit
                    //update db table to OrderPlaced
                    //$orderId = "NULL";
                    //header("location: ../confirmationPage.php?msg=creditcardvalid"); //VALIDDDDDDDDD
                } else {
                    header("location: ../checkOutPage.php?msg=invalidCardNum");
                    exit();
                }
            } else {
                header("location: ../checkOutPage.php?msg=invalidCardNum");
                exit();
            }
        } else {
            header("location: ../checkOutPage.php?msg=invalidExpiry");
            exit();
        }

        $status = "Order Placed";
    }




    //process order
    //1. Create in orders table
    $orderId = createOrder($conn, $cust_id, $status, $payment_mode, $grand_total, $cust_name, $cust_email, $cust_mobile, $order_type, $collect_date, $collect_time, $remarks, $points_rewarded, $cart_id);
    //2. Create in order status log
    //statusLog($conn, "--", "Pending Payment", $orderId, "SYSTEM");
    //3. Update cart status to order placed
    inactivateCart($conn, $cart_id);
    //4. Create new cart
    $newCart = createEmptyCart($conn, $cust_id);
    $_SESSION["cart_id"] = $newCart;
    //5. Update user points
    addPoints($conn, $points_rewarded, $cust_id);

    //send email
    $subject = "My Little Patisserie - Order Confirmation";
    $message = "<p>Hi, your order (order#" . $orderId . ") " . " has been placed. Your booking time is: " . $collect_date . " " . $collect_time . ".</p>";

    require_once("../assets/lib/PHPMailer/PHPMailerAutoload.php");
    sendEmail($subject, $message, $cust_email);

    header("location: ../confirmationPage.php?id=" . $orderId);
} else {
    header("location: ../shoppingCart.php");
    exit();
}
?>




