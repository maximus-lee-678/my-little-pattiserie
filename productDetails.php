<!-- Head -->
<?php include "./includes/header.inc.php" ?>
<body>
    <?php include "./includes/nav.inc.php" ?>
<body>
    <?php include "nav.inc.php" ?> 
    <main id="main">
        <?php
        if ($_GET["error"] == "noLogin") {
            echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
            //echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
            echo "Please <a href='./login.php'>login</a> or <a href='./register.php'>register</a> to add to cart.</div>";
        }
        ?>
        <!-- ======= Portfolio Details Section ======= -->
        <?php
        $imgPath = "assets/img/portfolio/krapfen.jpg";
        $title = "Krapfen";
        $price = "1.30";
        $desc = "a sweet thing originally from Austria and Germany";
        $altText = "Krapfen";
        $id = $_GET["id"];

        //$_SESSION["item_id"] = (int) $id;
        ///------SEANNNNNNN
        //TODO get member cart
        $cart_id = $_SESSION["cart_id"];

        //-------SEANNN END
        retrieveProduct($id);

        echo "<section id=\"portfolio-details\" class=\"portfolio-details\">
      <div class=\"container\">
        <div class=\"row gy-4\">
          <div class=\"col-lg-6\">
            <div class=\"portfolio-details-slider swiper\">
              <div class=\"swiper-wrapper align-items-center\">

                <div class=\"swiper-slide\">
                  <img src=\"" . $imgPath;
        echo "\" alt=" . $altText;
        echo ">
                </div>
              </div>
              <div class=\"swiper-pagination\"></div>
            </div>
          </div>

          <div class=\"col-lg-4\">
            <div class=\"portfolio-info\">
              <h3>" . $title;
        echo"</h3>";
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "success") {
                echo "<div class='alert alert-success alert-dismissible col-lg-10'>";
                echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                echo "Added to cart!</div>";
            }
        }
        echo"<ul>
                <li><strong> Price: $</>" . $price;
        echo" </li>
                <li>" . $desc;
        echo"</li>
              </ul>
            </div>
            <div class=\"portfolio-description\">
                <div class=\"card text-center\"\">";
        ?>
        <form class="add-to-cart" action="./includes/cart_addItem.inc.php" method="post">
            <input type="hidden" value="<?php echo $id ?>" name ="id_to_remove"/>

            <button class = "btn-primary" name="submit" type="submit" style="width: 100%;">Add To Cart</button>

        </form>
    </div>
</div>

</div>

</div>
</section>
<?php

//////METHOD TO RETRIEVE DETAILS
function retrieveProduct($id) {
    global $imgPath, $title, $price, $desc, $altText, $subCategory;

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM products WHERE products_id = ?");
        //Bind id
        $stmt->bind_param("s", $id);
        // execute the query statement:
        $stmt->execute();
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $imgPath = $row["image_path"];
            $title = $row["item_name"];
            $price = $row["price"];
            $desc = $row["summary"];
            $altText = $row["image_alt_text"];
            $subcategory = $row["sub_category"];
        } else {
            echo "ITEM NOT FOUND.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!-- End Portfolio Details Section -->
</main><!-- End #main -->
<br>
<!-- Footer -->
<?php include "./includes/footer.inc.php" ?>
</body>

</html>


