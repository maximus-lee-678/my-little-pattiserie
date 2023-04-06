<!-- Head -->
<?php include "./includes/header.inc.php" ?>
                            <script>
                                function text(x){
                                    if (x==0){

                                        document.getElementById('ccForm').style.display = "block";
                                        document.getElementById('name').disabled = false;
                                        document.getElementById('cvv').disabled = false;
                                        document.getElementById('card-number').disabled =false;
                                        document.getElementById('card-number-1').disabled = false;
                                        document.getElementById('card-number-2').disabled = false;
                                        document.getElementById('card-number-3').disabled = false;
                                        document.getElementById('card-number').disabled = false;
                                        document.getElementById('start').disabled = false;
                                        document.getElementById('expiry-year').disabled = false;
                                    }
                                    else{
                                        document.getElementById('name').disabled = true;
                                        document.getElementById('cvv').disabled = true;
                                        document.getElementById('card-number').disabled = true;
                                        document.getElementById('card-number-1').disabled = true;
                                        document.getElementById('card-number-2').disabled = true;
                                        document.getElementById('card-number-3').disabled = true;
                                        document.getElementById('card-number').disabled = true;
                                        document.getElementById('start').disabled = true;
                                        document.getElementById('expiry-year').disabled = true;
                                        
                                    
                                        }
                                    
                                    return;
                                }
                            </script>
                          
<body>
    <!-- Navbar -->
    <?php include "./includes/nav.inc.php" ?>

    <main class="container">
        <section id="cartPage" class="cartPage my-4">
            <div class="section-title">
                <h2>Items in your cart</h2>
            </div>
                    <!<!-- check credit card error -->
                    <?php
                    if (isset($_GET["msg"])) {
                        if ($_GET["msg"] == "invalidCardNum") {
                            echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                            echo "Invalid Card Number!</div>";
                        } else if ($_GET["error"] == "wronglogin") {
                            echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                            echo "Invalid login details!</div>";
                        } else if ($_GET["error"] == "invalidExpiry") {
                            echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                            echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                            echo "Invalid login details!</div></div>";
                        }
                    }
                    ?>

                    <?php
                    $totalPrice;
                    //retrieve cart
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
                                          <?php echo $row["item_name"]; ?>
                                        </div>
                                        <div class="product-price">
                                            Price: $<?php echo $row["price"]; ?>
                                        </div>
                                        <div class="product-quantity">
                                           Quantity: <?php echo $row["quantity"]; ?> 
                                        </div>
                                    </div>
                    
                                        <?php
                                        $totalPrice = $totalPrice + ($row["price"] * $row["quantity"]);
                                    }
                                    if ($_POST["redeem"] == "yes") {
                                        if ($mem_ptn <= $totalPrice) {
                                            //redeem everything
                                            $finalPrice = $totalPrice - $mem_ptn;
                                            $points = $finalPrice*0.05;
                                        } else if ($mem_ptn > $totalPrice) {
                                            $finalPrice = $totalPrice;
                                            $points = $mem_ptn - $finalPrice;
                                            $finalPrice = 0;
                                            $gst = 0;
                                        }
                                    } else if (($_POST["redeem"] == "no")) {
                                        $finalPrice = $totalPrice;
                                        $points = $mem_ptn + (($finalPrice - $gst) * 0.05);
                                    }

                                    //$noGst = $totalPrice;
