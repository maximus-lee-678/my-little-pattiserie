<!-- Head -->
<?php include "./includes/header.inc.php" ?>

<body>
    <!-- Navbar -->
    <?php include "./includes/nav.inc.php" ?>

    <main class="container">
        <!-- Contact Us Section-->
        <section id="confirmationPage" class="confirmationPage my-4">
            <div class="section-title">
                <h2>Confirmation Page</h2>
            </div>
            <?php
            session_start();
            require_once "./includes/db.inc.php";
            require_once "./includes/checkout_function.inc.php";
            $cust_id = $_SESSION["member_id"];
            //echo "CUST:" . $cust_id;
            $orderNumber = $_GET["id"];
            //echo "CUST2:" . $orderNumber;
//            ////-----Start db name retrieve-------
//            $cust_name;
//            $sql = "SELECT fname FROM ICT1004_Project.members WHERE member_id = ?;";
//            $stmt = mysqli_stmt_init($conn);
//            if (!mysqli_stmt_prepare($stmt, $sql)) {
//                header("location: ../register.php?error=nameCheckError");
//                exit();
//            }
//
//            mysqli_stmt_bind_param($stmt, "s", $cust_id);
//            mysqli_stmt_execute($stmt);
//
//            $resultData = mysqli_stmt_get_result($stmt);
//
//            if ($row = mysqli_fetch_assoc($resultData)) {
//                $cust_name = $row["fname"];
//            } else {
//                $result = false;
//                $cust_name = -1;
//            }
//            mysqli_stmt_close($stmt);
            $custName =  $_SESSION["name"];
            ////-----end db name retrieve-------
            ?>
            <div class="card shadow">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <div class="form-group">
                                <h1><strong> WE HAVE RECEIVED YOUR ORDER. </strong></h1>
                                <h3> Thanks for ordering <?php echo $custName; ?><h3>
                                        <h3><strong>Order Number:</strong> <?php echo $orderNumber; ?></h3>
                                        </div>
                                        </div>
                                        </form>
                                        </div>
                                        </div>
                                        </section>


                                        </main>
                                        <!-- Footer -->
                                        <?php include "./includes/footer.inc.php" ?>
                                        </body>
                                        </html>
