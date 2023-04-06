<!-- Head -->
<?php include "./includes/header.inc.php" ?>

<body>

    <?php include "./includes/nav.inc.php" ?>

    <main>
        <!-- Shopping Cart -->
        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">
                <div class="section-title">
                    <h2>Shopping Cart</h2>
                    <?php
                    if($_GET["status"] == "updated") {
                    echo "<div class='alert alert-success alert-dismissible col-lg-15'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Your cart has been updated!</div>";
                    }
                    ?>
                </div>
                <div class="shopping-cart">

                    <div class="column-labels">
                        <br>
                        <label class="product-image">Image</label>
                        <label class="product-details">Product</label>
                        <label class="product-price">Price</label>
                        <label class="product-quantity">Quantity</label>
                        <label class="product-line-price">Update</label>
                    </div>
                    <?php
                    $totalPrice;

                    //retrieve user points
                    if (isset($_SESSION["cart_id"])) {
                        $cartId = $_SESSION["cart_id"];
                        require_once "./includes/db.inc.php";
                        require_once "./includes/cart.inc.php";
                        $member_id = $_SESSION["member_id"];

                        /////start of retrieval ptns
                        $config = parse_ini_file('../../private/db-config.ini');
                        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
                        // Check connection
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
                            // Prepare the statement:
                            $stmt = $conn->prepare("SELECT points FROM ICT1004_Project.members WHERE member_id=?;");
                            //Bind id
                            //$stmt->bind_param("s", $id);
                            // execute the query statement:
                            $stmt->bind_param("s", $member_id);
                            if (!$stmt->execute()) {
                                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                                $success = false;
                            }

                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $mem_ptn = $row["points"];
                            } else {
                                echo "ITEM NOT FOUND.";
                            }
                            $stmt->close();
                        }
                        $conn->close();

                        //retrieve cart
                        $cartId = $_SESSION["cart_id"];
                        require_once "./includes/db.inc.php";
                        require_once "./includes/cart.inc.php";

                        /////start of retrieval
                        $config = parse_ini_file('../../private/db-config.ini');
                        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
                        // Check connection
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
                            // Prepare the statement:
                            $stmt = $conn->prepare("SELECT cart_id,ICT1004_Project.products.products_id,item_name,ICT1004_Project.cart_items.quantity,price,image_path,image_alt_text FROM ICT1004_Project.cart_items INNER JOIN ICT1004_Project.products ON ICT1004_Project.cart_items.products_id = ICT1004_Project.products.products_id WHERE cart_id = ?;");
                            //Bind id
                            //$stmt->bind_param("s", $id);
                            // execute the query statement:
                            $stmt->bind_param("s", $cartId);
                            if (!$stmt->execute()) {
                                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                                $success = false;
                            }

                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                //display found items
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="product">
                                        <div class="product-image">
                                            <img src="<?php echo $row["image_path"]; ?>" class="img-fluid" alt="<?php echo $row["image_alt_text"]; ?>">
                                        </div>
                                        <div class="product-details">
                                            <div class="product-title"><?php echo $row["item_name"]; ?></div>
                                        </div>
                                        <div class="product-price">$<?php echo $row["price"]; ?></div>
                                        <div class="product-quantity">
                <?php echo $row["quantity"]; ?>
                                        </div>
                                        <div class ="product-line-price">
                                            <form action="./includes/cart_changeQuantity.inc.php" method="post">
                                                <select name="newQ" id="newQ">
                                                    <?php
                                                    for ($i = 0; $i < 21; $i++) {
                                                        if ($row["quantity"] == $i) {
                                                            echo "<option selected=\"selected\" value=\"" . $i . "\">" . $i . "</option>";
                                                        } else {
                                                            echo "<option value=\"" . $i . "\">" . $i . "</option>";
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                                <input type="hidden" value="<?php echo $row["products_id"]; ?> " name ="id_to_remove"/>
                                                <input type="hidden" value="<?php echo $row["quantity"]; ?>" name ="oldQuan"/>
                                                <button name="submit" type="submit"> Update </button>
                                            </form>
                                        </div>
                                        <br>
                                    </div>


                                    <?php
                                    $totalPrice = $totalPrice + ($row["price"] * $row["quantity"]);
                                }
                                $gst = $totalPrice;
                                $totalPrice = $totalPrice * 1.07;
//                            echo "Gst: $" . round($gst, 2);
//                            echo "<br>"
                                ?>

                                <div class="totals">
                                    <div class="totals-item">
                                        <label>Total Price</label>
                                        <div class="totals-value" id="cart-subtotal"><?php
                                            echo round($totalPrice, 2);
                                            $points = round(($totalPrice * 0.05), 2);
                                            ?></div>
                                    </div>
                                    <div class="totals-item">
                                        <label>Points for Redemption</label>
                                        <div class="totals-value" id="cart-tax"><?php echo $mem_ptn; ?></div>
                                    </div>
                                    <form action="./checkOutPage.php" method="post">
                                        <div class="totals-item">
                                            <label>Do you want to redeem?   </label>
                                            <td><input style="margin-left: 130px" required type="radio" id="redeem" value = "yes" name="redeem"> Yes</td>
                                            <td><input style="margin-left:10px" required type="radio" id="redeem" value="no" name="redeem"> No</td>  
                                        </div>
                                        <button type="submit" name="submit" class="checkout">Checkout</button>
                                </div>

                            </div>
                        </div> <!-- end of container div -->
                        <?php
                    } else {
                        echo "ITEM NOT FOUND.";
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>

            </div>
        </section><!-- End About Section -->
        <br>

    </main>
    <br>
    <!-- Footer -->
<?php include "./includes/footer.inc.php" ?>
</body>
</html>