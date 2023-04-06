<!-- Head -->
<?php include "./includes/header.inc.php"?>

  <body>
    <!-- Navbar -->
    <?php include "./includes/nav.inc.php"?>

    <main class="container">
      <!-- Contact Us Section-->
      <section id="contact-us" class="contact-us my-4">
        <div class="section-title">
          <h2>Contact Us</h2>
          <?php
                if(isset($_GET["error"])) {
                  if($_GET["error"] == "success") {
                    echo "<div class='alert alert-success alert-dismissible col-lg-30'>";
                    echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
                    echo "Thanks for getting in touch!</div>";
                }}?>
        </div>

        <div class="card shadow">
          <div class="card-body">
            <form action="./includes/contact-us.inc.php" method="post">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" maxlength="45">
                <small id="nameHelp" class="form-text text-muted">You may choose to remain anonymous.</small>
              </div>
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Email Address" required maxlength="45">
              </div>
              <div class="form-group">
                <label for="feedback">Feedback & Suggestions</label>
                <textarea type="text" name="feedback" class="form-control" placeholder="Max 1000 Characters" required maxlength="1000" rows="10"></textarea>
              </div>
              <div class="form-group text-right">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>

      </section>
      
      <!-- FAQ Section -->
      <section id="frequently-asked-questions" class="frequently-asked-questions my-4">
        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
        </div>
          <div id="accordion">
            <div class="card">
              <div class="card-header text-center" id="headingA">
                <h5 class="mb-0">
                  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseA" aria-expanded="true" aria-controls="collapseA">
                    What payment modes are accepted here?
                  </button>
                </h5>
              </div>
              <div id="collapseA" class="collapse" aria-labelledby="headingA" data-parent="#accordion">
                <div class="card-body">
                  <p class="text-center">We accept both cash and credit/debit card payment. For credit and debit, Visa, MasterCard and AMEX are welcomed here!</p>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header text-center" id="headingB">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseB" aria-expanded="false" aria-controls="collapseB">
                    What perks do I get as a member?
                  </button>
                </h5>
              </div>
              <div id="collapseB" class="collapse" aria-labelledby="headingB" data-parent="#accordion">
                <div class="card-body">
                 <p class="text-center">5% rebates on every purchase! Every $10 spent entitles you to $0.50 credit balance in your account.</p>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header text-center" id="headingC">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseC" aria-expanded="false" aria-controls="collapseC">
                    Will my pre-orders be processed if I choose to pay by cash?
                  </button>
                </h5>
              </div>
              <div id="collapseC" class="collapse" aria-labelledby="headingC" data-parent="#accordion">
                <div class="card-body">
                  <p class="text-center">Nope! To prevent any food wastage, we will only prepare orders once payment has been received in full. We seek your kind understanding!</p>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header text-center" id="headingD">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseD" aria-expanded="false" aria-controls="collapseD">
                    Do you offer island-wide delivery or delivery of any sorts?
                  </button>
                </h5>
              </div>
              <div id="collapseD" class="collapse" aria-labelledby="headingD" data-parent="#accordion">
                <div class="card-body">
                  <p class="text-center">Unfortunately not, but we will be working on that soon, so stay tuned!</p>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header text-center" id="headingE">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseE" aria-expanded="false" aria-controls="collapseE">
                    I can't remember my order number!
                  </button>
                </h5>
              </div>
              <div id="collapseE" class="collapse" aria-labelledby="headingE" data-parent="#accordion">
                <div class="card-body">
                  <p class="text-center">Don't worry! Your order number has been sent to your email.</p>
                </div>
              </div>
            </div>
          </div>
      </section>
          
    </main>
    
    <!-- Footer -->
    <?php include "./includes/footer.inc.php"?>
    
  </body>
</html>