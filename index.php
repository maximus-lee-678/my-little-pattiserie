<!-- Head -->
<?php include "./includes/header.inc.php"?>

  <body>
    <!-- Navbar -->
    <?php include "./includes/nav.inc.php"?>


    <!-- Hero Carousel -->
    <div id="hero-carousel" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#hero-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#hero-carousel" data-slide-to="1"></li>
        <li data-target="#hero-carousel" data-slide-to="2"></li>
      </ol>

      <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active" data-interval="3000">
          <div class='overlay-image' style="background-image: url('./assets/img/sweet-slide.jpg')"></div>
          <div class='carousel-caption'>
            <h1>Satisfy your guilty pleasures</h1>
            <p>My Little Patisserie</p>      
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" data-interval="3000">
          <div class='overlay-image' style="background-image: url('./assets/img/beverage-slide.jpg')"></div>
          <div class='carousel-caption'>
            <h1>Grab a Cup of Joe with us</h1>
            <p>My Little Patisserie</p>
          </div>       
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item" data-interval="3000">
          <div class='overlay-image' style="background-image: url('./assets/img/cafe-slide.jpg')"></div>
          <div class='carousel-caption'>
            <h1>The perfect place for a catch-up</h1>
            <p>My Little Patisserie</p>
          </div>       
        </div>
      </div>

      <!-- Next/Prev Buttons -->
      <a class="carousel-control-prev" href="#hero-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#hero-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>


    <main class="container">
      <!-- Find Out More Section -->
      <section class="find-out-more">
        <div class="section-title">
          <h2>Find Out More</h2>
        </div>

          
        <!-- Order Status Modal -->
        <div class="modal fade" id="orderStatus" tabindex="-1" role="dialog" aria-labelledby="checkOrderStatus" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="checkOrderStatus">Check your Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                  <div class="form-group">
                    <label>Order ID: </label>
                    <input type="text" class="form-control" id="order_id">

                    <div id="display-order-status"></div> <!--align-middle center-block-->

                  </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="check-button">Check</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
              </div>
            </div>
          </div>
        </div>
                  
        <div class="row">

          <div class="col-lg-4 mb-3 align-items-stretch">
            <div class="card shadow text-center">
              <figure class="card-figure">
                <a href="./sweetPage.php"><img class="card-img-top" src="./assets/img/card1.jpg" alt="Pastry"></a>
              </figure>
              <div class="card-body">
                <a href="./sweetPage.php"><h5>Our Menu</h5></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-3 align-items-stretch">
            <div class="card shadow text-center">
              <figure class="card-figure">
                <a href="./aboutPage.php"><img class="card-img-top" src="./assets/img/card2.jpg" alt="Crossiant"></a>
              </figure>
              <div class="card-body">
                <a href="./aboutPage.php"><h5>Our Story</h5></a>
              </div>
            </div>
          </div>        
            
          <div class="col-lg-4 mb-3 align-items-stretch">
            <div class="card shadow text-center">
              <figure class="card-figure">
                <a href="#" data-toggle="modal" data-target="#orderStatus"><img class="card-img-top" src="./assets/img/card3.jpg" alt="Waiting Status"></a>
              </figure>
              <div class="card-body">
                <a href="#" data-toggle="modal" data-target="#orderStatus"><h5>Order Status</h5></a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Locate Us Section -->
      <section class="locate">
        <div class="section-title">
          <h2>Locate Us</h2>
        </div>

        <div class="row">
          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>1D Yong Siak Street, Tiong Bahru, S168641</p>
              </div>

              <div class="hours">
                <i class="bi bi-clock"></i>
                <h4>Operating Hours:</h4>
                <p>Mon - Fri: 9AM - 10PM<br>Sat, Sun & PH: 8.30AM - 10PM</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>mylilpatisserie@gmail.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+65 8234 2314</p>
              </div>
            </div>
          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <div class="info">
              <iframe width="100%" height="390px" style="border: 0" loading="lazy" allowfullscreen
                src="https://www.google.com/maps/embed/v1/place?q=1D%20Yong%20Siak%20Street%2C%20Singapore&key=AIzaSyB0HWowB8yZK96Cdb4S-iWE5r2oJ0IcT5U"></iframe>
            </div>
          </div>
        </div>  
      </section>

    </main>

    <!-- Newsletter Section -->
    <section id="newsletter" class="newsletter">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-lg-6">
                  <h3>Join our mailing list!</h3>
                  <p>Sign up to receive the latest updates on new products, promotions, seasonal items, and more!</p>
              </div>
          </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="./includes/newsletter.inc.php" method="post">
                    <input type="email" name="email" required placeholder="Enter your Email"><input type="submit" name="submit" value="Subscribe">
                </form>
            </div>
        </div>
      </div>
    </section>
    

    <!-- Footer -->
    <?php include "./includes/footer.inc.php"?>
    
  </body>
</html>



<!-- 
    <iframe width="100%" height="450" style="border:0" loading="lazy" allowfullscreen
    src="https://www.google.com/maps/embed/v1/place?q=110%20Westwood%20Crescent%2C%20Singapore&key=AIzaSyB0HWowB8yZK96Cdb4S-iWE5r2oJ0IcT5U"></iframe> -->