<!-- Head -->
<?php include "./includes/header.inc.php" ?>

    <body>
    <?php include "./includes/nav.inc.php"?>
        <main id="main">

            <!-- ======= My Portfolio Section ======= -->
            <section id="portfolio" class="portfolio">
                <div class="container">
                    <ul id="portfolio-flters" class="d-flex justify-content-center">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-tea">Tea</li>
                        <li data-filter=".filter-coffee">Coffee</li>
                        <li data-filter=".filter-others">Others</li>
                    </ul>

                    <div class="row portfolio-container">
                        <?php
                        //$filter = "app"; //!!!!!!!!!!!!!!!!!!!!!!!TO CHANGE!!!!!!!!!!!!!!!!!!!!!!!!!!!
                        /////start of retrieval
                        $config = parse_ini_file('../../private/db-config.ini');
                        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
                        // Check connection
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
                            // Prepare the statement:
                            $stmt = $conn->prepare("SELECT * FROM products WHERE category = \"Beverages\" AND active = \"YES\"");
                            //Bind id
                            //$stmt->bind_param("s", $id);
                            // execute the query statement:
                            $stmt->execute();
                            if (!$stmt->execute()) {
                                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                                $success = false;
                            }

                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                //display found items
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if($row["sub_category"] == "Tea"){
                                        $filter = "tea";
                                    }
                                    else if ($row["sub_category"] == "Coffee"){
                                        $filter = "coffee";
                                    }
                                    else if ($row["sub_category"] == "Others"){
                                        $filter = "others";
                                    }
                                    echo "<div class=\"col-lg-4 col-md-6 portfolio-item filter-" . $filter;
                                    echo"\">
            <div class=\"portfolio-img\"><img src=\"" . $row["image_path"];
                                    echo"\" class=\"img-fluid\" alt=\"\"></div>
            <div class=\"portfolio-info\">
              <h4>" . $row["item_name"];
                                    echo"</h4>
              <p>" . $row["category"];
                                    echo"</p>
<a href=\"" . $row["image_path"];
                                    echo"\" data-gallery=\"portfolioGallery\" class=\"portfolio-lightbox preview-link\" title=\"" . $row["item_name"];
                                    echo"\"><i class=\"bi bi-arrows-angle-expand\"></i></a>
              <a href=\"productDetails.php?id=" . $row["products_id"];
                                    echo"\" class=\"details-link\" title=\"More Details\"><i class=\"bi bi-info-lg\"></i></a>
            </div>
          </div>";
                                }
                            } else {
                                echo "ITEM NOT FOUND.";
                            }
                            $stmt->close();
                        }
                        $conn->close();

//                        //forloop
//                        $filter = "app";
//                        $imgPath = "assets/img/portfolio/krapfen.jpg";
//                        $title = "Krapfen";
//                        $id = "1";
//                        $subCategory = "Pastry";
//                        echo "<div class=\"col-lg-4 col-md-6 portfolio-item filter-" . $filter;
//                        echo"\">
//            <div class=\"portfolio-img\"><img src=\"" . $imgPath;
//                        echo"\" class=\"img-fluid\" alt=\"\"></div>
//            <div class=\"portfolio-info\">
//              <h4>" . $title;
//                        echo"</h4>
//              <p>" . $subCategory;
//                        echo"</p>
//              <a href=\"assets/img/portfolio/krapfen.jpg\" data-gallery=\"portfolioGallery\" class=\"portfolio-lightbox preview-link\" title=\"" . $title;
//                        echo"\"><i class=\"bx bx-plus\"></i></a>
//              <a href=\"productDetails.php/id=" . $id;
//                        echo"\" class=\"details-link\" title=\"More Details\"><i class=\"bx bx-link\"></i></a>
//            </div>
//                        </div>";
//                        ?>

                    </div>

                </div>
            </section><!-- End My Portfolio Section -->

        </main><!-- End #main -->
    <!-- Footer -->
    <?php include "./includes/footer.inc.php"?>

                        </body>

                        </html>