//                                    echo "<h4> GST: $" . round($gst, 2);
//                                    echo "</h4><br>";
                                    ?>
                      <div class="totals">
    <div class="totals-item">
      <label>Total Price</label>
      <div class="totals-value" id="cart-subtotal">
          <h6>
              <?php echo round($finalPrice, 2); 
              $finalPrice = round($finalPrice, 2);?>
          </h6>
      </div>
    </div>
    <div class="totals-item">
      <label>Remaining Points</label>
      <div class="totals-value" id="cart-tax"><?php echo $points;?></div>
    </div>
  </div>
                    <?php
                                } else {
                                    echo "Please add items to your cart first.";
                                   header("location: ./contact-us.php?error=emptyinput");
                                   exit();
                                }
                                $stmt->close();
                            }
                            $conn->close();
                        }
                        ?>
                    </div>
        </section>  
        <form id="checkoutForm" name="checkoutForm" method="post" action="./includes/cart_checkout.inc.php">
            <!-- Hidden values -->
            <input type="hidden" name="grand_total" id="grandTotal" value="<?php echo $finalPrice; ?>"/>
            <input type="hidden" name="points_rewarded" id="points_rewarded" value="<?php echo $points; ?>"/>

            <br class="clear" /> 
            <section id="checkOutPage" class="checkOutPage my-4">
                <div class="section-title">
                    <h2>Checkout</h2>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Payment Mode</label>
                            <div>
                                <input type="radio" id="mode1" name="mode" value= "credit card" onclick="text(0);">
                                <label for="mode1">Credit Card</label><br>
                                <input type="radio" id="mode2" name="mode" value = "cash" onclick="text(1);">
                                <label for="mode2">Cash</label><br>
                            </div>
                            <small id="paymentHelp" class="form-text text-muted">If you choose to pay by cash, your pre-order or takeaway order would only be prepared after payment has been made.</small>

                            <div class="ccForm" id="ccForm">
                                <br>
                                Credit Card
                                <br>
                                <input type="hidden" name="orderId" id="orderId" value="
                                <?php echo $_GET["id"]; ?>"
                                />
                                <label class="ccLabel" id="nameLabel"> Name </label>
                                <br>
                                <input required type="text" name="name" id="name" />
                                <br/> 
                                Card Number
                                <br>
                                <input required type="num" style="width: 40px" id="card-number" name="card-number" maxlength="4"   pattern="^[0-9]*$" title="Field should only contain numbers"/>-
                                <input style="width: 40px" type="num" id="card-number-1" name="card-number-1" maxlength="4" pattern="^[0-9]*$"/>-
                                <input style="width: 40px" type="num" id="card-number-2" name="card-number-2" maxlength="4" pattern="^[0-9]*$"/>-
                                <input style="width: 40px" type="num" id="card-number-3"  name="card-number-3" maxlength="4" pattern="^[0-9]*$"/>
                                <br/>
                                <br>
                                Expiry Date
                                <br>
                                <input type="month" id="start" min="<?php echo date("Y-n");?>">
                                <br/>
                                <br>
                                CVV Number
                                <br>
                                <input type="num" name="cvv" id="cvv" autocomplete="off" maxlength="3" pattern="^[0-9]*$" />
                                <br/> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cars"> Order Type </label>
                            <div>
                                <select name="order_type" id="order_type">
                                    <option value="delivery" class="form-control my-3 p-4" >Delivery</option>
                                    <option value="preorder" class="form-control my-3 p-4">Preorder</option>
                                    <option value="takeaway" class="form-control my-3 p-4">Takeaway</option>
                                    <option value="instore" class="form-control my-3 p-4">In-store</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cust_mobile"> Mobile Number</label>
                            <input required type="num" id="cust_mobile" class="form-control my-3 p-4" name="cust_mobile" maxlength="8" pattern="^[0-9]*$"/>
                        </div>
                        <div class="form-group">
                            <label for="collect_date">Collection Date: </label>
                            <input type="date" class="form-control my-3 p-4" id="collect_date" name="collect_date" min="<?php echo date("Y-m-d");?>"  required style="text-transform: uppercase;" >
                        </div>
                        <div class="form-group">
                            <label for="collect_time"> Collection Time:</label>
                            <input type="time" id="collect_time" name="collect_time" min="09:00" max="22:00" required class="form-control my-3 p-4" >
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks (500char): </label>
                            <textarea id="remarks" name="remarks" rows="4" cols="50" maxlength="500" class="form-control my-3 p-4" placeholder="Enter remarks or customizations to your drinks. (soy, low fat, extra shot)"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit">Submit</button>
                        </div>

                        </form>
                    </div>
                </div>



                <!-- <form>
                  <div class="form-group">
                    <label for="customer-name">Name</label>
                    <input type="text" name="customer-name" class="form-control" placeholder="Name" maxlength="45">
                    <small id="nameHelp" class="form-text text-muted">You can choose to remain anonymous.</small>
                  </div>
                  <div class="form-group">
                    <label for="customer-email">Email Address</label>
                    <input type="email" name="customer-email" class="form-control" placeholder="Email Address" required maxlength="45">
                  </div>
                  <div class="form-group">
                    <label for="customer-email">Feedback & Suggestions</label>
                    <input type="text" name="feedback" class="form-control" placeholder="Max 500 Characters" required maxlength="500">
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form> -->

                <!-- 
                        <div class="row no-gutters">
                          <div class="card" style="width: 100%;">
                            <div class="card-body col-md-12">
                              <form action="./includes/contact-us.inc.php" method="post">
                                <div class="container">
                                  <div class="form-row px-5 col-md-12">
                                    <div class="form-group">
                                      <label for="customer-name">Name: </label>
                                      <input type="text" name="customer-name" placeholder="Name" maxlength="45" class="form-control ">              
                                    </div>
                                  </div>
                                  <div class="form-row px-5 col-md-12">
                                    <div class="form-group">
                                      <label for="customer-email">Email: </label>
                                      <input type="email" name="customer-email" placeholder="Email Address" maxlength="45" required class="form-control">              
                                    </div>
                                  </div>
                                  <div class="form-row px-5 col-md-12">
                                    <div class="form-group">
                                      <label for="feedback">Feedback or Suggesstions: </label>
                                      <input type="text" placeholder="Max 500 Characters" name="feedback" maxlength="500" required class="form-control">              
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>          
                          </div>
                        </div> -->
            </section>


    </main>

</body>
</html>