<?php

// Create order in orders table
function createOrder($conn, $cust_id, $status, $payment_mode, $grand_total, $cust_name, $cust_email, $cust_mobile, $order_type, $collect_date, $collect_time, $remarks, $points_rewarded, $cart_id) {
    $sql = "INSERT INTO ICT1004_Project.orders (cust_id, order_date, order_time, status, payment_mode, grand_total, cust_name, cust_email, cust_mobile, order_type, collect_date, collect_time, remarks, points_rewarded, cart_id )  VALUES (?,date_format(curdate(), '%d %M %Y'),TIME_FORMAT(curtime(), '%H:%i:%s'),?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../checkout.php?error=CannotCreateOrder");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssss", $cust_id, $status, $payment_mode, $grand_total, $cust_name, $cust_email, $cust_mobile, $order_type, $collect_date, $collect_time, $remarks, $points_rewarded, $cart_id);

    if (!mysqli_stmt_execute($stmt)) {
        header("location: ../productDetails.php?id=" . $product_id);
    } else {
        $last_id = mysqli_insert_id($conn);
    }
    mysqli_stmt_close($stmt);
    return $last_id;
}

//Log order status change
function statusLog($conn, $status_from, $status_to, $order_id, $changed_by) {

    $sql = "INSERT INTO ICT1004_Project.order_status_log (status_from, status_to, order_id,status_date,status_time,changed_by) VALUES (?,?,?,date_format(curdate(), '%d:%M:%Y'),TIME_FORMAT(curtime(), '%H:%i:%s'),?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=statusLogfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $status_from, $status_to, $order_id, $changed_by);

    if (!mysqli_stmt_execute($stmt)) {
        header("location: ../checkout.php?error=CannotLogStatusChange");
    }
    mysqli_stmt_close($stmt);
}

//Log order status change
function addPoints($conn, $points, $cust_id) {

    $sql = "UPDATE ICT1004_Project.members SET points = points+? where member_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=addPointsfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $points, $cust_id);

    if (!mysqli_stmt_execute($stmt)) {
        header("location: ../checkout.php?error=CannotLogStatusChange");
    }
    mysqli_stmt_close($stmt);
}

function inactivateCart($conn, $cart_id) {
    $sql = "UPDATE ICT1004_Project.cart SET status='Order Placed' WHERE cart_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=DeactivateCartfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $cart_id);

    if (!mysqli_stmt_execute($stmt)) {
        header("location: ../checkout.php?error=cannotChangeCartStatus");
    }
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
    $last_id = mysqli_insert_id($conn);

    mysqli_stmt_close($stmt);
    //header("location: ../login.php?error=success");
    // exit();
    return $last_id;
}

///////////////////////CREDIT CARD///////////////////////////
//Luhn Algorithm for CreditCard Checksum
function luhn_check($number) {

    // Strip any non-digits
    $number = preg_replace('/\D/', '', $number);

    // Set the string length and parity
    $number_length = strlen($number);
    $parity = $number_length % 2;

    // Loop through each digit and do the math
    $total = 0;
    for ($i = 0; $i < $number_length; $i++) {
        $digit = $number[$i];
        // Multiply alternate digits by two
        if ($i % 2 == $parity) {
            $digit *= 2;
            // If the sum is two digits, add them together
            if ($digit > 9) {
                $digit -= 9;
            }
        }
        // Add up all the digits
        $total += $digit;
    }

    // If the total mod 10 equals 0, the number is valid
    return ($total % 10 == 0) ? TRUE : FALSE;
}

//Check Credit Card no regex and return card type
function check_cc($cc) {
    $cards = array(
        "visa" => "(4\d{12}(?:\d{3})?)",
        "amex" => "(3[47]\d{13})",
        "mastercard" => "(5[1-5]\d{14})"
    );
    $names = array("Visa", "American Express", "Mastercard");
    $matches = array();
    $pattern = "#^(?:" . implode("|", $cards) . ")$#";
    $result = preg_match($pattern, str_replace(" ", "", $cc), $matches);

    return ($result > 0) ? $names[sizeof($matches) - 2] : false;
}

//Check credit card expiry
function checkExp($month, $year) {
    $expTS = mktime(0, 0, 0, $month + 1, 1, $year);
    $curTS = time();
    $maxTS = $curTS + (10 * 365 * 24 * 60 * 60);

    if ($expTS > $curTS && $expTS < $maxTS) {
        return true;
    } else {
        return false;
    }
}

function updatePaid($conn, $order_id){
    $sql = "UPDATE ICT1004_Project.orders SET status='Order Placed' WHERE order_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=updateOrderFailed".$order_id);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $order_id);

    if (!mysqli_stmt_execute($stmt)) {
        header("location: ../checkout.php?error=cannotChangeCartStatus");
    }
    mysqli_stmt_close($stmt);
}

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
?>