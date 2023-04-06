<!-- Head -->
<?php include "./includes/header.inc.php"?>

  <body>
    
    <?php include "./includes/nav.inc.php"?>

    <main>
      <!-- Login Form -->
      <section class="login-form my-5">
        <div class="container">
          <div class="row no-gutters">
            <div class="cover-photo col-lg-5">
              <img src="./assets/img/login.jpg" class="img-fluid" alt="Cinammon Rolls">
            </div>
            <div class="col-lg-7 px-5 py-5">
              <?php
                if(isset($_GET["error"])) {
                  if($_GET["error"] == "success") {
                    echo "<div class='alert alert-success alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Your account has been created!</div>";
                  }
                  else if ($_GET["error"] == "wronglogin") {
                    echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Invalid login details!</div>";
                  } 
                  else if ($_GET["error"] == "newpwdempty") {
                    echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Please do not leave any fields blank! Use the link in the email to try again.</div>";
                  }
                  else if ($_GET["error"] == "pwdnotsame") {
                    echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Passwords don't match! Use the link in the email to try again.</div>";
                  }
                  else if ($_GET["error"] == "stmtfailed") {
                    echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Something went wrong. Try again.</div>";
                  }
                  else if ($_GET["error"] == "reqfailed") {
                    echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Please re-submit your reset request.</div>";
                  }
                  else if ($_GET["error"] == "passwordupdated") {
                    echo "<div class='alert alert-success alert-dismissible col-lg-10'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Your password has been updated!</div>";
                  }
                }
              ?> 
              <h4>Login</h4>
              <form action="./includes/login.inc.php" method="post">
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="email" name="email" required maxlength="45" placeholder="Email Address" class="form-control my-3 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="password" name="pwd" required placeholder="Password" class="form-control my-3 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <button type="submit" name="submit" class="btn1 mt-3 mb-5">Login</button>
                  </div>
                </div>
                <a href="./reset-password.php">Forgot Password</a>
                <p>Don't have an account? <a href="./register.php">Register here</a></p>
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