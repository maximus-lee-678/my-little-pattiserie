<!-- Head -->
<?php include "./includes/header.inc.php"?>

  <body>
    <!-- Navbar -->
    <?php include "./includes/nav.inc.php"?>

    <main>
      <!-- Register Form -->
      <section class="register-form my-5">
        <div class="container">
          <div class="row no-gutters">
            <div class="cover-photo col-lg-5">
              <img src="./assets/img/register2.jpg" class="img-fluid" alt="Cinammon Rolls">
            </div>
            <div class="col-lg-7 px-5 py-5">
                <?php
                  if(isset($_GET["error"])) {
                    if($_GET["error"] == "emptyinput") {
                      echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                      echo "Fill in all required fields!</div>";
                    }
                    else if ($_GET["error"] == "invalidemail") {
                      echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                      echo "Choose a valid email address!</div>";
                    }
                    else if ($_GET["error"] == "passwordsdontmatch") {
                      echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                      echo "Passwords don't match!</div>";                      
                    }
                    else if ($_GET["error"] == "emailtaken") {
                      echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                      echo "This email has already been registered!</div>";   
                    }
                    else if ($_GET["error"] == "stmtfailed") {
                      echo "<div class='alert alert-warning alert-dismissible col-lg-10'>";
                      echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                      echo "Something went wrong. Try again.</div>";  
                    }
                  }
                ?>              
              <h4>Create an Account</h4>
              <form action="./includes/register.inc.php" method="post">
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="text" name="fname" required maxlength="45" placeholder="First Name" class="form-control my-2 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="text" name="lname" maxlength="45" placeholder="Last Name" class="form-control my-2 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="email" name="email" required maxlength="45" placeholder="Email Address" class="form-control my-2 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="number" name="tel" required min="60000000" max="99999999" required placeholder="Phone Number" class="form-control my-2 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="password" name="pwd" required minlength="8" maxlength="45" placeholder="Password" class="form-control my-2 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <input type="password" name="pwdConfirm" required minlength="8" maxlength="45" placeholder="Confirm Password" class="form-control my-2 p-4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-lg-10">
                    <button type="submit" name="submit" class="btn1 mt-3 mb-5">Register</button>
                  </div>
                </div>
                <p>Already have an account? <a href="./login.php">Login here</a></p>
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

