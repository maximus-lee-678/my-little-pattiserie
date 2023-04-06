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
                        <li data-filter=".filter-pastry">Pastry</li>
                        <li data-filter=".filter-cake">Cake</li>
                    </ul>

                    <div class="row portfolio-container">
                        <?php
                        /////start of retrieval
                        $config = parse_ini_file('../../private/db-config.ini');
                        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
                        // Check connection
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
                            // Prepare the statement:
                            $stmt = $conn->prepare("SELECT * FROM products WHERE category = \"Sweets\" AND active = \"YES\"");
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
                                    if($row["sub_category"] == "Pastry"){
                                        $filter = "pastry";
                                    }
                                    else if ($row["sub_category"] == "Cakes"){
                                        $filter = "cake";
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
//                        ?>

                    </div>

                </div>
            </section><!-- End My Portfolio Section -->

        </main><!-- End #main -->
        <br>
    <!-- Footer -->
    <?php include "./includes/footer.inc.php"?>
                        </body>

                        </html>
