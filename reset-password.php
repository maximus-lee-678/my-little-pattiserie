<!-- Head -->
<?php include "./includes/header.inc.php"?>

  <body>
    <!-- Navbar -->
    <?php include "./includes/nav.inc.php"?>

    <main>
      <!-- Reset Password Form -->
      <section class="login-form my-5">
        <div class="container">
          <div class="row no-gutters">
            <div class="cover-photo col-lg-5">
              <img src="./assets/img/reset-password.jpg" class="img-fluid" alt="Tarts">
            </div>
            <div class="col-lg-7 px-5 py-5">
              <?php
                if(isset($_GET["error"])) {
                  if($_GET["error"] == "stmtfailed") {
                    echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Something went wrong. Try again.</div>";
                  }
                  else if ($_GET["error"] == "success") {
                    echo "<div class='alert alert-success alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "An email has been sent to you! If you did not receive the email, check your junk or spam folder.</div>";
                  }
                }
              ?> 
              <h4>Reset your Password</h4>
              <p>An e-mail will be sent to you with instructions on how to reset your password.</p>
              <form action="./includes/reset-request.inc.php" method="post">
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="email" name="email" required maxlength="45" placeholder="Email Address" class="form-control my-3 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <button type="submit" name="submit" class="btn1 mt-3 mb-5">Receive Email</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- Footer -->
    <?php include "./includes/footer.inc.php"?>
    
  </body>
</html>