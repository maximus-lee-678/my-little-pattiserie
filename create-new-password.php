<!-- Head -->
<?php include "./includes/header.inc.php"?>

  <body>
    <!-- Navbar -->
    <?php include "./includes/nav.inc.php"?>

    <main>
      <!-- Create New Password Form -->
      <section class="login-form my-5">
        <div class="container">
          <div class="row no-gutters">
            <div class="cover-photo col-lg-5">
              <img src="./assets/img/create-new-password.jpg" class="img-fluid" alt="Platter of Cakes">
            </div>
            <div class="col-lg-7 px-5 py-5">

              <?php 
                $selector = $_GET["selector"];
                $validator = $_GET["validator"];

                if(empty($selector) || empty($validator)) {
                  echo "Could not validate your request!";
                } else {
                  if(ctype_xdigit($selector) !== false && ctype_xdigit($validator)) {
                  ?> 

                  <h4>Create your New Password</h4>
                  <p>Enter your new password and confirm that they are similar.</p>
                  <form action="./includes/reset-password.inc.php" method="post">
                    <div class="form-row">
                      <div class="col-lg-10">
                        <input type="hidden" name="selector" value="<?php echo $selector ?>" class="form-control my-3 p-4">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-10">
                        <input type="hidden" name="validator" value="<?php echo $validator ?>" class="form-control my-3 p-4">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-10">
                        <input type="password" name="pwd" required minlength="8" placeholder="Enter a new password" class="form-control my-3 p-4">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-10">
                        <input type="password" name="pwdConfirm" required minlength="8" placeholder="Confirm new password" class="form-control my-3 p-4">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-lg-10">
                        <button type="submit" name="submit" class="btn1 mt-3 mb-5">Reset Password</button>
                      </div>
                    </div>
                  </form>
                  <?php
                  }
                }
              ?>

            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- Footer -->
    <?php include "./includes/footer.inc.php"?>
    
  </body>
</html>